<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PertanyaanPerkembangan extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan oleh model ini
    protected $table = 'tbl_pertanyaan_perkembangan';

    // Tentukan kolom-kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'kode_perkembangan',
        'urutan',
        'head_id',
        'pertanyaan',
        'need_option',
        'need_extra',
        'is_extra_required',
        'options_data',
        'extra_data',
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
        'need_option' => 'boolean',
        'is_aktif' => 'boolean',
    ];

    // Relasi dengan tabel HeadPerkembangan
    public function headPerkembangan()
    {
        return $this->belongsTo(HeadPerkembangan::class, 'head_id');
    }
}
