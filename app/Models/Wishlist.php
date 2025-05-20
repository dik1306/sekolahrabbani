<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;
    protected $table = 't_wishlist_seragam';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'produk_id',
        'quantity',
        'ukuran',
        'jenis',
        'kode_produk',
        'status_wl',
        'nis'
    ];
}
