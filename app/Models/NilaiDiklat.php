<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiDiklat extends Model
{
    use HasFactory;
    protected $table = 't_nilai_diklat';

    protected $fillable = [
        'id_profile_csdm',
        'kode_csdm',
        'file_nilai',
    ];

    public function profile_csdm() {
        return $this->belongsTo(Csdm::class, 'id_profile_csdm');
    }

    public static function get_nilai_with_profile () {
        $data = static::with('profile_csdm')->get();

        return $data;
    }

}
