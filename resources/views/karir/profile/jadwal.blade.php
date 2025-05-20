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
                                <h3 >Jadwal Kontrak</h3>
                            </div>                          
                            <p> Lihat Disini: <a href="{{route('download_jadwal')}}" target="_blank"> Jadwal Kontrak </a> </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection