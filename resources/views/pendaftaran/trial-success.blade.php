@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="center my-3">
            <h3 style="color: #704996">Pendaftaran Trial Class Berhasil !</h3>
        </div>
        <div class="row mt-5">
            <div class="col-md-6">
                <img src="{{ asset('assets/images/Siswa.png') }}" alt="siswa" class="img-fluid center" width="480">
            </div>
            <div class="col-md-6 d-flex justify-content-center" style="align-items: center">
                <div class="title center">
                    <h3 >Terimakasih Ayah/Bunda</h3>
                    <p >Kami akan menghubungi Ayah/Bunda dalam waktu 3 hari terkait dengan pelaksanaan Trial Class.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@endsection
