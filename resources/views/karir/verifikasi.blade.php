@extends('layouts.app')

@section('content')
    <div class="karir">
        <div class="container">
            <div class="my-5">
                <div class="card shadow center" style="width: 350px">
                    <div class="card-header">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="logo" height="60px">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title my-4">Verifikasi Akun</h5>
                        <form action="{{ route('karir.store_verifikasi') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <input type="text" class="form-control" id="email" name="email" placeholder="email">
                            </div>
                            <div class="mb-3">
                                <input type="no_hp" class="form-control" id="no_hp" name="no_hp" placeholder="no_hp">
                            </div>
                            <div class="mb-3">
                                {!! NoCaptcha::renderJs() !!}
                                {!! NoCaptcha::display() !!}
                            </div>
                            <button type="submit" class="btn btn-primary">Verifikasi</button>
                        </form>
                    </div>
                    <div class="card-footer">
                        <p> Sudah punya akun? <a href="{{route('karir.login')}}">Login disini</a></p>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
        </div>
    </div>
@endsection