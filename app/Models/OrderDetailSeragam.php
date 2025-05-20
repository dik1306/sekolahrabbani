<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetailSeragam extends Model
{
    use HasFactory;
    protected $table = 't_pesan_seragam_detail';
    protected $primaryKey = 'id';

    protected $fillable = [
        'pesan_seragam_id',
        'no_pemesanan',
        'nama_siswa',
        'lokasi_sekolah',
        'nama_kelas',
        'produk_id',
        'jenis_produk_id',
        'ukuran',
        'kode_produk',
        'quantity',
        'harga',
        'diskon',
        'status', 
        'snap_token',
        'p_diskon',
        'hpp',
        'ppn'
    ];

    public function order_seragam()
    {
        return $this->belongsTo(OrderSeragam::class, 'no_pemesanan', 'id');
    }

    public static function get_detail_produk ($id) {
        $data = OrderDetailSeragam::select('t_pesan_seragam_detail.*', 'm_produk_seragam.*' )
                ->leftJoin('m_produk_seragam', 't_pesan_seragam_detail.produk_id', 'm_produk_seragam.id')
                ->where('t_pesan_seragam_detail.no_pemesanan', $id)
                ->get();
        return $data;
    }
}
