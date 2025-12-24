<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Subcategoria;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CategoriaController extends Controller
{
    /**
     * Muestra la lista de todas las categorías con sus subcategorías.
     */
    public function index(): View
    {
        $categorias = Categoria::with('subcategorias')
            ->orderBy('nombre', 'asc')
            ->get();

        return view('administrador.productos.categorias.index', compact('categorias'));
    }

    /**
     * Muestra el formulario para crear una nueva categoría.
     */
    public function create(): View
    {
        return view('administrador.productos.categorias.create');
    }

    /**
     * Almacena una nueva categoría en la base de datos.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre',
        ], [
            'nombre.required' => 'El nombre de la categoría es obligatorio.',
            'nombre.unique' => 'Esta categoría ya existe.',
            'nombre.max' => 'El nombre no puede exceder 255 caracteres.',
        ]);

        Categoria::create($validated);

        return redirect()
            ->route('categorias.index')
            ->with('success', 'Categoría creada correctamente.');
    }

    /**
     * Muestra el formulario para editar una categoría.
     */
    public function edit(Categoria $categoria): View
    {
        $categoria->load('subcategorias');
        return view('administrador.productos.categorias.edit', compact('categoria'));
    }

    /**
     * Actualiza una categoría en la base de datos.
     */
    public function update(Request $request, Categoria $categoria): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre,' . $categoria->id,
        ], [
            'nombre.required' => 'El nombre de la categoría es obligatorio.',
            'nombre.unique' => 'Esta categoría ya existe.',
            'nombre.max' => 'El nombre no puede exceder 255 caracteres.',
        ]);

        $categoria->update($validated);

        return redirect()
            ->route('categorias.index')
            ->with('success', 'Categoría actualizada correctamente.');
    }

    /**
     * Elimina una categoría y sus subcategorías asociadas.
     */
    public function destroy(Categoria $categoria): RedirectResponse
    {
        // Eliminar subcategorías asociadas primero
        $categoria->subcategorias()->delete();
        
        // Luego eliminar la categoría
        $categoria->delete();

        return redirect()
            ->route('categorias.index')
            ->with('success', 'Categoría eliminada correctamente.');
    }

    /**
     * Crea una nueva subcategoría para una categoría específica.
     */
    public function storeSubcategoria(Request $request, Categoria $categoria): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
        ], [
            'nombre.required' => 'El nombre de la subcategoría es obligatorio.',
            'nombre.max' => 'El nombre no puede exceder 255 caracteres.',
        ]);

        $categoria->subcategorias()->create($validated);

        return redirect()
            ->route('categorias.edit', $categoria->id)
            ->with('success', 'Subcategoría agregada correctamente.');
    }

    /**
     * Elimina una subcategoría.
     */
    public function destroySubcategoria(Subcategoria $subcategoria): RedirectResponse
    {
        $categoriaId = $subcategoria->categoria_id;
        $subcategoria->delete();

        return redirect()
            ->route('categorias.edit', $categoriaId)
            ->with('success', 'Subcategoría eliminada correctamente.');
    }

    /**
     * Retorna las subcategorías de una categoría en formato JSON.
     */
    public function getSubcategorias(Categoria $categoria)
    {
        return response()->json($categoria->subcategorias()->orderBy('nombre')->get());
    }
}
