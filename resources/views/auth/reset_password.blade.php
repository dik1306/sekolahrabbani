@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buka QLP Mobile</title>
</head>
<body>
  <h2>Sedang mencoba membuka aplikasi QLP Mobile...</h2>
  <a id="openAppBtn">📱 Buka QLP Mobile</a>

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
      }
    });
  </script>
</body>
</html>
@endsection
