<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // Pastikan pesanan ini benar-benar milik user yang sedang login
        $validOrder = Order::where('id', $request->order_id)
            ->where('user_id', Auth::id())
            ->exists();

        if (!$validOrder) {
            return back()->with('error', 'Akses ditolak. Pesanan tidak valid.');
        }

        // Simpan berdasarkan kombinasi user_id, product_id, DAN order_id (Seperti Shopee)
        Review::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $productId, 'order_id' => $request->order_id],
            ['rating' => $request->rating, 'comment' => $request->comment]
        );

        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil disimpan.');
    }
}