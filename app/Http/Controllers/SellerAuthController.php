<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Umkm;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SellerAuthController extends Controller
{
    // Menampilkan halaman form pendaftaran
    public function create()
    {
        $categories = Category::all();
        return view('auth.register-penjual', compact('categories'));
    }

    // Memproses data pendaftaran
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'umkm_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'whatsapp_number' => 'required|string|max:20',
            'address' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        // 2. Buat Akun (Otomatis dapat role 'penjual')
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'penjual',
        ]);

        // 3. Buat Profil Toko (UMKM) disambungkan ke Akun tadi
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('umkm', 'public');
        }

        Umkm::create([
            'user_id' => $user->id,
            'category_id' => $request->category_id,
            'name' => $request->umkm_name,
            'owner_name' => $request->name,
            'whatsapp_number' => $request->whatsapp_number,
            'address' => $request->address,
            'image' => $imagePath,
        ]);

        // 4. Langsung Login-kan pengguna baru tersebut
        Auth::login($user);

        // Arahkan ke Dashboard
        return redirect('/dashboard');
    }
}