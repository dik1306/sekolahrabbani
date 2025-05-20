<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasDiklat extends Model
{
    use HasFactory;
    protected $table = 'm_tugas_diklat';

    protected $fillable = [
        'judul_tugas',
        'deskripsi_tugas',
        'file_tugas',
        'status_tugas',
        'modul_id',
        'deadline_tugas'
    ];

    public function modul() {
        return $this->belongsTo(ModulDiklat::class, 'modul_id');
    }
}
