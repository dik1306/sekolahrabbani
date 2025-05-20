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
                        <h5 class="card-title my-4">SIR YRA</h5>
                        <form action="{{ route('karir.login') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <input type="text" class="form-control" id="email" name="email" placeholder="ID">
                            </div>
                            <div class="">
                                <input type="password" class="form-control" id="password" name="password" placeholder="password">
                            </div>
                            <div class="mb-3" style="text-align: left;">
                                <input class="mt-3" type="checkbox" onclick="myFunction()"> Show Password
                            </div>
                            <div class="mb-3">
                                {!! NoCaptcha::renderJs() !!}
                                {!! NoCaptcha::display() !!}
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                    <div class="card-footer">
                        <p> Belum punya akun? <a href="{{route('karir.verifikasi')}}">Verifikasi disini</a></p>
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

    <script>
        function myFunction() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>

@endsection