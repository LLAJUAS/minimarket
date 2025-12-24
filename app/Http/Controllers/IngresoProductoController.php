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
        $query = $proveedor->ingresosProductos();

        // Filtro por nombre de producto
        if ($request->filled('nombre_producto')) {
            $query->where('nombre_producto', 'like', '%' . $request->nombre_producto . '%');
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

        // Cargamos los ingresos ordenados por fecha descendente (más reciente primero)
        $ingresos = $query->with(['productoDetalle.subcategoria.categoria'])
            ->orderBy('fecha_ingreso', 'desc')
            ->get();

        return view('administrador.proveedores.productos.index', compact('proveedor', 'ingresos'));
    }

    /**
     * Muestra el formulario para registrar un nuevo ingreso.
     */
    public function create(Request $request): View
{
    // Obtener proveedor_id de la URL
    $proveedorId = $request->get('proveedor_id');

    $selectedProveedor = null;
    $proveedores = Proveedor::orderBy('nombre_empresa')->get();

    // Si existe proveedor_id buscamos el proveedor
    if ($proveedorId) {
        $selectedProveedor = Proveedor::find($proveedorId);
    }

    return view('administrador.proveedores.productos.agregar', compact(
        'selectedProveedor',
        'proveedores'
    ));
}


   public function store(Request $request): RedirectResponse
{
    $request->validate([
        'proveedor_id' => 'required|exists:proveedores,id',
        'nombre_producto' => 'required',
        'cantidad_inicial' => 'required|integer|min:1',
        'costo_total' => 'required|numeric|min:0',
        'fecha_ingreso' => 'required|date',
        'fecha_vencimiento_lote' => 'nullable|date',
    ]);

    IngresoProducto::create([
        'proveedor_id' => $request->proveedor_id,
        'nombre_producto' => $request->nombre_producto,
        'cantidad_inicial' => $request->cantidad_inicial,
        'cantidad_restante' => $request->cantidad_inicial, // inicia igual
        'costo_total' => $request->costo_total,
        'fecha_ingreso' => $request->fecha_ingreso,
        'fecha_vencimiento_lote' => $request->fecha_vencimiento_lote,
        'numero_factura' => $request->numero_factura,
    ]);

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
            'cantidad_inicial' => 'required|integer|min:1',
            'costo_total' => 'required|numeric|min:0',
            'fecha_ingreso' => 'required|date',
            'fecha_vencimiento_lote' => 'nullable|date',
            'numero_factura' => 'nullable|string|max:255',
        ]);
        
        // Recalculamos la cantidad restante si la cantidad inicial cambia
        $diferencia = $validated['cantidad_inicial'] - $ingresoProducto->cantidad_inicial;
        $validated['cantidad_restante'] = $ingresoProducto->cantidad_restante + $diferencia;

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
}