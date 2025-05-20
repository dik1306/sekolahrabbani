@extends('layouts.app')

@section('content')
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-6 my-auto" style="text-align: end">
                <h3 >Sebagai upaya taqwa, ikhtiar menciptakan generasi yang tumbuh dalam kemandirian,
                    kepemimpinan, dan dekat dengan Al Quran, Sekolah Rabbani hadir mewujudkan cita-citanya
                </h3>
                <p class="mt-3">Ustadz Nur Ihsan Jundulloh, Lc. - Pengawas Rabbani </p>
                <div class="d-flex justify-content-end">
                    <img src="{{ asset('assets/images/logo_fb.png') }}" alt="logo program" style="width: 5%">
                    <img src="{{ asset('assets/images/logo_twitter.png') }}" class="mx-1" alt="logo program" style="width: 5%">
                    <img src="{{ asset('assets/images/logo_linkedin.png') }}" alt="logo program" style="width: 5%">
                    <img src="{{ asset('assets/images/logo_ig.png') }}" class="mx-1" alt="logo program" style="width: 5%">
                </div>
            </div>
            <div class="col-md-6">
                <img src="{{ asset('assets/images/ust_ihsan.png') }}" alt="logo program" width="90%">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6">
                <img src="{{ asset('assets/images/ust_choi.png') }}" alt="logo program" width="65%">
            </div>
            <div class="col-md-6 my-auto">
                <h3> “ Al-Qur’an adalah <span style="color: #118ECC"> pedoman hidup kita </span>, sengaja kami tanamkan Al-Qur’an sejak dini, agar Al-Qur’an
                    bercampur menjadi darah daging anak-anak dan menjadi <span style="color: #118ECC "> bekal </span> untuk kehidupan mereka kedepan” </h3>
                <p class="mt-3">Ustadz Khoiruddin Aditha Yudha - Ketua Yayasan </p>
                <div class="d-flex justify-content-start">
                    <img src="{{ asset('assets/images/logo_fb.png') }}" alt="logo fb" style="width: 5%">
                    <img src="{{ asset('assets/images/logo_twitter.png') }}" class="mx-1" alt="logo x" style="width: 5%">
                    <img src="{{ asset('assets/images/logo_linkedin.png') }}" alt="logo linkedin" style="width: 5%">
                    <img src="{{ asset('assets/images/logo_ig.png') }}" class="mx-1" alt="logo ig" style="width: 5%">
                </div>
            </div>
        </div>
    </div>

    {{-- visi-misi --}}
    <div class="jenjang-program mt-5">
        <div class="container ">
            <div class="vector mt-4">
                <img src="{{ asset('assets/images/star.png') }}" class="star-1-profile" alt="vector" width="3%">
                <img src="{{ asset('assets/images/star.png') }}" class="star-2-profile" alt="vector" width="1%">
                <img src="{{ asset('assets/images/star-sm.png') }}" class="star-3-profile" alt="vector" width="3%">
                <img src="{{ asset('assets/images/star-sm.png') }}" class="star-4-profile" alt="vector" width="1%">
                <img src="{{ asset('assets/images/rocket.png') }}" class="rocket-profile" alt="vector" width="5%">
                <img src="{{ asset('assets/images/ufo.png') }}" class="ufo-profile" alt="vector" width="7%">
                <img src="{{ asset('assets/images/icon_panah.png') }}" class="panah-profile" alt="vector" width="10%">

                {{-- <div class="star-1-profile"> </div>
                <div class="star-2-profile"> </div>
                <div class="star-3-profile"> </div>
                <div class="star-4-profile"> </div>
                <div class="rocket-profile"> </div>
                <div class="ufo-profile"> </div>
                <div class="panah-profile"> </div> --}}

            </div>
            <div class="center">
                <img src="{{ asset('assets/images/icon-jenjang.png') }}" class="center" alt="logo jenjang" width="3%">
                <h6 class="mt-1" style="color: #ED145B">Sekolah Rabbani</h6>
                <h4 class="mb-3">Visi Misi</h4>
            </div>
            <div class="center mt-3">
                <a class="btn btn-primary mb-3"> <h3> Visi </h3> </a>
                <h4>"Menyiapkan peserta didik calon pemimpin dan pengusaha muslim yang Berjiwa Qur’ani dalam menyosong kegemilangan Islam."
                </h4>
            </div>
            <div class="center mt-3">
                <a class="btn btn-blue mb-3"> <h3> Misi </h3> </a>
            </div>
            <ol class="mx-auto" style="display: table">
                <li> Sebagai Lembaga Pendidikan yang berdakwah untuk menyiapkan calon pengusaha muslim yang Qur’ani </li>
                <li> Memberikan layanan Pendidikan Qur’ani yang berkualitas </li>
                <li> Mewujudkan lingkungan Pendidikan Rabbani yang terintegrasikan dengan keluarga dan masyarakat </li>
                <li> Menjadikan nilai-nilai Al-Qur’an dan As Sunnah sebagai sumber aktivitas Pendidikan </li>
                <li> Menyelenggarakan kegiatan belajar berbasis Project Based Learning, Habbit Learning, Quran Based Learning, Design Thinking, dan Contextual Learning. </li>
            </ol>
            <br>
            <br>

            {{-- Lokasi --}}
            <div class="vector mt-4">
            </div>
            <div class="center mt-3">
                <img src="{{ asset('assets/images/icon-jenjang.png') }}" class="center" alt="logo program" width="3%">
                <h6 class="mt-1" style="color: #ED145B">Sekolah Rabbani</h6>
                <h4 class="mb-3">Lokasi</h4>
                <p> Sekolah Rabbani mempunyai sekolah yang tersebar di beberapa Kota di Indonesia </p>
            </div>
            <div class="d-flex row center">
                @foreach ($lokasi as $item)
                <div class="col-md-4">
                    <img src="{{ asset($item->image) }}" alt="sr_{{$item->lokasi}}" width="100%">
                </div>
                @endforeach
            </div>
            <br>
        </div>
    </div>
        
    <div class="fasilitas">
        <div class="container">
            {{-- core value --}}
            <div class="vector">
            </div>
            <div class="center">
                <img src="{{ asset('assets/images/icon-jenjang.png') }}" class="center" alt="logo program" width="3%">
                <h6 class="mt-1" style="color: #ED145B">Value</h6>
                <h4 class="mb-3">Core Value</h4>
                <p> Sekolah Rabbani mempunyai Quality Assurance (Kualitas Asuransi) untuk menerapkan karakter pada peserta didik </p>
            </div>
            <div class="d-flex mt-4">
                <div class="center">
                    <img src="{{ asset('assets/images/icon_quran.png') }}" alt="icon_quran" width="70%">
                    <h6 class="mt-3"> Quranic </h6>
                    <span>Gemar berinteraksi dengan Al-Qur’an, dan bersemangat untuk belajar serta mengajarkan Al-Qur’an
                    </span>
                </div>
                <div class=" center mx-2">
                    <img src="{{ asset('assets/images/icon_leader.png') }}" alt="icon_leader" width="70%">
                    <h6 class="mt-3"> Leader </h6>
                    <span> Menjadi teladan dalam kebaikan, berakidah kuat, beradab islami, 
                        berakhlakul kharimah, dan mempunyai kemampuan public speaking yang baik. 
                    </span>
                </div>
                <div class="center">
                    <img src="{{ asset('assets/images/icon_preneur.png') }}" alt="icon_preneur" width="70%">
                    <h6 class="mt-3"> Preneur </h6>
                    <span> Mandiri, produktif berkarya, berani menghadapi tantangan dan 
                        mengambil keputusan, kreatif dan berpenghasilan sejak dini. 
                    </span>
                </div>
            </div>
            <br>
            <br>
            
            {{-- ekstrakurikuler --}}
            <div class="vector mt-4">
                
            </div>
            {{-- <div class="center mt-3">
                <img src="{{ asset('assets/images/icon-jenjang.png') }}" class="center" alt="logo program" width="3%">
                <h6 class="mt-1" style="color: #ED145B">Menembus Batas</h6>
                <h4 class="mb-3">Ekstrakurikuler Sekolah</h4>
                <p> Eksplorasi kegiatan Ekstrakurikuler yang Inspiratif dan beragam di Sekolah Rabbani untuk menggali potensi Siswa. </p>
            </div>
            <div class="d-flex mt-4">
                <div class="center">
                    <img src="{{ asset('assets/images/memanah.png') }}" alt="ekskul_memanah" width="60%">
                    <h6 class="mt-3"> Memanah </h6>
                    <span> Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    </span>
                </div>
                <div class=" center mx-2">
                    <img src="{{ asset('assets/images/berkuda.png') }}" alt="ekskul_berkuda" width="60%">
                    <h6 class="mt-3"> Berkuda </h6>
                    <span> Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                    </span>
                </div>
                <div class="center">
                    <img src="{{ asset('assets/images/beladiri.png') }}" alt="ekskul_bela_diri" width="60%">
                    <h6 class="mt-3"> Bela Diri </h6>
                    <span> Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                    </span>
                </div>
            </div> --}}
            <br>
            <br>
        </div>
    </div>
                
@endsection