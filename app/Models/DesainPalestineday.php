<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesainPalestineday extends Model
{
    use HasFactory;
    protected $table = 't_desain_palestineday';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nis',
        'nama_siswa',
        'sekolah_id',
        'nama_kelas',
        'image_file',
        'updated_by'
    ];


}
