<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class permissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permisos = [
            //usuario
            'ver-usuario',
            'crear-usuario',
            'editar-usuario',
            'eliminar-usuario',

            //productos
            'gestionar-productos',
            'gestionar-medicamentos',
            'gestionar-equipos',

            //ventas
            'gestionar-ventas',
            'ver-detalles-ventas',
            'eliminar-ventas',

            //clientes
            'ver-clientes',
            'crear-clientes',
            'editar-clientes',
            'eliminar-clientes',

            //sucursales
            'administrar-sucursales',

            //roles
            'ver-roles',
            'crear-roles',
            'editar-roles',
            'eliminar-roles',
        ];
        foreach ($permisos as $permiso) {
            Permission::create(['name' => $permiso]);
        }
    }
}
