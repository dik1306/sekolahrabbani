@extends('karir.layouts.app')

@section('content')
    <div class="karir">
        <div class="container mt-3">
            <div class="row mt-4">
                @include('karir.admin.sidebar')
                <div class="col-md">
                    <div class="card">
                        <div class="card-body mb-3">
                            <h1 class="text-center">Halo Selamat Datang </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection