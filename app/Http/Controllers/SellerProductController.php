<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class SellerProductController extends Controller
{
    // 1. Fungsi untuk Halaman Dashboard (Menampilkan Statistik)
    public function dashboard()
    {
        $user = Auth::user();
        $umkm = $user->umkm;

        if (!$umkm) { 
            return redirect('/'); 
        }

        /* 
         * LOGIKA BARU: Karena tabel orders tidak memiliki umkm_id, 
         * kita tarik data dari tabel order_items yang terhubung 
         * dengan produk milik UMKM ini.
         */
        $completedItems = OrderItem::with(['product', 'order'])
            ->whereHas('product', function($q) use ($umkm) {
                $q->where('umkm_id', $umkm->id);
            })
            ->whereHas('order', function($q) {
                $q->where('status', 'selesai');
            })
            ->get();

        // 1. Hitung GMV (Total Pendapatan dari pesanan selesai)
        $gmv = $completedItems->sum(function($item) {
            // Cek harga dari order_item, jika kosong ambil dari harga master produk
            $harga = $item->price ?? $item->product->price ?? 0;
            return $harga * $item->quantity;
        });

        // 2. Total Pembeli Unik
        // Ambil ID order dari seluruh pesanan UMKM ini untuk melacak pembeli
        $orderIds = OrderItem::whereHas('product', function($q) use ($umkm) {
            $q->where('umkm_id', $umkm->id);
        })->pluck('order_id');
        
        $totalPembeli = Order::whereIn('id', $orderIds)->distinct('user_id')->count('user_id');

        // 3. Pesanan (SKU) - Total kuantitas barang terjual
        $totalSKU = $completedItems->sum('quantity');

        // 4. Pengunjung Toko 
        $pengunjung = $umkm->views ?? 0;

        // 5. Data Grafik Penjualan (12 Bulan Terakhir)
        $grafikBulan = [];
        $grafikPendapatan = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $grafikBulan[] = $date->translatedFormat('M Y'); 

            // Filter koleksi data yang sudah ditarik sebelumnya agar lebih cepat (hemat Query)
            $pendapatanBulanIni = $completedItems->filter(function($item) use ($date) {
                if (!$item->order) return false;
                $itemDate = Carbon::parse($item->order->created_at);
                return $itemDate->year === $date->year && $itemDate->month === $date->month;
            })->sum(function($item) {
                $harga = $item->price ?? $item->product->price ?? 0;
                return $harga * $item->quantity;
            });

            $grafikPendapatan[] = $pendapatanBulanIni;
        }

        // 6. Mengambil 4 produk terbaru untuk ditampilkan di bawah
        $recentProducts = $umkm->products()->latest()->take(4)->get();

        return view('dashboard', compact(
            'umkm', 'gmv', 'totalPembeli', 'totalSKU', 'pengunjung', 
            'grafikBulan', 'grafikPendapatan', 'recentProducts'
        ));
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
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0', 
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096', 
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'umkm_id' => Auth::user()->umkm->id, 
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan ke etalase!');
    }

    // 5. Menampilkan halaman form edit produk
    public function edit($id)
    {
        $product = Product::findOrFail($id);

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

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
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

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus dari etalase!');
    }

    // 8. Halaman Keuangan (Menghitung Saldo dan Riwayat)
    public function keuangan()
    {
        $user = Auth::user();
        $umkm = $user->umkm;

        if (!$umkm) { return redirect('/'); }

        // Tarik semua pesanan (order_items) milik UMKM ini
        $orderItems = OrderItem::with(['order', 'product'])
            ->whereHas('product', function($q) use ($umkm) {
                $q->where('umkm_id', $umkm->id);
            })
            ->latest()
            ->get();

        $saldoAktif = 0;
        $saldoTertunda = 0;
        $riwayatTransaksi = [];

        foreach ($orderItems as $item) {
            if (!$item->order) continue;

            // Hitung harga per item (prioritas dari order_item, jika kosong ambil dari master produk)
            $harga = $item->price ?? $item->product->price ?? 0;
            $totalSatuItem = $harga * $item->quantity;
            $statusPesanan = strtolower($item->order->status);

            // Klasifikasi Saldo
            if ($statusPesanan === 'selesai') {
                $saldoAktif += $totalSatuItem;
            } else {
                $saldoTertunda += $totalSatuItem;
            }

            // Masukkan ke array Riwayat Transaksi
            $riwayatTransaksi[] = [
                'tanggal' => $item->created_at,
                'id_referensi' => $item->order->order_code,
                'keterangan' => 'Penjualan produk ' . $item->product->name . ' (' . $item->quantity . ' Pcs)',
                'nominal' => $totalSatuItem,
                'status' => $statusPesanan,
            ];
        }

        // Total Penghasilan adalah seluruh pesanan yang sudah selesai (Saldo Aktif)
        $totalPenghasilan = $saldoAktif;

        // Ubah array ke Collection agar mudah di-sorting dan di-loop di blade
        $riwayatTransaksi = collect($riwayatTransaksi)->sortByDesc('tanggal');

        return view('seller.keuangan.index', compact('saldoAktif', 'saldoTertunda', 'totalPenghasilan', 'riwayatTransaksi'));
    }

    // 9. Menampilkan Halaman Pengaturan Toko
    public function pengaturan()
    {
        $user = Auth::user();
        $umkm = $user->umkm;

        if (!$umkm) { return redirect('/'); }

        return view('seller.pengaturan.index', compact('umkm'));
    }

    // 10. Memproses Pembaruan Profil Toko
    // 10. Memproses Pembaruan Profil Toko & Keamanan
    public function updatePengaturan(Request $request)
    {
        $user = Auth::user();
        $umkm = $user->umkm;

        if (!$umkm) { return redirect('/'); }

        // Validasi input form
        $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'maps_link' => 'nullable|url', // Validasi harus berupa link URL
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            
            // Validasi kata sandi (Hanya wajib jika kolom password baru diisi)
            'current_password' => 'nullable|required_with:password|current_password',
            'password' => 'nullable|min:8|confirmed',
        ]);

        // 1. Proses Update Password Akun (Jika pengguna mengisi form kata sandi)
        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        // 2. Proses Update Profil Toko
        $data = [
            'name' => $request->name,
            'whatsapp_number' => $request->whatsapp_number,
            'address' => $request->address,
            'maps_link' => $request->maps_link,
        ];

        // Jika penjual mengunggah foto profil toko baru
        if ($request->hasFile('image')) {
            if ($umkm->image) {
                Storage::disk('public')->delete($umkm->image);
            }
            $data['image'] = $request->file('image')->store('umkm', 'public');
        }

        $umkm->update($data);

        return redirect()->route('pengaturan.index')->with('success', 'Profil toko dan pengaturan keamanan berhasil diperbarui!');
    }
}