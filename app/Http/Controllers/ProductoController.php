<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Subcategoria;
use App\Models\IngresoProducto;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    /**
     * Muestra la lista de productos con filtros.
     */
    public function index(Request $request): View
    {
        $search = $request->get('search');
        $categoriaId = $request->get('categoria_id');
        $subcategoriaId = $request->get('subcategoria_id');
        $orden = $request->get('orden', 'desc');
        $filtroEstado = $request->get('filtro_estado');

        // 1. Estadísticas Globales (Sin filtros aplicados)
        $stats = [
            'total_productos' => Producto::count(),
            'proximos_vencer' => Producto::whereHas('ingresoProducto', function($q) {
                $q->where('fecha_vencimiento_lote', '>', now())
                  ->where('fecha_vencimiento_lote', '<=', now()->addDays(15));
            })->count(),
            'vencidos' => Producto::whereHas('ingresoProducto', function($q) {
                $q->where('fecha_vencimiento_lote', '<', now()->startOfDay());
            })->count(),
            'bajo_stock' => Producto::whereHas('ingresoProducto', function($q) {
                $q->whereColumn('cantidad_restante', '<=', 'stock_minimo')
                  ->where('cantidad_restante', '>', 0);
            })->count(),
            'eliminados' => Producto::onlyTrashed()->count(),
        ];

        $query = Producto::with(['subcategoria.categoria', 'ingresoProducto']);

        // Filtro por Estado (desde las cards)
        if ($filtroEstado) {
            switch ($filtroEstado) {
                case 'proximos_vencer':
                    $query->whereHas('ingresoProducto', function($q) {
                        $q->where('fecha_vencimiento_lote', '>', now())
                          ->where('fecha_vencimiento_lote', '<=', now()->addDays(15));
                    });
                    break;
                case 'vencidos':
                    $query->whereHas('ingresoProducto', function($q) {
                        $q->where('fecha_vencimiento_lote', '<', now()->startOfDay());
                    });
                    break;
                case 'bajo_stock':
                    $query->whereHas('ingresoProducto', function($q) {
                        $q->whereColumn('cantidad_restante', '<=', 'stock_minimo')
                          ->where('cantidad_restante', '>', 0);
                    });
                    break;
            }
        }

        // Filtro por búsqueda (nombre o código)
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

        // Ordenamiento
        $query->orderBy('created_at', $orden);

        $productos = $query->paginate(12)->withQueryString();
        
        // Agregar stock agregado y recomendaciones de precio
        $productos->getCollection()->transform(function($producto) {
            // Sumar stock de todos los lotes con el mismo nombre
            $producto->stock_total = IngresoProducto::where('nombre_producto', $producto->nombre)->sum('cantidad_restante');
            
            // Obtener el último lote para comparar costos
            $ultimoLote = IngresoProducto::where('nombre_producto', $producto->nombre)
                ->orderBy('fecha_ingreso', 'desc')
                ->first();
            
            $producto->recomendar_cambio_precio = false;
            $producto->costo_ultimo_lote = 0;
            
            if ($ultimoLote && $ultimoLote->cantidad_inicial > 0) {
                $costoUnitario = $ultimoLote->costo_total / $ultimoLote->cantidad_inicial;
                $producto->costo_ultimo_lote = $costoUnitario;
                
                // Si el margen es muy bajo o el costo cambió significativamente, recomendar cambio
                // Asumimos un margen ideal del 20% sobre el costo
                if (abs($producto->precio_venta_unitario - ($costoUnitario * 1.2)) > 1) {
                    $producto->recomendar_cambio_precio = true;
                }
            }

            // Encontrar la fecha de vencimiento más próxima de todos sus lotes
            $producto->fecha_vencimiento_proxima = IngresoProducto::where('nombre_producto', $producto->nombre)
                ->where('fecha_vencimiento_lote', '>', now())
                ->min('fecha_vencimiento_lote');
            
            return $producto;
        });
        
        $categorias = Categoria::orderBy('nombre')->get();
        
        // Cargar subcategorías solo si hay una categoría seleccionada
        $subcategorias = $categoriaId 
            ? Subcategoria::where('categoria_id', $categoriaId)->orderBy('nombre')->get() 
            : collect();

        return view('administrador.productos.index', compact(
            'productos', 'categorias', 'subcategorias', 
            'search', 'categoriaId', 'subcategoriaId', 'orden', 'stats', 'filtroEstado'
        ));
    }

    /**
     * Muestra el formulario para crear un producto a partir de un ingreso.
     */
    public function create(Request $request): View
    {
        $ingresoId = $request->get('ingreso_id');
        $ingreso = null;
        
        if ($ingresoId) {
            $ingreso = IngresoProducto::findOrFail($ingresoId);
        }

        $categorias = Categoria::with('subcategorias')->orderBy('nombre')->get();
        
        return view('administrador.productos.create', compact('ingreso', 'categorias'));
    }

    /**
     * Almacena un nuevo producto.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ingreso_producto_id' => 'required|exists:ingresos_productos,id',
            'subcategoria_id' => 'required|exists:subcategorias,id',
            'nombre' => 'required|string|max:255',
            'precio_venta_unitario' => 'required|numeric|min:0',
            'codigo' => 'nullable|string|max:255|unique:productos,codigo',
            'imagen' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        Producto::create($validated);

        return redirect()->route('productos.index')
            ->with('success', 'Producto registrado correctamente.');
    }

    /**
     * Muestra el formulario de edición.
     */
    public function edit(Producto $producto): View
    {
        $categorias = Categoria::with('subcategorias')->orderBy('nombre')->get();
        $ingreso = $producto->ingresoProducto;

        // Buscar el último ingreso para este producto para recomendar precio
        $ultimoIngreso = IngresoProducto::where('nombre_producto', $producto->nombre)
            ->orderBy('fecha_ingreso', 'desc')
            ->first();

        $recomendacion = null;
        if ($ultimoIngreso && $ultimoIngreso->cantidad_inicial > 0) {
            $costoUnitario = $ultimoIngreso->costo_total / $ultimoIngreso->cantidad_inicial;
            // Recomendamos si el margen actual se aleja del 20% sobre el último costo
            if (abs($producto->precio_venta_unitario - ($costoUnitario * 1.2)) > 1) {
                $recomendacion = [
                    'costo' => $costoUnitario,
                    'precio_sugerido' => $costoUnitario * 1.2
                ];
            }
        }

        return view('administrador.productos.edit', compact('producto', 'categorias', 'ingreso', 'ultimoIngreso', 'recomendacion'));
    }

    /**
     * Actualiza el producto.
     */
    public function update(Request $request, Producto $producto): RedirectResponse
    {
        $validated = $request->validate([
            'subcategoria_id' => 'required|exists:subcategorias,id',
            'nombre' => 'required|string|max:255',
            'precio_venta_unitario' => 'required|numeric|min:0',
            'codigo' => 'nullable|string|max:255|unique:productos,codigo,' . $producto->id,
            'imagen' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $validated['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update($validated);

        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Elimina el producto.
     */
    public function destroy(Producto $producto): RedirectResponse
    {
        $producto->delete();

        return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }

    /**
     * Busca proveedores mediante AJAX (mantenido por compatibilidad si es necesario en otras vistas).
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
     * Muestra la vista de empresas/proveedores (mantenido por compatibilidad).
     */
    public function empresas(Request $request): View
    {
        $gestionPor = $request->get('gestion_por', 'empresas');
        $search = $request->get('search');
        $sort = $request->get('sort', 'desc');

        // Variables para la vista de productos (lotes)
        $ingresos = collect();
        $proveedores = collect();

        if ($gestionPor === 'productos') {
            $nombresProductosExistentes = Producto::pluck('nombre')->toArray();
            
            $query = IngresoProducto::whereDoesntHave('productoDetalle')
                ->whereNotIn('nombre_producto', $nombresProductosExistentes)
                ->with('proveedor');

            // Filtros de búsqueda (similares a IngresoProductoController)
            if ($request->filled('nombre_producto')) {
                $query->where('nombre_producto', 'like', '%' . $request->nombre_producto . '%');
            }

            if ($request->filled('codigo_lote')) {
                $query->where('codigo_lote', 'like', '%' . $request->codigo_lote . '%');
            }

            if ($request->filled('filtro_periodo')) {
                $filtro = $request->filtro_periodo;
                $hoy = \Carbon\Carbon::now()->startOfDay();

                switch ($filtro) {
                    case 'esta_semana':
                        $query->whereBetween('fecha_ingreso', [$hoy->clone()->startOfWeek(), $hoy->clone()->endOfWeek()]);
                        break;
                    case 'este_mes':
                        $query->whereBetween('fecha_ingreso', [$hoy->clone()->startOfMonth(), $hoy->clone()->endOfMonth()]);
                        break;
                    case 'hace_2_meses':
                        $query->whereBetween('fecha_ingreso', [$hoy->clone()->subMonths(2)->startOfMonth(), $hoy->clone()->endOfMonth()]);
                        break;
                    case 'hace_3_meses':
                        $query->whereBetween('fecha_ingreso', [$hoy->clone()->subMonths(3)->startOfMonth(), $hoy->clone()->endOfMonth()]);
                        break;
                    case 'hace_1_año':
                        $query->whereBetween('fecha_ingreso', [$hoy->clone()->subYear(), $hoy]);
                        break;
                }
            }

            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $query->whereBetween('fecha_ingreso', [
                    \Carbon\Carbon::createFromFormat('Y-m-d', $request->fecha_inicio)->startOfDay(),
                    \Carbon\Carbon::createFromFormat('Y-m-d', $request->fecha_fin)->endOfDay()
                ]);
            }

            $ingresos = $query->orderBy('fecha_ingreso', $sort)
                ->paginate(12)
                ->withQueryString();
        } else {
            // Lógica actual para gestionar por empresas
            $query = Proveedor::with(['ingresos' => function ($q) {
                $q->orderBy('fecha_ingreso', 'desc')->limit(1);
            }]);

            if ($search) {
                $query->where('nombre_empresa', 'like', '%' . $search . '%');
            }

            $proveedores = $query
                ->orderBy('created_at', $sort)
                ->paginate(10)
                ->withQueryString();
        }

        return view('administrador.productos.empresas', compact(
            'proveedores', 'ingresos', 'search', 'sort', 'gestionPor'
        ));
    }

    /**
     * Muestra la lista de productos eliminados.
     */
    public function eliminados(): View
    {
        $eliminados = Producto::onlyTrashed()->with(['subcategoria.categoria', 'ingresoProducto'])->orderBy('deleted_at', 'desc')->get();
        return view('administrador.productos.eliminados', compact('eliminados'));
    }

    /**
     * Restaura un producto eliminado.
     */
    public function restore($id): RedirectResponse
    {
        $producto = Producto::withTrashed()->findOrFail($id);
        $producto->restore();

        return redirect()->route('productos.eliminados')
            ->with('success', 'Producto restaurado correctamente.');
    }
}
