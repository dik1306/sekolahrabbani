<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenjangSekolah extends Model
{
    use HasFactory;
    protected $table = 'm_jenjang_per_sekolah';
    protected $primaryKey = 'id';

    public function jenjang() {
        return $this->belongsTo(Jenjang::class, 'jenjang_id', 'id');
    }

    public static function get_jenjang ($kode) {
        $data = static::with('jenjang')->where('kode_sekolah', $kode)->get();

        return $data;
    }
}
