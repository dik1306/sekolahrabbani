@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buka QLP Mobile</title>

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    body, html {
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      background: linear-gradient(to bottom, #00c6ff, #0072ff);
      color: #fff;
      text-align: center;
      font-size: 16px;
      overflow: hidden;
    }

    h2 {
      font-size: 2rem;
      margin-bottom: 20px;
      opacity: 0;
      animation: fadeIn 2s forwards;
    }

    #openAppBtn {
      display: inline-block;
      margin-top: 20px;
      padding: 15px 30px;
      background-color: #fff;
      color: #0072ff;
      border-radius: 50px;
      font-size: 1.2rem;
      text-decoration: none;
      transition: transform 0.3s ease, background-color 0.3s ease;
    }

    #openAppBtn:hover {
      transform: scale(1.1);
      background-color: #0072ff;
      color: #fff;
    }

    @keyframes fadeIn {
      0% {
        opacity: 0;
        transform: translateY(-20px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .button-wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      animation: fadeIn 2s forwards;
    }

    .fallback-message {
      font-size: 1rem;
      margin-top: 15px;
      opacity: 0;
      animation: fadeIn 3s forwards;
    }

  </style>
</head>
<body>
  <div class="button-wrapper">
    <h2>Sedang mencoba membuka aplikasi QLP Mobile...</h2>
    <a id="openAppBtn">📱 Buka QLP Mobile</a>
    <p class="fallback-message" id="fallbackMessage"></p>
  </div>

  <script>
    function getUrlParameter(name) {
      const urlParams = new URLSearchParams(window.location.search);
      return urlParams.get(name);
    }

    function getStoreLink() {
      const ua = navigator.userAgent || navigator.vendor || window.opera;
      if (/android/i.test(ua)) {
        return "https://play.google.com/store/apps/details?id=com.schrabbani.qlp";
      }
      if (/iPad|iPhone|iPod/.test(ua) && !window.MSStream) {
        return "https://apps.apple.com/id/app/qlp-mobile/id6749219689?=id";
      }
      return "https://sekolahrabbani.sch.id"; // fallback web kalau bukan Android/iOS
    }

    document.addEventListener("DOMContentLoaded", () => {
      const token = "{{ $token }}";  // Get the token from Laravel's passed data
      const openAppBtn = document.getElementById("openAppBtn");
      const fallbackMessage = document.getElementById("fallbackMessage");

      if (token) {
        const deepLink = `qlpmobile://reset-password?token=${token}`;

        // tombol manual
        openAppBtn.href = deepLink;

        // auto-open aplikasi
        setTimeout(() => {
          window.location.href = deepLink;
        }, 500);

        // fallback ke store setelah 2 detik kalau app gagal terbuka
        setTimeout(() => {
          if (!document.hidden) {
            window.location.href = getStoreLink();
          }
        }, 2000);

      } else {
        openAppBtn.textContent = "Token tidak valid";
        openAppBtn.removeAttribute("href");
        fallbackMessage.textContent = "Tidak dapat membuka aplikasi. Silakan coba lagi.";
      }
    });
  </script>
</body>
</html>
@endsection
