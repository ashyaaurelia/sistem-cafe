<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Manajer',
            'username' => 'manajer',
            'email' => 'manajer@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'manajer',
        ]);

        User::create([
            'name' => 'Kasir',
            'username' => 'kasir',
            'email' => 'kasir@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'kasir',
        ]);
    }
}