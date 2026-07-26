<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Umkm;
use App\Models\Category;

class HomeController extends Controller
{
    // Menampilkan halaman Beranda (Menampilkan daftar UMKM & Kategori)
    public function index()
    {
        // Mengambil data kategori dan UMKM untuk ditampilkan di halaman awal
        $categories = Category::all();
        $umkms = Umkm::with('category')->latest()->get();
        
        return view('welcome', compact('categories', 'umkms'));
    }

    // Menampilkan halaman Detail Toko UMKM
    public function show($id)
    {
        $umkm = Umkm::findOrFail($id);

        // FITUR PENGHITUNG PENGUNJUNG:
        // Setiap kali rute ini diakses (baik oleh guest maupun user login),
        // kolom 'views' pada toko UMKM ini akan otomatis bertambah 1
        $umkm->increment('views');

        // Mengambil data produk milik toko ini untuk ditampilkan ke pembeli
        $products = $umkm->products()->latest()->get();

        return view('umkm.detail', compact('umkm', 'products'));
    }
}