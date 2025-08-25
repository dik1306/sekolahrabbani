@extends ('ortu.layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="text-center">
        <!-- Jersey Closed SVG Icon -->
        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" class="mb-4">
            <path d="M4 4L8 2L12 4L16 2L20 4V8C20 12 18 20 12 20C6 20 4 12 4 8V4Z" stroke="#6366f1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <line x1="4" y1="8" x2="20" y2="8" stroke="#6366f1" stroke-width="2" stroke-linecap="round"/>
            <line x1="9" y1="12" x2="15" y2="12" stroke="#6366f1" stroke-width="2" stroke-linecap="round"/>
            <line x1="12" y1="8" x2="12" y2="20" stroke="#6366f1" stroke-width="2" stroke-linecap="round"/>
        </svg>
        <h2 class="mb-3" style="color: #6366f1; font-weight: bold;">Pemesanan Jersey Ditutup</h2>
        <p class="lead mb-4" style="color: #374151;">
            Mohon Maaf, pemesanan Jersey ditutup sementara.<br>
            Terimakasih atas antusiasme Ayah/Bunda.<br>
            <span style="color: #6366f1; font-weight: 500;">Nantikan Informasi Selanjutnya.</span>
        </p>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-primary px-4 py-2" style="border-radius: 25px;">
            <i class="bi bi-arrow-left"></i> Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
