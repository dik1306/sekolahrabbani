<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Csdm extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_csdm',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tgl_lahir',
        'posisi_dilamar',
        'domisili_sekarang',
        'foto_profile',
    ];
    protected $table = 'm_profile_csdm';
    protected $primaryKey = 'id';

    public function user()
    {
        return $this->hasOne(User::class, 'id_profile_csdm', 'id');
    }

    public function nilai_diklat () 
    {
        return $this->hasOne(NilaiDiklat::class, 'id_profile_csdm', 'id');

    }

    public static function get_all()
    {
        $data = static::with('user')->get();

        return $data;
    }
}
