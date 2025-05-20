@extends('layouts.app')

@section('content')
<div class="row m-0  bg-white vh-100">            
    <div class="col-md-6 d-md-block d-none p-0 mt-n1 vh-100 overflow-hidden text-center" style="background-color: #940b92">
        <img src="{{ asset('assets/images/illustration-login1.png') }}" alt="" class="my-4" width="75%" >
    </div>
    <div class="col-md-6 mt-4">               
        <a href="{{route('home.index')}}" class="navbar-brand d-flex my-4">
            <div class="logo-main">
                <img src="{{ asset('assets/images/logo-yayasan_1.png') }}" width="100px" />
            </div>
            <h3 class="logo-title mt-2">Sekolah Rabbani</h3>
        </a>
        <div class="row align-middle justify-content-center ">
            <div class="col-md-10">
                <div class="card auth-card d-flex justify-content-center mt-3">
                    <div class="card-body">
                        <h2 class="mb-2 text-center">Verification</h2>
                        <p class="text-center mb-3"> Verify your account </p>
                        <form role="form" method="POST" action="{{route('verifikasi.post')}}">
                            @csrf
                            <div class="form-group{{ $errors->has('no_hp') ? ' has-danger' : '' }} mb-3">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa fa-mobile"></i></span>
                                    <input class="form-control form-control-login" placeholder="No Hp" type="text" name="no_hp" value="{{ old('no_hp') }}" required autofocus>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary my-4 text-white"  style=" background-color: #EB3C97 !important; border-radius: 1rem; border:none">Kirim</button>
                            </div>
                        </form>         
                    </div>
                </div>    
            </div>
        </div>
        <div class="bg-svg">
            <svg width="280" height="230" viewBox="0 0 421 359" fill="none" xmlns="http://www.w3.org/2000/svg">
               <g opacity="0.05">
                  <rect x="-15.0845" y="154.773" width="543" height="77.5714" rx="38.7857" transform="rotate(-45 -15.0845 154.773)" fill="#3A57E8"/>
                  <rect x="149.47" y="319.328" width="543" height="77.5714" rx="38.7857" transform="rotate(-45 149.47 319.328)" fill="#3A57E8"/>
                  <rect x="203.936" y="99.543" width="310.286" height="77.5714" rx="38.7857" transform="rotate(45 203.936 99.543)" fill="#3A57E8"/>
                  <rect x="204.316" y="-229.172" width="543" height="77.5714" rx="38.7857" transform="rotate(45 204.316 -229.172)" fill="#3A57E8"/>
               </g>
            </svg>
         </div>
    </div>   
</div>
@endsection

