<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaSeragam extends Model
{
    use HasFactory;
    protected $table = 'm_harga_seragam';
    protected $primaryKey = 'id';

    protected $fillable = [
        'produk_id',
        'jenis_produk_id',
        'ukuran_id',
        'harga',
        'diskon',
        'kode_produk',
        'stok',
        'style_produk',
        'status_item'
    ];
}
