<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Muestra el panel de administración.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index(): View
    {
        // 1. Obtener al usuario autenticado
        $user = Auth::user();

        // 2. Verificar si el usuario tiene el rol 'Admin'
        // Usamos el método first() para obtener el primer rol y lo comparamos.
        if ($user->roles->first()->nombre_rol !== 'Admin') {
            // Si no es admin, redirigir a la página principal con un mensaje de error
            return redirect('/')->with('error', 'No tienes permisos para acceder a esta página.');
        }

        // 3. Si es admin, mostrar la vista del dashboard y pasarle los datos del usuario
        return view('administrador.dashboard', compact('user'));
    }
}