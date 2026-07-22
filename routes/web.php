<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminUmkmController;
use App\Http\Controllers\SellerAuthController;

/*
|--------------------------------------------------------------------------
| Rute Pengunjung (Guest & User)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index']);
Route::get('/umkm/{id}', [HomeController::class, 'show'])->name('umkm.show');

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
// Group Route untuk Dashboard dan Manajemen Produk (Hanya untuk yang sudah login)
Route::middleware(['auth', 'verified'])->group(function () {
    // Rute Utama Dasbor (Statistik)
    Route::get('/dashboard', [SellerProductController::class, 'dashboard'])->name('dashboard');
    
    // Rute Halaman List Produk
    Route::get('/produk', [SellerProductController::class, 'index'])->name('produk.index');
    Route::get('/produk/tambah', [SellerProductController::class, 'create'])->name('produk.create');
    Route::post('/produk', [SellerProductController::class, 'store'])->name('produk.store');
    
    // Rute Halaman Pesanan
    Route::get('/pesanan', function() {
        return view('seller.pesanan.index');
    })->name('pesanan.index');
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