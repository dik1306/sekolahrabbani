<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKontrak extends Model
{
    use HasFactory;
    protected $table = 'm_jadwal_kontrak';

    protected $fillable = [
        'nama',
        'status',
        'file',
        'created_by',
    ];
}
