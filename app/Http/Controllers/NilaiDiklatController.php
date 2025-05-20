<?php

namespace App\Http\Controllers;

use App\Models\Csdm;
use App\Models\NilaiDiklat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NilaiDiklatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nilaiDiklat = NilaiDiklat::get_nilai_with_profile();
        // dd($nilaiDiklat);
        $csdm = User::all();
        // dd($csdm);
        return view('karir.admin.nilai.index', compact('nilaiDiklat', 'csdm'));
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
     * @param  \App\Models\NilaiDiklat  $nilaiDiklat
     * @return \Illuminate\Http\Response
     */
    public function show(NilaiDiklat $nilaiDiklat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NilaiDiklat  $nilaiDiklat
     * @return \Illuminate\Http\Response
     */
    public function edit(NilaiDiklat $nilaiDiklat, $id)
    {
        $nilaiDiklat = NilaiDiklat::where('id_profile_csdm', $id)->first();

        return view('karir.admin.nilai.index', compact('nilaiDiklat'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NilaiDiklat  $nilaiDiklat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NilaiDiklat $nilaiDiklat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NilaiDiklat  $nilaiDiklat
     * @return \Illuminate\Http\Response
     */
    public function destroy(NilaiDiklat $nilaiDiklat, $id)
    {
        NilaiDiklat::find($id)->delete();

        return redirect()->route('karir.admin.nilai')
            ->with('success', 'Nilai Diklat deleted successfully');
    }

    public function upload_nilai (Request $request) {
        $request->validate([
            'file_nilai' => 'required',
            'id_profile_csdm' => 'required'
        ]);

        $id_profile_csdm = $request->id_profile_csdm;
        $user_csdm = User::where('id_profile_csdm', $id_profile_csdm)->first();
        $kode_csdm = $user_csdm->kode_csdm;

        $file = null;
        $file_url = null;
        $path = 'kumpulan_nilai';
        if ($request->has('file_nilai')) {
            $file = $request->file('file_nilai')->store($path);
            $file_name = $request->file('file_nilai')->getClientOriginalName();
            $file_url = $path . '/' . $file_name;
            Storage::disk('public')->put($file_url, file_get_contents($request->file('file_nilai')->getRealPath()));
        } else {
            return redirect()->back()->with('failed', 'File tidak boleh kosong');
        }


        NilaiDiklat::create([
            'id_profile_csdm' => $id_profile_csdm,
            'kode_csdm' => $kode_csdm,
            'file_nilai' => $file_url,
            
        ]);

        return redirect()->back()
            ->with('success', 'nilai Diklat created successfully.');
    }
}
