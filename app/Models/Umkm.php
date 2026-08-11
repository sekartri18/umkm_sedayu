<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    use HasFactory;

    // Menggunakan $fillable jauh lebih aman daripada $guarded = [] 
    // untuk mencegah manipulasi data (Mass-Assignment Vulnerability)
    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'owner_name',    // <-- Baris ini yang ditambahkan agar data bisa masuk
        'whatsapp_number',
        'address',
        'maps_link',     // Link Google Maps
        'image',
        'status',        // Kolom verifikasi Admin (pending, approved, suspended)
        'bank_name',      // Nama Bank
        'bank_account',   // Nomor Rekening Bank    
        'bank_owner',     // Nama Pemilik Rekening Bank
    ];

    public function setWhatsappNumberAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['whatsapp_number'] = null;
            return;
        }

        $number = preg_replace('/[^0-9+]/', '', $value);

        if (str_starts_with($number, '+')) {
            $number = substr($number, 1);
        }

        if (str_starts_with($number, '0')) {
            $number = '62' . substr($number, 1);
        }

        $this->attributes['whatsapp_number'] = $number;
    }

    // Definisi relasi: Sebuah UMKM dimiliki oleh 1 Kategori (BelongsTo)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi Riwayat Transaksi Keuangan
    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }
}