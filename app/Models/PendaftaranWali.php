<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranWali extends Model
{
    use HasFactory;
    protected $table = 'tbl_wali';

    protected $fillable = [
        'id_wali',
        'nama',
        'tptlahir_wali',
        'tgllahir_wali',
        'pekerjaan_jabatan',
        'pendidikan_wali',
        'hubungan_wali'
    ];

    public static function get_profile($id)
    {
        $data = static::where('id_wali', $id)
            ->first();

        return $data;

    }
}
