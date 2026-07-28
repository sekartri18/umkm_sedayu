<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        // Mengambil semua data order (transaksi) beserta data user (pembeli)
        // Menggunakan paginate(20) agar halaman tidak berat jika transaksi sudah ribuan
        $orders = Order::with(['user'])->latest()->paginate(20);
        
        return view('admin.order.index', compact('orders'));
    }
}