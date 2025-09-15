<?php

namespace App\Http\Controllers;

use App\Models\Angket;
use App\Models\BiayaSPMB;
use App\Models\ContactPerson;
use App\Models\JenjangSekolah;
use App\Models\Kecamatan;
use App\Models\KelasJenjangSekolah;
use App\Models\Kelurahan;
use App\Models\Kota;
use App\Models\KuesionerAnak;
use App\Models\KuesionerOrtu;
use App\Models\KuotaPPDB;
use App\Models\Lokasi;
use App\Models\LokasiSub;
use App\Models\Pekerjaan;
use App\Models\Pendaftaran;
use App\Models\PendaftaranAyah;
use App\Models\PendaftaranIbu;
use App\Models\PendaftaranWali;
use App\Models\ProgramReg;
use App\Models\Provinsi;
use App\Models\TahunAjaranAktif;
use App\Models\TrialClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\HasilPengasuhan;
use App\Models\HasilPerkembangan;
use App\Models\HeadPengasuhan;
use App\Models\HeadPerkembangan;
use App\Models\PertanyaanPengasuhan;
use App\Models\PertanyaanPerkembangan;
use Carbon\Carbon;

class PendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $contact_person = ContactPerson::where('is_aktif', 1)->get();

        // TODO: UJI COBA TUTUP SEMENTARA HALAMAN PENDAFTARAN
        // $akses = request()->query('akses'); // atau bisa menggunakan request('akses')
        // if ($akses === 'admindopi') {
        //     // Logika jika akses diizinkan
        //     return view('pendaftaran.index', compact('contact_person'));
        // }
        
        // return view('pendaftaran.index-close', compact('contact_person'));
        return view('pendaftaran.index', compact('contact_person'));
        
    }

    public function form_pendaftaran()
    {
        // Pengecekan apakah hari ini tanggal 1 Agustus
        $today = Carbon::today();
        if ($today->month == 8 && $today->day == 1) {
            // Panggil fungsi updateStatusTampil hanya jika hari ini tanggal 1 Agustus
            TahunAjaranAktif::updateStatusTampil();
        }
         // Mendapatkan Tahun Ajaran Terbaru berdasarkan tanggal mulai
        $ppdb_now = TahunAjaranAktif::where('status', 1)
                                    ->where('status_tampil', 1)
                                    ->orderBy('mulai', 'desc')  // Mengurutkan berdasarkan tanggal mulai, yang terbaru dulu
                                    ->select('id')
                                    ->first();  // Mengambil satu record pertama (yang terbaru)
        $ppdb_now_id = $ppdb_now->id;
        // dd($ppdb_now_id);

        $lokasi = Lokasi::where('status', 1)->get();
        $jenjang_per_sekolah = JenjangSekolah::all();
        $tahun_ajaran = TahunAjaranAktif::where('status', 1)->where('status_tampil', 1)->orderBy('id', 'asc')->get();
        // dd('bisa');
        // dd($tahun_ajaran);
        $akses = request()->query('akses'); // atau bisa menggunakan request('akses')
        // if ($akses === 'admindopi') {
        //     // Logika jika akses diizinkan
        //     return view('pendaftaran.tk-sd.formulir', compact('lokasi', 'jenjang_per_sekolah', 'tahun_ajaran', 'ppdb_now_id'));
        // }

        // return view('pendaftaran.index-close');
        return view('pendaftaran.tk-sd.formulir', compact('lokasi', 'jenjang_per_sekolah', 'tahun_ajaran', 'ppdb_now_id'));
    }

    public function get_jenjang(Request $request) {

        $data['jenjang'] = JenjangSekolah::get_jenjang($request->id_lokasi);

        return response()->json($data);

    }

    public function get_jenjang_trial(Request $request) {

        $lokasi = $request->id_lokasi;

        $tahun_ajaran_aktif = TahunAjaranAktif::where('status_tampil', 1)->orderby('id', 'desc')->first();
        $tahun_ajaran = $tahun_ajaran_aktif->id;

        // $cek_kuota = KuotaPPDB::where('id_tahun_ajaran', $tahun_ajaran)->where('lokasi', $lokasi)->get();
        $cek_kuota =  JenjangSekolah::select('mj.value', 'mj.nama_jenjang', 'k.tingkat', 'k.kuota', 'k.siswa_lama',  DB::raw('(k.kuota - k.siswa_lama) as sisa_kuota'))
                                    ->leftJoin('m_jenjang as mj', 'mj.id', 'm_jenjang_per_sekolah.jenjang_id')
                                     ->leftJoin('tbl_kuota_psb as k', function($join)
                                    { $join->on('k.lokasi', '=', 'm_jenjang_per_sekolah.kode_sekolah') 
                                        ->on('k.jenjang', '=', 'mj.value'); 
                                    })
                                    ->where('k.id_tahun_ajaran', $tahun_ajaran)
                                    ->where('kode_sekolah', $lokasi)
                                    ->get();

        $result = [];
        foreach ($cek_kuota as $item) {
            $kuota = $item->sisa_kuota;
            $jenjang = $item->value;
            $tingkat = $item->tingkat;
 
            $count_pendaftar = Pendaftaran::where('tahun_ajaran', $tahun_ajaran)->where('lokasi', $lokasi)
                                        ->where('tingkat', $tingkat)->where('jenjang', $jenjang)
                                        ->where('status_pembayaran', 1)
                                        ->where('status_daftar', '!=', 5)
                                        ->count();
                                        

            if ($count_pendaftar < $kuota) {

                $result[] = [
                    'jenjang' => $jenjang,
                    'nama_jenjang' => $item->nama_jenjang,
                    'tingkat' => $tingkat,
                    'kuota' => $kuota,
                    'pendaftar' => $count_pendaftar
                ];

            }   
        }
        return response()->json([
               'message' => 'sukses',
               'data' => $result
           ]);      

    }

    public function get_kelas(Request $request) {

        $data['kelas'] = KelasJenjangSekolah::get_kelas_jenjang($request->id_lokasi, $request->id_jenjang);

        return response()->json($data);
    }

    public function get_kelas_smp(Request $request) {

        $data['kelas_smp'] = KelasJenjangSekolah::get_kelas_smp($request->id_lokasi);

        return response()->json($data);
    }

    public function get_kota(Request $request) {

        $data['kota'] = Kota::where('provinsi_id', $request->id_provinsi)->get();

        return response()->json($data);
    }

    public function get_kecamatan(Request $request) {

        $data['kecamatan'] = Kecamatan::where('kabkot_id', $request->id_kota)->get();

        return response()->json($data);
    }

    public function get_kelurahan(Request $request) {

        $data['kelurahan'] = Kelurahan::where('kecamatan_id', $request->id_kecamatan)->get();

        return response()->json($data);
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
        $request->validate([
            'nama' => 'required',
            'lokasi' => 'required',
            'no_hp_ayah' => 'required|alpha_num',
            'no_hp_ibu' => 'required'   
        ], [
            'nama.required' => 'Name is required',
            'no_hp_ayah.required' => 'No Whatsapp Ayah is required',
            'no_hp_ibu.required' => 'No Whatsapp Ibu is required',
            'no_hp_ayah.alpha_num' => 'No Whatsapp Hanya Nomor saja, tanpa special character seperti + , -',
            'no_hp_ibu.alpha_num' => 'No Whatsapp Hanya Nomor saja, tanpa special character seperti + , -',
        ]);

        $jenjang = $request->jenjang;
        if ($request->lokasi == 'UBR') {
            $tingkat = 'SMP';
            $jenjang = 5;
        }

        if ($request->jenjang == '1' || $request->jenjang == '3') {
            $tingkat = $request->kelas;
        } else if ($request->jenjang == '4') {
            $tingkat = 'SD';
        }

        if ($request->radios == 'lainnya') {
            $sumber_ppdb = $request->radios2;
        } else if ($request->radios == null || $request->radios == '') {
            $sumber_ppdb = 'spanduk/baliho';
        } else {
            $sumber_ppdb = $request->radios;
        }

        $info_apakah_abk = $request->abk_radios;
        $lokasi = $request->lokasi;
        $nama_lengkap = $request->nama;
        $kelas = $request->kelas;
        $jenis_kelamin = $request->jenis_kelamin;
        $tempat_lahir = $request->tempat_lahir;
        $tgl_lahir = $request->tgl_lahir;
        $nama_ayah = $request->nama_ayah;
        $nama_ibu = $request->nama_ibu;
        $no_hp_ayah = $request->no_hp_ayah;
        $no_hp_ibu = $request->no_hp_ibu;
        $jenis_pendidikan = $request->jenis_pendidikan;
        $tahun_ajaran = $request->tahun_ajaran;
        $asal_sekolah = $request->asal_sekolah;
        $now = date('YmdHis');
        $id_anak = "PPDB-$tingkat-$lokasi-$now";
        $is_pindahan = $request->is_pindahan;

        // cek kuota
        $cek_kuota = KuotaPPDB::where('id_tahun_ajaran', $tahun_ajaran)
                            ->where('lokasi', $lokasi)
                            ->where('tingkat', $tingkat)
                            ->where('jenjang', $jenjang)
                            ->first();

        // Cek jika $cek_kuota tidak null
        if ($cek_kuota) {
            $kuota = $cek_kuota->kuota;
        } else {
            // Tangani jika $cek_kuota adalah null (misalnya dengan memberi nilai default)
            $kuota = 0; // atau nilai default lainnya sesuai kebutuhan
        }

        $count_pendaftar = Pendaftaran::where('tahun_ajaran', $tahun_ajaran)
                                ->where('lokasi', $lokasi)
                                ->where('tingkat', $tingkat)
                                ->where('jenjang', $jenjang)
                                ->where('status_pembayaran', 1)
                                ->where('status_daftar', '!=', 5)
                                ->count();

        if ($kelas == 1 || $kelas == 7 || $kelas == 'tka' || $kelas == 'tkb' || $kelas == 'kober') {
            if ($kuota > $count_pendaftar) {
                $status_daftar = 2;
            } else {
                $status_daftar = 3;
            }
        } else {
            $status_daftar = 2;
        }
        
        // // TODO: BUAT TESTING
        // $status_daftar = 3;

        // Logika untuk memeriksa kuota, pendaftar, dll.
        if ($status_daftar == 3) {
            $lokasi = Lokasi::where('kode_sekolah', $lokasi)->first();
            $lokasi = $lokasi->nama_sekolah;
            $contact_ccrs =  ContactPerson::where('id', '16')->first();
            $contact_ccrs =  $contact_ccrs->telp; 
            session()->flash('status_daftar', 3);
            session()->flash('lokasi', $lokasi);  // Menyimpan lokasi di session
            session()->flash('no_ccrs', $contact_ccrs);  // Menyimpan lokasi di session
            return redirect()->back();
        }

        // simpan ke tbl_anak
        $pendaftaran_data = Pendaftaran::create([
            'id_anak' => $id_anak,
            'nama_lengkap' => $nama_lengkap,
            'tempat_lahir' => $tempat_lahir,
            'tgl_lahir' => $tgl_lahir,
            'jenis_kelamin' => $jenis_kelamin,
            'lokasi' => $lokasi,
            'jenjang' => $jenjang,
            'tingkat' => $tingkat,
            'kelas' => $kelas,
            'no_hp_ayah' => $no_hp_ayah,
            'no_hp_ibu' => $no_hp_ibu,
            'info_ppdb' => $sumber_ppdb,
            'info_apakah_abk' => $info_apakah_abk,
            'jenis_pendidikan' => $jenis_pendidikan,
            'tahun_ajaran' => $tahun_ajaran,
            'is_pindahan' => $is_pindahan,
            'asal_sekolah' => $asal_sekolah,
            'status_daftar' => $status_daftar
        ]);

        PendaftaranAyah::create([
            'id_ayah' => $id_anak,
            'nama' => $nama_ayah,
        ]);

        PendaftaranIbu::create([
            'id_ibu' => $id_anak,
            'nama' => $nama_ibu,
        ]);

        PendaftaranWali::create([
            'id_wali' => $id_anak,
        ]);

        Angket::create([
            'id_anak' => $id_anak
        ]);

        ProgramReg::create([
            'id_anak' => $id_anak
        ]);

        
        

        $contact_person =  ContactPerson::where('is_aktif', '1')->where('kode_sekolah', $lokasi)->where('id_jenjang', $jenjang)->first();
        $no_admin = $contact_person->telp;
        $no_rek = $contact_person->norek;
        $nama_rek = $contact_person->nama_rek;

        $pendaftaran_data = Pendaftaran::where('id_anak', $id_anak)->firstOrFail();
        $telp_id = ContactPerson::where('is_aktif', '1')
            ->where('kode_sekolah', $pendaftaran_data->lokasi)
            ->where('id_jenjang', $pendaftaran_data->jenjang)
            ->first()->id;
        $ajaran_id = TahunAjaranAktif::where('id', $pendaftaran_data->tahun_ajaran)->first()->id;
        $biaya = BiayaSPMB::where('tahun_ajaran_id', $ajaran_id)
                ->where('telp_id', $telp_id)
                ->first()->biaya;

        // send ke qlp
        // $this->send_pendaftaran($id_anak, $nama_lengkap, $jenis_kelamin, $tempat_lahir, $tgl_lahir, $lokasi, $kelas, $jenjang, $tingkat, $no_hp_ayah, $no_hp_ibu, $nama_ayah, $nama_ibu, $sumber_ppdb, $tahun_ajaran, $asal_sekolah, $status_daftar, $is_pindahan, $info_apakah_abk);
        $this->send_pendaftaran_baru($id_anak, $nama_lengkap, $jenis_kelamin, $tempat_lahir, $tgl_lahir, $lokasi, $kelas, $jenjang, $tingkat, $no_hp_ayah, $no_hp_ibu, $nama_ayah, $nama_ibu, $sumber_ppdb, $tahun_ajaran, $asal_sekolah, $status_daftar, $is_pindahan, $info_apakah_abk);

        //send notif ke ortu
        $message_ortu = "
Terimakasih *Ayah/Bunda $nama_lengkap* telah mendaftarkan Ananda ke Sekolah Rabbani 🏫 
📌 No. Registrasi / Pendaftaran: *$id_anak*
Mohon disimpan untuk keperluan pemenuhan data.

💳 Silakan melakukan pembayaran biaya pendaftaran sebesar *Rp ".number_format($biaya)."* _(Belum termasuk biaya admin)_
Melalui Laman Pembayaran berikut:
https://sekolahrabbani.sch.id/pendaftaran/histori/detail?no_registrasi=$id_anak

Setelah pembayaran dilakukan, status pendaftaran Ananda akan otomatis tercatat di sistem kami dan akan dilanjutkan ke tahap berikutnya.

📞 Untuk pertanyaan lebih lanjut, silakan hubungi Customer Service kami di ".$no_admin.".
Terima kasih atas kepercayaan Ayah/Bunda kepada Sekolah Rabbani 🌟
Kami akan segera menginformasikan proses selanjutnya.

Balas *Ya* jika data berikut benar, dan silakan mengakses link pembayaran

*Hormat kami*,
Sekolah Rabbani ✨
    ";

        $message_waiting_list = "
Terimakasih *Ayah/Bunda $nama_lengkap* telah mendaftarkan Ananda ke Sekolah Rabbani 🏫 
📌 No. Registrasi / Pendaftaran: *$id_anak*
Mohon disimpan untuk keperluan pemenuhan data.

💳 Silakan melakukan pembayaran biaya pendaftaran sebesar *Rp ".number_format($biaya)."* _(Belum termasuk biaya admin)_
Melalui Laman Pembayaran berikut:
https://sekolahrabbani.sch.id/pendaftaran/histori/detail?no_registrasi=$id_anak

Setelah pembayaran dilakukan, status pendaftaran Ananda akan otomatis tercatat di sistem kami dan akan dilanjutkan ke tahap berikutnya.

📞 Untuk pertanyaan lebih lanjut, silakan hubungi Customer Service kami di ".$no_admin.".
Terima kasih atas kepercayaan Ayah/Bunda kepada Sekolah Rabbani 🌟
Kami akan segera menginformasikan proses selanjutnya.

Balas *Ya* jika data berikut benar, dan silakan mengakses link pembayaran

*Hormat kami*,
Sekolah Rabbani ✨
    ";

    if ($status_daftar == 3) {
        $this->send_notif($message_waiting_list, $no_hp_ayah);
        $this->send_notif($message_waiting_list, $no_hp_ibu);
    } else {
        $this->send_notif($message_ortu, $no_hp_ayah);
        $this->send_notif($message_ortu, $no_hp_ibu);
    }

    // Redirect ke histori detail dengan no_registrasi = $id_anak
    return redirect()->route('form.histori.detail', ['no_registrasi' => $id_anak])
        ->with('success', 'Pendaftaran Berhasil.');
       
    }

    public function clearSessionForm(Request $request)
    {
        $request->session()->forget('status_daftar');
        $request->session()->forget('lokasi');
        return response()->json(['message' => 'Session cleared'], 200);
    }

    public function storePembayaran(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id_anak' => 'required',
                'payment_method' => 'required|in:other_qris,qris,gopay,shopeepay,bca_va,bni_va,bri_va,mandiri_va,echannel,cimb_va,permata_va',
                'admin_id' => 'required|in:qris,va,deeplink',
            ]);

            $idAnak = $request->id_anak;
            $paymentMethod = $request->payment_method;
            $adminId = $request->admin_id;

            $pendaftaran_data = Pendaftaran::where('id_anak', $idAnak)->firstOrFail();
            $telp_id = ContactPerson::where('is_aktif', '1')
                ->where('kode_sekolah', $pendaftaran_data->lokasi)
                ->where('id_jenjang', $pendaftaran_data->jenjang)
                ->first()->id;
            $ajaran_id = TahunAjaranAktif::where('id', $pendaftaran_data->tahun_ajaran)->first()->id;
            $biaya = BiayaSPMB::where('tahun_ajaran_id', $ajaran_id)
                    ->where('telp_id', $telp_id)
                    ->first()->biaya;

            if ($adminId == 'qris') {
                $totalAmount = $biaya + (($biaya/0.993)* 0.007);
            } elseif ($adminId == 'va') {
                $totalAmount = $biaya + 4000 + (4000 * 0.11);
            } elseif ($adminId == 'deeplink') {
                $totalAmount = $biaya + ($biaya * 0.02);
            } else if ($biaya == 0){
                return response()->json(['failed' => 'Terjadi kesalahan pada nominal pembayaran'], 400);
            } else {
                return response()->json(['failed' => 'Jenis pembayaran Tidak ditemukan'], 400);
            }

            
            // // TODO: UNTUK TESTING AJA
            // $totalAmount = 100;

            \Midtrans\Config::$serverKey = config('midtrans.serverKey');
            \Midtrans\Config::$isProduction = config('midtrans.isProduction');
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $order_id = $idAnak . '-' . time();
            $paymentMethods = [$paymentMethod];

            if ($paymentMethod == 'other_qris') {
                $paymentMethod = 'qris';
            } else if ($paymentMethod == 'echannel') {
                $paymentMethod = 'mandiri_va';
            } else {
                $paymentMethod = $paymentMethod;
            }

            // return response()->json(['failed' => 'Terjadi kesalahan: ' . $paymentMethod], 400);

            $params = [
                'transaction_details' => [
                    'order_id' => $order_id,
                    'gross_amount' => $totalAmount,
                ],
                'enabled_payments' => $paymentMethods,
                'customer_details' => [
                    'first_name' => $pendaftaran_data->nama_lengkap,
                    'phone' => $pendaftaran_data->no_hp_ibu,
                ]
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            Pendaftaran::where('id_anak', $idAnak)->update([
                'order_id' => $order_id,
                'snap_token' => $snapToken,
                'metode_pembayaran' => $paymentMethod,
                'status_midtrans' => 'pending',
                'total_harga' => $totalAmount,
            ]);

            return response()->json(['snap_token' => $snapToken], 200);
        } catch (\Exception $e) {
            Log::error('Error in storePembayaran: ' . $e->getMessage());
            return response()->json(['failed' => 'Terjadi kesalahan: ' . $e->getMessage()], 400);
        }
    }

    private function createNewMidtransOrder(string $no_registrasi, $data_pendaftaran, int $biaya): void
    {
        // order_id sederhana: idAnak + timestamp
        $order_id = $no_registrasi . '-' . time();

        $custName  = trim(($data_pendaftaran->nama_lengkap ?? '') ?: ($data_pendaftaran->nama_anak ?? 'Calon Siswa'));
        $custEmail = $data_pendaftaran->email ?? 'no-reply@example.com';
        $custPhone = $data_pendaftaran->no_telepon ?? '081234567890';

        $params = [
            'transaction_details' => [
                'order_id'     => $order_id,
                'gross_amount' => max(1, (int) $biaya), // gross_amount tidak boleh 0
            ],
            'enabled_payments' => ['bca_va','bni_va','bri_va','mandiri_va','echannel','cimb_va','permata_va'],
            'customer_details' => [
                'first_name' => $custName,
                'email'      => $custEmail,
                'phone'      => $custPhone,
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            Pendaftaran::where('id_anak', $no_registrasi)->update([
                'order_id'    => $order_id,
                'snap_token'  => $snapToken,
                'expire_time' => now()->addHours(24), // contoh expire 24 jam
                'total_harga' => (int) $biaya,
            ]);
        } catch (\Throwable $e) {
            report($e);
            Pendaftaran::where('id_anak', $no_registrasi)->update([
                'order_id'    => null,
                'snap_token'  => null,
                'expire_time' => null,
                'total_harga' => 0,
            ]);
        }
    }



    
    public function cekStatusPembayaran(Request $request)
    {
        $id_anak = $request->input('id_anak');
        $pendaftaran = Pendaftaran::where('id_anak', $id_anak)->first();

        if ($pendaftaran) {
            return response()->json([
                'status_midtrans' => $pendaftaran->status_midtrans ?? 'pending'
            ]);
        }

        return response()->json(['error' => 'Data not found'], 404);
    }

    public function histori_detail(Request $request)
    {
        $no_registrasi = $request->no_registrasi ?? null;

        // Midtrans config
        \Midtrans\Config::$serverKey   = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = (bool) config('midtrans.isProduction', false);
        \Midtrans\Config::$isSanitized  = true;
        \Midtrans\Config::$is3ds        = true;

        // Ambil profil dasar
        $data_pendaftaran = Pendaftaran::get_profile($no_registrasi);
        $get_profile_ibu  = PendaftaranIbu::get_profile($no_registrasi);
        $get_profile_ayah = PendaftaranAyah::get_profile($no_registrasi);

        // Default lokasi & biaya
        $lokasi = 'Tidak ditemukan';
        $biaya  = 0;

        if ($data_pendaftaran) {
            // Hitung/ambil biaya & lokasi
            try {
                $telp_id   = optional(
                    ContactPerson::where('is_aktif', '1')
                        ->where('kode_sekolah', $data_pendaftaran->lokasi)
                        ->where('id_jenjang', $data_pendaftaran->jenjang)
                        ->first()
                )->id;

                $ajaran_id = optional(
                    TahunAjaranAktif::where('id', $data_pendaftaran->tahun_ajaran)->first()
                )->id;

                $biayaAwal = BiayaSPMB::where('tahun_ajaran_id', $ajaran_id)
                    ->where('telp_id', $telp_id)
                    ->first()->biaya;
                
                
                $biaya = $biayaAwal + 4000 + (4000 * 0.11);

                $lokasiModel = Lokasi::where('kode_sekolah', $data_pendaftaran->lokasi)->first();
                $lokasi = $lokasiModel ? $lokasiModel->nama_sekolah : 'Tidak ditemukan';
            } catch (\Throwable $e) {
                $lokasi = 'Tidak ditemukan';
                $biaya  = 0;
            }

            // ——— LANGKAH INTI: cek status transaksi yang sudah ada ———
            if (!empty($data_pendaftaran->order_id)) {
                try {
                    $status = \Midtrans\Transaction::status($data_pendaftaran->order_id);

                    // Jika sukses, update expiry & total_harga
                    $expiryTime  = $status->expiry_time ?? null;
                    $total_harga = isset($status->gross_amount) ? (int) $status->gross_amount : 0;

                    Pendaftaran::where('id_anak', $no_registrasi)->update([
                        'expire_time' => $expiryTime,
                        'total_harga' => $total_harga,
                    ]);
                } catch (\Throwable $e) {
                    // Deteksi 404: "Transaction doesn't exist."
                    $msg = $e->getMessage();
                    $is404 = str_contains($msg, '404') || str_contains($msg, "Transaction doesn't exist");

                    if ($is404) {
                        // 1) Bersihkan jejak lama
                        Pendaftaran::where('id_anak', $no_registrasi)->update([
                            'order_id'    => null,
                            'snap_token'  => null,
                            'expire_time' => null,
                            'total_harga' => 0,
                        ]);

                        // 2) Generate order baru + Snap token baru
                        $this->createNewMidtransOrder($no_registrasi, $data_pendaftaran, $biaya);
                    } else {
                        // Error lain: biarkan tampil tanpa memutus alur halaman
                        report($e);
                    }
                }
            } else {
                // Tidak ada order_id sama sekali → buat baru
                $this->createNewMidtransOrder($no_registrasi, $data_pendaftaran, $biaya);
            }
        }

        // Refresh data untuk view
        $data_pendaftaran = Pendaftaran::where('id_anak', $no_registrasi)->first();

        return view('pendaftaran.histori-detail',
            compact('data_pendaftaran','no_registrasi','get_profile_ibu','get_profile_ayah','lokasi','biaya')
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pendaftaran  $pendaftaran
     * @return \Illuminate\Http\Response
     */
    public function show(Pendaftaran $pendaftaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pendaftaran  $pendaftaran
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Pendaftaran $pendaftaran)
    {
        $no_registrasi = $request->no_registrasi ?? null;
        $get_profile = Pendaftaran::get_profile($no_registrasi);

        $provinsi = Provinsi::all();
        $kecamatan_asal_sekolah = Kecamatan::kecamatan_with_kota();

        $list_pekerjaan_ayah = Pekerjaan::whereNotIn('id', [6,7,10])->get();
        $list_pekerjaan_ibu = Pekerjaan::whereNotIn('id', [6,7])->get();

        if ($get_profile != null) {
            $kota = Kota::where('provinsi_id', $get_profile->provinsi)->get();
            $kecamatan = Kecamatan::where('kabkot_id', $get_profile->kota)->get();
            $kelurahan = Kelurahan::where('kecamatan_id', $get_profile->kecamatan)->get();
        } else {
            $kota = Kota::all();
            $kecamatan = Kecamatan::all();
            $kelurahan = Kelurahan::all();
        }

        // $id = $request->no_registrasi;

        if ($request->has('no_registrasi')) {
            $get_profile = Pendaftaran::get_profile($no_registrasi);
            $get_profile_ibu = PendaftaranIbu::get_profile($no_registrasi);
            $get_profile_ayah = PendaftaranAyah::get_profile($no_registrasi);
            $get_profile_wali = PendaftaranWali::get_profile($no_registrasi);
            
        }
        

        $get_profile_ibu = PendaftaranIbu::get_profile($no_registrasi);
        $get_profile_ayah = PendaftaranAyah::get_profile($no_registrasi);
        $get_profile_wali = PendaftaranWali::get_profile($no_registrasi);
        // dd($get_kuesioner_ortu);

        if ($get_profile) {
            $tingkat = strtolower($get_profile->tingkat);
            $is_lunas = $get_profile->status_pembayaran;
        } else {
            $tingkat = null;
            $is_lunas = null;
        }

        if (($tingkat == 'kober' || $tingkat == 'tka' || $tingkat == 'tkb')) {
             $jenjang = 'kober_tk';
        } else {
            $jenjang = $tingkat;
        }
        
        $head_perkembangan = HeadPerkembangan::where('is_aktif', 1)->where('jenjang',$jenjang)->get();
        $pertanyaan_perkembangan = PertanyaanPerkembangan::where('is_aktif', 1)->get();
        
        $head_pengasuhan = HeadPengasuhan::where('is_aktif', 1)->where('jenjang',$jenjang)->get();
        $pertanyaan_pengasuhan = PertanyaanPengasuhan::where('is_aktif', 1)->get();
        
        
        $jawaban_perkembangan_raw = HasilPerkembangan::where('id_anak', $no_registrasi)->get(); 
        $jawaban_pengasuhan_raw = HasilPengasuhan::where('id_anak', $no_registrasi)->get();
        // Menyimpan jawaban pertanyaan dalam format yang diinginkan
        $jawaban_perkembangan = [];
        $jawaban_pengasuhan = [];

        foreach ($jawaban_perkembangan_raw as $key => $value) {
            // Decode JSON jawaban dari database
            $decoded_answer = json_decode($value->jawaban, true);
            
            // Pastikan data terstruktur dengan format yang diinginkan
            $id_pertanyaan = $value->id_pertanyaan; // Ambil ID pertanyaan dari database

            $kode_perkembangan = PertanyaanPerkembangan::where('id', $id_pertanyaan)->first();
            $kode_perkembangan = $kode_perkembangan->kode_perkembangan;
            
            // Menyusun ulang format jawaban
            $jawaban_perkembangan[$id_pertanyaan] = [
                'id_pertanyaan' => $id_pertanyaan,
                'kode_perkembangan' => $kode_perkembangan,
                'option_field' => isset($decoded_answer['option_field']) ? $decoded_answer['option_field'] : '_',
                'option_default' => isset($decoded_answer['option_default']) ? $decoded_answer['option_default'] : '_',
                'input_field' => isset($decoded_answer['input_field']) ? $decoded_answer['input_field'] : '_',
            ];
        }
        
        foreach ($jawaban_pengasuhan_raw as $key => $value) {
            // Decode JSON jawaban dari database
            $decoded_answer = json_decode($value->jawaban, true);
            
            // Pastikan data terstruktur dengan format yang diinginkan
            $id_pertanyaan = $value->id_pertanyaan; // Ambil ID pertanyaan dari database
            
            // Menyusun ulang format jawaban
            $jawaban_pengasuhan[$id_pertanyaan] = [
                'id_pertanyaan' => $id_pertanyaan,
                'option_field' => isset($decoded_answer['option_field']) ? $decoded_answer['option_field'] : '_',
                'option_default' => isset($decoded_answer['option_default']) ? $decoded_answer['option_default'] : '_',
                'input_field' => isset($decoded_answer['input_field']) ? $decoded_answer['input_field'] : '_',
            ];
        }
        // dd($jawaban_perkembangan, $jawaban_pengasuhan); 


        return view('pendaftaran.tk-sd.pemenuhan-data', compact('provinsi', 'kecamatan', 'kecamatan_asal_sekolah', 'kelurahan', 'kota', 
        'get_profile',  'get_profile_ibu',  'get_profile_ayah', 'get_profile_wali', 'no_registrasi', 'list_pekerjaan_ayah', 'list_pekerjaan_ibu', 
        'head_perkembangan', 'pertanyaan_perkembangan','head_pengasuhan', 'pertanyaan_pengasuhan', 'jawaban_perkembangan', 'jawaban_pengasuhan', 'is_lunas'));
    }

    public function find(Request $request, Pendaftaran $pendaftaran)
    {
        // $id = $request->no_registrasi;
        $no_registrasi = $request->no_registrasi ?? null;

        if ($request->has('no_registrasi')) {
            $get_profile = Pendaftaran::get_profile($no_registrasi);
            $get_profile_ibu = PendaftaranIbu::get_profile($no_registrasi);
            $get_profile_ayah = PendaftaranAyah::get_profile($no_registrasi);
            $get_profile_wali = PendaftaranWali::get_profile($no_registrasi);
        }
        
        $get_profile = Pendaftaran::get_profile($no_registrasi);
        $get_profile_ibu = PendaftaranIbu::get_profile($no_registrasi);
        $get_profile_ayah = PendaftaranAyah::get_profile($no_registrasi);
        $get_profile_wali = PendaftaranWali::get_profile($no_registrasi);
        // dd($get_profile);


        return view('pendaftaran.tk-sd.find-noregis', compact('get_profile',  'get_profile_ibu',  'get_profile_ayah', 'get_profile_wali'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pendaftaran  $pendaftaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            // Ambil semua data dari request
        $data = $request->all();

        // Kelompokkan data ke dalam array $data_anak
        $data_anak = [
            'nama_lengkap' => $data['nama_lengkap'],
            'nama_panggilan' => $data['nama_panggilan'],
            'no_nik' => $data['nik'],
            'alamat' => $data['alamat'],
            'provinsi' => $data['provinsi'],
            'kota' => $data['kota'],
            'kecamatan' => $data['kecamatan'],
            'kelurahan' => $data['kelurahan'],
            'status_tinggal' => $data['status_tinggal'],
            'anak_ke' => $data['anak_ke'],
            'jml_sdr' => $data['jumlah_saudara'],
            'tinggi_badan' => $data['tinggi_badan'],
            'berat_badan' => $data['berat_badan'],
            'bahasa' => $data['bhs_digunakan'],
            'asal_sekolah' => isset($data['asal_sekolah']) && !empty($data['asal_sekolah']) ? $data['asal_sekolah'] : '-',
            'npsn' => isset($data['npsn']) && !empty($data['npsn']) ? $data['npsn'] : '-',
            'kec_asal_sekolah' => isset($data['kec_asal_sekolah']) && !empty($data['kec_asal_sekolah']) ? $data['kec_asal_sekolah'] : '-',
            'agama' => $data['agama'],
            'gol_darah' => $data['gol_darah'],
            'hafalan' => $data['hafalan'],
            'riwayat_penyakit' => isset($data['riwayat_penyakit']) && !empty($data['riwayat_penyakit']) ? $data['riwayat_penyakit'] : '-',
            'info_apakah_abk' => $data['info_apakah_abk'],
            
            // Menggabungkan array menjadi string dengan pemisah ;
            'info_detail_saudara' => isset($data['info_detail_saudara']) ? implode(';', $data['info_detail_saudara']) : '',
            'info_detail_tempat' => isset($data['info_detail_tempat']) ? implode(';', $data['info_detail_tempat']) : '',
            'info_detail_khusus' => isset($data['info_detail_khusus']) ? implode(';', $data['info_detail_khusus']) : '',
        ];

        // Kelompokkan data ibu ke dalam $data_ibu
        $data_ibu = [
            'nama' => $data['nama_ibu'],
            'email_ibu' => $data['email_ibu'],
            'tptlahir_ibu' => $data['tempat_lahir_ibu'],
            'tgllahir_ibu' => $data['tgl_lahir_ibu'],
            'pekerjaan_jabatan' => $data['pekerjaan_ibu'],
            'penghasilan' => $data['penghasilan_ibu'],
            'pendidikan_ibu' => $data['pendidikan_ibu'],
            'tahun_nikah_ibu' => $data['tahun_nikah_ibu'],
            'pernikahan_ke_ibu' => $data['pernikahan_ke_ibu'],
        ];
        
        // Kelompokkan data ibu ke dalam $data_ayah
        $data_ayah = [
            'nama' => $data['nama_ayah'],
            'email_ayah' => $data['email_ayah'],
            'tptlahir_ayah' => $data['tempat_lahir_ayah'],
            'tgllahir_ayah' => $data['tgl_lahir_ayah'],
            'pekerjaan_jabatan' => $data['pekerjaan_ayah'],
            'penghasilan' => $data['penghasilan_ayah'],
            'pendidikan_ayah' => $data['pendidikan_ayah'],
            'tahun_nikah_ayah' => $data['tahun_nikah_ayah'],
            'pernikahan_ke_ayah' => $data['pernikahan_ke_ayah'],
        ];
        
        // Kelompokkan data ibu ke dalam $data_wali
        $data_wali = [
            'nama' => $data['nama_wali'],
            'tptlahir_wali' => $data['tempat_lahir_wali'],
            'tgllahir_wali' => $data['tgl_lahir_wali'],
            'pekerjaan_jabatan' => $data['pekerjaan_wali'],
            'pendidikan_wali' => $data['pendidikan_wali'],
            'hubungan_wali' => $data['hubungan_wali'],
        ];

        // PERTANYAAN PERKEMBANGAN DAN PENGASUHAN
        // Inisialisasi array untuk menyimpan data yang dikelompokkan
        $grouped_data = [
            'perkembangan' => [],
            'pengasuhan' => [],
        ];

        foreach ($data as $key => $value) {
            // Cek apakah key mengandung tipe 'pertanyaan' atau 'pengasuhan'
            if (strpos($key, 'pertanyaan') === 0 || strpos($key, 'pengasuhan') === 0) {
                // Extract head_id dan question_id dari key 'pertanyaan_9_50'
                if (preg_match('/^(pertanyaan|pengasuhan)_(\d+)_(\d+)$/', $key, $matches)) {
                    $type = $matches[1];  // Tipe (pertanyaan atau pengasuhan)
                    $head_id = $matches[2]; // Head ID (misalnya 9, 10, 11)
                    $question_id = $matches[3]; // Question ID (misalnya 50, 51, 52)

                    // Ambil PertanyaanPengasuhan Berdasarkan Head ID dan Question ID
                    // Ambil data berdasarkan tipe (pertanyaan atau pengasuhan)
                    if ($type == 'pertanyaan') {
                        // Jika tipe adalah 'pertanyaan', ambil dari model PertanyaanPerkembangan
                        $pertanyaan = PertanyaanPerkembangan::where('head_id', $head_id)
                                                            ->where('id', $question_id)
                                                            ->first();
                    } elseif ($type == 'pengasuhan') {
                        // Jika tipe adalah 'pengasuhan', ambil dari model PertanyaanPengasuhan
                        $pertanyaan = PertanyaanPengasuhan::where('head_id', $head_id)
                                                            ->where('id', $question_id)
                                                            ->first();
                    }

                    if ($pertanyaan) {
                        $answer = [
                            'option_field' => '_',
                            'option_default' => '_',
                            'input_field' => $value,
                        ];

                        // Cek jika pertanyaan memiliki opsi (need_option)
                        if ($pertanyaan->need_option) {
                            if ($value === 'self_fill') {
                                if ($type == 'pertanyaan') {
                                    $option_key = $type.'_'.$head_id.'_'. $question_id.'_self_fill';
                                } else {
                                    $option_key = $type.'_'.$head_id.'_'. $question_id.'_self_fill_pengasuhan';
                                }
                                if (isset($data[$option_key])) {
                                    $answer['option_field'] = $data[$option_key];  // Set nilai sesuai request
                                    $answer['option_default'] = $pertanyaan->options_data;  // Ambil data opsi
                                    $answer['input_field'] = '_';  // Set input field sebagai _
                                } 
                            } else {
                                $answer['option_field'] = $value;  // Set nilai sesuai request
                                $answer['option_default'] = $pertanyaan->options_data;  // Ambil data opsi
                                $answer['input_field'] = '_';  // Set input field sebagai _
                            }
                        }

                        // Cek jika pertanyaan membutuhkan extra (need_extra)
                        if ($pertanyaan->need_extra) {
                            // Ambil data dari request untuk pertanyaan dan extra
                            $extra_key = $type . '_extra_' .$head_id.'_'. $question_id;
                            if (isset($data[$extra_key])) {
                                $answer['option_field'] = $value;
                                $answer['option_default'] = $pertanyaan->options_data;
                                $answer['input_field'] = $data[$extra_key];
                            }
                        }
                        
                        if ($type == 'pertanyaan') $type = 'perkembangan';
                        $grouped_data[$type][$question_id] = json_encode($answer);  // Simpan dalam format JSON
                    }
                }
            }
        }

        // Debug: Lihat data yang sudah dikelompokkan
        // dd($grouped_data, $data_wali, $data_ayah, $data_ibu, $data_anak, $request->all());
        
        // Update data anak
        $update_data_anak = Pendaftaran::where('id_anak', $id)->update($data_anak);

        // Update data ibu
        $update_data_ibu = PendaftaranIbu::where('id_ibu', $id)->update($data_ibu);

        // Update data ayah
        $update_data_ibu = PendaftaranAyah::where('id_ayah', $id)->update($data_ayah);

        // Update data wali
        $update_data_wali = PendaftaranWali::where('id_wali', $id)->update($data_wali);

        // $this->update_pendaftaran(
        //     //PK
        //     $id,
        //     // data anak
        //     $data_anak['nama_panggilan'], $data_anak['no_nik'], $data_anak['alamat'], $data_anak['provinsi'],$data_anak['kota'], $data_anak['kecamatan'], $data_anak['kelurahan'], $data_anak['status_tinggal'], 
        //     $data_anak['anak_ke'], $data_anak['jml_sdr'], $data_anak['tinggi_badan'], $data_anak['berat_badan'], $data_anak['bahasa'], 
        //     $data_anak['asal_sekolah'], $data_anak['npsn'], $data_anak['kec_asal_sekolah'], $data_anak['agama'], $data_anak['gol_darah'], $data_anak['hafalan'], $data_anak['riwayat_penyakit'], 
        //     $data_anak['info_apakah_abk'], $data_anak['info_detail_saudara'], $data_anak['info_detail_tempat'], $data_anak['info_detail_khusus'],
        //     // data ayah
        //     $data_ayah['email_ayah'], $data_ayah['tptlahir_ayah'], $data_ayah['tgllahir_ayah'], 
        //     $data_ayah['penghasilan'], $data_ayah['pekerjaan_jabatan'], $data_ayah['pendidikan_ayah'], $data_ayah['tahun_nikah_ayah'], $data_ayah['pernikahan_ke_ayah'],
        //     // data ibu
        //     $data_ibu['email_ibu'], $data_ibu['tptlahir_ibu'], $data_ibu['tgllahir_ibu'], 
        //     $data_ibu['penghasilan'], $data_ibu['pekerjaan_jabatan'], $data_ibu['pendidikan_ibu'], $data_ibu['tahun_nikah_ibu'], $data_ibu['pernikahan_ke_ibu'],
        //     // data wali
        //     $data_wali['nama'], $data_wali['tptlahir_wali'], $data_wali['tgllahir_wali'], $data_wali['pekerjaan_jabatan'], $data_wali['pendidikan_wali'], $data_wali['hubungan_wali']
        // );
        $this->update_pendaftaran_baru(
            //PK
            $id,
            // data anak
            $data_anak['nama_panggilan'], $data_anak['no_nik'], $data_anak['alamat'], $data_anak['provinsi'],$data_anak['kota'], $data_anak['kecamatan'], $data_anak['kelurahan'], $data_anak['status_tinggal'], 
            $data_anak['anak_ke'], $data_anak['jml_sdr'], $data_anak['tinggi_badan'], $data_anak['berat_badan'], $data_anak['bahasa'], 
            $data_anak['asal_sekolah'], $data_anak['npsn'], $data_anak['kec_asal_sekolah'], $data_anak['agama'], $data_anak['gol_darah'], $data_anak['hafalan'], $data_anak['riwayat_penyakit'], 
            $data_anak['info_apakah_abk'], $data_anak['info_detail_saudara'], $data_anak['info_detail_tempat'], $data_anak['info_detail_khusus'],
            // data ayah
            $data_ayah['email_ayah'], $data_ayah['tptlahir_ayah'], $data_ayah['tgllahir_ayah'], 
            $data_ayah['penghasilan'], $data_ayah['pekerjaan_jabatan'], $data_ayah['pendidikan_ayah'], $data_ayah['tahun_nikah_ayah'], $data_ayah['pernikahan_ke_ayah'],
            // data ibu
            $data_ibu['email_ibu'], $data_ibu['tptlahir_ibu'], $data_ibu['tgllahir_ibu'], 
            $data_ibu['penghasilan'], $data_ibu['pekerjaan_jabatan'], $data_ibu['pendidikan_ibu'], $data_ibu['tahun_nikah_ibu'], $data_ibu['pernikahan_ke_ibu'],
            // data wali
            $data_wali['nama'], $data_wali['tptlahir_wali'], $data_wali['tgllahir_wali'], $data_wali['pekerjaan_jabatan'], $data_wali['pendidikan_wali'], $data_wali['hubungan_wali']
        );
        
        // Iterasi untuk menyimpan data
        foreach ($grouped_data as $type => $questions) {
            foreach ($questions as $question_id => $answer_json) {
                // Tentukan model yang akan digunakan berdasarkan tipe
                // Simpan atau update data berdasarkan tipe
                if ($type == 'perkembangan') {
                    // Cek apakah data sudah ada di HasilPerkembangan
                    $existing = HasilPerkembangan::where('id_anak', $id)
                                                ->where('id_pertanyaan', $question_id)
                                                ->first();
                    if ($existing) {
                        // Jika data sudah ada, lakukan update
                        $existing->update([
                            'jawaban' => $answer_json,
                        ]);
                    } else {
                        // Jika data belum ada, buat baru
                        HasilPerkembangan::create([
                            'id_anak' => $id,
                            'id_pertanyaan' => $question_id,
                            'jawaban' => $answer_json,
                        ]);
                    }
                    // $this->update_data_pertanyaan($type, $id, $question_id, $answer_json);
                    $this->update_data_pertanyaan_baru($type, $id, $question_id, $answer_json);
                } elseif ($type == 'pengasuhan') {
                    // Cek apakah data sudah ada di HasilPengasuhan
                    $existing = HasilPengasuhan::where('id_anak', $id)
                                            ->where('id_pertanyaan', $question_id)
                                            ->first();
                    if ($existing) {
                        // Jika data sudah ada, lakukan update
                        $existing->update([
                            'jawaban' => $answer_json,
                        ]);
                    } else {
                        // Jika data belum ada, buat baru
                        HasilPengasuhan::create([
                            'id_anak' => $id,
                            'id_pertanyaan' => $question_id,
                            'jawaban' => $answer_json,
                        ]);
                    }
                    // $this->update_data_pertanyaan($type, $id, $question_id, $answer_json);
                    $this->update_data_pertanyaan_baru($type, $id, $question_id, $answer_json);
                }
            }
        }

            return redirect()->route('pendaftaran')->with('success', 'Data berhasil diupdate');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    function update_data_pertanyaan($type, $id, $question_id, $answer_json)
    {
	    $curl = curl_init();

		curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://103.135.214.11:81/qlp_system/api_regist/simpan_data_pertanyaan.php',
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
                'type' => $type,
                'id_anak' => $id,
                'id_pertanyaan' => $question_id,
                'jawaban' => $answer_json
            )

		));

		$response = curl_exec($curl);

		// echo $response;
		curl_close($curl);
	    return ($response);
	
    }
    function update_data_pertanyaan_baru($type, $id, $question_id, $answer_json)
    {
	    $curl = curl_init();

		curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://system.sekolahrabbani.sch.id/api_regist/simpan_data_pertanyaan.php',
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
                'type' => $type,
                'id_anak' => $id,
                'id_pertanyaan' => $question_id,
                'jawaban' => $answer_json
            )

		));

		$response = curl_exec($curl);

		// echo $response;
		curl_close($curl);
	    return ($response);
	}


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pendaftaran  $pendaftaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pendaftaran $pendaftaran)
    {
        //
    }

    public function forget_no_regis (Request $request) {
        try {
            $request->validate([
                'no_hp' => 'required'
            ]);

            $get_no_regis = Pendaftaran::where('no_hp_ibu', $request->no_hp)
                            ->orWhere('no_hp_ayah', $request->no_hp)
                            ->where('nama_lengkap', 'like', '%' .$request->nama_lengkap. '%')
                            ->where('status_pembayaran', 1)
                            ->first();

            if ($get_no_regis) {
                $message = "No Registrasi / Pendaftaran an. $get_no_regis->nama_lengkap adalah " . $get_no_regis->id_anak . "";
                $no_wha = $request->no_hp;

                $this->send_notif($message, $no_wha);
                return redirect()->route('form.find')->with('success', 'No Registrasi telah dikirim ke nomor whatsapp anda');

            } else {
                return redirect()->route('form.find')->with('error', 'Nomor whatsapp tidak terdaftar / Nama Lengkap Tidak Benar');
            }
        } catch (\Throwable $th) {
            return redirect()->route('form.find')->with('error', 'Terjadi kesalahan');
        }
    }

    public function get_profile_by_no_regist (Request $request) 
    {
        $provinsi = Provinsi::all();
        $kota = Kota::all();
        $kecamatan = Kecamatan::all();
        $kelurahan = Kelurahan::all();

        $id = $request->no_registrasi;
        $get_profile = Pendaftaran::get_profile($id);
        // dd($get_profile);

        return view('pendaftaran.tk-sd.pemenuhan-data', compact('get_profile', 'provinsi', 'kecamatan', 'kelurahan', 'kota'));
    }

    
    public function trial_class()
    {
        $lokasi = Lokasi::where('status', 1)->get();
        $jenjang_per_sekolah = JenjangSekolah::all();

        // return view('pendaftaran.trial-class', compact('lokasi', 'jenjang_per_sekolah'));
        return view('pendaftaran.trial-class-close', compact('lokasi', 'jenjang_per_sekolah'));
    }

    public function store_trial_class(Request $request)
    {
        $jenjang_id = $request->jenjang;
        if ($request->lokasi == 'UBR') {
            $jenjang_id = 5;
        }

        $nama_anak = $request->nama_anak;
        $tgl_lahir = $request->tgl_lahir;
        $lokasi = $request->lokasi;
        $no_wa = $request->no_wa;
        $asal_sekolah = $request->asal_sekolah;
        $now = date('YmdHis');

        $tahun_ajaran = TahunAjaranAktif::where('status', 1)->where('status_tampil', 1)->orderBy('id', 'desc')->first();
        $th_ajaran_now = $tahun_ajaran->id;

        $add_trial = TrialClass::create([
            'nama_anak' => $nama_anak,
            'tgl_lahir' => $tgl_lahir,
            'no_wa' => $no_wa,
            'asal_sekolah' => $asal_sekolah,
            'tujuan_sekolah' => $lokasi,
            'jenjang_id' => $jenjang_id,
            'tahun_ajaran' => $th_ajaran_now
        ]);

        $get_jenjang = KuotaPPDB::where('tingkat', $jenjang_id)->first();
        $jenjang = $get_jenjang->jenjang;
        $contact_person =  ContactPerson::where('is_aktif', '1')->where('kode_sekolah', $lokasi)->where('id_jenjang', $jenjang)->first();
        $no_admins = $contact_person->telp;
        $message_trial = 'Pendaftaran trial class telah berhasil dengan nama "'.$nama_anak.'" nomor wa ortu "'.$no_wa.'". ';
        $message_ortu = "*Terima Kasih atas Pendaftarannya!*

Ayah dan Bunda yang kami hormati,

Terima kasih telah mendaftarkan Anandanya untuk mengikuti trial class bersama kami. Kami sangat menghargai kepercayaan yang telah diberikan serta semangat Ayah dan Bunda dalam mendukung proses belajar dan perkembangan Ananda tercinta.☺️

Kami akan menghubungi Ayah dan Bunda dalam waktu *maksimal 3 hari* ke depan untuk menyampaikan informasi mengenai *jadwal trial class* yang tersedia.☺️🙏🏻

Sampai jumpa di kelas, dan mari bersama ciptakan pengalaman belajar yang menyenangkan dan bermakna!

*Salam hangat,*
Sekolah Rabbani";

         // send ke qlp
        //  $this->send_trial_class($nama_anak, $tgl_lahir, $no_wa, $lokasi, $jenjang_id, $asal_sekolah, $th_ajaran_now);
         $this->send_trial_class_baru($nama_anak, $tgl_lahir, $no_wa, $lokasi, $jenjang_id, $asal_sekolah, $th_ajaran_now);

        if ($add_trial) {
            $this->send_notif($message_trial, $no_admins); 
            $this->send_notif($message_ortu, $no_wa); 
        }

        return redirect()->route('trial-class.success')
            ->with('success', 'Pendaftaran Trial Class Berhasil.');
    }

    public function trial_class_success()
    {
        return view('pendaftaran.trial-success');
    }

    function send_pendaftaran_baru($id_anak, $nama_lengkap, $jenis_kelamin, $tempat_lahir, $tgl_lahir, $lokasi, $kelas, $jenjang, $tingkat, $no_hp_ayah, $no_hp_ibu, $nama_ayah, $nama_ibu, $info_ppdb, $tahun_ajaran, $asal_sekolah, $status_daftar, $is_pindahan, $info_apakah_abk){
	    $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://system.sekolahrabbani.sch.id/api_regist/simpan_pendaftaran_baru.php',
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
		  	'id_anak' => $id_anak,
		  	'id_ibu' => $id_anak,
		  	'id_ayah' => $id_anak,
		  	'nama_lengkap' => $nama_lengkap,
		  	'jenis_kelamin' => $jenis_kelamin,
		  	'tempat_lahir' => $tempat_lahir,
		  	'tgl_lahir' => $tgl_lahir,
		  	'lokasi' => $lokasi,
		  	'kelas' => $kelas,
            'jenjang' => $jenjang,
			'tingkat' => $tingkat,
			'no_hp_ayah' => $no_hp_ayah,
			'nama_ayah' => $nama_ayah,
			'nama_ibu' => $nama_ibu,
			'no_hp_ibu' => $no_hp_ibu,
			'info_ppdb' => $info_ppdb,
			'tahun_ajaran' => $tahun_ajaran,
			'asal_sekolah' => $asal_sekolah,
			'status_daftar' => $status_daftar,
			'is_pindahan' => $is_pindahan,
			'info_apakah_abk' => $info_apakah_abk,
            )

		));

		$response = curl_exec($curl);

		// echo $response;
		curl_close($curl);
	    // return ($response);
	}


    function send_pendaftaran($id_anak, $nama_lengkap, $jenis_kelamin, $tempat_lahir, $tgl_lahir, $lokasi, $kelas, $jenjang, $tingkat, $no_hp_ayah, $no_hp_ibu, $nama_ayah, $nama_ibu, $info_ppdb, $tahun_ajaran, $asal_sekolah, $status_daftar, $is_pindahan, $info_apakah_abk){
	    $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'http://103.135.214.11:81/qlp_system/api_regist/simpan_pendaftaran_baru.php',
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
		  	'id_anak' => $id_anak,
		  	'id_ibu' => $id_anak,
		  	'id_ayah' => $id_anak,
		  	'nama_lengkap' => $nama_lengkap,
		  	'jenis_kelamin' => $jenis_kelamin,
		  	'tempat_lahir' => $tempat_lahir,
		  	'tgl_lahir' => $tgl_lahir,
		  	'lokasi' => $lokasi,
		  	'kelas' => $kelas,
            'jenjang' => $jenjang,
			'tingkat' => $tingkat,
			'no_hp_ayah' => $no_hp_ayah,
			'nama_ayah' => $nama_ayah,
			'nama_ibu' => $nama_ibu,
			'no_hp_ibu' => $no_hp_ibu,
			'info_ppdb' => $info_ppdb,
			'tahun_ajaran' => $tahun_ajaran,
			'asal_sekolah' => $asal_sekolah,
			'status_daftar' => $status_daftar,
			'is_pindahan' => $is_pindahan,
			'info_apakah_abk' => $info_apakah_abk,
            )

		));

		$response = curl_exec($curl);

		// echo $response;
		curl_close($curl);
	    // return ($response);
	}

    function update_pendaftaran(
        //PK
        $id_anak,
        // data anak
        $nama_panggilan, $no_nik, $alamat, $provinsi,$kota, $kecamatan, $kelurahan, $status_tinggal, 
        $anak_ke, $jml_sdr, $tinggi_badan, $berat_badan, $bhs_digunakan, 
        $asal_sekolah, $npsn, $kec_asal_sekolah, $agama, $gol_darah, $hafalan, $riwayat_penyakit, 
        $info_apakah_abk, $info_detail_saudara, $info_detail_tempat, $info_detail_khusus,
        // data ayah
        $email_ayah, $tptlahir_ayah, $tgllahir_ayah, 
        $pengahasilan_ayah, $pekerjaan_ayah, $pendidikan_ayah, $tahun_nikah_ayah, $pernikahan_ke_ayah,
        // data ibu
        $email_ibu, $tptlahir_ibu, $tgllahir_ibu, 
        $pengahasilan_ibu, $pekerjaan_ibu, $pendidikan_ibu, $tahun_nikah_ibu, $pernikahan_ke_ibu,
        // data wali
        $nama_wali, $tptlahir_wali, $tgllahir_wali, $pekerjaan_wali, $pendidikan_wali, $hubungan_wali
    )
    {
	    $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'http://103.135.214.11:81/qlp_system/api_regist/update_pendaftaran_baru.php',
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
            // PK
            'id' => $id_anak,
            // data anak
            'nama_panggilan' => $nama_panggilan,
            'no_nik' => $no_nik,
            'alamat' => $alamat,
            'provinsi' => $provinsi,
            'kota' => $kota,
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'status_tinggal' => $status_tinggal,
            'anak_ke' => $anak_ke,
            'jml_sdr' => $jml_sdr,
            'tinggi_badan' => $tinggi_badan,
            'berat_badan' => $berat_badan,
            'bhs_digunakan' => $bhs_digunakan,
            'asal_sekolah' => $asal_sekolah,
            'npsn' => $npsn,
            'kec_asal_sekolah' => $kec_asal_sekolah,
            'agama' => $agama,
            'gol_darah' => $gol_darah,
            'hafalan' => $hafalan,
            'riwayat_penyakit' => $riwayat_penyakit,
            'info_apakah_abk' => $info_apakah_abk,
            'info_detail_saudara' => $info_detail_saudara,
            'info_detail_tempat' => $info_detail_tempat,
            'info_detail_khusus' => $info_detail_khusus,
            // data ayah
            'email_ayah' => $email_ayah,
            'tptlahir_ayah' => $tptlahir_ayah,
            'tgllahir_ayah' => $tgllahir_ayah,
            'pengahasilan_ayah' => $pengahasilan_ayah,
            'pekerjaan_ayah' => $pekerjaan_ayah,
            'pendidikan_ayah' => $pendidikan_ayah,
            'tahun_nikah_ayah' => $tahun_nikah_ayah,
            'pernikahan_ke_ayah' => $pernikahan_ke_ayah,
            // data ibu
            'email_ibu' => $email_ibu,
            'tptlahir_ibu' => $tptlahir_ibu,
            'tgllahir_ibu' => $tgllahir_ibu,
            'pengahasilan_ibu' => $pengahasilan_ibu,
            'pekerjaan_ibu' => $pekerjaan_ibu,
            'pendidikan_ibu' => $pendidikan_ibu,
            'tahun_nikah_ibu' => $tahun_nikah_ibu,
            'pernikahan_ke_ibu' => $pernikahan_ke_ibu,
            // data wali
            'nama_wali' => $nama_wali,
            'tptlahir_wali' => $tptlahir_wali,
            'tgllahir_wali' => $tgllahir_wali,
            'pekerjaan_wali' => $pekerjaan_wali,
            'pendidikan_wali' => $pendidikan_wali,
            'hubungan_wali' => $hubungan_wali
            )
		));

		$response = curl_exec($curl);

		// echo $response;
		curl_close($curl);
	    return ($response);
	}

    function update_pendaftaran_baru(
        //PK
        $id_anak,
        // data anak
        $nama_panggilan, $no_nik, $alamat, $provinsi,$kota, $kecamatan, $kelurahan, $status_tinggal, 
        $anak_ke, $jml_sdr, $tinggi_badan, $berat_badan, $bhs_digunakan, 
        $asal_sekolah, $npsn, $kec_asal_sekolah, $agama, $gol_darah, $hafalan, $riwayat_penyakit, 
        $info_apakah_abk, $info_detail_saudara, $info_detail_tempat, $info_detail_khusus,
        // data ayah
        $email_ayah, $tptlahir_ayah, $tgllahir_ayah, 
        $penghasilan_ayah, $pekerjaan_ayah, $pendidikan_ayah, $tahun_nikah_ayah, $pernikahan_ke_ayah,
        // data ibu
        $email_ibu, $tptlahir_ibu, $tgllahir_ibu, 
        $penghasilan_ibu, $pekerjaan_ibu, $pendidikan_ibu, $tahun_nikah_ibu, $pernikahan_ke_ibu,
        // data wali
        $nama_wali, $tptlahir_wali, $tgllahir_wali, $pekerjaan_wali, $pendidikan_wali, $hubungan_wali
    )
    {
	    $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://system.sekolahrabbani.sch.id/api_regist/update_pendaftaran_baru.php',
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
            // PK
            'id' => $id_anak,
            // data anak
            'nama_panggilan' => $nama_panggilan,
            'no_nik' => $no_nik,
            'alamat' => $alamat,
            'provinsi' => $provinsi,
            'kota' => $kota,
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'status_tinggal' => $status_tinggal,
            'anak_ke' => $anak_ke,
            'jml_sdr' => $jml_sdr,
            'tinggi_badan' => $tinggi_badan,
            'berat_badan' => $berat_badan,
            'bhs_digunakan' => $bhs_digunakan,
            'asal_sekolah' => $asal_sekolah,
            'npsn' => $npsn,
            'kec_asal_sekolah' => $kec_asal_sekolah,
            'agama' => $agama,
            'gol_darah' => $gol_darah,
            'hafalan' => $hafalan,
            'riwayat_penyakit' => $riwayat_penyakit,
            'info_apakah_abk' => $info_apakah_abk,
            'info_detail_saudara' => $info_detail_saudara,
            'info_detail_tempat' => $info_detail_tempat,
            'info_detail_khusus' => $info_detail_khusus,
            // data ayah
            'email_ayah' => $email_ayah,
            'tptlahir_ayah' => $tptlahir_ayah,
            'tgllahir_ayah' => $tgllahir_ayah,
            'penghasilan_ayah' => $penghasilan_ayah,
            'pekerjaan_ayah' => $pekerjaan_ayah,
            'pendidikan_ayah' => $pendidikan_ayah,
            'tahun_nikah_ayah' => $tahun_nikah_ayah,
            'pernikahan_ke_ayah' => $pernikahan_ke_ayah,
            // data ibu
            'email_ibu' => $email_ibu,
            'tptlahir_ibu' => $tptlahir_ibu,
            'tgllahir_ibu' => $tgllahir_ibu,
            'penghasilan_ibu' => $penghasilan_ibu,
            'pekerjaan_ibu' => $pekerjaan_ibu,
            'pendidikan_ibu' => $pendidikan_ibu,
            'tahun_nikah_ibu' => $tahun_nikah_ibu,
            'pernikahan_ke_ibu' => $pernikahan_ke_ibu,
            // data wali
            'nama_wali' => $nama_wali,
            'tptlahir_wali' => $tptlahir_wali,
            'tgllahir_wali' => $tgllahir_wali,
            'pekerjaan_wali' => $pekerjaan_wali,
            'pendidikan_wali' => $pendidikan_wali,
            'hubungan_wali' => $hubungan_wali
            )
		));

		$response = curl_exec($curl);

		// echo $response;
		curl_close($curl);
	    return ($response);
	}

    function send_trial_class_baru($nama_anak, $tgl_lahir, $no_wa, $lokasi, $jenjang, $asal_sekolah, $th_ajaran_now )
    {
        $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://system.sekolahrabbani.sch.id/api_regist/simpan_trial_class.php',
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
		  	'nama_anak' => $nama_anak,
		  	'tgl_lahir' => $tgl_lahir,
		  	'no_wa' => $no_wa,
		  	'lokasi' => $lokasi,
		  	'jenjang_id' => $jenjang,
			'asal_sekolah' => $asal_sekolah,
			'tahun_ajaran' => $th_ajaran_now
            )

		));

		$response = curl_exec($curl);

		// echo $response;
		curl_close($curl);
	    // return ($response)
    }

    function send_trial_class($nama_anak, $tgl_lahir, $no_wa, $lokasi, $jenjang, $asal_sekolah, $th_ajaran_now )
    {
        $curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'http://103.135.214.11:81/qlp_system/api_regist/simpan_trial_class.php',
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
		  	'nama_anak' => $nama_anak,
		  	'tgl_lahir' => $tgl_lahir,
		  	'no_wa' => $no_wa,
		  	'lokasi' => $lokasi,
		  	'jenjang_id' => $jenjang,
			'asal_sekolah' => $asal_sekolah,
			'tahun_ajaran' => $th_ajaran_now
            )

		));

		$response = curl_exec($curl);

		// echo $response;
		curl_close($curl);
	    // return ($response)
    }

    function send_notif($message,$no_wha){
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

}
