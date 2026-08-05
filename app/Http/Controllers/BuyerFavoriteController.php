<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyerFavoriteController extends Controller
{
    public function index()
    {
        $favorites = Auth::user()
            ->favoriteProducts()
            ->with('umkm')
            ->orderByDesc('favorite_products.created_at')
            ->get();

        return view('buyer.favorites', compact('favorites'));
    }

    public function toggle(Product $product)
    {
        $user = Auth::user();

        if ($user->favoriteProducts()->whereKey($product->id)->exists()) {
            $user->favoriteProducts()->detach($product->id);

            return back()->with('success', 'Barang dihapus dari favorit.');
        }

        $user->favoriteProducts()->syncWithoutDetaching([$product->id]);

        return back()->with('success', 'Barang berhasil ditambahkan ke favorit.');
    }

    public function destroy(Product $product)
    {
        Auth::user()->favoriteProducts()->detach($product->id);

        return back()->with('success', 'Barang dihapus dari favorit.');
    }
}
