<?php

namespace App\Http\Controllers;

use App\Exports\HaveReadList;
use App\Exports\ListKarya;
use App\Models\CartMerchandise;
use App\Models\DesainPalestineday;
use App\Models\HargaMerchandise;
use App\Models\HaveRead;
use App\Models\JenisMerchandise;
use App\Models\KategoriUmur;
use App\Models\Merchandise;
use App\Models\OrderDetailMerchandise;
use App\Models\OrderMerchandise;
use App\Models\PalestineDay;
use App\Models\Profile;
use App\Models\TemplateDesain;
use App\Models\UkuranSeragam;
use App\Models\WarnaKaos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class PalestineDayController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $user_phone = Auth::user()->no_hp;

        $get_jenjang = Profile::where('no_hp_ibu', $user_phone)->groupby('sekolah_id')->get();

        return view('ortu.palestine_day.index', compact('get_jenjang'));
        
    }

    public function materi_tk()
    {
        $user_id = Auth::user()->id;

        $materi = PalestineDay::where('jenjang', 1)->where('status', 1)->get();

        return view('ortu.palestine_day.materi-tk', compact('materi'));
        
    }

    public function materi_tk_by_id($id)
    {
        $user_id = Auth::user()->id;

        $materi = PalestineDay::find($id);

        $file = public_path('storage/'.$materi->file);
        
        return response()->file($file);
        
    }

    public function materi_tksd_by_id($id)
    {
        $user_id = Auth::user()->id;

        $materi = PalestineDay::find($id);

        $file = public_path('storage/'.$materi->file);

        $sudah_baca = HaveRead::where('user_id', $user_id)->where('materi_id', $id)->first();

        return view('ortu.palestine_day.materi-by-id', compact('file', 'materi', 'sudah_baca'));
        
    }

    public function materi_smp()
    {
        $user_id = Auth::user()->id;

        $materi = PalestineDay::where('jenjang', 2)->where('status', 1)->get();

        $date_today = date('Y-m-d');

        return view('ortu.palestine_day.materi-smp', compact('materi', 'date_today'));
        
    }

    public function materi_smp_by_id($id)
    {
        $user_id = Auth::user()->id;

        $materi = PalestineDay::find($id);

        $file = public_path('storage/'.$materi->file);

        $sudah_baca = HaveRead::where('user_id', $user_id)->where('materi_id', $id)->first();

        
        return view('ortu.palestine_day.materi-smp-by-id', compact('file', 'materi', 'sudah_baca'));
        
    }

    public function master_materi()
    {
        $materi_tksd = PalestineDay::where('jenjang', 1)->get();
        $materi_smp = PalestineDay::where('jenjang', 2)->get();
        return view('admin.master.palestineday.index', compact('materi_tksd', 'materi_smp'));
    }

    public function master_materi_by_id(Request $request, $id)
    {
        $detail_materi = PalestineDay::where('id', $id)->first();

        return response($detail_materi);
    }

    public function update_materi(Request $request, $id)
    {
        try {
            $user = Auth::user()->name;

            $file = null;
            $file_url = null;
            $path = 'palestineday/file';
            if ($request->has('file')) {
                $file = $request->file('file')->store($path);
                $file_name = $request->file('file')->getClientOriginalName();
                $file_url = $path . '/' . $file_name;
                Storage::disk('public')->put($file_url, file_get_contents($request->file('file')->getRealPath()));
            }
    
            $image = null;
            $image_url = null;
            $path = 'palestineday/gambar';
            if ($request->has('gambar')) {
                $image = $request->file('gambar')->store($path);
                $image_name = $request->file('gambar')->getClientOriginalName();
                $image_url = $path . '/' . $image_name;
                Storage::disk('public')->put($image_url, file_get_contents($request->file('gambar')->getRealPath()));
            }

            $update_materi = PalestineDay::where('id', $id)->update([
            'judul' => $request->judul_edit,
            'style' => $request->warna_edit,
            'status'  => $request->status_edit,
            'terbit'  => $request->terbit_edit,
            'link_evaluasi'  => $request->evaluasi_edit,
            'jenjang' => $request->jenjang_edit,
            'created_by' => $request->penulis_edit,
            'design_by' => $request->design_by_edit,
            'updated_by' => $user,
            ]);
            return redirect()->back()->withSuccess('Success update Materi ');
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }

    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'gambar' => 'required'
        ]);

        $user = Auth::user()->name;

        $file = null;
        $file_url = null;
        $path = 'palestineday/file';
        if ($request->has('file')) {
            $file = $request->file('file')->store($path);
            $file_name = $request->file('file')->getClientOriginalName();
            $file_url = $path . '/' . $file_name;
            Storage::disk('public')->put($file_url, file_get_contents($request->file('file')->getRealPath()));
        } else {
            return redirect()->back()->with('failed', 'File tidak boleh kosong');
        }

        $image = null;
        $image_url = null;
        $path = 'palestineday/gambar';
        if ($request->has('gambar')) {
            $image = $request->file('gambar')->store($path);
            $image_name = $request->file('gambar')->getClientOriginalName();
            $image_url = $path . '/' . $image_name;
            Storage::disk('public')->put($image_url, file_get_contents($request->file('gambar')->getRealPath()));
        } else {
            return redirect()->back()->with('error', 'Image tidak boleh kosong');
        }

        PalestineDay::create([
            'judul' => $request->judul,
            'style' => $request->warna,
            'deskripsi' => $request->deskripsi,
            'file' => $file_url,
            'image' => $image_url,
            'status'  => 1,
            'terbit'  => $request->terbit,
            'jenjang' => $request->jenjang,
            'created_by' => $request->penulis,
            'design_by' => $request->design_by,
            'updated_by' => $user,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('success', 'Materi created successfully.');
    }

    public function sudah_baca(Request $request) {
        $user = auth()->user();
        $user_id = $user->id;
        $user_name = $user->name;
        $materi_id = $request->materi_id;

        $materi = PalestineDay::find($materi_id);
        
        $get_jenjang = $materi->jenjang;

        if ($get_jenjang == 2) {
            $jenjang = 'UBRSMP';

            $data = Profile::select('m_profile.nis')
                            ->leftJoin('t_sudah_baca_materi as tsbm', 'tsbm.user_id', 'm_profile.user_id')
                            ->leftJoin('m_palestine_day as mpd', 'mpd.id', 'tsbm.materi_id')
                            ->where('m_profile.user_id', $user_id)
                            ->where('m_profile.sekolah_id', 'UBRSMP')
                            ->groupby('m_profile.user_id', 'm_profile.nis', 'tsbm.materi_id')
                            ->get();
            
            
            foreach ($data as $item) {
                $store_have_read = HaveRead::create([
                    'user_id' => $user_id,
                    'user_name' => $user_name,
                    'nis' => $item['nis'],
                    'materi_id' => $materi_id,
                ]);
            }
            return response()->json($store_have_read);

        } else {
            $data = Profile::select('m_profile.nis')
                            ->leftJoin('t_sudah_baca_materi as tsbm', 'tsbm.user_id', 'm_profile.user_id')
                            ->leftJoin('m_palestine_day as mpd', 'mpd.id', 'tsbm.materi_id')
                            ->where('m_profile.user_id', $user_id)
                            ->where('m_profile.sekolah_id', '!=', 'UBRSMP')
                            ->groupby('m_profile.user_id', 'm_profile.nis', 'tsbm.materi_id')
                            ->get();

            foreach ($data as $item) {
                $store_have_read = HaveRead::create([
                    'user_id' => $user_id,
                    'user_name' => $user_name,
                    'nis' => $item['nis'],
                    'materi_id' => $materi_id,
                ]);
            }
            return response()->json($store_have_read);
        }

    }

    public function list_sudah_baca()
    {
        $haveRead = HaveRead::select('t_sudah_baca_materi.materi_id', 't_sudah_baca_materi.created_at', 'mpro.nis', 'mpro.nama_lengkap', 'mls.sublokasi as lokasi', 'mpro.nama_kelas', 'mpd.judul', )
                            ->leftJoin('m_palestine_day as mpd', 'mpd.id', 't_sudah_baca_materi.materi_id')
                            ->leftJoin('m_profile as mpro', 'mpro.nis', 't_sudah_baca_materi.nis')
                            ->leftJoin('mst_lokasi_sub as mls', 'mpro.sekolah_id', 'mls.id')
                            ->groupby('t_sudah_baca_materi.materi_id', 't_sudah_baca_materi.nis')
                            ->orderby('t_sudah_baca_materi.created_at', 'Desc')
                            ->get();

        return view('admin.master.palestineday.sudahbaca', compact('haveRead'));
    }

    public function export_have_read()
    {
        $now = date('d-m-y');
        $file_name = 'haveread-'.$now.'.xlsx';
        return Excel::download(new HaveReadList(), $file_name);
    }

    public function export_karya()
    {
        $now = date('d-m-y');
        $file_name = 'list-karya-'.$now.'.xlsx';
        return Excel::download(new ListKarya(), $file_name);
    }

    public function merchandise()
    {
        $user_id = Auth::user()->id;
        $user_nohp = Auth::user()->no_hp;
        $data_nis = Profile::where('no_hp_ibu', $user_nohp)->get();

        foreach ($data_nis as $item) {
            $get_nis = $item->nis;
            
            $list_karya = DesainPalestineday::where('nis', $get_nis)->orderby('created_at', 'desc')->get();
        }

        $get_merch = Merchandise::all();
        $cart_detail = CartMerchandise::select('t_cart_merchandise.quantity', 't_cart_merchandise.id', 't_cart_merchandise.merchandise_id', 't_cart_merchandise.is_selected', 
                        'mwk.warna', 'mus.ukuran_seragam', 't_cart_merchandise.jenis_id', 't_cart_merchandise.template_id', 'mm.nama_produk', 'mm.harga_awal', 'mm.diskon', 'mm.image_1', 'mm.image_2', 
                        'tdp.nama_siswa', 'tdp.sekolah_id',  'tdp.nama_kelas', 'tdp.image_file', 'mjm.jenis', 'mku.kategori' )
                        ->leftJoin('m_merchandise as mm', 'mm.id', 't_cart_merchandise.merchandise_id')
                        ->leftJoin('m_jenis_merchandise as mjm', 'mjm.id', 't_cart_merchandise.jenis_id')
                        ->leftJoin('t_desain_palestineday as tdp', 'tdp.id', 't_cart_merchandise.design_id')
                        ->leftJoin('m_warna_kaos as mwk', 'mwk.id', 't_cart_merchandise.warna_id')
                        ->leftJoin('m_ukuran_seragam as mus', 'mus.id', 't_cart_merchandise.ukuran_id')
                        ->leftJoin('m_kategori_umur as mku', 'mku.id', 't_cart_merchandise.kategori_id') 
                        ->where('t_cart_merchandise.user_id', $user_id)
                        ->where('t_cart_merchandise.status_cart', 0)
                        ->get();

        
        return view('ortu.palestine_day.closed', compact('get_nis', 'list_karya', 'get_merch', 'cart_detail'));
    }

    public function detail_merchandise($id) 
    {
        $user_id = Auth::user()->id;
        $no_hp = auth()->user()->no_hp;
        $profile = Profile::get_user_profile_byphone($no_hp);
        $get_nis = Profile::select('nis')->where('no_hp_ibu',$no_hp)->get();
        $nis = $get_nis->toArray();

        $merchandise = Merchandise::where('id', $id)->first();
        
        $design_anak = DesainPalestineday::whereIn('nis', $nis)->groupby('nis')->get();

        $ukuran_dewasa = UkuranSeragam::whereNotIn('ukuran_seragam', ['ALL', 'XXS', '3XL', '4XL', '5XL'])->get();
        $ukuran_anak = UkuranSeragam::whereNotIn('ukuran_seragam', ['ALL', 'XXL', '3XL', '4XL', '5XL'])->orderby('urutan', 'asc')->get();
        $ukuran_kerudung = UkuranSeragam::where('ukuran_seragam', 'ALL')->get();
        $warna_kaos_ikhwan = WarnaKaos::where('id', '!=', 3)->get();
        $warna_kaos_akhwat = WarnaKaos::all();
        $warna_kerudung = WarnaKaos::whereIn('id', [1,2,3])->get();
        $jenis_kaos = JenisMerchandise::where('grup', 1)->get();
        $kategori = KategoriUmur::all();
        $template_kaos = TemplateDesain::where('jenis_id', 1)->get();
        $template_kaos_akhwat = TemplateDesain::where('jenis_id', 2)->get();
        $template_kerudung = TemplateDesain::where('jenis_id', 3)->get();

        $cart_detail = CartMerchandise::select('t_cart_merchandise.quantity', 't_cart_merchandise.id', 't_cart_merchandise.merchandise_id', 't_cart_merchandise.is_selected', 
                        'mwk.warna', 'mus.ukuran_seragam', 'mus.id as ukuran_id', 't_cart_merchandise.jenis_id', 't_cart_merchandise.template_id', 'mm.nama_produk', 'mm.harga_awal', 'mm.diskon', 'mm.image_1', 'mm.image_2', 
                        'tdp.nama_siswa', 'tdp.sekolah_id',  'tdp.nama_kelas', 'tdp.image_file', 'mjm.jenis', 'mku.kategori' )
                        ->leftJoin('m_merchandise as mm', 'mm.id', 't_cart_merchandise.merchandise_id')
                        ->leftJoin('m_jenis_merchandise as mjm', 'mjm.id', 't_cart_merchandise.jenis_id')
                        ->leftJoin('t_desain_palestineday as tdp', 'tdp.id', 't_cart_merchandise.design_id')
                        ->leftJoin('m_warna_kaos as mwk', 'mwk.id', 't_cart_merchandise.warna_id')
                        ->leftJoin('m_ukuran_seragam as mus', 'mus.id', 't_cart_merchandise.ukuran_id')
                        ->leftJoin('m_kategori_umur as mku', 'mku.id', 't_cart_merchandise.kategori_id') 
                        ->where('t_cart_merchandise.user_id', $user_id)
                        ->where('t_cart_merchandise.status_cart', 0)
                        ->get();

        return view('ortu.palestine_day.detail-merchandise', compact('merchandise', 'cart_detail', 'profile', 'design_anak', 'kategori', 
        'ukuran_dewasa', 'ukuran_anak', 'warna_kaos_ikhwan', 'warna_kaos_akhwat', 'warna_kerudung', 'jenis_kaos', 'ukuran_kerudung', 'template_kaos', 'template_kaos_akhwat', 'template_kerudung'));
    }

    public function detail_merchandise_kaos($id) 
    {
        $user_id = auth()->user()->id;
        $no_hp = auth()->user()->no_hp;
        $profile = Profile::get_user_profile_byphone($no_hp);

        $merchandise_kaos = DesainPalestineday::where('id', $id)->first();
        $detail_kaos = Merchandise::whereIn('jenis_id', ['1', '2'])->get();
        $ukuran = UkuranSeragam::whereNotIn('ukuran_seragam', ['ALL', 'XXS'])->get();
        $warna_kaos = WarnaKaos::all();
        $jenis_kaos = JenisMerchandise::where('grup', 1)->get();
        $kategori = KategoriUmur::all();

        $cart_detail = CartMerchandise::select('t_cart_merchandise.quantity', 't_cart_merchandise.id', 't_cart_merchandise.merchandise_id', 't_cart_merchandise.is_selected', 
                        'mwk.warna', 'mus.ukuran_seragam', 't_cart_merchandise.jenis_id', 't_cart_merchandise.template_id', 'mm.nama_produk', 'mm.harga_awal', 'mm.diskon', 'mm.image_1', 'mm.image_2', 
                        'tdp.nama_siswa', 'tdp.sekolah_id',  'tdp.nama_kelas', 'tdp.image_file' )
                        ->leftJoin('m_merchandise as mm', 'mm.id', 't_cart_merchandise.merchandise_id')
                        ->leftJoin('t_desain_palestineday as tdp', 'tdp.id', 't_cart_merchandise.design_id')
                        ->leftJoin('m_warna_kaos as mwk', 'mwk.id', 't_cart_merchandise.warna_id')
                        ->leftJoin('m_ukuran_seragam as mus', 'mus.id', 't_cart_merchandise.ukuran_id')
                        ->leftJoin('m_kategori_umur as mku', 'mku.id', 't_cart_merchandise.kategori_id')
                        ->where('t_cart_merchandise.user_id', $user_id)
                        ->where('t_cart_merchandise.status_cart', 0)
                        ->get();

        return view('ortu.palestine_day.detail-kaos', compact('merchandise_kaos', 'cart_detail', 'profile', 'detail_kaos', 'kategori', 'ukuran', 'warna_kaos', 'jenis_kaos'));
    }

    public function add_to_cart(Request $request)
    {
        $merchandise_id = $request->merchandise_id;
        $design_id = $request->design_id;
        $ukuran = $request->ukuran;
        $warna_id = $request->warna_id;
        $jenis_id = $request->jenis_id;
        $template_id = $request->template_id;
        $kategori_id = $request->kategori_id;
        $quantity = $request->quantity;
        $user_id = auth()->user()->id;

        $add_cart_detail =  CartMerchandise::create([
            'merchandise_id' => $merchandise_id,
            'user_id' => $user_id,
            'quantity' => $quantity,
            'design_id' => $design_id,
            'ukuran_id' => $ukuran,
            'warna_id' => $warna_id,
            'jenis_id' => $jenis_id,
            'template_id' => $template_id,
            'kategori_id' => $kategori_id,
        ]);
    
        return response()->json($add_cart_detail);

    }

    public function cart(Request $request)
    {
        $user_id = auth()->user()->id;

        $profile = Profile::where('user_id', $user_id)->get();

        $cart_detail = CartMerchandise::select('t_cart_merchandise.quantity', 't_cart_merchandise.id', 't_cart_merchandise.merchandise_id', 't_cart_merchandise.is_selected', 
                        'mwk.warna', 'mus.ukuran_seragam', 'mus.id as ukuran_id', 'mus.aliases', 'mm.jenis_id', 't_cart_merchandise.template_id', 'mm.nama_produk', 'mm.harga_awal', 'mm.diskon', 'mm.image_1', 'mm.image_2', 
                        'tdp.nama_siswa', 'tdp.sekolah_id',  'tdp.nama_kelas', 'tdp.image_file', 'mjm.jenis', 'mku.kategori', 'mtd.judul as template', 'mhk.harga as harga_baju' )
                        ->leftJoin('m_merchandise as mm', 'mm.id', 't_cart_merchandise.merchandise_id')
                        ->leftJoin('m_jenis_merchandise as mjm', 'mjm.id', 't_cart_merchandise.jenis_id')
                        ->leftJoin('t_desain_palestineday as tdp', 'tdp.id', 't_cart_merchandise.design_id')
                        ->leftJoin('m_warna_kaos as mwk', 'mwk.id', 't_cart_merchandise.warna_id')
                        ->leftJoin('m_ukuran_seragam as mus', 'mus.id', 't_cart_merchandise.ukuran_id')
                        ->leftJoin('m_kategori_umur as mku', 'mku.id', 't_cart_merchandise.kategori_id') 
                        ->leftJoin('m_template_desain as mtd', 'mtd.id', 't_cart_merchandise.template_id')
                        ->leftJoin('m_harga_kaos as mhk', function($join)
                        { $join->on('mhk.merchandise_id', '=', 'mm.id') 
                            ->on('mhk.kategori_id', '=', 'mku.id');
                        }) 
                        ->where('t_cart_merchandise.user_id', $user_id)
                        ->where('t_cart_merchandise.status_cart', 0)
                        ->get();

        $ukuran = UkuranSeragam::whereNotIn('ukuran_seragam', ['ALL', 'XXS'])->get();

        $total_bayar = CartMerchandise::select('t_cart_merchandise.quantity', 't_cart_merchandise.id', 't_cart_merchandise.merchandise_id', 't_cart_merchandise.is_selected', 
                        'mwk.warna', 'mus.ukuran_seragam', 'mm.jenis_id', 't_cart_merchandise.template_id', 'mm.nama_produk', 'mm.harga_awal', 'mm.diskon', 'mm.image_1', 'mm.image_2', 
                        'tdp.nama_siswa', 'tdp.sekolah_id',  'tdp.nama_kelas', 'tdp.image_file', 'mjm.jenis', 'mku.kategori',  'mhk.harga as harga_baju' )
                        ->leftJoin('m_merchandise as mm', 'mm.id', 't_cart_merchandise.merchandise_id')
                        ->leftJoin('m_jenis_merchandise as mjm', 'mjm.id', 't_cart_merchandise.jenis_id')
                        ->leftJoin('t_desain_palestineday as tdp', 'tdp.id', 't_cart_merchandise.design_id')
                        ->leftJoin('m_warna_kaos as mwk', 'mwk.id', 't_cart_merchandise.warna_id')
                        ->leftJoin('m_ukuran_seragam as mus', 'mus.id', 't_cart_merchandise.ukuran_id')
                        ->leftJoin('m_kategori_umur as mku', 'mku.id', 't_cart_merchandise.kategori_id')
                        ->leftJoin('m_harga_kaos as mhk', function($join)
                        { $join->on('mhk.merchandise_id', '=', 'mm.id') 
                            ->on('mhk.kategori_id', '=', 'mku.id');
                        }) 
                        ->where('t_cart_merchandise.user_id', $user_id)
                        ->where('t_cart_merchandise.status_cart', 0)
                        ->where('t_cart_merchandise.is_selected', 1)
                        ->get();

                        // dd($total_bayar);
        $total_bayar_selected = 0;
        $harga = 0;
        foreach ($total_bayar as $item) {
            $harga_awal = $item->harga_awal;
            $harga_baju = $item->harga_baju;

            if ($harga_baju != null) {
                $harga = $harga_baju;
            } else {
                $harga = $harga_awal;
            }

            $quantity = $item->quantity;
            $jumlah_harga = $harga * $quantity;
            $diskon = $item->diskon;
            $nilai_diskon = ($diskon/100 * $jumlah_harga);

            $total_harga = $jumlah_harga - $nilai_diskon;

            $total_bayar_selected += $total_harga;
        }


        return view('ortu.palestine_day.cart', compact('profile', 'cart_detail', 'total_bayar_selected', 'ukuran'));
    }

    public function update_cart(Request $request, $id) 
    {
        // return response()->json($id);
        $quantity = $request->quantity;
        $is_selected = $request->is_selected;
        $cart_detail = CartMerchandise::where('id', $id)->update([
            'quantity' => $quantity,
            'is_selected' => $is_selected
        ]);


        return response()->json($cart_detail);
    }

    public function update_select_cart(Request $request, $id) 
    {
        // return response($id);
        $is_selected = $request->is_selected;
        $cart_detail = CartMerchandise::where('id', $id)->update([
            'is_selected' => $is_selected
        ]);


        return response()->json($cart_detail);
    }

    public function select_all_cart(Request $request) 
    {
        $user_id = auth()->user()->id;

        if ( isset( $request->checks ) && isset( $request->ids ) ) { 
            $checks = explode( ",", $request->checks ); 
            $ids    = explode( ",", $request->ids ); 
         
            foreach ($checks as $check) {
                foreach ($ids as $id) {
                    $select_all = CartMerchandise::where('id', $id)->update([
                            'is_selected' => $check
                    ]);                    
                }
                $total_bayar = CartMerchandise::select('t_cart_merchandise.quantity', 't_cart_merchandise.id', 't_cart_merchandise.merchandise_id', 't_cart_merchandise.is_selected', 
                                'mwk.warna', 'mus.ukuran_seragam', 'mm.jenis_id', 't_cart_merchandise.template_id', 'mm.nama_produk', 'mm.harga_awal', 'mm.diskon', 'mm.image_1', 'mm.image_2', 
                                'tdp.nama_siswa', 'tdp.sekolah_id',  'tdp.nama_kelas', 'tdp.image_file', 'mjm.jenis', 'mku.kategori', 'mhk.harga as harga_baju' )
                                ->leftJoin('m_merchandise as mm', 'mm.id', 't_cart_merchandise.merchandise_id')
                                ->leftJoin('m_jenis_merchandise as mjm', 'mjm.id', 't_cart_merchandise.jenis_id')
                                ->leftJoin('t_desain_palestineday as tdp', 'tdp.id', 't_cart_merchandise.design_id')
                                ->leftJoin('m_warna_kaos as mwk', 'mwk.id', 't_cart_merchandise.warna_id')
                                ->leftJoin('m_ukuran_seragam as mus', 'mus.id', 't_cart_merchandise.ukuran_id')
                                ->leftJoin('m_kategori_umur as mku', 'mku.id', 't_cart_merchandise.kategori_id')
                                ->leftJoin('m_harga_kaos as mhk', function($join)
                                { $join->on('mhk.merchandise_id', '=', 'mm.id') 
                                    ->on('mhk.kategori_id', '=', 'mku.id');
                                }) 
                                ->where('t_cart_merchandise.user_id', $user_id)
                                ->where('t_cart_merchandise.status_cart', 0)
                                ->where('t_cart_merchandise.is_selected', 1)
                                ->get();
                                
                $total_bayar_selected = 0;

                foreach ($total_bayar as $item) {
                    $harga_awal = $item->harga_awal;
                    $harga_baju = $item->harga_baju;
        
                    if ($harga_baju != null) {
                        $harga = $harga_baju;
                    } else {
                        $harga = $harga_awal;
                    }

                    $quantity = $item->quantity;
                    $jumlah_harga = $harga * $quantity;
                    $diskon = $item->diskon;
                    $nilai_diskon = ($diskon/100 * $jumlah_harga);

                    $total_harga = $jumlah_harga - $nilai_diskon;

                    $total_bayar_selected += $total_harga;
                }
                return response()->json($total_bayar_selected);
            }
        }
    }

    public function remove_cart($id) 
    {
        CartMerchandise::find($id)->delete();

        return redirect()->route('merchandise.cart')
            ->with('error', 'Remove from cart successfully');
    }

    public function pembayaran(Request $request)
    {

        $user_id = auth()->user()->id;

        $order = $request->all();
        
        $profile = Profile::where('user_id', $user_id)->get();
        $cart_detail =  CartMerchandise::select('t_cart_merchandise.quantity', 't_cart_merchandise.id', 't_cart_merchandise.merchandise_id', 't_cart_merchandise.is_selected', 
                        'mwk.warna', 'mus.ukuran_seragam', 'mus.aliases', 'mus.id as ukuran_id', 'mm.jenis_id', 't_cart_merchandise.template_id', 'mm.nama_produk', 'mm.harga_awal', 'mm.diskon', 'mm.image_1', 'mm.image_2', 
                        'tdp.nama_siswa', 'tdp.sekolah_id',  'tdp.nama_kelas', 'tdp.image_file', 'mjm.jenis', 'mku.kategori', 'mtd.judul as template', 'mhk.harga as harga_baju' )
                        ->leftJoin('m_merchandise as mm', 'mm.id', 't_cart_merchandise.merchandise_id')
                        ->leftJoin('m_jenis_merchandise as mjm', 'mjm.id', 't_cart_merchandise.jenis_id')
                        ->leftJoin('t_desain_palestineday as tdp', 'tdp.id', 't_cart_merchandise.design_id')
                        ->leftJoin('m_warna_kaos as mwk', 'mwk.id', 't_cart_merchandise.warna_id')
                        ->leftJoin('m_ukuran_seragam as mus', 'mus.id', 't_cart_merchandise.ukuran_id')
                        ->leftJoin('m_kategori_umur as mku', 'mku.id', 't_cart_merchandise.kategori_id')
                        ->leftJoin('m_template_desain as mtd', 'mtd.id', 't_cart_merchandise.template_id')
                        ->leftJoin('m_harga_kaos as mhk', function($join)
                        { $join->on('mhk.merchandise_id', '=', 'mm.id') 
                            ->on('mhk.kategori_id', '=', 'mku.id');
                        }) 
                        ->where('t_cart_merchandise.user_id', $user_id)
                        ->where('t_cart_merchandise.status_cart', 0)
                        ->where('t_cart_merchandise.is_selected', 1)
                        ->get();

        return view('ortu.palestine_day.pembayaran', compact('profile', 'cart_detail', 'order'));

    }

    public function pre_order(Request $request)
    {
        $user_id = auth()->user()->id;
        
        $order = $request->all();
        $order_dec = json_decode($order['data'], true);
        $count = count($order_dec) - 1;
    
        $merch_id = $order_dec[$count]['merch_id'];
        $quantity = $order_dec[$count]['quantity'];

        $merchandise = Merchandise::find($merch_id);

        $profile = Profile::select('u.id', 'u.no_hp', 'm_profile.sekolah_id', 'm_profile.nama_lengkap', 'm_profile.nama_kelas', 'm_profile.nis')
                    ->leftJoin('mst_lokasi_sub as mls', 'mls.id', 'm_profile.sekolah_id')
                    ->leftJoin('users as u', 'u.no_hp', 'm_profile.no_hp_ibu')
                    ->where('u.id', $user_id)
                    ->first();

        if ($merchandise->jenis_id == '1' || $merchandise->jenis_id == '2') {

            $design_id = $order_dec[$count]['design'];
            $ukuran_id = $order_dec[$count]['ukuran'];
            $warna_id = $order_dec[$count]['warna'];
            $template_id = $order_dec[$count]['template'];
            $kategori_id = $order_dec[$count]['kategori'];
            $get_warna = WarnaKaos::where('id', $warna_id)->first();
            $warna = $get_warna->warna;
            $harga_baju = HargaMerchandise::where('merchandise_id', $merch_id)->where('kategori_id', $kategori_id)->first();

            $template = TemplateDesain::find($template_id);

            $design = DesainPalestineday::find($design_id);
            $kategori = KategoriUmur::find($kategori_id);
            $ukuran = UkuranSeragam::find($ukuran_id);
            
            return view('ortu.palestine_day.pembayaran', compact('order', 'merchandise', 'design', 'kategori', 'quantity', 'ukuran', 'warna', 
            'warna_id', 'design_id', 'kategori_id', 'template', 'harga_baju', 'profile'));

        } else if ($merchandise->jenis_id = '3') {
            $design_id = $order_dec[$count]['design'];
            $ukuran_id = $order_dec[$count]['ukuran'];
            $warna_id = $order_dec[$count]['warna'];
            $template_id = $order_dec[$count]['template'];
            $kategori_id = $order_dec[$count]['kategori'];
            $get_warna = WarnaKaos::where('id', $warna_id)->first();
            $warna = $get_warna->warna;
            $harga_baju = HargaMerchandise::where('merchandise_id', $merch_id)->where('kategori_id', $kategori_id)->first();

            $template = TemplateDesain::find($template_id);
            $design = DesainPalestineday::find($design_id);
            $ukuran = UkuranSeragam::find($ukuran_id);
            
            return view('ortu.palestine_day.pembayaran', compact('order', 'merchandise', 'design', 'quantity', 'ukuran', 'warna', 
            'warna_id', 'design_id', 'kategori_id', 'template', 'harga_baju', 'profile'));
        } else {
            
            return view('ortu.palestine_day.pembayaran', compact( 'merchandise', 'quantity', 'order', 'profile'));

        }

    }

    public function store_order(Request $request)
    {
        $user_id = auth()->user()->id;
        $no_hp = auth()->user()->no_hp;
        $nama_pemesan = auth()->user()->name;
        $no_pesanan = 'INV-MPD-'. date('YmdHis');

        $total_harga_now = $request->total_harga;
        $harga_awal_now = $request->harga_awal;
        $diskon_now = $request->diskon;
        $warna_now = $request->warna;
        $template_now = $request->template;
        $kategori_now = $request->kategori;
        $quantity_now = $request->quantity;
        $ukuran_now = $request->ukuran;
        $merchandise_id_now = $request->merchandise_id;
        $nama_siswa_now = $request->nama_siswa;
        $kelas_now = $request->kelas;
        $sekolah_id_now = $request->sekolah_id;
        $design_now = $request->design_id;
        $hpp_now = $request->hpp;

        if ($total_harga_now == null || $total_harga_now == 'undefined' || $total_harga_now == '') {

            $order = CartMerchandise::select('t_cart_merchandise.quantity', 't_cart_merchandise.id', 't_cart_merchandise.merchandise_id', 't_cart_merchandise.is_selected', 
                    'mwk.warna', 'mwk.id as warna_id', 'mus.ukuran_seragam', 'mus.aliases', 'mm.jenis_id', 't_cart_merchandise.template_id', 't_cart_merchandise.kategori_id', 'mm.nama_produk', 'mm.harga_awal', 'mm.hpp as hpp_awal', 'mm.diskon', 'mm.image_1', 'mm.image_2', 
                    'tdp.nama_siswa', 'tdp.sekolah_id as sekolah', 'tdp.id as design_id', 'tdp.nama_kelas', 'tdp.image_file', 'mus.id as ukuran_id', 'mjm.jenis', 'mku.kategori', 'mtd.judul as template', 'mhk.harga as harga_baju', 'mhk.hpp' )
                    ->leftJoin('m_merchandise as mm', 'mm.id', 't_cart_merchandise.merchandise_id')
                    ->leftJoin('m_jenis_merchandise as mjm', 'mjm.id', 't_cart_merchandise.jenis_id')
                    ->leftJoin('t_desain_palestineday as tdp', 'tdp.id', 't_cart_merchandise.design_id')
                    ->leftJoin('m_warna_kaos as mwk', 'mwk.id', 't_cart_merchandise.warna_id')
                    ->leftJoin('m_ukuran_seragam as mus', 'mus.id', 't_cart_merchandise.ukuran_id')
                    ->leftJoin('m_kategori_umur as mku', 'mku.id', 't_cart_merchandise.kategori_id')
                    ->leftJoin('m_template_desain as mtd', 'mtd.id', 't_cart_merchandise.template_id')
                    ->leftJoin('m_harga_kaos as mhk', function($join)
                    { $join->on('mhk.merchandise_id', '=', 'mm.id') 
                        ->on('mhk.kategori_id', '=', 'mku.id');
                    }) 
                    ->where('t_cart_merchandise.user_id', $user_id)
                    ->where('t_cart_merchandise.status_cart', 0)
                    ->where('t_cart_merchandise.is_selected', 1)
                    ->get();

            $total_harga = 0;
            $total_diskon =0;
            foreach ($order as $item) {
                $nama_siswa = $item['nama_siswa'];
                $lokasi = $item['sekolah'];
                $nama_kelas = $item['nama_kelas'];
                $merchandise_id = $item['merchandise_id'];
                $ukuran_dewasa = $item['ukuran_seragam'];
                $ukuran_anak = $item['aliases'];
                $warna = $item['warna_id'];
                $template = $item['template_id'];
                $kategori = $item['kategori_id'];
                $desgin = $item['design_id'];
                $quantity = $item['quantity'];
                $harga_awal = $item['harga_awal'];
                $harga_baju = $item['harga_baju'];
                $hpp = $item['hpp'];
                $hpp_awal = $item['hpp_awal'];

                if ($harga_baju != null) {
                    $harga = $harga_baju;
                    $harga_pokok = $hpp;
                } else {
                    $harga = $harga_awal;
                    $harga_pokok = $hpp_awal;
                }

                $ukuran = $kategori == 1 ? $ukuran_anak : $ukuran_dewasa;

                $diskon = $item['diskon'];
                $nilai_diskon = $diskon/100 * $harga_awal * $quantity;


                $order_detail = OrderDetailMerchandise::create([
                'no_pesanan' => $no_pesanan,
                'nama_siswa' => $nama_siswa,
                'lokasi_sekolah' => $lokasi,
                'nama_kelas' => $nama_kelas,
                'merchandise_id' => $merchandise_id,
                'ukuran_id' => $ukuran,
                'warna_id' => $warna,
                'template_id' => $template,
                'kategori_id' => $kategori,
                'design_id' => $desgin,
                'quantity' => $quantity,
                'harga' => $harga,
                'persen_diskon' => $diskon,
                'hpp' => $harga_pokok
                ]);

                $total_harga += $harga * $quantity;
                $total_diskon += $nilai_diskon;
                $harga_akhir = $total_harga - $total_diskon;
                $harga_akhir_format = number_format($harga_akhir);

                $this->send_pesan_merchandise_detail($no_pesanan, $nama_siswa, $lokasi, $nama_kelas, $merchandise_id, $warna, $template, $kategori, $desgin, $ukuran, $quantity, $harga, $diskon, $harga_pokok);
                $this->update_cart_status($user_id, $merchandise_id);
            }

            $order_merchandise = OrderMerchandise::create([
                'no_pesanan' => $no_pesanan,
                'no_hp' => $no_hp,
                'nama_pemesan' => $nama_pemesan,
                'status' => 'pending',
                'total_harga' => $harga_akhir,
                'user_id' => $user_id
            ]);

            $this->send_pesan_merchandise($no_pesanan, $nama_pemesan, $no_hp);

                // Set your Merchant Server Key
                \Midtrans\Config::$serverKey = config('midtrans.serverKey');
                // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
                \Midtrans\Config::$isProduction = config('midtrans.isProduction');
                // Set sanitization on (default)
                \Midtrans\Config::$isSanitized = true;
                // Set 3DS transaction for credit card to true
                \Midtrans\Config::$is3ds = true;

            $params = array(
            'transaction_details' => array(
            'order_id' => $no_pesanan,
            'gross_amount' => $harga_akhir,
            ),
            'customer_details' => array(
            'first_name' => $nama_pemesan,
            'phone' => $no_hp,
            )
            );

            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $order_merchandise->snap_token = $snapToken;
            $order_merchandise->save();

            return response()->json($order_merchandise);
        
        } else {
            $order_merchandise = OrderMerchandise::create([
                'no_pesanan' => $no_pesanan,
                'no_hp' => $no_hp,
                'nama_pemesan' => $nama_pemesan,
                'status' => 'pending',
                'total_harga' => $total_harga_now,
                'user_id' => $user_id
            ]);

            $order_detail = OrderDetailMerchandise::create([
                'no_pesanan' => $no_pesanan,
                'nama_siswa' => $nama_siswa_now,
                'lokasi_sekolah' => $sekolah_id_now,
                'nama_kelas' => $kelas_now,
                'merchandise_id' => $merchandise_id_now,
                'ukuran_id' => $ukuran_now,
                'warna_id' => $warna_now,
                'template_id' => $template_now,
                'kategori_id' => $kategori_now,
                'design_id' => $design_now,
                'quantity' => $quantity_now,
                'harga' => $total_harga_now,
                'persen_diskon' => $diskon_now,
                'hpp' => $hpp_now
            ]);

            $this->send_pesan_merchandise($no_pesanan, $nama_pemesan, $no_hp);
            $this->send_pesan_merchandise_detail($no_pesanan, $nama_siswa_now, $sekolah_id_now, $kelas_now, $merchandise_id_now, $warna_now, $template_now, $kategori_now, $design_now, $ukuran_now, $quantity_now, $total_harga_now, $diskon_now, $hpp_now);

               // Set your Merchant Server Key
               \Midtrans\Config::$serverKey = config('midtrans.serverKey');
               // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
               \Midtrans\Config::$isProduction = config('midtrans.isProduction');
               // Set sanitization on (default)
               \Midtrans\Config::$isSanitized = true;
               // Set 3DS transaction for credit card to true
               \Midtrans\Config::$is3ds = true;

           $params = array(
           'transaction_details' => array(
           'order_id' => $no_pesanan,
           'gross_amount' => $total_harga_now,
           ),
           'customer_details' => array(
           'first_name' => $nama_pemesan,
           'phone' => $no_hp,
           )
           );

           $snapToken = \Midtrans\Snap::getSnapToken($params);
           $order_merchandise->snap_token = $snapToken;
           $order_merchandise->save();

           return response()->json($order_merchandise);
        }
    }

    public function callback(Request $request) {
        
        $serverKey = config('midtrans.serverKey');
        $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);

        if ($hashed !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature key'], 403);
        }

        $transactionStatus = $request->transaction_status;
        $mtd_pembayaran = null;
        $no_va = null;
        $paymentType = $request->payment_type;

        if ($paymentType == 'shopeepay' || $paymentType == 'gopay' || $paymentType == 'qris') {
            $mtd_pembayaran = $paymentType;
            $no_va = 0;
        } else if ($paymentType == 'bank_transfer' && !$request->permata_va_number) {
            $va_number = $request->va_numbers[0]['va_number'];
            
            $bank = $request->va_numbers[0]['bank'];

            $mtd_pembayaran = $bank;
            $no_va = $va_number;
            // return response()->json($no_va);
        } else if ($paymentType == 'bank_transfer' && $request->permata_va_number) {
            $va_number = $request->permata_va_number;
            
            $bank = 'Permata';

            $mtd_pembayaran = $bank;
            $no_va = $va_number;
        } else if($paymentType == 'echannel') {
            $no_va = $request->bill_key;
            $mtd_pembayaran = 'Mandiri';
        }
        $orderId = $request->order_id;
        $order = OrderMerchandise::where('no_pesanan', $orderId)->first();
       
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

         $order_detail = OrderDetailMerchandise::where('no_pesanan', $orderId)->get();

        switch ($transactionStatus) {
            case 'capture':
                if ($request->payment_type == 'credit_card') {
                    if ($request->fraud_status == 'challenge') {
                        $order->update([
                            'status' => 'pending',
                            'metode_pembayaran' => $mtd_pembayaran,
                            'va_number' => $no_va
                        ]);
                    } else {
                        $order->update([
                            'status' => 'success',
                            'metode_pembayaran' => $mtd_pembayaran,
                            'va_number' => $no_va
                        ]);
                    }
                }
                break;
            case 'settlement':
                $order->update([
                    'status' => 'success',
                    'metode_pembayaran' => $mtd_pembayaran,
                    'va_number' => $no_va,
                    'updated_at' => $request->settlement_time
                ]);
                foreach ($order_detail as $item) {
                    $kode_produk = $item->kode_produk;
                    $quantity = $item->quantity;

                };
                $this->update_status_seragam('success', $mtd_pembayaran, $orderId);
                break;
            case 'pending':
                $order->update([
                    'status' => 'pending',
                    'metode_pembayaran' => $mtd_pembayaran,
                    'va_number' => $no_va,
                    'expire_time' => $request->expiry_time
                ]);
                foreach ($order_detail as $item) {
                    $kode_produk = $item->kode_produk;
                    $quantity = $item->quantity;
                }
                $this->update_status_seragam('pending', $mtd_pembayaran, $orderId);
                break;
            case 'deny':
                $order->update([
                    'status' => 'failed',
                    'metode_pembayaran' => $mtd_pembayaran,
                    'va_number' => $no_va
                ]);
                foreach ($order_detail as $item) {
                    $kode_produk = $item->kode_produk;
                    $quantity = $item->quantity;
                }
                break;
            case 'expire':
                $order->update([
                    'status' => 'expired',
                    'metode_pembayaran' => $mtd_pembayaran,
                    'va_number' => $no_va
                ]);
                // foreach ($order_detail as $item) {
                //     $kode_produk = $item->kode_produk;
                //     $quantity = $item->quantity;

                // }
                // $this->update_status_seragam('expired', $mtd_pembayaran, $orderId);
                break;
            case 'cancel':
                $order->update([
                    'status' => 'canceled',
                    'metode_pembayaran' => $mtd_pembayaran,
                    'va_number' => $no_va
                ]);
               
                break;
            default:
                $order->update([
                    'status' => 'unknown',
                ]);
                break;
        }

        return response()->json(['message' => 'Callback received successfully']);
    }

    public function update_cart_status($user_id, $merch_id) 
    {
        $cart_detail = CartMerchandise::where('user_id', $user_id)
                ->where('status_cart', 0)
                ->where('merchandise_id', $merch_id)
                ->where('is_selected', 1)
                ->first();
        
        $update_status_cart = $cart_detail->update([
            'status_cart' => 1
        ]);

        return response()->json($update_status_cart);
    }

    function send_pesan_merchandise($no_pesanan, $nama_pemesan, $no_hp){
	    $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'http://103.135.214.11:81/qlp_system/api_regist/simpan_pesan_merchandise.php',
		  CURLOPT_RETURNTRANSFER => 1,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  // CURLOPT_SSL_VERIFYPEER => false,
		  // CURLOPT_SSL_VERIFYHOST => false,
		  CURLOPT_POSTFIELDS => array(
		  	'no_pesanan' => $no_pesanan,
		  	'nama_pemesan' => $nama_pemesan,
		  	'no_hp' => $no_hp)

		));

		$response = curl_exec($curl);

		// echo $response;
		curl_close($curl);
	    // return ($response);
	}

    function send_pesan_merchandise_detail($no_pesanan, $nama_siswa, $lokasi_sekolah, $nama_kelas, $merchandise_id, $warna_id, $template_id, $kategori_id, $design_id, $ukuran, $quantity, $harga, $diskon, $hpp){
	    $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'http://103.135.214.11:81/qlp_system/api_regist/simpan_pesan_merchandise_detail.php',
		  CURLOPT_RETURNTRANSFER => 1,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  // CURLOPT_SSL_VERIFYPEER => false,
		  // CURLOPT_SSL_VERIFYHOST => false,
		  CURLOPT_POSTFIELDS => array(
		  	'no_pesanan' => $no_pesanan,
		  	'nama_siswa' => $nama_siswa,
		  	'lokasi_sekolah' => $lokasi_sekolah,
		  	'nama_kelas' => $nama_kelas,
		  	'merchandise_id' => $merchandise_id,
		  	'warna_id' => $warna_id,
		  	'template_id' => $template_id,
		  	'kategori_id' => $kategori_id,
		  	'design_id' => $design_id,
		  	'ukuran' => $ukuran,
		  	'quantity' => $quantity,
		  	'harga' => $harga,
		  	'diskon' => $diskon,
		  	'hpp' => $hpp,
            )

		));

		$response = curl_exec($curl);

		// echo $response;
		curl_close($curl);
	    // return ($response);
	}

}
