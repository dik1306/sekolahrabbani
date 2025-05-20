<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasDiklat extends Model
{
    use HasFactory;
    protected $table = 'm_kelas_diklat';

    protected $fillable = [
        'pertemuan',
        'forum_link',
        'status_kelas',
        'deskripsi_kelas',
        'tgl_buka_kelas',
        'jam_buka_kelas',
        'jam_selesai'
    ];

    public function modul()
    {
        return $this->hasMany(ModulDiklat::class, 'kelas_diklat_id');
    }

    

    public static function get_kelas_per_pertemuan($pertemuan)
    {
        return KelasDiklat::where('pertemuan', $pertemuan)->get();
    }

    public static function get_kelas_with_modul ($pertemuan) {
        $data = static::with(['modul.tugas'])
                ->where('pertemuan', $pertemuan)        
                ->get();

        return $data;
    }

    public static function get_kelas_aktif () {
        $data = static::where('status_kelas', 1)->get();

        return $data;
    }
}
