<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    use HasFactory;

    // Mengizinkan semua kolom diisi secara massal (mass-assignment)
    protected $guarded = [];

    // Definisi relasi: Sebuah UMKM dimiliki oleh 1 Kategori (BelongsTo)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}