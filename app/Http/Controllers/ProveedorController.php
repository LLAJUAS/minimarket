<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class ProveedorController extends Controller
{
    /**
     * Muestra una lista de todos los proveedores con búsqueda y ordenamiento.
     */
   public function index(Request $request): View
{
    $search = $request->get('search');
    $sort = $request->get('sort', 'desc'); // 'desc' para más reciente, 'asc' para más antiguo

    $query = Proveedor::withCount('productos');

    // Si hay un término de búsqueda, filtramos por nombre de empresa o contacto
    if ($search) {
        $query->where('nombre_empresa', 'like', '%' . $search . '%')
              ->orWhere('nombre_contacto', 'like', '%' . $search . '%');
    }

    // Ordenamos por fecha de creación
    $proveedores = $query->orderBy('created_at', $sort)->get();

    return view('administrador.proveedores.index', compact('proveedores', 'search', 'sort'));
}

    /**
     * Muestra el formulario para crear un nuevo proveedor.
     */
    public function create(): View
    {
        return view('administrador.proveedores.agregar');
    }

    /**
     * Guarda un nuevo proveedor en la base de datos.
     */
    public function store(Request $request): RedirectResponse
    {
       $validated = $request->validate([
    'nombre_empresa' => 'required|string|max:255|unique:proveedores,nombre_empresa',
    'nombre_contacto' => 'nullable|string|max:255',
    'celular' => 'nullable|string|max:20',
    'email' => 'nullable|email|unique:proveedores,email',
    'direccion' => 'nullable|string',
]);


        $validated['nombre_empresa'] = Str::upper($validated['nombre_empresa']);
        $validated['nombre_contacto'] = Str::upper($validated['nombre_contacto']);
        $validated['direccion'] = Str::upper($validated['direccion']);

        Proveedor::create($validated);

        return redirect()->route('proveedores')->with('success', 'Proveedor agregado correctamente.');
    }

    /**
     * Muestra el formulario para editar un proveedor existente.
     */
    public function edit(Proveedor $proveedor): View
    {
        return view('administrador.proveedores.editar', compact('proveedor'));
    }

    /**
     * Actualiza un proveedor existente en la base de datos.
     */
    public function update(Request $request, Proveedor $proveedor): RedirectResponse
    {
        $validated = $request->validate([
    'nombre_empresa' => 'required|string|max:255|unique:proveedores,nombre_empresa,' . $proveedor->id,
    'nombre_contacto' => 'nullable|string|max:255',
    'celular' => 'nullable|string|max:20',
    'email' => 'nullable|email|unique:proveedores,email,' . $proveedor->id,
    'direccion' => 'nullable|string',
]);


        $validated['nombre_empresa'] = Str::upper($validated['nombre_empresa']);
        $validated['nombre_contacto'] = Str::upper($validated['nombre_contacto']);
        $validated['direccion'] = Str::upper($validated['direccion']);

        $proveedor->update($validated);

        return redirect()->route('proveedores')->with('success', 'Proveedor actualizado correctamente.');
    }

    /**
     * Elimina un proveedor de la base de datos.
     */
    public function destroy(Proveedor $proveedor): RedirectResponse
    {
        $proveedor->delete();
        return redirect()->route('proveedores')->with('success', 'Proveedor eliminado correctamente.');
    }
    public function buscarAjax(Request $request)
{
    $search = $request->get('search');

    $proveedores = Proveedor::where('nombre_empresa', 'LIKE', "%$search%")
        ->orWhere('nombre_contacto', 'LIKE', "%$search%")
        ->limit(10)
        ->get();

    return response()->json($proveedores);
}

}