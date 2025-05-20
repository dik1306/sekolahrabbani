<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $table = 'm_kelas';
    protected $primaryKey = 'id';

    public function kelas_sekolah () {
        return $this->hasMany(KelasJenjangSekolah::class, 'kelas_id', 'id');

    }
}
