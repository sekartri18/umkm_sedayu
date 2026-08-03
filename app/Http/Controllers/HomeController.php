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

    public function umkmList(Request $request)
    {
        $categories = \App\Models\Category::all();
        
        // Mulai query untuk mengambil UMKM yang sudah disetujui
        $query = \App\Models\Umkm::with('category')->where('status', 'approved');

        // Jika ada inputan di kotak pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('address', 'like', '%' . $search . '%')
                  ->orWhereHas('category', function($qCat) use ($search) {
                      $qCat->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        // Ambil data dengan pagination (12 UMKM per halaman)
        $umkms = $query->latest()->paginate(12);

        return view('umkm.index', compact('umkms', 'categories'));
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

    public function productShow($id)
    {
        // Cari produk berdasarkan ID beserta data UMKM pemiliknya
        $product = \App\Models\Product::with(['umkm', 'reviews.user'])->findOrFail($id);
        
        // Ambil beberapa produk lain dari toko yang sama untuk rekomendasi
        $otherProducts = \App\Models\Product::where('umkm_id', $product->umkm_id)
                            ->where('id', '!=', $id)
                            ->inRandomOrder()
                            ->take(4)
                            ->get();

        return view('product.show', compact('product', 'otherProducts'));
    }
}