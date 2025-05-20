<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokCard extends Model
{
    use HasFactory;
    protected $table = 't_stok_card_seragam';

    protected $fillable = [
        'kd_gudang',
        'kd_barang',
        'stok_awal',
        'qty',
        'stok_akhir',
        'proses',
        'no_proses',
        'created_at',
        'updated_at',
        'updateby'
    ];
}
