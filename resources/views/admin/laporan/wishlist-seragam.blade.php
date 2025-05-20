@extends('admin.layouts.app')

@section('content')
    <div class="iq-navbar-header">
        <div style="position: absolute; z-index:-1; top:0; height: 263px">
            <img src="{{asset('assets/images/top-header.png')}} " alt="header" class="theme-color-default-img img-fluid w-100 h-100">
        </div>
        <div class="title my-3">
            <h1 class="text-white" style="margin-left: 1rem">Daftar Wishlist Seragam </h1>
        </div>
    </div>
    <div class="container iq-container px-3">
        
        <div class="card">
            <div class="card-body">
                <div class="d-flex" style="justify-content: flex-end">
                    <form action="{{route('export_wishlist')}}" method="GET" >
                        <button type="submit" class="btn btn-success btn-sm" > Export Excel </button> 
                    </form>
                </div>
                <div class="table-responsive mt-3">
                    <table id="wishlist_seragam" class="table table-striped" data-toggle="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Seragam</th>
                                <th>Kode Produk</th>
                                <th>Jenis</th>
                                <th>Ukuran</th>
                                <th>Quantity</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($wishlist as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$item->nama_produk}}</td>
                                    <td>{{$item->kode_produk}}</td>
                                    <td>{{$item->jenis_produk}}</td>
                                    <td>{{$item->ukuran}}</td>
                                    <td>{{$item->quantity}}</td>
                                    <td>{{date_format($item->created_at, 'Y-m-d H:i:s')}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
@endsection

