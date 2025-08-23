<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilPerkembangan extends Model
{
    use HasFactory;

    // Tentukan nama tabel
    protected $table = 'tbl_hasil_perkembangan';

    // Tentukan kolom yang bisa diisi
    protected $fillable = [
        'id_anak',
        'id_pertanyaan',
        'jawaban',
    ];

    // Tentukan apakah kolom jawaban akan disimpan sebagai JSON
    protected $casts = [
        'jawaban' => 'array',
    ];

    // Tentukan relasi dengan model Anak (tbl_anak)
    public function anak()
    {
        return $this->belongsTo(Pendaftaran::class, 'id_anak');
    }

    // Tentukan relasi dengan model PertanyaanPerkembangan (tbl_pertanyaan_perkembangan)
    public function pertanyaan()
    {
        return $this->belongsTo(PertanyaanPerkembangan::class, 'id_pertanyaan');
    }
}
