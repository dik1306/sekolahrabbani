@extends ('ortu.layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 70vh; background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);">
    <div class="card shadow-lg p-4" style="max-width: 600px; width: 100%;">
        <div class="text-center">
            <!-- Jersey Closed SVG Icon -->
            <svg width="100" height="100" viewBox="0 0 64 64" fill="none" style="margin-bottom: 20px;" xmlns="http://www.w3.org/2000/svg">
                <rect x="8" y="12" width="48" height="40" rx="8" fill="#6366f1"/>
                <path d="M16 12L24 4H40L48 12" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M32 28V44" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                <circle cx="32" cy="36" r="3" fill="#fff"/>
                <line x1="20" y1="44" x2="44" y2="44" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <h2 class="mb-3" style="color: #6366f1;">Pemesanan Jersey Ditutup</h2>
            <p class="lead mb-4" style="color: #374151;">
                Mohon Maaf, pemesanan Jersey sudah ditutup.<br>
                Terimakasih atas antusiasme Ayah/Bunda.<br>
                Nantikan Informasi Selanjutnya.
            </p>
            <a href="{{ route('jersey.index') }}" class="btn btn-primary">Kembali ke Beranda</a>
        </div>
    </div>
</div>
@endsection
