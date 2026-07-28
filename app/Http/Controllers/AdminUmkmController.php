<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use Illuminate\Http\Request;

class AdminUmkmController extends Controller
{
    public function index()
    {
        $umkms = Umkm::latest()->get();
        return view('admin.umkm.index', compact('umkms'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,suspended'
        ]);

        $umkm = Umkm::findOrFail($id);
        $umkm->update(['status' => $request->status]);

        return back()->with('success', 'Status UMKM ' . $umkm->name . ' berhasil diperbarui menjadi ' . strtoupper($request->status));
    }
}