<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    
    // Tambahkan order_id dan review_photo di sini
    protected $fillable = ['user_id', 'product_id', 'order_id', 'rating', 'comment', 'review_photo'];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function product() {
        return $this->belongsTo(Product::class);
    }
    public function order() {
        return $this->belongsTo(Order::class);
    }
}