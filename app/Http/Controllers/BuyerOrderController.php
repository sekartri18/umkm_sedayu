<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class BuyerOrderController extends Controller
{
    public function index()
    {
        // Mengambil semua pesanan milik user yang sedang login beserta detail produknya
        $orders = Order::with('items.product')->where('user_id', Auth::id())->latest()->get();
        
        return view('buyer.orders', compact('orders'));
    }
}