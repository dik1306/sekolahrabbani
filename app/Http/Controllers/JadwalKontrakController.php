<?php

namespace App\Http\Controllers;

use App\Models\JadwalKontrak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JadwalKontrakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jadwalKontrak = JadwalKontrak::all();

        return view('karir.admin.jadwal-kontrak.index', compact('jadwalKontrak'));
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
     * @param  \App\Models\JadwalKontrak  $jadwalKontrak
     * @return \Illuminate\Http\Response
     */
    public function show(JadwalKontrak $jadwalKontrak)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JadwalKontrak  $jadwalKontrak
     * @return \Illuminate\Http\Response
     */
    public function edit(JadwalKontrak $jadwalKontrak)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JadwalKontrak  $jadwalKontrak
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JadwalKontrak $jadwalKontrak)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JadwalKontrak  $jadwalKontrak
     * @return \Illuminate\Http\Response
     */
    public function destroy(JadwalKontrak $jadwalKontrak)
    {
        //
    }

    public function upload_jadwal_kontrak(Request $request) {
        $request->validate([
            'file' => 'required',
        ]);

        $user = auth()->user();

        $file = null;
        $file_url = null;
        $path = 'jadwal_kontrak';
        if ($request->has('file')) {
            $file = $request->file('file')->store($path);
            $file_name = $request->file('file')->getClientOriginalName();
            $file_url = $path . '/' . $file_name;
            Storage::disk('public')->put($file_url, file_get_contents($request->file('file')->getRealPath()));
        } else {
            return redirect()->back()->with('failed', 'File tidak boleh kosong');
        }


        JadwalKontrak::create([
            'file' => $file_url,
            'nama' => $request->nama,
            'status' => $request->status,
            'created_by' => $user->name
            
        ]);

        return redirect()->back()
            ->with('success', 'nilai Diklat created successfully.');
    }

}
