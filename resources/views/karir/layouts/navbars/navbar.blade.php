<nav class="navbar navbar-expand-lg">
    <div class="container mt-3">
        <img src="{{ asset('assets/images/logo.png') }}" alt="logo" height="60px">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mt-2 mt-lg-0" >
                <li class="nav-item">
                <a class="nav-link" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="#">Profil</a>
                    </li>
                <li class="nav-item">
                <a class="nav-link" href="kurikulum">Kurikulum</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Artikel</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Kesiswaan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Humas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('karir')}}">Karir</a>
                </li>
                <li>
                    <a class="nav-link text-white" style="background-color: #624F8F; border-radius: 1rem" href="{{route('pendaftaran')}}">Info Pendaftaran</a>
                </li>
            </ul>
            <ul class="navbar-nav mt-2 mt-lg-0" style="margin-left: auto">
                <li class="nav-item mr-2 mb-3 mb-lg-0">
                    <a class="nav-link" href="/login">Login</a>
                </li>
                <li class="nav-item mr-2 mb-3 mb-lg-0">
                    <a class="nav-link" href="/register">Register</a>
                </li>
            </ul>
        </div>
    </div>
</nav>