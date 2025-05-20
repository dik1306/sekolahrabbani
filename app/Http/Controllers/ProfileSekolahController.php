<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\Request;

class ProfileSekolahController extends Controller
{
    public function index()
    {
        $lokasi = Lokasi::where('status', 1)->get();

        return view('profile.index', compact('lokasi'));
    }
}
