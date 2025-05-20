<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tagihan extends Model
{
    use HasFactory;
    protected $table = 't_tagihan';
    protected $primaryKey = 'id';

    protected $fillable = [
       'id', 
       'nis',
       'jenis_penerimaan',
       'tahun',
       'tgl_tagihan',
       'status',
       'nilai_tagihan',
       'bulan_pendapatan'
    ];

    public static function get_tagihan_bdu_by_nis($nis) {
        $data = Tagihan::select('t_tagihan.*', 'm_profile.nama_lengkap')
                    ->leftJoin('m_profile', 't_tagihan.nis', 'm_profile.nis')
                    ->where('jenis_penerimaan', 'bdu')
                    ->whereIn('t_tagihan.nis', $nis)
                    ->where('status', 1)
                    ->get();

        return $data;
    }

    public static function get_tagihan_spp_by_nis($nis) {
        $data = static::selectRaw('id as no_tagihan, nis, jenis_penerimaan, nilai_tagihan, bulan_pendapatan')
                    ->where('jenis_penerimaan', 'spp')
                    ->whereIn('nis', $nis)
                    ->where('status', 1)
                    ->get();

        return $data;
    }

    public static function get_spp_lunas_by_nis($nis) {
        $data = static::selectRaw('id as no_tagihan, nis, jenis_penerimaan, nilai_tagihan, bulan_pendapatan')
                    ->where('jenis_penerimaan', 'spp')
                    ->whereIn('nis', $nis)
                    ->where('status', 2)
                    ->get();

        return $data;
    }

    public static function total_tunggakan_by_nis($nis) {

        $last_3_month = date("Y-m", strtotime(date("Y-m") . " -3 months"));
        $data = Tagihan::select('t_tagihan.*', 'm_profile.nama_lengkap', DB::raw('sum(nilai_tagihan) as total_tunggakan'))
                    ->leftJoin('m_profile', 't_tagihan.nis', 'm_profile.nis')
                    ->whereIn('t_tagihan.nis', $nis)   
                    ->where('status', 1)
                    // ->where('bulan_pendapatan', '!=', '')
                    ->whereRaw("CONCAT(bulan_pendapatan,'-10') <= CURDATE()")
                    ->groupBy('t_tagihan.nis')
                    ->get();

        return $data;
    }

    public static function total_tagihan_by_nis($nis) {
        $this_month = date("Y-m", strtotime(date("Y-m")));
        $data = Tagihan::select('t_tagihan.*', 'm_profile.nama_lengkap', DB::raw('sum(nilai_tagihan) as total_tagihan'))
                    ->leftJoin('m_profile', 't_tagihan.nis', 'm_profile.nis')
                    ->whereIn('t_tagihan.nis', $nis)   
                    ->where('status', 1)
                    ->where('bulan_pendapatan', '!=', '')
                    ->where('bulan_pendapatan', $this_month)
                    ->groupBy('t_tagihan.nis')
                    ->get();

        return $data;
    }

    public static function get_tunggakan_spp_by_nis($nis) {
        $data = Tagihan::select('t_tagihan.*', 'm_profile.nama_lengkap', DB::raw('sum(nilai_tagihan) as lunas_spp') )
                ->leftJoin('m_profile', 't_tagihan.nis', 'm_profile.nis')
                ->whereIn('t_tagihan.nis', $nis)
                ->where('status', 2)
                ->where('jenis_penerimaan', 'spp')
                ->groupBy('t_tagihan.nis')
                ->get();
        return $data;
    }
    
    public static function get_tunggakan_by_nis($nis) {
        $last_3_month = date("Y-m", strtotime(date("Y-m") . " -3 months"));
        $data = Tagihan::select('t_tagihan.*', 'm_profile.nama_lengkap', 't_tagihan.id as no_tagihan')
                    ->leftJoin('m_profile', 't_tagihan.nis', 'm_profile.nis')
                    ->whereIn('t_tagihan.nis', $nis)   
                    ->where('status', 1)
                    ->whereRaw("CONCAT(bulan_pendapatan,'-10') <= CURDATE()")
                    ->get();

        return $data;
    }

    public static function get_tagihan_by_nis($nis) {
        $this_month = date("Y-m", strtotime(date("Y-m")));
        $data = Tagihan::select('t_tagihan.*', 'm_profile.nama_lengkap', 't_tagihan.id as no_tagihan')
                    ->leftJoin('m_profile', 't_tagihan.nis', 'm_profile.nis')
                    ->whereIn('t_tagihan.nis', $nis)   
                    ->where('status', 1)
                    ->where('bulan_pendapatan', '!=', '')
                    ->where('bulan_pendapatan', $this_month)
                    ->get();

        return $data;
    }


    public static function get_lunas_by_nis($nis) {
        $data = static::selectRaw('id as no_tagihan, nis, jenis_penerimaan, nilai_tagihan, bulan_pendapatan')
                ->where('status', 2)
                ->whereIn('nis', $nis)
                ->orderBy('bulan_pendapatan', 'DESC')
                ->get();

        return $data;
    }
}
