<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Muestra el formulario de login.
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Maneja una solicitud de autenticación.
     */
    public function login(Request $request)
    {
        // Validación de los campos
        $credentials = $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        // Determinar si el campo 'login' es un email o un nombre de usuario
        $loginField = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'usuario';

        // Combinar las credenciales para el intento de login
        $authCredentials = [
            $loginField => $request->input('login'),
            'password'  => $request->input('password'),
        ];

        // Intentar autenticar al usuario
        if (Auth::attempt($authCredentials)) {
            // Regenerar la sesión para evitar fijación de sesión
            $request->session()->regenerate();

            // Redirigir al panel de control o a la página deseada
            return redirect()->intended('dashboard');
        }

        // Si la autenticación falla, devolver error
        return back()->withErrors([
            'login' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->withInput($request->only('login'));
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}