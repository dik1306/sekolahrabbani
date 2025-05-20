@extends('layouts.app')

@section('content')
    <div class="d-flex" style="min-height: 100vh">
        <div class="col-4" style="background-color: #940b92">
            {{-- <h1><strong>Sekolah Rabbani</strong></h1> --}}
            <h3 class="text-white center" style="margin-top: 5rem"><strong>Sekolah Rabbani</strong></h3>
            <img src="{{ asset('assets/images/illustration-login1.png') }}" alt="" class="my-4" width="80%" >
        </div>
        <div class="col mt-4">
            <div class="login center">
                <div class="container px-4">
                    <a class="brand-image" href="">
                        <img src="{{ asset('assets/images/logo-yayasan_1.png') }}" width="100px" />
                    </a>
                </div>
                <div class="login-box">   
                    <span><strong> Selamat Datang di Sekolah Rabbani</strong></span>
                <div class="card mt-3">
                    <div class="card-body">
                        <p class="login-box-msg">Silahkan daftar dengan akun anda</p>
                        <form role="form" method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <div class="input-group mb-3">
                                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    <input class="form-control form-control-login"
                                        placeholder="{{ __('name') }}" type="name" name="name"
                                        value="{{ old('name') }}" required>
                                </div>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('username') ? ' has-danger' : '' }}">
                                <div class="input-group mb-3">
                                    <span class="input-group-text"><i class="fa fa-at"></i></span>
                                    <input class="form-control form-control-login"
                                        placeholder="{{ __('username') }}" type="username" name="username"
                                        value="{{ old('username') }}" required>
                                </div>
                                @if ($errors->has('username'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                <div class="input-group mb-3">
                                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                    <input class="form-control form-control-login"
                                        placeholder="{{ __('email') }}" type="email" name="email"
                                        value="{{ old('email') }}" required>
                                </div>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                    <input class="form-control form-control-login"
                                        placeholder="{{ __('Password') }}" type="password" name="password" required>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            {{-- <div class="form-group">
                                <select name="role" id="role" class="form-control" required>
                                    <option value="" disabled selected>-- Pilih Role --</option>
                                    @foreach ($role as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary mt-4">{{ __('Create account') }}</button>
                            </div>
                        </form>
                        <p class="my-3">
                            <a href="{{route('login')}}" class="text-center">I already have an account</a>
                        </p>
                    </div>
                    <!-- /.login-card-body -->
                </div>
                </div>            
            </div>
        </div>
    </div>
@endsection


