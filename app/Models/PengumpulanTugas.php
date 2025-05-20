<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengumpulanTugas extends Model
{
    use HasFactory;
    protected $table = 't_pengumpulan_tugas';

    protected $fillable = [
        'user_id',
        'kode_csdm',
        'tugas_id',
        'status',
        'file'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');

    }

    public static function get_kumpul_tugas_with_user () {
        $data = static::with(['user'])
                ->select('id', 'user_id', 'tugas_id', 'file', 'updated_at')
                ->groupBy('user_id', 'tugas_id')
                ->orderBy('updated_at', 'desc')
                ->get();
    

        return $data;
    }
 
}
