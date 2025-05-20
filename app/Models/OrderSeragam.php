<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderSeragam extends Model
{
    use HasFactory;
    protected $table = 't_pesan_seragam';
    protected $primaryKey = 'id';

    protected $fillable = [
        'no_pemesanan',
        'no_hp',
        'nama_pemesan',
        'status',
        'total_harga',
        'snap_token',
        'user_id',
        'metode_pembayaran',
        'va_number',
        'expire_time',
        'updated_at'
    ];

    public function order_detail() {
        return $this->hasMany(OrderDetailSeragam::class, 'id', 'no_pemesanan');
    }

    public static function get_order_with_detail ($user_id) {
        $data = static::with('order_detail')
                    ->where('user_id', $user_id)
                    ->get();

        return $data;
    }
}
