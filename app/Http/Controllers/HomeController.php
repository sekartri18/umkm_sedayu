<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Umkm;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        // ... (kode index yang sudah ada sebelumnya) ...
        $categories = Category::all();
        $umkms = Umkm::with('category')->latest()->get();
        return view('welcome', compact('categories', 'umkms'));
    }

    // Method baru untuk Halaman Detail UMKM
    public function show($id)
    {
        // Mencari data UMKM berdasarkan ID beserta relasi kategorinya
        // Menggunakan findOrFail agar jika ID tidak ditemukan, langsung menampilkan error 404
        $umkm = Umkm::with(['category', 'products' => function ($query) {
            $query->latest();
        }])->findOrFail($id);

        return view('umkm.detail', compact('umkm'));
    }
}