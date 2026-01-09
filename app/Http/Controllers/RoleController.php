<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $allPermissions = \App\Models\Permission::all();
        return view('administrador.usuarios.roles', compact('roles', 'allPermissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_rol' => 'required|string|max:45|unique:roles,nombre_rol',
        ]);

        $role = Role::create($request->only('nombre_rol'));

        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Rol creado exitosamente.');
    }

    public function update(Request $request, Role $role)
    {
        if ($role->nombre_rol === 'Administrador') {
            return redirect()->route('roles.index')->with('error', 'Operación denegada: El rol Administrador no puede ser modificado.');
        }

        $request->validate([
            'nombre_rol' => 'required|string|max:45|unique:roles,nombre_rol,' . $role->id,
        ]);

        $role->update($request->only('nombre_rol'));

        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        } else {
            $role->permissions()->detach();
        }

        return redirect()->route('roles.index')->with('success', 'Rol actualizado exitosamente.');
    }

    public function destroy(Role $role)
    {
        if ($role->nombre_rol === 'Administrador') {
            return redirect()->route('roles.index')->with('error', 'Operación denegada: El rol Administrador no puede ser eliminado.');
        }

        if ($role->users()->count() > 0) {
            return back()->with('error', 'No se puede eliminar el rol porque tiene usuarios asignados.');
        }

        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Rol eliminado exitosamente.');
    }
}
