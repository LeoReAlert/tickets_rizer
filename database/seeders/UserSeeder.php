<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {

        $admin = User::create([
            'name' => 'Admin Suporte',
            'email' => 'suporte@rizer.com',
            'password' => Hash::make('password123'),
        ]);
        $felipe = User::create([
            'name' => 'Felipe Vendedor',
            'email' => 'felipe@rizer.com',
            'password' => Hash::make('password123'),
        ]);
        $rodrigo = User::create([
            'name' => 'Rodrigo Vendedor',
            'email' => 'rodrigo@rizer.com',
            'password' => Hash::make('password123'),
        ]);
        $joao = User::create([
            'name' => 'João Vendedor',
            'email' => 'joao@rizer.com',
            'password' => Hash::make('password123'),
        ]);


        $admin->assignRole('support');
        $felipe->assignRole('vendedor');
        $rodrigo->assignRole('vendedor');
        $joao->assignRole('vendedor');
    }
}
