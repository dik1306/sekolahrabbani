@extends('layouts.app')

@section('content')
    <div class="">
        <img class="banner-2" src="{{ asset('assets/images/home_rabbani_school-2.png') }}" alt="banner">
        <div class="centered text-white">
            <h1> Tanya Kami </h1>
        </div>
    </div>
    <div>
        <img src="{{ asset('assets/images/awan1.png') }}" class="cloud-hms"  alt="cloud">
        <img src="{{ asset('assets/images/awan2.png') }}" class="cloud-hms2"  alt="cloud">
    </div>
    <div class="container" style="position: relative; z-index:1000">
        <div class="row">
            <div class="col-md-6">
                <h6 class="mt-1" style="color: #ED145B">Tanya Kami</h6>
                <h4 class="mb-3">Formulir Pertanyaan</h4>
                <span class="small"> Mohon Pertanyaan tidak mengandung unsur SARA terimakasih </span>
                <div class="form-group mt-4">
                    <input class="form-control" id="nama" name="nama" placeholder="Nama Ayah/Bunda">
                </div>
                <div class="form-group mt-4">
                    <input class="form-control" id="email" name="email" placeholder="Email Ayah/Bunda">
                </div>
                <div class="form-group mt-4">
                    <input class="form-control" id="kelas" name="kelas" placeholder="Kelas">
                </div>
                <div class="form-group mt-4">
                    <input class="form-control" id="no_hp" name="no_hp" placeholder="No Handphone">
                </div>
                <div class="form-group mt-4">
                    <textarea class="form-control" id="pesan" name="pesan" placeholder="Tulis Pesan"> </textarea>
                </div>
                <div class="mt-3 center">
                    <button type="submit" class="btn btn-primary"> Kirim Pesan </button>
                </div>
            </div>
            <div class="col-md-6 center">
                <img src="{{ asset('assets/images/icon_formulir.png') }}" width="50%" alt="icon form">
            </div>
        </div>
    </div>
                
@endsection