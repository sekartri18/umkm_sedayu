<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class SellerProductController extends Controller
{
    // 1. Fungsi baru untuk Halaman Dashboard (Menampilkan Statistik)
    public function dashboard()
    {
        $user = Auth::user();
        $umkm = $user->umkm;

        // Proteksi ekstra: Jika bukan penjual (tidak punya UMKM), kembalikan ke Beranda
        if (!$umkm) { 
            return redirect('/'); 
        }

        return view('dashboard', compact('umkm'));
    }

    // 2. Fungsi index sekarang dikhususkan untuk Halaman "Produk" (Menampilkan Daftar Produk)
    public function index()
    {
        $user = Auth::user();
        $umkm = $user->umkm;

        if (!$umkm) { 
            return redirect('/'); 
        }
        
        // Mengambil semua produk milik UMKM tersebut
        $products = $umkm->products()->latest()->get();

        // Mengarahkan ke file tampilan baru yang akan kita buat
        return view('seller.product.index', compact('umkm', 'products'));
    }

    // 3. Menampilkan halaman form tambah produk
    public function create()
    {
        return view('seller.product.create');
    }

    // 4. Memproses data input dan menyimpan foto ke database
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096', // Maksimal ukuran 4MB
        ]);

        // 2. Proses Upload Gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            // Gambar akan disimpan di folder storage/app/public/products
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // 3. Simpan Data Produk Baru
        Product::create([
            // Ambil ID UMKM dari penjual yang sedang login
            'umkm_id' => Auth::user()->umkm->id, 
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        // 4. Kembalikan ke Halaman Produk dengan pesan sukses
        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan ke etalase!');
    }
}