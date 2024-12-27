<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {

        Permission::create(['name' => 'manage tickets']);
        Permission::create(['name' => 'manage vendedores']);


        $suporte = Role::create(['name' => 'support']);
        $vendedor = Role::create(['name' => 'vendedor']);


        $suporte->givePermissionTo(['manage tickets', 'manage vendedores']);
        $vendedor->givePermissionTo(['manage tickets']);
    }
}
