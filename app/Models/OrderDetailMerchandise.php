<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetailMerchandise extends Model
{
    use HasFactory;
    protected $table = 't_pesan_merchandise_detail';
    protected $primaryKey = 'id';

    protected $fillable = [
        'no_pesanan',
        'nama_siswa',
        'lokasi_sekolah',
        'nama_kelas',
        'merchandise_id',
        'design_id',
        'ukuran_id',
        'warna_id',
        'kategori_id',
        'jenis_id',
        'template_id',
        'kode',
        'quantity',
        'harga',
        'diskon',
        'persen_diskon',
        'hpp'
    ];

}
