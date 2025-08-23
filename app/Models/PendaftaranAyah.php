<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranAyah extends Model
{
    use HasFactory;
    protected $table = 'tbl_ayah';

    protected $fillable = [
        'id_ayah',
        'nama',
        'email_ayah'
        'tptlahir_ayah',
        'tgllahir_ayah',
        'pekerjaan_jabatan',
        'pendidikan_ayah',
        'penghasilan'
    ];

    public static function get_profile($id)
    {
        $data = static::where('id_ayah', $id)
            ->first();

        return $data;

    }
}
