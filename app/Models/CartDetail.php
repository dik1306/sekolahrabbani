<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    use HasFactory;
    protected $table = 't_cart_detail';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'produk_id',
        'cart_id',
        'quantity',
        'nis',
        'ukuran',
        'jenis',
        'kode_produk',
        'status_cart',
        'is_selected'
    ];
}
