@extends('layouts.app')
<style>
    input[readonly] {
        background-color: #f0f0f0; /* Warna abu-abu */
        cursor: not-allowed; /* Mengubah kursor menjadi tanda tidak diizinkan */
    }
    .text-muted {
        color: #6c757d; /* Warna abu-abu */
        font-size: 0.8rem; /* Ukuran font sedikit lebih kecil */
    }

</style>
@section('content')
    <div class="">
        <img class="banner-2" src="{{ asset('assets/images/home_rabbani_school-2.png') }}" alt="banner">
    </div>
    <div class="container" style="position: relative; z-index:1000">
        <div class="row mx-auto">
            <div class="col-md">
                <h6 class="mt-1" style="color: #ED145B">Pemenuhan Data</h6>
                <h4 class="mb-3">Data Calon Siswa</h4>
                <form action="{{route('form.update')}}"  method="GET">
                    <div class="form-group">
                    <div class="d-flex">
                        <input type="text" name="no_registrasi" data-pertanyaan="No Registrasi/Pendaftaran" data-tab="Data Anak" id="no_registrasi" class="form-control form-control-sm px-3" aria-label=".form-control-sm px-3 example" value="{{$no_registrasi}}" placeholder="Masukkan No Registrasi/Pendaftaran">
                        <button type="submit" class="btn btn-primary mx-3"> Cari </button>
                    </div>
                    </div>
                    <small> Lupa No Registrasi/Pendaftaran ? <a href="#" data-bs-toggle="modal" data-bs-target="#lupa_no_regis"> Klik Disini </a> </small>
                </form>
                @if ($get_profile != null && $is_lunas == 1)
                    <form action="{{route('form.update.id', $get_profile->id_anak)}}" id="update_data_pendaftaran"  method="post">
                        @csrf @method('PUT')
                        <nav>
                            <div class="nav nav-tabs mt-3" id="nav-tab" role="tablist">
                                <button class="nav-link tab-1 active" id="nav-data-anak-tab" data-bs-toggle="tab" data-bs-target="#nav-data-anak" type="button" role="tab" aria-controls="nav-data-anak" aria-selected="true">Data Anak</button>
                                <button class="nav-link tab-2" id="nav-data-ibu-tab" data-bs-toggle="tab" data-bs-target="#nav-data-ibu" type="button" role="tab" aria-controls="nav-data-ibu" aria-selected="false">Data Ibu</button>
                                <button class="nav-link tab-3" id="nav-data-ayah-tab" data-bs-toggle="tab" data-bs-target="#nav-data-ayah" type="button" role="tab" aria-controls="nav-data-ayah" aria-selected="false">Data Ayah</button>
                                <button class="nav-link tab-4" id="nav-data-wali-tab" data-bs-toggle="tab" data-bs-target="#nav-data-wali" type="button" role="tab" aria-controls="nav-data-wali" aria-selected="false">Data Wali</button>
                                <button class="nav-link tab-5" id="nav-data-perkembangan-anak-1-tab" data-bs-toggle="tab" data-bs-target="#nav-data-perkembangan-anak-1" type="button" role="tab" aria-controls="nav-data-perkembangan-anak-1" aria-selected="false">Perkembangan Anak 1</button>
                                <button class="nav-link tab-6" id="nav-data-perkembangan-anak-2-tab" data-bs-toggle="tab" data-bs-target="#nav-data-perkembangan-anak-2" type="button" role="tab" aria-controls="nav-data-perkembangan-anak-2" aria-selected="false">Perkembangan Anak 2</button>
                                <button class="nav-link tab-7" id="nav-data-pengasuhan-tab" data-bs-toggle="tab" data-bs-target="#nav-data-pengasuhan" type="button" role="tab" aria-controls="nav-data-pengasuhan" aria-selected="false">Pengasuhan</button>
                            </div>
                        </nav>

                        <div class="tab-content" id="nav-tabContent">

                            {{-- NAV DATA ANAK --}}
                            <div class="tab-pane fade show active" id="nav-data-anak" role="tabpanel" aria-labelledby="nav-data-anak-tab" tabindex="0">
                                <div class="my-3">
                                    <span for="nama_lengkap" class="form-label">Nama Lengkap<span style="color: red;">*</span></span>
                                    <input type="text" name="nama_lengkap"  data-tab="Data Anak" class="form-control form-control-sm px-3" id="nama_lengkap" value="{{$get_profile->nama_lengkap }}" readonly>
                                </div>
            
                                <div class="mb-3">
                                    <span for="tempat_tanggal_lahir" class="form-label">Tempat, Tanggal Lahir<span style="color: red;">*</span></span>
                                    <input type="text" name="tempat_tanggal_lahir"  data-tab="Data Anak" id="tempat_tanggal_lahir" class="form-control form-control-sm px-3" value="{{$get_profile->tempat_lahir}}, {{date('d F Y', strtotime($get_profile->tgl_lahir))}}"  readonly>
                                </div>

                                <div class="mb-3">
                                    <span for="nama_panggilan" class="form-label">Nama Panggilan<span style="color: red;">*</span></span>
                                    <input type="text" name="nama_panggilan" data-pertanyaan="Nama Panggilan" data-tab="Data Anak" class="form-control form-control-sm px-3" id="nama_panggilan" value="{{$get_profile->nama_panggilan }}" required>
                                </div>
            
                                <div class="mb-3">
                                    <span for="nik" class="form-label">Nomor Induk Kependudukan (NIK)<span style="color: red;">*</span></span>
                                    <input type="tel" name="nik" data-pertanyaan="NIK"  data-tab="Data Anak" class="form-control form-control-sm px-3" id="nik" onkeypress="return /[0-9]/i.test(event.key)" minlength="16" value="{{$get_profile->no_nik }}" placeholder="Masukkan No NIK" required>
                                </div>
            
                                <div class="mb-3">
                                    <span for="alamat" class="form-label">Alamat Sekarang<span style="color: red;">*</span></span>
                                    <input type="text" name="alamat" data-pertanyaan="Alamat Sekarang"  data-tab="Data Anak" class="form-control form-control-sm px-3" id="alamat" value="{{$get_profile->alamat}}" placeholder="Jalan, No. RT/RW" required>
                                </div>
                                
                                <div class="mb-3">
                                    <span for="provinsi" class="form-label">Provinsi<span style="color: red;">*</span></span>
                                    <select id="provinsi" name="provinsi" data-pertanyaan="Provinsi" data-tab="Data Anak" class="select form-control form-control-sm px-3"  onchange="getKota()" required>
                                        <option value="" disabled selected>-- Pilih Provinsi--</option>
                                        @foreach ($provinsi as $item)
                                            <option value="{{ $item->id }}" {{($get_profile->provinsi == $item->id) ? 'selected' : ''}} >{{ $item->provinsi }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <span for="kota" class="form-label">Kabupaten/Kota<span style="color: red;">*</span></span>
                                    <select id="kota" name="kota" data-pertanyaan="Kabupaten/Kota" data-tab="Data Anak" class="select form-control form-control-sm px-3" onchange="getKecamatan()" required>
                                        @if ($get_profile->kota == null)
                                            <option disabled selected>-- Pilih Kota--</option>
                                        @else
                                            @foreach ($kota as $item)
                                                <option value="{{ $item->id }}" {{($get_profile->kota == $item->id) ? 'selected' : ''}} >{{ $item->kabupaten_kota }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <span for="kecamatan" class="form-label">Kecamatan<span style="color: red;">*</span></span>
                                    <select id="kecamatan" name="kecamatan" data-pertanyaan="Kecamatan" data-tab="Data Anak" class="select form-control form-control-sm px-3" onchange="getKelurahan()" required>
                                        @if ($get_profile->kecamatan == null)
                                            <option value="" disabled selected>-- Pilih Kecamatan--</option>
                                        @else 
                                            @foreach ($kecamatan as $item)
                                                <option value="{{ $item->id }}" {{($get_profile->kecamatan == $item->id) ? 'selected' : ''}} >{{ $item->kecamatan }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <span for="kelurahan" class="form-label">Desa/Kelurahan<span style="color: red;">*</span></span>
                                    <select id="kelurahan" name="kelurahan" data-pertanyaan="Desa/Kelurahan" data-tab="Data Anak" class="select form-control form-control-sm px-3">
                                        @if ($get_profile->kelurahan == null)
                                            <option value="" disabled selected>-- Pilih Desa/Kelurahan --</option>
                                        @else
                                            @foreach ($kelurahan as $item)
                                                <option value="{{ $item->id }}" {{($get_profile->kelurahan == $item->id) ? 'selected' : ''}} >{{ $item->kelurahan }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <span for="status_tinggal" class="form-label">Status Tinggal<span style="color: red;">*</span></span>
                                    <select id="status_tinggal" name="status_tinggal" data-pertanyaan="Status Tinggal" data-tab="Data Anak" class="select form-control form-control-sm px-3" required>
                                        <option value="" disabled selected>-- Pilih Status Tinggal Bersama --</option>
                                        <option value="Orang Tua" {{($get_profile->status_tinggal == 'Orang Tua') ? 'selected' : ''}} >Orang Tua</option>
                                        <option value="Wali" {{($get_profile->status_tinggal == 'Wali') ? 'selected' : ''}} >Wali</option>
                                        <option value="Kost" {{($get_profile->status_tinggal == 'Kost') ? 'selected' : ''}} >Kost</option>
                                        <option value="Asrama" {{($get_profile->status_tinggal == 'Asrama') ? 'selected' : ''}} >Asrama</option>
                                        <option value="Panti Asuhan" {{($get_profile->status_tinggal == 'Panti Asuhan') ? 'selected' : ''}} >Panti Asuhan</option>
                                        <option value="Pesantren" {{($get_profile->status_tinggal == 'Pesantren') ? 'selected' : ''}} >Pesantren</option>            
                                        <option value="Lainnya" {{($get_profile->status_tinggal == 'Lainnya') ? 'selected' : ''}} >Lainnya</option>
                                    </select>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <span for="anak_ke" class="form-label">Anak Ke<span style="color: red;">*</span></span>
                                        <input type="number" class="form-control form-control-sm px-3" id="anak_ke" name="anak_ke" data-pertanyaan="Anak Ke"  data-tab="Data Anak" value="{{$get_profile->anak_ke}}"  placeholder="Anak Ke" required >
                                    </div>
                                    <div class="col-md-6">
                                        <span for="jumlah_saudara" class="form-label">Dari Jumlah Saudara<span style="color: red;">*</span></span>
                                        <input type="number" type="text" class="form-control form-control-sm px-3" id="jumlah_saudara" name="jumlah_saudara"  data-pertanyaan="Dari Jumlah Saudara" data-tab="Data Anak" value="{{$get_profile->jml_sdr}}"  placeholder="dari berapa saudara" required >
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <span for="tinggi_badan" class="form-label">Tinggi Badan (cm)<span style="color: red;">*</span></span>
                                    <input type="number" name="tinggi_badan" data-pertanyaan="Tinggi Badan"  data-tab="Data Anak" class="form-control form-control-sm px-3" id="tinggi_badan" value="{{$get_profile->tinggi_badan}}"  placeholder="xxx" required>
                                </div>
            
                                <div class="mb-3">
                                    <span for="berat_badan" class="form-label">Berat Badan (kg)<span style="color: red;">*</span></span>
                                    <input type="number" name="berat_badan" data-pertanyaan="Berat Badan"  data-tab="Data Anak" class="form-control form-control-sm px-3" id="berat_badan" value="{{$get_profile->berat_badan}}"  placeholder="xx" required>
                                </div>
                                

                                <div class="mb-3">
                                    <span for="bhs_digunakan" class="form-label">Bahasa yang Digunakan<span style="color: red;">*</span></span>
                                    <select id="bhs_digunakan" name="bhs_digunakan" data-pertanyaan="Bahasa yang Digunakan"  data-tab="Data Anak" class="select form-control form-control-sm px-3">
                                        <option value="" disabled selected>-- Pilih Bahasa --</option>
                                        <option value="bhs_indo" {{($get_profile->bahasa == 'bhs_indo') ? 'selected' : ''}}>Bahasa Indonesia</option>
                                        <option value="bhs_inggris" {{($get_profile->bahasa == 'bhs_inggris') ? 'selected' : ''}}>Bahasa Inggris</option>
                                        <option value="bhs_arab" {{($get_profile->bahasa == 'bhs_arab') ? 'selected' : ''}}>Bahasa Arab</option>
                                        <option value="bhs_sunda" {{($get_profile->bahasa == 'bhs_sunda') ? 'selected' : ''}}>Bahasa Sunda</option>
                                        <option value="bhs_jawa" {{($get_profile->bahasa == 'bhs_jawa') ? 'selected' : ''}}>Bahasa Jawa</option>
                                        <option value="lainnya" {{($get_profile->bahasa == 'lainnya') ? 'selected' : ''}}>Lainnya</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <span for="asal_sekolah" class="form-label">Asal Sekolah</span>
                                    <input class="form-control form-control-sm px-3" id="asal_sekolah" d name="asal_sekolah"  data-tab="Data Anak" value="{{ $get_profile->asal_sekolah ? $get_profile->asal_sekolah : '-' }}" placeholder="Sekolah Sebelumnya" required readonly>
                                </div>
                             
                                <div class="mb-3">
                                    <span for="npsn" class="form-label">NPSN</span>
                                    <input class="form-control form-control-sm px-3" id="npsn" name="npsn"  data-tab="Data Anak" value="{{$get_profile->npsn}}"  placeholder="Nomor Pokok Siswa Nasional"  >
                                </div>

                                <div class="mb-3">
                                    <span for="kec_asal_sekolah" class="form-label">Kecamatan Asal Sekolah</span>
                                    <select id="kec_asal_sekolah" name="kec_asal_sekolah"  data-tab="Data Anak" class="select2 form-control form-control-sm px-3">
                                        <option value="" disabled selected>-- Pilih Kecamatan Asal Sekolah--</option>
                                        @foreach ($kecamatan_asal_sekolah as $item)
                                            <option value="{{ $item->id_kecamatan }}" {{($get_profile->kec_asal_sekolah == $item->id_kecamatan) ? 'selected' : '' }} >{{ $item->kecamatan }} - {{ $item->kabupaten_kota }} </option>
                                        @endforeach
                                    </select>
                                </div>
            
                                <div class="mb-3">
                                    <span for="agama" class="form-label">Agama<span style="color: red;">*</span></span>
                                    <input type="text" name="agama"  data-tab="Data Anak" class="form-control form-control-sm px-3" id="agama" value="{{$get_profile->agama}}" placeholder="Agama" required>
                                </div>
            
                                <div class="mb-3">
                                    <span for="gol_darah" class="form-label">Golongan Darah<span style="color: red;">*</span></span>
                                    <select id="gol_darah" name="gol_darah"  data-tab="Data Anak" class="select form-control form-control-sm px-3" required>
                                        <option value="" disabled selected>-- Pilih Golongan Darah --</option>
                                        <option value="A" {{($get_profile->gol_darah == 'A') ? 'selected' : ''}}>A</option>
                                        <option value="B" {{($get_profile->gol_darah == 'B') ? 'selected' : ''}}>B</option>
                                        <option value="AB" {{($get_profile->gol_darah == 'AB') ? 'selected' : ''}}>AB</option>
                                        <option value="O" {{($get_profile->gol_darah == 'O') ? 'selected' : ''}}>O</option>
                                    </select>
                                </div>
            
                                <div class="mb-3">
                                    <span for="hafalan" class="form-label">Hafalan Juz<span style="color: red;">*</span></span>
                                    <input type="number" name="hafalan"  data-tab="Data Anak" class="form-control form-control-sm px-3" id="hafalan" value="{{$get_profile->hafalan}}" placeholder="Sudah hafal berapa juz" required>
                                </div>

                                <div class="mb-3">
                                    <span for="riwayat_penyakit" class="form-label">Riwayat Kesehatan (Jika Ada)</span>
                                    <br><small class="text-muted">Riwayat Dirawat di RS (Tahun Berapa) - Sakit Apa - Lama Dirawat - Intervensi yang Dilakukan - Keterangan</small>
                                    <br><small class="text-muted"><strong>Contoh:</strong> 2021 - Tipes - 5 hari - Rawat inap dan infus - Sembuh total, kontrol 2 minggu</small>
                                    <input type="text" name="riwayat_penyakit"  data-tab="Data Anak" class="form-control form-control-sm px-3" value="{{$get_profile->riwayat_penyakit}}" id="riwayat_penyakit" placeholder="Riwayat Penyakit" required>
                                </div>

                                 <div class="my-3">
                                    <span for="info_detail_saudara" class="form-label">Data Saudara <span style="color: red;">*</span></span>
                                    <br><small class="text-muted">Nama-Usia-Jenis Kelamin-Keterangan</small>
                                    <br><small class="text-muted"><strong>Contoh:</strong><br>Diana-15-Perempuan-Kandung<br>Shinta-13-Perempuan-Kandung</small>
                                    <div id="inputContainerSaudara">
                                        @php
                                            // Pecah data info_detail_saudara menjadi array
                                            $saudaraList = !empty($get_profile->info_detail_saudara) ? explode(';', $get_profile->info_detail_saudara) : [''];
                                        @endphp
                                        @foreach ($saudaraList as $index => $saudara)
                                            <div class="input-group mb-2" style="max-width: 500px; border: none;">
                                                <input type="text" 
                                                    name="info_detail_saudara[]" 
                                                    class="form-control form-control-sm" 
                                                    placeholder="Nama-Usia-Jenis Kelamin-Keterangan"
                                                    data-pertanyaan="Data Saudara"
                                                     data-tab="Data Anak"
                                                    value="{{ $saudara }}">
                                                @if ($loop->count > 1)
                                                    <button type="button" 
                                                            class="btn btn-outline-danger btn-sm ms-2" 
                                                            style="border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;" 
                                                            onclick="removeInputSaudara(this)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @endif
                                                @if ($loop->last)
                                                    <button type="button" 
                                                            class="btn btn-outline-primary btn-sm add-button-saudara ms-2" 
                                                            style="border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;" 
                                                            onclick="addInputSaudara()">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="my-3">
                                    <span for="info_detail_tempat" class="form-label">Informasi Tempat Tinggal<span style="color: red;">*</span></span>
                                    <br><small class="text-muted">Nama - Keterangan</small>
                                    <br><small class="text-muted"><strong>Contoh:</strong><br>Ninda - Ibu<br>Toni - Ayah</small>
                                    <div id="inputContainer">
                                        @php
                                            // Pecah data info_detail_saudara menjadi array
                                            $tinggalList = !empty($get_profile->info_detail_tempat) ? explode(';', $get_profile->info_detail_tempat) : [''];
                                        @endphp
                                        @foreach ($tinggalList as $index => $tinggal)
                                            <div class="input-group mb-2" style="max-width: 500px; border: none;">
                                                <input type="text" 
                                                    name="info_detail_tempat[]" 
                                                    class="form-control form-control-sm" 
                                                    placeholder="Nama - Keterangan"
                                                    data-pertanyaan="Informasi Tempat Tinggal"
                                                     data-tab="Data Anak" 
                                                    value="{{$tinggal}}"
                                                >
                                                @if ($loop->count > 1)
                                                    <button type="button" 
                                                            class="btn btn-outline-danger btn-sm ms-2" 
                                                            style="border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;" 
                                                            onclick="removeInput(this)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @endif
                                                @if ($loop->last)
                                                    <button type="button" 
                                                            class="btn btn-outline-primary btn-sm add-button-saudara ms-2" 
                                                            style="border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;" 
                                                            onclick="addInput()">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        @endforeach
                                        
                                    </div>
                                </div>

                                <div class="my-3">
                                    <span for="info_detail_khusus" class="form-label">Kebutuhan Khusus dan Terapi (Jika Ada)<span style="color: red;">*</span></span>
                                        <br>
                                        <div class="form-check form-check-inline">
                                            <input 
                                                type="radio" 
                                                name="info_apakah_abk" 
                                                 data-tab="Data Anak" 
                                                data-pertanyaan="Kebutuhan Khusus dan Terapi"
                                                id="info_apakah_abk_ya" 
                                                class="form-check-input" 
                                                value="ya" 
                                                {{ $get_profile->info_apakah_abk == 'ya' ? 'checked' : '' }} 
                                                required
                                                onchange="toggleInputContainer()"
                                            >
                                            <label class="form-check-label" style="margin-left: 2px;" for="info_apakah_abk_ya">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input 
                                                type="radio" 
                                                name="info_apakah_abk" 
                                                data-pertanyaan="Kebutuhan Khusus dan Terapi"
                                                 data-tab="Data Anak" 
                                                id="info_apakah_abk_tidak" 
                                                class="form-check-input" 
                                                value="tidak" 
                                                {{ is_null($get_profile->info_apakah_abk) || $get_profile->info_apakah_abk != 'ya' ? 'checked' : '' }} 
                                                required
                                                onchange="toggleInputContainer()"
                                            >
                                            <label class="form-check-label" style="margin-left: 2px;" for="info_apakah_abk_tidak">Tidak</label>
                                        </div>
                                    @if ($get_profile->info_apakah_abk == 'ya')
                                        <div id="inputSectionKhusus"> 
                                            <br><small class="text-muted-khusus">Jenis Terapi - Tempat Terapi - Frekuensi Terapi - Dilaksanakan pada tahun - Hasil terapi</small>
                                            <br><small class="text-muted-khusus"><strong>Contoh:</strong><br>Terapi Wicara - Klinik Tumbuh Kembang X - 2 kali seminggu - 2023  - Kemampuan berbicara semakin lancar</small>
                                            <div id="inputContainerKhusus">
                                                @php
                                                    // Pecah data info_detail_saudara menjadi array
                                                    $khususList = !empty($get_profile->info_detail_khusus) ? explode(';', $get_profile->info_detail_khusus) : [''];
                                                @endphp
                                                @foreach ($khususList as $index => $khusus)
                                                    <div class="input-group mb-2" style="max-width: 900px; border: none;">
                                                        <input type="text" 
                                                            name="info_detail_khusus[]"
                                                            data-pertanyaan="Kebutuhan Khusus dan Terapi"
                                                            data-tab="Data Anak" 
                                                            class="form-control form-control-sm"
                                                            placeholder="Jenis Terapi - Tempat Terapi - Frekuensi Terapi - Dilaksanakan pada tahun - Hasil terapi"
                                                            value="{{$khusus}}"
                                                        >
                                                        @if ($loop->count > 1)
                                                            <button type="button" 
                                                                    class="btn btn-outline-danger btn-sm ms-2" 
                                                                    style="border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;" 
                                                                    onclick="removeInputKhusus(this)">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        @endif
                                                        @if ($loop->last)
                                                            <button type="button" 
                                                                    class="btn btn-outline-primary btn-sm add-button-saudara ms-2" 
                                                                    style="border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;" 
                                                                    onclick="addInputKhusus()">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <div id="inputSectionKhusus" style="display: none;"> 
                                            <small class="text-muted-khusus">Jenis Terapi - Tempat Terapi - Frekuensi Terapi - Dilaksanakan pada tahun - Hasil terapi</small>
                                            <small class="text-muted-khusus"><strong>Contoh:</strong><br>Terapi Wicara - Klinik Tumbuh Kembang X - 2 kali seminggu - 2023  - Kemampuan berbicara semakin lancar</small>
                                            <div id="inputContainerKhusus">
                                                @php
                                                    // Pecah data info_detail_saudara menjadi array
                                                    $khususList = !empty($get_profile->info_detail_khusus) ? explode(';', $get_profile->info_detail_khusus) : [''];
                                                @endphp
                                                @foreach ($khususList as $index => $khusus)
                                                    <div class="input-group mb-2" style="max-width: 900px; border: none;">
                                                        <input type="text" 
                                                            name="info_detail_khusus[]"
                                                            data-pertanyaan="Kebutuhan Khusus dan Terapi"
                                                            data-tab="Data Anak" 
                                                            class="form-control form-control-sm"
                                                            placeholder="Jenis Terapi - Tempat Terapi - Frekuensi Terapi - Dilaksanakan pada tahun - Hasil terapi"
                                                            value="{{$khusus}}"
                                                        >
                                                        @if ($loop->count > 1)
                                                            <button type="button" 
                                                                    class="btn btn-outline-danger btn-sm ms-2" 
                                                                    style="border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;" 
                                                                    onclick="removeInputKhusus(this)">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        @endif
                                                        @if ($loop->last)
                                                            <button type="button" 
                                                                    class="btn btn-outline-primary btn-sm add-button-saudara ms-2" 
                                                                    style="border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;" 
                                                                    onclick="addInputKhusus()">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                
                                {{-- <button type="button" class="btn btn-primary btn-sm px-3" onclick="next_ibu()"> Next </button> --}}
                                <a style="float: right" id="next-ibu" class="btn btn-primary btn-sm px-3">Next</a>

                            </div>

                            {{-- NAV DATA IBU --}}
                            <div class="tab-pane fade" id="nav-data-ibu" role="tabpanel" aria-labelledby="nav-data-ibu-tab" tabindex="0">
                                <div class="my-3">
                                    <span for="nama_ibu" class="form-label">Nama Lengkap Ibu<span style="color: red;">*</span></span>
                                    <input type="text" name="nama_ibu" data-tab="Data Ibu" class="form-control form-control-sm px-3" id="nama_ibu" placeholder="Nama Ibu"  value="{{$get_profile_ibu != null ? $get_profile_ibu->nama : ''}}" readonly>
                                </div>

                                <div class="mb-3">
                                    <span for="email_ibu" class="form-label">Email Ibu<span style="color: red;">*</span></span>
                                    <input type="email" name="email_ibu" data-tab="Data Ibu" class="form-control form-control-sm px-3" id="email_ibu" value="{{$get_profile_ibu->email_ibu}}" placeholder="Email Ibu" required>
                                </div>
            
                                <div class="row mb-3">
                                    <div class=" col-md-6">
                                        <span for="tempat_lahir_ibu" class="form-label">Tempat Lahir<span style="color: red;">*</span></span>
                                        <input class="form-control form-control-sm px-3" id="tempat_lahir_ibu" data-tab="Data Ibu" name="tempat_lahir_ibu" value="{{$get_profile_ibu->tptlahir_ibu}}" placeholder="Tempat Lahir" required  >
                                    </div>
                                    <div class=" col-md-6">
                                        <span for="tgl_lahir_ibu" class="form-label">Tanggal Lahir<span style="color: red;">*</span></span>
                                        <input type="date" class="form-control form-control-sm px-3" id="tgl_lahir_ibu" data-tab="Data Ibu" name="tgl_lahir_ibu" value="{{$get_profile_ibu->tgllahir_ibu}}" placeholder="Tanggal Lahir" required >
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <span for="pekerjaan_ibu" class="form-label">Pekerjaan Ibu<span style="color: red;">*</span></span>
                                    <select id="pekerjaan_ibu" name="pekerjaan_ibu" data-tab="Data Ibu" class="select form-control form-control-sm px-3" required>
                                        <option value="" disabled selected>-- Pilih Pekerjaan --</option>
                                        @foreach ($list_pekerjaan_ibu as $item)
                                            <option value="{{ $item->id }}" {{($get_profile_ibu->pekerjaan_jabatan == $item->id) ? 'selected' : ''}} >{{ $item->pekerjaan }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <span for="penghasilan_ibu" class="form-label">Penghasilan Ibu<span style="color: red;">*</span></span>
                                    <select id="penghasilan_ibu" name="penghasilan_ibu" data-tab="Data Ibu" class="select form-control form-control-sm px-3" required>
                                        <option value="" disabled selected>-- Pilih Penghasilan --</option>
                                        <option value="1" {{($get_profile_ibu->penghasilan == '1') ? 'selected' : ''}} >< Rp. 3.000.000</option>
                                        <option value="2" {{($get_profile_ibu->penghasilan == '2') ? 'selected' : ''}} >Rp. 3.000.000 - Rp. 5.000.000</option>
                                        <option value="3" {{($get_profile_ibu->penghasilan == '3') ? 'selected' : ''}} >Rp. 5.000.000 - Rp. 8.000.000</option>
                                        <option value="4" {{($get_profile_ibu->penghasilan == '4') ? 'selected' : ''}} >Rp. 8.000.000 - Rp. 10.000.000</option>
                                        <option value="5" {{($get_profile_ibu->penghasilan == '5') ? 'selected' : ''}} >Rp. 10.000.000 - Rp. 15.000.000</option>
                                        <option value="6" {{($get_profile_ibu->penghasilan == '6') ? 'selected' : ''}} >> Rp. 15.000.000</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <span for="pendidikan_ibu" class="form-label">Pendidikan Terakhir Ibu<span style="color: red;">*</span></span>
                                    <select id="pendidikan_ibu" name="pendidikan_ibu" data-tab="Data Ibu" class="select form-control form-control-sm px-3" required>
                                        <option value="" disabled selected>-- Pilih Pendidikan --</option>
                                        <option value="SMP" {{($get_profile_ibu->pendidikan_ibu == 'SMP') ? 'selected' : ''}} >SMP</option>
                                        <option value="SMA" {{($get_profile_ibu->pendidikan_ibu == 'SMA') ? 'selected' : ''}} >SMA</option>
                                        <option value="Diploma" {{($get_profile_ibu->pendidikan_ibu == 'Diploma') ? 'selected' : ''}} >Diploma</option>
                                        <option value="S1" {{($get_profile_ibu->pendidikan_ibu == 'S1') ? 'selected' : ''}} >S1 / D4</option>
                                        <option value="S2" {{($get_profile_ibu->pendidikan_ibu == 'S2') ? 'selected' : ''}} >S2</option>
                                        <option value="S3" {{($get_profile_ibu->pendidikan_ibu == 'S3') ? 'selected' : ''}} >S3</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <span for="tahun_nikah_ibu" class="form-label">Tahun Menikah<span style="color: red;">*</span></span>
                                    <input type="number" name="tahun_nikah_ibu" data-tab="Data Ibu" class="form-control form-control-sm px-3" id="tahun_nikah_ibu" value="{{$get_profile_ibu->tahun_nikah_ibu}}" placeholder="Tahun Menikah" required>
                                </div>

                                <div class="mb-3">
                                    <span for="pernikahan_ke_ibu" class="form-label">Pernikahan Ke<span style="color: red;">*</span></span>
                                    <input type="number" name="pernikahan_ke_ibu" data-tab="Data Ibu" class="form-control form-control-sm px-3" id="tahun_nikah_ibu" value="{{$get_profile_ibu->tahun_nikah_ibu}}" placeholder="Pernikahan ke" required>
                                </div>

                                <a style="float: right" id="next-ayah" class="btn btn-primary btn-sm px-3">Next</a>

                            </div>

                            {{-- NAV DATA AYAH --}}
                            <div class="tab-pane fade" id="nav-data-ayah" role="tabpanel" aria-labelledby="nav-data-ayah-tab" tabindex="0">
                                <div class="my-3">
                                    <span for="nama_ayah" class="form-label">Nama Lengkap ayah<span style="color: red;">*</span></span>
                                    <input type="text" name="nama_ayah" data-tab="Data Ayah" class="form-control form-control-sm px-3" id="nama_ayah" value="{{$get_profile_ayah != null ? $get_profile_ayah->nama : ''}}" readonly>
                                </div>

                                <div class="mb-3">
                                    <span for="email_ayah" class="form-label">Email Ayah<span style="color: red;">*</span></span>
                                    <input type="email" name="email_ayah" data-tab="Data Ayah" class="form-control form-control-sm px-3" id="email_ayah" value="{{$get_profile_ayah->email_ayah}}" placeholder="Email Ayah" required>
                                </div>
            
                                <div class="row mb-3">
                                    <div class=" col-md-6">
                                        <span for="tempat_lahir_ayah" class="form-label">Tempat Lahir<span style="color: red;">*</span></span>
                                        <input class="form-control form-control-sm px-3" id="tempat_lahir_ayah" name="tempat_lahir_ayah" data-tab="Data Ayah" value="{{$get_profile_ayah->tptlahir_ayah}}" placeholder="Tempat Lahir" required >
                                    </div>
                                    <div class=" col-md-6">
                                        <span for="tgl_lahir_ayah" class="form-label">Tanggal Lahir<span style="color: red;">*</span></span>
                                        <input type="date" class="form-control form-control-sm px-3" id="tgl_lahir_ayah" name="tgl_lahir_ayah" data-tab="Data Ayah" value="{{$get_profile_ayah->tgllahir_ayah}}" placeholder="Tanggal Lahir" required >
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <span for="pekerjaan_ayah" class="form-label">Pekerjaan ayah<span style="color: red;">*</span></span>
                                    <select id="pekerjaan_ayah" name="pekerjaan_ayah" data-tab="Data Ayah" class="select form-control form-control-sm px-3" required>
                                        <option value="" disabled selected>-- Pilih Pekerjaan --</option>
                                        @foreach ($list_pekerjaan_ayah as $item)
                                            <option value="{{ $item->id }}" {{($get_profile_ayah->pekerjaan_jabatan == $item->id) ? 'selected' : ''}} >{{ $item->pekerjaan }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <span for="penghasilan_ayah" class="form-label">Penghasilan ayah<span style="color: red;">*</span></span>
                                    <select id="penghasilan_ayah" name="penghasilan_ayah" data-tab="Data Ayah" class="select form-control form-control-sm px-3" required>
                                        <option value="" disabled selected>-- Pilih Penghasilan --</option>
                                        <option value="1" {{($get_profile_ayah->penghasilan == '1') ? 'selected' : ''}} >< Rp. 3.000.000</option>
                                        <option value="2" {{($get_profile_ayah->penghasilan == '2') ? 'selected' : ''}} >Rp. 3.000.000 - Rp. 5.000.000</option>
                                        <option value="3" {{($get_profile_ayah->penghasilan == '3') ? 'selected' : ''}} >Rp. 5.000.000 - Rp. 8.000.000</option>
                                        <option value="4" {{($get_profile_ayah->penghasilan == '4') ? 'selected' : ''}} >Rp. 8.000.000 - Rp. 10.000.000</option>
                                        <option value="5" {{($get_profile_ayah->penghasilan == '5') ? 'selected' : ''}} >Rp. 10.000.000 - Rp. 15.000.000</option>
                                        <option value="6" {{($get_profile_ayah->penghasilan == '6') ? 'selected' : ''}} >> Rp. 15.000.000</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <span for="pendidikan_ayah" class="form-label">Pendidikan Terakhir ayah<span style="color: red;">*</span></span>
                                    <select id="pendidikan_ayah" name="pendidikan_ayah" data-tab="Data Ayah" class="select form-control form-control-sm px-3" required>
                                        <option value="" disabled selected>-- Pilih Pendidikan --</option>
                                        <option value="SMP" {{($get_profile_ayah->pendidikan_ayah == 'SMP') ? 'selected' : ''}} >SMP</option>
                                        <option value="SMA" {{($get_profile_ayah->pendidikan_ayah == 'SMA') ? 'selected' : ''}} >SMA</option>
                                        <option value="Diploma" {{($get_profile_ayah->pendidikan_ayah == 'Diploma') ? 'selected' : ''}} >Diploma</option>
                                        <option value="S1" {{($get_profile_ayah->pendidikan_ayah == 'S1') ? 'selected' : ''}} >S1 / D4</option>
                                        <option value="S2" {{($get_profile_ayah->pendidikan_ayah == 'S2') ? 'selected' : ''}} >S2</option>
                                        <option value="S3" {{($get_profile_ayah->pendidikan_ayah == 'S3') ? 'selected' : ''}} >S3</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <span for="tahun_nikah_ayah" class="form-label">Tahun Menikah<span style="color: red;">*</span></span>
                                    <input type="number" name="tahun_nikah_ayah" data-tab="Data Ayah" class="form-control form-control-sm px-3" id="tahun_nikah_ayah" value="{{$get_profile_ayah->tahun_nikah_ayah}}" placeholder="Tahun Menikah" required>
                                </div>

                                <div class="mb-3">
                                    <span for="pernikahan_ke_ayah" class="form-label">Pernikahan Ke<span style="color: red;">*</span></span>
                                    <input type="number" name="pernikahan_ke_ayah"  data-tab="Data Ayah" class="form-control form-control-sm px-3" id="pernikahan_ke_ayah" value="{{$get_profile_ayah->pernikahan_ke_ayah}}" placeholder="Pernikahan ke" required>
                                </div>

                                <a style="float: right" id="next-wali" class="btn btn-primary btn-sm px-3">Next</a>

                            </div>

                            {{-- NAV DATA WALI --}}
                            <div class="tab-pane fade" id="nav-data-wali" role="tabpanel" aria-labelledby="nav-data-wali-tab" tabindex="0">
                                <div class="my-3">
                                    <span for="nama_wali" class="form-label">Nama Lengkap Wali</span>
                                    <input type="text" name="nama_wali" class="form-control form-control-sm px-3" id="nama_wali"  data-tab="Data Wali" value="{{$get_profile_wali != null ? $get_profile_wali->nama : ''}}" placeholder="Nama wali" required>
                                </div>
            
                                <div class="row mb-3">
                                    <div class=" col-md-6">
                                        <span for="tempat_lahir_wali" class="form-label">Tempat Lahir</span>
                                        <input class="form-control form-control-sm px-3" id="tempat_lahir_wali" name="tempat_lahir_wali"  data-tab="Data Wali" value="{{$get_profile_wali !=null ? $get_profile_wali->tptlahir_wali : ''}}" placeholder="Tempat Lahir"  >
                                    </div>
                                    <div class=" col-md-6">
                                        <span for="tgl_lahir_wali" class="form-label">Tanggal Lahir</span>
                                        <input type="date" class="form-control form-control-sm px-3" id="tgl_lahir_wali" name="tgl_lahir_wali"  data-tab="Data Wali" value="{{$get_profile_wali !=null ? $get_profile_wali->tgllahir_wali : ''}}" placeholder="Tanggal Lahir"  >
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <span for="pekerjaan_wali" class="form-label">Pekerjaan wali</span>
                                    <select id="pekerjaan_wali" name="pekerjaan_wali" data-tab="Data Wali" class="select form-control form-control-sm px-3">
                                        <option value="" disabled selected>-- Pilih Pekerjaan --</option>
                                        <option value="PNS" {{($get_profile_wali !=null ? $get_profile_wali->pekerjaan_jabatan : '' == 'PNS') ? 'selected' : ''}} >PNS</option>
                                        <option value="Karyawan BUMN/BUMD" {{($get_profile_wali !=null ? $get_profile_wali->pekerjaan_jabatan : '' == 'Karyawan BUMN/BUMD') ? 'selected' : ''}}>Karyawan BUMN/BUMD</option>
                                        <option value="Karyawan Swasta" {{($get_profile_wali !=null ? $get_profile_wali->pekerjaan_jabatan : '' == 'Karyawan Swasta') ? 'selected' : ''}} >Karyawan Swasta</option>
                                        <option value="Karyawan Rabbani" {{($get_profile_wali !=null ? $get_profile_wali->pekerjaan_jabatan : '' == 'Karyawan Rabbani') ? 'selected' : ''}} >Karyawan Rabbani</option>
                                        <option value="Guru/Dosen" {{($get_profile_wali !=null ? $get_profile_wali->pekerjaan_jabatan : '' == 'Guru/Dosen') ? 'selected' : ''}} >Guru/Dosen</option>
                                        <option value="TNI/POLRI" {{($get_profile_wali !=null ? $get_profile_wali->pekerjaan_jabatan : '' == 'TNI/POLRI') ? 'selected' : ''}} >TNI/POLRI</option>
                                        <option value="Wiraswasta" {{($get_profile_wali !=null ? $get_profile_wali->pekerjaan_jabatan : '' == 'Wiraswasta') ? 'selected' : ''}} >Wiraswasta</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <span for="pendidikan_wali" class="form-label">Pendidikan Terakhir wali</span>
                                    <select id="pendidikan_wali" name="pendidikan_wali" data-tab="Data Wali" class="select form-control form-control-sm px-3">
                                        <option value="" disabled selected>-- Pilih Pendidikan --</option>
                                        <option value="SMP" {{($get_profile_wali !=null ? $get_profile_wali->pendidikan_wali : '' == 'SMP') ? 'selected' : ''}} >SMP</option>
                                        <option value="SMA" {{($get_profile_wali !=null ? $get_profile_wali->pendidikan_wali : '' == 'SMA') ? 'selected' : ''}} >SMA</option>
                                        <option value="Diploma" {{($get_profile_wali !=null ? $get_profile_wali->pendidikan_wali : '' == 'Diploma') ? 'selected' : ''}} >Diploma</option>
                                        <option value="S1" {{($get_profile_wali !=null ? $get_profile_wali->pendidikan_wali : '' == 'S1') ? 'selected' : ''}} >S1 / D4</option>
                                        <option value="S2" {{($get_profile_wali !=null ? $get_profile_wali->pendidikan_wali : '' == 'S2') ? 'selected' : ''}} >S2</option>
                                        <option value="S3" {{($get_profile_wali !=null ? $get_profile_wali->pendidikan_wali : '' == 'S3') ? 'selected' : ''}} >S3</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <span for="hubungan_wali" class="form-label">Hubungan Wali dan Peserta Didik</span>
                                    <select id="hubungan_wali" name="hubungan_wali" data-tab="Data Wali" class="select form-control form-control-sm px-3">
                                        <option value="" disabled selected>-- Pilih Hubungan Wali --</option>
                                        <option value="kakek/nenek" {{ (isset($get_profile_wali) && $get_profile_wali->hubungan_wali == 'kakek/nenek') ? 'selected' : '' }}>Kakek / Nenek</option>
                                        <option value="paman/bibi" {{ (isset($get_profile_wali) && $get_profile_wali->hubungan_wali == 'paman/bibi') ? 'selected' : '' }}>Paman / Bibi</option>
                                        <option value="kakak" {{ (isset($get_profile_wali) && $get_profile_wali->hubungan_wali == 'kakak') ? 'selected' : '' }}>Kakak</option>
                                        <option value="lainnya" {{ (isset($get_profile_wali) && $get_profile_wali->hubungan_wali == 'lainnya') ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                </div>

                                <a style="float: right" id="next-per-anak-1" class="btn btn-primary btn-sm px-3">Next</a>
                                
                            </div>

                            {{-- NAV PERKEMBANGAN ANAK 1 --}}
                            <div class="tab-pane fade" id="nav-data-perkembangan-anak-1" role="tabpanel" aria-labelledby="nav-data-perkembangan-anak-1-tab" tabindex="0">
                                <table> 
                                    <tbody>
                                    @foreach ($head_perkembangan as $head)
                                        @if ($head->kode_perkembangan == 1)
                                            <h6> {{$head->head_name}} 
                                                @if ($head->subhead_name)
                                                    <br> {{$head->subhead_name}}
                                                @endif
                                            </h6>
                                            
                                            @foreach ($pertanyaan_perkembangan as $pertanyaan)
                                                @if ($pertanyaan->kode_perkembangan == 1)
                                                    @if ($pertanyaan->head_id == $head->id)
                                                        <div class="my-3">
                                                            <span for="pertanyaan_{{$pertanyaan->head_id}}_{{$pertanyaan->id}}" class="form-label">
                                                                {{$pertanyaan->urutan}}. {{$pertanyaan->pertanyaan}}<span style="color: red;">*</span>
                                                            </span>

                                                            @php
                                                                // Cek apakah jawaban ada dan jika jawaban berupa string JSON, maka decode
                                                                $jawaban = isset($jawaban_perkembangan[$pertanyaan->id]) ? $jawaban_perkembangan[$pertanyaan->id] : null;

                                                                // Jika jawaban dalam bentuk string JSON, decode ke array
                                                                if ($jawaban && is_string($jawaban)) {
                                                                    $jawaban = json_decode($jawaban, true);
                                                                }
                                                            @endphp

                                                            @if ($pertanyaan->need_option == 1) <!-- Cek jika need_option = 1 -->
                                                                @php
                                                                    // Mengubah opsi menjadi array dari string yang dipisahkan dengan ';'
                                                                    $options = explode(';', $pertanyaan->options_data);
                                                                @endphp
                                                                <div class="form-group">
                                                                    @foreach ($options as $option)
                                                                        <div class="form-check" style="margin-left: 15px;">
                                                                            <!-- Radio Button -->
                                                                            <input 
                                                                                type="radio" 
                                                                                name="pertanyaan_{{$pertanyaan->head_id}}_{{$pertanyaan->id}}" 
                                                                                id="pertanyaan_{{$pertanyaan->head_id}}_{{$pertanyaan->id}}_{{$loop->index}}" 
                                                                                class="form-check-input" 
                                                                                data-pertanyaan="{{$pertanyaan->pertanyaan}}"
                                                                                data-tab="Perkembangan Anak 1" 
                                                                                value="{{ $option }}" 
                                                                                required
                                                                                @if ($jawaban && (
                                                                                    ($jawaban['option_field'] == $option) || 
                                                                                    ($option == 'self_fill' && $jawaban['option_field'] != '_' && !in_array($jawaban['option_field'], $options))
                                                                                )) checked @endif
                                                                            >

                                                                            <!-- Jika opsi adalah self_fill, tampilkan input teks di sampingnya -->
                                                                            @if ($option == 'self_fill')
                                                                                <input 
                                                                                    type="text" 
                                                                                    name="pertanyaan_{{$pertanyaan->head_id}}_{{$pertanyaan->id}}_self_fill" 
                                                                                    id="pertanyaan_{{$pertanyaan->head_id}}_{{$pertanyaan->id}}_self_fill" 
                                                                                    class="form-control form-control-sm" 
                                                                                    data-pertanyaan="{{$pertanyaan->pertanyaan}}"
                                                                                    data-tab="Perkembangan Anak 1" 
                                                                                    placeholder="Silakan isi..." 
                                                                                    style="margin-left: 2px; display: inline-block; width: auto;"
                                                                                    @if ($jawaban && $jawaban['option_field'] != '_' && (
                                                                                        !in_array($jawaban['option_field'], $options) || 
                                                                                        ($jawaban['option_field'] == 'self_fill' && isset($jawaban['input_field']) && $jawaban['input_field'] != '_')
                                                                                    )) 
                                                                                        value="{{ !in_array($jawaban['option_field'], $options) ? $jawaban['option_field'] : $jawaban['input_field'] }}" 
                                                                                    @endif
                                                                                >
                                                                            @else
                                                                                <label class="form-check-label" 
                                                                                    style="margin-left: 2px;"
                                                                                    for="pertanyaan_{{$pertanyaan->head_id}}_{{$pertanyaan->id}}_{{$loop->index}}">
                                                                                    {{ $option }}
                                                                                </label>
                                                                            @endif
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @else

                                                                <input 
                                                                    type="text" 
                                                                    name="pertanyaan_{{$pertanyaan->head_id}}_{{$pertanyaan->id}}"
                                                                    data-pertanyaan="{{$pertanyaan->pertanyaan}}"
                                                                    data-tab="Perkembangan Anak 1"
                                                                    class="form-control form-control-sm px-3"
                                                                    style="margin-left: 15px;" 
                                                                    id="pertanyaan_{{$pertanyaan->head_id}}_{{$pertanyaan->id}}" 
                                                                    value="{{ $jawaban ? $jawaban['input_field'] : '' }}"
                                                                    placeholder="Silakan isi.."
                                                                    required
                                                                >
                                                            @endif
                                                        </div>
                                                    @endif
                                                @endif
                                            @endforeach
                                            <br>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>

                                <a style="float: right" id="next-per-anak-2" class="btn btn-primary btn-sm px-3">Next</a>
                            
                            </div>

                            {{-- NAV PERKEMBANGAN ANAK 2 --}}
                            <div class="tab-pane fade" id="nav-data-perkembangan-anak-2" role="tabpanel" aria-labelledby="nav-data-perkembangan-anak-2-tab" tabindex="0">
                                @foreach ($head_perkembangan as $head)
                                    @if ($head->kode_perkembangan == 2)
                                        <h6> {{$head->head_name}} 
                                            @if ($head->subhead_name)
                                                <br> {{$head->subhead_name}}
                                            @endif
                                        </h6>
                                        
                                        @foreach ($pertanyaan_perkembangan as $pertanyaan)
                                            @if ($pertanyaan->kode_perkembangan == 2)
                                                @if ($pertanyaan->head_id == $head->id)
                                                    <div class="my-3">
                                                        <span for="pertanyaan_{{$pertanyaan->head_id}}_{{$pertanyaan->id}}" class="form-label">
                                                            {{$pertanyaan->urutan}}. {{$pertanyaan->pertanyaan}}<span style="color: red;">*</span>
                                                        </span>

                                                        @php
                                                            // Cek apakah jawaban ada dan jika jawaban berupa string JSON, maka decode
                                                            $jawaban = isset($jawaban_perkembangan[$pertanyaan->id]) ? $jawaban_perkembangan[$pertanyaan->id] : null;

                                                            // Jika jawaban dalam bentuk string JSON, decode ke array
                                                            if ($jawaban && is_string($jawaban)) {
                                                                $jawaban = json_decode($jawaban, true);
                                                            }
                                                        @endphp

                                                        @if ($pertanyaan->need_option == 1) <!-- Cek jika need_option = 1 -->
                                                            @php
                                                                // Mengubah opsi menjadi array dari string yang dipisahkan dengan ';'
                                                                $options = explode(';', $pertanyaan->options_data);
                                                            @endphp
                                                            <div class="form-group">
                                                                @foreach ($options as $option)
                                                                    <div class="form-check" style="margin-left: 15px;">
                                                                        <!-- Radio Button -->
                                                                        <input 
                                                                            type="radio" 
                                                                            name="pertanyaan_{{$pertanyaan->head_id}}_{{$pertanyaan->id}}" 
                                                                            id="pertanyaan_{{$pertanyaan->head_id}}_{{$pertanyaan->id}}_{{$loop->index}}" 
                                                                            class="form-check-input" 
                                                                            value="{{ $option }}" 
                                                                            data-pertanyaan="{{$pertanyaan->pertanyaan}}"
                                                                            data-tab="Perkembangan Anak 2 " 
                                                                            required
                                                                            @if ($jawaban && (
                                                                                ($jawaban['option_field'] == $option) || 
                                                                                ($option == 'self_fill' && $jawaban['option_field'] != '_' && !in_array($jawaban['option_field'], $options))
                                                                            )) checked @endif
                                                                        >

                                                                        <!-- Jika opsi adalah self_fill, tampilkan input teks di sampingnya -->
                                                                        @if ($option == 'self_fill')
                                                                            <input 
                                                                                type="text" 
                                                                                name="pertanyaan_{{$pertanyaan->head_id}}_{{$pertanyaan->id}}_self_fill" 
                                                                                id="pertanyaan_{{$pertanyaan->head_id}}_{{$pertanyaan->id}}_self_fill" 
                                                                                class="form-control form-control-sm" 
                                                                                placeholder="Silakan isi..." 
                                                                                data-pertanyaan="{{$pertanyaan->pertanyaan}}"
                                                                                data-tab="Perkembangan Anak 2 " 
                                                                                style="margin-left: 2px; display: inline-block; width: auto;"
                                                                                @if ($jawaban && $jawaban['option_field'] != '_' && (
                                                                                    !in_array($jawaban['option_field'], $options) || 
                                                                                    ($jawaban['option_field'] == 'self_fill' && isset($jawaban['input_field']) && $jawaban['input_field'] != '_')
                                                                                )) 
                                                                                    value="{{ !in_array($jawaban['option_field'], $options) ? $jawaban['option_field'] : $jawaban['input_field'] }}" 
                                                                                @endif
                                                                        >
                                                                        @else
                                                                            <label class="form-check-label" 
                                                                                style="margin-left: 2px;"
                                                                                for="pertanyaan_{{$pertanyaan->head_id}}_{{$pertanyaan->id}}_{{$loop->index}}">
                                                                                {{ $option }}
                                                                            </label>
                                                                        @endif
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @else

                                                            <input 
                                                                type="text" 
                                                                name="pertanyaan_{{$pertanyaan->head_id}}_{{$pertanyaan->id}}"
                                                                class="form-control form-control-sm px-3"
                                                                style="margin-left: 15px;" 
                                                                id="pertanyaan_{{$pertanyaan->head_id}}_{{$pertanyaan->id}}" 
                                                                value="{{ $jawaban ? $jawaban['input_field'] : '' }}" 
                                                                placeholder="Silakan isi.." 
                                                                data-pertanyaan="{{$pertanyaan->pertanyaan}}"
                                                                data-tab="Perkembangan Anak 2 " 
                                                                required
                                                            >
                                                        @endif
                                                    </div>
                                                @endif
                                            @endif
                                        @endforeach
                                        <br>
                                    @endif
                                @endforeach                                
                                <a style="float: right" id="next-pengasuhan" class="btn btn-primary btn-sm px-3 mt-3">Next</a>
                            </div>
                            
                            {{-- NAV PENGASUHAN --}}
                            <div class="tab-pane fade" id="nav-data-pengasuhan" role="tabpanel" aria-labelledby="nav-data-pengasuhan-tab" tabindex="0">
                               @foreach ($head_pengasuhan as $head)
                                    <h6> {{$head->head_name}} 
                                        @if ($head->subhead_name)
                                            <br> {{$head->subhead_name}}
                                        @endif
                                    </h6>

                                    
                                        
                                    @foreach ($pertanyaan_pengasuhan as $pertanyaan)
                                        @if ($pertanyaan->head_id == $head->id)
                                            <div class="my-3">
                                                <span for="pengasuhan_{{$pertanyaan->head_id}}_{{$pertanyaan->id}}" class="form-label">
                                                    {{$pertanyaan->urutan}}. {{$pertanyaan->pertanyaan}}<span style="color: red;">*</span>
                                                </span>
                                                @php
                                                    // Cek apakah jawaban ada dan jika jawaban berupa string JSON, maka decode
                                                    $jawaban = isset($jawaban_pengasuhan[$pertanyaan->id]) ? $jawaban_pengasuhan[$pertanyaan->id] : null;

                                                    // Jika jawaban dalam bentuk string JSON, decode ke array
                                                    if ($jawaban && is_string($jawaban)) {
                                                        $jawaban = json_decode($jawaban, true);
                                                    }
                                                @endphp

                                                @if ($pertanyaan->need_option == 1) <!-- Cek jika need_option = 1 -->
                                                    @php
                                                        // Mengubah opsi menjadi array dari string yang dipisahkan dengan ';'
                                                        $options = explode(';', $pertanyaan->options_data);
                                                    @endphp
                                                    <div class="form-group">
                                                        @foreach ($options as $option)
                                                            <div class="form-check" style="margin-left: 15px;">
                                                                <!-- Radio Button -->
                                                                <input 
                                                                    type="radio" 
                                                                    name="pengasuhan_{{$pertanyaan->head_id}}_{{$pertanyaan->id}}" 
                                                                    id="pengasuhan_{{$pertanyaan->head_id}}_{{$pertanyaan->id}}_{{$loop->index}}" 
                                                                    class="form-check-input" 
                                                                    value="{{ $option }}" 
                                                                    data-pertanyaan="{{$pertanyaan->pertanyaan}}"
                                                                    data-tab="Pengasuhan" 
                                                                    required
                                                                    @if ($jawaban && (
                                                                        ($jawaban['option_field'] == $option) || 
                                                                        ($option == 'self_fill' && $jawaban['option_field'] != '_' && !in_array($jawaban['option_field'], $options))
                                                                    )) checked 
                                                                    @endif
                                                                >

                                                                <!-- Jika opsi adalah self_fill, tampilkan input teks di sampingnya -->
                                                                @if ($option == 'self_fill')
                                                                    <input 
                                                                        type="text" 
                                                                        name="pengasuhan_{{$pertanyaan->head_id}}_{{$pertanyaan->id}}_self_fill_pengasuhan" 
                                                                        id="pengasuhan_{{$pertanyaan->head_id}}_{{$pertanyaan->id}}_self_fill_pengasuhan" 
                                                                        class="form-control form-control-sm" 
                                                                        data-pertanyaan="{{$pertanyaan->pertanyaan}}"
                                                                        data-tab="Pengasuhan"
                                                                        placeholder="Silakan isi..." 
                                                                        style="margin-left: 2px; display: inline-block; width: auto;" 
                                                                        @if ($jawaban && $jawaban['option_field'] != '_' && (
                                                                            !in_array($jawaban['option_field'], $options) || 
                                                                            ($jawaban['option_field'] == 'self_fill' && isset($jawaban['input_field']) && $jawaban['input_field'] != '_')
                                                                        )) 
                                                                            value="{{ !in_array($jawaban['option_field'], $options) ? $jawaban['option_field'] : $jawaban['input_field'] }}" 
                                                                        @endif
                                                                        >
                                                                @else
                                                                    <label class="form-check-label" 
                                                                        style="margin-left: 2px;"
                                                                        for="pengasuhan_{{$pertanyaan->head_id}}_{{$pertanyaan->id}}_{{$loop->index}}">
                                                                        {{ $option }}
                                                                    </label>
                                                                @endif
                                                               
                                                            </div>
                                                        @endforeach
                                                        @if ($pertanyaan->need_extra == 1)
                                                            <input 
                                                                type="text" 
                                                                name="pengasuhan_extra_{{$pertanyaan->head_id}}_{{$pertanyaan->id}}" 
                                                                id="pengasuhan_extra_{{$pertanyaan->head_id}}_{{$pertanyaan->id}}" 
                                                                class="form-control form-control-sm"
                                                                data-is-extra-required="{{$pertanyaan->is_extra_required}}" 
                                                                data-pertanyaan="{{$pertanyaan->pertanyaan}}"
                                                                data-tab="Pengasuhan"
                                                                placeholder= "{{$pertanyaan->extra_data}}" 
                                                                style="margin-left: 15px; display: inline-block;"
                                                                @if ($jawaban && $jawaban['option_field'] != '_' && $jawaban['input_field'] != '_' ) 
                                                                    value="{{ $jawaban['input_field'] }}" 
                                                                @endif
                                                            >
                                                        @endif
                                                    </div>
                                                @else

                                                    <input 
                                                        type="text" 
                                                        name="pengasuhan_{{$pertanyaan->head_id}}_{{$pertanyaan->id}}"
                                                        class="form-control form-control-sm px-3"
                                                        style="margin-left: 15px;" 
                                                        id="pengasuhan_{{$pertanyaan->head_id}}_{{$pertanyaan->id}}" 
                                                        data-pertanyaan="{{$pertanyaan->pertanyaan}}"
                                                        data-tab="Pengasuhan"
                                                        placeholder="Silakan isi.." 
                                                        required
                                                        value="{{ $jawaban ? $jawaban['input_field'] : '' }}" 
                                                    >
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                    <br>
                                @endforeach 

                                <div class="mt-4 d-flex" style="justify-content: flex-end">
                                    <button type="button" class="btn btn-primary btn-sm ml-auto px-3" id="btn-submit"> Submit </button>
                                </div>
                            </div>
                        
                        
                        <br><br>
                        <span style="color: red;">*</span>
                        <small>Wajib untuk diisi</small>
                        {{-- END TAB CONTENT --}}
                        </div>
                    </form>
                @elseif($get_profile != null && $is_lunas == 0)
                    <div class="text-center mt-5 p-4" style="background-color: #f8f9fa; border-radius: 15px; border: 1px solid #dee2e6;">
                        <img src="{{ asset('assets/images/_other_assets/payment_ilustrasi.png') }}" alt="Ilustrasi Pembayaran" class="img-fluid mb-4" style="max-width: 200px;">
                        <h4 class="fw-bold" style="color: #0056b3;">Selesaikan Pembayaran Terlebih Dahulu</h4>
                        <p class="text-muted mt-3">
                            Terima kasih telah melakukan pendaftaran. Untuk melanjutkan ke tahap pemenuhan data, silakan selesaikan pembayaran biaya pendaftaran terlebih dahulu.
                        </p>
                        <p class="text-muted">
                            Setelah pembayaran berhasil, Anda dapat kembali ke halaman ini untuk melengkapi data Ananda.
                        </p>
                        <a href="{{ route('form.histori.detail', ['no_registrasi' => $no_registrasi]) }}" class="btn btn-primary btn-lg mt-3 px-5 shadow-sm">
                            <i class="fas fa-wallet me-2"></i> Lanjutkan Pembayaran
                        </a>
                    </div>
                @elseif($no_registrasi != null)
                    <div class="mt-4"> 
                        <h3 class="center"> Data Tidak Ditemukan </h3>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>

    <script>
        function addInput() {
            const container = document.getElementById('inputContainer');
            // Remove existing add button
            const existingAddButton = document.querySelector('.add-button');
            if (existingAddButton) existingAddButton.remove();

            // Create new input group
            const newInputGroup = document.createElement('div');
            newInputGroup.className = 'input-group mb-2';
            newInputGroup.style.maxWidth = '500px';
            newInputGroup.style.border = 'none';
            newInputGroup.innerHTML = `
                <input type="text" name="info_detail_tempat[]" data-pertanyaan="Detail Tempat Tinggal" data-tab="Data Anak" class="form-control form-control-sm" placeholder="Nama - Keterangan">
                <button type="button" class="btn btn-outline-danger btn-sm ms-2" style="border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;" onclick="removeInput(this)">
                    <i class="fas fa-trash"></i>
                </button>
                <button type="button" class="btn btn-outline-primary btn-sm add-button ms-2" style="border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;" onclick="addInput()">
                    <i class="fas fa-plus"></i>
                </button>
            `;
            container.appendChild(newInputGroup);
        }

        function removeInput(button) {
            const container = document.getElementById('inputContainer');
            const inputGroups = container.querySelectorAll('.input-group');
            
            // Only remove if there is more than one input
            if (inputGroups.length > 1) {
                button.parentElement.remove();
                // Add the add-button to the last input group if it doesn't have one
                const lastInputGroup = container.querySelector('.input-group:last-child');
                if (!lastInputGroup.querySelector('.add-button')) {
                    const addButton = document.createElement('button');
                    addButton.type = 'button';
                    addButton.className = 'btn btn-outline-primary btn-sm add-button ms-2';
                    addButton.onclick = addInput;
                    addButton.style.borderRadius = '50%';
                    addButton.style.width = '32px';
                    addButton.style.height = '32px';
                    addButton.style.display = 'flex';
                    addButton.style.alignItems = 'center';
                    addButton.style.justifyContent = 'center';
                    addButton.innerHTML = '<i class="fas fa-plus"></i>';
                    lastInputGroup.appendChild(addButton);
                }
            }
        }
    </script>

    <script>
        function addInputSaudara() {
            const container = document.getElementById('inputContainerSaudara');
            // Remove existing add button
            const existingAddButton = document.querySelector('.add-button-saudara');
            if (existingAddButton) existingAddButton.remove();

            // Create new input group
            const newInputGroup = document.createElement('div');
            newInputGroup.className = 'input-group mb-2';
            newInputGroup.style.maxWidth = '500px';
            newInputGroup.style.border = 'none';
            newInputGroup.innerHTML = `
                <input type="text" name="info_detail_saudara[]" data-pertanyaan="Data Saudara" data-tab="Data Anak" class="form-control form-control-sm" placeholder="Nama-Usia-Jenis Kelamin-Keterangan">
                <button type="button" class="btn btn-outline-danger btn-sm ms-2" style="border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;" onclick="removeInputSaudara(this)">
                    <i class="fas fa-trash"></i>
                </button>
                <button type="button" class="btn btn-outline-primary btn-sm add-button-saudara ms-2" style="border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;" onclick="addInputSaudara()">
                    <i class="fas fa-plus"></i>
                </button>
            `;
            container.appendChild(newInputGroup);
        }

        function removeInputSaudara(button) {
            const container = document.getElementById('inputContainerSaudara');
            const inputGroups = container.querySelectorAll('.input-group');
            
            // Only remove if there is more than one input
            if (inputGroups.length > 1) {
                button.parentElement.remove();
                // Add the add-button to the last input group if it doesn't have one
                const lastInputGroup = container.querySelector('.input-group:last-child');
                if (!lastInputGroup.querySelector('.add-button-saudara')) {
                    const addButton = document.createElement('button');
                    addButton.type = 'button';
                    addButton.className = 'btn btn-outline-primary btn-sm add-button-saudara ms-2';
                    addButton.onclick = addInputSaudara;
                    addButton.style.borderRadius = '50%';
                    addButton.style.width = '32px';
                    addButton.style.height = '32px';
                    addButton.style.display = 'flex';
                    addButton.style.alignItems = 'center';
                    addButton.style.justifyContent = 'center';
                    addButton.innerHTML = '<i class="fas fa-plus"></i>';
                    lastInputGroup.appendChild(addButton);
                }
            }
        }
    </script>
    
    <script>
        function toggleInputContainer() {
            const yaRadio = document.getElementById('info_apakah_abk_ya');
            const inputContainer = document.getElementById('inputSectionKhusus');
            const smallText = document.querySelectorAll('.text-muted-khusus');
            
            if (yaRadio.checked) {
                inputContainer.style.display = 'block';
                smallText.forEach(text => text.style.display = 'block');
            } else {
                inputContainer.style.display = 'none';
                smallText.forEach(text => text.style.display = 'none');
            }
        }

        function addInputKhusus() {
            const container = document.getElementById('inputContainerKhusus');
            // Remove existing add button
            const existingAddButton = document.querySelector('.add-button-khusus');
            if (existingAddButton) existingAddButton.remove();

            // Create new input group
            const newInputGroup = document.createElement('div');
            newInputGroup.className = 'input-group mb-2';
            newInputGroup.style.maxWidth = '900px';
            newInputGroup.style.border = 'none';
            newInputGroup.innerHTML = `
                <input type="text" name="info_detail_khusus[]" data-pertanyaan="Info Kebutuhan Khusus" data-tab="Data Anak" class="form-control form-control-sm" placeholder="Jenis Terapi - Tempat Terapi - Frekuensi Terapi - Dilaksanakan pada tahun - Hasil terapi">
                <button type="button" class="btn btn-outline-danger btn-sm ms-2" style="border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;" onclick="removeInputKhusus(this)">
                    <i class="fas fa-trash"></i>
                </button>
                <button type="button" class="btn btn-outline-primary btn-sm add-button-khusus ms-2" style="border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;" onclick="addInputKhusus()">
                    <i class="fas fa-plus"></i>
                </button>
            `;
            container.appendChild(newInputGroup);
        }

        function removeInputKhusus(button) {
            const container = document.getElementById('inputContainerKhusus');
            const inputGroups = container.querySelectorAll('.input-group');
            
            // Only remove if there is more than one input
            if (inputGroups.length > 1) {
                button.parentElement.remove();
                // Add the add-button to the last input group if it doesn't have one
                const lastInputGroup = container.querySelector('.input-group:last-child');
                if (!lastInputGroup.querySelector('.add-button-khusus')) {
                    const addButton = document.createElement('button');
                    addButton.type = 'button';
                    addButton.className = 'btn btn-outline-primary btn-sm add-button-khusus ms-2';
                    addButton.onclick = addInputKhusus;
                    addButton.style.borderRadius = '50%';
                    addButton.style.width = '32px';
                    addButton.style.height = '32px';
                    addButton.style.display = 'flex';
                    addButton.style.alignItems = 'center';
                    addButton.style.justifyContent = 'center';
                    addButton.innerHTML = '<i class="fas fa-plus"></i>';
                    lastInputGroup.appendChild(addButton);
                }
            }
        }
    </script>

    <script>
        // Simpan nilai asli radio button saat halaman dimuat
        document.querySelectorAll('[name^="pertanyaan_"], [name^="pengasuhan_"]').forEach(function(radio) {
            radio.setAttribute('data-original-value', radio.value);
        });

        // Function to update radio button value based on input
        function updateRadioValue(radio, input) {
            if (radio && radio.checked && radio.getAttribute('data-original-value') === 'self_fill') {
                radio.value = input && input.value.trim() ? input.value.trim().toLowerCase() : 'self_fill';
            } else if (radio && radio.checked) {
                // Kembalikan ke nilai asli jika bukan self_fill
                radio.value = radio.getAttribute('data-original-value');
            }
        }

        // Event listener untuk perubahan radio button (pertanyaan_ dan pengasuhan_)
        document.querySelectorAll('[name^="pertanyaan_"], [name^="pengasuhan_"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                var nameParts = radio.name.split('_');
                var headId = nameParts[1];
                var questionId = nameParts[2];
                var isPengasuhan = radio.name.startsWith('pengasuhan_');
                var inputId = isPengasuhan 
                    ? `#pengasuhan_${headId}_${questionId}_self_fill_pengasuhan`
                    : `#pertanyaan_${headId}_${questionId}_self_fill`;
                var selfFillInput = document.querySelector(inputId);
                updateRadioValue(radio, selfFillInput);
            });
        });

        // Event listener untuk perubahan input teks (self_fill dan self_fill_pengasuhan)
        document.querySelectorAll('[id$="_self_fill"], [id$="_self_fill_pengasuhan"]').forEach(function(input) {
            input.addEventListener('input', function() {
                var idParts = input.id.split('_');
                var headId = idParts[1];
                var questionId = idParts[2];
                var isPengasuhan = input.id.endsWith('_self_fill_pengasuhan');
                var radioName = isPengasuhan 
                    ? `pengasuhan_${headId}_${questionId}`
                    : `pertanyaan_${headId}_${questionId}`;
                var relatedRadio = document.querySelector(`[name="${radioName}"][data-original-value="self_fill"]`);
                updateRadioValue(relatedRadio, input);
            });
        });

        // Pastikan nilai radio diperbarui sebelum form disubmit
        document.querySelector('form').addEventListener('submit', function(e) {
            // Untuk pertanyaan_
            document.querySelectorAll('[name^="pertanyaan_"]').forEach(function(radio) {
                var nameParts = radio.name.split('_');
                var headId = nameParts[1];
                var questionId = nameParts[2];
                var selfFillInput = document.querySelector(`#pertanyaan_${headId}_${questionId}_self_fill`);
                updateRadioValue(radio, selfFillInput);
            });

            // Untuk pengasuhan_
            document.querySelectorAll('[name^="pengasuhan_"]').forEach(function(radio) {
                var nameParts = radio.name.split('_');
                var headId = nameParts[1];
                var questionId = nameParts[2];
                var selfFillInput = document.querySelector(`#pengasuhan_${headId}_${questionId}_self_fill_pengasuhan`);
                updateRadioValue(radio, selfFillInput);
            });
        });
        </script>

    <!-- Tambahkan SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
        $('#btn-submit').click(function (e) {
            e.preventDefault();

            // Ambil semua inputan penting
            var form = document.getElementById('update_data_pendaftaran');
            var data = new FormData(form);

            var provinsi = $('#provinsi').val();
            var kota = $('#kota').val();
            var kecamatan = $('#kecamatan').val();
            var kelurahan = $('#kelurahan').val();
            var status_tinggal = $('#status_tinggal').val();
            var bhs_digunakan = $('#bhs_digunakan').val();
            var gol_darah = $('#gol_darah').val();

            var pekerjaan_ibu = $('#pekerjaan_ibu').val();
            var penghasilan_ibu = $('#penghasilan_ibu').val();
            var pendidikan_ibu = $('#pendidikan_ibu').val();

            var pekerjaan_ayah = $('#pekerjaan_ayah').val();
            var penghasilan_ayah = $('#penghasilan_ayah').val();
            var pendidikan_ayah = $('#pendidikan_ayah').val();

            // var pekerjaan_wali = $('#pekerjaan_wali').val();
            // var pendidikan_wali = $('#pendidikan_wali').val();
            // var hubungan_wali = $('#hubungan_wali').val();

            var berat_badan = parseFloat($('#berat_badan').val()) || 0;
            var tinggi_badan = parseFloat($('#tinggi_badan').val()) || 0;
            var hafalan = parseFloat($('#hafalan').val()) || 0;

            // Validasi input satu-satu
            // if (!provinsi) return alert('Mohon cek kembali inputan provinsi, Pastikan Semua Data Sudah Terisi');
            // if (!kota) return alert('Mohon cek kembali inputan kota, Pastikan Semua Data Sudah Terisi');
            // if (!kecamatan) return alert('Mohon cek kembali inputan kecamatan, Pastikan Semua Data Sudah Terisi');
            // if (!kelurahan) return alert('Mohon cek kembali inputan kelurahan, Pastikan Semua Data Sudah Terisi');
            // if (!status_tinggal) return alert('Mohon cek kembali inputan status tinggal, Pastikan Semua Data Sudah Terisi');
            // if (!bhs_digunakan) return alert('Mohon cek kembali inputan bahasa yang digunakan, Pastikan Semua Data Sudah Terisi');
            // if (!gol_darah) return alert('Mohon cek kembali inputan golongan darah, Pastikan Semua Data Sudah Terisi');
            // if (!pekerjaan_ibu) return alert('Mohon cek kembali inputan pekerjaan ibu, Pastikan Semua Data Sudah Terisi');
            // if (!penghasilan_ibu) return alert('Mohon cek kembali inputan penghasilan ibu, Pastikan Semua Data Sudah Terisi');
            // if (!pendidikan_ibu) return alert('Mohon cek kembali inputan pendidikan ibu, Pastikan Semua Data Sudah Terisi');
            // if (!pekerjaan_ayah) return alert('Mohon cek kembali inputan pekerjaan ayah, Pastikan Semua Data Sudah Terisi');
            // if (!penghasilan_ayah) return alert('Mohon cek kembali inputan penghasilan ayah, Pastikan Semua Data Sudah Terisi');
            // if (!pendidikan_ayah) return alert('Mohon cek kembali inputan pendidikan ayah, Pastikan Semua Data Sudah Terisi');
            // if (!pekerjaan_wali) return alert('Mohon cek kembali inputan pekerjaan wali, Pastikan Semua Data Sudah Terisi');
            // if (!pendidikan_wali) return alert('Mohon cek kembali inputan pendidikan wali, Pastikan Semua Data Sudah Terisi');
            // if (!hubungan_wali) return alert('Mohon cek kembali inputan hubungan wali, Pastikan Semua Data Sudah Terisi');

            // Validasi berat badan, tinggi badan, hafalan
            if (tinggi_badan < 0 || tinggi_badan > 300) {
                return alert('Silakan isi tinggi badan anak dengan angka yang sebenarnya');
            }

            if (berat_badan < 0 || berat_badan > 150) {
                return alert('Silakan isi berat badan anak dengan angka yang sebenarnya');
            }
            if (hafalan < 0) return alert('Jumlah hafalan tidak boleh kurang dari 0');

            // Validasi kuesioner anak
            let unanswered = new Set();
            let unansweredTab = new Set();
            let firstUnansweredElement = null;
            let firstUnansweredElementTab = null;
            let targetTab = null;

            // Cek untuk semua elemen input radio dan teks
            $('input[type="radio"], input[type="text"]').each(function () {
                var name = $(this).attr('name');
                var value = $(this).val();
                var dataPertanyaan = $(this).data('pertanyaan');
                var dataTab = $(this).data('tab');
                var targetTabId = $(this).closest('.tab-pane').attr('id'); // Menemukan tab yang mengandung elemen ini

                // Lewati pengecekan jika nama adalah "info_detail_khusus[]"
                if (name === "info_detail_khusus[]" || name === "asal_sekolah" || name === "npsn" || name === "riwayat_penyakit" || name === "no_hp" || name === "nama_lengkap" || name.endsWith("_self_fill") || name.endsWith("_self_fill_pengasuhan") || name.endsWith("_wali")) {
                    return; // Skip elemen ini
                }

                // Cek jika tipe input adalah radio
                if ($(this).attr('type') === 'radio') {
                    var isChecked = $(`input[name="${name}"]:checked`).val();
                    if (!isChecked) {
                        unanswered.add(dataPertanyaan || name); // Jika tidak ada yang dipilih, tambahkan ke unanswered
                        unansweredTab.add(dataTab); // Jika tidak ada yang dipilih, tambahkan ke unanswered
                        if (!firstUnansweredElement) {
                            firstUnansweredElement = $(this); // Ambil elemen pertama yang tidak terisi
                            targetTab = targetTabId; // Ambil ID tab untuk elemen ini
                        }
                    }
                }
                // Cek untuk input teks
                else if ($(this).attr('type') === 'text' && !value) {
                    unanswered.add(dataPertanyaan || name); // Tambahkan ke unanswered jika input teks kosong
                    unansweredTab.add(dataTab);
                    if (!firstUnansweredElement) {
                        firstUnansweredElement = $(this); // Ambil elemen pertama yang tidak terisi
                        targetTab = targetTabId; // Ambil ID tab untuk elemen ini
                    }
                }
            });

            // Jika ada pertanyaan yang belum dijawab, tampilkan menggunakan SweetAlert
            if (unanswered.size > 0) {
                var unansweredList = Array.from(unanswered).join('<br>'); // Menggabungkan pertanyaan dengan baris baru
                var unansweredTabList = Array.from(unansweredTab).join('<br>'); // Menggabungkan pertanyaan dengan baris baru
                

                var firstUnansweredQuestion = unansweredList.split('<br>')[0];
                var firstUnansweredQuestionTab = unansweredTabList.split('<br>')[0];

                // Gunakan SweetAlert untuk menampilkan daftar pertanyaan
                Swal.fire({
                    title: 'Mohon lengkapi pertanyaan pada bagian tab "'+firstUnansweredQuestionTab+'" ',
                    html: `<div style="text-align: left; direction: ltr;">Terdapat pertanyaan berikut: <br> ${  } <br><br> <em style:"font-size:10px;">Pastikan Semua Data Sudah Terisi</em></div>`, // Inline style untuk teks rata kiri
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Setelah SweetAlert ditutup, aktifkan tab yang sesuai dan scroll ke elemen pertama yang belum terisi
                    // if (targetTab) {
                    //     // Aktifkan tab yang sesuai
                    //     $('#nav-tab a[href="#' + targetTab + '"]').tab('show');

                    //     // Setelah tab aktif, scroll ke elemen yang belum terisi
                    //     $('html, body').animate({
                    //         scrollTop: firstUnansweredElement.offset().top - 100
                    //     }, 1000);

                    //     // Highlight elemen dengan border merah
                    //     firstUnansweredElement.css('border', '2px solid red');
                    // }
                    if (firstUnansweredElement && targetTab) {
                        // Dapatkan ID elemen
                        var elementId = firstUnansweredElement.attr('id');

                        // Fokus ke elemen (akan mengaktifkan tab yang sesuai secara otomatis)
                        $(`#${elementId}`).focus();

                        // Gulir ke elemen dengan animasi
                        // $('html, body').animate({
                        //     scrollTop: $(`#${elementId}`).offset().top - 100
                        // }, 500); // Animasi pengguliran selama 500ms

                        // Highlight elemen dengan border merah
                        $(`#${elementId}`).css('border', '2px solid red');

                        // Hapus highlight setelah 3 detik (opsional)
                        setTimeout(() => {
                            $(`#${elementId}`).css('border', '');
                        }, 3000);
                    } else {
                        console.error('Target tab atau elemen tidak ditemukan:', targetTab, firstUnansweredElement);
                    }
                });

                return;
            }

            // Validasi isi semua FormData (opsional)
            for (var [key, value] of data) {
                // Cek jika key mengandung "_self_fill" atau "pengasuhan_extra_" dengan kondisi tambahan pada data-is-extra-required
                if (key.endsWith("_self_fill") || key.endsWith("_self_fill_pengasuhan") || key.includes("pengasuhan_extra_")) {
                    var pertanyaanElement = document.querySelector(`[name="${key}"]`);
                    
                    // Jika elemen ditemukan dan key mengandung "pengasuhan_extra_", cek data-is-extra-required
                    if (pertanyaanElement && key.includes("pengasuhan_extra_")) {
                        var isExtraRequired = pertanyaanElement.getAttribute('data-is-extra-required');
                        if (isExtraRequired === "false" || isExtraRequired === "0") {
                            continue; // Skip elemen dengan key yang mengandung "pengasuhan_extra_" dan data-is-extra-required adalah false atau 0
                        }
                    }
                    continue; // Skip elemen dengan key yang berakhiran "_self_fill" atau "_self_fill_pengasuhan" atau "pengasuhan_extra_"
                }

                if ((value === "" || value === null) && key !== "info_detail_khusus[]" && key !== "asal_sekolah"  && key !== "npsn"  && key !== "riwayat_penyakit") {
                    // Cek apakah input adalah radio dan apakah ada yang dipilih
                    var radioElement = document.querySelector(`[name="${key}"]`);
                    
                    // Jika radio button, cek apakah ada yang dipilih
                    if (radioElement && radioElement.type === "radio") {
                        var isChecked = document.querySelector(`input[name="${key}"]:checked`);
                        if (!isChecked) {
                            var pertanyaanElement = document.querySelector(`[name="${key}"]`);
                            var pertanyaan = pertanyaanElement ? pertanyaanElement.getAttribute('data-pertanyaan') : key;
                            var tab = pertanyaanElement ? pertanyaanElement.getAttribute('data-tab') : key;
                            // Gunakan SweetAlert untuk menampilkan daftar pertanyaan
                            Swal.fire({
                                title: 'Mohon cek kembali bagian Tab "'+tab+'"',
                                html: `<div style="text-align: left; direction: ltr;">Cek pada isian ${(pertanyaan || key)}<br>Pastikan Semua Data Sudah Terisi</div>`, // Inline style untuk teks rata kiri
                                icon: 'warning',
                                confirmButtonText: 'OK'
                            });
                            return;
                        }
                    }
                    // Cek input teks
                    else if (radioElement && value === "") {
                        var pertanyaanElement = document.querySelector(`[name="${key}"]`);
                        var pertanyaan = pertanyaanElement ? pertanyaanElement.getAttribute('data-pertanyaan') : key;
                         var tab = pertanyaanElement ? pertanyaanElement.getAttribute('data-tab') : key;
                        Swal.fire({
                            title: 'Mohon cek kembali bagian Tab "'+tab+'"',
                            html: `<div style="text-align: left; direction: ltr;">Cek pada isian ${(pertanyaan || key)}<br>Pastikan Semua Data Sudah Terisi</div>`, // Inline style untuk teks rata kiri
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }
                }
            }

            // Semua valid, submit form
            $(this).prop("disabled", true);
            $(this).html(
                `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`
            );
            $("#update_data_pendaftaran").submit();
        });
    });

        $(document).ready(function() {
            $('#kec_asal_sekolah').select2();
        });
      
         $("#next-ibu").click(function() {
            $('#nav-tab button:eq(1) ').tab('show');
        });

        $("#next-ayah").click(function() {
            $('#nav-tab button:eq(2) ').tab('show');
        });

        $('#next-wali').click(function(){
            $('#nav-tab button:eq(3) ').tab('show');
        });

        $('#next-per-anak-1').click(function(){
            $('#nav-tab button:eq(4) ').tab('show');
        });

        $('#next-per-anak-2').click(function(){
            $('#nav-tab button:eq(5) ').tab('show');
        });

        $('#next-pengasuhan').click(function(){
            $('#nav-tab button:eq(6) ').tab('show');
        });
        
        function getKota() {
            var id_provinsi = document.getElementById("provinsi").value
            $.ajax({
                url: "{{route('get_kota')}}",
                type: 'POST',
                data: {
                    id_provinsi: id_provinsi,
                     _token: '{{csrf_token()}}'
                },
                success: function (result) {
                    
                    $('#kota').html('<option value="">-- Pilih kota --</option>');
                    $.each(result.kota, function (key, item) {
                    //    console.log('ini', item.id , get_profile.kota);
                        $("#kota").append('<option value="' + item
                            .id + '" >' + item.kabupaten_kota + '</option>');
                    });
                }
            });
        }
        
        function getKecamatan() {
            var id_kota = document.getElementById("kota").value
            $.ajax({
                url: "{{route('get_kecamatan')}}",
                type: 'POST',
                data: {
                    id_kota: id_kota,
                     _token: '{{csrf_token()}}'
                },
                success: function (result) {
                    $('#kecamatan').html('<option value="">-- Pilih kecamatan --</option>');
                    $.each(result.kecamatan, function (key, item) {
                        $("#kecamatan").append('<option value="' + item
                            .id + '">' + item.kecamatan + '</option>');
                    });
                }
            });
        }

        function getKelurahan() {
            var id_kecamatan = document.getElementById("kecamatan").value
            $.ajax({
                url: "{{route('get_kelurahan')}}",
                type: 'POST',
                data: {
                    id_kecamatan: id_kecamatan,
                     _token: '{{csrf_token()}}'
                },
                success: function (result) {
                    $('#kelurahan').html('<option value="">-- Pilih kelurahan --</option>');
                    $.each(result.kelurahan, function (key, item) {
                        $("#kelurahan").append('<option value="' + item
                            .id + '">' + item.kelurahan + '</option>');
                    });
                }
            });
        }
    </script>

    <div class="modal fade" id="lupa_no_regis" tabindex="-1" role="dialog" aria-labelledby="lupa_regis" aria-hidden="true">
        <div class="modal-dialog">
            <form role="form" method="POST" action="{{route('forget_no_regis')}}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="lupa_regis">Lupa No Pendaftaran / Registrasi</h5>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Masukkan No HP Anda</label>
                            <input type="text" name="no_hp" class="form-control form-control-sm px-3" placeholder="08xx"  >
                        </div>
                        <div class="form-group mt-2">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control form-control-sm px-3" placeholder="Masukkan Nama Anak Anda"  >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm my-4 text-white">Kirim</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form> 
        </div>
    </div>
    
@endsection
