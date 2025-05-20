<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramReg extends Model
{
    use HasFactory;
    protected $table = 'tbl_program_reg';

    protected $fillable = [
        'id_anak',
        'orientasi_peserta_didik',
        'bersedia_mengikuti_qp',
        'mengikuti_pertemuan_rutin',
        'menemani_ananda',
        'kewirausahaan_ananda',
        'kemampuan_komunikasi_aktif_ananda',
        'pembiayaan_pendidikan',
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
