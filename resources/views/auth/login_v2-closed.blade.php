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
                <div class="text-center my-5">
                    <svg width="180" height="180" viewBox="0 0 180 180" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="90" cy="90" r="80" fill="#F3F4F6"/>
                        <g>
                            <rect x="60" y="60" width="60" height="60" rx="12" fill="#940b92"/>
                            <rect x="75" y="75" width="30" height="30" rx="6" fill="#fff"/>
                            <rect x="85" y="95" width="10" height="20" rx="3" fill="#940b92"/>
                            <rect x="95" y="95" width="10" height="20" rx="3" fill="#940b92"/>
                            <rect x="80" y="85" width="20" height="6" rx="3" fill="#940b92"/>
                        </g>
                        <g>
                            <circle cx="90" cy="150" r="6" fill="#940b92" opacity="0.6"/>
                            <circle cx="60" cy="140" r="4" fill="#940b92" opacity="0.3"/>
                            <circle cx="120" cy="140" r="4" fill="#940b92" opacity="0.3"/>
                        </g>
                        <g>
                            <rect x="70" y="40" width="40" height="8" rx="4" fill="#940b92" opacity="0.5"/>
                            <rect x="80" y="32" width="20" height="8" rx="4" fill="#940b92" opacity="0.2"/>
                        </g>
                    </svg>
                    <h2 class="mt-4 mb-2" style="color:#940b92;">Sedang Maintenance</h2>
                    <p class="text-muted">Website sedang dalam penyesuai. Silakan kembali beberapa saat lagi.</p>
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
