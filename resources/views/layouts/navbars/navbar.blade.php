<nav class="navbar navbar-expand-lg">
    <div class="container mt-3">
        <a href="/" style="border-image: none"><img src="{{ asset('assets/images/logo.png') }}" alt="logo" height="60px"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mt-2 mt-lg-0" >
                <li class="nav-item">
                <a class="nav-link" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{route('profile.sekolah')}}">Profil</a>
                    </li>
                <li class="nav-item">
                <a class="nav-link" href="{{route('kurikulum.sekolah')}}">Kurikulum & Kesiswaan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Artikel</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/humas">Humas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('karir')}}">Karir</a>
                </li>
                <li>
                    <a class="nav-link text-white" style="background-color: #624F8F; border-radius: 1rem" href="{{route('pendaftaran')}}">Info Pendaftaran</a>
                </li>
            </ul>
            <ul class="navbar-nav mt-2 mt-lg-0" style="margin-left: auto;">
                @if (Auth::check())
                    <li class="nav-item dropdown">
                        <a class="py-0 nav-link d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user"></i>
                            <div class="caption ms-3 d-none d-md-block ">
                                <h6 class="mb-1 caption-title">{{ auth()->user()->name }}</h6>
                                @if ( auth()->user()->id_role == 1)
                                <span class="mb-1 caption-sub-title">Superadmin</span>
                                @elseif ( auth()->user()->id_role == 4)
                                <p class="mb-0 caption-sub-title">Karyawan</p>
                                @else
                                <p class="mb-0 caption-sub-title">Orang Tua Siswa</p>
                                @endif
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{route('profile-diri')}}">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <form role="form" method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <div
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="dropdown-item">
                                    <span class="dropdown-item">Logout</span>
                                </div>
                            </form>
                        </ul>
                    </li>
                @else
                    <li class="nav-item mr-2 mb-3 mb-lg-0">
                        <a class="nav-link" href="{{route('login')}}">Login</a>
                    </li>
                    {{-- <li class="nav-item mr-2 mb-3 mb-lg-0">
                        <a class="nav-link" href="/register">Register</a>
                    </li> --}}
                @endif
            </ul>
        </div>
    </div>
</nav>