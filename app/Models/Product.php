<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Mengizinkan mass-assignment
    protected $guarded = [];

    // Relasi: Produk dimiliki oleh satu UMKM
    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}