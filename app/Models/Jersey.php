<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jersey extends Model
{
    use HasFactory;
    protected $table = 'm_jersey';
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode',
        'nama_jersey',
        'deskripsi',
        'harga_awal',
        'persen_diskon',
        'image_1',
        'image_2',
        'image_3',
        'image_4',
        'image_5',
        'image_6',
        'image_7',
        'jenis_kelamin',
        'jenjang_id',
        'ekskul_id',
        'status',
        'created_at'
    ];
}
