<!--Nav Start-->
<nav class="nav navbar navbar-expand-lg navbar-light iq-navbar">
    <div class="container-fluid navbar-inner">
    
        <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
            <i class="icon">
             <svg  width="20px" class="icon-20" viewBox="0 0 24 24">
                <path fill="currentColor" d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" />
            </svg>
            </i>
        </div>
    
        <button class="navbar-toggler" style="margin-left: auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <span class="mt-2 navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="mb-2 navbar-nav ms-auto align-items-center navbar-list mb-lg-0">
            <li class="nav-item dropdown">
            <a class="py-0 nav-link d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-user"></i>
                <div class="caption ms-3 d-none d-md-block ">
                    @if ( auth()->user()->id_role == 1)
                        <span class="mb-1 caption-sub-title">Superadmin</span>
                    @elseif ( auth()->user()->id_role == 2)
                        <p class="mb-0 caption-sub-title">Admin</p>
                    @elseif ( auth()->user()->id_role == 4 )
                        <p class="mb-0 caption-sub-title">Karyawan</p>
                    @elseif ( auth()->user()->id_role == null )
                        <input type="hidden" id="role-null" value="" >
                    @endif
                    <h6 class="mb-1 caption-title">{{ auth()->user()->name }}</h6>
                </div>
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
            </li>
        </ul>
        </div>
    </div>
</nav> 
<aside class="sidebar sidebar-default sidebar-white sidebar-base navs-rounded-all ">
    <div class="sidebar-header d-flex align-items-center justify-content-start">
        @if (auth()->user()->id_role != 4)
            <a href="{{route('dashboard')}}" class="navbar-brand">
        @else 
            <a href="#" class="navbar-brand">
        @endif
            <!--Logo start-->
            <div >
                <img src="{{ asset('assets/images/logo-yayasan_1.png') }}" class="logo" alt="logo-yayasan" width="60">
            </div>
            <!--logo End-->
            
            <h5 class="logo-title">QLP School</h5>
        </a>
        <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
            <i class="icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </i>
        </div>
    </div>
    <div class="sidebar-body pt-0 data-scrollbar">
        <div class="sidebar-list">
            <!-- Sidebar Menu Start -->
            <ul class="navbar-nav iq-main-menu" id="sidebar-menu">
                @foreach (getMenus() as $menu)
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#horizontal-menu-{!!str_replace(' ', '-', $menu->name)!!}" role="button" aria-expanded="false" aria-controls="horizontal-menu-{!!str_replace(' ', '-', $menu->name)!!}">
                            <i class="{{ $menu->icon }}"></i>
                            <span class="item-name">{{ $menu->name }}</span>
                            <i class="right-icon">
                                <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </i>
                        </a>
                        <ul class="sub-nav collapse" id="horizontal-menu-{!!str_replace(' ', '-', $menu->name)!!}" data-bs-parent="#sidebar-menu">
                            @foreach ($menu->sub as $item)
                                <li class="nav-item">
                                    <a class="nav-link " href="{{ url($item->url) }}">
                                        <i class="{{$item->icon}}"></i>
                                    {{-- <i class="sidenav-mini-icon"> H </i> --}}
                                    <span class="item-name"> {{ ($item->name) }} </span>
                                    </a>
                                    {{-- <ul class="sub-nav nav-sm flex-column">
                                        @foreach ($item->sub as $sub)
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ url($sub->url) }}">
                                                    <span class="item-name"> {{ $sub->name }} </span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul> --}}
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
            <!-- Sidebar Menu End -->        </div>
    </div>
</aside>
