<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;
    protected $table = 'm_lokasi_sekolah';
    protected $primaryKey = 'id';

    public static function get_sekolah_by_code ($code) {
        $data = static::where('kode_sekolah', $code)
            ->get();

        return $data;
    }
}
