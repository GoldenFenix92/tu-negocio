<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ID 1: Administrador
        User::create([
            'id' => 1,
            'name' => 'Administrador',
            'email' => 'admin@ebc.com',
            'password' => Hash::make('ADMINISTRADOR'),
            'role' => User::ROLE_ADMIN,
            'permissions' => User::getDefaultPermissionsForRole(User::ROLE_ADMIN),
            'commission_percentage' => 0.0000,
            'email_verified_at' => now(),
        ]);

        // ID 2: Supervisor
        User::create([
            'id' => 2,
            'name' => 'Supervisor',
            'email' => 'supervisor@ebc.com',
            'password' => Hash::make('SUPERVISOR'),
            'role' => User::ROLE_SUPERVISOR,
            'permissions' => User::getDefaultPermissionsForRole(User::ROLE_SUPERVISOR),
            'commission_percentage' => 5.0000,
            'email_verified_at' => now(),
        ]);

        // ID 3: Usuario (Empleado/Vendedor/Cajero)
        User::create([
            'id' => 3,
            'name' => 'Usuario',
            'email' => 'usuario@ebc.com',
            'password' => Hash::make('USUARIO'),
            'role' => User::ROLE_EMPLEADO,
            'permissions' => User::getDefaultPermissionsForRole(User::ROLE_EMPLEADO),
            'commission_percentage' => 9.9999,
            'email_verified_at' => now(),
        ]);
    }
}
