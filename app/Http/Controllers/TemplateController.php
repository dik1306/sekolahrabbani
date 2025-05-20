<?php

namespace App\Http\Controllers;

use App\Models\JenisMerchandise;
use App\Models\TemplateDesain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SebastianBergmann\Template\Template;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $template = TemplateDesain::all();
        $jenis_merchandise = JenisMerchandise::whereIn('id', ['1', '2', '3'])->get();
        return view('admin.master.template-desain', compact('template', 'jenis_merchandise'));
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
        try {
            $judul = $request->nama_template;
            $jenis = $request->jenis;

            $image_1 = null;
            $image_url_1 = null;
            $path = 'palestineday/template';
            if ($request->has('image_1')) {
                $image_1 = $request->file('image_1')->store($path);
                $image_name_1 = $request->file('image_1')->getClientOriginalName();
                $image_url_1 = $path . '/' . $image_name_1;
                Storage::disk('public')->put($image_url_1, file_get_contents($request->file('image_1')->getRealPath()));
            } else {
                return redirect()->back()->with('error', 'Image tidak boleh kosong');
            }

            $add_merch = TemplateDesain::create([
                'jenis_id' => $jenis,
                'judul' => $judul,
                'image_1' => $image_url_1,
            ]);

            return redirect()->back()->with('success', 'Berhasil tambah menu');

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TemplateDesain  $templateDesain
     * @return \Illuminate\Http\Response
     */
    public function show(TemplateDesain $templateDesain)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TemplateDesain  $templateDesain
     * @return \Illuminate\Http\Response
     */
    public function edit(TemplateDesain $templateDesain)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TemplateDesain  $templateDesain
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TemplateDesain $templateDesain)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TemplateDesain  $templateDesain
     * @return \Illuminate\Http\Response
     */
    public function destroy(TemplateDesain $templateDesain)
    {
        //
    }
}
