<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasJenjangSekolah extends Model
{
    use HasFactory;
    protected $table = 'm_kelas_jenjang_sekolah';
    protected $primaryKey = 'id';

    public function jenjang() {
        return $this->belongsTo(Jenjang::class, 'jenjang_id', 'id');
    }

    public function kelas() {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }

    public static function get_kelas_jenjang ($kode, $jenjang_id) {
        $data = static::with('kelas')
                        ->where('kode_sekolah', $kode)
                        ->where('jenjang_value', $jenjang_id)
                        ->get();

        return $data;
    }

    public static function get_kelas_smp ($kode) {
        $data = static::with('kelas')
                        ->where('kode_sekolah', $kode)
                        ->get();

        return $data;
    }
}
