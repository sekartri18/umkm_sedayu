<?php

namespace App\Http\Controllers;

use App\Models\WalletTransaction;
use Illuminate\Http\Request;

class AdminWithdrawalController extends Controller
{
    public function index()
    {
        // Mengambil transaksi penarikan, diurutkan agar yang "pending" berada paling atas
        $withdrawals = WalletTransaction::with('umkm')
            ->where('type', 'withdrawal')
            ->orderByRaw("FIELD(status, 'pending', 'success', 'failed')")
            ->latest()
            ->get();

        return view('admin.withdrawals.index', compact('withdrawals'));
    }

    public function approve($id)
    {
        $transaction = WalletTransaction::findOrFail($id);
        
        // Memastikan hanya transaksi pending yang bisa disetujui
        if ($transaction->status === 'pending') {
            $transaction->update(['status' => 'success']);
            
            return back()->with('success', 'Penarikan dana berhasil disetujui dan ditandai selesai. Saldo penjual telah diperbarui.');
        }

        return back()->with('error', 'Status penarikan tidak valid atau sudah diproses sebelumnya.');
    }
}