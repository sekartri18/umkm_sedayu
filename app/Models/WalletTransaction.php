<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'umkm_id', 'order_id', 'type', 'amount', 'status', 'description'
    ];

    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}