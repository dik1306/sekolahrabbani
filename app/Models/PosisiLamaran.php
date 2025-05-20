<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosisiLamaran extends Model
{
    use HasFactory;
    protected $table = 'm_posisi_lamaran';
    

    protected $fillable = [
        'posisi_dilamar',
        'tingkat_jabatan',
        'divisi',
        'id_lokasi',
        'status'
    ];
}
