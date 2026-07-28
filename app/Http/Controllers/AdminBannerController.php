<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminBannerController extends Controller
{
    public function index()
    {
        $banners = Banner::latest()->get();
        return view('admin.banner.index', compact('banners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // Maksimal 2MB
        ]);

        $imagePath = $request->file('image')->store('banners', 'public');

        Banner::create([
            'title' => $request->title,
            'image' => $imagePath,
        ]);

        return back()->with('success', 'Banner promosi berhasil ditambahkan!');
    }

    public function destroy(Banner $banner)
    {
        // Hapus file fisik dari storage
        if (Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }
        
        $banner->delete();
        return back()->with('success', 'Banner berhasil dihapus!');
    }
}