<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Umkm;

class AdminUmkmController extends Controller
{
    public function index()
    {
        // Mengambil semua data UMKM, diurutkan dari yang terbaru
        $umkms = Umkm::with('category')->latest()->get();
        
        return view('admin.umkm.index', compact('umkms'));
    }
}