<?php

namespace App\Http\Controllers;

use App\Models\Csdm;
use App\Models\JadwalKontrak;
use App\Models\Karir;
use App\Models\NilaiDiklat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class KarirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('karir.index');
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
     * @param  \App\Models\Karir  $karir
     * @return \Illuminate\Http\Response
     */
    public function show(Karir $karir)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Karir  $karir
     * @return \Illuminate\Http\Response
     */
    public function edit(Karir $karir)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Karir  $karir
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Karir $karir)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Karir  $karir
     * @return \Illuminate\Http\Response
     */
    public function destroy(Karir $karir)
    {
        //
    }

    public function login()
    {
        return view('karir.login');
    }

    public function verifikasi()
    {
        return view('karir.verifikasi');
    }

    public function logout()
    {
        session()->flush();
        Auth::logout();
        return redirect()->route('karir.login');
    }

    public function store_login (Request $request) {

        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'g-recaptcha-response' => 'required|captcha'
        ]);

        $user_csdm = User::where('email', $request->email)->first();

        if ($user_csdm) {
            if (Hash::check($request->password, $user_csdm->password)) {
                $request->session()->regenerate();

                Auth::login($user_csdm);

                return redirect()->route('karir.profile')->with('success', 'Login berhasil');
            } else {
                return redirect()->route('karir.login')->with('error', 'ID atau password salah');
            }
        } else {
            return redirect()->route('karir.login')->with('error', 'ID atau password salah');
        }
    }

    public function store_verifikasi(Request $request) {
        try {
            $request->validate([
                'no_hp' => 'required',
                'email' => 'required',
                'g-recaptcha-response' => 'required|captcha'
            ]);

            $user_csdm = User::where('no_hp', $request->no_hp)
                        ->where('email', $request->email)
                        ->first();

            if ($user_csdm) {
                $message = "Halo $user_csdm->nama Silahkan masuk ke https://karir.sekolahrabbani.sch.id/karir dengan 
        ID : " . $user_csdm->email . "  
        password : " . $user_csdm->kode_csdm . "
                
*Mohon untuk tidak menyebarkan ID dan password ini kepada siapapun. Terima kasih.*";
                $no_wha = $request->no_hp;
                $this->send_notif($message, $no_wha);
                return redirect()->route('karir.login')->with('success', 'Kode verifikasi telah dikirim ke nomor whatsapp anda');
            } else {
                return redirect()->route('karir.verifikasi')->with('error', 'Nomor whatsapp tidak terdaftar');
            }
        } catch (\Throwable $th) {
            return redirect()->route('karir.verifikasi')->with('error', 'Terjadi kesalahan');
        }
    }

    public function profile() {
        $user = Auth::user();

        $user_csdm = User::get_profile_csdm($user->id);
        // dd($user_csdm);
        return view('karir.profile.index', compact('user', 'user_csdm'));
    }

    public function get_nilai($id) {
        $nilai_diklat = NilaiDiklat::where('id_profile_csdm', $id)->first();
        // dd($nilai_diklat);
        return view('karir.profile.nilai', compact('nilai_diklat'));
        
    }

    public function jadwal_kontrak() {
        $jadwal_kontrak = JadwalKontrak::all();
        // dd($jadwal_kontrak);
        return view('karir.profile.jadwal', compact('jadwal_kontrak'));
        
    }

    public function download_nilai($id) {
        $nilaiDiklat = NilaiDiklat::where('id_profile_csdm', $id)->first();
        // dd($nilaiDiklat);
        $file = public_path('storage/'.$nilaiDiklat->file_nilai);
        $file_name = 'hasil-diklat-'.$nilaiDiklat->kode_csdm.'.pdf';
        
        $headers = [
            'Content-Type' => 'application/pdf',
         ];

        return response()->download($file, $file_name, $headers);
    }

    public function download_jadwal() {
        $jadwal_kontrak = JadwalKontrak::where('status', 1)->first();
        // dd($jadwal_kontrak);
        $file = public_path('storage/'.$jadwal_kontrak->file);
        $file_name = 'jadwal-'.$jadwal_kontrak->nama.'.pdf';
        
        $headers = [
            'Content-Type' => 'application/pdf',
         ];

        return response()->download($file, $file_name, $headers);
    }

    public function profile_by_id($id) {
        $user = Auth::user();

        $user_csdm = User::get_profile_csdm($user->id);
        return view('karir.profile.edit', compact('user', 'user_csdm'));
    }

    public function store_profile(Request $request, $id) {

        $user = User::find($id);

        $file = null;
        $file_url = null;
        $path = 'foto_profile';
        if ($request->has('foto_profile')) {
            $file = $request->file('foto_profile')->store($path);
            $file_name = $request->file('foto_profile')->getClientOriginalName();
            $file_url = $path . '/' . $file_name;
            Storage::disk('public')->put($file_url, file_get_contents($request->file('foto_profile')->getRealPath()));
        } else {
            return redirect()->back()->with('failed', 'File tidak boleh kosong');
        }

        if ($user->id_profile_csdm != null) {
            $id_profile_csdm = $user->id_profile_csdm;
            $user_csdm = CSDM::find($id_profile_csdm);

            $user_csdm->update([
                'nama_lengkap' => $request->nama_lengkap,
                'foto_profile' => $file_url,
                'tgl_lahir' => $request->tgl_lahir,
                'tempat_lahir' => $request->tempat_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'posisi_dilamar' => $request->posisi_dilamar,
                'domisili_sekarang' => $request->domisili_sekarang,
            ]);
        } else {
            $store_csdm = Csdm::create([
                 'nama_lengkap' => $request->nama_lengkap,
                 'foto_profile' => $file_url,
                 'tgl_lahir' => $request->tgl_lahir,
                 'tempat_lahir' => $request->tempat_lahir,
                 'jenis_kelamin' => $request->jenis_kelamin,
                 'posisi_dilamar' => $request->posisi_dilamar,
                 'domisili_sekarang' => $request->domisili_sekarang,
             ]);
     
             $user->id_profile_csdm = $store_csdm->id;
             $user->save();
            
        }


        return redirect()->route('karir.profile')->with('success', 'Data berhasil diubah');

    }

    public function edit_profile (Request $request, $id) {
        try {
    
            $user = User::find($id);
            $id_csdm = $user->id_csdm;
            $user_csdm = CSDM::find($id_csdm);

            $user_csdm->update($request->all());
            // dd($user);
    
            // $update_csdm = Csdm::where('id_csdm', $id_csdm)->update([
            //     'nama_lengkap' => $request->nama,
            //     'foto_profile' => $request->foto_profile,
            //     'tgl_lahir' => $request->tgl_lahir,
            //     'tempat_lahir' => $request->tempat_lahir,
            //     'jenis_kelamin' => $request->jenis_kelamin,
            //     'posisi_dilamar' => $request->posisi_dilamar,
            //     'domisili_sekarang' => $request->domisili_sekarang,
            // ]);
    
            return redirect()->route('karir.profile')->with('success', 'Data berhasil diubah');
        } catch (\Throwable $th) {
            throw $th;
        }
        
    }

    public function admin() {
        return view('karir.admin.index');
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
        // curl_setopt($curl, CURLOPT_URL, "https://tx.wablas.com/api/v2/send-bulk/text");
        curl_setopt($curl, CURLOPT_URL, "https://pati.wablas.com/api/v2/send-message");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);
    
        // echo "<pre>";
        return ($result);
    }

}
