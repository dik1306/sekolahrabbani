<?php

namespace App\Http\Controllers;

use App\Exports\SalesJerseyExport;
use App\Models\CartJersey;
use App\Models\JenisEkskul;
use App\Models\Jenjang;
use App\Models\Jersey;
use App\Models\LokasiSub;
use App\Models\MenuMobile;
use App\Models\JerseyImage;
use App\Models\OrderDetailJersey;
use App\Models\OrderJersey;
use App\Models\Profile;
use App\Models\UkuranSeragam;
use App\Models\UkuranJersey;
use Barryvdh\DomPDF\Facade\Pdf;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class JerseyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $menubar = MenuMobile::where('is_footer', 1)->orderBy('no', 'asc')->get();
        $jenjang = Jenjang::select('nama_jenjang', 'value')->get();

        $list_jersey = Jersey::where('status', 1)->get();
        $jersey_futsal = Jersey::where('status', 1)->where('ekskul_id', 1)->get();
        $jersey_badminton = Jersey::where('status', 1)->where('ekskul_id', 3)->get();
        $jersey_basket = Jersey::where('status', 1)->where('ekskul_id', 2)->get();
        $jersey_memanah = Jersey::where('status', 1)->where('ekskul_id', 5)->get();

        $cart_detail = CartJersey::select('t_cart_jersey.quantity', 't_cart_jersey.id', 't_cart_jersey.jersey_id', 't_cart_jersey.is_selected', 
                        'mus.ukuran_seragam', 'mj.nama_jersey', 'mj.harga_awal', 'mj.persen_diskon', 'mj.image_1', 'mj.image_2')
                        ->leftJoin('m_jersey as mj', 'mj.id', 't_cart_jersey.jersey_id')
                        ->leftJoin('m_ukuran_seragam as mus', 'mus.id', 't_cart_jersey.ukuran_id')
                        ->where('t_cart_jersey.user_id', $user_id)
                        ->where('t_cart_jersey.status_cart', 0)
                        ->get();

        // TODO: KEPERLUAN TESTING
        $akses = request()->query('akses'); // atau bisa menggunakan request('akses')
        if ($akses === 'admindopi') {
            // Logika jika akses diizinkan
            return view('ortu.jersey.index', compact('menubar', 'jenjang', 'list_jersey', 'cart_detail', 'jersey_futsal', 'jersey_badminton',
                        'jersey_basket', 'jersey_memanah'));
        } else {
            return view('ortu.jersey.closed', compact('menubar', 'jenjang', 'list_jersey', 'cart_detail', 'jersey_futsal', 'jersey_badminton',
                        'jersey_basket', 'jersey_memanah'));
        }
        // return view('ortu.jersey.index', compact('menubar', 'jenjang', 'list_jersey', 'cart_detail', 'jersey_futsal', 'jersey_badminton',
        //            'jersey_basket', 'jersey_memanah'));

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
            $nama_jersey = $request->nama_jersey;
            $deskripsi = $request->deskripsi;
            $jenis_ekskul = $request->jenis_ekskul;
            $jenis_kelamin = $request->jenis_kelamin;
            $jenjang = $request->jenjang;
            $harga = $request->harga;
            $diskon = $request->diskon;

            $path = 'jersey/' .$jenis_ekskul. '/'. $jenis_kelamin;
            $images = [];
            $isSizeChart = false;

            // Menginisialisasi image_url untuk setiap gambar
            for ($i = 1; $i <= 7; $i++) {
                $image_key = 'image_' . $i;
                $image_url = null;
                
                if ($request->has($image_key)) {
                    $image_name = $request->file($image_key)->getClientOriginalName();
                    $image_url = $path . '/' . $image_name;
                    Storage::disk('public')->put($image_url, file_get_contents($request->file($image_key)->getRealPath()));
                    $images[$i] = $image_url;  // Menyimpan URL gambar sesuai index
                }
            }

            // Menambahkan data Jersey
            $add_jersey = Jersey::create([
                'nama_jersey' => $nama_jersey,
                'ekskul_id' => $jenis_ekskul,
                'jenis_kelamin' => $jenis_kelamin,
                'jenjang_id' => $jenjang,
                'deskripsi' => $deskripsi,
                'harga_awal' => $harga,
                'persen_diskon' => $diskon,
                'status' => 1,
                'image_1' => isset($images[1]) ? $images[1] : null,
                'image_2' => isset($images[2]) ? $images[2] : null,
                'image_3' => isset($images[3]) ? $images[3] : null,
                'image_4' => isset($images[4]) ? $images[4] : null,
                'image_5' => isset($images[5]) ? $images[5] : null,
                'image_6' => isset($images[6]) ? $images[6] : null,
                'image_7' => isset($images[7]) ? $images[7] : null,
            ]);

            foreach ($images as $index => $image_url) {
                if ($image_url) {
                    $isSizeChart = ($index == 6 || $index == 7) ? true : false;

                    // Menyimpan data ke tabel m_jersey_images
                    $jerseyImage = JerseyImage::create([
                        'jersey_id' => $add_jersey->id,
                        'image_url' => $image_url,
                        'isSizeChart' => $isSizeChart,
                    ]); 
                }
            }

            return redirect()->back()->with('success', 'Berhasil tambah Jersey');
        } catch (\Throwable $th) {
            // Tangani kesalahan jika terjadi
            return redirect()->back()->with('error', 'Terjadi kesalahan, silakan coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jersey  $jersey
     * @return \Illuminate\Http\Response
     */
    public function show(Jersey $jersey)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jersey  $jersey
     * @return \Illuminate\Http\Response
     */
    public function edit(Jersey $jersey)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jersey  $jersey
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jersey $jersey)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jersey  $jersey
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jersey $jersey)
    {
        //
    }

    public function index_master()
    {
      $jersey = Jersey::select('m_jersey.nama_jersey', 'mjen.nama_jenjang', 'muj.kode_produk', 'muj.ukuran_jersey', 'm_jersey.harga_awal', 'm_jersey.persen_diskon')
            ->leftJoin('m_jenjang as mjen', 'mjen.value', '=', 'm_jersey.jenjang_id')  // Menyambungkan m_jenjang ke m_jersey
            ->join('m_ukuran_jersey as muj', 'muj.jersey_id', '=', 'm_jersey.id')  // Menyambungkan m_ukuran_jersey ke m_jersey
            ->get();

        $jenis_ekskul = JenisEkskul::all();
        $jenjang = Jenjang::whereIn('id', ['3','4'])->get();

        return view('admin.master.jersey', compact('jersey', 'jenis_ekskul', 'jenjang'));
    }

    public function detail_order(Request $request, $id, $jersey_id, $no_punggung)
    {
        $order_detail = OrderDetailJersey::select('t_pesan_jersey_detail.nama_siswa', 't_pesan_jersey_detail.lokasi_sekolah', 't_pesan_jersey_detail.jersey_id',
                        't_pesan_jersey_detail.nama_kelas', 'mj.nama_jersey','t_pesan_jersey_detail.persen_diskon', 't_pesan_jersey_detail.ukuran_id',
                        'tpj.no_pesanan', 't_pesan_jersey_detail.nama_punggung', 't_pesan_jersey_detail.no_punggung')
                        ->leftJoin('t_pesan_jersey as tpj', 'tpj.no_pesanan', 't_pesan_jersey_detail.no_pesanan')
                        ->leftJoin('m_jersey as mj', 'mj.id', 't_pesan_jersey_detail.jersey_id')
                        ->leftJoin('m_ukuran_seragam as mus', 'mus.id', 't_pesan_jersey_detail.ukuran_id')
                        ->where('tpj.no_pesanan', $id)
                        ->where('t_pesan_jersey_detail.jersey_id', $jersey_id)
                        ->where('t_pesan_jersey_detail.no_punggung', $no_punggung)
                        ->first();

        return response($order_detail);
    }

    public function create_jenis_ekskul(Request $request)
    {
        $add_jenis = JenisEkskul::create([
            'ekskul' => $request->nama_ekskul,
            'status' => 1
        ]);

        return redirect()->back();
    }

    public function detail_jersey(Request $request, $id)
    {
        $user_id = auth()->user()->id;
        $no_hp = auth()->user()->no_hp;
        $produk = Jersey::find($id);
        $role_id = auth()->user()->id_role;


        $ukuran = UkuranJersey::select('ukuran_jersey', 'm_ukuran_seragam.id as id')  // Pilih kolom dari kedua tabel
            ->join('m_ukuran_seragam', 'm_ukuran_jersey.ukuran_jersey', '=', 'm_ukuran_seragam.ukuran_seragam')  // Join berdasarkan ukuran_jersey dan ukuran_seragam
            ->where('jersey_id', $id)  // Kondisi jersey_id
            ->where('is_aktif', true)  // Kondisi is_aktif
            ->get();
        
        $profile = Profile::get_user_profile_byphone($no_hp);

        $cart_detail = CartJersey::select('t_cart_jersey.quantity', 't_cart_jersey.id', 't_cart_jersey.jersey_id', 't_cart_jersey.is_selected', 
                        'mus.ukuran_seragam', 'mj.nama_jersey', 'mj.harga_awal', 'mj.persen_diskon', 'mj.image_1', 'mj.image_2')
                        ->leftJoin('m_jersey as mj', 'mj.id', 't_cart_jersey.jersey_id')
                        ->leftJoin('m_ukuran_seragam as mus', 'mus.id', 't_cart_jersey.ukuran_id')
                        ->where('t_cart_jersey.user_id', $user_id)
                        ->where('t_cart_jersey.status_cart', 0)
                        ->get();

        $jersey_images = JerseyImage::where('jersey_id', $id)->get();

        $jersey_size_chart = JerseyImage::where('jersey_id', $id)->where('isSizeChart',true)->get();

        return view('ortu.jersey.detail', compact('produk', 'profile', 'ukuran', 'cart_detail', 'role_id', 'jersey_images', 'jersey_size_chart'));
        
    }

    public function add_to_cart(Request $request)
    {
        $jersey_id = $request->produk_id;
        $ukuran_id = $request->ukuran;
        $quantity = $request->quantity;
        $nis = $request->nis;
        $nama_punggung = $request->nama_punggung;
        $no_punggung = $request->no_punggung;
        $user_id = auth()->user()->id;

        $add_cart_detail =  CartJersey::create([
            'jersey_id' => $jersey_id,
            'user_id' => $user_id,
            'quantity' => $quantity,
            'nis' => $nis,
            'nama_punggung' => $nama_punggung,
            'no_punggung' => $no_punggung,
            'ukuran_id' => $ukuran_id,
        ]);
    
        return response()->json($add_cart_detail);

    }

    public function cart(Request $request)
    {
        $user_id = auth()->user()->id;
        $profile = Profile::select('mls.sublokasi')
                        ->leftJoin('mst_lokasi_sub as mls', 'mls.id', 'm_profile.sekolah_id') 
                        ->where('user_id', $user_id)
                        ->first();

        $cart_detail = CartJersey::select('t_cart_jersey.quantity', 't_cart_jersey.id', 't_cart_jersey.jersey_id', 't_cart_jersey.is_selected', 
                        'mus.ukuran_seragam', 'mj.nama_jersey', 'mj.ekskul_id', 'mj.harga_awal', 'mj.persen_diskon', 'mj.image_1', 'mj.image_2', 'mp.nama_lengkap',
                        'mls.sublokasi', 'mp.nama_kelas', 't_cart_jersey.nama_punggung', 't_cart_jersey.no_punggung')
                        ->leftJoin('m_jersey as mj', 'mj.id', 't_cart_jersey.jersey_id')
                        ->leftJoin('m_ukuran_seragam as mus', 'mus.id', 't_cart_jersey.ukuran_id')
                        ->leftJoin('m_profile as mp', 'mp.nis', 't_cart_jersey.nis')
                        ->leftJoin('mst_lokasi_sub as mls', 'mls.id', 'mp.sekolah_id')
                        ->where('t_cart_jersey.user_id', $user_id)
                        ->where('t_cart_jersey.status_cart', 0)
                        ->get();

        $ukuran = UkuranSeragam::whereNotIn('ukuran_seragam', ['ALL', 'XXS'])->get();

        $total_bayar = CartJersey::select('t_cart_jersey.quantity', 't_cart_jersey.id', 't_cart_jersey.jersey_id', 't_cart_jersey.is_selected', 
                        'mus.ukuran_seragam', 'mj.nama_jersey', 'mj.harga_awal', 'mj.persen_diskon', 'mj.image_1', 'mj.image_2')
                        ->leftJoin('m_jersey as mj', 'mj.id', 't_cart_jersey.jersey_id')
                        ->leftJoin('m_ukuran_seragam as mus', 'mus.id', 't_cart_jersey.ukuran_id')
                        ->where('t_cart_jersey.user_id', $user_id)
                        ->where('t_cart_jersey.status_cart', 0)
                        ->where('t_cart_jersey.is_selected', 1)
                        ->get();

        $total_bayar_selected = 0;
        $harga = 0;
        foreach ($total_bayar as $item) {
            $harga_awal = $item->harga_awal;
            $quantity = $item->quantity;
            $jumlah_harga = $harga_awal * $quantity;
            $diskon = $item->persen_diskon;
            $nilai_diskon = ($diskon/100 * $jumlah_harga);

            $total_harga = $jumlah_harga - $nilai_diskon;

            $total_bayar_selected += $total_harga;
        }


        return view('ortu.jersey.cart', compact('profile', 'cart_detail', 'total_bayar_selected', 'ukuran'));
    }

    public function update_cart(Request $request, $id) 
    {
        // return response()->json($id);
        $quantity = $request->quantity;
        $is_selected = $request->is_selected;
        $cart_detail = CartJersey::where('id', $id)->update([
            'quantity' => $quantity,
            'is_selected' => $is_selected
        ]);


        return response()->json($cart_detail);
    }

    public function update_select_cart(Request $request, $id) 
    {
        // return response($id);
        $is_selected = $request->is_selected;
        $cart_detail = CartJersey::where('id', $id)->update([
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
                    $select_all = CartJersey::where('id', $id)->update([
                            'is_selected' => $check
                    ]);                    
                }
                $total_bayar = CartJersey::select('t_cart_jersey.quantity', 't_cart_jersey.id', 't_cart_jersey.jersey_id', 't_cart_jersey.is_selected', 
                            'mus.ukuran_seragam', 'mj.nama_jersey', 'mj.harga_awal', 'mj.persen_diskon', 'mj.image_1', 'mj.image_2')
                            ->leftJoin('m_jersey as mj', 'mj.id', 't_cart_jersey.jersey_id')
                            ->leftJoin('m_ukuran_seragam as mus', 'mus.id', 't_cart_jersey.ukuran_id')
                            ->where('t_cart_jersey.user_id', $user_id)
                            ->where('t_cart_jersey.status_cart', 0)
                            ->where('t_cart_jersey.is_selected', 1)
                            ->get();
                                
                $total_bayar_selected = 0;

                foreach ($total_bayar as $item) {
                    $harga_awal = $item->harga_awal;
                    $quantity = $item->quantity;
                    $jumlah_harga = $harga_awal * $quantity;
                    $diskon = $item->persen_diskon;
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
        CartJersey::find($id)->delete();

        return redirect()->route('jersey.cart')
            ->with('error', 'Remove from cart successfully');
    }

    public function pembayaran(Request $request)
    {

        $user_id = auth()->user()->id;

        $order = $request->all();
        
        $profile = Profile::select('mls.sublokasi')
                        ->leftJoin('mst_lokasi_sub as mls', 'mls.id', 'm_profile.sekolah_id') 
                        ->where('user_id', $user_id)
                        ->first();

        $cart_detail = CartJersey::select('t_cart_jersey.quantity', 't_cart_jersey.id', 't_cart_jersey.jersey_id', 't_cart_jersey.is_selected', 
                    'mus.ukuran_seragam', 'mj.nama_jersey', 'mj.harga_awal', 'mj.persen_diskon', 'mj.image_1', 'mj.image_2', 'mp.nama_lengkap',
                    'mls.sublokasi', 'mp.nama_kelas', 't_cart_jersey.nama_punggung', 't_cart_jersey.no_punggung', 'mj.ekskul_id')
                    ->leftJoin('m_jersey as mj', 'mj.id', 't_cart_jersey.jersey_id')
                    ->leftJoin('m_ukuran_seragam as mus', 'mus.id', 't_cart_jersey.ukuran_id')
                    ->leftJoin('m_profile as mp', 'mp.nis', 't_cart_jersey.nis')
                    ->leftJoin('mst_lokasi_sub as mls', 'mls.id', 'mp.sekolah_id')
                    ->where('t_cart_jersey.user_id', $user_id)
                    ->where('t_cart_jersey.status_cart', 0)
                    ->where('t_cart_jersey.is_selected', 1)
                    ->get();

        return view('ortu.jersey.pembayaran', compact('profile', 'cart_detail', 'order'));

    }

    public function pre_order(Request $request)
    {
        $user_id = auth()->user()->id;
        
        $order = $request->all();
        $order_dec = json_decode($order['data'], true);
        $count = count($order_dec) - 1;
    
        $jersey_id = $order_dec[$count]['jersey_id'];
        $quantity = $order_dec[$count]['quantity'];
        $ukuran_id = $order_dec[$count]['ukuran'];
        $nis = $order_dec[$count]['nis'];
        $nama_punggung = $order_dec[$count]['nama_punggung'];
        $no_punggung = $order_dec[$count]['no_punggung'];


        $ukuran = UkuranSeragam::find($ukuran_id);

        $jersey = Jersey::find($jersey_id);

        $profile = Profile::select('u.id', 'u.no_hp', 'm_profile.sekolah_id', 'mls.sublokasi', 'm_profile.nama_lengkap', 'm_profile.nama_kelas', 'm_profile.nis')
                    ->leftJoin('mst_lokasi_sub as mls', 'mls.id', 'm_profile.sekolah_id')
                    ->leftJoin('users as u', 'u.no_hp', 'm_profile.no_hp_ibu')
                    ->where('u.id', $user_id)
                    ->where('m_profile.nis', $nis)
                    ->first();

        // dd($profile);
        
        return view('ortu.jersey.pembayaran', compact( 'jersey', 'quantity', 'order', 'profile', 'nis', 'ukuran', 'nama_punggung', 'no_punggung'));

    }

    public function store_order(Request $request)
    {
        $user_id = auth()->user()->id;
        $no_hp = auth()->user()->no_hp;
        $nama_pemesan = auth()->user()->name;
        $no_pesanan = 'INV-JRS-'.$user_id.'-'. date('YmdHis');
        $profile = Profile::select('sekolah_id')
                        ->where('user_id', $user_id)
                        ->first();

        $total_harga_now = $request->total_harga;
        $harga_awal_now = $request->harga_awal;
        $diskon_now = $request->diskon_persen;
        $quantity_now = $request->quantity;
        $ukuran_now = $request->ukuran;
        $jersey_id_now = $request->jersey_id;
        $nis_now = $request->nis;
        $hpp_now = $request->hpp;
        $nama_punggung_now = $request->nama_punggung;
        $no_punggung_now = $request->no_punggung;

        if ($total_harga_now == null || $total_harga_now == 'undefined' || $total_harga_now == '') {

            $order = CartJersey::select('t_cart_jersey.quantity', 't_cart_jersey.id', 't_cart_jersey.jersey_id', 't_cart_jersey.is_selected', 
                    't_cart_jersey.nama_punggung', 't_cart_jersey.no_punggung','mus.ukuran_seragam', 'mj.nama_jersey', 'mj.harga_awal', 'mj.persen_diskon as diskon', 
                    'mj.hpp', 'mj.image_1', 'mj.image_2', 'mp.nama_lengkap','mp.sekolah_id as sekolah', 'mp.nama_kelas', 'mj.ekskul_id')
                    ->leftJoin('m_jersey as mj', 'mj.id', 't_cart_jersey.jersey_id')
                    ->leftJoin('m_ukuran_seragam as mus', 'mus.id', 't_cart_jersey.ukuran_id')
                    ->leftJoin('m_profile as mp', 'mp.nis', 't_cart_jersey.nis')
                    ->leftJoin('mst_lokasi_sub as mls', 'mls.id', 'mp.sekolah_id')
                    ->where('t_cart_jersey.user_id', $user_id)
                    ->where('t_cart_jersey.status_cart', 0)
                    ->where('t_cart_jersey.is_selected', 1)
                    ->get();
            
            $total_harga = 0;
            $total_diskon =0;
            foreach ($order as $item) {
                $nama_siswa = $item['nama_lengkap'];
                $lokasi = $item['sekolah'];
                if ($lokasi != null) {
                    $lokasi_sekolah = $lokasi;
                } else {
                    $lokasi_sekolah = $profile->sekolah_id;
                }
                $nama_kelas = $item['nama_kelas'];
                $jersey_id = $item['jersey_id'];
                $ukuran = $item['ukuran_seragam'];
                $quantity = $item['quantity'];
                $harga_awal = $item['harga_awal'];
                $hpp = $item['hpp'];
                $nama_punggung = $item['nama_punggung'];
                $no_punggung = $item['no_punggung'];
                $diskon = $item['diskon'];
                $nilai_diskon = $diskon/100 * $harga_awal * $quantity;


                $order_detail = OrderDetailJersey::create([
                'no_pesanan' => $no_pesanan,
                'nama_siswa' => $nama_siswa,
                'lokasi_sekolah' => $lokasi_sekolah,
                'nama_kelas' => $nama_kelas,
                'jersey_id' => $jersey_id,
                'ukuran_id' => $ukuran,
                'quantity' => $quantity,
                'harga' => $harga_awal,
                'persen_diskon' => $diskon,
                'nama_punggung' => $nama_punggung,
                'no_punggung' => $no_punggung,
                'hpp' => $hpp,
                'created_at' => Carbon::now(), // Menetapkan waktu saat ini untuk created_at
                'updated_at' => Carbon::now()  // Menetapkan waktu saat ini untuk updated_at
                ]);

                $total_harga += $harga_awal * $quantity;
                $total_diskon += $nilai_diskon;
                $harga_akhir = $total_harga - $total_diskon;

                $this->send_pesan_jersey_detail($no_pesanan, $nama_siswa, $lokasi, $nama_kelas, $jersey_id, $ukuran, $quantity, $harga_awal, $diskon, $hpp, $no_punggung, $nama_punggung);
                $this->send_pesan_jersey_detail_baru($no_pesanan, $nama_siswa, $lokasi, $nama_kelas, $jersey_id, $ukuran, $quantity, $harga_awal, $diskon, $hpp, $no_punggung, $nama_punggung);
                $this->update_cart_status($user_id, $jersey_id);
            }

            $order_jersey = OrderJersey::create([
                'no_pesanan' => $no_pesanan,
                'no_hp' => $no_hp,
                'nama_pemesan' => $nama_pemesan,
                'status' => 'pending',
                'total_harga' => $harga_akhir,
                'user_id' => $user_id
            ]);

            $this->send_pesan_jersey($no_pesanan, $nama_pemesan, $no_hp);
            $this->send_pesan_jersey_baru($no_pesanan, $nama_pemesan, $no_hp);

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
            $order_jersey->snap_token = $snapToken;
            $order_jersey->save();

            return response()->json($order_jersey);
        
        } else {

            if ($nis_now != '0000') {
                $get_siswa = Profile::where('nis', $nis_now)->first();
                $nama_lengkap = $get_siswa->nama_lengkap;
                $sekolah_id = $get_siswa->sekolah_id;
                $nama_kelas = $get_siswa->nama_kelas;
            } else {
                $get_profile = Profile::where('user_id', $user_id)->first();
                $nama_lengkap = auth()->user()->name;
                $sekolah_id = $get_profile->sekolah_id;
                $nama_kelas = '-';
            }

            $get_jersey = Jersey::where('id', $jersey_id_now)->first();

            $order_jersey = OrderJersey::create([
                'no_pesanan' => $no_pesanan,
                'no_hp' => $no_hp,
                'nama_pemesan' => $nama_pemesan,
                'status' => 'pending',
                'total_harga' => $total_harga_now,
                'user_id' => $user_id
            ]);

            $order_detail = OrderDetailJersey::create([
                'no_pesanan' => $no_pesanan,
                'nama_siswa' => $nama_lengkap,
                'lokasi_sekolah' => $sekolah_id,
                'nama_kelas' => $nama_kelas,
                'jersey_id' => $jersey_id_now,
                'ukuran_id' => $ukuran_now,
                'quantity' => $quantity_now,
                'harga' => $get_jersey->harga_awal,
                'persen_diskon' => $diskon_now,
                'nama_punggung' => $nama_punggung_now,
                'no_punggung' => $no_punggung_now,
                'hpp' => $hpp_now,
                'created_at' => Carbon::now(), // Menetapkan waktu saat ini untuk created_at
                'updated_at' => Carbon::now()  // Menetapkan waktu saat ini untuk updated_at
            ]);

            $this->send_pesan_jersey($no_pesanan, $nama_pemesan, $no_hp);
            $this->send_pesan_jersey_baru($no_pesanan, $nama_pemesan, $no_hp);

            $this->send_pesan_jersey_detail($no_pesanan, $nama_lengkap, $sekolah_id, $nama_kelas, $jersey_id_now, $ukuran_now, $quantity_now, $get_jersey->harga_awal, $diskon_now, $hpp_now, $no_punggung_now, $nama_punggung_now);
            $this->send_pesan_jersey_detail_baru($no_pesanan, $nama_lengkap, $sekolah_id, $nama_kelas, $jersey_id_now, $ukuran_now, $quantity_now, $get_jersey->harga_awal, $diskon_now, $hpp_now, $no_punggung_now, $nama_punggung_now);

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
           $order_jersey->snap_token = $snapToken;
           $order_jersey->save();

           return response()->json($order_jersey);
        }
    }

    public function rincian_pesanan (Request $request, $id) {
        $user_id = auth()->user()->id;

        $order = OrderJersey::where('no_pesanan', $id)->first();
        $order_detail = OrderDetailJersey::select('t_pesan_jersey_detail.nama_siswa', 't_pesan_jersey_detail.lokasi_sekolah', 'mj.persen_diskon',
                        't_pesan_jersey_detail.nama_kelas', 'mj.nama_jersey', 'mj.image_1', 'mj.harga_awal', 'mus.ukuran_seragam', 't_pesan_jersey_detail.harga', 
                        't_pesan_jersey_detail.persen_diskon', 't_pesan_jersey_detail.quantity', 't_pesan_jersey_detail.ukuran_id', 'mj.ekskul_id',
                        't_pesan_jersey_detail.created_at', 'tpj.metode_pembayaran', 'tpj.no_pesanan', 't_pesan_jersey_detail.nama_punggung', 't_pesan_jersey_detail.no_punggung',
                        't_pesan_jersey_detail.status_do', 't_pesan_jersey_detail.tgl_do', 't_pesan_jersey_detail.status_order', 't_pesan_jersey_detail.status_terima_tu',
                        't_pesan_jersey_detail.tgl_terima_tu', 't_pesan_jersey_detail.status_distribusi_tu', 't_pesan_jersey_detail.tgl_distribusi_tu', 
                        't_pesan_jersey_detail.tgl_terima_ortu', 't_pesan_jersey_detail.tgl_retur', )
                        ->leftJoin('t_pesan_jersey as tpj', 'tpj.no_pesanan', 't_pesan_jersey_detail.no_pesanan')
                        ->leftJoin('m_jersey as mj', 'mj.id', 't_pesan_jersey_detail.jersey_id')
                        ->leftJoin('m_ukuran_seragam as mus', 'mus.id', 't_pesan_jersey_detail.ukuran_id')
                        ->where('tpj.no_pesanan', $id)
                        ->get();

        $tglPesan = $order->created_at->format('Y-m-d');

        $orderStatus = $order->status == 'success';
        $tglUpdateBaru = Carbon::parse($tglPesan)->gte(Carbon::parse('2025-08-01'));
        // dd($tglUpdateBaru);

        return view('ortu.jersey.rincian-pesan', compact( 'order', 'order_detail', 'orderStatus', 'tglUpdateBaru'));
    }

    public function terimaJersey($no_pemesanan, $tgl_terima_ortu) { 
        // Ambil ID pengguna yang sedang login
        $user_id = auth()->user()->id;

        // Cari order berdasarkan no_pemesanan dan user_id yang sesuai dengan yang login
        $order = OrderJersey::where('no_pesanan', $no_pemesanan)
                            ->where('user_id', $user_id)
                            ->first();
        
        // Jika order ditemukan
        if ($order) {
            // Cari semua detail order berdasarkan no_pemesanan
            $order_details = OrderDetailJersey::where('no_pesanan', $no_pemesanan)->get();
            
            // Pastikan ada detail pesanan
            if ($order_details->isNotEmpty()) {
                

                // Kirim permintaan cURL ke API eksternal
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'http://103.135.214.11:81/qlp_system/api_bisnis/update_pesanan_seragam_terima_tu.php',
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => array(
                        'no_pemesanan' => $no_pemesanan,
                        'tgl_terima_ortu' => $tgl_terima_ortu
                    )
                ));

                // Eksekusi cURL request dan ambil respons
                $response = curl_exec($curl);

                // Cek error jika ada
                if(curl_errno($curl)) {
                    curl_close($curl);
                    return response()->json(['error' => 'Terjadi kesalahan pada koneksi server: ' . curl_error($curl)], 500);
                }

                // Tutup koneksi cURL
                curl_close($curl);

                // Update tgl_terima_ortu untuk setiap detail order
                foreach ($order_details as $order_detail) {
                    $order_detail->tgl_terima_ortu = $tgl_terima_ortu;
                    $order_detail->save();  // Simpan perubahan untuk setiap item
                }

                // Mengembalikan respons sukses
                return response()->json(['message' => 'Tanggal terima seragam berhasil diperbarui.']);
            } else {
                return response()->json(['error' => 'Detail pesanan tidak ditemukan.'], 404);
            }
        } else {
            return response()->json(['error' => 'Order tidak ditemukan atau Anda tidak memiliki akses ke order ini.'], 404);
        }
    }

    public function list_order_jersey(Request $request) {
        $list_jersey = Jersey::all();
        $list_ukuran = UkuranSeragam::whereNotIn('ukuran_seragam', ['ALL', '4XL', '5XL'])->orderby('urutan', 'asc')->get();

        $sekolah_id = $request->sekolah ?? null;
        $start = $request->date_start != '' ? $request->date_start : null ;
        $date_end = $request->date_end != '' ? $request->date_end : null;

        $date_start = date($start);
        $new_date_end = new DateTime($date_end);
        $date_end_plus = $new_date_end->modify('+1 day')->format('Y-m-d');

        $sekolah = LokasiSub::select('id as id_sekolah', 'sublokasi')->where('status', 1)->get();

        if ($request->has('date_start') && $request->has('date_end') || $request->has('sekolah')) {
            $list_order = OrderJersey::query();
            
            if ($request->has('sekolah'))
            $list_order = $list_order->selectRaw('t_pesan_jersey.id, t_pesan_jersey.no_pesanan, nama_pemesan, total_harga, metode_pembayaran, status, t_pesan_jersey.updated_at, r.name as role_name')
                            ->leftJoin('t_pesan_jersey_detail as tpjd', 't_pesan_jersey.no_pesanan', 'tpjd.no_pesanan')
                            ->leftJoin('users as user', 't_pesan_jersey.user_id', 'user.id')
                            ->leftJoin('role as r', 'user.id_role', 'r.id')
                            ->where('tpjd.lokasi_sekolah', $sekolah_id)
                            ->where('status', 'success')
                            ->orderBy('t_pesan_jersey.updated_at', 'desc');
                         
            if ($start!= null && $date_end != null)

            $list_order = $list_order->selectRaw('t_pesan_jersey.id, t_pesan_jersey.no_pesanan, nama_pemesan, total_harga, metode_pembayaran, status, t_pesan_jersey.updated_at, role.name as role_name')
                                    ->leftJoin('users', 't_pesan_jersey.user_id', 'users.id')
                                    ->leftJoin('role', 'users.id_role', 'role.id')                        
                                    ->whereBetween('t_pesan_jersey.updated_at', [$date_start, $date_end_plus])
                                    ->where('status', 'success')
                                    ->orderBy('t_pesan_jersey.updated_at', 'desc');

            if ($start == '' && $date_end == '')
            $list_order = $list_order->selectRaw('t_pesan_jersey.id, t_pesan_jersey.no_pesanan, nama_pemesan, total_harga, metode_pembayaran, status, t_pesan_jersey.updated_at, role.name as role_name')
                            ->leftJoin('users', 't_pesan_jersey.user_id', 'users.id')
                            ->leftJoin('role', 'users.id_role', 'role.id')
                            ->where('status', 'success')
                            ->orderBy('t_pesan_jersey.updated_at', 'desc');

            $list_order = $list_order->get();

        } else {
            $list_order = OrderJersey::select('t_pesan_jersey.id', 'no_pesanan', 'nama_pemesan', 'total_harga', 'metode_pembayaran', 'status', 't_pesan_jersey.updated_at', 'r.name as role_name')
                            ->leftJoin('users as u', 't_pesan_jersey.user_id', 'u.id')
                            ->leftJoin('role as r', 'u.id_role', 'r.id')
                            ->where('status', 'success')
                            ->orderby('t_pesan_jersey.updated_at', 'desc')
                            ->get();
        }

        return view('admin.laporan.jersey', compact('list_order', 'date_start', 'date_end', 'sekolah', 'sekolah_id', 'list_jersey', 'list_ukuran'));
    }

    public function order_jersey_detail($id){
        $order_detail = OrderDetailJersey::select('t_pesan_jersey_detail.nama_siswa', 't_pesan_jersey_detail.lokasi_sekolah', 'mj.persen_diskon',
                        't_pesan_jersey_detail.nama_kelas', 'mj.nama_jersey', 'mj.image_1', 'mj.harga_awal', 'mus.ukuran_seragam', 't_pesan_jersey_detail.harga', 
                        't_pesan_jersey_detail.persen_diskon', 't_pesan_jersey_detail.quantity', 't_pesan_jersey_detail.ukuran_id', 't_pesan_jersey_detail.jersey_id',
                        't_pesan_jersey_detail.created_at', 'tpj.metode_pembayaran', 'tpj.no_pesanan', 't_pesan_jersey_detail.nama_punggung', 't_pesan_jersey_detail.no_punggung')
                        ->leftJoin('t_pesan_jersey as tpj', 'tpj.no_pesanan', 't_pesan_jersey_detail.no_pesanan')
                        ->leftJoin('m_jersey as mj', 'mj.id', 't_pesan_jersey_detail.jersey_id')
                        ->leftJoin('m_ukuran_seragam as mus', 'mus.id', 't_pesan_jersey_detail.ukuran_id')
                        ->where('tpj.no_pesanan', $id)
                        ->get();

        return response()->json($order_detail);
    }

    public function update_jersey(Request $request)
    {
        $user = auth()->user()->name;

        $id = $request->id;
        $jersey_id = $request->jersey_id;
        $old_jersey_id = $request->old_jersey_id;
        $ukuran = $request->ukuran;
        $nama_punggung = $request->nama_punggung;
        $no_punggung = $request->no_punggung;
        $old_no_punggung = $request->old_no_punggung;

        $update_jersey = OrderDetailJersey::where('no_pesanan', $id)->where('jersey_id', $old_jersey_id)->where('no_punggung', $old_no_punggung)->first();

        $update_jersey->update([
            'jersey_id' => $jersey_id,
            'ukuran_id' => $ukuran,
            'nama_punggung' => $nama_punggung,
            'no_punggung' => $no_punggung

        ]);

        return response()->json($update_jersey);
    }

    public function download_invoice(Request $request, $id)
    {
        $user_id = auth()->user()->id;

        $order = OrderJersey::where('no_pesanan', $id)->first();

        $order_detail = OrderDetailJersey::select('t_pesan_jersey_detail.nama_siswa', 't_pesan_jersey_detail.lokasi_sekolah', 'mj.persen_diskon',
                        't_pesan_jersey_detail.nama_kelas', 'mj.nama_jersey', 'mj.image_1', 'mj.harga_awal', 'mus.ukuran_seragam', 't_pesan_jersey_detail.harga', 
                        't_pesan_jersey_detail.persen_diskon', 't_pesan_jersey_detail.quantity', 't_pesan_jersey_detail.ukuran_id',
                        't_pesan_jersey_detail.created_at', 'tpj.metode_pembayaran', 'tpj.no_pesanan', 't_pesan_jersey_detail.nama_punggung', 't_pesan_jersey_detail.no_punggung')
                        ->leftJoin('t_pesan_jersey as tpj', 'tpj.no_pesanan', 't_pesan_jersey_detail.no_pesanan')
                        ->leftJoin('m_jersey as mj', 'mj.id', 't_pesan_jersey_detail.jersey_id')
                        ->leftJoin('m_ukuran_seragam as mus', 'mus.id', 't_pesan_jersey_detail.ukuran_id')
                        ->where('tpj.no_pesanan', $id)
                        ->get();

        // Load view dengan data yang disiapkan
        $pdf = Pdf::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('admin.laporan.invoice-jersey', [
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
        return Excel::download(new SalesJerseyExport($start, $date_end_plus), $file_name);
    }

    public function resume_order(Request $request)
    {
        $this_month = date('Y-m');
        $user_id = auth()->user()->id;
        
                
        $sekolah_id = $request->sekolah ?? null;
        $start = $request->date_start != '' ? $request->date_start : Carbon::now()->startOfMonth()->toDateString();
        $date_end = $request->date_end != '' ? $request->date_end : Carbon::now()->toDateString();
        $new_date_end = new DateTime($date_end);
        $date_end_plus = $new_date_end->modify('+1 day')->format('Y-m-d');

        $sekolah = LokasiSub::select('id as id_sekolah', 'sublokasi')->where('status', 1)->get();
        
        $date_start = date($start);

        if ($request->has('date_start') && $request->has('date_end') && $request->has('sekolah')) {
            
            $order_success = OrderDetailJersey::select(DB::raw('sum(t_pesan_jersey_detail.harga*t_pesan_jersey_detail.quantity) as grand_total'))
                        ->leftJoin('t_pesan_jersey as tpj', 'tpj.no_pesanan', 't_pesan_jersey_detail.no_pesanan')
                        ->where('tpj.status', 'success')
                        ->whereBetween('tpj.tgl_bayar', [$date_start, $date_end_plus])
                        ->where('t_pesan_jersey_detail.lokasi_sekolah', $sekolah_id)
                        ->first();

            $hpp = OrderJersey::select(DB::raw('SUM( (tpjd.hpp * tpjd.quantity) ) as total_hpp'))
            ->leftJoin('t_pesan_jersey_detail as tpjd', 'tpjd.no_pesanan', 't_pesan_jersey.no_pesanan')
            ->where('t_pesan_jersey.status', 'success')
            ->whereBetween('t_pesan_jersey.tgl_bayar', [$date_start, $date_end_plus])
            ->where('tpjd.lokasi_sekolah', $sekolah_id)
            ->first();

            $profit = $order_success->grand_total - $hpp->total_hpp;

            $sales_per_month = OrderJersey::select(DB::raw('SUM( total_harga ) as sales_month'))
                            ->where('status', 'success')
                            ->where('tgl_bayar', 'LIKE', $this_month.'%')
                            ->first();

            $total_sales_by_produk = OrderJersey::select('mj.nama_jersey', 'tpjd.harga', DB::raw('sum(tpjd.quantity) as total_quantity'))
                    ->leftJoin('t_pesan_jersey_detail as tpjd', 'tpjd.no_pesanan', 't_pesan_jersey.no_pesanan')
                    ->leftJoin('m_jersey as mj', 'mj.id', 'tpjd.jersey_id')
                    ->where('t_pesan_jersey.status', 'success')
                    ->whereBetween('t_pesan_jersey.tgl_bayar', [$date_start, $date_end_plus])
                    ->where('tpjd.lokasi_sekolah', $sekolah_id)
                    ->groupby('tpjd.jersey_id')
                    ->orderby('total_quantity', 'desc')
                    ->get();

            // dd($total_sales_by_produk);

            $total_sales_by_ekskul = OrderJersey::select('mje.ekskul', DB::raw('sum(tpjd.quantity) as total_quantity'))
                    ->leftJoin('t_pesan_jersey_detail as tpjd', 'tpjd.no_pesanan', 't_pesan_jersey.no_pesanan')
                    ->leftJoin('m_jersey as mj', 'mj.id', 'tpjd.jersey_id')
                    ->leftJoin('m_jenis_ekskul as mje', 'mj.ekskul_id', 'mje.id')
                    ->where('t_pesan_jersey.status', 'success')
                    ->whereBetween('t_pesan_jersey.tgl_bayar', [$date_start, $date_end_plus])
                    ->where('tpjd.lokasi_sekolah', $sekolah_id)
                    ->groupby('mje.id')
                    ->orderby('total_quantity', 'desc')
                    ->get();

            $total_sales_by_school = OrderJersey::select('mls.sublokasi', DB::raw('count(tpsd.lokasi_sekolah) as total_item'))
            ->leftJoin('t_pesan_jersey_detail as tpsd', 'tpsd.no_pesanan', 't_pesan_jersey.no_pesanan')
            ->leftJoin('mst_lokasi_sub as mls', 'mls.id', 'tpsd.lokasi_sekolah')
            ->where('t_pesan_jersey.status', 'success')
            ->whereBetween('t_pesan_jersey.tgl_bayar', [$date_start, $date_end_plus])
            ->where('tpsd.lokasi_sekolah', $sekolah_id)
            ->groupby('tpsd.lokasi_sekolah')
            ->orderby('total_item', 'desc')
            ->get();

            $total_item = OrderDetailJersey::select(DB::raw('sum(t_pesan_jersey_detail.quantity) as total_item'))
            ->leftJoin('t_pesan_jersey as tpj', 'tpj.no_pesanan', 't_pesan_jersey_detail.no_pesanan')
            ->where('tpj.status', 'success')
            ->whereBetween('tpj.tgl_bayar', [$date_start, $date_end_plus])
            ->where('t_pesan_jersey_detail.lokasi_sekolah', $sekolah_id)
            ->first();
        } else if ($start && $date_end_plus) {
            
            $order_success = OrderDetailJersey::select(DB::raw('sum(t_pesan_jersey_detail.harga*t_pesan_jersey_detail.quantity) as grand_total'))
                        ->leftJoin('t_pesan_jersey as tpj', 'tpj.no_pesanan', 't_pesan_jersey_detail.no_pesanan')
                        ->where('tpj.status', 'success')
                        ->whereBetween('tpj.tgl_bayar', [$date_start, $date_end_plus])
                        ->first();

            $hpp = OrderJersey::select(DB::raw('SUM( (tpjd.hpp * tpjd.quantity) ) as total_hpp'))
            ->leftJoin('t_pesan_jersey_detail as tpjd', 'tpjd.no_pesanan', 't_pesan_jersey.no_pesanan')
            ->where('t_pesan_jersey.status', 'success')
            ->whereBetween('t_pesan_jersey.tgl_bayar', [$date_start, $date_end_plus])
            ->first();

            $profit = $order_success->grand_total - $hpp->total_hpp;

            $sales_per_month = OrderJersey::select(DB::raw('SUM( total_harga ) as sales_month'))
                            ->where('status', 'success')
                            ->where('tgl_bayar', 'LIKE', $this_month.'%')
                            ->first();

            $total_sales_by_produk = OrderJersey::select('mj.nama_jersey', 'tpjd.harga', DB::raw('sum(tpjd.quantity) as total_quantity'))
                    ->leftJoin('t_pesan_jersey_detail as tpjd', 'tpjd.no_pesanan', 't_pesan_jersey.no_pesanan')
                    ->leftJoin('m_jersey as mj', 'mj.id', 'tpjd.jersey_id')
                    ->where('t_pesan_jersey.status', 'success')
                    ->whereBetween('t_pesan_jersey.tgl_bayar', [$date_start, $date_end_plus])
                    ->groupby('tpjd.jersey_id')
                    ->orderby('total_quantity', 'desc')
                    ->get();

            // dd($total_sales_by_produk);

            $total_sales_by_ekskul = OrderJersey::select('mje.ekskul', DB::raw('sum(tpjd.quantity) as total_quantity'))
                    ->leftJoin('t_pesan_jersey_detail as tpjd', 'tpjd.no_pesanan', 't_pesan_jersey.no_pesanan')
                    ->leftJoin('m_jersey as mj', 'mj.id', 'tpjd.jersey_id')
                    ->leftJoin('m_jenis_ekskul as mje', 'mj.ekskul_id', 'mje.id')
                    ->where('t_pesan_jersey.status', 'success')
                    ->whereBetween('t_pesan_jersey.tgl_bayar', [$date_start, $date_end_plus])
                    ->groupby('mje.id')
                    ->orderby('total_quantity', 'desc')
                    ->get();

            $total_sales_by_school = OrderJersey::select('mls.sublokasi', DB::raw('count(tpsd.lokasi_sekolah) as total_item'))
            ->leftJoin('t_pesan_jersey_detail as tpsd', 'tpsd.no_pesanan', 't_pesan_jersey.no_pesanan')
            ->leftJoin('mst_lokasi_sub as mls', 'mls.id', 'tpsd.lokasi_sekolah')
            ->where('t_pesan_jersey.status', 'success')
            ->whereBetween('t_pesan_jersey.tgl_bayar', [$date_start, $date_end_plus])
            ->groupby('tpsd.lokasi_sekolah')
            ->orderby('total_item', 'desc')
            ->get();

            $total_item = OrderDetailJersey::select(DB::raw('sum(t_pesan_jersey_detail.quantity) as total_item'))
            ->leftJoin('t_pesan_jersey as tpj', 'tpj.no_pesanan', 't_pesan_jersey_detail.no_pesanan')
            ->where('tpj.status', 'success')
            ->whereBetween('tpj.tgl_bayar', [$date_start, $date_end_plus])
            ->first();
        } else {
            $order_success = OrderDetailJersey::select(DB::raw('sum(t_pesan_jersey_detail.harga*t_pesan_jersey_detail.quantity) as grand_total'))
                        ->leftJoin('t_pesan_jersey as tpj', 'tpj.no_pesanan', 't_pesan_jersey_detail.no_pesanan')
                        ->where('tpj.status', 'success')
                        ->first();

            $hpp = OrderJersey::select(DB::raw('SUM( (tpjd.hpp * tpjd.quantity) ) as total_hpp'))
            ->leftJoin('t_pesan_jersey_detail as tpjd', 'tpjd.no_pesanan', 't_pesan_jersey.no_pesanan')
            ->where('t_pesan_jersey.status', 'success')
            ->first();

            $profit = $order_success->grand_total - $hpp->total_hpp;

            $sales_per_month = OrderJersey::select(DB::raw('SUM( total_harga ) as sales_month'))
                            ->where('status', 'success')
                            ->where('tgl_bayar', 'LIKE', $this_month.'%')
                            ->first();

            $total_sales_by_produk = OrderJersey::select('mj.nama_jersey', 'tpjd.harga', DB::raw('sum(tpjd.quantity) as total_quantity'))
                    ->leftJoin('t_pesan_jersey_detail as tpjd', 'tpjd.no_pesanan', 't_pesan_jersey.no_pesanan')
                    ->leftJoin('m_jersey as mj', 'mj.id', 'tpjd.jersey_id')
                    ->where('t_pesan_jersey.status', 'success')
                    ->groupby('tpjd.jersey_id')
                    ->orderby('total_quantity', 'desc')
                    ->get();

            $total_sales_by_ekskul = OrderJersey::select('mje.ekskul', DB::raw('sum(tpjd.quantity) as total_quantity'))
            ->leftJoin('t_pesan_jersey_detail as tpjd', 'tpjd.no_pesanan', 't_pesan_jersey.no_pesanan')
            ->leftJoin('m_jersey as mj', 'mj.id', 'tpjd.jersey_id')
            ->leftJoin('m_jenis_ekskul as mje', 'mj.ekskul_id', 'mje.id')
            ->where('t_pesan_jersey.status', 'success')
            ->groupby('mje.id')
            ->orderby('total_quantity', 'desc')
            ->get();

            $total_sales_by_school = OrderJersey::select('mls.sublokasi', DB::raw('count(tpsd.lokasi_sekolah) as total_item'))
            ->leftJoin('t_pesan_jersey_detail as tpsd', 'tpsd.no_pesanan', 't_pesan_jersey.no_pesanan')
            ->leftJoin('mst_lokasi_sub as mls', 'mls.id', 'tpsd.lokasi_sekolah')
            ->where('t_pesan_jersey.status', 'success')
            ->groupby('tpsd.lokasi_sekolah')
            ->orderby('total_item', 'desc')
            ->get();

            $total_item = OrderDetailJersey::select(DB::raw('sum(t_pesan_jersey_detail.quantity) as total_item'))
            ->leftJoin('t_pesan_jersey as tpj', 'tpj.no_pesanan', 't_pesan_jersey_detail.no_pesanan')
            ->where('tpj.status', 'success')
            ->first();
        }

        return view('admin.laporan.resume-jersey', compact( 'order_success', 'hpp', 'profit', 'sales_per_month', 'total_sales_by_ekskul',
        'total_sales_by_school', 'total_sales_by_produk', 'total_item', 'user_id', 'sekolah', 'sekolah_id', 'date_start', 'date_end'));
    }

    public function update_cart_status($user_id, $jersey_id) 
    {
        $cart_detail = CartJersey::where('user_id', $user_id)
                ->where('status_cart', 0)
                ->where('jersey_id', $jersey_id)
                ->where('is_selected', 1)
                ->first();
        
        $update_status_cart = $cart_detail->update([
            'status_cart' => 1
        ]);

        return response()->json($update_status_cart);
    }

    function send_pesan_jersey($no_pesanan, $nama_pemesan, $no_hp){
	    $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'http://103.135.214.11:81/qlp_system/api_regist/simpan_pesan_jersey.php',
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

    function send_pesan_jersey_baru($no_pesanan, $nama_pemesan, $no_hp){
	    $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://system.sekolahrabbani.sch.id/api_regist/simpan_pesan_jersey.php',
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

    function send_pesan_jersey_detail($no_pesanan, $nama_siswa, $lokasi_sekolah, $nama_kelas, $jersey_id, $ukuran, $quantity, $harga, $diskon, $hpp, $no_punggung, $nama_punggung){
	    $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'http://103.135.214.11:81/qlp_system/api_regist/simpan_pesan_jersey_detail.php',
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
		  	'jersey_id' => $jersey_id,
		  	'ukuran' => $ukuran,
		  	'quantity' => $quantity,
		  	'harga' => $harga,
		  	'diskon' => $diskon,
		  	'hpp' => $hpp, 
            'no_punggung' => $no_punggung, 
            'nama_punggung' => $nama_punggung
            )

		));

		$response = curl_exec($curl);

		// echo $response;
		curl_close($curl);
	    // return ($response);
	}

    function send_pesan_jersey_detail_baru($no_pesanan, $nama_siswa, $lokasi_sekolah, $nama_kelas, $jersey_id, $ukuran, $quantity, $harga, $diskon, $hpp, $no_punggung, $nama_punggung){
	    $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://system.sekolahrabbani.sch.id/api_regist/simpan_pesan_jersey_detail.php',
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
		  	'jersey_id' => $jersey_id,
		  	'ukuran' => $ukuran,
		  	'quantity' => $quantity,
		  	'harga' => $harga,
		  	'diskon' => $diskon,
		  	'hpp' => $hpp,
            'no_punggung' => $no_punggung, 
            'nama_punggung' => $nama_punggung
            )

		));

		$response = curl_exec($curl);

		// echo $response;
		curl_close($curl);
	    // return ($response);
	}
}
