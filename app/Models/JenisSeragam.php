<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSeragam extends Model
{
    use HasFactory;
    protected $table = 'm_jenis_produk_seragam';
    protected $primaryKey = 'id';
}
