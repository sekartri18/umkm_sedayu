<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminUmkmController;
use App\Http\Controllers\SellerAuthController;
use App\Http\Controllers\CartController;
use App\Models\Order;
use App\Models\Umkm;
use App\Models\Banner;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminBannerController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\BuyerOrderController;
use App\Http\Controllers\BuyerFavoriteController;
use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| Rute Pengunjung (Guest & User)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

// Halaman Jelajah / Pencarian Semua UMKM
Route::get('/jelajah', [HomeController::class, 'umkmList'])->name('umkm.list');
Route::get('/umkm/{id}', [HomeController::class, 'show'])->name('umkm.show');
Route::get('/produk-detail/{id}', [HomeController::class, 'productShow'])->name('product.show');
Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
Route::post('/keranjang/{productId}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/keranjang/{productId}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/keranjang/{productId}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/checkout', [CartController::class, 'processCheckout'])->name('cart.processCheckout');
Route::get('/checkout/sukses', [CartController::class, 'success'])->name('cart.success');

/*
|--------------------------------------------------------------------------
| Rute Pendaftaran Khusus Penjual
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/daftar-penjual', [SellerAuthController::class, 'create'])->name('penjual.register');
    Route::post('/daftar-penjual', [SellerAuthController::class, 'store']);
});

/*
|--------------------------------------------------------------------------
| Rute Admin, Penjual & Pembeli (Membutuhkan Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Rute Dashboard Dinamis
    Route::get('/dashboard', function () {
        $user = auth()->user();

        // 1. Jika yang login adalah admin, tampilkan dasbor analitik
        if ($user->role === 'admin') {
            $totalUmkm = \App\Models\Umkm::where('status', 'approved')->count();
            $totalCustomer = \App\Models\User::where('role', 'buyer')->count();
            $gmv = \App\Models\Order::whereIn('status', ['success', 'settlement', 'berhasil'])->sum('subtotal');
            
            return view('dashboard', compact('totalUmkm', 'totalCustomer', 'gmv'));
        }

        // 2. Jika yang login penjual (role 'seller' ATAU memiliki UMKM), arahkan ke dashboard penjual
        if ($user->role === 'seller' || $user->role === 'penjual' || $user->umkm) {
            return app(SellerProductController::class)->dashboard();
        }

        // 3. Jika yang login adalah pembeli (atau fallback default), arahkan ke halaman utama
        return redirect()->route('home');
        
    })->name('dashboard');
    
    // Rute Manajemen Produk (Penjual)
    Route::get('/produk', [SellerProductController::class, 'index'])->name('produk.index');
    Route::get('/produk/tambah', [SellerProductController::class, 'create'])->name('produk.create');
    Route::post('/produk', [SellerProductController::class, 'store'])->name('produk.store');
    Route::get('/produk/{id}/edit', [SellerProductController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{id}', [SellerProductController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [SellerProductController::class, 'destroy'])->name('produk.destroy');
    
    // Rute Halaman Pesanan Penjual
    Route::get('/pesanan', function() {
        $user = Auth::user();
        $umkm = $user->umkm;

        $orders = Order::with(['items.product', 'items.umkm'])
            ->whereHas('items', function ($query) use ($umkm) {
                $query->where('umkm_id', $umkm->id);
            })
            ->latest('checked_out_at')
            ->latest()
            ->get();

        return view('seller.pesanan.index', compact('orders', 'umkm'));
    })->name('pesanan.index');

    // BARIS BARU: Rute untuk penjual memproses dan mengirim barang
    Route::patch('/pesanan/{id}/kirim', [SellerProductController::class, 'kirimPesanan'])->name('seller.pesanan.kirim');

    // Rute Halaman Pesanan & Favorit (Pembeli) terhubung ke Controller buatan temanmu
    Route::get('/pesanan-saya', [BuyerOrderController::class, 'index'])->name('buyer.orders');
    
    // Rute untuk tombol "Pesanan Diterima" dan pelepasan dana
    Route::patch('/pesanan-saya/{id}/selesai', [BuyerOrderController::class, 'completeOrder'])->name('buyer.orders.complete');

    Route::get('/favorit-saya', [BuyerFavoriteController::class, 'index'])->name('buyer.favorites');
    Route::post('/favorit-saya/{product}', [BuyerFavoriteController::class, 'toggle'])->name('buyer.favorites.toggle');
    Route::delete('/favorit-saya/{product}', [BuyerFavoriteController::class, 'destroy'])->name('buyer.favorites.destroy');

    // Rute Tambah Ulasan Produk (Pembeli)
    Route::post('/produk-detail/{id}/ulasan', [ReviewController::class, 'store'])->name('reviews.store');

    // Rute Halaman Keuangan (Penjual)
    Route::get('/keuangan', [SellerProductController::class, 'keuangan'])->name('keuangan.index');
    Route::post('/keuangan/tarik', [SellerProductController::class, 'tarikSaldo'])->name('keuangan.tarik'); // BARIS BARU

    // Rute Halaman Pengaturan Toko (Penjual)
    Route::get('/pengaturan', [SellerProductController::class, 'pengaturan'])->name('pengaturan.index');
    Route::put('/pengaturan', [SellerProductController::class, 'updatePengaturan'])->name('pengaturan.update');
});

/*
|--------------------------------------------------------------------------
| Rute Panel Khusus Admin
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth', IsAdmin::class])->group(function () {
    Route::get('/umkm', [AdminUmkmController::class, 'index'])->name('admin.umkm.index');
    Route::put('/umkm/{id}/status', [AdminUmkmController::class, 'updateStatus'])->name('admin.umkm.status');
    Route::resource('/category', AdminCategoryController::class)->names('admin.category');
    Route::resource('/banner', AdminBannerController::class)->names('admin.banner')->only(['index', 'store', 'destroy']);
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/penarikan', [App\Http\Controllers\AdminWithdrawalController::class, 'index'])->name('admin.withdrawals.index');
    Route::patch('/penarikan/{id}/setujui', [App\Http\Controllers\AdminWithdrawalController::class, 'approve'])->name('admin.withdrawals.approve');
});

/*
|--------------------------------------------------------------------------
| Rute Profil Bawaan Breeze
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';