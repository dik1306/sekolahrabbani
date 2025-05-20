<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Angket extends Model
{
    use HasFactory;
    protected $table = 'tbl_angket';

    protected $fillable = [
        'id_anak',
        'mengenal_hijaiyah',
        'mengenal_alphabet',
        'suka_menulis',
        'suka_menggambar',
        'hafalan_alquran',
        'memiliki_hafalan',
        'senang_bergaul',
        'membuat_prakarya',
        'ungkapan_keinginan',
        'mengikuti_sholat',
        'berbicara_baik',
        'memakai_baju_sendiri',
        'menyimpan_sepatu',
        'membuang_sampah',
        'mengekspresikan',
        'melakukan_kesalahan',
        'ketergantungan',
        'keinginan',
        'mampu_mandi',
        'mampu_sendiri',
        'menghabiskan_waktu',
        'kelebihan_ananda',
        'updatedate',
        'updateby'

    ];


    public static function get_profile($id)
    {
        $data = static::where('id_anak', $id)
            ->first();

        return $data;

    }
}
