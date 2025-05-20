<?php

namespace App\Http\Controllers;

use App\Models\PosisiLamaran;
use Illuminate\Http\Request;

class PosisiLamaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posisiLamaran = PosisiLamaran::all();
        return view('karir.admin.posisi-lamaran.index', compact('posisiLamaran'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('karir.admin.posisi-lamaran.create');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'posisi_dilamar' => 'required',
            'tingkat_jabatan' => 'required',
            'divisi' => 'required'
        ]);

        PosisiLamaran::create($request->all());

        return redirect()->route('karir.admin.posisi')->with('success', 'Berhasil Menambahkan Posisi');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PosisiLamaran  $posisiLamaran
     * @return \Illuminate\Http\Response
     */
    public function show(PosisiLamaran $posisiLamaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PosisiLamaran  $posisiLamaran
     * @return \Illuminate\Http\Response
     */
    public function edit(PosisiLamaran $posisiLamaran, $id)
    {
        $posisiLamaran = PosisiLamaran::find($id);
        return view('karir.admin.posisi-lamaran.edit', compact('posisiLamaran'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PosisiLamaran  $posisiLamaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PosisiLamaran $posisiLamaran, $id)
    {
        $request->validate([
            'posisi_dilamar' => 'required',
            'tingkat_jabatan' => 'required',
            'divisi' => 'required'
        ]);

        PosisiLamaran::find($id)->update($request->all());

        return redirect()->route('karir.admin.posisi')->with('success', 'Berhasil Update Posisi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PosisiLamaran  $posisiLamaran
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PosisiLamaran::find($id)->delete();

        return redirect()->route('karir.admin.posisi')
            ->with('success', 'Modul Diklat deleted successfully');
    }
}
