<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetailJersey extends Model
{
    use HasFactory;
    protected $table = 't_pesan_jersey_detail';
    protected $primaryKey = 'id';

    protected $fillable = [
        'no_pesanan',
        'nama_siswa',
        'lokasi_sekolah',
        'nama_kelas',
        'jersey_id',
        'ukuran_id',
        'kode',
        'quantity',
        'harga',
        'diskon',
        'persen_diskon',
        'no_punggung',
        'nama_punggung',
        'hpp'
    ];
}
