<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('auth.login_v2');
    }

    public function list_user()
    {
        $list_user = User::select('users.*', 'role.name as role_name')
                        ->leftJoin('role', 'users.id_role', 'role.id')->get();
        $list_role = Role::all();
        // dd($list_user);
        return view('admin.master.index', compact('list_user', 'list_role'));
    }

    public function add_user(Request $request)
    {
        $no_hp = $request->no_hp;
        $nama_lengkap = $request->nama_lengkap;
        $email = $request->email;
        $id_role = $request->id_role;
        $pass = $this->rand_pass(8);

        $create = User::create([
            'name' => $nama_lengkap,
            'no_hp' => $no_hp,
            'email' => $email,
            'password' => Hash::make($pass),
            'id_role' => $id_role,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $get_user = User::where('no_hp', $no_hp)->first();

        Profile::create([
            'pass_akun' => $pass,
            'user_id' => $get_user->id,
            'no_hp_ibu' => $no_hp,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('success', 'berhasil menambah user');

    }

    public function get_user_api()
    {
        $client = new Client();
        $api_ortu = "http://103.135.214.11:81/qlp_system/api_pos/api_data_ortu_siswa_aktif.php?pass=aun64268ubstun4w8nw6busrhbumunfjbuwr868w6aynerysteum7timt";
        $api_siswa = "http://103.135.214.11:81/qlp_system/api_pos/api_data_siswa_aktif.php?pass=aun64268ubstun4w8nw6busrhbumunfjbuwr868w6aynerysteum7timt";

        try {
            $response_ortu = $client->get($api_ortu);

            $data = json_decode($response_ortu->getBody(), true);

            $list_ortu = $data['userApi'];

            //data siswa
            $response_siswa = $client->get($api_siswa);

            $data = json_decode($response_siswa->getBody(), true);

            $list_siswa = $data['userApi'];

            // return response($list_siswa);

            foreach ($list_siswa as $item) {
                $nis = $item['nis'];
                $nama_siswa = $item['nama_siswa'];
                $id_lokasi = $item['id_lokasi'];
                $id_sekolah = $item['id_sekolah'];
                $id_jenjang = $item['id_jenjang'];
                $nama_kelas = $item['nama_kelas'];
                $tahun_masuk = $item['tahun_masuk'];
                $nohp_ibu_siswa = $item['nohp_ibu'];
                $nohp_ayah_siswa = $item['nohp_ayah'];

                // $userId = User::select('id')->where('no_hp', $nohp_ibu_siswa)->where('no_hp_2', $nohp_ayah_siswa)->first();

                // create profile
                Profile::create([
                    'nis' => $nis,
                    'nama_lengkap' => $nama_siswa,
                    'tahun_masuk' => $tahun_masuk,
                    'nama_kelas' => $nama_kelas,
                    'sekolah_id' => $id_sekolah,
                    'jenjang_id' => $id_jenjang,
                    'no_hp_ibu' => $nohp_ibu_siswa,
                    'no_hp_ayah' => $nohp_ayah_siswa,
                    // 'user_id' => $userId->id,
                    // 'pass_akun' => $pass
                ]);
            }

            foreach ($list_ortu as $item) {
               
                $nama_ibu = $item['nama_ibu'];
                $nohp_ibu = $item['nohp_ibu'];
                $nohp_ayah = $item['nohp_ayah'];
                $pass = $this->rand_pass(8);

                // create user
                User::create([
                    'name' => $nama_ibu,
                    'no_hp' => $nohp_ibu,
                    'no_hp_2' => $nohp_ayah,
                    'password' => Hash::make($pass),
                    'id_role' => 5,
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                //find id
                $userId = User::select('id')->where('no_hp', $nohp_ibu)->where('no_hp_2', $nohp_ayah)->first();

                $profiles = Profile::where('no_hp_ibu', $nohp_ibu)->where('no_hp_ayah', $nohp_ayah)->get();

                foreach ($profiles as $profile) {
                    $update_profile = Profile::where('no_hp_ibu', $profile->no_hp_ibu)->where('no_hp_ayah', $profile->no_hp_ayah)->first();

                    $update_profile->update([
                        'pass_akun' => $pass,
                        'user_id' => $userId->id
                    ]);
                }
            }

            return redirect()->back()->with('success', 'berhasil menambah user');


        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function get_guru_api()
    {
        $client = new Client();
        $api_guru = "http://103.135.214.11:81/qlp_system/api_pos/api_data_guru_aktif.php?pass=aun64268ubstun4w8nw6busrhbumunfjbuwr868w6aynerysteum7tim8";

        try {
            $response_ortu = $client->get($api_guru);

            $data = json_decode($response_ortu->getBody(), true);

            $list_guru = $data['guruApi'];
            // return response($list_siswa);

            foreach ($list_guru as $item) {
                $nik = $item['nik'];
                $nama_guru = $item['nama_guru'];
                $lokasi = $item['lokasi'];
                $password = $item['password'];
                $nohp = $item['nohp'];

                  // create user
                User::create([
                    'name' => $nama_guru,
                    'no_hp' => $nik,
                    'no_hp_2' => $nohp,
                    'password' => Hash::make($password),
                    'id_role' => 4,
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                // create profile
                Profile::create([
                    'nik' => $nik,
                    'nama_lengkap' => $nama_guru,
                    'sekolah_id' => $lokasi,
                    'no_hp_ibu' => $nohp,
                    'pass_akun' => $password
                ]);
            }

            return redirect()->back()->with('success', 'berhasil menambah user');


        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function customLogin(Request $request)
    {
        try {
            $request->validate([
                'no_hp' => 'required',
                'password' => 'required',
            ]);


            $user  = User::where('no_hp', $request->no_hp)
                        ->orWhere('no_hp_2', $request->no_hp)                
                        ->first();

            if ($user->id_role == 1 || $user->id_role == 2 ) {
                if (Hash::check($request->password, $user->password)) {
                    $request->session()->regenerate();

                    Auth::login($user);

                    return redirect()->route('list-seragam');
                } else {
                    return redirect()->route('login')->with('error', 'No Hp atau password salah');
                }
            } else if ($user->id_role == 4 || $user->id_role == 6) {
                if (Hash::check($request->password, $user->password)) {
                    $request->session()->regenerate();

                    Auth::login($user);

                    return redirect()->route('master.palestine');
                } else {
                    return redirect()->route('login')->with('error', 'No Hp atau password salah');
                }
            } else {
                if (Hash::check($request->password, $user->password)) {
                    $request->session()->regenerate();

                    Auth::login($user);

                    return redirect()->route('dashboard');
                } else {
                    return redirect()->route('login')->with('error', 'No Hp atau password salah');
                }
            }

            return redirect("login")->with('error', 'Login details are not valid');
        } catch (\Exception $th) {
            // dd($th);
            return redirect("login")->withError($th->getMessage());
        }
    }

    public function register()
    {
        return view('auth.register');
    }

    public function customRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            // 'role' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $check = $this->create($data);
        // dd($check);

        return redirect("login")->withSuccess('You have signed-in');
    }

    public function create(array $data)
    {
        try {
            return User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                // 'id_role' => $data['role'],
            ]);
        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function home()
    {
        if (Auth::check()) {
            return view('index');
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function logout()
    {
        session()->flush();
        Auth::logout();
        return Redirect('login');
    }

    public function verifikasi()
    {
        return view('auth.verifikasi');
    }

    public function store_verifikasi(Request $request) {
        try {
            $request->validate([
                'no_hp' => 'required'
            ]);

            $get_pass = Profile::where('no_hp_ibu', $request->no_hp)
                            ->orWhere('no_hp_ayah', $request->no_hp)
                            ->where('pass_akun', '!=', null)
                            ->first();

            $user = User::where('no_hp', $request->no_hp)
                        ->orWhere('no_hp_2', $request->no_hp)
                        ->first();

            if ($user) {
                $message = "
Password anda adalah: 
*$get_pass->pass_akun*

Silahkan masuk ke 
https://sekolahrabbani.sch.id/login

*Mohon untuk tidak menyebarkan password ini kepada siapapun.*
*Terima kasih.*
                ";
                $no_wha = $request->no_hp;

                $this->send_notif($message, $no_wha);
                return redirect()->route('login')->with('success', 'Kode verifikasi telah dikirim ke nomor whatsapp anda');

            } else {
                return redirect()->route('verifikasi')->with('error', 'Nomor whatsapp tidak terdaftar');
            }
        } catch (\Throwable $th) {
            return redirect()->route('verifikasi')->with('error', 'Terjadi kesalahan');
        }
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
    
        return ($result);
    }
    
    public function send_notif_test(Request $request) {
        $message = $request->input('message');
        $no_wha = $request->input('no_wha');
        // $auth = $request->input('auth');

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

        // Return a JSON response
        return response()->json([
            'status' => 'success',  // Or 'failed' depending on the result of $result
            'message' => $result
        ]);
    }


    function rand_pass($length) {
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            return substr(str_shuffle($chars),0,$length);

    }
}
