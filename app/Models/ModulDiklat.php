<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModulDiklat extends Model
{
    use HasFactory;
    protected $table = 'm_modul_diklat';

    protected $fillable = [
        'judul_modul',
        'deskripsi_modul',
        'file_modul',
        'status_modul',
        'kelas_diklat_id'
    ];

    public function kelas()
    {
        return $this->belongsTo(KelasDiklat::class, 'kelas_diklat_id');
    }

    public function tugas () {

        return $this->hasOne(TugasDiklat::class, 'id');
    }

    public static function get_modul_with_tugas () {
        $data = static::with(['tugas'])->get();

        return $data;
    }
}
