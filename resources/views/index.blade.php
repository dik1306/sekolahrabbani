@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 mb-5">
        <div id="header-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#header-carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#header-carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#header-carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="banner" src="{{ asset('assets/images/home_rabbani_school.png') }}" alt="Image">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3">
                            <h1 class="text-white text-uppercase animated zoomIn">School of Qur'anic <br> Leaderpreneur</h1>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="banner" src="{{ asset('assets/images/home_rabbani_school.png') }}" alt="Image">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3">
                            <h1 class="text-white text-uppercase animated zoomIn">Sekolah Rabbani Menuju <br> Generasi Rabbani</h1>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="banner" src="{{ asset('assets/images/home_rabbani_school.png') }}" alt="Image">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="">
                            <h1 class="text-white text-uppercase animated zoomIn">Sekolah Berbasis <br>Qur'an Leadership Entrepreneur</h1>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#header-carousel"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <div>
            <img src="{{ asset('assets/images/awan1.png') }}" class="cloud-1"  alt="cloud">
            <img src="{{ asset('assets/images/awan2.png') }}" class="cloud-2"  alt="cloud">
        </div>
    </div>
    <div class="container-fluid" style="position: relative; z-index: 1000">
        <div class="vector">
            <img src="{{ asset('assets/images/plane.png') }}" class="plane" alt="icon plane" width="4%">
            <img src="{{ asset('assets/images/puzzle.png') }}" class="puzzle" alt="icon plane" width="4%">
            <img src="{{ asset('assets/images/lamp.png') }}" class="lamp" alt="icon plane" width="3%">
        </div>
        <div class="row">
            <div class="col-md-6">
                <img src="{{ asset('assets/images/siswa_profile_2.png') }}" class="center dynamic" alt="logo" width="70%">
            </div>
            <div class="col-md-5">
                <div class="row">
                <h6 class="mt-1" style="color: #ED145B">Profil Sekolah Rabbani</h6>
                </div>
                <div class="row">
                    <h1> School of Qur'anic Leaderpreneur.</h1>
                </div>
                <div class="row">
                    <p style="text-align: justify"> Sekolah Rabbani dengan kurikulum khas Quranic Leaderpreneur (QLP) dirancang sebagai sekolah pencetak 
                        peserta didik yang mampu menjadi teladan dan memiliki jiwa pengusaha yang berbasis Al-Qur’an dan As-Sunnah. 
                    </p>
                    <br>
                    <p>
                        Sekolah Rabbani memiliki berbagai program unggulan yang dapat meningkatkan kecakapan hidup peserta didik <i>life skills</i> sehingga mampu beradaptasi dengan perkembangan zaman.
                    </p>
                </div>
                <div>
                    <a href="{{route('profile.sekolah')}}" class="btn btn-primary text-white">Lanjut Baca</a>
                </div>
            </div>
        </div>
        <br>
    </div>

    {{-- Landasan --}}

    <div style="background-color: #704996">
        <div class="container" style="align-items: center">
            <div class="row">
                <div class="col-md-8 text-center text-white mt-3 px-4">
                    <h3> QS. Al-Baqarah 151 </h3>
                    <span style="font-size: 28px; text-shadow: 0 0 10px white" > كَمَآ اَرْسَلْنَا فِيْكُمْ رَسُوْلًا مِّنْكُمْ يَتْلُوْا عَلَيْكُمْ اٰيٰتِنَا وَيُزَكِّيْكُمْ وَيُعَلِّمُكُمُ الْكِتٰبَ وَالْحِكْمَةَ وَيُعَلِّمُكُمْ مَّا لَمْ تَكُوْنُوْا تَعْلَمُوْنَۗ </span>
                    <p> <i> “Sebagaimana (Kami telah menyempurnakan nikmat kepadamu), Kami pun mengutus kepadamu seorang Rasul (Nabi Muhammad) 
                        dari (kalangan) kamu yang membacakan kepadamu ayat-ayat Kami, menyucikan kamu, dan mengajarkan kepadamu Kitab (Al-Qur’an) 
                        dan hikmah (sunah), serta mengajarkan apa yang belum kamu ketahui.” </i>
                    </p>
                    <h4> menjadi landasan kami dalam menyusun kurikulum </h4>
                    <h3> <i> QURANIC LEADERPRENEUR </i> </h3>
                </div>
                <div class="col-md-4">
                    <img src="{{asset('assets/images/img-landasan.png')}}" width="90%" >
                </div>
            </div>
        </div>
    </div>

    {{-- Jenjang --}}
    <div class="jenjang-program mt-5">
        <div class="container ">
            <div class="center">
                <img src="{{ asset('assets/images/icon-jenjang.png') }}" class="center" alt="logo jenjang" width="3%">
                <h6 class="mt-1" style="color: #ED145B">Sekolah Rabbani</h6>
                <h4 class="mb-3">Berbagai Jenjang Pilihan</h4>
            </div>
            <div class="row mb-4">
                @foreach ($jenjang as $item)
                    <div class="col-md-3 mb-1">
                        <a href="{{route('jenjang.sekolah', $item->nama_jenjang)}}" style="text-decoration: none">
                        <div class="card shadow" style="height: 350px">
                            <div class="bg-jenjang center" style="background-color: #{{$item->bg_style}}">
                                <img src="{{ asset($item->image_1) }}" class="card-img-top card-jenjang" alt="jenjang-{{$item->nama_jenjang}}">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-center"> {{$item->nama_jenjang}} </h5>
                                <p style="font-size: 12px">{{$item->deskripsi}}</p>
                            </div>
                        </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <br>
            <br>
            
            {{-- program --}}
            <div class="vector mt-4">
                <img src="{{ asset('assets/images/star.png') }}" class="star-1" alt="vector" width="3%">
                <img src="{{ asset('assets/images/star.png') }}" class="star-2" alt="vector" width="1%">
                <img src="{{ asset('assets/images/star-sm.png') }}" class="star-3" alt="vector" width="3%">
                <img src="{{ asset('assets/images/star-sm.png') }}" class="star-4" alt="vector" width="1%">
                <img src="{{ asset('assets/images/rocket.png') }}" class="rocket" alt="vector" width="5%">
                <img src="{{ asset('assets/images/ufo.png') }}" class="ufo" alt="vector" width="7%">
            </div>
            <div class="center mt-3">
                <img src="{{ asset('assets/images/icon-jenjang.png') }}" class="center" alt="logo program" width="3%">
                <h6 class="mt-1" style="color: #ED145B">Program Unggulan</h6>
                <h4 class="mb-3">Beragam Kegiatan Sekolah</h4>
                <p> Sekolah Rabbani menawarkan beragam program bagi siswa. Program-program ini <br> bertujuan menciptakan lingkungan belajar yang menyenangkan bagi siswa. </p>
            </div>

            <div class="row mt-4">
                @foreach ($program as $item)
                    <div class="col-md-4 mb-3">
                        <div class="card card-program" style="box-shadow: 0px 6px #{{$item->style}};">
                            <div class="d-flex p-3">
                                <div style="margin-right: 1rem;">
                                    <img src="{{ asset($item->image) }}" width="150" alt="img program">
                                </div>
                                <div style="overflow-y: auto">
                                    <h5 style="color: #{{$item->style}}"> {{$item->nama_program}} </h5>
                                    <p style="font-size: 11px"> {{$item->deskripsi}} </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <br>
            <br>
        </div>
    </div>

    {{-- kegiatan --}}
    <div class="container my-5">
        <div class="vector">
            <img src="{{ asset('assets/images/bumi.png') }}" class="bumi" alt="logo program" width="4%">
            <img src="{{ asset('assets/images/komet.png') }}" class="komet" alt="vector" width="7%">
        </div>
        <div class="row">
            <div class="col-md-4">
                <img src="{{ asset('assets/images/icon-jenjang.png') }}" class="kegiatan" alt="logo program" width="10%">
                <h6 class="mt-1" style="color: #ED145B">Melangkah Bersama</h6>
                <h4 class="mb-3">Beragam Kegiatan Sekolah</h4>
                <p style="font-size: 12px">Sorotan kegiatan terbaru yang dilaksanakan oleh Sekolah Rabbani</p>
                <a href="#" class="btn btn-primary">Berita Sekolah</a>
            </div>
            {{-- <div class="col-md-3">
                <img src="{{ asset('assets/images/bumi.png') }}" class="bumi" alt="logo program" width="5%">
            </div> --}}
            <div class="col-md-6">
                <img src="{{ asset('assets/images/img-kegiatan-1.png') }}" class="kegiatan" alt="logo program" width="48%">
                <img src="{{ asset('assets/images/img-kegiatan-2.png') }}" class="kegiatan" alt="logo program" width="48%">
            </div>
            <div class="col-md-2">
            </div>
        </div>
    </div>

    {{-- fasilitas --}}
    <div class="fasilitas">
        <div class="container my-5">
            <div class="vector">
                <img src="{{ asset('assets/images/star-happy.png') }}" class="star-5" alt="vector" width="7%">
                <img src="{{ asset('assets/images/planet.png') }}" class="planet" alt="vector" width="7%">
            </div>
            <div class="center">
                <img src="{{ asset('assets/images/icon-jenjang.png') }}" class="center" alt="logo program" width="3%">
                <h6 class="mt-1" style="color: #ED145B">Jelajahi Sarana Terbaik</h6>
                <h4 class="mb-3">Keunggulan Fasilitas Terbaru</h4>
                <p >Sekolah Rabbani memberikan fasilitas yang maksimal untuk pengalaman pendidikan <br> yang menyeluruh, memotivasi, dan mempersiapkan siswa untuk menjadi pengusaha muslim.</p>
            </div>
            <div class="row mt-4">
                @foreach ($fasilitas as $item)
                    <div class="col-md-3 mb-2">
                        <div class="card bg-fasilitas shadow" style="height: 500px;">
                            <div class="">
                                <img src="{{ asset($item->image) }}" class="card-img-top" alt="kober">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title mb-2 center"> {{$item->nama_fasilitas}} </h5>
                                <img class="center" src="{{asset('assets/images/vector-fasilitas.png')}}" alt="vector" width="80%">
                                <p class="mt-3" style="font-size: 12px"> {{$item->deskripsi}} </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="container">
            <div class="vector">
                <img src="{{ asset('assets/images/perahu.png') }}" class="perahu" alt="vector" width="7%">
                <img src="{{ asset('assets/images/ufo-2.png') }}" class="ufo-2" alt="vector" width="7%">
            </div>
            <div class="center">
                <img src="{{ asset('assets/images/icon-jenjang.png') }}" class="center" alt="logo program" width="3%">
                <h6 class="mt-1" style="color: #ED145B">Media Sosial Sekolah Rabbani</h6>
                <h4 class="mb-3">Follow us</h4>
                {{-- <p>Total Site Visits: {{ $visitorCount }}</p> --}}
                <a href="https://www.tiktok.com/@SekolahRabbani" target="_blank" ><img src="{{ asset('assets/images/icon-tiktok.png') }}" class="icon-sosial" alt="logo tiktok" width="5%"></a>
                <a href="https://www.instagram.com/sekolahrabbani/" target="_blank" ><img src="{{ asset('assets/images/instagram-2.png') }}" class="icon-sosial" alt="logo ig" width="5%"></a>
                <a href="https://www.youtube.com/@SekolahRabbani" target="_blank" ><img src="{{ asset('assets/images/icon-youtube.png') }}" class="icon-sosial" alt="logo yutub" width="5%"></a>
            </div>
        </div>
    </div>
@endsection

   
