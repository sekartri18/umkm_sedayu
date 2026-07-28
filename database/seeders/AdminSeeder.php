<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@sedayu.com'], // Cek agar tidak duplikat
            [
                'name' => 'Administrator',
                'password' => Hash::make('password123'), // Kata sandi: password123
                'role' => 'admin',
            ]
        );
    }
}