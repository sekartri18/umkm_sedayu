<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.category.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:10' // Untuk emoji
        ]);

        Category::create($request->all());
        return back()->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:10'
        ]);

        $category->update($request->all());
        return redirect()->route('admin.category.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Category $category)
    {
        // Cegah penghapusan jika kategori ini sedang dipakai oleh UMKM
        if($category->umkms()->count() > 0) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih digunakan oleh UMKM.');
        }

        $category->delete();
        return back()->with('success', 'Kategori berhasil dihapus!');
    }
}