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
        <div class="row align-items-center justify-content-center ">
            <div class="col-md-10">
                <div class="card shadow d-flex justify-content-center mt-3">
                    <div class="card-body">
                        <h2 class="mb-2 text-center">Login</h2>
                        <p class="text-center mb-3"> Login to Stay Connected </p>
                        <form role="form" method="POST" action="{{route('login')}}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="no_hp" class="form-label">No HP</label>
                                        <input type="text" class="form-control" id="no_hp" name="no_hp" aria-describedby="no_hp" placeholder=" ">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group mt-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" aria-describedby="password" placeholder=" ">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary mt-3" >Login</button>
                            </div>
                        </form>

                        <p class="my-3 text-center">
                            <a href="{{route('verifikasi')}}" class="text-center">Verify your account</a>
                        </p>
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
