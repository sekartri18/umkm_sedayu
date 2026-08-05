<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyerOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items.product', 'items.umkm'])
            ->where('user_id', Auth::id())
            ->latest('checked_out_at')
            ->latest()
            ->get();

        return view('buyer.orders', compact('orders'));
    }

    public function completeOrder($id)
    {
        $order = Order::with('items.umkm')->where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if (strtolower($order->status) !== 'dikirim') {
            return back()->with('error', 'Pesanan ini belum bisa diselesaikan.');
        }

        // 1. Ubah status pesanan menjadi Selesai
        $order->update(['status' => 'Selesai']);

        // 2. Lepaskan dana ke Saldo UMKM (HANYA JIKA BUKAN COD)
        if (strtolower($order->payment_method) !== 'cod') {
            foreach ($order->items as $item) {
                if ($item->umkm) {
                    $item->umkm->increment('balance', $item->subtotal);

                    \App\Models\WalletTransaction::create([
                        'umkm_id' => $item->umkm->id,
                        'order_id' => $order->id,
                        'type' => 'income',
                        'amount' => $item->subtotal,
                        'status' => 'success',
                        'description' => 'Pencairan dana dari Pesanan #' . $order->id,
                    ]);
                }
            }
        }

        return back()->with('success', 'Pesanan diselesaikan! Silakan berikan ulasan Anda.');
    }
}