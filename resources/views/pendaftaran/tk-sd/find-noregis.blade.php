@extends('layouts.app')

@section ('content')
    <div class="">
        <img class="banner-2" src="{{ asset('assets/images/home_rabbani_school-2.png') }}" alt="banner">
        {{-- <div class="centered text-white">
            <h1> Formulir Pemenuhan Data </h1>
        </div> --}}
    </div>
    {{-- <div>
        <img src="{{ asset('assets/images/awan1.png') }}" class="cloud-pmnh"  alt="cloud">
        <img src="{{ asset('assets/images/awan2.png') }}" class="cloud-pmnhn"  alt="cloud">
    </div> --}}
    <div class="container" style="position: relative; z-index:1000">
        <div class="row mx-auto">
            <div class="col-md">
                <h6 class="mt-1" style="color: #ED145B">Pemenuhan Data</h6>
                <h4 class="mb-3">Data Calon Siswa</h4>
                <form action="{{route('form.update')}}"  method="GET">
                    <div class="form-group">
                    <div class="d-flex">
                        <input type="text" name="no_registrasi" id="no_registrasi" class="form-control form-control-sm px-3" aria-label=".form-control-sm px-3 example" placeholder="Masukkan No Registrasi/Pendaftaran">
                        <button type="submit" class="btn btn-primary mx-3"> Cari </button>
                    </div>
                    </div>
                    <small> Lupa No Registrasi/Pendaftaran ? <a href="#" data-bs-toggle="modal" data-bs-target="#lupa_no_regis"> Klik Disini </a> </small>
                </form>
            </div>
        </div>
    </div>
@endsection

<div class="modal fade" id="lupa_no_regis" tabindex="-1" role="dialog" aria-labelledby="lupa_regis" aria-hidden="true">
    <div class="modal-dialog">
        <form role="form" method="POST" action="{{route('forget_no_regis')}}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lupa_regis">Lupa No Pendaftaran / Registrasi</h5>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Masukkan No HP Anda</label>
                        <input type="text" name="no_hp" class="form-control form-control-sm px-3" placeholder="08xx"  >
                    </div>
                    <div class="form-group mt-2">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control form-control-sm px-3" placeholder="Masukkan Nama Anak Anda"  >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm my-4 px-3 text-white">Kirim</button>
                    <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form> 
    </div>
</div>