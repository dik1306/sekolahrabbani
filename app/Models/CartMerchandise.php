<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartMerchandise extends Model
{
    use HasFactory;

    protected $table = 't_cart_merchandise';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'merchandise_id',
        'quantity',
        'status_cart',
        'is_selected',
        'design_id',
        'ukuran_id',
        'warna_id',
        'template_id',
        'jenis_id',
        'kategori_id'
    ];
}
