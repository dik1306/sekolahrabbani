@extends ('ortu.layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex" style="justify-content: space-between">
            <div class="">
                <h6> Halo, {{auth()->user()->name}} </h6>
            </div>
            <div class="mx-2">
                <a href="#" id="navbarDropdown"  role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-user-circle fa-xl"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="{{route('profile-diri')}}">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <form role="form" method="POST" action="{{ route('logout') }}" id="logout-form">
                        @csrf
                        <div
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <span class="dropdown-item">Logout</span>
                        </div>
                    </form>
                </ul>
            </div>
        </div>

        {{-- card --}}
        <div class="card mt-2" style="border-radius: 1rem">
            <div class="card-body-dashboard">
                <div class="d-flex" style="justify-content: space-between">
                    <div class=" text-white my-auto p-3">
                        <h1 class="center" > Sekolah Rabbani </h1>
                        <span class="center" style="font-size: 12px" > School of Quranic Leaderpreneur </span>
                    </div>
                    <div class="w-50">
                        <img class="center" src="{{asset ('assets/images/icon-animate.png')}}" alt="animate" style="width: 75%">
                    </div>
                </div>
            </div>
        </div>
        {{-- end card --}}

        {{-- menu --}}
        <div class="row mt-3">
            <h6> Menu Pilihan </h6>
            @foreach ($main_menu as $item)
                @if ($main_menu->count() == 2)
                    <div class="col-6 my-2">
                        <a href="{{$item->url}}" style="text-decoration: none; color:black" >
                            <img class="center" src="{{asset($item->icon)}}" alt="{{$item->icon}}" width="125px" >
                            <span class="center p-0" style="font-size: 16px"> {{$item->name}} </span>
                        </a>
                    </div>
                @elseif ($main_menu->count() == 3) 
                    <div class="col-4 mb-2">
                        <a href="{{$item->url}}" style="text-decoration: none; color:black" >
                            <img class="center" src="{{asset($item->icon)}}" alt="{{$item->icon}}" width="90px" >
                            <span class="center p-0" style="font-size: 12px"> {{$item->name}} </span>
                        </a>
                    </div>
                @else 
                    <div class="col-3 mb-2">
                        <a href="{{$item->url}}" style="text-decoration: none; color:black" >
                            <img class="center" src="{{asset($item->icon)}}" alt="{{$item->icon}}" width="80px" >
                            <span class="center p-0" style="font-size: 12px"> {{$item->name}} </span>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
        {{-- end menu --}}

        <div class="center-btn">
            <a href="{{route('home.index')}}">
            <button class="btn btn-warning px-5 shadow" style="border-radius: 1rem" > 
                <span> Informasi lebih lanjut </span> 
                <h4> sekolahrabbani.sch.id </h4>
            </button>
            </a>
        </div>
    </div>
    {{-- @include('ortu.footer.index') --}}
@endsection
