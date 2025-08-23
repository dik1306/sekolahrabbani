<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilPengasuhan extends Model
{
    use HasFactory;

    // Tentukan nama tabel
    protected $table = 'tbl_hasil_pengasuhan';

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

    // Tentukan relasi dengan model PertanyaanPengasuhan (tbl_pertanyaan_pengasuhan)
    public function pertanyaan()
    {
        return $this->belongsTo(PertanyaanPengasuhan::class, 'id_pertanyaan');
    }
}
