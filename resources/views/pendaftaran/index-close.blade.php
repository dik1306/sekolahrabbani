@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <div class="alert alert-info" role="alert">
        <img id="trial-class-illustration" src="{{ asset('assets/images/_other_assets/trial_class_close_ilustrasi.png') }}" alt="Ilustrasi Trial Class" class="img-fluid illustration-animation" style="max-width: 20%;" />
                
        <h4 class="alert-heading">Pendaftaran Sekolah Rabbani Ditutup Sementara</h4>
        <p>Terima kasih atas antusiasme Ayah/Bunda terhadap Pendaftaran Sekolah Rabbani.</p>
        <p>Saat ini, pendaftaran kami tutup sementara untuk semua unit/cabang. </p>
        <p>Saat ini kami sedang mempersiapkan Alur SPMB yang disesuaikan, hal ini dilakukan agar kami dapat mempersiapkan pengalaman terbaik bagi calon peserta.</p>
        <p>Silakan cek secara berkala Website Sekolah Rabbani untuk mengetahui pembukaan pendaftaran kembali.</p>
        <p>Terima kasih atas pengertian dan dukungannya Ayah/Bunda.</p>
    </div>



    <!-- Optional: Additional animation with Javascript -->
    <div class="mt-4">
        <div class="animate__animated animate__fadeIn">
            <p class="lead fade-in-text">Kami tunggu kedatangan Ayah/Bunda pada kesempatan berikutnya!</p>
        </div>
    </div>
</div>

<!-- Javascript for additional animation -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const illustration = document.getElementById("trial-class-illustration");

        // Animate the image on load with a zoom effect
        illustration.classList.add("animate__animated", "animate__zoomIn");

        // Add text fade-in animation after the illustration
        setTimeout(function() {
            const fadeInText = document.querySelectorAll('.fade-in-text');
            fadeInText.forEach((text, index) => {
                setTimeout(() => {
                    text.classList.add('animate__animated', 'animate__fadeInUp');
                }, index * 500);
            });
        }, 500);
    });
</script>

@endsection

<!-- Add necessary CSS for smooth animations -->
<style>
    .illustration-animation {
        width: 70%; /* Adjust the size of the image */
        opacity: 0;
        transition: opacity 2s ease-in-out;
        animation: zoomIn 1s ease-out; /* Zoom effect */
    }

    .illustration-animation.animate__zoomIn {
        opacity: 1;
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
