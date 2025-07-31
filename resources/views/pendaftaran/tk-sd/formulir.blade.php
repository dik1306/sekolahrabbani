@extends('layouts.app')

@section('content')
    <div class="">
        <img class="banner-2" src="{{ asset('assets/images/home_rabbani_school-2.png') }}" alt="banner">
        <div class="centered text-white">
            <h1> Formulir Pendaftaran </h1>
        </div>
    </div>
    <div>
        <img src="{{ asset('assets/images/awan1.png') }}" class="cloud-3"  alt="cloud">
        <img src="{{ asset('assets/images/awan2.png') }}" class="cloud-4"  alt="cloud">
    </div>
    <div class="container" style="position: relative; z-index:1000">
        <div class="row mx-auto">
            <div class="col-md">
                <h6 class="mt-1" style="color: #ED145B">Pendaftaran</h6>
                <h4 class="mb-3">Data Calon Siswa</h4>
                <a href="{{route('form.update')}}" style="text-decoration: none">
                    <button class="btn btn-blue btn-sm px-3 d-block" style="margin-left: auto" > Pemenuhan Data </button>
                </a>
                <form action="{{route('store.pendaftaran')}}"  method="POST" id="form_pendaftaran">
                    @csrf
                    
                    <div class="form-group mt-3">
                        <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                        <select name="tahun_ajaran" id="tahun_ajaran" class="form-control" required>
                            <option value="" disabled>-- Pilih Tahun Ajaran --</option>
                            @foreach ($tahun_ajaran as $item)
                                <option value="{{ $item->id }}"
                                    @if ($ppdb_now_id == $item->id) 
                                        selected 
                                    @endif
                                >
                                    {{ $item->tahun_ajaran }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Input hidden untuk 'is_pindahan' jika tahun ajaran yang dipilih bukan yang terbaru -->
                        <input type="hidden" name="is_pindahan" id="is_pindahan" value="0"> <!-- Default 0 -->
                    </div>
                    <script>
                        document.getElementById('tahun_ajaran').addEventListener('change', function() {
                            var selectedValue = this.value;
                            var ppdbNowId = "{{ $ppdb_now_id }}"; // ID Tahun Ajaran Terbaru

                            // Jika tahun ajaran yang dipilih tidak sama dengan yang terbaru, set is_pindahan = 1
                            if (selectedValue !== ppdbNowId) {
                                document.getElementById('is_pindahan').value = '1';  // Set is_pindahan = 1 jika tidak sama
                            } else {
                                document.getElementById('is_pindahan').value = '0';  // Set is_pindahan = 0 jika sama
                            }
                        });
                    </script>

                    <div class="form-group mt-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input class="form-control" id="nama" name="nama" placeholder="Nama Lengkap" required>
                    </div>

                    <div class="row mt-3">
                        <div class="form-group col-md-6">
                            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                            <input class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Tempat Lahir" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" placeholder="Tanggal Lahir" required>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                            <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                            <option value="L" >Laki Laki</option>
                            <option value="P" >Perempuan</option>
                        </select>
                    </div>

                    <div class="form-group mt-3">
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <select name="lokasi" id="lokasi" class="form-control" onchange="getJenjang()" required>
                            <option value="" disabled selected>-- Pilih Lokasi --</option>
                            @foreach ($lokasi as $item)
                                <option value="{{ $item->kode_sekolah }}"> {{ $item->nama_sekolah }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mt-3" id="form_jenjang">
                        <label for="jenjang" class="form-label">Jenjang</label>
                        <select name="jenjang" id="jenjang" class="form-control" onchange="getKelas()" required>
                            <option value="" disabled selected>-- Pilih Jenjang --</option>
                        </select>
                    </div>

                    <div class="form-group mt-3" id="form_kelas">
                        <label for="kelas" class="form-label">Kelas</label>
                        <select name="kelas" id="kelas" class="form-control" required>
                            <option value="" disabled selected>-- Pilih Kelas --</option>
                        </select>
                    </div>

                    <div class="form-group mt-3" id="form_boarding" style="display: none">
                        <label for="jenis_pendidikan" class="form-label">Jenis Pendidikan</label>
                        <select name="jenis_pendidikan" id="jenis_pendidikan" class="form-control" required>
                            <option value="" disabled selected>-- Pilih Jenis Pendidikan --</option>
                            <option value="1">Reguler</option>
                            {{-- <option value="2">Boarding</option> --}}
                        </select>
                    </div>

                    <div class="form-group mt-3">
                        <label for="nama_ayah" class="form-label">Nama Ayah Kandung</label>
                        <input class="form-control" id="nama_ayah" name="nama_ayah" placeholder="Nama Ayah" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="nama_ibu" class="form-label">Nama Ibu Kandung</label>
                        <input class="form-control" id="nama_ibu" name="nama_ibu" placeholder="Nama Ibu" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="no_hp_ayah" class="form-label">No Whatsapp Ayah</label>
                        <input class="form-control" id="no_hp_ayah" type="tel" name="no_hp_ayah" placeholder="08123xxx" minlength="10" maxlength="13" onkeypress="return /[0-9]/i.test(event.key)" required>
                        @if ($errors->has('no_hp_ayah'))
                            <span style="font-size: 10px" class="text-danger">{{ $errors->first('no_hp_ayah') }}</span>
                        @endif
                    </div>

                    <div class="form-group mt-3">
                        <label for="no_hp_ibu" class="form-label">No Whatsapp Ibu</label>
                        <input class="form-control" id="no_hp_ibu" name="no_hp_ibu" placeholder="08213xxx" type="tel" minlength="10" maxlength="13" onkeypress="return /[0-9]/i.test(event.key)" required>
                        @if ($errors->has('no_hp_ibu'))
                            <span style="font-size: 10px" class="text-danger">{{ $errors->first('no_hp_ibu') }}</span>
                        @endif
                    </div>

                    <div class="mt-3">
                        <span for="asal_sekolah" class="form-label">Asal Sekolah</span>
                        <input class="form-control form-control-sm px-3" id="asal_sekolah" name="asal_sekolah"  placeholder="Sekolah Sebelumnya" required >
                    </div>

                    <div class="mt-3">
                        <span for="info_ppdb" class="form-label">Informasi PPDB</span>
                        <div class="form-check">
                            <input type="radio" name="radios" class="form-check-input" value="spanduk/baliho" id="spanduk_baliho" onclick="close_info()" required>
                            <label class="form-check-label" for="spanduk_baliho">Spanduk / Baliho</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="radios" class="form-check-input" value="flyer" id="flyer" onclick="close_info()">
                            <label class="form-check-label" for="flyer">Flyer</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="radios" class="form-check-input" value="instagram" id="instagram" onclick="close_info()">
                            <label class="form-check-label" for="instagram">Instagram</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="radios" class="form-check-input" value="lainnya" onclick="open_info()" id="lainnya">
                            <label class="form-check-label" for="lainnya">Rekomendasi Orang Lain</label>
                        </div>
                        <div class="mb-3 form-check show_rekom" id="show_rekom">
                            <input type="text" style="display: none" name="radios2" id="input_rekomen" placeholder="Sebutkan" class="form-control form-control-sm"><br>
                        </div>

                        @if ($errors->has('info_ppdb'))
                            <span style="font-size: 10px" class="text-danger">{{ $errors->first('info_ppdb') }}</span>
                        @endif
                    </div>

                    <div class="mt-3 center">
                        <button type="submit" class="btn btn-primary px-3" id="btn-submit"> Submit </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
          
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#btn-submit").click(function() {

                var nama = $('#nama').val();
                var tempat_lahir = $('#tempat_lahir').val();
                var tgl_lahir = $('#tgl_lahir').val();
                var jenis_kelamin = $('#jenis_kelamin').val();
                var nama_ayah = $('#nama_ayah').val();
                var nama_ibu = $('#nama_ibu').val();
                var no_hp_ibu = $('#no_hp_ibu').val();
                var no_hp_ayah = $('#no_hp_ayah').val();
                var asal_sekolah = $('#asal_sekolah').val();
                var info_ppdb = $('input[name="radios"]').val();
                if (nama == '' || tempat_lahir == '' || tgl_lahir == '' || jenis_kelamin == '' || nama_ayah == '' || nama_ibu == '' || asal_sekolah == '' || info_ppdb == '' ) {

                } else {
                    // disable button
                    $(this).prop("disabled", true);
                    // add spinner to button
                    $(this).html(
                        `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`
                    );
                    $("#form_pendaftaran").submit();
                }

            });
        });

        function open_info() {
            $('#input_rekomen').show()
        }

        function close_info() {
            $('#input_rekomen').hide()
        }

        function getJenjang() {
            var id_lokasi = document.getElementById("lokasi").value

            if (id_lokasi == 'UBR') {
                $('#form_boarding').show();
                $('#form_jenjang').hide();
                // $('#form_kelas').hide();
                $.ajax({
                    url: "{{route('get_kelas_smp')}}",
                    type: 'POST',
                    data: {
                        id_lokasi: id_lokasi,
                         _token: '{{csrf_token()}}'
                    },
                    success: function (result) {
                        // console.log(result);
                        $('#kelas').html('<option value="" disabled selected>-- Pilih Kelas --</option>');
                        $.each(result.kelas_smp, function (key, item) {
                            // console.log(item);
                            $("#kelas").append('<option value="' + item
                                .kelas.value + '">' + item.kelas.nama_kelas + '</option>');
                        });
                    }
                });
            } else {
                $('#form_boarding').hide();
                $('#form_jenjang').show();
                // $('#form_kelas').show();
                $.ajax({
                    url: "{{route('get_jenjang')}}",
                    type: 'POST',
                    data: {
                        id_lokasi: id_lokasi,
                         _token: '{{csrf_token()}}'
                    },
                    success: function (result) {
                        // console.log(result);
                        $('#jenjang').html('<option value="" disabled selected>-- Pilih Jenjang --</option>');
                        $.each(result.jenjang, function (key, item) {
                            // console.log(item.jenjang.value);
                            $("#jenjang").append('<option value="' + item
                                .jenjang.value + '">' + item.jenjang.nama_jenjang + '</option>');
                        });
                    }
                });
               
            }
        }
        
        function getKelas() {
            var id_jenjang = document.getElementById("jenjang").value
            var id_lokasi = document.getElementById("lokasi").value

            // alert(id_jenjang)
            $.ajax({
                url: "{{route('get_kelas')}}",
                type: 'POST',
                data: {
                    id_lokasi: id_lokasi,
                    id_jenjang: id_jenjang,
                     _token: '{{csrf_token()}}'
                },
                success: function (result) {
                    $('#kelas').html('<option value="" disabled selected>-- Pilih Kelas --</option>');
                    $.each(result.kelas, function (key, item) {
                        $("#kelas").append('<option value="' + item
                            .kelas.value + '">' + item.kelas.nama_kelas + '</option>');
                    });
                }
            });
        }
    </script>
@endsection