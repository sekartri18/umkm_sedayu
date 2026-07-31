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

/*
|--------------------------------------------------------------------------
| Rute Pengunjung (Guest & User)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
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
    
    // Rute Dashboard Dinamis
    Route::get('/dashboard', function () {
        // Jika yang login adalah admin, tampilkan dasbor analitik
        if (auth()->user()->role === 'admin') {
            $totalUmkm = \App\Models\Umkm::where('status', 'approved')->count();
            $totalCustomer = \App\Models\User::where('role', 'buyer')->count();
            $gmv = \App\Models\Order::whereIn('status', ['success', 'settlement', 'berhasil'])->sum('subtotal');
            
            return view('dashboard', compact('totalUmkm', 'totalCustomer', 'gmv'));
        }

            // Jika yang login adalah pembeli, arahkan ke halaman utama (hapus dashboard pembeli)
            if (auth()->user()->role === 'buyer' || auth()->user()->role === 'pembeli') {
                return redirect()->route('home');
            }

            // Jika yang login penjual (memiliki UMKM), panggil controller dashboard penjual
            if (auth()->user()->umkm) {
                return app(SellerProductController::class)->dashboard();
            }

            // Default fallback: arahkan ke halaman utama
            return redirect()->route('home');
    })->name('dashboard');
    
    // Rute Manajemen Produk
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

    // Rute Halaman Pesanan Pembeli
    Route::get('/pesanan-saya', function() {
        $orders = Order::with(['items.product', 'items.umkm'])
            ->where('user_id', Auth::id())
            ->latest('checked_out_at')
            ->get();

        return view('buyer.pesanan', compact('orders'));
    })->name('buyer.orders');

    // Rute Halaman Favorit Pembeli
    Route::get('/favorit-saya', function() {
        return view('buyer.favorites');
    })->name('buyer.favorites');

    // Rute Halaman Keuangan
    Route::get('/keuangan', [SellerProductController::class, 'keuangan'])->name('keuangan.index');

    // Rute Halaman Pengaturan Toko
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

Route::middleware(['auth'])->group(function () {
    Route::get('/pesanan-saya', [BuyerOrderController::class, 'index'])->name('buyer.orders');
});

require __DIR__.'/auth.php';