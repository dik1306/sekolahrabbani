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
                                <h3 >Data Diri</h3>
                                <a href="{{route('karir.profile_by_id', $user->id)}}" class="btn btn-primary" style="margin-left: auto">Edit Profile</a>
                            </div>
                            <div class="avatar">
                                @if ($user->csdm && $user->csdm->foto_profile)
                                    <img src="{{ asset('storage/'.$user->csdm->foto_profile) }}" alt="avatar" class="img-thumbnail" width="100">
                                @else 
                                    <div class="foto-profile">
                                        <p class="center">Foto Profile</p>
                                        <p style="font-size:10px">*Gunakan latar berwarna merah</p>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group row my-4">
                                <label for="nama" class="col-sm-2">Nama</label>
                                <div class="col-sm-8">: {{$user->csdm != null ? $user->csdm->nama_lengkap : $user->name}} </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label for="email" class="col-sm-2">Email</label>
                                <div class="col-sm-8">: {{$user->email}} </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label for ="jenis_kelamin" class="col-sm-2">Jenis Kelamin</label>
                                <div class="col-sm-8">: {{$user->csdm != null ? $user->csdm->jenis_kelamin : ''}} </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label for ="tempat_lahir" class="col-sm-2">Tempat Lahir</label>
                                <div class="col-sm-8">: {{$user->csdm != null ? $user->csdm->tempat_lahir :''}} </div>

                            </div>
                            <div class="form-group row mb-4">
                                <label for ="tgl_lahir" class="col-sm-2">Tanggal Lahir</label>
                                <div class="col-sm-8">: {{$user->csdm != null ? $user->csdm->tgl_lahir : ''}}</div>
                            </div>
                            <div class="form-group row mb-4">
                                <label for ="posisi_dilamar" class="col-sm-2">Posisi Dilamar</label>
                                <div class="col-sm-8">: {{$user->csdm != null ? $user->csdm->posisi_dilamar : ''}} </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label for ="domisili_saat_ini" class="col-sm-2">Domisili Saat Ini</label>
                                <div class="col-sm-8">: {{$user->csdm != null ? $user->csdm->domisili_sekarang : ''}} </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection