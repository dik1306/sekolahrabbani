<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchandise extends Model
{
    use HasFactory;
    protected $table = 'm_merchandise';

    protected $fillable = [
        'kode',
        'nama_produk',
        'ukuran',
        'jenis_id',
        'warna',
        'deskripsi',
        'harga_awal',
        'diskon',
        'image_1',
        'image_2',
        'image_3',
        'created_at'
    ];

    public function jenis_merch()
    {
        return $this->belongsTo(JenisMerchandise::class, 'jenis_id', 'id');
    }

    public static function get_jenis () {
        $data = static::with(['jenis_merch'])
                ->select('*')
                ->get();
    
        return $data;
    }
}
