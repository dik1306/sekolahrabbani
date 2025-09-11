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
