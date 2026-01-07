<?php

namespace App\Http\Controllers;

use App\Models\IngresoProducto;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;

class IngresoProductoController extends Controller
{
    /**
     * Muestra la lista de productos (ingresos) de un proveedor específico.
     */
    public function index(Proveedor $proveedor, Request $request): View
    {
        // 0. (Auto-eliminación eliminada a petición del usuario)

        // 1. Calcular Estadísticas Globales (Antes de aplicar filtros)
        // Estas consultas son independientes de los filtros actuales para mantener los contadores fijos
        $stats = [
            'total_productos' => $proveedor->ingresosProductos()->count(),
            'proximos_vencer' => $proveedor->ingresosProductos()
                ->where('fecha_vencimiento_lote', '>', now())
                ->where('fecha_vencimiento_lote', '<=', now()->addDays(15))
                ->count(),
            'vencidos' => $proveedor->ingresosProductos()
                ->where('fecha_vencimiento_lote', '<', now()->startOfDay())
                ->count(),
            'bajo_stock' => $proveedor->ingresosProductos()
                ->whereColumn('cantidad_restante', '<=', 'stock_minimo')
                ->where('cantidad_restante', '>', 0)
                ->count(),
            'eliminados' => $proveedor->ingresosProductos()->onlyTrashed()->count(),
        ];

        // 2. Construir la consulta principal
        $query = $proveedor->ingresosProductos();

        // Filtro por Estado (desde las cards)
        if ($request->filled('filtro_estado')) {
            switch ($request->filtro_estado) {
                case 'proximos_vencer':
                    $query->where('fecha_vencimiento_lote', '>', now())
                          ->where('fecha_vencimiento_lote', '<=', now()->addDays(15));
                    break;
                case 'vencidos':
                    $query->where('fecha_vencimiento_lote', '<', now()->startOfDay());
                    break;
                case 'bajo_stock':
                    $query->whereColumn('cantidad_restante', '<=', 'stock_minimo')
                          ->where('cantidad_restante', '>', 0);
                    break;
                // 'todos' no necesita filtro adicional
            }
        }

        // Filtro por nombre de producto
        if ($request->filled('nombre_producto')) {
            $query->where('nombre_producto', 'like', '%' . $request->nombre_producto . '%');
        }

        // Filtro por Código de Lote
        if ($request->filled('codigo_lote')) {
            $query->where('codigo_lote', 'like', '%' . $request->codigo_lote . '%');
        }

        // Filtro por período predefinido
        if ($request->filled('filtro_periodo')) {
            $filtro = $request->filtro_periodo;
            $hoy = Carbon::now()->startOfDay();

            switch ($filtro) {
                case 'esta_semana':
                    $query->whereBetween('fecha_ingreso', [
                        $hoy->clone()->startOfWeek(),
                        $hoy->clone()->endOfWeek()
                    ]);
                    break;
                case 'este_mes':
                    $query->whereBetween('fecha_ingreso', [
                        $hoy->clone()->startOfMonth(),
                        $hoy->clone()->endOfMonth()
                    ]);
                    break;
                case 'hace_2_meses':
                    $query->whereBetween('fecha_ingreso', [
                        $hoy->clone()->subMonths(2)->startOfMonth(),
                        $hoy->clone()->endOfMonth()
                    ]);
                    break;
                case 'hace_3_meses':
                    $query->whereBetween('fecha_ingreso', [
                        $hoy->clone()->subMonths(3)->startOfMonth(),
                        $hoy->clone()->endOfMonth()
                    ]);
                    break;
                case 'hace_1_año':
                    $query->whereBetween('fecha_ingreso', [
                        $hoy->clone()->subYear(),
                        $hoy
                    ]);
                    break;
            }
        }

        // Filtro por rango de fechas personalizado
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('fecha_ingreso', [
                Carbon::createFromFormat('Y-m-d', $request->fecha_inicio)->startOfDay(),
                Carbon::createFromFormat('Y-m-d', $request->fecha_fin)->endOfDay()
            ]);
        }

        // 3. Obtener los ingresos y agrupar por nombre de producto
        $ingresosBase = $query->with(['productoDetalle.subcategoria.categoria'])
            ->orderBy('fecha_ingreso', 'desc')
            ->get();

        // Agrupamos por nombre de producto para evitar duplicados en la vista principal
        $ingresos = $ingresosBase->groupBy('nombre_producto')->map(function ($group) {
            $latest = $group->first(); // El más reciente por el orderBy arriba
            
            // Buscamos si alguno de los lotes en este grupo ya tiene un producto retail creado
            $productoDetalle = $group->filter(function($lote) {
                return $lote->productoDetalle !== null;
            })->first()?->productoDetalle;

            $costoUltimoLote = $latest->costo_total / $latest->cantidad_inicial;
            $recomendarCambioPrecio = false;
            if ($productoDetalle && abs($productoDetalle->precio_venta_unitario - ($costoUltimoLote * 1.2)) > 1) { // Lógica simple de margen
                $recomendarCambioPrecio = true;
            }

            return (object) [
                'id' => $latest->id,
                'nombre_producto' => $latest->nombre_producto,
                'codigo_lote' => $latest->codigo_lote,
                'unidad_medida' => $latest->unidad_medida,
                'cantidad_inicial' => $group->sum('cantidad_inicial'),
                'cantidad_restante' => $group->sum('cantidad_restante'),
                'stock_minimo' => $group->max('stock_minimo'), // Usamos el máximo stock mínimo definido
                'costo_total' => $group->sum('costo_total'),
                'fecha_ingreso' => $latest->fecha_ingreso,
                'fecha_vencimiento_lote' => $latest->fecha_vencimiento_lote,
                'productoDetalle' => $productoDetalle,
                'costo_reabastecimiento' => $costoUltimoLote,
                'recomendar_cambio_precio' => $recomendarCambioPrecio,
                'total_lotes' => $group->count(),
                'lotes' => $group,
                'tiene_bajo_stock' => $group->sum('cantidad_restante') <= $group->max('stock_minimo'),
                'reabastecido' => $group->count() > 1 && $group->some(function($lote) {
                    return $lote->cantidad_restante > $lote->stock_minimo;
                })
            ];
        })->values();

        return view('administrador.proveedores.productos.index', compact('proveedor', 'ingresos', 'stats'));
    }

    /**
     * Muestra el historial de lotes de un producto específico.
     */
    public function show(IngresoProducto $ingresoProducto): View
    {
        // Buscamos todos los lotes del mismo producto para este proveedor
        $lotes = IngresoProducto::where('proveedor_id', $ingresoProducto->proveedor_id)
            ->where('nombre_producto', $ingresoProducto->nombre_producto)
            ->orderBy('fecha_ingreso', 'desc')
            ->get();

        return view('administrador.proveedores.productos.ver', compact('ingresoProducto', 'lotes'));
    }

    /**
     * Muestra el formulario para registrar un nuevo ingreso.
     */
    public function create(Request $request): View
    {
        // Obtener proveedor_id y nombre_producto de la URL
        $proveedorId = $request->get('proveedor_id');
        $nombre_producto = $request->get('nombre_producto');

        $selectedProveedor = null;
        $proveedores = Proveedor::orderBy('nombre_empresa')->get();

        // Si existe proveedor_id buscamos el proveedor
        if ($proveedorId) {
            $selectedProveedor = Proveedor::find($proveedorId);
        }

        return view('administrador.proveedores.productos.agregar', compact(
            'selectedProveedor',
            'proveedores',
            'nombre_producto'
        ));
    }


    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'nombre_producto' => 'required',
            'codigo_lote' => 'nullable|string|max:255',
            'unidad_medida' => 'required|string|in:Unidad,Kilogramos,Gramos,Litros',
            'cantidad_inicial' => 'required|integer|min:1',
            'stock_minimo' => 'required|integer|min:0',
            'costo_total' => 'required|numeric|min:0',
            'fecha_ingreso' => 'required|date',
            'fecha_vencimiento_lote' => 'nullable|date',
            'numero_factura' => 'nullable|string|max:255',
            'foto_factura' => 'nullable|image|max:2048',
        ]);

        $data = [
            'proveedor_id' => $request->proveedor_id,
            'nombre_producto' => $request->nombre_producto,
            'codigo_lote' => $request->codigo_lote,
            'unidad_medida' => $request->unidad_medida,
            'cantidad_inicial' => $request->cantidad_inicial,
            'cantidad_restante' => $request->cantidad_inicial,
            'stock_minimo' => $request->stock_minimo,
            'costo_total' => $request->costo_total,
            'fecha_ingreso' => $request->fecha_ingreso,
            'fecha_vencimiento_lote' => $request->fecha_vencimiento_lote,
            'numero_factura' => $request->numero_factura,
        ];

        if ($request->hasFile('foto_factura')) {
            $data['foto_factura'] = $request->file('foto_factura')->store('facturas', 'public');
        }

        IngresoProducto::create($data);

        return redirect()
            ->route('proveedores.productos.index', $request->proveedor_id)
            ->with('success', 'Ingreso registrado correctamente.');
    }


    /**
     * Muestra el formulario para editar un ingreso existente.
     */
    public function edit(IngresoProducto $ingresoProducto): View
    {
        $proveedores = Proveedor::orderBy('nombre_empresa')->get();
        return view('administrador.proveedores.productos.editar', compact('ingresoProducto', 'proveedores'));
    }

    /**
     * Actualiza un ingreso de producto existente.
     */
    public function update(Request $request, IngresoProducto $ingresoProducto): RedirectResponse
    {
        $validated = $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'nombre_producto' => 'required|string|max:255',
            'codigo_lote' => 'nullable|string|max:255',
            'unidad_medida' => 'required|string|in:Unidad,Kilogramos,Gramos,Litros',
            'cantidad_inicial' => 'required|integer|min:1',
            'stock_minimo' => 'required|integer|min:0',
            'costo_total' => 'required|numeric|min:0',
            'fecha_ingreso' => 'required|date',
            'fecha_vencimiento_lote' => 'nullable|date',
            'numero_factura' => 'nullable|string|max:255',
            'foto_factura' => 'nullable|image|max:2048',
        ]);
        
        // Recalculamos la cantidad restante si la cantidad inicial cambia
        $diferencia = $validated['cantidad_inicial'] - $ingresoProducto->cantidad_inicial;
        $validated['cantidad_restante'] = $ingresoProducto->cantidad_restante + $diferencia;

        if ($request->hasFile('foto_factura')) {
            if ($ingresoProducto->foto_factura) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($ingresoProducto->foto_factura);
            }
            $validated['foto_factura'] = $request->file('foto_factura')->store('facturas', 'public');
        }

        $ingresoProducto->update($validated);

        return redirect()->route('proveedores.productos.index', $ingresoProducto->proveedor_id)
                   ->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Elimina un ingreso de producto.
     */
    public function destroy(IngresoProducto $ingresoProducto): RedirectResponse
    {
        $proveedorId = $ingresoProducto->proveedor_id;
        $ingresoProducto->delete();

        return redirect()->route('proveedores.productos.index', $proveedorId)
                   ->with('success', 'Producto eliminado correctamente.');
    }

    /**
     * Muestra la lista de productos eliminados.
     */
    public function deleted(Proveedor $proveedor): View
    {
        $eliminados = $proveedor->ingresosProductos()->onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view('administrador.proveedores.productos.eliminados', compact('proveedor', 'eliminados'));
    }

    /**
     * Restaura un producto eliminado.
     */
    public function restore($id): RedirectResponse
    {
        $ingreso = IngresoProducto::withTrashed()->findOrFail($id);
        $ingreso->restore();

        return redirect()->route('ingresos.deleted', $ingreso->proveedor_id)
            ->with('success', 'Producto restaurado correctamente.');
    }
}