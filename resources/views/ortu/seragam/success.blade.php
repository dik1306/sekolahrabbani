@extends ('ortu.layouts.app')

@section('content')
    <div class="top-navigate sticky-top">
        <div class="d-flex" style="justify-content: stretch; width: 100%;">
            <a href="{{route('seragam')}}" style="text-decoration: none; color: black">
                <i class="fa-solid fa-arrow-left fa-lg"></i>
            </a>
        </div>
        <div class="center">
            <img src="{{asset('assets/images/icon-success.png')}}" alt="success" class="mt-3" width="45%">
            <h6 class="my-3">Terimakasih telah melakukan pembayaran. <br> Pesanan Anda akan kami segera proses</h6>
        </div>
        <div class="d-flex justify-content-center">
            <a href="{{route('seragam')}}" style="text-decoration: none" > <button class="btn btn-primary btn-sm mx-2 px-3"> Home </button> </a>
            <a href="{{route('seragam.history')}}" style="text-decoration: none" > <button class="btn btn-purple btn-sm px-3"> Cek Pesanan </button> </a>
        </div>
    </div>
@endsection