<?php

namespace App\Http\Controllers;

use App\Exports\OrderDetailMerchandiseExport;
use App\Exports\OrderMerchandiseExport;
use App\Exports\SalesMerchandiseExport;
use App\Models\DesainPalestineday;
use App\Models\HargaMerchandise;
use App\Models\JenisMerchandise;
use App\Models\LokasiSub;
use App\Models\Merchandise;
use App\Models\OrderDetailMerchandise;
use App\Models\OrderMerchandise;
use App\Models\Profile;
use App\Models\TemplateDesain;
use App\Models\WarnaImage;
use Barryvdh\DomPDF\Facade\Pdf;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class MerchandiseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $merchandise = Merchandise::get_jenis();
        // dd($merchandise);
        $jenis_merchandise = JenisMerchandise::all();
        return view('admin.master.merchandise', compact('merchandise', 'jenis_merchandise'));
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
            $nama_merchandise = $request->nama_merchandise;
            $deskripsi = $request->deskripsi;
            $jenis = $request->jenis;
            $harga = $request->harga;
            $diskon = $request->diskon;
            $image_2 = $request->image_2;

            $image_1 = null;
            $image_url_1 = null;
            $path = 'palestineday/merchandise';
            if ($request->has('image_1')) {
                $image_1 = $request->file('image_1')->store($path);
                $image_name_1 = $request->file('image_1')->getClientOriginalName();
                $image_url_1 = $path . '/' . $image_name_1;
                Storage::disk('public')->put($image_url_1, file_get_contents($request->file('image_1')->getRealPath()));
            } else {
                return redirect()->back()->with('error', 'Image tidak boleh kosong');
            }

            $image_url_2 = null;
            $path = 'palestineday/merchandise';
            if ($request->has('image_2')) {
                $image_name_2 = $request->file('image_2')->getClientOriginalName();
                $image_url_2 = $path . '/' . $image_name_2;
                Storage::disk('public')->put($image_url_2, file_get_contents($request->file('image_2')->getRealPath()));
            }

            $image_url_3 = null;
            $path = 'palestineday/merchandise';
            if ($request->has('image_3')) {
                $image_name_3 = $request->file('image_3')->getClientOriginalName();
                $image_url_3 = $path . '/' . $image_name_3;
                Storage::disk('public')->put($image_url_3, file_get_contents($request->file('image_3')->getRealPath()));
            }

            $add_merch = Merchandise::create([
                'nama_produk' => $nama_merchandise,
                'jenis_id' => $jenis,
                'deskripsi' => $deskripsi,
                'harga_awal' => $harga,
                'diskon' => $diskon,
                'image_1' => $image_url_1,
                'image_2' => $image_url_2,
                'image_3' => $image_url_3,
            ]);

            // $add_harga = HargaMerchandise::create([
            //     'merchandise_id' => $add_merch->id,
            //     'harga' => $harga,
            //     'diskon' => $diskon
            // ]);

            return redirect()->back()->with('success', 'Berhasil tambah menu');

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Merchandise  $merchandise
     * @return \Illuminate\Http\Response
     */
    public function show(Merchandise $merchandise)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Merchandise  $merchandise
     * @return \Illuminate\Http\Response
     */
    public function edit(Merchandise $merchandise)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Merchandise  $merchandise
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Merchandise $merchandise)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Merchandise  $merchandise
     * @return \Illuminate\Http\Response
     */
    public function destroy(Merchandise $merchandise)
    {
        //
    }

    public function kumpul_desain()
    {
        $sekolah = LokasiSub::select('id as id_lokasi', 'sublokasi')->where('id_lokasi', '!=', 'YYS')->get();

        $list_desain = DesainPalestineday::select('t_desain_palestineday.*', 'mls.sublokasi as lokasi')
                        ->leftJoin('mst_lokasi_sub as mls', 't_desain_palestineday.sekolah_id', 'mls.id')
                        ->orderby('created_at', 'desc')
                        ->groupby('t_desain_palestineday.nis')
                        ->get();
                        

        return view('admin.master.kumpul-desain', compact('sekolah', 'list_desain'));
    }

    public function get_kelas(Request $request) {
        $sekolah_id = $request->id_sekolah;

        $data['kelas'] = Profile::select('nama_kelas')->where('sekolah_id', $sekolah_id)->groupby('nama_kelas')->get();

        return response()->json($data);
    }

    public function get_siswa(Request $request) {
        $sekolah_id = $request->id_sekolah;
        $id_kelas = $request->id_kelas;

        $data['siswa'] = Profile::select('nama_lengkap', 'nis')
                                ->where('sekolah_id', $sekolah_id)
                                ->where('nama_kelas', $id_kelas)
                                ->get();

        return response()->json($data);
    }

    public function store_desain(Request $request)
    {
        try {

            $user = Auth::user();
            $update_by = $user->name;
            $sekolah = $request->sekolah;
            $kelas = $request->kelas;
            $nis = $request->nama_siswa;

            $get_siswa = Profile::where('nis', $nis)->first();
            $nama_siswa = $get_siswa->nama_lengkap;

            $image = null;
            $image_url = null;
            $path = 'palestineday/desain';
            if ($request->has('image_file')) {
                $image = $request->file('image_file')->store($path);
                $image_name = $request->file('image_file')->getClientOriginalName();
                $image_url = $path . '/' . $image_name;
                Storage::disk('public')->put($image_url, file_get_contents($request->file('image_file')->getRealPath()));
            } else {
                return redirect()->back()->with('error', 'Image tidak boleh kosong');
            }

            $add_desain = DesainPalestineday::create([
                'nis' => $nis,
                'nama_siswa' => $nama_siswa,
                'sekolah_id' => $sekolah,
                'nama_kelas' => $kelas,
                'updated_by' => $update_by,
                'image_file' => $image_url
            ]);

            return redirect()->back()->with('success', 'Desaid created successfully.');

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function desain_by_id(Request $request, $id)
    {
        $desain_by_id = DesainPalestineday::where('id', $id)->first();

        return response($desain_by_id);
    }

    public function create_jenis(Request $request)
    {
        $add_jenis = JenisMerchandise::create([
            'jenis' => $request->nama_jenis
        ]);

        return redirect()->back();
    }

    public function download_desain(Request $request, $id)
    {
        $desain = DesainPalestineday::find($id);
        
        $file = public_path('storage/'.$desain->image_file);
        $name = $desain->nis.'.jpg';
        
        $headers = array(
            'Content-Disposition' => 'inline',
        );

        return response()->download($file, $name, $headers);
    }

    public function list_order (Request $request)
    {
        $sekolah_id = $request->sekolah ?? null;
        $start = $request->date_start != '' ? $request->date_start : null ;
        $date_end = $request->date_end != '' ? $request->date_end : null;

        $date_start = date($start);
        $new_date_end = new DateTime($date_end);
        $date_end_plus = $new_date_end->modify('+1 day')->format('Y-m-d');

        $sekolah = LokasiSub::select('id as id_sekolah', 'sublokasi')->where('status', 1)->get();

        if ($request->has('date_start') && $request->has('date_end') || $request->has('sekolah')) {
            $list_order = OrderMerchandise::query();
            
            if ($request->has('sekolah'))
            $list_order = $list_order->selectRaw('t_pesan_merchandise.id, t_pesan_merchandise.no_pesanan, nama_pemesan, total_harga, metode_pembayaran, status, t_pesan_merchandise.updated_at')
                            ->leftJoin('t_pesan_merchandise_detail as tpmd', 't_pesan_merchandise.no_pesanan', 'tpmd.no_pesanan')
                            ->where('tpmd.lokasi_sekolah', $sekolah_id)
                            ->where('status', 'success');

            if ($start!= null && $date_end != null)
            $list_order = $list_order->selectRaw('t_pesan_merchandise.id, t_pesan_merchandise.no_pesanan, nama_pemesan, total_harga, metode_pembayaran, status, t_pesan_merchandise.updated_at')
                            ->whereBetween('t_pesan_merchandise.updated_at', [$date_start, $date_end_plus])
                            ->where('status', 'success');

            $list_order = $list_order->get();

        } else {
            $list_order = OrderMerchandise::where('status', 'success')->orderby('updated_at', 'desc')->get();
        }

        return view('admin.laporan.order-merchandise', compact('list_order', 'date_start', 'date_end', 'sekolah', 'sekolah_id'));
    }

    public function order_detail ($id)
    {
        $order_detail = OrderDetailMerchandise::select('mm.nama_produk', 'mwk.warna', 'mus.ukuran_seragam',  'mku.kategori', 'mtd.judul as template',
                        't_pesan_merchandise_detail.nama_siswa', 'tdp.id as design_id', 'tdp.nis', 'tdp.nama_siswa as siswa', 'tdp.sekolah_id', 'tdp.nama_kelas as kelas', 't_pesan_merchandise_detail.lokasi_sekolah', 
                        't_pesan_merchandise_detail.nama_kelas', 'tdp.image_file', 't_pesan_merchandise_detail.quantity',
                        't_pesan_merchandise_detail.harga', 't_pesan_merchandise_detail.persen_diskon', 't_pesan_merchandise_detail.ukuran_id')
                        ->leftJoin('m_merchandise as mm', 'mm.id', 't_pesan_merchandise_detail.merchandise_id')
                        ->leftJoin('m_warna_kaos as mwk', 'mwk.id', 't_pesan_merchandise_detail.warna_id')
                        ->leftJoin('m_ukuran_seragam as mus', 'mus.id', 't_pesan_merchandise_detail.ukuran_id')
                        ->leftJoin('m_kategori_umur as mku', 'mku.id', 't_pesan_merchandise_detail.kategori_id')
                        ->leftJoin('m_template_desain as mtd', 'mtd.id', 't_pesan_merchandise_detail.template_id')
                        ->leftJoin('t_desain_palestineday as tdp', 'tdp.id', 't_pesan_merchandise_detail.design_id')
                        ->where('no_pesanan', $id)
                        ->get();
        // dd($order_detail);

        return response()->json($order_detail);
    }

    public function download_invoice(Request $request, $id)
    {
        $user_id = auth()->user()->id;

        $order = OrderMerchandise::where('no_pesanan', $id)->first();

        $order_detail = OrderDetailMerchandise::select('t_pesan_merchandise_detail.nama_siswa', 't_pesan_merchandise_detail.lokasi_sekolah',
                    't_pesan_merchandise_detail.nama_kelas', 'mm.nama_produk', 'mwk.warna', 'mm.image_1', 'mtd.judul as template',  
                    'mus.ukuran_seragam', 'mku.kategori', 'tdp.nis', 't_pesan_merchandise_detail.harga', 't_pesan_merchandise_detail.persen_diskon', 
                    't_pesan_merchandise_detail.quantity', 't_pesan_merchandise_detail.ukuran_id', 't_pesan_merchandise_detail.created_at')
                    ->leftJoin('t_pesan_merchandise as tpm', 'tpm.no_pesanan', 't_pesan_merchandise_detail.no_pesanan')
                    ->leftJoin('m_merchandise as mm', 'mm.id', 't_pesan_merchandise_detail.merchandise_id')
                    ->leftJoin('m_warna_kaos as mwk', 'mwk.id', 't_pesan_merchandise_detail.warna_id')
                    ->leftJoin('m_ukuran_seragam as mus', 'mus.id', 't_pesan_merchandise_detail.ukuran_id')
                    ->leftJoin('m_kategori_umur as mku', 'mku.id', 't_pesan_merchandise_detail.kategori_id')
                    ->leftJoin('m_template_desain as mtd', 'mtd.id', 't_pesan_merchandise_detail.template_id')
                    ->leftJoin('t_desain_palestineday as tdp', 'tdp.id', 't_pesan_merchandise_detail.design_id')
                    ->where('tpm.no_pesanan', $id)
                    ->get();

        // Load view dengan data yang disiapkan
        $pdf = Pdf::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('admin.laporan.invoice', [
                        'order' => $order,
                        'order_detail' => $order_detail
                    ]);
        $pdf->setPaper('Letter');
        $pdf->setWarnings(false);

        // Download file PDF
        return $pdf->download('Invoice-'.$id.'.pdf');
    }

    public function export_list_order(Request $request)
    {
        $sekolah_id = $request->sekolah ?? null;
        $start = $request->date_start_ex != '' ? $request->date_start_ex : '2024-12-18' ;
        $date_end = $request->date_end_ex != '' ? $request->date_end_ex : null;
        
        $date_start = date($start);
        $new_date_end = new DateTime($date_end);
        $date_end_plus = $new_date_end->modify('+1 day')->format('Y-m-d');

        $now = date('d-m-y');
        $file_name = 'list-order-by-'.$now.'.xlsx';
        return Excel::download(new SalesMerchandiseExport($start, $date_end_plus), $file_name);
    }

    public function rincian_pesanan (Request $request, $id) {
        $user_id = auth()->user()->id;

        $order = OrderMerchandise::where('no_pesanan', $id)->first();

        $order_detail = OrderDetailMerchandise::select('t_pesan_merchandise_detail.nama_siswa', 't_pesan_merchandise_detail.lokasi_sekolah',
                        't_pesan_merchandise_detail.nama_kelas', 'mm.nama_produk', 'mwk.warna', 'mm.image_1', 'mtd.judul as template',  
                        'mus.ukuran_seragam', 'mku.kategori', 'tdp.nis', 'tdp.nama_siswa as design_siswa', 't_pesan_merchandise_detail.harga', 't_pesan_merchandise_detail.persen_diskon', 
                        't_pesan_merchandise_detail.quantity', 't_pesan_merchandise_detail.ukuran_id', 't_pesan_merchandise_detail.created_at', 'tpm.metode_pembayaran', 'tpm.no_pesanan')
                        ->leftJoin('t_pesan_merchandise as tpm', 'tpm.no_pesanan', 't_pesan_merchandise_detail.no_pesanan')
                        ->leftJoin('m_merchandise as mm', 'mm.id', 't_pesan_merchandise_detail.merchandise_id')
                        ->leftJoin('m_warna_kaos as mwk', 'mwk.id', 't_pesan_merchandise_detail.warna_id')
                        ->leftJoin('m_ukuran_seragam as mus', 'mus.id', 't_pesan_merchandise_detail.ukuran_id')
                        ->leftJoin('m_kategori_umur as mku', 'mku.id', 't_pesan_merchandise_detail.kategori_id')
                        ->leftJoin('m_template_desain as mtd', 'mtd.id', 't_pesan_merchandise_detail.template_id')
                        ->leftJoin('t_desain_palestineday as tdp', 'tdp.id', 't_pesan_merchandise_detail.design_id')
                        ->where('tpm.no_pesanan', $id)
                        ->get();

        return view('ortu.palestine_day.rincian-pesan', compact( 'order', 'order_detail'));
    }

    public function harga_per_kategori(Request $request) {
        $user_id = auth()->user()->id;
        $merch_id = $request->merch_id;
        $kategori_id = $request->kategori_id;

        $harga = HargaMerchandise::select('harga', 'diskon')
                        ->where('merchandise_id', $merch_id)->where('kategori_id', $kategori_id)->get();
     
        return response()->json($harga);
    }

    public function resume_order (Request $request) {

        $order_success = OrderDetailMerchandise::select(DB::raw('sum(t_pesan_merchandise_detail.harga*t_pesan_merchandise_detail.quantity) as grand_total'))
                        ->leftJoin('t_pesan_merchandise as tpm', 'tpm.no_pesanan', 't_pesan_merchandise_detail.no_pesanan')
                        ->where('tpm.status', 'success')
                        ->first();

        $total_item = OrderDetailMerchandise::select(DB::raw('sum(t_pesan_merchandise_detail.quantity) as total_item'))
                        ->leftJoin('t_pesan_merchandise as tpm', 'tpm.no_pesanan', 't_pesan_merchandise_detail.no_pesanan')
                        ->where('tpm.status', 'success')
                        ->first();

        $total_item_baju_ikhwan = OrderDetailMerchandise::leftJoin('t_pesan_merchandise as tpm', 'tpm.no_pesanan', 't_pesan_merchandise_detail.no_pesanan')
        ->where('t_pesan_merchandise_detail.merchandise_id', 1)
        ->where('tpm.status', 'success')
        ->get();

        $total_item_baju_akhwat = OrderDetailMerchandise::leftJoin('t_pesan_merchandise as tpm', 'tpm.no_pesanan', 't_pesan_merchandise_detail.no_pesanan')
        ->where('t_pesan_merchandise_detail.merchandise_id', 2)
        ->where('tpm.status', 'success')
        ->get();

        $total_item_kerudung = OrderDetailMerchandise::leftJoin('t_pesan_merchandise as tpm', 'tpm.no_pesanan', 't_pesan_merchandise_detail.no_pesanan')
        ->where('tpm.status', 'success')
        ->where('t_pesan_merchandise_detail.merchandise_id', 3)
        ->get();

        $hpp = OrderMerchandise::select(DB::raw('SUM( (tpmd.hpp * tpmd.quantity) ) as total_hpp'))
        ->leftJoin('t_pesan_merchandise_detail as tpmd', 'tpmd.no_pesanan', 't_pesan_merchandise.no_pesanan')
        ->where('t_pesan_merchandise.status', 'success')
        ->first();

        $profit = $order_success->grand_total - $hpp->total_hpp;

        $total_item_by_merch_and_kategori = OrderMerchandise::select('mm.nama_produk', 'mku.kategori', 'mwk.warna', 'tpmd.harga',
        DB::raw('sum(tpmd.quantity) as total_item'))
        ->leftJoin('t_pesan_merchandise_detail as tpmd', 'tpmd.no_pesanan', 't_pesan_merchandise.no_pesanan')
        ->leftJoin('m_merchandise as mm', 'mm.id', 'tpmd.merchandise_id')
        ->leftJoin('m_kategori_umur as mku', 'mku.id', 'tpmd.kategori_id')
        ->leftJoin('m_warna_kaos as mwk', 'mwk.id', 'tpmd.warna_id')
        ->where('t_pesan_merchandise.status', 'success')
        ->groupby('tpmd.merchandise_id', 'tpmd.kategori_id', 'tpmd.warna_id')
        ->orderby('total_item', 'desc')
        ->take(5)
        ->get();

        $count_item_by_merch_and_kategori = OrderMerchandise::select('mm.nama_produk', 'mku.kategori', 'mwk.warna', 'tpmd.harga',
        DB::raw('sum(tpmd.quantity) as total_item'))
        ->leftJoin('t_pesan_merchandise_detail as tpmd', 'tpmd.no_pesanan', 't_pesan_merchandise.no_pesanan')
        ->leftJoin('m_merchandise as mm', 'mm.id', 'tpmd.merchandise_id')
        ->leftJoin('m_kategori_umur as mku', 'mku.id', 'tpmd.kategori_id')
        ->leftJoin('m_warna_kaos as mwk', 'mwk.id', 'tpmd.warna_id')
        ->where('t_pesan_merchandise.status', 'success')
        ->groupby('tpmd.merchandise_id', 'tpmd.kategori_id', 'tpmd.warna_id')
        ->orderby('total_item', 'desc')
        ->get();

        $sales_by_school = OrderMerchandise::select('mls.sublokasi', DB::raw('count(tpmd.lokasi_sekolah) as total_item'))
        ->leftJoin('t_pesan_merchandise_detail as tpmd', 'tpmd.no_pesanan', 't_pesan_merchandise.no_pesanan')
        ->leftJoin('mst_lokasi_sub as mls', 'mls.id', 'tpmd.lokasi_sekolah')
        ->where('t_pesan_merchandise.status', 'success')
        ->groupby('tpmd.lokasi_sekolah')
        ->orderby('total_item', 'desc')
        ->get();

        $sales_by_produk = OrderMerchandise::select('mm.nama_produk', DB::raw('sum(tpmd.quantity) as total_item'))
        ->leftJoin('t_pesan_merchandise_detail as tpmd', 'tpmd.no_pesanan', 't_pesan_merchandise.no_pesanan')
        ->leftJoin('m_merchandise as mm', 'mm.id', 'tpmd.merchandise_id')
        ->where('t_pesan_merchandise.status', 'success')
        ->groupby('tpmd.merchandise_id')
        ->orderby('total_item', 'desc')
        ->get();

        return view('admin.laporan.resume', compact( 'order_success', 'total_item', 'total_item_baju_ikhwan', 'total_item_baju_akhwat', 'total_item_kerudung',
        'total_item_by_merch_and_kategori', 'total_item', 'count_item_by_merch_and_kategori', 'sales_by_school', 'hpp', 'profit', 'sales_by_produk'));

    }

    public function resume_detail (Request $request) {

        $order_success = OrderDetailMerchandise::select(DB::raw('sum(t_pesan_merchandise_detail.harga*t_pesan_merchandise_detail.quantity) as grand_total'))
                        ->leftJoin('t_pesan_merchandise as tpm', 'tpm.no_pesanan', 't_pesan_merchandise_detail.no_pesanan')
                        ->where('tpm.status', 'success')
                        ->first();

        $total_item = OrderDetailMerchandise::select(DB::raw('sum(t_pesan_merchandise_detail.quantity) as total_item'))
                        ->leftJoin('t_pesan_merchandise as tpm', 'tpm.no_pesanan', 't_pesan_merchandise_detail.no_pesanan')
                        ->where('tpm.status', 'success')
                        ->first();
        $hpp = OrderMerchandise::select(DB::raw('SUM( (tpmd.hpp * tpmd.quantity) ) as total_hpp'))
        ->leftJoin('t_pesan_merchandise_detail as tpmd', 'tpmd.no_pesanan', 't_pesan_merchandise.no_pesanan')
        ->where('t_pesan_merchandise.status', 'success')
        ->first();

        $profit = $order_success->grand_total - $hpp->total_hpp;

        $total_item_baju_ikhwan = OrderDetailMerchandise::leftJoin('t_pesan_merchandise as tpm', 'tpm.no_pesanan', 't_pesan_merchandise_detail.no_pesanan')
        ->where('t_pesan_merchandise_detail.merchandise_id', 1)
        ->where('tpm.status', 'success')
        ->get();

        $total_item_baju_akhwat = OrderDetailMerchandise::leftJoin('t_pesan_merchandise as tpm', 'tpm.no_pesanan', 't_pesan_merchandise_detail.no_pesanan')
        ->where('t_pesan_merchandise_detail.merchandise_id', 2)
        ->where('tpm.status', 'success')
        ->get();

        $total_item_kerudung = OrderDetailMerchandise::leftJoin('t_pesan_merchandise as tpm', 'tpm.no_pesanan', 't_pesan_merchandise_detail.no_pesanan')
        ->where('tpm.status', 'success')
        ->where('t_pesan_merchandise_detail.merchandise_id', 3)
        ->get();

        $total_item_by_merch_and_kategori = OrderMerchandise::select('mm.nama_produk', 'mku.kategori', 'mwk.warna', 'tpmd.harga',
        DB::raw('sum(tpmd.quantity) as total_item'))
        ->leftJoin('t_pesan_merchandise_detail as tpmd', 'tpmd.no_pesanan', 't_pesan_merchandise.no_pesanan')
        ->leftJoin('m_merchandise as mm', 'mm.id', 'tpmd.merchandise_id')
        ->leftJoin('m_kategori_umur as mku', 'mku.id', 'tpmd.kategori_id')
        ->leftJoin('m_warna_kaos as mwk', 'mwk.id', 'tpmd.warna_id')
        ->where('t_pesan_merchandise.status', 'success')
        ->groupby('tpmd.merchandise_id', 'tpmd.kategori_id', 'tpmd.warna_id')
        ->orderby('total_item', 'desc')
        ->get();

        $sales_by_school = OrderMerchandise::select('mls.sublokasi', DB::raw('count(tpmd.lokasi_sekolah) as total_item'))
        ->leftJoin('t_pesan_merchandise_detail as tpmd', 'tpmd.no_pesanan', 't_pesan_merchandise.no_pesanan')
        ->leftJoin('mst_lokasi_sub as mls', 'mls.id', 'tpmd.lokasi_sekolah')
        ->where('t_pesan_merchandise.status', 'success')
        ->groupby('tpmd.lokasi_sekolah')
        ->orderby('total_item', 'desc')
        ->get();

        $sales_by_produk = OrderMerchandise::select('mm.nama_produk', DB::raw('sum(tpmd.quantity) as total_item'))
        ->leftJoin('t_pesan_merchandise_detail as tpmd', 'tpmd.no_pesanan', 't_pesan_merchandise.no_pesanan')
        ->leftJoin('m_merchandise as mm', 'mm.id', 'tpmd.merchandise_id')
        ->where('t_pesan_merchandise.status', 'success')
        ->groupby('tpmd.merchandise_id')
        ->orderby('total_item', 'desc')
        ->get();

        return view('admin.laporan.resume-all', compact( 'order_success', 'total_item', 'total_item_baju_ikhwan', 'total_item_baju_akhwat', 'total_item_kerudung',
        'total_item_by_merch_and_kategori', 'total_item', 'sales_by_school', 'hpp', 'profit', 'sales_by_produk'));

    }

    public function get_design(Request $request)
    {
        $design_id = $request->design_id;

        $karya = DesainPalestineday::select('id', 'nis', 'image_file')
                        ->where('id', $design_id)
                        ->first();
     
        return response()->json($karya);
    }

    public function get_template(Request $request)
    {
        $template_id = $request->template_id;

        $karya = TemplateDesain::where('id', $template_id)->first();
     
        return response()->json($karya);
    }

    public function get_warna(Request $request)
    {
        $warna_id = $request->warna_id;
        $merch_id = $request->merch_id;

        $karya = WarnaImage::where('warna_id', $warna_id)->where('merch_id', $merch_id)->first();
     
        return response()->json($karya);
    }

}
