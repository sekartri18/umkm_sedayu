<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Umkm;

class UmkmSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Membuat Kategori
        $kategoriMakanan = Category::create(['name' => 'Makanan', 'slug' => 'makanan']);
        $kategoriPakaian = Category::create(['name' => 'Pakaian', 'slug' => 'pakaian']);
        $kategoriKerajinan = Category::create(['name' => 'Kerajinan', 'slug' => 'kerajinan']);

        // 2. Membuat Data UMKM Contoh
        Umkm::create([
            'category_id' => $kategoriMakanan->id,
            'name' => 'Keripik Singkong Bu Ani',
            'description' => 'Keripik singkong renyah khas Sedayu dengan berbagai varian rasa.',
            'owner_name' => 'Ibu Ani',
            'whatsapp_number' => '6281234567890', // Format 62...
            'address' => 'Dusun Krajan, Sedayu',
            'image' => 'placeholder-makanan.jpg' 
        ]);

        Umkm::create([
            'category_id' => $kategoriPakaian->id,
            'name' => 'Toko Pakaian Lestari',
            'description' => 'Menyediakan pakaian harian dan daster berkualitas.',
            'owner_name' => 'Bapak Budi',
            'whatsapp_number' => '6289876543210',
            'address' => 'Dusun Pethit, Sedayu',
            'image' => 'placeholder-pakaian.jpg'
        ]);
    }
}