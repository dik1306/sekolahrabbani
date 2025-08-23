<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiayaSPMB extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'tbl_biaya_spmb';

    // Menentukan kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'tahun_ajaran_id',
        'telp_id',
        'biaya',
        'created_at',
        'updated_at',
    ];

    // Menentukan kolom yang tidak boleh diubah (protected)
    protected $guarded = ['id'];

    // Jika Anda menggunakan timestamp otomatis
    public $timestamps = true;

    // Relasi dengan tabel master_tahun_ajaran
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaranAktif::class, 'tahun_ajaran_id');
    }

    // Relasi dengan tabel tbl_telp
    public function telp()
    {
        return $this->belongsTo(ContactPerson::class, 'telp_id');
    }
}
