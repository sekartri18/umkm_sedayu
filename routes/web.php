<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminUmkmController;
use App\Http\Controllers\SellerAuthController;
use App\Http\Controllers\CartController;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Rute Pengunjung (Guest & User)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index']);
Route::get('/umkm/{id}', [HomeController::class, 'show'])->name('umkm.show');
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
| Rute Admin & Penjual (Membutuhkan Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // Rute Dashboard
    Route::get('/dashboard', [SellerProductController::class, 'dashboard'])->name('dashboard');
    
    // Rute Manajemen Produk
    Route::get('/produk', [SellerProductController::class, 'index'])->name('produk.index');
    Route::get('/produk/tambah', [SellerProductController::class, 'create'])->name('produk.create');
    Route::post('/produk', [SellerProductController::class, 'store'])->name('produk.store');
    Route::get('/produk/{id}/edit', [SellerProductController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{id}', [SellerProductController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [SellerProductController::class, 'destroy'])->name('produk.destroy');
    
    // Rute Halaman Pesanan
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

    // Rute Halaman Keuangan
    Route::get('/keuangan', [SellerProductController::class, 'keuangan'])->name('keuangan.index');

    // Rute Halaman Pengaturan Toko
    Route::get('/pengaturan', [SellerProductController::class, 'pengaturan'])->name('pengaturan.index');
    Route::put('/pengaturan', [SellerProductController::class, 'updatePengaturan'])->name('pengaturan.update');
});

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/umkm', [AdminUmkmController::class, 'index'])->name('admin.umkm.index');
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