@extends('karir.layouts.app')

@section('content')
    <div class="karir">
        <div class="container mt-3">
            <div class="row mt-4">
                @include('karir.profile.sidebar')
                <div class="col-md">
                    <div class="card">
                        <div class="card-body mb-3">
                            <div class="d-flex">
                                <h3 >Hasil Nilai</h3>
                            </div>
                            @if ($nilai_diklat == null)
                            <p> Anda Belum Memiliki Hasil Penilaian, Silahkan Hubungi Tim HCD </p>
                            @else 
                            <p> Lihat Disini: <a href="{{route('download_nilai', $nilai_diklat->id_profile_csdm)}}" target="_blank"> Hasil Diklat - {{$nilai_diklat->kode_csdm}} </a> </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection