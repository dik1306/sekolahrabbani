<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderMerchandise extends Model
{
    use HasFactory;
    protected $table = 't_pesan_merchandise';
    protected $primaryKey = 'id';

    protected $fillable = [
        'no_pesanan',
        'no_hp',
        'nama_pemesan',
        'status',
        'total_harga',
        'snap_token',
        'user_id',
        'metode_pembayaran',
        'va_number',
        'expire_time',
        'updated_at'
    ];
}
