<?php

namespace App\Http\Controllers;

use App\Models\ModulDiklat;
use App\Models\PengumpulanTugas;
use App\Models\TugasDiklat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class TugasDiklatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tugasDiklat = TugasDiklat::all();
        return view('karir.admin.tugas.index', compact('tugasDiklat'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modulDiklat = ModulDiklat::all();
        return view('karir.admin.tugas.create', compact('modulDiklat'));
        
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
            'judul_tugas' => 'required',
        ]);

        $file = null;
        $file_url = null;
        $path = 'tugas';
        if ($request->has('file_tugas')) {
            $file = $request->file('file_tugas')->store($path);
            $file_name = $request->file('file_tugas')->getClientOriginalName();
            $file_url = $path . '/' . $file_name;
            Storage::disk('public')->put($file_url, file_get_contents($request->file('file_tugas')->getRealPath()));
        } else {
            return redirect()->back()->with('failed', 'File tidak boleh kosong');
        }

        TugasDiklat::create([
            'judul_tugas' => $request->judul_tugas,
            'deskripsi_tugas' => $request->deskripsi_tugas,
            'deadline_tugas' => $request->deadline_tugas,
            'modul_id' => $request->modul_id,
            'status_tugas' => $request->status_tugas,
            'file_tugas' => $file_url, 
        ]);

        return redirect()->route('karir.admin.tugas')
            ->with('success', 'Tugas Diklat created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TugasDiklat  $tugasDiklat
     * @return \Illuminate\Http\Response
     */
    public function show(TugasDiklat $tugasDiklat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TugasDiklat  $tugasDiklat
     * @return \Illuminate\Http\Response
     */
    public function edit(TugasDiklat $tugasDiklat, $id)
    {
        $tugasDiklat = TugasDiklat::find($id);
        $modulDiklat = ModulDiklat::all();

        return view('karir.admin.tugas.edit', compact('tugasDiklat', 'modulDiklat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TugasDiklat  $tugasDiklat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TugasDiklat $tugasDiklat, $id)
    {
        $request->validate([
            'judul_tugas' => 'required',
        ]);

        $file = null;
        $file_url = $request->file_tugas_prev;
        $path = 'tugas';
        if ($request->has('file_tugas')) {
            $file = $request->file('file_tugas')->store($path);
            $file_name = $request->file('file_tugas')->getClientOriginalName();
            $file_url = $path . '/' . $file_name;
            Storage::disk('public')->put($file_url, file_get_contents($request->file('file_tugas')->getRealPath()));
        } else if ($request->file_tugas_prev == null) {
            return redirect()->back()->with('failed', 'File tidak boleh kosong');
        }

        TugasDiklat::find($id)->update([
            'judul_tugas' => $request->judul_tugas,
            'deskripsi_tugas' => $request->deskripsi_tugas,
            'file_tugas' => $file_url,
            'modul_id' => $request->modul_id,
            'status_tugas' => $request->status_tugas,
            'deadline_tugas' => $request->deadline_tugas,
        ]

        );

        return redirect()->route('karir.admin.tugas')
            ->with('success', 'Tugas Diklat updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TugasDiklat  $tugasDiklat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        tugasDiklat::find($id)->delete();

        return redirect()->route('karir.admin.tugas')
            ->with('success', 'Tugas Diklat deleted successfully');
    }

    public function kumpul_tugas() {
        $kumpul_tugas = PengumpulanTugas::get_kumpul_tugas_with_user();

        // dd($kumpul_tugas);

        return view('karir.admin.tugas.kumpul', compact('kumpul_tugas'));
    }

    public function download_kumpulan_tugas($id)
    {   
        $pengumpulan_tugas = PengumpulanTugas::find($id);
        // dd($pengumpulan_tugas);
        $file = public_path('storage/'.$pengumpulan_tugas->file);
        // $name = 'hasil-tugas-'.$pengumpulan_tugas->tugas_id.'-'.$pengumpulan_tugas->kode_csdm.'.pdf';
        
        $headers = [
            'Content-Type' => 'application/pdf',
         ];

        return response()->download($file);
        // return Storage::disk('public')->download($path, $name);
    }

    public function multiple_download_kumpulan_tugas()
    {
        $pengumpulan_tugas = PengumpulanTugas::all();

        $files = [];

        foreach ($pengumpulan_tugas as $item) {
            $files[$item->id] = public_path('storage/'.$item->file);
        }
        
        // dd($files);
        $zip = new ZipArchive;
        $zipFile = 'kumpulan_tugas.zip';

        if ($zip->open(public_path('storage/'.$zipFile), \ZipArchive::CREATE) === TRUE)
        {
            foreach ($files as $key => $value) {
                $relativeName = basename($value);
                $zip->addFile($value, $relativeName);
            }

            $zip->close();
        }

        return response()->download(public_path('storage/'.$zipFile));


    }

    public function download_tugas_master($id)
    {   
        $tugas = TugasDiklat::find($id);
        
        $file = public_path('storage/'.$tugas->file_tugas);
        $name = 'tugas-'.$tugas->judul_tugas.'.pdf';
        
        $headers = [
            'Content-Type' => 'application/pdf',
         ];

        return response()->download($file, $name, $headers);
    }
}
