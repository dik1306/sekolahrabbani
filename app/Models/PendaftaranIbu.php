<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranIbu extends Model
{
    use HasFactory;
    protected $table = 'tbl_ibu';

    protected $fillable = [
        'id_ibu',
        'nama',
        'tptlahir_ibu',
        'tgllahir_ibu',
        'pekerjaan_jabatan',
        'pendidikan_ibu',
        'penghasilan'
    ];

    public static function get_profile($id)
    {
        $data = static::where('id_ibu', $id)
            ->first();

        return $data;

    }
}
