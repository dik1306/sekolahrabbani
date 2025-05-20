<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPenerimaan extends Model
{
    use HasFactory;
    protected $table = 'm_jenis_penerimaan';
    protected $primaryKey = 'id';
}
