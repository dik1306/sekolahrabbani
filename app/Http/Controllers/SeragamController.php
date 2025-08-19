<?php

namespace App\Http\Controllers;

use App\Exports\HargaExport;
use App\Exports\StokExport;
use App\Exports\WishlistExport;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\HargaSeragam;
use App\Models\JenisKategori;
use App\Models\JenisSeragam;
use App\Models\Jenjang;
use App\Models\LokasiSub;
use App\Models\ProdukSeragamImage;
use App\Models\MenuMobile;
use App\Models\OrderDetailMerchandise;
use App\Models\OrderDetailSeragam;
use App\Models\OrderJersey;
use App\Models\OrderMerchandise;
use App\Models\OrderSeragam;
use App\Models\ContactPerson;
use App\Models\ProdukSeragam;
use App\Models\Pendaftaran;
use App\Models\Profile;
use App\Models\StokCard;
use App\Models\StokSeragam;
use App\Models\UkuranSeragam;
use App\Models\Wishlist;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class SeragamController extends Controller
{
    public function index(Request $request)
    {
        $user_id = auth()->user()->id;
        $lokasi = LokasiSub::select('id as kode_lokasi', 'sublokasi')->where('status', 1)->get();
        $jenjang = Jenjang::select('nama_jenjang', 'value')->get();
        $kategori_seragam = JenisKategori::all();
        $produk_seragam = ProdukSeragam::all();
        $produk_seragam_tk = ProdukSeragam::where('jenjang_id', 3)->get();
        $produk_seragam_sd = ProdukSeragam::where('jenjang_id', 4)->get();
        $produk_seragam_smp = ProdukSeragam::where('jenjang_id', 5)->get();
        $produk_seragam_kober = ProdukSeragam::where('jenjang_id', 1)->get();

        $search = $request->input('search');

        $search_produk = ProdukSeragam::where('nama_produk', 'like', "$search")->get();

        $cart_detail = CartDetail::select('t_cart_detail.id', 'm_produk_seragam.id as id_produk','m_produk_seragam.nama_produk', 'm_produk_seragam.deskripsi', 'm_produk_seragam.image', 
                    'm_produk_seragam.material', 'mhs.harga', 'mhs.diskon', 'mjps.id as jenis_id', 'mp.nama_lengkap as nama_siswa', 'mp.nama_kelas as nama_kelas', 'mhs.kode_produk',
                    'mls.sublokasi as sekolah', 'mjps.jenis_produk', 't_cart_detail.quantity', 't_cart_detail.ukuran', 't_cart_detail.is_selected', 'tss.qty')
                    ->leftJoin('m_produk_seragam', 'm_produk_seragam.id', 't_cart_detail.produk_id')
                    ->leftJoin('m_profile as mp' , 'mp.nis', 't_cart_detail.nis')
                    ->leftJoin('mst_lokasi_sub as mls', 'mls.id', 'mp.sekolah_id')
                    ->leftJoin('m_jenis_produk_seragam as mjps', 'mjps.id', 't_cart_detail.jenis')
                    ->leftJoin('m_ukuran_seragam as mus', 'mus.ukuran_seragam', 't_cart_detail.ukuran')
                    ->leftJoin('m_harga_seragam as mhs', function($join)
                    { $join->on('mhs.produk_id', '=', 'm_produk_seragam.id') 
                        ->on('mhs.jenis_produk_id', '=', 'mjps.id')
                        ->on('mus.id', '=', 'mhs.ukuran_id'); 
                    })
                    ->leftJoin('t_stok_seragam as tss', 'mhs.kode_produk', 'tss.kd_barang')
                    ->where('t_cart_detail.user_id', $user_id)
                    ->where('t_cart_detail.status_cart', 0)
                    ->where('tss.qty', '>', 0)
                    ->get();

        $wishlist = Wishlist::select('t_wishlist_seragam.id', 'm_produk_seragam.id as id_produk','m_produk_seragam.nama_produk', 'm_produk_seragam.deskripsi', 'm_produk_seragam.image', 
                    'm_produk_seragam.material', 'mhs.harga', 'mhs.diskon', 'mjps.id as jenis_id', 'mhs.kode_produk',
                    'mjps.jenis_produk', 't_wishlist_seragam.quantity', 't_wishlist_seragam.ukuran', 'tss.qty')
                    ->leftJoin('m_produk_seragam', 'm_produk_seragam.id', 't_wishlist_seragam.produk_id')
                    ->leftJoin('m_jenis_produk_seragam as mjps', 'mjps.id', 't_wishlist_seragam.jenis')
                    ->leftJoin('m_ukuran_seragam as mus', 'mus.ukuran_seragam', 't_wishlist_seragam.ukuran')
                    ->leftJoin('m_harga_seragam as mhs', function($join)
                    { $join->on('mhs.produk_id', '=', 'm_produk_seragam.id') 
                        ->on('mhs.jenis_produk_id', '=', 'mjps.id')
                        ->on('mus.id', '=', 'mhs.ukuran_id'); 
                    })
                    ->leftJoin('t_stok_seragam as tss', 'mhs.kode_produk', 'tss.kd_barang')
                    ->where('t_wishlist_seragam.user_id', $user_id)
                    ->where('t_wishlist_seragam.status_wl', 1)
                    ->where('tss.qty', '>', 0)
                    ->get();

        $menubar = MenuMobile::where('is_footer', 1)->orderBy('no', 'asc')->get();

        // return view('ortu.seragam.closed', compact('lokasi', 'produk_seragam', 'jenjang', 'kategori_seragam', 'produk_seragam_tk', 'produk_seragam_sd', 'produk_seragam_smp', 'produk_seragam_kober', 'search_produk', 'cart_detail', 'menubar', 'wishlist'));
        return view('ortu.seragam.index', compact('lokasi', 'produk_seragam', 'jenjang', 'kategori_seragam', 'produk_seragam_tk', 'produk_seragam_sd', 'produk_seragam_smp', 'produk_seragam_kober', 'search_produk', 'cart_detail', 'menubar', 'wishlist'));
    }

    public function search_produk(Request $request)
    {
        $keyword = $request->keyword;


            $output = '';

            if ($keyword != '') {
                $produk = ProdukSeragam::where('nama_produk', 'LIKE', '%'.$keyword.'%')->where('jenjang_id', '!=', '10')->get();
                
                if ($produk) {
                    foreach ($produk as $item) {
                        $harga = number_format($item->harga_awal);
                        $harga_akhir = number_format((100-$item->diskon_persen)/100 * $item->harga_awal);
                        $src_image = asset('assets/images/'.$item->image);
                        $route = route('seragam.detail', $item->id);
                        $output .=  
                        '<a href="'.$route.'" style="text-decoration: none">
                            <div class="card catalog mb-1">
                                <img src="'.$src_image.'" class="card-img-top" alt="'.$item->image.'" style="max-height: 180px">
                                <div class="card-body pt-1" style="padding-left: 0.8rem; padding-right: 0">
                                    <h6 class="card-title mb-0">'.$item->nama_produk.'</h6>
                                    <p class="mb-0 price-diskon" ><b> Rp. '.$harga_akhir.' </b> </p>
                                    <p class="mb-1 price-normal"><s> Rp. '.$harga.' </s> </p>
                                    <p class="mb-0" style="font-size: 10px"> Disc. 
                                        <span class="bg-danger p-1">'.$item->diskon_persen.'% </span> 
                                        <span class="mx-2"> <i class="fa-solid fa-paper-plane fa-sm"></i> Sekolah Rabbani </span> 
                                    </p>
                                </div>
                            </div>
                        </a>';
                    }
                    return response()->json([
                        'message' => 'success',
                        'output' => $output
                    ]);
                }
            } else {
                return response()->json([
                    'message' => 'not',
                    'output' => $output
                ]);
            }
        

        return view('ortu.seragam.index');
    }

    public function filter_produk(Request $request)
    {
        $jenjang = $request->jenjang ?? null;
        $jenis = $request->jenis ?? null;


            $output = '';

            if ($jenjang != '' || $jenis != '') {
                $produk = ProdukSeragam::query();

                if ($jenjang != '')
                $produk = $produk->where('jenjang_id', $jenjang);

                if ($jenis != '')
                $produk = $produk->where('kategori_id', $jenis);

                $produk = $produk->get();
                
                if ($produk) {
                    foreach ($produk as $item) {
                        $harga = number_format($item->harga_awal);
                        $harga_akhir = number_format((100-$item->diskon_persen)/100 * $item->harga_awal);
                        $src_image = asset('assets/images/'.$item->image);
                        $route = route('seragam.detail', $item->id);
                        $output .=  
                        '<a href="'.$route.'" style="text-decoration: none">
                            <div class="card catalog mb-1">
                                <img src="'.$src_image.'" class="card-img-top" alt="'.$item->image.'" style="max-height: 180px">
                                <div class="card-body pt-1" style="padding-left: 0.8rem; padding-right: 0">
                                    <h6 class="card-title mb-0">'.$item->nama_produk.'</h6>
                                    <p class="mb-0 price-diskon" ><b> Rp. '.$harga_akhir.' </b> </p>
                                    <p class="mb-1 price-normal"><s> Rp. '.$harga.' </s> </p>
                                    <p class="mb-0" style="font-size: 10px"> Disc. 
                                        <span class="bg-danger p-1">'.$item->diskon_persen.'% </span> 
                                        <span class="mx-2"> <i class="fa-solid fa-paper-plane fa-sm"></i> Sekolah Rabbani </span> 
                                    </p>
                                </div>
                            </div>
                        </a>';
                    }
                    return response()->json([
                        'message' => 'success',
                        'output' => $output
                    ]);
                }
            } else {
                return response()->json([
                    'message' => 'not',
                    'output' => $output
                ]);
            }
        

        return view('ortu.seragam.index');
    }

    public function detail_produk(Request $request, $id)
    {
        $produk = ProdukSeragam::select('m_produk_seragam.id','m_produk_seragam.nama_produk', 'm_produk_seragam.deskripsi', 'm_produk_seragam.image', 'm_produk_seragam.image_2',
        'm_produk_seragam.image_3', 'm_produk_seragam.image_4', 'm_produk_seragam.image_5', 'm_produk_seragam.image_6', 'm_produk_seragam.image_7', 'm_produk_seragam.material', 'mhs.harga', 'mhs.diskon', 'mjps.jenis_produk')
                                ->leftJoin('m_harga_seragam as mhs', 'mhs.produk_id', 'm_produk_seragam.id')
                                ->leftJoin('m_ukuran_seragam as mus', 'mus.grup_ukuran', 'mhs.ukuran_id')
                                ->leftJoin('m_jenis_produk_seragam as mjps', 'mjps.id', 'mhs.jenis_produk_id')
                                ->where('m_produk_seragam.id', $id)
                                ->first();
        // dd($produk->image_7);
        $user_id = auth()->user()->id;
        $no_hp = auth()->user()->no_hp;

        $jenis_produk = JenisSeragam::select('m_jenis_produk_seragam.id','m_jenis_produk_seragam.jenis_produk', DB::raw('sum(tss.qty) as quantity') )
                                    ->leftJoin('m_harga_seragam as mhs', 'mhs.jenis_produk_id', 'm_jenis_produk_seragam.id')
                                    ->leftJoin('m_produk_seragam as mps', 'mps.id', 'mhs.produk_id')
                                    ->leftJoin('m_ukuran_seragam as mus', 'mus.id', 'mhs.ukuran_id')
                                    ->leftJoin('t_stok_seragam as tss', 'mhs.kode_produk', 'tss.kd_barang')
                                    ->where('mps.id', $id)
                                    ->groupby('m_jenis_produk_seragam.id')                          
                                    ->get();
        
        $ukuran_seragam = HargaSeragam::select('mus.id', 'mus.ukuran_seragam', 'mjps.id as jenis_produk_id', DB::raw('sum(tss.qty) as quantity'))
                                    ->leftJoin('m_ukuran_seragam as mus', 'mus.id', 'm_harga_seragam.ukuran_id')
                                    ->leftJoin('m_produk_seragam as mps', 'mps.id', 'm_harga_seragam.produk_id')
                                    ->leftJoin('m_jenis_produk_seragam as mjps', 'mjps.id', 'm_harga_seragam.jenis_produk_id')
                                    ->leftJoin('t_stok_seragam as tss', 'm_harga_seragam.kode_produk', 'tss.kd_barang')
                                    ->where('mps.id', $id)
                                    ->groupby('mus.id')
                                    ->orderby('mus.urutan', 'ASC')
                                    ->get();

        $stok_seragam = HargaSeragam::select('mus.id', 'mus.ukuran_seragam', 'tss.qty', 'm_harga_seragam.kode_produk')
                        ->leftJoin('m_ukuran_seragam as mus', 'mus.id', 'm_harga_seragam.ukuran_id')
                        ->leftJoin('m_produk_seragam as mps', 'mps.id', 'm_harga_seragam.produk_id')
                        ->leftJoin('t_stok_seragam as tss', 'm_harga_seragam.kode_produk', 'tss.kd_barang')
                        ->where('mps.id', $id)
                        ->groupby('mus.id')
                        ->first();

        $profile = Profile::get_user_profile_byphone($no_hp);

        $cart_detail = CartDetail::select('t_cart_detail.id', 'm_produk_seragam.id as id_produk','m_produk_seragam.nama_produk', 'm_produk_seragam.deskripsi', 'm_produk_seragam.image', 
                    'm_produk_seragam.material', 'mhs.harga', 'mhs.diskon', 'mjps.id as jenis_id', 'mp.nama_lengkap as nama_siswa', 'mp.nama_kelas as nama_kelas', 'mhs.kode_produk',
                    'mls.sublokasi as sekolah', 'mjps.jenis_produk', 't_cart_detail.quantity', 't_cart_detail.ukuran', 't_cart_detail.is_selected', 'tss.qty')
                    ->leftJoin('m_produk_seragam', 'm_produk_seragam.id', 't_cart_detail.produk_id')
                    ->leftJoin('m_profile as mp' , 'mp.nis', 't_cart_detail.nis')
                    ->leftJoin('mst_lokasi_sub as mls', 'mls.id', 'mp.sekolah_id')
                    ->leftJoin('m_jenis_produk_seragam as mjps', 'mjps.id', 't_cart_detail.jenis')
                    ->leftJoin('m_ukuran_seragam as mus', 'mus.ukuran_seragam', 't_cart_detail.ukuran')
                    ->leftJoin('m_harga_seragam as mhs', function($join)
                    { $join->on('mhs.produk_id', '=', 'm_produk_seragam.id') 
                        ->on('mhs.jenis_produk_id', '=', 'mjps.id')
                        ->on('mus.id', '=', 'mhs.ukuran_id'); 
                    })
                    ->leftJoin('t_stok_seragam as tss', 'mhs.kode_produk', 'tss.kd_barang')
                    ->where('t_cart_detail.user_id', $user_id)
                    ->where('t_cart_detail.status_cart', 0)
                    ->where('tss.qty', '>', 0)
                    ->get();

        $seragam_images = ProdukSeragamImage::where('produk_seragam_id', $id)->where('isUsed', true)->get();
        $size_chart_images = ProdukSeragamImage::where('produk_seragam_id', $id)->where('isSizeChart', true)->where('isUsed', true)->get();

        return view('ortu.seragam.detail', compact('produk', 'cart_detail', 'profile', 'jenis_produk', 'ukuran_seragam', 'seragam_images' ,'size_chart_images'));
    }

    public function cart(Request $request)
    {

        $user_id = auth()->user()->id;

        $profile = Profile::where('user_id', $user_id)->get();

        $cart_detail = CartDetail::select('t_cart_detail.id', 'm_produk_seragam.id as id_produk','m_produk_seragam.nama_produk', 'm_produk_seragam.deskripsi', 'm_produk_seragam.image', 
                    'm_produk_seragam.material', 'mhs.harga', 'mhs.diskon', 'mjps.id as jenis_id', 'mp.nama_lengkap as nama_siswa', 'mp.nama_kelas as nama_kelas', 'mhs.kode_produk',
                    'mls.sublokasi as sekolah', 'mjps.jenis_produk', 't_cart_detail.quantity', 't_cart_detail.ukuran', 't_cart_detail.is_selected', 'tss.qty')
                    ->leftJoin('m_produk_seragam', 'm_produk_seragam.id', 't_cart_detail.produk_id')
                    ->leftJoin('m_profile as mp' , 'mp.nis', 't_cart_detail.nis')
                    ->leftJoin('mst_lokasi_sub as mls', 'mls.id', 'mp.sekolah_id')
                    ->leftJoin('m_jenis_produk_seragam as mjps', 'mjps.id', 't_cart_detail.jenis')
                    ->leftJoin('m_ukuran_seragam as mus', 'mus.ukuran_seragam', 't_cart_detail.ukuran')
                    ->leftJoin('m_harga_seragam as mhs', function($join)
                    { $join->on('mhs.produk_id', '=', 'm_produk_seragam.id') 
                        ->on('mhs.jenis_produk_id', '=', 'mjps.id')
                        ->on('mus.id', '=', 'mhs.ukuran_id'); 
                    })
                    ->leftJoin('t_stok_seragam as tss', 'mhs.kode_produk', 'tss.kd_barang')
                    ->where('t_cart_detail.user_id', $user_id)
                    ->where('t_cart_detail.status_cart', 0)
                    ->where('tss.qty', '>', 0)
                    ->get();
        // dd($cart_detail);

        $total_bayar = CartDetail::select('t_cart_detail.id', 'm_produk_seragam.id as id_produk','m_produk_seragam.nama_produk', 'm_produk_seragam.deskripsi', 'm_produk_seragam.image', 
                            'm_produk_seragam.material', 'mhs.harga', 'mhs.diskon', 'mjps.id as jenis_id', 'mp.nama_lengkap as nama_siswa', 'mp.nama_kelas as nama_kelas', 'mhs.kode_produk',
                            'mls.sublokasi as sekolah', 'mjps.jenis_produk', 't_cart_detail.quantity', 't_cart_detail.ukuran', 't_cart_detail.is_selected')
                            ->leftJoin('m_produk_seragam', 'm_produk_seragam.id', 't_cart_detail.produk_id')
                            ->leftJoin('m_profile as mp' , 'mp.nis', 't_cart_detail.nis')
                            ->leftJoin('mst_lokasi_sub as mls', 'mls.id', 'mp.sekolah_id')
                            ->leftJoin('m_jenis_produk_seragam as mjps', 'mjps.id', 't_cart_detail.jenis')
                            ->leftJoin('m_ukuran_seragam as mus', 'mus.ukuran_seragam', 't_cart_detail.ukuran')
                            ->leftJoin('m_harga_seragam as mhs', function($join)
                            { $join->on('mhs.produk_id', '=', 'm_produk_seragam.id') 
                                ->on('mhs.jenis_produk_id', '=', 'mjps.id')
                                ->on('mus.id', '=', 'mhs.ukuran_id'); 
                            })
                            ->leftJoin('t_stok_seragam as tss', 'mhs.kode_produk', 'tss.kd_barang')
                            ->where('t_cart_detail.user_id', $user_id)
                            ->where('t_cart_detail.status_cart', 0)
                            ->where('t_cart_detail.is_selected', 1)
                            ->where('tss.qty', '>', 0)
                            ->get();
        
        $total_bayar_selected = 0;
        foreach ($total_bayar as $item) {
            $quantity = $item->quantity;
            $harga = $item->harga * $quantity;
            $diskon = $item->diskon;
            $nilai_diskon = ($diskon/100 * $harga);

            $total_harga = $harga - $nilai_diskon;

            $total_bayar_selected += $total_harga;
        }

        return view('ortu.seragam.cart', compact('profile', 'cart_detail', 'total_bayar_selected'));
    }

    public function harga(Request $request) {
        $user_id = auth()->user()->id;
        $jenis = $request->jenis_id;
        $produk_id = $request->produk_id;
        $ukuran = $request->ukuran_id;

        $ukuran_id = UkuranSeragam::where('ukuran_seragam', $ukuran)->first();

        $harga = HargaSeragam::select('m_harga_seragam.harga', 'm_harga_seragam.diskon', 'm_harga_seragam.kode_produk', 'tss.qty')
                        ->leftJoin('t_stok_seragam as tss', 'm_harga_seragam.kode_produk', 'tss.kd_barang')
                        ->where('jenis_produk_id', $jenis)->where('produk_id', $produk_id)->where('ukuran_id', $ukuran_id->id)->get();
     
        return response()->json($harga);
    }

    public function stok(Request $request) {
        $jenis = $request->jenis_id;
        $produk_id = $request->produk_id;

        $stok = HargaSeragam::select('m_harga_seragam.harga', 'm_harga_seragam.kode_produk', 'mjps.id as jenis_produk_id', 'mus.ukuran_seragam', 'tss.qty')
                            ->leftJoin('t_stok_seragam as tss', 'm_harga_seragam.kode_produk', 'tss.kd_barang')
                            ->leftJoin('m_ukuran_seragam as mus', 'm_harga_seragam.ukuran_id', 'mus.id')
                            ->leftJoin('m_jenis_produk_seragam as mjps', 'm_harga_seragam.jenis_produk_id', 'mjps.id')
                            ->where('jenis_produk_id', $jenis)->where('produk_id', $produk_id)->get();

        return response()->json($stok);
    }


    public function add_to_cart(Request $request)
    {
        $produk_id = $request->produk_id;
        $quantity = $request->quantity;
        $ukuran = $request->ukuran;
        $nis = $request->nama_siswa;
        $jenis = $request->jenis;
        $kode_produk = $request->kode_produk;

        $user_id = auth()->user()->id;
        $profile = Profile::where('nis', $nis)->first();

        $add_cart_detail =  CartDetail::create([
            'produk_id' => $produk_id,
            'user_id' => $user_id,
            'nis' => $nis,
            'quantity' => $quantity,
            'ukuran' => $ukuran,
            'jenis' => $jenis,
            'kode_produk' => $kode_produk
            
        ]);
    
        return response()->json($add_cart_detail);

    }

    public function update_cart(Request $request, $id) 
    {
        $quantity = $request->quantity;
        $is_selected = $request->is_selected;
        $cart_detail = CartDetail::where('id', $id)->update([
            'quantity' => $quantity,
            'is_selected' => $is_selected
        ]);


        return response()->json($cart_detail);
    }

    public function update_select_cart(Request $request, $id) 
    {
        $is_selected = $request->is_selected;
        $cart_detail = CartDetail::where('id', $id)->update([
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
                    $select_all = CartDetail::where('id', $id)->update([
                            'is_selected' => $check
                    ]);                    
                }
                    $total_bayar = CartDetail::select('t_cart_detail.id', 'm_produk_seragam.id as id_produk','m_produk_seragam.nama_produk', 'm_produk_seragam.deskripsi', 'm_produk_seragam.image', 
                    'm_produk_seragam.material', 'mhs.harga', 'mhs.diskon', 'mjps.id as jenis_id', 'mp.nama_lengkap as nama_siswa', 'mp.nama_kelas as nama_kelas', 'mhs.kode_produk',
                    'mls.sublokasi as sekolah', 'mjps.jenis_produk', 't_cart_detail.quantity', 't_cart_detail.ukuran', 't_cart_detail.is_selected')
                    ->leftJoin('m_produk_seragam', 'm_produk_seragam.id', 't_cart_detail.produk_id')
                    ->leftJoin('m_profile as mp' , 'mp.nis', 't_cart_detail.nis')
                    ->leftJoin('mst_lokasi_sub as mls', 'mls.id', 'mp.sekolah_id')
                    ->leftJoin('m_jenis_produk_seragam as mjps', 'mjps.id', 't_cart_detail.jenis')
                    ->leftJoin('m_ukuran_seragam as mus', 'mus.ukuran_seragam', 't_cart_detail.ukuran')
                    ->leftJoin('m_harga_seragam as mhs', function($join)
                    { $join->on('mhs.produk_id', '=', 'm_produk_seragam.id') 
                        ->on('mhs.jenis_produk_id', '=', 'mjps.id')
                        ->on('mus.id', '=', 'mhs.ukuran_id'); 
                    })
                    ->leftJoin('t_stok_seragam as tss', 'mhs.kode_produk', 'tss.kd_barang')
                    ->where('t_cart_detail.user_id', $user_id)
                    ->where('t_cart_detail.status_cart', 0)
                    ->where('t_cart_detail.is_selected', 1)
                    ->where('tss.qty', '>', 0)
                    ->get();
                    $total_bayar_selected = 0;

                    foreach ($total_bayar as $item) {
                        $quantity = $item->quantity;
                        $harga = $item->harga * $quantity;
                        $diskon = $item->diskon;
                        $nilai_diskon = ($diskon/100 * $harga);

                        $total_harga = $harga - $nilai_diskon;

                        $total_bayar_selected += $total_harga;
                    }
                return response()->json($total_bayar_selected);
            }
        }
    }

    public function remove_cart($id) 
    {
        CartDetail::find($id)->delete();

        return redirect()->route('seragam.cart')
            ->with('error', 'Remove from cart successfully');
    }

    public function add_to_wishlist(Request $request)
    {
        $produk_id = $request->produk_id;
        $quantity = $request->quantity;
        $ukuran = $request->ukuran;
        $jenis = $request->jenis;
        $kode_produk = $request->kode_produk;
        $nis = $request->nama_siswa;
        $user_id = auth()->user()->id;
        $no_hp = auth()->user()->no_hp;

        $add_wishlist_detail =  Wishlist::create([
            'produk_id' => $produk_id,
            'user_id' => $user_id,
            'quantity' => $quantity,
            'ukuran' => $ukuran,
            'jenis' => $jenis,
            'kode_produk' => $kode_produk,
            'status_wl' => '1',
            'nis' => $nis
        ]);

        $this->send_wishlist($produk_id, $user_id, $quantity, $ukuran, $jenis, $nis, $no_hp, $kode_produk);
        $this->send_wishlist_baru($produk_id, $user_id, $quantity, $ukuran, $jenis, $nis, $no_hp, $kode_produk);

    
        return response()->json($add_wishlist_detail);

    }

    public function wishlist(Request $request)
    {

        $user_id = auth()->user()->id;

        $profile = Profile::where('user_id', $user_id)->get();

        $wishlist = Wishlist::select('t_wishlist_seragam.id', 'm_produk_seragam.id as id_produk','m_produk_seragam.nama_produk', 'm_produk_seragam.deskripsi', 'm_produk_seragam.image', 
                    'm_produk_seragam.material', 'mhs.harga', 'mhs.diskon', 'mjps.id as jenis_id', 'mhs.kode_produk',
                    'mjps.jenis_produk', 't_wishlist_seragam.quantity', 't_wishlist_seragam.ukuran', 'tss.qty')
                    ->leftJoin('m_produk_seragam', 'm_produk_seragam.id', 't_wishlist_seragam.produk_id')
                    ->leftJoin('m_jenis_produk_seragam as mjps', 'mjps.id', 't_wishlist_seragam.jenis')
                    ->leftJoin('m_ukuran_seragam as mus', 'mus.ukuran_seragam', 't_wishlist_seragam.ukuran')
                    ->leftJoin('m_harga_seragam as mhs', function($join)
                    { $join->on('mhs.produk_id', '=', 'm_produk_seragam.id') 
                        ->on('mhs.jenis_produk_id', '=', 'mjps.id')
                        ->on('mus.id', '=', 'mhs.ukuran_id'); 
                    })
                    ->leftJoin('t_stok_seragam as tss', 'mhs.kode_produk', 'tss.kd_barang')
                    ->where('t_wishlist_seragam.user_id', $user_id)
                    ->where('t_wishlist_seragam.status_wl', 1)
                    ->get();
        // dd($wishlist);

        return view('ortu.seragam.wishlist', compact('profile', 'wishlist'));
    }

    public function wishlist_seragam(Request $request)
    {
        $user_id = auth()->user()->id;

        $wishlist = Wishlist::select('t_wishlist_seragam.id', 'm_produk_seragam.id as id_produk','m_produk_seragam.nama_produk', 'm_produk_seragam.deskripsi', 'm_produk_seragam.image', 
                    'm_produk_seragam.material', 'mhs.harga', 'mhs.diskon', 'mjps.id as jenis_id', 'mhs.kode_produk',
                    'mjps.jenis_produk', 't_wishlist_seragam.quantity', 't_wishlist_seragam.ukuran', 't_wishlist_seragam.created_at')
                    ->leftJoin('m_produk_seragam', 'm_produk_seragam.id', 't_wishlist_seragam.produk_id')
                    ->leftJoin('m_jenis_produk_seragam as mjps', 'mjps.id', 't_wishlist_seragam.jenis')
                    ->leftJoin('m_ukuran_seragam as mus', 'mus.ukuran_seragam', 't_wishlist_seragam.ukuran')
                    ->leftJoin('m_harga_seragam as mhs', function($join)
                    { $join->on('mhs.produk_id', '=', 'm_produk_seragam.id') 
                        ->on('mhs.jenis_produk_id', '=', 'mjps.id')
                        ->on('mus.id', '=', 'mhs.ukuran_id'); 
                    })
                    ->where('t_wishlist_seragam.status_wl', 1)
                    ->get();
        // dd($wishlist);

        return view('admin.laporan.wishlist-seragam', compact('wishlist'));
    }


    public function remove_wishlist($id) 
    {
        Wishlist::find($id)->delete();

        return redirect()->route('seragam.wishlist')
            ->with('error', 'Remove from wishlist successfully');
    }

    public function export_wishlist()
    {
        return Excel::download(new WishlistExport(), 'wishlist.xlsx');
    }

    public function buy_now(Request $request)
    {
        
        $order = $request->all();
        $order_dec = json_decode($order['data'], true);
    
        $produk_id = $order_dec[0]['produk_id'];
        $quantity = $order_dec[0]['quantity'];
        $ukuran = $order_dec[0]['ukuran'];
        $jenis = $order_dec[0]['jenis'];
        $nis = $order_dec[0]['nama_siswa'];

        $produk_seragam = ProdukSeragam::select('m_produk_seragam.id', 'm_produk_seragam.nama_produk', 'm_produk_seragam.image', 
                        'mhs.harga', 'mhs.diskon', 'mhs.kode_produk', 'mjps.jenis_produk', 'mjps.id as jenis_produk_id', 'mhs.hpp', 'mhs.ppn')
                        ->leftJoin('m_harga_seragam as mhs', 'mhs.produk_id', 'm_produk_seragam.id')
                        ->leftJoin('m_jenis_produk_seragam as mjps', 'mjps.id', 'mhs.jenis_produk_id')
                        ->leftJoin('m_ukuran_seragam as mus', 'mus.id', 'mhs.ukuran_id')
                        ->where('m_produk_seragam.id', $produk_id)
                        ->where('mhs.jenis_produk_id', $jenis)
                        ->where('mus.ukuran_seragam', $ukuran)
                        ->first();

        $profile = Profile::leftJoin('mst_lokasi_sub as mls', 'mls.id', 'm_profile.sekolah_id' )
                            ->where('nis', $nis)->first();
        // dd($produk_seragam);

        return view('ortu.seragam.pembayaran', compact('profile', 'produk_seragam', 'quantity', 'ukuran', 'produk_id', 'profile', 'order'));

    }

    public function pembayaran(Request $request, OrderSeragam $order_seragam)
    {

        $user_id = auth()->user()->id;

        $order = $request->all();
        
        $profile = Profile::where('user_id', $user_id)->get();
        $cart_detail =  CartDetail::select('t_cart_detail.id', 'm_produk_seragam.id as id_produk','m_produk_seragam.nama_produk', 'm_produk_seragam.deskripsi', 'm_produk_seragam.image', 
                            'm_produk_seragam.material', 'mhs.harga', 'mhs.diskon', 'mjps.id as jenis_id', 'mp.nama_lengkap as nama_siswa', 'mp.nama_kelas as nama_kelas', 
                            'mls.sublokasi as sekolah', 'mjps.jenis_produk', 't_cart_detail.quantity', 't_cart_detail.ukuran', 'mhs.kode_produk')
                            ->leftJoin('m_produk_seragam', 'm_produk_seragam.id', 't_cart_detail.produk_id')
                            ->leftJoin('m_profile as mp' , 'mp.nis', 't_cart_detail.nis')
                            ->leftJoin('mst_lokasi_sub as mls', 'mls.id', 'mp.sekolah_id')
                            ->leftJoin('m_jenis_produk_seragam as mjps', 'mjps.id', 't_cart_detail.jenis')
                            ->leftJoin('m_ukuran_seragam as mus', 'mus.ukuran_seragam', 't_cart_detail.ukuran')
                            ->leftJoin('m_harga_seragam as mhs', function($join)
                            { $join->on('mhs.produk_id', '=', 'm_produk_seragam.id') 
                                ->on('mhs.jenis_produk_id', '=', 'mjps.id')
                                ->on('mus.id', '=', 'mhs.ukuran_id'); 
                            })
                            ->leftJoin('t_stok_seragam as tss', 'mhs.kode_produk', 'tss.kd_barang')
                            ->where('t_cart_detail.user_id', $user_id)
                            ->where('t_cart_detail.status_cart', 0)
                            ->where('t_cart_detail.is_selected', 1)
                            ->where('tss.qty', '>', 0)
                            ->get();

        return view('ortu.seragam.pembayaran', compact('profile', 'cart_detail', 'order_seragam', 'order'));
        
        // dd($order);
    }

    public function check_stok(Request $request)
    {
        $kode_produk = $request->kode_produk;

        $cek_stok = StokSeragam::where('kd_barang', $kode_produk)->first();
        $qty_stok = $cek_stok->qty;

        return response()->json($qty_stok);
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = auth()->user()->id;
        $no_hp = auth()->user()->no_hp;
        $nama_pemesan = auth()->user()->name;
        $no_pesanan = 'INV-RSU-'. date('YmdHis');
        $total_harga_now = $request->total_harga;
        $harga_awal_now = $request->harga_awal;
        $diskon_now = $request->diskon;
        $diskon_persen_now = $request->diskon_persen;
        $nama_siswa_now = $request->nama_siswa;
        $nama_kelas_now = $request->nama_kelas;
        $sekolah_id_now = $request->sekolah_id;
        $produk_id_now = $request->produk_id;
        $ukuran_now = $request->ukuran;
        $kode_produk_now = $request->kode_produk;
        $hpp_now = $request->hpp;
        $ppn_now = $request->ppn;
        $jenis_produk_now = $request->jenis_produk;
        $quantity_now = $request->quantity;

        if ($total_harga_now == null || $total_harga_now == 'undefined' || $total_harga_now == '') {

            $order = CartDetail::select('t_cart_detail.id', 'm_produk_seragam.id as id_produk','m_produk_seragam.nama_produk', 'm_produk_seragam.deskripsi', 'm_produk_seragam.image', 
                'm_produk_seragam.material', 'mhs.harga', 'mhs.diskon', 'mjps.id as jenis_id', 'mp.nama_lengkap as nama_siswa', 'mp.nama_kelas as nama_kelas', 
                'mls.id as sekolah', 'mjps.jenis_produk', 't_cart_detail.quantity', 't_cart_detail.ukuran', 'mhs.kode_produk', 'mhs.hpp', 'mhs.ppn')
                ->leftJoin('m_produk_seragam', 'm_produk_seragam.id', 't_cart_detail.produk_id')
                ->leftJoin('m_profile as mp' , 'mp.nis', 't_cart_detail.nis')
                ->leftJoin('mst_lokasi_sub as mls', 'mls.id', 'mp.sekolah_id')
                ->leftJoin('m_jenis_produk_seragam as mjps', 'mjps.id', 't_cart_detail.jenis')
                ->leftJoin('m_ukuran_seragam as mus', 'mus.ukuran_seragam', 't_cart_detail.ukuran')
                ->leftJoin('m_harga_seragam as mhs', function($join)
                { $join->on('mhs.produk_id', '=', 'm_produk_seragam.id') 
                    ->on('mhs.jenis_produk_id', '=', 'mjps.id')
                    ->on('mus.id', '=', 'mhs.ukuran_id'); 
                })
                ->leftJoin('t_stok_seragam as tss', 'mhs.kode_produk', 'tss.kd_barang')
                ->where('t_cart_detail.user_id', $user_id)
                ->where('t_cart_detail.status_cart', 0)
                ->where('t_cart_detail.is_selected', 1)
                ->where('tss.qty', '>', 0)
                ->get();

            $total_harga = 0;
            $total_diskon =0;
            foreach ($order as $item) {
                $nama_siswa = $item['nama_siswa'];
                $lokasi = $item['sekolah'];
                $nama_kelas = $item['nama_kelas'];
                $produk_id = $item['id_produk'];
                $ukuran = $item['ukuran'];
                $quantity = $item['quantity'];
                $harga_awal = $item['harga'];
                $diskon = $item['diskon'];
                $jenis_produk = $item['jenis_id'];
                $kode_produk = $item['kode_produk'];
                $hpp = $item['hpp'];
                $ppn = $item['ppn'];


                $order_detail = OrderDetailSeragam::create([
                'no_pemesanan' => $no_pesanan,
                'nama_siswa' => $nama_siswa,
                'lokasi_sekolah' => $lokasi,
                'nama_kelas' => $nama_kelas,
                'produk_id' => $produk_id,
                'ukuran' => $ukuran,
                'kode_produk' => $kode_produk,
                'quantity' => $quantity,
                'harga' => $harga_awal,
                'diskon' => $diskon/100 * $harga_awal,
                'jenis_produk_id' => $jenis_produk,
                'p_diskon' => $diskon,
                'hpp' => $hpp,
                'ppn' => $ppn
                ]);

                $total_harga += $harga_awal * $quantity;
                $total_diskon = $diskon/100 * $total_harga;
                $harga_akhir = $total_harga - $total_diskon;
                $harga_akhir_format = number_format($harga_akhir);

                $this->send_pesan_seragam_detail($no_pesanan, $nama_siswa, $lokasi, $nama_kelas, $produk_id, $jenis_produk, $kode_produk, $ukuran, $quantity, $harga_awal, $diskon/100 * $harga_awal, $diskon, $hpp, $ppn);
                $this->send_pesan_seragam_detail_baru($no_pesanan, $nama_siswa, $lokasi, $nama_kelas, $produk_id, $jenis_produk, $kode_produk, $ukuran, $quantity, $harga_awal, $diskon/100 * $harga_awal, $diskon, $hpp, $ppn);
                
                $this->update_cart_status($user_id, $kode_produk);
            }

            $order_seragam = OrderSeragam::create([

            'no_pemesanan' => $no_pesanan,
            'no_hp' => $no_hp,
            'nama_pemesan' => $nama_pemesan,
            'status' => 'pending',
            'total_harga' => $harga_akhir,
            'user_id' => $user_id
            ]);


            $this->send_pesan_seragam($no_pesanan, $nama_pemesan, $no_hp);
            $this->send_pesan_seragam_baru($no_pesanan, $nama_pemesan, $no_hp);

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
            $order_seragam->snap_token = $snapToken;
            $order_seragam->save();

            return response()->json($order_seragam);

        } else {
            $order_seragam_now = OrderSeragam::create([
                'no_pemesanan' => $no_pesanan,
                'no_hp' => $no_hp,
                'nama_pemesan' => $nama_pemesan,
                'status' => 'pending',
                'total_harga' => $total_harga_now,
                'user_id' => $user_id
            ]);

            $order_detail_now = OrderDetailSeragam::create([
                'no_pemesanan' => $no_pesanan,
                'nama_siswa' => $nama_siswa_now,
                'lokasi_sekolah' => $sekolah_id_now,
                'nama_kelas' => $nama_kelas_now,
                'produk_id' => $produk_id_now,
                'ukuran' => $ukuran_now,
                'kode_produk' => $kode_produk_now,
                'hpp' => $hpp_now,
                'ppn' => $ppn_now,
                'quantity' => $quantity_now,
                'harga' => $harga_awal_now,
                'diskon' => $diskon_now,
                'jenis_produk_id' => $jenis_produk_now,
                'p_diskon' => $diskon_persen_now
            ]);
            $this->send_pesan_seragam($no_pesanan, $nama_pemesan, $no_hp);
            $this->send_pesan_seragam_baru($no_pesanan, $nama_pemesan, $no_hp);


            $this->send_pesan_seragam_detail($no_pesanan, $nama_siswa_now, $sekolah_id_now, $nama_kelas_now, $produk_id_now, $jenis_produk_now, $kode_produk_now, $ukuran_now, $quantity_now, $harga_awal_now, $diskon_now, $diskon_persen_now, $hpp_now, $ppn_now);
            $this->send_pesan_seragam_detail_baru($no_pesanan, $nama_siswa_now, $sekolah_id_now, $nama_kelas_now, $produk_id_now, $jenis_produk_now, $kode_produk_now, $ukuran_now, $quantity_now, $harga_awal_now, $diskon_now, $diskon_persen_now, $hpp_now, $ppn_now);

                // Set your Merchant Server Key
            \Midtrans\Config::$serverKey = config('midtrans.serverKey');
            // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
            \Midtrans\Config::$isProduction = config('midtrans.isProduction');;
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
            $order_seragam_now->snap_token = $snapToken;
            $order_seragam_now->save();

            return response()->json($order_seragam_now);
        }
    }

    public function update_stok($kode_barang, $qty) {

        $stok_seragam = StokSeragam::where('kd_barang', $kode_barang)->first();
        $stok_now = $stok_seragam->qty;
        $jumlah_beli = intval($qty);

        $update_stok_decrease = $stok_seragam->update([
            'qty' => $stok_now - $jumlah_beli
        ]);

        return response()->json($update_stok_decrease);
    }

    public function update_cart_status($user_id, $kode_produk) 
    {
        $cart_detail = CartDetail::where('user_id', $user_id)
                ->where('status_cart', 0)
                ->where('kode_produk', $kode_produk)
                ->where('is_selected', 1)
                ->first();
        
        $update_status_cart = $cart_detail->update([
            'status_cart' => 1
        ]);

        return response()->json($update_status_cart);
    }


    public function success(Request $request) {

        return view('ortu.seragam.success');

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
        $order = OrderSeragam::where('no_pemesanan', $orderId)->first();
        $order_merch = OrderMerchandise::where('no_pesanan', $orderId)->first();
        $order_jersey = OrderJersey::where('no_pesanan', $orderId)->first();
        $pendaftaran_siswa = Pendaftaran::where('order_id', $orderId)->first();
       
        if (!$order && !$order_merch && !$order_jersey && !$pendaftaran_siswa) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order_detail = OrderDetailSeragam::select('kode_produk', 'quantity')->where('no_pemesanan', $orderId)->get();

        if ($order != null && $order_merch == null && $order_jersey == null && $pendaftaran_siswa == null) {
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
    
                        $stok_awal = StokSeragam::where('kd_barang', $kode_produk)->first();
    
                        $stok_card = StokCard::create([
                            'kd_gudang' => 'YYS',
                            'kd_barang' => $kode_produk,
                            'stok_awal' => $stok_awal->qty,
                            'qty' => $quantity,
                            'stok_akhir' => $stok_awal->qty - $quantity,
                            'proses' => 'penjualan',
                            'no_proses' => $orderId
                        ]);
    
                        $this->update_stok($kode_produk, $quantity);
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
    
                        $this->return_stock($kode_produk, $quantity);
                    }
                    break;
                case 'expire':
                    $order->update([
                        'status' => 'expired',
                        'metode_pembayaran' => $mtd_pembayaran,
                        'va_number' => $no_va
                    ]);
                    foreach ($order_detail as $item) {
                        $kode_produk = $item->kode_produk;
                        $quantity = $item->quantity;
    
                        $stok_awal = StokSeragam::where('kd_barang', $kode_produk)->first();
    
                        $stok_card = StokCard::create([
                            'kd_gudang' => 'YYS',
                            'kd_barang' => $kode_produk,
                            'stok_awal' => $stok_awal->qty,
                            'qty' => $quantity,
                            'stok_akhir' => $stok_awal->qty + $quantity,
                            'proses' => 'expired',
                            'no_proses' => $orderId
                        ]);
    
                        $this->return_stock($kode_produk, $quantity);
                    }
                    $this->update_status_seragam('expired', $mtd_pembayaran, $orderId);
                    break;
                case 'cancel':
                    $order->update([
                        'status' => 'canceled',
                        'metode_pembayaran' => $mtd_pembayaran,
                        'va_number' => $no_va
                    ]);
                    foreach ($order_detail as $item) {
                        $kode_produk = $item->kode_produk;
                        $quantity = $item->quantity;
    
                        $this->return_stock($kode_produk, $quantity);
                    }
                    break;
                default:
                    $order->update([
                        'status' => 'unknown',
                    ]);
                    break;
            }
    
            return response()->json(['message' => 'Callback received successfully']);
        } else if ($order_jersey != null && $order == null  && $order_merch == null && $pendaftaran_siswa == null) {
            switch ($transactionStatus) {
                case 'capture':
                    if ($request->payment_type == 'credit_card') {
                        if ($request->fraud_status == 'challenge') {
                            $order_jersey->update([
                                'status' => 'pending',
                                'metode_pembayaran' => $mtd_pembayaran,
                                'va_number' => $no_va
                            ]);
                        } else {
                            $order_jersey->update([
                                'status' => 'success',
                                'metode_pembayaran' => $mtd_pembayaran,
                                'va_number' => $no_va
                            ]);
                        }
                    }
                    break;
                case 'settlement':
                    $order_jersey->update([
                        'status' => 'success',
                        'metode_pembayaran' => $mtd_pembayaran,
                        'va_number' => $no_va,
                        'tgl_bayar' => $request->settlement_time,
                        'updated_at' => $request->settlement_time
                    ]);
                    $this->update_status_jersey('success', $mtd_pembayaran, $orderId);
                    break;
                case 'pending':
                    $order_jersey->update([
                        'status' => 'pending',
                        'metode_pembayaran' => $mtd_pembayaran,
                        'va_number' => $no_va,
                        'expire_time' => $request->expiry_time
                    ]);
                    $this->update_status_jersey('pending', $mtd_pembayaran, $orderId);
                    break;
                case 'deny':
                    $order_jersey->update([
                        'status' => 'failed',
                        'metode_pembayaran' => $mtd_pembayaran,
                        'va_number' => $no_va
                    ]);
                   
                    break;
                case 'expire':
                    $order_jersey->update([
                        'status' => 'expired',
                        'metode_pembayaran' => $mtd_pembayaran,
                        'va_number' => $no_va
                    ]);
                    $this->update_status_jersey('expired', $mtd_pembayaran, $orderId);
                    break;
                case 'cancel':
                    $order_jersey->update([
                        'status' => 'canceled',
                        'metode_pembayaran' => $mtd_pembayaran,
                        'va_number' => $no_va
                    ]);
                    break;
                default:
                    $order_jersey->update([
                        'status' => 'unknown',
                    ]);
                    break;
            }
    
            return response()->json(['message' => 'Callback received successfully']);
        } else if ($order_merch != null && $order == null  && $order_jersey == null && $pendaftaran_siswa == null) {
            switch ($transactionStatus) {
                case 'capture':
                    if ($request->payment_type == 'credit_card') {
                        if ($request->fraud_status == 'challenge') {
                            $order_merch->update([
                                'status' => 'pending',
                                'metode_pembayaran' => $mtd_pembayaran,
                                'va_number' => $no_va
                            ]);
                        } else {
                            $order_merch->update([
                                'status' => 'success',
                                'metode_pembayaran' => $mtd_pembayaran,
                                'va_number' => $no_va
                            ]);
                        }
                    }
                    break;
                case 'settlement':
                    $order_merch->update([
                        'status' => 'success',
                        'metode_pembayaran' => $mtd_pembayaran,
                        'va_number' => $no_va,
                        'updated_at' => $request->settlement_time
                    ]);
                    $this->update_status_merchandise('success', $mtd_pembayaran, $orderId);
                    break;
                case 'pending':
                    $order_merch->update([
                        'status' => 'pending',
                        'metode_pembayaran' => $mtd_pembayaran,
                        'va_number' => $no_va,
                        'expire_time' => $request->expiry_time
                    ]);
                    $this->update_status_merchandise('pending', $mtd_pembayaran, $orderId);
                    break;
                case 'deny':
                    $order_merch->update([
                        'status' => 'failed',
                        'metode_pembayaran' => $mtd_pembayaran,
                        'va_number' => $no_va
                    ]);
                   
                    break;
                case 'expire':
                    $order_merch->update([
                        'status' => 'expired',
                        'metode_pembayaran' => $mtd_pembayaran,
                        'va_number' => $no_va
                    ]);
                    $this->update_status_merchandise('expired', $mtd_pembayaran, $orderId);
                    break;
                case 'cancel':
                    $order_merch->update([
                        'status' => 'canceled',
                        'metode_pembayaran' => $mtd_pembayaran,
                        'va_number' => $no_va
                    ]);
                    break;
                default:
                    $order_merch->update([
                        'status' => 'unknown',
                    ]);
                    break;
            }
    
            return response()->json(['message' => 'Callback received successfully']);
        } else if ($pendaftaran_siswa != null && $order == null  && $order_jersey == null && $order_merch == null) {
            switch ($transactionStatus) {
                case 'capture':
                    if ($request->payment_type == 'credit_card') {
                        if ($request->fraud_status == 'challenge') {
                            Pendaftaran::where('order_id', $orderId)->update([
                               'status_midtrans' => 'pending',
                                'metode_pembayaran' => $mtd_pembayaran,
                                'va_number' => $no_va
                            ]);
                        } else {
                            Pendaftaran::where('order_id', $orderId)->update([
                               'status_midtrans' => 'success',
                                'status_pembayaran' => 1,
                                'metode_pembayaran' => $mtd_pembayaran,
                                'va_number' => $no_va,
                                'tgl_bayar' => $request->settlement_time,
                                'updatedate' => $request->settlement_time,
                            ]);
                            $data_anak = Pendaftaran::where('order_id', $orderId)->first();
                            $this->update_status_pendaftaran_siswa('success', $mtd_pembayaran, $data_anak->id_anak, $orderId);

                            $data_anak = Pendaftaran::where('order_id', $orderId)->first();
                            // TODO: Tracing Error contact_person dan contact_ccrs
                            $contact_person =  ContactPerson::where('is_aktif', '1')->where('kode_sekolah', $data_anak->lokasi)->where('id_jenjang', $data_anak->jenjang)->first();
                            // $no_admin = $contact_person->telp;
                            $contact_ccrs =  ContactPerson::where('id', '16')->first();
                            $contact_ccrs =  $contact_ccrs->telp;
                            // $no_hp_ayah = $data_anak->no_hp_ayah;
                            // $no_hp_ibu = $data_anak->no_hp_ibu;
                            
                            // TODO: HAPUS INI TESTING
                            $no_admin = '+6285173044086';
                            $no_hp_ayah = '+6285173044086';
                            $no_hp_ibu = '+6285173044086';

                            //send notif ke admin
                            $message_for_admin='
Telah diterima pembayaran biaya pendaftaran:

📌 No. Registrasi: '.$data_anak->id_anak.'
👤 Nama Ananda: '.$data_anak->nama_lengkap.'
💳 Jumlah Bayar: Rp '.$request->gross_amount.'
⏰ Waktu Pembayaran: '.$request->settlement_time.'

Status pendaftaran sudah otomatis tercatat di sistem dan dapat dipantau melalui dashboard.';

                    $message_for_admin_wl='
Telah diterima pembayaran biaya pendaftaran:

📌 No. Registrasi: '.$data_anak->id_anak.'
👤 Nama Ananda: '.$data_anak->nama_lengkap.'
💳 Jumlah Bayar: Rp '.$request->gross_amount.'
⏰ Waktu Pembayaran: '.$request->settlement_time.'

Status pendaftaran sudah otomatis tercatat di sistem dan dapat dipantau melalui dashboard.';

                            //send notif ke ortu
                            $message_ortu = "
✅ Pembayaran Pendaftaran Berhasil

Terima kasih Ayah/Bunda '.$data_anak->nama_lengkap.' 🙏
Kami telah menerima pembayaran biaya pendaftaran sebesar Rp '.$request->gross_amount.'. untuk:

📌 No. Registrasi / Pendaftaran: '.$data_anak->id_anak.'
📌 Nama Ananda: .$data_anak->nama_lengkap.'

Status pendaftaran Ananda kini resmi tercatat di sistem Sekolah Rabbani dan akan diproses ke tahap selanjutnya.

📞 Untuk informasi lebih lanjut atau pertanyaan, silakan hubungi Customer Service kami di ".$contact_ccrs.".

Terima kasih atas kepercayaan Ayah/Bunda kepada Sekolah Rabbani 🌟

Hormat kami,
Sekolah Rabbani ✨
                    ";

                            $message_waiting_list = "
✅ Pembayaran Pendaftaran Berhasil

Terima kasih Ayah/Bunda '.$data_anak->nama_lengkap.' 🙏
Kami telah menerima pembayaran biaya pendaftaran sebesar Rp '.$request->gross_amount.'. untuk:

📌 No. Registrasi / Pendaftaran: '.$data_anak->id_anak.'
📌 Nama Ananda: .$data_anak->nama_lengkap.'

Status pendaftaran Ananda kini resmi tercatat di sistem Sekolah Rabbani dan akan diproses ke tahap selanjutnya.

📞 Untuk informasi lebih lanjut atau pertanyaan, silakan hubungi Customer Service kami di ".$contact_ccrs.".

Terima kasih atas kepercayaan Ayah/Bunda kepada Sekolah Rabbani 🌟

Hormat kami,
Sekolah Rabbani ✨
                    ";
                    
                            if ($data_anak->status_daftar == 3) {
                                $this->send_notif_new($message_for_admin_wl, $no_admin);
                                $this->send_notif_new($message_waiting_list, $no_hp_ayah);
                                $this->send_notif_new($message_waiting_list, $no_hp_ibu);
                            } else {
                                $this->send_notif_new($message_for_admin, $no_admin);
                                $this->send_notif_new($message_ortu, $no_hp_ayah);
                                $this->send_notif_new($message_ortu, $no_hp_ibu);
                            }
                        }
                    }
                    break;
                case 'settlement':
                    Pendaftaran::where('order_id', $orderId)->update([
                        'status_midtrans' => 'success',
                        'status_pembayaran' => 1,
                        'metode_pembayaran' => $mtd_pembayaran,
                        'va_number' => $no_va,
                        'tgl_bayar' => $request->settlement_time,
                        'updatedate' => $request->settlement_time,
                    ]);
                    $data_anak = Pendaftaran::where('order_id', $orderId)->first();
                    $this->update_status_pendaftaran_siswa('success', $mtd_pembayaran, $data_anak->id_anak, $orderId);
                    $data_anak = Pendaftaran::where('order_id', $orderId)->first();
                    // TODO: Tracing Error contact_person dan contact_ccrs
                    $contact_person =  ContactPerson::where('is_aktif', '1')->where('kode_sekolah', $data_anak->lokasi)->where('id_jenjang', $data_anak->jenjang)->first();
                    // $no_admin = $contact_person->telp;
                    $contact_ccrs =  ContactPerson::where('id', '16')->first();
                    $contact_ccrs =  $contact_ccrs->telp;
                    // $no_hp_ayah = $data_anak->no_hp_ayah;
                    // $no_hp_ibu = $data_anak->no_hp_ibu;
                    
                    // TODO: HAPUS INI TESTING
                    $no_admin = '+6285173044086';
                    $no_hp_ayah = '+6285173044086';
                    $no_hp_ibu = '+6285173044086';

                    //send notif ke admin
                    $message_for_admin='
Telah diterima pembayaran biaya pendaftaran:

📌 No. Registrasi: '.$data_anak->id_anak.'
👤 Nama Ananda: '.$data_anak->nama_lengkap.'
💳 Jumlah Bayar: Rp '.$request->gross_amount.'
⏰ Waktu Pembayaran: '.$request->settlement_time.'

Status pendaftaran sudah otomatis tercatat di sistem dan dapat dipantau melalui dashboard.';

                    $message_for_admin_wl='
Telah diterima pembayaran biaya pendaftaran:

📌 No. Registrasi: '.$data_anak->id_anak.'
👤 Nama Ananda: '.$data_anak->nama_lengkap.'
💳 Jumlah Bayar: Rp '.$request->gross_amount.'
⏰ Waktu Pembayaran: '.$request->settlement_time.'

Status pendaftaran sudah otomatis tercatat di sistem dan dapat dipantau melalui dashboard.';

                    //send notif ke ortu
                    $message_ortu = "
✅ Pembayaran Pendaftaran Berhasil

Terima kasih Ayah/Bunda '.$data_anak->nama_lengkap.' 🙏
Kami telah menerima pembayaran biaya pendaftaran sebesar Rp '.$request->gross_amount.'. untuk:

📌 No. Registrasi / Pendaftaran: '.$data_anak->id_anak.'
📌 Nama Ananda: .$data_anak->nama_lengkap.'

Status pendaftaran Ananda kini resmi tercatat di sistem Sekolah Rabbani dan akan diproses ke tahap selanjutnya.

📞 Untuk informasi lebih lanjut atau pertanyaan, silakan hubungi Customer Service kami di ".$contact_ccrs.".

Terima kasih atas kepercayaan Ayah/Bunda kepada Sekolah Rabbani 🌟

Hormat kami,
Sekolah Rabbani ✨
                    ";

                    $message_waiting_list = "
✅ Pembayaran Pendaftaran Berhasil

Terima kasih Ayah/Bunda '.$data_anak->nama_lengkap.' 🙏
Kami telah menerima pembayaran biaya pendaftaran sebesar Rp '.$request->gross_amount.'. untuk:

📌 No. Registrasi / Pendaftaran: '.$data_anak->id_anak.'
📌 Nama Ananda: .$data_anak->nama_lengkap.'

Status pendaftaran Ananda kini resmi tercatat di sistem Sekolah Rabbani dan akan diproses ke tahap selanjutnya.

📞 Untuk informasi lebih lanjut atau pertanyaan, silakan hubungi Customer Service kami di ".$contact_ccrs.".

Terima kasih atas kepercayaan Ayah/Bunda kepada Sekolah Rabbani 🌟

Hormat kami,
Sekolah Rabbani ✨
                    ";
                    
                    if ($data_anak->status_daftar == 3) {
                        $this->send_notif_new($message_for_admin_wl, $no_admin);
                        $this->send_notif_new($message_waiting_list, $no_hp_ayah);
                        $this->send_notif_new($message_waiting_list, $no_hp_ibu);
                    } else {
                        $this->send_notif_new($message_for_admin, $no_admin);
                        $this->send_notif_new($message_ortu, $no_hp_ayah);
                        $this->send_notif_new($message_ortu, $no_hp_ibu);
                    }
                    break;
                case 'pending':
                    Pendaftaran::where('order_id', $orderId)->update([
                        'status_midtrans' => 'pending',
                        'metode_pembayaran' => $mtd_pembayaran,
                        'va_number' => $no_va,
                        'expire_time' => $request->expiry_time
                    ]);
                    $data_anak = Pendaftaran::where('order_id', $orderId)->first();
                    $this->update_status_pendaftaran_siswa('pending', $mtd_pembayaran, $data_anak->id_anak, $orderId);
                    break;
                case 'deny':
                    Pendaftaran::where('order_id', $orderId)->update([
                        'status_midtrans' => 'failed',
                        'metode_pembayaran' => $mtd_pembayaran,
                        'va_number' => $no_va
                    ]);
                    break;
                case 'expire':
                    Pendaftaran::where('order_id', $orderId)->update([
                        'status_midtrans' => 'expired',
                        'metode_pembayaran' => $mtd_pembayaran,
                        'va_number' => $no_va
                    ]);
                    $data_anak = Pendaftaran::where('order_id', $orderId)->first();
                    $this->update_status_pendaftaran_siswa('expired', $mtd_pembayaran, $data_anak->id_anak, $orderId);

                    $data_anak = Pendaftaran::where('order_id', $orderId)->first();
                    // $contact_ccrs =  ContactPerson::where('id', '16')->first();
                    // $contact_ccrs =  $contact_ccrs->telp;
                    // $no_hp_ayah = $data_anak->no_hp_ayah;
                    // $no_hp_ibu = $data_anak->no_hp_ibu;
                    
                    // TODO: HAPUS INI TESTING
                    $no_hp_ayah = '+6285173044086';
                    $no_hp_ibu = '+6285173044086';

                    //send notif ke ortu
                    $message_ortu = "
❌ Pembayaran Pendaftaran Telah Kedaluwarsa

Mohon Maaf Ayah/Bunda '.$data_anak->nama_lengkap.' 🙏
Pembayaran biaya pendaftaran sebesar Rp '.$request->gross_amount.'. untuk:

📌 No. Registrasi / Pendaftaran: '.$data_anak->id_anak.'
📌 Nama Ananda: .$data_anak->nama_lengkap.'

Status pendaftaran Ananda kini telah kedaluwarsa, silakan untuk mendaftarkan ulang, dan melakukan pembayaran biaya pendaftaran.

📞 Untuk informasi lebih lanjut atau pertanyaan, silakan hubungi Customer Service kami di +62

Hormat kami,
Sekolah Rabbani ✨
                    ";

                    $message_waiting_list = "
❌ Pembayaran Pendaftaran Telah Kedaluwarsa

Mohon Maaf Ayah/Bunda '.$data_anak->nama_lengkap.' 🙏
Pembayaran biaya pendaftaran sebesar Rp '.$request->gross_amount.'. untuk:

📌 No. Registrasi / Pendaftaran: '.$data_anak->id_anak.'
📌 Nama Ananda: .$data_anak->nama_lengkap.'

Status pendaftaran Ananda kini telah kedaluwarsa, silakan untuk mendaftarkan ulang, dan melakukan pembayaran biaya pendaftaran.

📞 Untuk informasi lebih lanjut atau pertanyaan, silakan hubungi Customer Service kami di +62

Hormat kami,
Sekolah Rabbani ✨
                    ";
                    
                    if ($data_anak->status_daftar == 3) {
                        $this->send_notif_new($message_waiting_list, $no_hp_ayah);
                        $this->send_notif_new($message_waiting_list, $no_hp_ibu);
                    } else {
                        $this->send_notif_new($message_ortu, $no_hp_ayah);
                        $this->send_notif_new($message_ortu, $no_hp_ibu);
                    }

                    break;
            }
    
            return response()->json(['message' => 'Callback received successfully']);
        }  
    }

    public function return_stock($kode_barang, $qty) {
        $stok_seragam = StokSeragam::where('kd_barang', $kode_barang)->first();
        $stok_now = $stok_seragam->qty;
        $jumlah_return = intval($qty);

        $update_stok_return = $stok_seragam->update([
            'qty' => $stok_now + $jumlah_return
        ]);

        return response()->json($update_stok_return);
    }


    public function history(Request $request) {
        $user_id = auth()->user()->id;
        $menubar = MenuMobile::where('is_footer', 1)->orderBy('no', 'asc')->get();


        $order = OrderSeragam::select('psd.*', 'mps.image', 'mps.nama_produk', 't_pesan_seragam.status', 't_pesan_seragam.total_harga', 't_pesan_seragam.user_id')
                                ->leftJoin('t_pesan_seragam_detail as psd', 'psd.no_pemesanan', 't_pesan_seragam.no_pemesanan')
                                ->leftJoin('m_produk_seragam as mps', 'psd.produk_id', 'mps.id')
                                ->where('t_pesan_seragam.user_id', $user_id)
                                ->groupby('psd.no_pemesanan', 't_pesan_seragam.total_harga')
                                ->orderby('psd.created_at', 'DESC')
                                ->get();

        $order_merch = OrderMerchandise::where('user_id', $user_id)->where('status', 'success')->get();

        $order_detail_merch = OrderMerchandise::select('tpmd.*', 'mm.nama_produk', 'mwk.warna', 'mtd.judul as template', 
                        'mus.ukuran_seragam', 'mku.kategori', 'tdp.nis', 'mm.image_1', 't_pesan_merchandise.status', 
                        't_pesan_merchandise.total_harga')
                        ->leftJoin('t_pesan_merchandise_detail as tpmd', 'tpmd.no_pesanan', 't_pesan_merchandise.no_pesanan')
                        ->leftJoin('m_merchandise as mm', 'mm.id', 'tpmd.merchandise_id')
                        ->leftJoin('m_warna_kaos as mwk', 'mwk.id', 'tpmd.warna_id')
                        ->leftJoin('m_ukuran_seragam as mus', 'mus.id', 'tpmd.ukuran_id')
                        ->leftJoin('m_kategori_umur as mku', 'mku.id', 'tpmd.kategori_id')
                        ->leftJoin('m_template_desain as mtd', 'mtd.id', 'tpmd.template_id')
                        ->leftJoin('t_desain_palestineday as tdp', 'tdp.id', 'tpmd.design_id')
                        ->where('t_pesan_merchandise.user_id', $user_id)
                        ->groupby('tpmd.no_pesanan')
                        ->orderby('tpmd.created_at', 'DESC')
                        ->get();

        $order_jersey = Orderjersey::select('psj.*', 'mj.image_1', 'mj.nama_jersey', 't_pesan_jersey.status', 't_pesan_jersey.total_harga', 't_pesan_jersey.user_id')
                                ->leftJoin('t_pesan_jersey_detail as psj', 'psj.no_pesanan', 't_pesan_jersey.no_pesanan')
                                ->leftJoin('m_jersey as mj', 'psj.jersey_id', 'mj.id')
                                ->where('t_pesan_jersey.user_id', $user_id)
                                ->groupby('psj.no_pesanan', 't_pesan_jersey.total_harga')
                                ->orderby('psj.created_at', 'DESC')
                                ->get();
        
        return view('ortu.seragam.history', compact('order', 'menubar', 'order_merch', 'order_detail_merch', 'order_jersey'));
    }

     public function rincian_pesanan(Request $request, $id) {
        $user_id = auth()->user()->id;

        $order = OrderSeragam::where('no_pemesanan', $id)->first();

        $order_detail = OrderDetailSeragam::select('tps.no_pemesanan', 'tps.metode_pembayaran', 'tps.va_number', 't_pesan_seragam_detail.*', 'mps.nama_produk', 'mps.image')
                                            ->leftJoin('m_produk_seragam as mps', 't_pesan_seragam_detail.produk_id', 'mps.id')
                                            ->leftJoin('t_pesan_seragam as tps', 'tps.no_pemesanan', 't_pesan_seragam_detail.no_pemesanan')
                                            ->where('tps.no_pemesanan', $id)->get();
        
        $tglPesan = $order->created_at->format('Y-m-d');

        $orderStatus = $order->status == 'success';
        $tglUpdateBaru = Carbon::parse($tglPesan)->gte(Carbon::parse('2025-08-01'));
        // dd($tglUpdateBaru);
        

        return view('ortu.seragam.rincian-pesan', compact( 'order', 'order_detail','tglUpdateBaru','orderStatus'));
    }

    public function terimaSeragam($no_pemesanan, $tgl_terima_ortu) { 
        // Ambil ID pengguna yang sedang login
        $user_id = auth()->user()->id;

        // Cari order berdasarkan no_pemesanan dan user_id yang sesuai dengan yang login
        $order = OrderSeragam::where('no_pemesanan', $no_pemesanan)
                            ->where('user_id', $user_id)
                            ->first();
        
        // Jika order ditemukan
        if ($order) {
            // Cari semua detail order berdasarkan no_pemesanan
            $order_details = OrderDetailSeragam::where('no_pemesanan', $no_pemesanan)->get();
            
            // Pastikan ada detail pesanan
            if ($order_details->isNotEmpty()) {
                // Update tgl_terima_ortu untuk setiap detail order
                foreach ($order_details as $order_detail) {
                    $order_detail->tgl_terima_ortu = $tgl_terima_ortu;
                    $order_detail->save();  // Simpan perubahan untuk setiap item
                }

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

                // Mengembalikan respons sukses
                return response()->json(['message' => 'Tanggal terima seragam berhasil diperbarui.']);
            } else {
                return response()->json(['error' => 'Detail pesanan tidak ditemukan.'], 404);
            }
        } else {
            return response()->json(['error' => 'Order tidak ditemukan atau Anda tidak memiliki akses ke order ini.'], 404);
        }
    }

    public function download(Request $request, $id) {
        $user_id = auth()->user()->id;

        $order = OrderSeragam::where('no_pemesanan', $id)->first();

        $order_detail = OrderDetailSeragam::select('tps.no_pemesanan', 'tps.metode_pembayaran', 'tps.va_number', 't_pesan_seragam_detail.*', 'mps.nama_produk', 'mps.image', 'mjps.jenis_produk')
                                            ->leftJoin('m_produk_seragam as mps', 't_pesan_seragam_detail.produk_id', 'mps.id')
                                            ->leftJoin('t_pesan_seragam as tps', 'tps.no_pemesanan', 't_pesan_seragam_detail.no_pemesanan')
                                            ->leftJoin('m_jenis_produk_seragam as mjps', 'mjps.id', 't_pesan_seragam_detail.jenis_produk_id')
                                            ->where('tps.no_pemesanan', $id)->get();
        // dd($order);

        // Load view dengan data yang disiapkan
        $pdf = Pdf::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('ortu.seragam.invoice', [
                        'order' => $order,
                        'order_detail' => $order_detail
                    ]);
        $pdf->setPaper('Letter');
        $pdf->setWarnings(false);

        // Download file PDF
        return $pdf->download('Invoice-'.$id.'.pdf');
    }

    public function invoice(Request $request, $id) {

        $pemesan = OrderSeragam::where('no_pemesanan', $id)->first();
        // dd($pemesan);
        $detail_pesan = OrderDetailSeragam::get_detail_produk($id);
        // dd($detail_pesan);

        // $pdf = Pdf::loadView('invoice.index', ['data' => $pemesan, $detail_pesan]);
     
        return view('ortu.seragam.invoice', compact('pemesan', 'detail_pesan'));
    }

    public function list_seragam(Request $request) {
        $user = Auth::user();
        $id_role = $user->id_role;
        // dd($id_role);
        $list_produk = ProdukSeragam::all();
        $list_ukuran = UkuranSeragam::all();
        $list_jenis = JenisSeragam::all();

        $nama_produk = $request->nama_produk ?? null;
        $jenis_produk = $request->jenis_produk ?? null;
        $ukuran = $request->ukuran ?? null;

        if ($request->has('nama_produk') || $request->has('jenis_produk') || $request->has('ukuran') ) {
            $list_seragam = HargaSeragam::select('m_harga_seragam.id', 'mps.nama_produk', 'mjps.jenis_produk', 'mus.ukuran_seragam',
                                        'm_harga_seragam.kode_produk', 'm_harga_seragam.harga', 'm_harga_seragam.diskon', 'tss.qty')
                                        ->leftJoin('m_ukuran_seragam as mus', 'mus.id', 'm_harga_seragam.ukuran_id')
                                        ->leftJoin('m_produk_seragam as mps', 'mps.id', 'm_harga_seragam.produk_id')
                                        ->leftJoin('m_jenis_produk_seragam as mjps', 'mjps.id', 'm_harga_seragam.jenis_produk_id')
                                        ->leftJoin('t_stok_seragam as tss', 'tss.kd_barang', 'm_harga_seragam.kode_produk');

            if ($request->has('nama_produk')) {
                $list_seragam = $list_seragam->where('produk_id', $nama_produk);
            } 

            if ($request->has('ukuran')) {
                $list_seragam =  $list_seragam->where('ukuran_id', $ukuran);
            }

            if ($request->has('jenis_produk')) {
                $list_seragam =  $list_seragam->where('jenis_produk_id', $jenis_produk);
            }

            $list_seragam = $list_seragam->get();

        } else {
            $list_seragam = HargaSeragam::select('m_harga_seragam.id', 'mps.nama_produk', 'mjps.jenis_produk', 'mus.ukuran_seragam',
                            'm_harga_seragam.kode_produk', 'm_harga_seragam.harga', 'm_harga_seragam.diskon', 'tss.qty')
                            ->leftJoin('m_ukuran_seragam as mus', 'mus.id', 'm_harga_seragam.ukuran_id')
                            ->leftJoin('m_produk_seragam as mps', 'mps.id', 'm_harga_seragam.produk_id')
                            ->leftJoin('m_jenis_produk_seragam as mjps', 'mjps.id', 'm_harga_seragam.jenis_produk_id')
                            ->leftJoin('t_stok_seragam as tss', 'tss.kd_barang', 'm_harga_seragam.kode_produk')
                            ->get();
            
        }

        return view('admin.master.seragam', compact('list_seragam', 'list_produk', 'list_ukuran', 'list_jenis', 'nama_produk', 'jenis_produk', 'ukuran', 'id_role'));
    }

    public function create_seragam(Request $request) {
        $product_name = $request->product_name_add;
        $ukuran_produk_add = $request->ukuran_produk_add;
        $jenis_produk_add = $request->jenis_produk_add;
        $harga_add = $request->harga_add;
        $diskon_add = $request->diskon_add;
        $kode_produk_add = $request->kode_produk_add;
        $barcode15_add = $request->barcode15_add;
        $style_produk_add = $request->style_produk_add;
        $stock_add = $request->stock_add;

        $add_product = HargaSeragam::create([
            'produk_id' => $product_name,
            'jenis_produk_id' => $jenis_produk_add,
            'ukuran_id' => $ukuran_produk_add,
            'harga' => $harga_add,
            'diskon' => $diskon_add,
            'kode_produk' => $kode_produk_add,
            'stok' => $stock_add,
            'style_produk' => $style_produk_add
        ]);

        $add_stock = StokSeragam::create([
            'kd_barang' =>$kode_produk_add,
            'qty' => $stock_add,
            'barcode_15' => $barcode15_add
        ]);

        return redirect()->back()->with('success', 'create new seragam successfully');
      
    }

    public function export_seragam()
    {
        return Excel::download(new StokExport(), 'stok.xlsx');
    }

    public function detail_seragam(Request $request, $id)
    {
        $dtl_seragam = HargaSeragam::select('m_harga_seragam.id', 'mps.nama_produk', 'mjps.jenis_produk', 'mus.ukuran_seragam',
                        'm_harga_seragam.kode_produk', 'm_harga_seragam.harga', 'm_harga_seragam.diskon', 'tss.qty')
                        ->leftJoin('m_ukuran_seragam as mus', 'mus.id', 'm_harga_seragam.ukuran_id')
                        ->leftJoin('m_produk_seragam as mps', 'mps.id', 'm_harga_seragam.produk_id')
                        ->leftJoin('m_jenis_produk_seragam as mjps', 'mjps.id', 'm_harga_seragam.jenis_produk_id')
                        ->leftJoin('t_stok_seragam as tss', 'tss.kd_barang', 'm_harga_seragam.kode_produk')
                        ->where('m_harga_seragam.id', $id)
                        ->first();

        return response($dtl_seragam);
    }

    public function update_seragam(Request $request)
    {
        $user = auth()->user()->name;

        $harga = $request->harga;
        $diskon = $request->diskon;
        $id = $request->id;
        $kode_produk = $request->kode_produk;
        $stock_update = $request->stock;
        $keterangan = $request->keterangan;
        
        $stock_seragam = StokSeragam::find($id);
        $stok_awal = $stock_seragam->qty;

        $update_seragam = HargaSeragam::find($id);

        $update_seragam->update([
            'harga' => $harga,
            'diskon' => $diskon,
            'kode_produk' => $kode_produk
        ]);

        $stock_seragam->update([
            'kd_barang' => $kode_produk,
            'qty' => $stock_update
        ]);

        $stok_card_seragam = StokCard::create([
            'kd_gudang' => 'YYS',
            'kd_barang' => $kode_produk,
            'stok_awal' => $stok_awal,
            'qty' => $stock_update - $stok_awal,
            'stok_akhir' => $stok_awal + ($stock_update - $stok_awal),
            'updateby' => $user,
            'proses' => $keterangan
        ]);

        return response()->json($update_seragam);
    }

    public function resume_seragam()
    {
        $this_month = date('Y-m');

        $total_pesanan = OrderSeragam::select(DB::raw('SUM( (tpsd.harga * tpsd.quantity) - (tpsd.diskon * quantity) ) as grand_total'))
        ->leftJoin('t_pesan_seragam_detail as tpsd', 'tpsd.no_pemesanan', 't_pesan_seragam.no_pemesanan')
        ->where('t_pesan_seragam.status', 'success')
        ->first();

        $hpp = OrderSeragam::select(DB::raw('SUM( (tpsd.hpp * tpsd.quantity) ) as total_hpp'))
        ->leftJoin('t_pesan_seragam_detail as tpsd', 'tpsd.no_pemesanan', 't_pesan_seragam.no_pemesanan')
        ->where('t_pesan_seragam.status', 'success')
        ->first();

        $profit = $total_pesanan->grand_total - $hpp->total_hpp;

        $sales_per_month = OrderSeragam::select(DB::raw('SUM( total_harga ) as sales_month'))
                        ->where('status', 'success')
                        ->where('updated_at', 'LIKE', $this_month.'%')
                        ->first();

        $total_sales_by_item = OrderSeragam::select('mps.nama_produk', 'tpsd.harga', 'tpsd.diskon', DB::raw('sum(tpsd.quantity) as total_quantity'))
        ->leftJoin('t_pesan_seragam_detail as tpsd', 'tpsd.no_pemesanan', 't_pesan_seragam.no_pemesanan')
        ->leftJoin('m_produk_seragam as mps', 'mps.id', 'tpsd.produk_id')
        ->leftJoin('m_jenis_produk_seragam as mjps', 'mjps.id', 'tpsd.jenis_produk_id')
        ->leftJoin('m_ukuran_seragam as mus', 'mus.ukuran_seragam', 'tpsd.ukuran')
        ->where('t_pesan_seragam.status', 'success')
        ->groupby('tpsd.produk_id')
        ->orderby('total_quantity', 'desc')
        ->take(5)
        ->get();

        $count_sales_by_item = OrderSeragam::select('mps.nama_produk', 'tpsd.harga', 'tpsd.diskon', DB::raw('sum(tpsd.quantity) as total_quantity'))
        ->leftJoin('t_pesan_seragam_detail as tpsd', 'tpsd.no_pemesanan', 't_pesan_seragam.no_pemesanan')
        ->leftJoin('m_produk_seragam as mps', 'mps.id', 'tpsd.produk_id')
        ->leftJoin('m_jenis_produk_seragam as mjps', 'mjps.id', 'tpsd.jenis_produk_id')
        ->leftJoin('m_ukuran_seragam as mus', 'mus.ukuran_seragam', 'tpsd.ukuran')
        ->where('t_pesan_seragam.status', 'success')
        ->groupby('tpsd.produk_id')
        ->orderby('total_quantity', 'desc')
        ->get();

        $total_sales_by_school = OrderSeragam::select('mls.sublokasi', DB::raw('count(tpsd.lokasi_sekolah) as total_item'))
        ->leftJoin('t_pesan_seragam_detail as tpsd', 'tpsd.no_pemesanan', 't_pesan_seragam.no_pemesanan')
        ->leftJoin('mst_lokasi_sub as mls', 'mls.id', 'tpsd.lokasi_sekolah')
        ->where('t_pesan_seragam.status', 'success')
        ->groupby('tpsd.lokasi_sekolah')
        ->orderby('total_item', 'desc')
        ->get();

        return view('admin.laporan.seragam', compact( 'total_pesanan', 'hpp', 'profit', 'sales_per_month', 'total_sales_by_item',
        'total_sales_by_school', 'count_sales_by_item'));
    }

    public function resume_detail()
    {
        $this_month = date('Y-m');

        $total_pesanan = OrderSeragam::select(DB::raw('SUM( (tpsd.harga * tpsd.quantity) - (tpsd.diskon * quantity) ) as grand_total'))
        ->leftJoin('t_pesan_seragam_detail as tpsd', 'tpsd.no_pemesanan', 't_pesan_seragam.no_pemesanan')
        ->where('t_pesan_seragam.status', 'success')
        ->first();

        $hpp = OrderSeragam::select(DB::raw('SUM( (tpsd.hpp * tpsd.quantity) ) as total_hpp'))
        ->leftJoin('t_pesan_seragam_detail as tpsd', 'tpsd.no_pemesanan', 't_pesan_seragam.no_pemesanan')
        ->where('t_pesan_seragam.status', 'success')
        ->first();

        $profit = $total_pesanan->grand_total - $hpp->total_hpp;

        $sales_per_month = OrderSeragam::select(DB::raw('SUM( total_harga ) as sales_month'))
                        ->where('status', 'success')
                        ->where('updated_at', 'LIKE', $this_month.'%')
                        ->first();

        $total_sales_by_item = OrderSeragam::select('mps.nama_produk', 'tpsd.harga', 'tpsd.diskon', 'tpsd.quantity', DB::raw('sum(tpsd.quantity) as total_quantity'))
        ->leftJoin('t_pesan_seragam_detail as tpsd', 'tpsd.no_pemesanan', 't_pesan_seragam.no_pemesanan')
        ->leftJoin('m_produk_seragam as mps', 'mps.id', 'tpsd.produk_id')
        ->where('t_pesan_seragam.status', 'success')
        ->groupby('tpsd.produk_id')
        ->orderby('total_quantity', 'desc')
        ->get();

        $total_sales_by_school = OrderSeragam::select('mls.sublokasi', DB::raw('count(tpsd.lokasi_sekolah) as total_item'))
        ->leftJoin('t_pesan_seragam_detail as tpsd', 'tpsd.no_pemesanan', 't_pesan_seragam.no_pemesanan')
        ->leftJoin('mst_lokasi_sub as mls', 'mls.id', 'tpsd.lokasi_sekolah')
        ->where('t_pesan_seragam.status', 'success')
        ->groupby('tpsd.lokasi_sekolah')
        ->orderby('total_item', 'desc')
        ->get();

        return view('admin.laporan.seragam-all', compact( 'total_pesanan', 'hpp', 'profit', 'sales_per_month', 'total_sales_by_item',
        'total_sales_by_school'));
    }

    function send_notif_new($message,$no_wha){
        $curl = curl_init();
        $token =  config('wablas.token_wablas');
        $secret = config('wablas.secret_wablas');
        $auth = $token.'.'.$secret;
    
        $payload = [
            "data" => [
                [
                    'phone' => $no_wha,
                    'message' => $message,
                    // 'secret' => false, // or true
                    // 'priority' => false,
                    // 'retry' => false, // or true
                    // 'isGroup' => false, // or true
                ],
                
            ]
        ];
    
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array(
                "Authorization: $auth",
                "Content-Type: application/json"
            )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload) );
        curl_setopt($curl, CURLOPT_URL, "https://pati.wablas.com/api/v2/send-message");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);
    
        return ($result);
    }


    function send_notif ($no_wha, $message) {
        $dataSending = array();
        $dataSending["api_key"] = "VDSVRW87NW812KD7";
        $dataSending["number_key"] = "3UgISCw7MC8dDj75";
        $dataSending["phone_no"] = $no_wha;
        $dataSending["message"] = $message;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.watzap.id/v1/send_message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($dataSending),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;

    }

    function send_wishlist($produk_id, $user_id, $quantity, $ukuran, $jenis, $nis, $no_hp, $kode_produk){
	    $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'http://103.135.214.11:81/qlp_system/api_regist/simpan_wishlist.php',
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
		  	'produk_id' => $produk_id,
		  	'user_id' => $user_id,
		  	'quantity' => $quantity,
		  	'ukuran' => $ukuran,
		  	'nis' => $nis,
		  	'jenis' => $jenis,
		  	'kode_produk' => $kode_produk,
		  	'no_hp' => $no_hp
            )

		));

		$response = curl_exec($curl);

		// echo $response;
		curl_close($curl);
	    // return ($response);
	}
    
    function send_wishlist_baru($produk_id, $user_id, $quantity, $ukuran, $jenis, $nis, $no_hp, $kode_produk){
	    $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://system.rabbani.sch.id/api_regist/simpan_wishlist.php',
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
		  	'produk_id' => $produk_id,
		  	'user_id' => $user_id,
		  	'quantity' => $quantity,
		  	'ukuran' => $ukuran,
		  	'nis' => $nis,
		  	'jenis' => $jenis,
		  	'kode_produk' => $kode_produk,
		  	'no_hp' => $no_hp
            )

		));

		$response = curl_exec($curl);

		// echo $response;
		curl_close($curl);
	    // return ($response);
	}

    function send_pesan_seragam($no_pesanan, $nama_pemesan, $no_hp){
	    $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'http://103.135.214.11:81/qlp_system/api_regist/simpan_pesan_seragam.php',
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

    function send_pesan_seragam_baru($no_pesanan, $nama_pemesan, $no_hp){
	    $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://system.rabbani.sch.id/api_regist/simpan_pesan_seragam.php',
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

    function send_pesan_seragam_detail($no_pesanan, $nama_siswa, $lokasi_sekolah, $nama_kelas, $produk_id, $jenis_produk_id, $kode_produk, $ukuran, $quantity, $harga, $diskon, $diskon_persen, $hpp, $ppn){
	    $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'http://103.135.214.11:81/qlp_system/api_regist/simpan_pesan_seragam_detail.php',
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
		  	'produk_id' => $produk_id,
		  	'jenis_produk_id' => $jenis_produk_id,
		  	'kode_produk' => $kode_produk,
		  	'ukuran' => $ukuran,
		  	'quantity' => $quantity,
		  	'harga' => $harga,
		  	'diskon' => $diskon,
		  	'diskon_persen' => $diskon_persen,
		  	'hpp' => $hpp,
		  	'ppn' => $ppn 
            )

		));

		$response = curl_exec($curl);

		// echo $response;
		curl_close($curl);
	    // return ($response);
	}
    
    function send_pesan_seragam_detail_baru($no_pesanan, $nama_siswa, $lokasi_sekolah, $nama_kelas, $produk_id, $jenis_produk_id, $kode_produk, $ukuran, $quantity, $harga, $diskon, $diskon_persen, $hpp, $ppn){
	    $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://system.rabbani.sch.id/api_regist/simpan_pesan_seragam_detail.php',
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
		  	'produk_id' => $produk_id,
		  	'jenis_produk_id' => $jenis_produk_id,
		  	'kode_produk' => $kode_produk,
		  	'ukuran' => $ukuran,
		  	'quantity' => $quantity,
		  	'harga' => $harga,
		  	'diskon' => $diskon,
		  	'diskon_persen' => $diskon_persen,
		  	'hpp' => $hpp,
		  	'ppn' => $ppn 
            )

		));

		$response = curl_exec($curl);

		// echo $response;
		curl_close($curl);
	    // return ($response);
	}

    function update_status_seragam($status, $mtd_pembayaran, $no_pesanan)
    {
        {
            $curl = curl_init();
    
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'http://103.135.214.11:81/qlp_system/api_regist/update_pesan_seragam.php',
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
                'status' => $status,
                'mtd_pembayaran' => $mtd_pembayaran,
                'no_pesanan' => $no_pesanan,
                )
    
            ));
    
            $response = curl_exec($curl);
    
            // echo $response;
            curl_close($curl);
            // return ($response);
        }
    }
    
    function update_status_seragam_baru($status, $mtd_pembayaran, $no_pesanan)
    {
        {
            $curl = curl_init();
    
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://system.rabbani.sch.id/api_regist/update_pesan_seragam.php',
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
                'status' => $status,
                'mtd_pembayaran' => $mtd_pembayaran,
                'no_pesanan' => $no_pesanan,
                )
    
            ));
    
            $response = curl_exec($curl);
    
            // echo $response;
            curl_close($curl);
            // return ($response);
        }
    }

    function update_status_merchandise($status, $mtd_pembayaran, $no_pesanan)
    {
        {
            $curl = curl_init();
    
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'http://103.135.214.11:81/qlp_system/api_regist/update_pesan_merchandise.php',
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
                'status' => $status,
                'mtd_pembayaran' => $mtd_pembayaran,
                'no_pesanan' => $no_pesanan,
                )
    
            ));
    
            $response = curl_exec($curl);
    
            // echo $response;
            curl_close($curl);
            // return ($response);
        }
    }

    function update_status_pendaftaran_siswa($status, $mtd_pembayaran, $id_anak, $orderID)
    {        
        // Inisialisasi cURL
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://103.135.214.11:81/qlp_system/api_regist/update_pembayaran_midtrans.php', // URL API
            CURLOPT_RETURNTRANSFER => 1,  // Mengembalikan hasil dari eksekusi curl
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST', // Menentukan metode HTTP
            CURLOPT_POSTFIELDS => array(
                'status_midtrans' => $status,
                'mtd_pembayaran' => $mtd_pembayaran,
                'id_anak' => $id_anak,
                'order_id' => $$orderID,
            ),
        ));

        // Eksekusi cURL
        $response = curl_exec($curl);

        // Cek jika terjadi kesalahan
        if(curl_errno($curl)) {
            echo 'Curl error: ' . curl_error($curl);
        }

        // Tutup cURL
        curl_close($curl);
    }

    function update_status_merchandise_baru($status, $mtd_pembayaran, $no_pesanan)
    {
        {
            $curl = curl_init();
    
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://system.rabbani.sch.id/api_regist/update_pesan_merchandise.php',
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
                'status' => $status,
                'mtd_pembayaran' => $mtd_pembayaran,
                'no_pesanan' => $no_pesanan,
                )
    
            ));
    
            $response = curl_exec($curl);
    
            // echo $response;
            curl_close($curl);
            // return ($response);
        }
    }

    function update_status_jersey($status, $mtd_pembayaran, $no_pesanan)
    {
        {
            $curl = curl_init();
    
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'http://103.135.214.11:81/qlp_system/api_regist/update_pesan_jersey.php',
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
                'status' => $status,
                'mtd_pembayaran' => $mtd_pembayaran,
                'no_pesanan' => $no_pesanan,
                )
    
            ));
    
            $response = curl_exec($curl);
    
            // echo $response;
            curl_close($curl);
            // return ($response);
        }
    }

    function update_status_jersey_baru($status, $mtd_pembayaran, $no_pesanan)
    {
        {
            $curl = curl_init();
    
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://system.rabbani.sch.id/api_regist/update_pesan_jersey.php',
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
                'status' => $status,
                'mtd_pembayaran' => $mtd_pembayaran,
                'no_pesanan' => $no_pesanan,
                )
    
            ));
    
            $response = curl_exec($curl);
    
            // echo $response;
            curl_close($curl);
            // return ($response);
        }
    }
}
