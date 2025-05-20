<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikel = Artikel::all();
        return view('admin.master.artikel.index', compact('artikel'));
    }

    public function edit(Request $request, $id)
    {
        $artikel = Artikel::all();
        return view('admin.master.artikel.edit', compact('artikel'));
    }
}
