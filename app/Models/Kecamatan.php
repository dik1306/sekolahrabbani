<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;
    protected $table = 'mst_kecamatan';
    protected $primaryKey = 'id';

    public static function kecamatan_with_kota()
    {
        $data = Kecamatan::select('mst_kecamatan.*', 'mst_kota.*', 'mst_kecamatan.id as id_kecamatan')
                        ->leftjoin('mst_kota', 'mst_kecamatan.kabkot_id', 'mst_kota.id')
                        ->get();

        return $data;
    }
}
