<?php

namespace App\Http\Controllers;

use App\Models\Angket;
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

        return view('pendaftaran.index', compact('contact_person'));
    }

    public function form_pendaftaran()
    {
        $lokasi = Lokasi::where('status', 1)->get();
        $jenjang_per_sekolah = JenjangSekolah::all();
        $tahun_ajaran = TahunAjaranAktif::where('status', 1)->where('status_tampil', 1)->orderBy('id', 'asc')->get();

        // dd($tahun_ajaran);
        return view('pendaftaran.tk-sd.formulir', compact('lokasi', 'jenjang_per_sekolah', 'tahun_ajaran'));
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
            'no_hp_ibu' => 'required',
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
        }else if ($request->jenjang == '4') {
            $tingkat = 'SD';
        }

        
        if ($request->radios == 'lainnya') {
            $sumber_ppdb = $request->radios2;
        } else if ($request->radios == null || $request->radios == '') {
            $sumber_ppdb = 'spanduk/baliho';
        } else {
            $sumber_ppdb = $request->radios;
        }

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

        // cek kuota
        $cek_kuota = KuotaPPDB::where('id_tahun_ajaran', $tahun_ajaran)->where('lokasi', $lokasi)
                                ->where('tingkat', $tingkat)->where('jenjang', $jenjang)->first();
        
        $kuota = $cek_kuota->kuota;

        $pendaftar = Pendaftaran::where('tahun_ajaran', $tahun_ajaran)->where('lokasi', $lokasi)
                                        ->where('tingkat', $tingkat)->where('jenjang', $jenjang)
                                        ->where('status_pembayaran', 1)->get();
        
        $count_pendaftar = $pendaftar->count();

        if ($kelas == 1 || $kelas == 7 || $kelas == 'tka' || $kelas == 'tkb' || $kelas == 'kober') {
            if ($kuota > $count_pendaftar) {
                $status_daftar = 2 ;
            } else {
                $status_daftar = 3 ;
            }
        } else {
            $status_daftar = 2;
        }

        // simpan ke tbl_anak
        Pendaftaran::create([
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
            'jenis_pendidikan' => $jenis_pendidikan,
            'tahun_ajaran' => $tahun_ajaran,
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

        // send ke qlp
        $this->send_pendaftaran($id_anak, $nama_lengkap, $jenis_kelamin, $tempat_lahir, $tgl_lahir, $lokasi, $kelas, $jenjang, $tingkat, $no_hp_ayah, $no_hp_ibu, $nama_ayah, $nama_ibu, $sumber_ppdb, $tahun_ajaran, $asal_sekolah, $status_daftar);
        $this->send_pendaftaran_baru($id_anak, $nama_lengkap, $jenis_kelamin, $tempat_lahir, $tgl_lahir, $lokasi, $kelas, $jenjang, $tingkat, $no_hp_ayah, $no_hp_ibu, $nama_ayah, $nama_ibu, $sumber_ppdb, $tahun_ajaran, $asal_sekolah, $status_daftar);

        $contact_person =  ContactPerson::where('is_aktif', '1')->where('kode_sekolah', $lokasi)->where('id_jenjang', $jenjang)->first();
        $no_admin = $contact_person->telp;
        $biaya = $contact_person->biaya;
        $no_rek = $contact_person->norek;
        $nama_rek = $contact_person->nama_rek;

        //send notif ke admin
		$message_for_admin='Pendaftaran telah berhasil dengan nomor registrasi "'.$id_anak.'". a/n "'.$nama_lengkap.'" ';
		$message_for_admin_wl='Pendaftaran telah berhasil dengan nomor registrasi "'.$id_anak.'". a/n "'.$nama_lengkap.'" masuk dalam waiting list';

        //send notif ke ortu
        $message_ortu = "Terimakasih *Ayah/Bunda $nama_lengkap* telah mendaftarkan Anandanya ke Sekolah Rabbani. 
No Registrasi / Pendaftaran adalah *$id_anak* mohon disimpan untuk selanjutnya pemenuhan data saat psikotest. 

Silahkan lakukan pembayaran pendaftaran sebesar *Rp ".number_format($biaya)."* ke rekening *".$nama_rek." ".$no_rek."* dan kirim bukti bayar ke nomor https://wa.me/".$no_admin." 

Apabila ada pertanyaan silahkan hubungi Customer Service kami di nomor ".$no_admin.", Terima Kasih.";

        $message_waiting_list = "Terimakasih *Ayah/Bunda $nama_lengkap* telah mendaftarkan Anandanya ke Sekolah Rabbani dengan No Registrasi adalah *$id_anak*. Kami sangat menghargai kepercayaan Ayah/Bunda kepada kami. 

Kami akan segera menginformasikan kepada Ayah/Bunda mengenai proses selanjutnya. Jika ada pertanyaan atau kebutuhan informasi tambahan, jangan ragu untuk menghubungi kami melalui nomor ".$no_admin." 

Hormat Kami,
*Sekolah Rabbani.*";

        if ($status_daftar == 3) {
            $this->send_notif($message_for_admin_wl, $no_admin);
            $this->send_notif($message_waiting_list, $no_hp_ayah);
            $this->send_notif($message_waiting_list, $no_hp_ibu);
        } else {
            $this->send_notif($message_for_admin, $no_admin);
            $this->send_notif($message_ortu, $no_hp_ayah);
            $this->send_notif($message_ortu, $no_hp_ibu);
        }

        return redirect()->route('pendaftaran')
            ->with('success', 'Pendaftaran Berhasil.');
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
            $kuesioner = KuesionerAnak::all();
            $kuesioner_ortu = KuesionerOrtu::all();
            $get_kuesioner_anak = Angket::get_profile($no_registrasi);
            $get_kuesioner_ortu = ProgramReg::get_profile($no_registrasi);
        }
        

        $get_profile_ibu = PendaftaranIbu::get_profile($no_registrasi);
        $get_profile_ayah = PendaftaranAyah::get_profile($no_registrasi);
        $get_profile_wali = PendaftaranWali::get_profile($no_registrasi);
        $kuesioner = KuesionerAnak::all();
        $kuesioner_ortu = KuesionerOrtu::all();
        $get_kuesioner_anak = Angket::get_profile($no_registrasi);
        $get_kuesioner_ortu = ProgramReg::get_profile($no_registrasi);
        // dd($get_kuesioner_ortu);


        return view('pendaftaran.tk-sd.pemenuhan-data', compact('provinsi', 'kecamatan', 'kecamatan_asal_sekolah', 'kelurahan', 'kota', 
        'get_profile',  'get_profile_ibu',  'get_profile_ayah', 'get_profile_wali', 'no_registrasi', 'kuesioner', 'kuesioner_ortu',
        'get_kuesioner_ortu', 'get_kuesioner_anak', 'list_pekerjaan_ayah', 'list_pekerjaan_ibu'));
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

            $nik = $request->nik;
            $alamat = $request->alamat;
            $provinsi = $request->provinsi;
            $kota = $request->kota;
            $kecamatan = $request->kecamatan;
            $kelurahan = $request->kelurahan;
            $agama = $request->agama;
            $anak_ke = $request->anak_ke;
            $jumlah_saudara = $request->jumlah_saudara;
            $tinggi_badan = $request->tinggi_badan;
            $berat_badan = $request->berat_badan;
            $gol_darah = $request->gol_darah;
            $riwayat_penyakit = $request->riwayat_penyakit;
            $kec_asal_sekolah = $request->kec_asal_sekolah;
            $email_ibu = $request->email_ibu;
            $email_ayah = $request->email_ayah;
            $npsn = $request->npsn;
            $status_tinggal = $request->status_tinggal;
            $hafalan = $request->hafalan;
            $tempat_lahir_ibu = $request->tempat_lahir_ibu;
            $tgl_lahir_ibu = $request->tgl_lahir_ibu;
            $pekerjaan_ibu = $request->pekerjaan_ibu;
            $penghasilan_ibu = $request->penghasilan_ibu;
            $pendidikan_ibu = $request->pendidikan_ibu;
            $tempat_lahir_ayah = $request->tempat_lahir_ayah;
            $tgl_lahir_ayah = $request->tgl_lahir_ayah;
            $pekerjaan_ayah = $request->pekerjaan_ayah;
            $penghasilan_ayah = $request->penghasilan_ayah;
            $pendidikan_ayah = $request->pendidikan_ayah;
            $tempat_lahir_wali = $request->tempat_lahir_wali;
            $tgl_lahir_wali = $request->tgl_lahir_wali;
            $pekerjaan_wali = $request->pekerjaan_wali;
            $pendidikan_wali = $request->pendidikan_wali;
            $nama_wali = $request->nama_wali;
            $hubungan_wali = $request->hubungan_wali;
            $nama_panggilan = $request->nama_panggilan;
            $bhs_digunakan = $request->bhs_digunakan;
            $asal_sekolah = $request->asal_sekolah;
            $hijayah = $request->hijayah;
            $alphabet = $request->alphabet;
            $suka_menulis = $request->suka_menulis;
            $suka_gambar = $request->suka_gambar;
            $suka_hafalan = $request->suka_hafalan;
            $memiliki_hafalan = $request->memiliki_hafalan;
            $bergaul = $request->bergaul;
            $prakarya = $request->prakarya;
            $mengungkapkan = $request->mengungkapkan;
            $sholat_fardhu = $request->sholat_fardhu;
            $berbicara_baik = $request->berbicara_baik;
            $baju_sendiri = $request->baju_sendiri;
            $simpan_sepatu = $request->simpan_sepatu;
            $buang_sampah = $request->buang_sampah;
            $ekspresi_marah = $request->ekspresi_marah;
            $malu_salah = $request->malu_salah;
            $ketergantungan = $request->ketergantungan;
            $merengek = $request->merengek;
            $mandi_sendiri = $request->mandi_sendiri;
            $bab_bak_sendiri = $request->bab_bak_sendiri;
            $habis_waktu = $request->habis_waktu;
            $kelebihan_ananda = $request->kelebihan_ananda;
            $welcome_ceremony = $request->welcome_ceremony;
            $quranic_parenting = $request->quranic_parenting;
            $temu_wali_kelas = $request->temu_wali_kelas;
            $hafalan_rumah = $request->hafalan_rumah;
            $wirausaha = $request->wirausaha;
            $komunikasi = $request->komunikasi;
            $biaya_pendidikan = $request->biaya_pendidikan;
            
    
            $update_data_anak = Pendaftaran::where('id_anak', $id)->update([
                'no_nik' => $nik,
                'alamat' => $alamat,
                'provinsi' => $provinsi,
                'kota' => $kota,
                'kecamatan' => $kecamatan,
                'kelurahan' => $kelurahan,
                'agama' => $agama,
                'anak_ke' => $anak_ke,
                'jml_sdr' => $jumlah_saudara,
                'tinggi_badan' => $tinggi_badan,
                'berat_badan' => $berat_badan,
                'gol_darah' => $gol_darah,
                'riwayat_penyakit' => $riwayat_penyakit,
                'hafalan' => $hafalan,
                'kec_asal_sekolah' => $kec_asal_sekolah,
                'email_ibu' => $email_ibu,
                'email_ayah' => $email_ayah,
                'npsn' => $npsn,
                'bahasa' => $bhs_digunakan,
                'nama_panggilan' => $nama_panggilan,
                'status_tinggal' => $status_tinggal,
                'asal_sekolah' => $asal_sekolah
            ]);

          
            $update_data_ibu = PendaftaranIbu::where('id_ibu', $id)->update([
                'tptlahir_ibu' => $tempat_lahir_ibu,
                'tgllahir_ibu' => $tgl_lahir_ibu,
                'pekerjaan_jabatan' => $pekerjaan_ibu,
                'penghasilan' => $penghasilan_ibu,
                'pendidikan_ibu' => $pendidikan_ibu,
            ]);

            $update_data_ayah = PendaftaranAyah::where('id_ayah', $id)->update([
                'tptlahir_ayah' => $tempat_lahir_ayah,
                'tgllahir_ayah' => $tgl_lahir_ayah,
                'pekerjaan_jabatan' => $pekerjaan_ayah,
                'penghasilan' => $penghasilan_ayah,
                'pendidikan_ayah' => $pendidikan_ayah,
            ]);

            $update_data_wali = PendaftaranWali::where('id_wali', $id)->update([
                'nama' => $nama_wali,
                'tptlahir_wali' => $tempat_lahir_wali,
                'tgllahir_wali' => $tgl_lahir_wali,
                'pekerjaan_jabatan' => $pekerjaan_wali,
                'pendidikan_wali' => $pendidikan_wali,
                'hubungan_wali' => $hubungan_wali,
            ]);

            $update_kuesioner = Angket::where('id_anak', $id)->update([
                'mengenal_hijaiyah' => $hijayah,
                'mengenal_alphabet' => $alphabet,
                'suka_menulis' => $suka_menulis,
                'suka_menggambar' => $suka_gambar,
                'hafalan_alquran' => $suka_hafalan,
                'memiliki_hafalan' => $memiliki_hafalan,
                'senang_bergaul' => $bergaul,
                'membuat_prakarya' => $prakarya,
                'ungkapan_keinginan' => $mengungkapkan,
                'mengikuti_sholat' => $sholat_fardhu,
                'berbicara_baik' => $berbicara_baik,
                'memakai_baju_sendiri' => $baju_sendiri,
                'menyimpan_sepatu' => $simpan_sepatu,
                'membuang_sampah' => $buang_sampah,
                'mengekspresikan' => $ekspresi_marah,
                'melakukan_kesalahan' => $malu_salah,
                'ketergantungan' => $ketergantungan,
                'keinginan' => $merengek,
                'mampu_mandi' => $mandi_sendiri,
                'mampu_sendiri' => $bab_bak_sendiri,
                'menghabiskan_waktu' => $habis_waktu,
                'kelebihan_ananda' => $kelebihan_ananda,
                'updatedate' => date('Y-m-d H:i:s'),
            ]);

            $update_kuesionere_ortu = ProgramReg::where('id_anak', $id)->update([
                'orientasi_peserta_didik' => $welcome_ceremony,
                'bersedia_mengikuti_qp' => $quranic_parenting,
                'mengikuti_pertemuan_rutin' => $temu_wali_kelas,
                'menemani_ananda' => $hafalan_rumah,
                'kewirausahaan_ananda' => $wirausaha,
                'kemampuan_komunikasi_aktif_ananda' => $komunikasi,
                'pembiayaan_pendidikan' => $biaya_pendidikan,
                'updatedate' => date('Y-m-d H:i:s')
            ]);

            // update ke qlp
            $this->update_pendaftaran($id, $nik, $alamat, $provinsi, $kota, $kecamatan, $kelurahan, $agama, $anak_ke, $jumlah_saudara, $npsn,
            $asal_sekolah, $tinggi_badan, $berat_badan, $gol_darah, $riwayat_penyakit, $kec_asal_sekolah, $hafalan, $email_ayah, $email_ibu, $status_tinggal, 
            $tempat_lahir_ibu, $tgl_lahir_ibu, $pekerjaan_ibu, $penghasilan_ibu, $pendidikan_ibu, 
            $tempat_lahir_ayah, $tgl_lahir_ayah, $pekerjaan_ayah, $penghasilan_ayah, $pendidikan_ayah, 
            $tempat_lahir_wali, $tgl_lahir_wali, $pekerjaan_wali, $pendidikan_wali, $nama_wali, $hubungan_wali, $bhs_digunakan, $nama_panggilan,
            $hijayah, $alphabet, $suka_menulis, $suka_gambar, $suka_hafalan, $memiliki_hafalan, $bergaul, $prakarya, $mengungkapkan, 
            $sholat_fardhu, $berbicara_baik, $baju_sendiri, $simpan_sepatu, $buang_sampah, $ekspresi_marah, $malu_salah, $ketergantungan, 
            $merengek, $mandi_sendiri, $bab_bak_sendiri, $habis_waktu, $kelebihan_ananda,
            $welcome_ceremony, $quranic_parenting, $temu_wali_kelas, $hafalan_rumah, $wirausaha, $komunikasi, $biaya_pendidikan
            );
            $this->update_pendaftaran_baru($id, $nik, $alamat, $provinsi, $kota, $kecamatan, $kelurahan, $agama, $anak_ke, $jumlah_saudara, $npsn,
            $asal_sekolah, $tinggi_badan, $berat_badan, $gol_darah, $riwayat_penyakit, $kec_asal_sekolah, $hafalan, $email_ayah, $email_ibu, $status_tinggal, 
            $tempat_lahir_ibu, $tgl_lahir_ibu, $pekerjaan_ibu, $penghasilan_ibu, $pendidikan_ibu, 
            $tempat_lahir_ayah, $tgl_lahir_ayah, $pekerjaan_ayah, $penghasilan_ayah, $pendidikan_ayah, 
            $tempat_lahir_wali, $tgl_lahir_wali, $pekerjaan_wali, $pendidikan_wali, $nama_wali, $hubungan_wali, $bhs_digunakan, $nama_panggilan,
            $hijayah, $alphabet, $suka_menulis, $suka_gambar, $suka_hafalan, $memiliki_hafalan, $bergaul, $prakarya, $mengungkapkan, 
            $sholat_fardhu, $berbicara_baik, $baju_sendiri, $simpan_sepatu, $buang_sampah, $ekspresi_marah, $malu_salah, $ketergantungan, 
            $merengek, $mandi_sendiri, $bab_bak_sendiri, $habis_waktu, $kelebihan_ananda,
            $welcome_ceremony, $quranic_parenting, $temu_wali_kelas, $hafalan_rumah, $wirausaha, $komunikasi, $biaya_pendidikan
            );
    
            return redirect()->route('pendaftaran')->with('success', 'Data berhasil diupdate');
        } catch (\Throwable $th) {
            throw $th;
        }
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

        return view('pendaftaran.trial-class', compact('lokasi', 'jenjang_per_sekolah'));
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
         $this->send_trial_class($nama_anak, $tgl_lahir, $no_wa, $lokasi, $jenjang_id, $asal_sekolah, $th_ajaran_now);
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

    function send_pendaftaran_baru($id_anak, $nama_lengkap, $jenis_kelamin, $tempat_lahir, $tgl_lahir, $lokasi, $kelas, $jenjang, $tingkat, $no_hp_ayah, $no_hp_ibu, $nama_ayah, $nama_ibu, $info_ppdb, $tahun_ajaran, $asal_sekolah, $status_daftar){
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
			'status_daftar' => $status_daftar
            )

		));

		$response = curl_exec($curl);

		// echo $response;
		curl_close($curl);
	    // return ($response);
	}


    function send_pendaftaran($id_anak, $nama_lengkap, $jenis_kelamin, $tempat_lahir, $tgl_lahir, $lokasi, $kelas, $jenjang, $tingkat, $no_hp_ayah, $no_hp_ibu, $nama_ayah, $nama_ibu, $info_ppdb, $tahun_ajaran, $asal_sekolah, $status_daftar){
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
			'status_daftar' => $status_daftar
            )

		));

		$response = curl_exec($curl);

		// echo $response;
		curl_close($curl);
	    // return ($response);
	}

    function update_pendaftaran($id, $nik, $alamat, $provinsi, $kota, $kecamatan, $kelurahan, $agama, $anak_ke, $jumlah_saudara, $npsn,
    $asal_sekolah, $tinggi_badan, $berat_badan, $gol_darah, $riwayat_penyakit, $kec_asal_sekolah, $hafalan, $email_ayah, $email_ibu, $status_tinggal, 
    $tempat_lahir_ibu, $tgl_lahir_ibu, $pekerjaan_ibu, $penghasilan_ibu, $pendidikan_ibu, 
    $tempat_lahir_ayah, $tgl_lahir_ayah, $pekerjaan_ayah, $penghasilan_ayah, $pendidikan_ayah, 
    $tempat_lahir_wali, $tgl_lahir_wali, $pekerjaan_wali, $pendidikan_wali, $nama_wali, $hubungan_wali, $bhs_digunakan, $nama_panggilan,
    $hijayah, $alphabet, $suka_menulis, $suka_gambar, $suka_hafalan, $memiliki_hafalan, $bergaul, $prakarya, $mengungkapkan, 
    $sholat_fardhu, $berbicara_baik, $baju_sendiri, $simpan_sepatu, $buang_sampah, $ekspresi_marah, $malu_salah, $ketergantungan, 
    $merengek, $mandi_sendiri, $bab_bak_sendiri, $habis_waktu, $kelebihan_ananda,
    $welcome_ceremony, $quranic_parenting, $temu_wali_kelas, $hafalan_rumah, $wirausaha, $komunikasi, $biaya_pendidikan)
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
		  	'id_anak' => $id,
		  	'id_ibu' => $id,
		  	'id_ayah' => $id,
		    'no_nik' => $nik,
            'alamat' => $alamat,
            'provinsi' => $provinsi,
            'kota' => $kota,
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'agama' => $agama,
            'anak_ke' => $anak_ke,
            'jml_sdr' => $jumlah_saudara,
            'npsn' => $npsn,
            'tinggi_badan' => $tinggi_badan,
            'berat_badan' => $berat_badan,
            'gol_darah' => $gol_darah,
            'riwayat_penyakit' => $riwayat_penyakit,
            'hafalan' => $hafalan,
            'kec_asal_sekolah' => $kec_asal_sekolah,
            'email_ibu' => $email_ibu,
            'email_ayah' => $email_ayah,
            'status_tinggal' => $status_tinggal,
            'tptlahir_ibu' => $tempat_lahir_ibu,
            'tgllahir_ibu' => $tgl_lahir_ibu,
            'pekerjaan_ibu' => $pekerjaan_ibu,
            'penghasilan_ibu' => $penghasilan_ibu,
            'pendidikan_ibu' => $pendidikan_ibu,
            'tptlahir_ayah' => $tempat_lahir_ayah,
            'tgllahir_ayah' => $tgl_lahir_ayah,
            'pekerjaan_ayah' => $pekerjaan_ayah,
            'penghasilan_ayah' => $penghasilan_ayah,
            'pendidikan_ayah' => $pendidikan_ayah,
            'nama_wali' => $nama_wali,
            'tptlahir_wali' => $tempat_lahir_wali,
            'tgllahir_wali' => $tgl_lahir_wali,
            'pekerjaan_wali' => $pekerjaan_wali,
            'pendidikan_wali' => $pendidikan_wali,
            'hubungan_wali' => $hubungan_wali,
            'bhs_digunakan' => $bhs_digunakan,
            'asal_sekolah' => $asal_sekolah,
            'nama_panggilan' => $nama_panggilan,
            'mengenal_hijaiyah' => $hijayah,
            'mengenal_alphabet' => $alphabet,
            'suka_menulis' => $suka_menulis,
            'suka_menggambar' => $suka_gambar,
            'hafalan_alquran' => $suka_hafalan,
            'memiliki_hafalan' => $memiliki_hafalan,
            'senang_bergaul' => $bergaul,
            'membuat_prakarya' => $prakarya,
            'ungkapan_keinginan' => $mengungkapkan,
            'mengikuti_sholat' => $sholat_fardhu,
            'berbicara_baik' => $berbicara_baik,
            'memakai_baju_sendiri' => $baju_sendiri,
            'menyimpan_sepatu' => $simpan_sepatu,
            'membuang_sampah' => $buang_sampah,
            'mengekspresikan' => $ekspresi_marah,
            'melakukan_kesalahan' => $malu_salah,
            'ketergantungan' => $ketergantungan,
            'keinginan' => $merengek,
            'mampu_mandi' => $mandi_sendiri,
            'mampu_sendiri' => $bab_bak_sendiri,
            'menghabiskan_waktu' => $habis_waktu,
            'kelebihan_ananda' => $kelebihan_ananda,
            'orientasi_peserta_didik' => $welcome_ceremony,
            'bersedia_mengikuti_qp' => $quranic_parenting,
            'mengikuti_pertemuan_rutin' => $temu_wali_kelas,
            'menemani_ananda' => $hafalan_rumah,
            'kewirausahaan_ananda' => $wirausaha,
            'kemampuan_komunikasi_aktif_ananda' => $komunikasi,
            'pembiayaan_pendidikan' => $biaya_pendidikan,
            )

		));

		$response = curl_exec($curl);

		// echo $response;
		curl_close($curl);
	    return ($response);
	}

    function update_pendaftaran_baru($id, $nik, $alamat, $provinsi, $kota, $kecamatan, $kelurahan, $agama, $anak_ke, $jumlah_saudara, $npsn,
    $asal_sekolah, $tinggi_badan, $berat_badan, $gol_darah, $riwayat_penyakit, $kec_asal_sekolah, $hafalan, $email_ayah, $email_ibu, $status_tinggal, 
    $tempat_lahir_ibu, $tgl_lahir_ibu, $pekerjaan_ibu, $penghasilan_ibu, $pendidikan_ibu, 
    $tempat_lahir_ayah, $tgl_lahir_ayah, $pekerjaan_ayah, $penghasilan_ayah, $pendidikan_ayah, 
    $tempat_lahir_wali, $tgl_lahir_wali, $pekerjaan_wali, $pendidikan_wali, $nama_wali, $hubungan_wali, $bhs_digunakan, $nama_panggilan,
    $hijayah, $alphabet, $suka_menulis, $suka_gambar, $suka_hafalan, $memiliki_hafalan, $bergaul, $prakarya, $mengungkapkan, 
    $sholat_fardhu, $berbicara_baik, $baju_sendiri, $simpan_sepatu, $buang_sampah, $ekspresi_marah, $malu_salah, $ketergantungan, 
    $merengek, $mandi_sendiri, $bab_bak_sendiri, $habis_waktu, $kelebihan_ananda,
    $welcome_ceremony, $quranic_parenting, $temu_wali_kelas, $hafalan_rumah, $wirausaha, $komunikasi, $biaya_pendidikan)
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
		  	'id_anak' => $id,
		  	'id_ibu' => $id,
		  	'id_ayah' => $id,
		    'no_nik' => $nik,
            'alamat' => $alamat,
            'provinsi' => $provinsi,
            'kota' => $kota,
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'agama' => $agama,
            'anak_ke' => $anak_ke,
            'jml_sdr' => $jumlah_saudara,
            'npsn' => $npsn,
            'tinggi_badan' => $tinggi_badan,
            'berat_badan' => $berat_badan,
            'gol_darah' => $gol_darah,
            'riwayat_penyakit' => $riwayat_penyakit,
            'hafalan' => $hafalan,
            'kec_asal_sekolah' => $kec_asal_sekolah,
            'email_ibu' => $email_ibu,
            'email_ayah' => $email_ayah,
            'status_tinggal' => $status_tinggal,
            'tptlahir_ibu' => $tempat_lahir_ibu,
            'tgllahir_ibu' => $tgl_lahir_ibu,
            'pekerjaan_ibu' => $pekerjaan_ibu,
            'penghasilan_ibu' => $penghasilan_ibu,
            'pendidikan_ibu' => $pendidikan_ibu,
            'tptlahir_ayah' => $tempat_lahir_ayah,
            'tgllahir_ayah' => $tgl_lahir_ayah,
            'pekerjaan_ayah' => $pekerjaan_ayah,
            'penghasilan_ayah' => $penghasilan_ayah,
            'pendidikan_ayah' => $pendidikan_ayah,
            'nama_wali' => $nama_wali,
            'tptlahir_wali' => $tempat_lahir_wali,
            'tgllahir_wali' => $tgl_lahir_wali,
            'pekerjaan_wali' => $pekerjaan_wali,
            'pendidikan_wali' => $pendidikan_wali,
            'hubungan_wali' => $hubungan_wali,
            'bhs_digunakan' => $bhs_digunakan,
            'asal_sekolah' => $asal_sekolah,
            'nama_panggilan' => $nama_panggilan,
            'mengenal_hijaiyah' => $hijayah,
            'mengenal_alphabet' => $alphabet,
            'suka_menulis' => $suka_menulis,
            'suka_menggambar' => $suka_gambar,
            'hafalan_alquran' => $suka_hafalan,
            'memiliki_hafalan' => $memiliki_hafalan,
            'senang_bergaul' => $bergaul,
            'membuat_prakarya' => $prakarya,
            'ungkapan_keinginan' => $mengungkapkan,
            'mengikuti_sholat' => $sholat_fardhu,
            'berbicara_baik' => $berbicara_baik,
            'memakai_baju_sendiri' => $baju_sendiri,
            'menyimpan_sepatu' => $simpan_sepatu,
            'membuang_sampah' => $buang_sampah,
            'mengekspresikan' => $ekspresi_marah,
            'melakukan_kesalahan' => $malu_salah,
            'ketergantungan' => $ketergantungan,
            'keinginan' => $merengek,
            'mampu_mandi' => $mandi_sendiri,
            'mampu_sendiri' => $bab_bak_sendiri,
            'menghabiskan_waktu' => $habis_waktu,
            'kelebihan_ananda' => $kelebihan_ananda,
            'orientasi_peserta_didik' => $welcome_ceremony,
            'bersedia_mengikuti_qp' => $quranic_parenting,
            'mengikuti_pertemuan_rutin' => $temu_wali_kelas,
            'menemani_ananda' => $hafalan_rumah,
            'kewirausahaan_ananda' => $wirausaha,
            'kemampuan_komunikasi_aktif_ananda' => $komunikasi,
            'pembiayaan_pendidikan' => $biaya_pendidikan,
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
        $token = env('TOKEN_WABLAS');
        $secret = env('SECRET_WABLAS');
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
