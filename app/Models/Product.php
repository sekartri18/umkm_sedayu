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
}