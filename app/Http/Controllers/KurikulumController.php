<?php

namespace App\Http\Controllers;

use App\Models\EkskulSekolah;
use Illuminate\Http\Request;

class KurikulumController extends Controller
{
    public function index() {
        $ekskul_tk = EkskulSekolah::where('kategori', 'tk')->get();
        $ekskul_sd_wajib = EkskulSekolah::where('kategori', 'sd')->where('status', 1)->get();
        $ekskul_smp_wajib = EkskulSekolah::where('kategori', 'smp')->where('status', 1)->get();
        $ekskul_sd_pilihan = EkskulSekolah::where('kategori', 'sd')->where('status', 2)->get();
        $ekskul_smp_pilihan = EkskulSekolah::where('kategori', 'smp')->where('status', 2)->get();
 

        return view('kurikulum.index', compact('ekskul_tk', 'ekskul_sd_wajib', 'ekskul_smp_wajib', 'ekskul_sd_pilihan', 'ekskul_smp_pilihan'));
    }
}
