@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <div class="alert alert-info" role="alert">
        <h4 class="alert-heading">Sedang mencoba membuka aplikasi QLP Mobile...</h4>
        <p>Jika aplikasi tidak terbuka otomatis, Anda bisa klik tombol di bawah ini untuk membuka QLP Mobile.</p>
        
        <!-- Core button for app redirection -->
        <a id="openAppBtn" class="btn btn-primary">📱 Buka QLP Mobile</a>
    </div>

    <!-- Optional: Additional animation with Javascript -->
    <div class="mt-4">
        <div class="animate__animated animate__fadeIn">
            <p class="lead fade-in-text">Kami tunggu kedatangan Ayah/Bunda pada kesempatan berikutnya!</p>
        </div>
    </div>
</div>

<!-- Javascript for additional animation and functionality -->
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

@endsection

<!-- Add necessary CSS for smooth animations -->
<style>
    .btn-primary {
        padding: 15px 30px;
        font-size: 1.2rem;
        text-decoration: none;
        border-radius: 50px;
        transition: transform 0.3s ease, background-color 0.3s ease;
    }

    .btn-primary:hover {
        transform: scale(1.1);
        background-color: #0056b3;
    }

    .fade-in-text {
        opacity: 0;
        animation: fadeInUp 1.5s forwards;
        animation-delay: 0.5s;
    }

    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes zoomIn {
        0% {
            transform: scale(0.3);
        }
        100% {
            transform: scale(1);
        }
    }
</style>
