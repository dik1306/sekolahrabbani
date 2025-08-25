@extends ('ortu.layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 70vh; background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);">
    <div class="text-center">
            <!-- Jersey Closed SVG Icon -->
           
            <h2 class="mb-3" style="color: #6366f1;">Pemesanan Jersey Ditutup</h2>
            <p class="lead mb-4" style="color: #374151;">
                Mohon Maaf, pemesanan Jersey ditutup sementara.<br>
                Terimakasih atas antusiasme Ayah/Bunda.<br>
                Nantikan Informasi Selanjutnya.
            </p>
            <a href="{{ route('jersey.index') }}" class="btn btn-primary">Kembali ke Beranda</a>
        </div>
    </div>
</div>
@endsection
