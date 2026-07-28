<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Umkm;
use App\Models\Category;

class HomeController extends Controller
{
    // Menampilkan halaman Beranda (Menampilkan daftar UMKM & Kategori)
    public function index(Request $request)
    {
        $categories = Category::all();
        $banners = \App\Models\Banner::latest()->get(); // Ambil data banner terbaru
        
        $query = Umkm::with('category')->where('status', 'approved');

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $umkms = $query->latest()->get();
        
        // Tambahkan variabel $banners ke view
        return view('welcome', compact('categories', 'umkms', 'banners'));
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