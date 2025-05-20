<?php

namespace App\Http\Controllers;

use App\Models\MenuMobile;
use App\Models\PenerimaanDetail;
use App\Models\Profile;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $get_nis = Profile::select('nis')->where('user_id', $user_id)->get();
        // dd($get_nis);

        $nis = $get_nis->toArray();
        // dd($nis);
            $tagihan = Tagihan::get_tagihan_by_nis($nis);
            $tunggakan = Tagihan::get_tunggakan_by_nis($nis);
            $penerimaan = PenerimaanDetail::get_bayar_by_nis($nis);
            // dd($tagihan);
            $tagihan_bdu = Tagihan::get_tagihan_bdu_by_nis($nis);
            $tagihan_spp = Tagihan::get_tagihan_spp_by_nis($nis);
            $lunas_spp = Tagihan::get_tunggakan_spp_by_nis($nis);
            $spp_lunas = Tagihan::get_spp_lunas_by_nis($nis);
            $tot_tunggakan = Tagihan::total_tunggakan_by_nis($nis);
            $tot_tagihan = Tagihan::total_tagihan_by_nis($nis);
       
        return view('admin.dashboard', compact('tagihan_spp', 'tagihan_bdu', 'tot_tunggakan', 'lunas_spp', 'spp_lunas', 'tagihan', 'tunggakan', 'penerimaan', 'tot_tagihan', 'get_nis'));
        
        // $detail_tunggakan =
        // dd($spp_lunas);
        
    }

    public function dashboard() 
    {
        $user_id = Auth::user()->id;

        $menubar = MenuMobile::where('is_footer', 1)->orderBy('no', 'asc')->get();

        $main_menu = MenuMobile::where('is_footer', 0)->where('is_profile', 0)->where('status', 1)->get();

        return view('ortu.dashboard', compact('main_menu', 'menubar', 'user_id'));

    }

    public function footer() 
    {

        $menubar = MenuMobile::where('is_footer', 1)->orderBy('no', 'asc')->get();

        return view('ortu.footer.index', compact('menubar'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
