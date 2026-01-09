<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash; // Importar la clase Hash

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear el rol 'Admin'
        $roleAdmin = Role::firstOrCreate(
            ['nombre_rol' => 'Administrador']
        );

        // 2. Crear el usuario 'admin'
        $userAdmin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'], // Buscar por email para no duplicar
            [
                'nombre'     => 'Admin',
                'apellido'   => 'Admin',
                'usuario'    => 'admin',
                'celular'    => '62397902',
                'password'   => Hash::make('admin'), // Hashear la contraseña de forma segura
            ]
        );

        // 3. Asignar el rol 'Admin' al usuario 'admin'
        // El método sync() evita duplicados en la tabla pivote
        $userAdmin->roles()->sync([$roleAdmin->id]);

        $this->command->info('✅ Usuario y rol de administrador creados exitosamente.');
    }
}