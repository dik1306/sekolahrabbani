@extends('karir.layouts.app')

@section('content')
    <div class="karir">
        <div class="container mt-3">
            <div class="row mt-4">
                <div class="col-md-2">
                    <div class="card">
                        <div class="card-body">
                            <nav class="nav flex-column nav-menu">
                               @foreach ($kelasDiklat as $item)
                                    <a class="nav-link" href="{{route('karir.kelas_pertemuan', $item->id)}}">Pertemuan {{$item->pertemuan}}</a>
                               @endforeach
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="card">
                        <div class="card-body mb-3">
                            <h3>Halo Selamat Datang {{auth()->user()->name}}! 👋 </h3>
                            <p class="mt-3"> <i class="fa-solid fa-arrow-left"></i> Silahkan pilih kelas pertemuan terlebih dahulu</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection