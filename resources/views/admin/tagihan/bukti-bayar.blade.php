@extends('admin.layouts.app')

@section('content')
    <div class="iq-navbar-header">
        <div style="position: absolute; z-index:-1; top:0; height: 263px">
            <img src="{{asset('assets/images/top-header.png')}} " alt="header" class="theme-color-default-img img-fluid w-100 h-100">
        </div>
        <div class="title my-3">
            <h1 class="text-white" style="margin-left: 1rem">Bukti Bayar </h1>
        </div>
    </div>
    <div class="container iq-container px-3">
        <div class="card">
            <div class="card-header card-header-lg">
                <header>Bukti Pembayaran</header>
                <div class="row">
                    <div class="col-lg-6 company-info">
                        <h6><img src="{{asset('assets/images/logo_sekolah_rabbani.png')}}" alt="logo-sekolah" style="width: 30px;">{{$profil_sekolah[0]->nama_sekolah}}</h6>
                        <p>www.sekolahrabbani.sch.id</p>
                        <small>{{$profil_sekolah[0]->alamat}} </small>
                        <p>Telepon : {{$profil_sekolah[0]->no_telp}}</p>
                    </div>
                    <div class="col-lg-6 clearfix invoice-info">
                        <div style="text-align: right">
                            <h6>#{{$grup_data[0]->no_penerimaan}}</h6>
                            <p>Telah diterima dari</p>
                            <h6>{{$grup_data[0]->nama_lengkap}} ({{$grup_data[0]->nis}}) </h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection