<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeadPengasuhan extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan oleh model ini
    protected $table = 'tbl_head_pengasuhan';

    // Tentukan kolom-kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'head_name',
        'subhead_name',
        'jenjang',
        'is_aktif'
    ];

    // Tentukan kolom yang tidak boleh diubah (guarded)
    protected $guarded = ['id', 'created_at', 'updated_at'];

    // Tentukan format tanggal (jika perlu)
    protected $dates = ['created_at', 'updated_at'];

    // Atur timestamps
    public $timestamps = false; // Karena kita menggunakan timestamp manual (created_at, updated_at)

    // Jika Anda ingin mengonversi nilai boolean ke tipe PHP yang sesuai
    protected $casts = [
        'is_aktif' => 'boolean',
    ];
}
