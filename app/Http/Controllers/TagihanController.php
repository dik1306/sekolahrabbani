<?php

namespace App\Http\Controllers;

use App\Models\JenisPenerimaan;
use App\Models\Lokasi;
use App\Models\PenerimaanDetail;
use App\Models\Profile;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        $get_nis =  Profile::select('nis')->where('user_id', $user_id)->get();

        $nis = $get_nis->toArray();

        $jenis_penerimaan = JenisPenerimaan::where('status', 1)->get();

        $getMonth = [];
        foreach (range(1, 12) as $m) {
            $getMonth[] = date('F', mktime(0, 0, 0, $m, 1));
        }

        $bulan_periode = $request->bulan_periode ?? null;
        $tahun_periode = $request->tahun_periode ?? null;
        $jenis = $request->jenis_penerimaan ?? null;

        if ($request->has('bulan_periode') || $request->has('tahun_periode') || $request->has('jenis_penerimaan')) {
            $tagihan = Tagihan::query();
            $lunas = Tagihan::query();

            if ($request->has('bulan_periode')) 
            $tagihan = $tagihan->selectRaw('id as no_tagihan, nis, jenis_penerimaan, nilai_tagihan, bulan_pendapatan')->where('bulan_pendapatan', 'like', '%' .$request->bulan_periode)->whereIn('nis', $nis)->where('status', 1);
            $lunas = $lunas->selectRaw('id as no_tagihan, nis, jenis_penerimaan, nilai_tagihan, bulan_pendapatan')->where('bulan_pendapatan', 'like', '%' .$request->bulan_periode)->whereIn('nis', $nis)->where('status', 2);
            
            if ($request->has('tahun_periode')) 
            $tagihan = $tagihan->selectRaw('id as no_tagihan, nis, jenis_penerimaan, nilai_tagihan, bulan_pendapatan')->where('bulan_pendapatan', 'like', '%' .$request->tahun_periode.'%')->whereIn('nis', $nis)->where('status', 1);
            $lunas = $lunas->selectRaw('id as no_tagihan, nis, jenis_penerimaan, nilai_tagihan, bulan_pendapatan')->where('bulan_pendapatan', 'like', '%' .$request->tahun_periode.'%')->whereIn('nis', $nis)->where('status', 2);
            
            if ($request->has('jenis_penerimaan')) 
            $tagihan = $tagihan->selectRaw('id as no_tagihan, nis, jenis_penerimaan, nilai_tagihan, bulan_pendapatan')->where('jenis_penerimaan', 'like', '%' .$request->jenis_penerimaan.'%')->whereIn('nis', $nis)->where('status', 1);
            $lunas = $lunas->selectRaw('id as no_tagihan, nis, jenis_penerimaan, nilai_tagihan, bulan_pendapatan')->where('jenis_penerimaan', 'like', '%' .$request->jenis_penerimaan.'%')->whereIn('nis', $nis)->where('status', 2);
            
            $tagihan = $tagihan->get();
            $lunas = $lunas->get();
            // dd($lunas, $tagihan);
        } else {
            $tagihan = Tagihan::get_tunggakan_by_nis($nis);
            $lunas = Tagihan::get_lunas_by_nis($nis);

        }

        return view('admin.tagihan.index', compact( 'getMonth', 'tagihan', 'lunas', 'bulan_periode', 'tahun_periode', 'jenis_penerimaan', 'jenis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function show(Tagihan $tagihan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function edit(Tagihan $tagihan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tagihan $tagihan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tagihan $tagihan)
    {
        //
    }

    public function bukti_bayar (Request $request, $id) 
    {
        $lokasi = PenerimaanDetail::where('no_penerimaan', $id)->first();
        $profil_sekolah = Lokasi::get_sekolah_by_code($lokasi->id_lokasi);
        // dd($profil_sekolah);
        $grup_data = PenerimaanDetail::grup_detail($id);
        // dd($grup_data);

        return view('admin.tagihan.bukti-bayar', compact('profil_sekolah', 'grup_data'));
    }
}
