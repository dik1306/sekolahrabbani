<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HaveRead extends Model
{
    use HasFactory;
    protected $table = 't_sudah_baca_materi';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'user_name',
        'materi_id',
        'nis',
        'created_at'
    ];
}
