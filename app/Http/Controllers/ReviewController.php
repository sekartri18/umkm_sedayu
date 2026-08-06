<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'review_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'review_video' => 'nullable|file|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/webm|max:5120',
        ]);

        // Pastikan pesanan ini benar-benar milik user yang sedang login
        $validOrder = Order::where('id', $request->order_id)
            ->where('user_id', Auth::id())
            ->exists();

        if (!$validOrder) {
            return back()->with('error', 'Akses ditolak. Pesanan tidak valid.');
        }

        $review = Review::firstOrNew([
            'user_id' => Auth::id(),
            'product_id' => $productId,
            'order_id' => $request->order_id,
        ]);

        if ($request->hasFile('review_photo')) {
            if ($review->review_photo) {
                Storage::disk('public')->delete($review->review_photo);
            }
            $review->review_photo = $request->file('review_photo')->store('reviews', 'public');
        }

        if ($request->hasFile('review_video')) {
            if ($review->review_video) {
                Storage::disk('public')->delete($review->review_video);
            }
            $review->review_video = $request->file('review_video')->store('reviews', 'public');
        }

        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->user_id = Auth::id();
        $review->product_id = $productId;
        $review->order_id = $request->order_id;
        $review->save();

        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil disimpan.');
    }
}