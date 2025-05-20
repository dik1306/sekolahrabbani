<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartJersey extends Model
{
    use HasFactory;
    protected $table = 't_cart_jersey';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'jersey_id',
        'nis',
        'nama_punggung',
        'no_punggung',
        'quantity',
        'status_cart',
        'is_selected',
        'ukuran_id'
    ];
}
