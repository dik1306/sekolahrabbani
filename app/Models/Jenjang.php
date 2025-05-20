<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenjang extends Model
{
    use HasFactory;
    protected $table = 'm_jenjang';
    protected $primaryKey = 'id';

    public function jenjang_sekolah () {
        return $this->hasMany(JenjangSekolah::class, 'jenjang_id', 'id');

    }

    public static function jenjang_sekolah_sub_lokasi($jenjang) 
    {
        $data = Jenjang::select('m_jenjang.id', 'm_jenjang.nama_jenjang', 'jps.kode_sekolah', 'ls.nama_sekolah', 'ls.image', 'ls.lokasi', 'ls.alamat' )
                        ->leftjoin('m_jenjang_per_sekolah as jps', 'm_jenjang.id', 'jps.jenjang_id')
                        ->leftjoin('m_lokasi_sekolah as ls', 'jps.kode_sekolah', 'ls.kode_sekolah')
                        ->where('ls.status', 1)
                        ->where('m_jenjang.nama_jenjang', $jenjang)
                        ->get();

        return $data;
    }
}
