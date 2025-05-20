<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisEkskul extends Model
{
    use HasFactory;
    protected $table = 'm_jenis_ekskul';
    protected $primaryKey = 'id';

    protected $fillable = [
        'ekskul',
        'status',
    ];

}
