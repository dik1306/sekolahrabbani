<nav class="navbar navbar-expand-lg">
    <div class="container mt-3">
        <a href="/" style="border-image: none"><img src="{{ asset('assets/images/logo.png') }}" alt="logo" height="60px"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mt-2 mt-lg-0" style="margin-left: auto">
                <li class="nav-item mr-2 mb-3 mb-lg-0">
                    @if (Auth::check())
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-user"></i>{{' Hi, '}}{{auth()->user()->name}}</a>
                        <div class="dropdown-menu m-0">
                            <a href="{{route('karir.profile')}}" class="dropdown-item">Profile</a>
                            <a href="#" class="dropdown-item">Notifikasi</a>
                            <div class="dropdown-divider"></div>
                            <form role="form" method="POST" action="{{ route('karir.logout') }}" id="logout-form">
                                @csrf
                                <div
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="dropdown-item">
                                    <span>{{ __('Logout') }}</span>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('karir.login') }}" class="nav-item nav-link"><i class="fa fa-user"></i> Login</a>
                @endif
                </li>
            </ul>
        </div>
    </div>
</nav>