<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

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

        $umkm->load('category');
        $umkm->loadCount('products');

        $products = $umkm->products()->latest()->get();

        return view('dashboard', compact('umkm', 'products'));
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
        // 1. Validasi Input (Ditambahkan validasi untuk stock)
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0', 
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096', // Maksimal ukuran 4MB
        ]);

        // 2. Proses Upload Gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            // Gambar akan disimpan di folder storage/app/public/products
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // 3. Simpan Data Produk Baru (Ditambahkan penyimpanan stock)
        Product::create([
            // Ambil ID UMKM dari penjual yang sedang login
            'umkm_id' => Auth::user()->umkm->id, 
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        // 4. Kembalikan ke Halaman Produk dengan pesan sukses
        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan ke etalase!');
    }

    // 5. Menampilkan halaman form edit produk
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        // Proteksi: Pastikan produk ini milik UMKM yang sedang login
        if ($product->umkm_id !== Auth::user()->umkm->id) {
            abort(403, 'Anda tidak memiliki akses ke produk ini.');
        }

        return view('seller.product.edit', compact('product'));
    }

    // 6. Memproses pembaruan data produk
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($product->umkm_id !== Auth::user()->umkm->id) {
            abort(403);
        }

        // Validasi Input (Ditambahkan validasi untuk stock)
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        // Siapkan data yang akan diupdate (Ditambahkan pembaruan stock)
        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
        ];

        // Jika penjual mengunggah gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama dari server jika ada
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            // Simpan gambar baru
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('produk.index')->with('success', 'Data produk berhasil diperbarui!');
    }

    // 7. Menghapus produk
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->umkm_id !== Auth::user()->umkm->id) {
            abort(403);
        }

        // Hapus file gambar dari server
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Hapus data dari database
        $product->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus dari etalase!');
    }
}