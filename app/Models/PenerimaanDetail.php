<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PenerimaanDetail extends Model
{
    use HasFactory;
    protected $table = 't_penerimaan_detail';
    protected $primaryKey = 'id';

    public static function get_bayar_by_nis($nis) {
        $data = PenerimaanDetail::select('t_penerimaan_detail.*', 't_tagihan.jenis_penerimaan', 't_tagihan.bulan_pendapatan', 'm_profile.nama_lengkap')
        ->leftJoin('t_tagihan', 't_penerimaan_detail.id_tagihan', 't_tagihan.id')
        ->leftJoin('m_profile', 't_penerimaan_detail.nis', 'm_profile.nis')
        ->whereIn('t_penerimaan_detail.nis', $nis)
        ->get();

        return $data;
    }

    public static function grup_detail($id) {
        $data = PenerimaanDetail::select('t_penerimaan_detail.*', 'm_profile.nama_lengkap',  DB::raw('sum(nilai_bayar) as total_bayar'))
                ->leftJoin('m_profile', 't_penerimaan_detail.nis', 'm_profile.nis')
                ->where('no_penerimaan', $id)
                ->groupBy('no_penerimaan')
                ->get();

        return $data;
    }
}
