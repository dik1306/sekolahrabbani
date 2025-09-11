<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    // Fungsi untuk mengirim pesan melalui API
    public function sendNotif(Request $request)
    {
        // Mengambil data dari request POST
        $message = $request->input('message');
        $no_wa = $request->input('no_wa');
        $pass = $request->input('pass');

        // Pass yang benar
        $correctPass = 'Ysoc5c0JpX8LiOTz7tvq0m13';

        // Memeriksa apakah pass yang dikirimkan sesuai
        if ($pass !== $correctPass) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pass tidak valid. Tidak bisa kirim WA.'
            ], 400);
        }

        // Jika pass valid, lanjutkan mengirim pesan
        $result = $this->sendNotifApi($message, $no_wa);
        
        // Mengembalikan hasil API
        return response()->json([
            'status' => 'success',
            'message' => 'Pesan berhasil dikirim.',
            'result' => $result
        ]);
    }

    // Fungsi untuk verifikasi
    public function storeVerifikasi(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'no_hp' => 'required'
            ]);

            // Mencari data password berdasarkan no_hp ibu atau ayah
            $get_pass = Profile::where('no_hp_ibu', $request->no_hp)
                ->orWhere('no_hp_ayah', $request->no_hp)
                ->whereNotNull('pass_akun')
                ->first();

            // Mencari user berdasarkan no_hp
            $user = User::where('no_hp', $request->no_hp)
                ->orWhere('no_hp_2', $request->no_hp)
                ->first();

            // Jika user ditemukan, kirim pesan
            if ($user && $get_pass) {
                $message = "
Password anda adalah: 
*$get_pass->pass_akun*

Silahkan masuk ke 
https://sekolahrabbani.sch.id/login atau menggunakan QLP Mobile

*Mohon untuk tidak menyebarkan password ini kepada siapapun.* 
*Terima kasih.*
                ";

                $no_wha = $request->no_hp;

                // Fungsi untuk mengirim pesan
                $this->sendNotifApi($message, $no_wha);

                // Mengirimkan response sukses
                return response()->json([
                    'status' => 'success',
                    'message' => 'Kode verifikasi telah dikirim ke nomor whatsapp anda'
                ]);
            } else {
                // Jika user tidak ditemukan
                return response()->json([
                    'status' => 'error',
                    'message' => 'Nomor whatsapp tidak terdaftar'
                ], 400);
            }
        } catch (\Throwable $th) {
            // Menangani kesalahan
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan'
            ], 500);
        }
    }

    // Fungsi untuk mengirim pesan menggunakan curl
    private function sendNotifApi($message, $no_wa)
    {
        $curl = curl_init();
        $token = config('wablas.token_wablas');
        $secret = config('wablas.secret_wablas');
        $auth = $token . '.' . $secret;

        $payload = [
            "data" => [
                [
                    'phone' => $no_wa,
                    'message' => $message,
                ]
            ]
        ];

        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Authorization: $auth",
            "Content-Type: application/json"
        ]);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($curl, CURLOPT_URL, "https://pati.wablas.com/api/v2/send-message");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }
}
