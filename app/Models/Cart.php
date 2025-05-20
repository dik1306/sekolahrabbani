<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 't_cart';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
    ];
}
