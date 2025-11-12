<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $administrador = Role::create(['name' => 'Administrador']);
        $editor = Role::create(['name' => 'Editor']);
        $usuario = Role::create(['name' => 'Usuario']);


        // Permisos para la gestión de membresias
        Permission::create(['name' => 'Crear membresias'])->syncRoles([$administrador, $editor]);
        Permission::create(['name' => 'Actualizar membresias'])->syncRoles([$administrador, $editor]);
        Permission::create(['name' => 'Eliminar membresias'])->syncRoles([$administrador]);
        Permission::create(['name' => 'Ver membresias'])->syncRoles([$administrador, $editor, $usuario]);
        // Permisos para la gestión de servicios
        Permission::create(['name' => 'Crear servicios'])->syncRoles([$administrador, $editor]);
        Permission::create(['name' => 'Actualizar servicios'])->syncRoles([$administrador, $editor]);
        Permission::create(['name' => 'Eliminar servicios'])->syncRoles([$administrador]);
        Permission::create(['name' => 'Ver servicios'])->syncRoles([$administrador, $editor, $usuario]);
        // Permisos para la gestión de productos
        Permission::create(['name' => 'Crear prductos'])->syncRoles([$administrador, $editor]);
        Permission::create(['name' => 'Actualizar productos'])->syncRoles([$administrador, $editor]);
        Permission::create(['name' => 'Eliminar productos'])->syncRoles([$administrador]);
        Permission::create(['name' => 'Ver productos'])->syncRoles([$administrador, $editor, $usuario]);

        // Permisos para la gestión de ventas
        Permission::create(['name' => 'Crear ventas'])->syncRoles([$administrador, $editor]);
        Permission::create(['name' => 'Actualizar ventas'])->syncRoles([$administrador, $editor]);
        Permission::create(['name' => 'Eliminar ventas'])->syncRoles([$administrador]);
        Permission::create(['name' => 'Ver ventas'])->syncRoles([$administrador, $editor, $usuario]);

    }
}
