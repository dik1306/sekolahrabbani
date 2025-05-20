<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokSeragam extends Model
{
    use HasFactory;
    protected $table = 't_stok_seragam';
    protected $primaryKey = 'id';

    protected $fillable = [
        'kd_barang',
        'qty',
        'barcode_15'
    ];
}
