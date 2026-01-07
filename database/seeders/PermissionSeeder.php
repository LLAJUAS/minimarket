<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['nombre_permiso' => 'Ver Dashboard', 'slug' => 'ver-dashboard'],
            ['nombre_permiso' => 'Ver Venta Rápida', 'slug' => 'ver-venta-rapida'],
            ['nombre_permiso' => 'Ver Ventas', 'slug' => 'ver-ventas'],
            ['nombre_permiso' => 'Ver Proveedores', 'slug' => 'ver-proveedores'],
            ['nombre_permiso' => 'Ver Productos', 'slug' => 'ver-productos'],
            ['nombre_permiso' => 'Ver Usuarios', 'slug' => 'ver-usuarios'],
            ['nombre_permiso' => 'Gestionar Roles', 'slug' => 'gestionar-roles'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['slug' => $permission['slug']], $permission);
        }

        // Asignar todos los permisos al rol de Administrador por defecto
        $adminRole = \App\Models\Role::where('nombre_rol', 'Administrador')->first();
        if ($adminRole) {
            $allPermissionIds = Permission::pluck('id');
            $adminRole->permissions()->sync($allPermissionIds);
        }
    }
}
