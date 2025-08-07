<?php

namespace App\Http\Controllers;

use App\Models\FasilitasSekolah;
use App\Models\Jenjang;
use App\Models\ProgramUnggulan;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;

class HomeController extends Controller
{
    public function index()
    {
        $jenjang = Jenjang::all();
        $program = ProgramUnggulan::all();
        $fasilitas = FasilitasSekolah::all();

        $position = Location::get(request()->ip());
         
         $add_user = Visitor::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'location' => $position->cityName,
            'created_at' => now()
         ]);

        return view('index', compact('jenjang', 'program', 'fasilitas'));
    }

     public function privacy_policy()
    {
        return view('privacy_policy');
    }

    public function jenjang(Request $request, $jenjang)
    {
        $jenjang_detail = Jenjang::jenjang_sekolah_sub_lokasi($jenjang);
        // dd($jenjang_detail);

        return view('jenjang.index', compact('jenjang_detail'));
    }
}
