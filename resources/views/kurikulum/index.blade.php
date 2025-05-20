@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
           <div class="col-md-6">
               <img src="{{ asset('assets/images/siswa_tk.png') }}" class="center dynamic" alt="logo" width="70%">
               <div class="row">
                   <h4 class="text-center">Metode Sentra</h4>
                   <div class="col-md-3">
                   </div>
                   <div class="col-md-3">
                    <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #E21387;"></i> Sentra Imtaq </p>
                    <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #E21387;"></i> Sentra Seni </p>
                    <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #E21387;"></i> Sentra Balok </p>
                    <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #E21387;"></i> Sentra Olah Tubuh </p>
                   </div>
                   <div class="col-md-3">
                    <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #E21387;"></i> Sentra Bahan Alam </p>
                    <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #E21387;"></i> Sentra Peran </p>
                    <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #E21387;"></i> Sentra Persiapan </p>
                   </div>
               </div>
           </div>
           <div class="col-md-5">
                <div class="kurikulum_tk">
                    <h1> TK </h1>
                </div>
                <div class="mt-3">
                    <h4> Kurikulum Diknas. </h4>
                    <p style="font-size: small"> Kurikulum TK Rabbani menggunakan metode sentra guna mengoptimalkan tumbuh dan kembang serta pola berpikir peserta didik sehingga mampu melanjutkan ke jenjang pendidikan selanjutnya. Metode sentra dirancang untuk memenuhi kebutuhan main anak usia dini yaitu mainsensorimotor, main pembangunan, dan main peran. </p>
                </div>
                <div class="mt-5">
                    <h4> Kurikulum Khas. </h4>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong> Program Unggulan Quantum </strong> </p>
                            <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #E21387;"></i> Tahfidz 1 Juz </p>
                            <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #E21387;"></i> Murojaah </p>
                            <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #E21387;"></i> Tahfidz On The Stage (TOS) </p>
                            <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #E21387;"></i> Simaan </p>
                        </div>
                        <div class="col-md-5">
                            <p><strong> Program Unggulan Tajir </strong> </p>
                            <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #E21387;"></i> Make Product Benefit </p>
                            <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #E21387;"></i> Market Day </p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <p><strong> Program Unggulan Dai Muda </strong> </p>
                            <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #E21387;"></i> Pembiasaan ibadah Beradab Islam </p>
                            <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #E21387;"></i> Zona Inspirasi Da’i Rabbani (ZINDANI) </p>
                        </div>
                    </div>
                </div>
           </div>
        </div>
    </div>

        {{-- Ekskul TK --}}
    <div class="jenjang-program ekskul-tk">
        <div class="container">
            <div class="center">
                <img src="{{ asset('assets/images/icon-jenjang.png') }}" class="center" alt="logo jenjang" width="3%">
                <h6 class="mt-1" style="color: #ED145B">Ikuti</h6>
                <h4 class="mb-3">Ekstrakurikuler TK Wajib</h4>
                <p> Eksplorasi kegiatan Ekstrakurikuler yang Inspiratif dan beragam di Sekolah Rabbani untuk menggali potensi Siswa. </p>
            </div>
            <div class="row">
                @foreach ($ekskul_tk as $item)
                    <div class="col-md-4">
                        <img src="{{asset($item->image)}}" alt="image-{{$item->id}}" width="100%">
                        <h6 class="center"> {{$item->nama_ekskul}} </h6>
                    </div>
                @endforeach
            </div>

                <div class="row my-5">
                    <div class="col-md-6">
                        <img src="{{ asset('assets/images/siswa_sd.png') }}" class="center dynamic" alt="logo" width="70%">
                        <div class="row">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md">
                                <p class="text-center"><strong> Program Unggulan Quantum </strong> </p>
                                <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #1593D0;"></i> Tahfidz 7 Juz </p>
                                <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #1593D0;"></i> Tahsin dan Mutqin 2 Juz </p>
                                <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #1593D0;"></i> Tahfidz On The Stage (TOS) </p>
                                <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #1593D0;"></i> Simaan </p>
                                <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #1593D0;"></i> Ujian Tahfidz </p>
                                <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #1593D0;"></i> Sidang Tahfidz </p>
                                <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #1593D0;"></i> Pekan Qur'an </p>
                            </div>
                            <div class="col-md-3">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="kurikulum_sd">
                            <h1> SD </h1>
                        </div>
                        <div class="mt-3">
                            <h4> Kurikulum Diknas. </h4>
                            <p style="font-size: small"> Kurikulum SD Rabbani merupakan pengintegrasian kurikulum diknas, kurikulum khas dan kecakapan hidup (life skills) dengan merujuk pada kurikulum yang berlaku secara nasional serta pengembangan berbasis Ilmu Al-Qur’an yang berfokus pada tauhid dan adab islami. </p>
                            <p style="font-size: small"> Pembelajaran dilaksanakan dengan menggunakan metode <strong> Multiple Intelligences (MI), Tematic Integratif, Contextual Teaching Learning (CTL) dan Project Based Learning (PBL).</strong></p>
                        </div>
                        <div class="mt-3">
                            <h4> Kurikulum Khas. </h4>
                            <div class="row">
                                <div class="col-md">
                                    <p><strong> Program Unggulan Dai Muda </strong> </p>
                                    <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #1593D0;"></i> Pembiasaan ibadah Beradab Islam </p>
                                    <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #1593D0;"></i> Pembelajaran Hadits-hadits pilihan </p>
                                    <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #1593D0;"></i> Field Trip </p>
                                    <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #1593D0;"></i> Super Camp </p>
                                    <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #1593D0;"></i> Zona Inspirasi Da’i Rabbani (ZINDANI) </p>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <p><strong> Program Unggulan Tajir </strong> </p>
                                    <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #1593D0;"></i> Make Product Benefit & Gallery </p>
                                    <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #1593D0;"></i> Market Day </p>
                                    <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #1593D0;"></i> Rabbani Expo </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        

            {{-- Ekskul SD --}}
            <div class="center">
                <img src="{{ asset('assets/images/icon-jenjang.png') }}" class="center" alt="logo jenjang" width="3%">
                <h6 class="mt-1" style="color: #ED145B">Ikuti</h6>
                <h4 class="mb-3">Ekstrakurikuler SD Wajib</h4>
                <p> Eksplorasi kegiatan Ekstrakurikuler yang Inspiratif dan beragam di Sekolah Rabbani untuk menggali potensi Siswa. </p>
            </div>
            <div class="row">
                @foreach ($ekskul_sd_wajib as $item)
                    <div class="col-md-3">
                        <img src="{{asset($item->image)}}" alt="image-{{$item->id}}" width="100%">
                        <h6 class="center"> {{$item->nama_ekskul}} </h6>
                    </div>
                @endforeach
            </div>

            {{-- Ekskul SD Pilihan --}}
            <div class="center">
                <img src="{{ asset('assets/images/icon-jenjang.png') }}" class="center" alt="logo jenjang" width="3%">
                <h6 class="mt-1" style="color: #ED145B">Ikuti</h6>
                <h4 class="mb-3">Ekstrakurikuler SD Pilihan</h4>
                <p> Eksplorasi kegiatan Ekstrakurikuler yang Inspiratif dan beragam di Sekolah Rabbani untuk menggali potensi Siswa. </p>
            </div>
            <div class="row">
                @foreach ($ekskul_sd_pilihan as $item)
                    <div class="col-md-3">
                        <img src="{{asset($item->image)}}" alt="image-{{$item->id}}" width="100%">
                        <h6 class="center"> {{$item->nama_ekskul}} </h6>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="fasilitas">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ asset('assets/images/siswa_smp.png') }}" class="center dynamic" alt="logo" width="70%">
                    <div class="row">
                        <div class="col-md-3">
                        </div>
                        <div class="col-md">
                            <p class="text-center"><strong> Program Unggulan Quantum </strong> </p>
                            <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #3152A4;"></i> Tahfidz 15 Juz </p>
                            <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #3152A4;"></i> Tahsin </p>
                            <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #3152A4;"></i> Tahfidz On The Stage (TOS) </p>
                            <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #3152A4;"></i> Simaan </p>
                            <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #3152A4;"></i> Ujian Tahfidz </p>
                            <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #3152A4;"></i> Pekan Qur'an </p>
                        </div>
                        <div class="col-md-3">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-5">
                    <div class="kurikulum_smp">
                        <h1> SMP </h1>
                    </div>
                    <div class="mt-3">
                        <h4> Kurikulum Diknas. </h4>
                        <p style="font-size: small"> Kurikulum SMP QLP Rabbani merupakan pengintegrasian kurikulum diknas, kurikulum khas dan kecakapan hidup (life skills) dengan merujuk pada kurikulum yang berlaku secara nasional dengan pengembangan berbasis Ilmu Al-Qur’an yang berfokus pada tauhid dan adab islami. </p>
                        <p style="font-size: small"> Pembelajaran dilaksanakan dengan menggunakan metode <strong> Multiple Intelligences (MI), Tematic Integratif, Contextual Teaching Learning (CTL) dan Project Based Learning (PBL).</strong></p>
                    </div>
                    <div class="mt-3">
                        <h4> Kurikulum Khas. </h4>
                        <div class="row">
                            <div class="col-md">
                                <p><strong> Program Unggulan Dai Muda </strong> </p>
                                <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #3152A4;"></i> Zona Inspirasi Da’i Rabbani (ZINDANI) </p>
                                <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #3152A4;"></i> Malam Bina Taqwa (MABIT) </p>
                                <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #3152A4;"></i> Islamic Development Character (IDC) </p>
                                <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #3152A4;"></i> Field Trip </p>
                                <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #3152A4;"></i> Super Camp </p>
                                <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #3152A4;"></i> Home Stay </p>
                            </div>           
                        </div>
                        <div class="row mt-3">
                            <div class="col-md">
                                <p><strong> Program Unggulan Tajir </strong> </p>
                                <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #3152A4;"></i> Make Product Benefit & Gallery </p>
                                <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #3152A4;"></i> Market Day </p>
                                <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #3152A4;"></i> Meet CEO </p>
                                <p style="font-size: small; margin-bottom: 0"><i class="fa-solid fa-circle-check" style="color: #3152A4;"></i> Company Review </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Ekskul smp --}}
            <div class="center">
                <img src="{{ asset('assets/images/icon-jenjang.png') }}" class="center" alt="logo jenjang" width="3%">
                <h6 class="mt-1" style="color: #ED145B">Ikuti</h6>
                <h4 class="mb-3">Ekstrakurikuler SMP Wajib</h4>
                <p> Eksplorasi kegiatan Ekstrakurikuler yang Inspiratif dan beragam di Sekolah Rabbani untuk menggali potensi Siswa. </p>
            </div>
            <div class="row">
                @foreach ($ekskul_smp_wajib as $item)
                    <div class="col-md-3">
                        <img src="{{asset($item->image)}}" alt="image-{{$item->id}}" width="100%">
                        <h6 class="center"> {{$item->nama_ekskul}} </h6>
                    </div>
                @endforeach
            </div>

            {{-- Ekskul smp Pilihan --}}
            <div class="center">
                <img src="{{ asset('assets/images/icon-jenjang.png') }}" class="center" alt="logo jenjang" width="3%">
                <h6 class="mt-1" style="color: #ED145B">Ikuti</h6>
                <h4 class="mb-3">Ekstrakurikuler SMP Pilihan</h4>
                <p> Eksplorasi kegiatan Ekstrakurikuler yang Inspiratif dan beragam di Sekolah Rabbani untuk menggali potensi Siswa. </p>
            </div>
            <div class="row">
                @foreach ($ekskul_smp_pilihan as $item)
                    <div class="col-md-4 mb-2">
                        <img src="{{asset($item->image)}}" alt="image-{{$item->id}}" width="100%">
                        <h6 class="center"> {{$item->nama_ekskul}} </h6>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection