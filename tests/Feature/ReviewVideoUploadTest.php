<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('allows a buyer to upload a review video up to 5mb', function () {
    Storage::fake('public');

    $user = User::factory()->create([
        'role' => 'buyer',
    ]);

    $umkm = Umkm::factory()->create();
    $product = Product::factory()->create([
        'umkm_id' => $umkm->id,
    ]);
    $order = Order::factory()->create([
        'user_id' => $user->id,
    ]);

    $video = UploadedFile::fake()->create('review-video.mp4', 1024, 'video/mp4');

    $response = $this->actingAs($user)
        ->post(route('reviews.store', $product->id), [
            'order_id' => $order->id,
            'rating' => 5,
            'comment' => 'Produk ini bagus sekali',
            'review_video' => $video,
        ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');

    $review = Review::where('product_id', $product->id)
        ->where('user_id', $user->id)
        ->where('order_id', $order->id)
        ->first();

    expect($review)->not->toBeNull();
    expect($review->review_video)->not->toBeNull();
    Storage::disk('public')->assertExists($review->review_video);
});
