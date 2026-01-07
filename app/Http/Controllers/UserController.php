<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $role_id = $request->get('role_id');
        $status = $request->get('status');

        $query = User::with('roles');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%$search%")
                  ->orWhere('apellido', 'like', "%$search%")
                  ->orWhere('usuario', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        if ($role_id) {
            $query->whereHas('roles', function($q) use ($role_id) {
                $q->where('roles.id', $role_id);
            });
        }

        if ($status) {
            if ($status === 'bloqueado') {
                $query->onlyTrashed();
            }
        }

        $usuarios = $query->paginate(10)->withQueryString();
        $roles = Role::all();

        // Statistics
        $totalUsuarios = User::withTrashed()->count();
        $usuariosActivos = User::count();
        $usuariosBloqueados = User::onlyTrashed()->count();
        $totalAdmins = User::whereHas('roles', function($q) {
            $q->where('nombre_rol', 'Administrador');
        })->count();

        return view('administrador.usuarios.index', compact(
            'usuarios', 'roles', 'totalUsuarios', 'usuariosActivos', 'usuariosBloqueados', 'totalAdmins'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'usuario' => 'required|string|unique:users,usuario',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'usuario' => $request->usuario,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'celular' => $request->celular,
            ]);

            $user->roles()->attach($request->role_id);

            DB::commit();

            return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al crear el usuario: ' . $e->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        if ($user->trashed()) {
            $user->restore();
            $mensaje = "Usuario restaurado y activado.";
        } else {
            $user->delete();
            $mensaje = "Usuario bloqueado correctamente.";
        }

        return response()->json([
            'success' => true,
            'mensaje' => $mensaje
        ]);
    }

    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->roles()->sync($request->role_id);

        return response()->json([
            'success' => true,
            'mensaje' => 'Rol actualizado correctamente.'
        ]);
    }

    public function destroy($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        
        // Hard delete if already soft deleted, or just soft delete? 
        // Template shows a "Delete" button. Usually implies permanent or confirming soft delete.
        // Let's do permanent delete if the user is already trashed, or just soft delete if not.
        
        if ($user->trashed()) {
            $user->forceDelete();
            return response()->json(['success' => true, 'mensaje' => 'Usuario eliminado permanentemente.']);
        } else {
            $user->delete();
            return response()->json(['success' => true, 'mensaje' => 'Usuario enviado a la papelera.']);
        }
    }
}
