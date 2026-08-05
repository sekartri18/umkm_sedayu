<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Pengecekan aman: hanya buat user jika email belum ada
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        $this->call([
            AdminSeeder::class,
        ]);

        // Memanggil UmkmSeeder
        $this->call([
            UmkmSeeder::class,
        ]);
    }
}