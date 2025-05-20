<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EdukasiQurban extends Model
{
    use HasFactory;
    protected $table = 'm_edukasi_qurban';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'judul',
        'image',
        'link_video',
        'deskripsi',
        'style',
        'status',
        'terbit',
        'link_evaluasi',
        'jenjang',
        'created_by',
        'design_by',
        'updated_by',
    ];
}
