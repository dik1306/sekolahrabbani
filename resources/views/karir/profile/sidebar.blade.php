<div class="col-md-2">
    <div class="card">
        <div class="card-body">
            <nav class="nav nav-menu">
                <a class="nav-link" href="{{route('karir.profile')}}">Data Diri</a>
                {{-- <a class="nav-link" href="#">Notifikasi</a> --}}
                @if (auth()->user()->id_profile_csdm != null)
                <a class="nav-link" href="{{route('karir.nilai', auth()->user()->id_profile_csdm)}}">Hasil Penilaian Diklat</a>
                @else
                <a class="nav-link" href="#">Hasil Penilaian Diklat</a>
                @endif
                <a class="nav-link" href="{{route('karir.jadwal')}}">Jadwal Kontrak [Setelah Lulus]</a>
            </nav>
        </div>
    </div>
</div>