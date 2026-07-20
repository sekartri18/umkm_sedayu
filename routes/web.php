<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/umkm/{id}', [HomeController::class, 'show'])->name('umkm.show');