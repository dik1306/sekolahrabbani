@extends('admin.layouts.app')

@section('content')
    <div class="iq-navbar-header">
        <div style="position: absolute; z-index:-1; top:0; height: 263px">
            <img src="{{asset('assets/images/top-header.png')}} " alt="header" class="theme-color-default-img img-fluid w-100 h-100">
        </div>
        <div class="title my-3">
            <h1 class="text-white" style="margin-left: 1rem">List Sudah Nonton Edukasi Qurban </h1>
        </div>
    </div>
    <div class="container iq-container px-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex" style="justify-content: flex-end">
                    <form action="{{route('export-sudahnonton-qurban')}}" method="GET" ><button class="btn btn-success btn-sm" > Export Excel </button> </form>
                </div>
                <div class="table-responsive mt-3">
                    <table id="list_seragam" class="table table-striped" data-toggle="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nis </th>
                                <th>Nama</th>
                                <th>Sekolah</th>
                                <th>Kelas</th>
                                <th>Materi sudah baca</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($haveWatch as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$item->nis}}</td>
                                    <td>{{$item->nama_lengkap}} </td>
                                    <td>{{$item->lokasi}}</td>
                                    <td>{{$item->nama_kelas}}</td>
                                    <td>{{$item->judul}}</td>
                                    <td>{{$item->created_at}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection