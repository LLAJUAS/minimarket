<?php

namespace App\Http\Controllers;

use App\Models\IngresoProducto;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class IngresoProductoController extends Controller
{
    /**
     * Muestra la lista de productos (ingresos) de un proveedor específico.
     */
    public function index(Proveedor $proveedor): View
    {
        // Cargamos los ingresos del proveedor, ordenados por fecha descendente (más reciente primero)
        $ingresos = $proveedor->ingresosProductos()->orderBy('fecha_ingreso', 'desc')->get();

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
    ]);

    IngresoProducto::create([
        'proveedor_id' => $request->proveedor_id,
        'nombre_producto' => $request->nombre_producto,
        'cantidad_inicial' => $request->cantidad_inicial,
        'cantidad_restante' => $request->cantidad_inicial, // inicia igual
        'costo_total' => $request->costo_total,
        'fecha_ingreso' => $request->fecha_ingreso,
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