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
       

        $admin->assignRole('support');
       
    }
}
