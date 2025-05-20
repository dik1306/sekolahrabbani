<?php

namespace App\Http\Controllers;

use App\Models\Csdm;
use App\Models\KelasDiklat;
use App\Models\ModulDiklat;
use App\Models\PengumpulanTugas;
use App\Models\TugasDiklat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KelasDiklatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kelasDiklat = KelasDiklat::get_kelas_aktif();

        return view('karir.kelas-diklat.index', compact('kelasDiklat'));
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
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KelasDiklat  $kelasDiklat
     * @return \Illuminate\Http\Response
     */
    public function show(KelasDiklat $kelasDiklat)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KelasDiklat  $kelasDiklat
     * @return \Illuminate\Http\Response
     */
    public function edit(KelasDiklat $kelasDiklat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KelasDiklat  $kelasDiklat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KelasDiklat $kelasDiklat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KelasDiklat  $kelasDiklat
     * @return \Illuminate\Http\Response
     */
    public function destroy(KelasDiklat $kelasDiklat)
    {
        //
    }

    public function get_kelas_by_pertemuan_id($pertemuan)
    {
        $user = auth()->user();
        $kelasDiklat = KelasDiklat::get_kelas_aktif();
        $kelas_pertemuan = KelasDiklat::get_kelas_per_pertemuan($pertemuan);
        $tugasDiklat = TugasDiklat::all();
        $kelas_with_modul = KelasDiklat::get_kelas_with_modul($pertemuan);
        $kumpul_tugas_by_id = PengumpulanTugas::where('tugas_id', $pertemuan)
                                ->where('user_id', $user->id)
                                ->orderby('created_at', 'DESC')
                                ->first();
        // dd($kumpul_tugas_by_id);

        return view('karir.kelas-diklat.by-pertemuan', compact('kelas_pertemuan', 'kelasDiklat', 'tugasDiklat', 'kelas_with_modul', 'kumpul_tugas_by_id'));
    }

    public function admin_kelas()
    {
        $kelasDiklat = KelasDiklat::all();
        return view('karir.admin.kelas.index', compact('kelasDiklat'));
    }

    public function admin_create_kelas()
    {
        return view('karir.admin.kelas.create');
    }

    public function admin_store_kelas(Request $request)
    {
        $request->validate([
            
            'pertemuan' => 'required',
            'forum_link' => 'required',
        ]);

        KelasDiklat::create($request->all());

        return redirect()->route('karir.admin.kelas')->with('success', 'Kelas berhasil ditambahkan');
    }

    public function admin_edit_kelas($id)
    {
        $kelasDiklat = KelasDiklat::find($id);

        return view('karir.admin.kelas.edit', compact('kelasDiklat'));
    }

    public function admin_update_kelas(Request $request, $id)
    {
        $request->validate([
            
            'pertemuan' => 'required',
            'forum_link' => 'required',
            'deskripsi_kelas' => 'required',
        ]);

        KelasDiklat::find($id)->update($request->all());

        return redirect()->route('karir.admin.kelas')->with('success', 'Kelas berhasil diupdate');
    }

    public function admin_delete_kelas($id)
    {
        KelasDiklat::where('id', $id)->delete();

        return redirect()->route('karir.admin.kelas')->with('success', 'Kelas berhasil dihapus');
    }

    public function getDownloadTugas($id)
    {   
        $tugasDiklat = TugasDiklat::where('modul_id', $id)->where('status_tugas', 1)->first();
        // dd($tugasDiklat);
        $file = public_path('storage/'.$tugasDiklat->file_tugas);
        
        $headers = [
            'Content-Type' => 'application/pdf',
         ];

        return response()->download($file);
        // return Storage::disk('public')->download($path, $name);
    }

    public function getDownloadModul($id)
    {
        $modulDiklat = ModulDiklat::where('kelas_diklat_id', $id)->where('status_modul', 1)->first();
        // dd($modulDiklat);
        $file = public_path('storage/'.$modulDiklat->file_modul);
        
        $headers = [
            'Content-Type' => 'application/pdf',
         ];

        return response()->download($file);
    }

    public function upload_tugas (Request $request) {
        $request->validate([
            'file' => 'required',
        ]);

        // $tugas_id = $pertemuan;

        $user_id = auth()->user()->id;
        $kode_csdm = auth()->user()->kode_csdm;
        $file = null;
        $file_url = null;
        $path = 'kumpulan_tugas';
        if ($request->has('file')) {
            $file = $request->file('file')->store($path);
            $file_name = $request->file('file')->getClientOriginalName();
            $file_url = $path . '/' . $file_name;
            Storage::disk('public')->put($file_url, file_get_contents($request->file('file')->getRealPath()));
        } else {
            return redirect()->back()->with('failed', 'File tidak boleh kosong');
        }


        PengumpulanTugas::create([
            'user_id' => $user_id,
            'kode_csdm' => $kode_csdm,
            'file' => $file_url,
            'status' => 1,
            'tugas_id' =>$request->pertemuan_ke
            
        ]);

        return redirect()->back()
            ->with('success', 'Tugas Diklat created successfully.');
    }

    public function download_nilai($id)
    {
        $modulDiklat = ModulDiklat::find($id);
        
        $file = public_path('storage/'.$modulDiklat->file_modul);
        
        $headers = [
            'Content-Type' => 'application/pdf',
         ];

        return response()->download($file, 'modul_diklat.pdf', $headers);
    }

    public function download_tugas_uploaded($id)
    {   
        $kumpulan_tugas = PengumpulanTugas::where('tugas_id', $id)->first();
        
        $file = public_path('storage/'.$kumpulan_tugas->file);
        $name = 'tugas-'.$kumpulan_tugas->kode_csdm.'.pdf';
        
        $headers = [
            'Content-Type' => 'application/pdf',
         ];

        return response()->download($file, $name, $headers);
    }
}
