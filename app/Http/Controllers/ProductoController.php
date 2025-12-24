<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use App\Models\IngresoProducto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductoController extends Controller
{
    /**
     * Muestra una lista de los productos registrados.
     */
    public function index(Request $request): View
    {
        $search = $request->get('search');
        $categoriaId = $request->get('categoria_id');
        $subcategoriaId = $request->get('subcategoria_id');
        $orden = $request->get('orden', 'desc'); // 'desc' (último) o 'asc' (más antiguo)
        
        $query = \App\Models\Producto::with(['subcategoria.categoria', 'ingresoProducto']);

        // Filtro por búsqueda
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', '%' . $search . '%')
                  ->orWhere('codigo', 'like', '%' . $search . '%');
            });
        }

        // Filtro por categoría
        if ($categoriaId) {
            $query->whereHas('subcategoria', function ($q) use ($categoriaId) {
                $q->where('categoria_id', $categoriaId);
            });
        }

        // Filtro por subcategoría
        if ($subcategoriaId) {
            $query->where('subcategoria_id', $subcategoriaId);
        }

        $productos = $query->orderBy('created_at', $orden)->paginate(12);
        
        // Cargar categorías para el select de filtro
        $categorias = Categoria::orderBy('nombre')->get();
        // Si hay categoría seleccionada, cargar subcategorías para mantener el filtro
        $subcategorias = $categoriaId ? \App\Models\Subcategoria::where('categoria_id', $categoriaId)->get() : collect();

        return view('administrador.productos.index', compact('productos', 'search', 'categorias', 'subcategorias', 'categoriaId', 'subcategoriaId', 'orden'));
    }

    /**
     * Busca proveedores mediante AJAX.
     */
    public function buscarAjax(Request $request): JsonResponse
    {
        $search = $request->get('search', '');
        
        if (strlen($search) < 1) {
            return response()->json([]);
        }

        $proveedores = Proveedor::where('nombre_empresa', 'like', '%' . $search . '%')
            ->limit(10)
            ->get(['id', 'nombre_empresa']);

        return response()->json($proveedores);
    }

    /**
     * Muestra la vista de empresas/proveedores con sus productos.
     */
    public function empresas(Request $request): View
    {
        $search = $request->get('search');
        $sort = $request->get('sort', 'desc'); // desc = más reciente, asc = más antiguo

        // Query base
        $query = Proveedor::with(['ingresos' => function ($q) {
            $q->orderBy('fecha_ingreso', 'desc');
        }]);

        // Subquery para ordenar por fecha del último lote
        $query->addSelect(['ultimo_lote_fecha' => IngresoProducto::select('fecha_ingreso')
            ->whereColumn('proveedor_id', 'proveedores.id')
            ->orderBy('fecha_ingreso', 'desc')
            ->limit(1)
        ]);

        if ($search) {
            $query->where('nombre_empresa', 'like', '%' . $search . '%');
        }

        // Ordenar por la fecha del último lote
        $query->orderBy('ultimo_lote_fecha', $sort);

        // Paginación de 10
        $proveedores = $query->paginate(10);

        // Asegurar que mantenemos los parámetros en la paginación
        $proveedores->appends(['search' => $search, 'sort' => $sort]);

        return view('administrador.productos.empresas', compact('proveedores', 'search', 'sort'));
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     */
    public function create(Request $request): View
    {
        $ingresoId = $request->get('ingreso_id');
        $ingreso = null;
        
        if ($ingresoId) {
            $ingreso = IngresoProducto::find($ingresoId);
            
            // Verificar si ya existe un producto para este lote
            if ($ingreso) {
                $productoExistente = \App\Models\Producto::where('ingreso_producto_id', $ingresoId)->first();
                if ($productoExistente) {
                    // Redirigir con mensaje de error si ya existe un producto
                    return redirect()->route('productos.index')
                        ->with('error', 'Ya existe un producto para este lote. No se puede crear uno nuevo.');
                }
            }
        }

        // Obtener todas las categorías
        $categorias = Categoria::with('subcategorias')->get();
        
        // Obtener todas las subcategorías (para compatibilidad con el código existente)
        $subcategorias = \App\Models\Subcategoria::all();

        return view('administrador.productos.create', compact('ingreso', 'subcategorias', 'categorias'));
    }

    /**
     * Almacena un nuevo producto en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación de los datos - todos los campos son obligatorios excepto código
        $validatedData = $request->validate([
            'ingreso_producto_id' => 'required|exists:ingresos_productos,id',
            'categoria_id' => 'required|exists:categorias,id',
            'subcategoria_id' => 'required|exists:subcategorias,id',
            'codigo' => 'nullable|string|unique:productos,codigo',
            'nombre' => 'required|string|max:255',
            'precio_venta_unitario' => 'required|numeric|min:0',
            'imagen' => 'required|image|max:10240', // Max 10MB y ahora es obligatorio
        ], [
            'categoria_id.required' => 'Debe seleccionar una categoría',
            'subcategoria_id.required' => 'Debe seleccionar una subcategoría',
            'imagen.required' => 'Debe subir una imagen para el producto',
            'imagen.image' => 'El archivo debe ser una imagen',
            'imagen.max' => 'La imagen no puede ser mayor a 10MB',
        ]);

        // Verificar si ya existe un producto para este lote (ingreso)
        $productoExistente = \App\Models\Producto::where('ingreso_producto_id', $validatedData['ingreso_producto_id'])->first();

        if ($productoExistente) {
            return back()->withInput()->withErrors(['error' => 'Producto del lote existente. No se puede crear uno nuevo.']);
        }

        try {
            $producto = new \App\Models\Producto();
            $producto->ingreso_producto_id = $validatedData['ingreso_producto_id'];
            $producto->subcategoria_id = $validatedData['subcategoria_id'];
            $producto->codigo = $validatedData['codigo'];
            $producto->nombre = $validatedData['nombre'];
            $producto->precio_venta_unitario = $validatedData['precio_venta_unitario'];

            // Manejo de la subida de imagen
            if ($request->hasFile('imagen')) {
                // Generar un nombre único para la imagen usando timestamp y slug del nombre
                $imageName = time() . '_' . Str::slug($validatedData['nombre']) . '.' . $request->file('imagen')->getClientOriginalExtension();
                
                // Guardar la imagen en storage/app/public/productos
                $path = $request->file('imagen')->storeAs('productos', $imageName, 'public');
                $producto->imagen = $path;
                
                // Crear una versión thumbnail si es necesario
                // Esto es opcional, pero útil para optimizar la carga
                // $thumbnailPath = 'thumbnails/' . $imageName;
                // Image::make($request->file('imagen'))->resize(300, 300)->save(storage_path('app/public/' . $thumbnailPath));
            }

            $producto->save();

            return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');

        } catch (\Exception $e) {
            // Manejo de excepciones
            return back()->withInput()->withErrors(['error' => 'Error al registrar el producto: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Muestra el formulario para editar un producto.
     */
    public function edit(\App\Models\Producto $producto): View
    {
        $ingreso = $producto->ingresoProducto; 
        $categorias = Categoria::with('subcategorias')->get();
        $subcategorias = \App\Models\Subcategoria::all();

        return view('administrador.productos.edit', compact('producto', 'ingreso', 'categorias', 'subcategorias'));
    }

    /**
     * Actualiza un producto en la base de datos.
     */
    public function update(Request $request, \App\Models\Producto $producto)
    {
        // Validación
        $validatedData = $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'subcategoria_id' => 'required|exists:subcategorias,id',
            'codigo' => 'nullable|string|unique:productos,codigo,' . $producto->id,
            'nombre' => 'required|string|max:255',
            'precio_venta_unitario' => 'required|numeric|min:0',
            'imagen' => 'nullable|image|max:10240',
        ], [
            'categoria_id.required' => 'Debe seleccionar una categoría',
            'subcategoria_id.required' => 'Debe seleccionar una subcategoría',
            'imagen.image' => 'El archivo debe ser una imagen',
            'imagen.max' => 'La imagen no puede ser mayor a 10MB',
        ]);

        try {
            $producto->subcategoria_id = $validatedData['subcategoria_id'];
            $producto->codigo = $validatedData['codigo'];
            $producto->nombre = $validatedData['nombre'];
            $producto->precio_venta_unitario = $validatedData['precio_venta_unitario'];

            if ($request->hasFile('imagen')) {
                // Eliminar imagen anterior si existe
                if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
                    Storage::disk('public')->delete($producto->imagen);
                }

                $imageName = time() . '_' . Str::slug($validatedData['nombre']) . '.' . $request->file('imagen')->getClientOriginalExtension();
                $path = $request->file('imagen')->storeAs('productos', $imageName, 'public');
                $producto->imagen = $path;
            }

            $producto->save();

            return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');

        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Error al actualizar el producto: ' . $e->getMessage()]);
        }
    }

    /**
     * Obtiene las subcategorías de una categoría específica mediante AJAX.
     */
    public function getSubcategorias($categoriaId): JsonResponse
    {
        $categoria = Categoria::find($categoriaId);
        
        if (!$categoria) {
            return response()->json([]);
        }
        
        $subcategorias = $categoria->subcategorias()->get(['id', 'nombre']);
        
        return response()->json($subcategorias);
    }
}