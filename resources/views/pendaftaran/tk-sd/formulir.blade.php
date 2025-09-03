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
                <div class="d-flex justify-content-end">
                    <a href="{{route('form.histori.detail')}}" style="text-decoration: none">
                        <button class="btn btn-primary btn-sm px-3 me-2" > Histori Pendaftaran </button>
                    </a>
                    <a href="{{route('form.update')}}" style="text-decoration: none">
                        <button class="btn btn-blue btn-sm px-3 ml-2"> Pemenuhan Data </button>
                    </a>
                </div>
                <form action="{{route('store.pendaftaran')}}"  method="POST" id="form_pendaftaran" onsubmit="return validateForm()">
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
                            <input type="radio" name="radios" class="form-check-input" value="Keluarga/saudara" id="Keluarga_saudara" onclick="close_info()" required>
                            <label class="form-check-label" for="Keluarga_saudara">Keluarga/Saudara</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="radios" class="form-check-input" value="orangtua siswa rabbani" id="orangtua_siswa_rabbani" onclick="close_info()">
                            <label class="form-check-label" for="orangtua_siswa_rabbani">Orangtua Siswa Rabbani</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="radios" class="form-check-input" value="tetangga" id="tetangga" onclick="close_info()">
                            <label class="form-check-label" for="tetangga">Tetangga</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="radios" class="form-check-input" value="teman" id="teman" onclick="close_info()">
                            <label class="form-check-label" for="teman">Teman</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="radios" class="form-check-input" value="baligho/spanduk" id="baligho/spanduk" onclick="close_info()">
                            <label class="form-check-label" for="baligho/spanduk">Baligho/Spanduk</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="radios" class="form-check-input" value="instagram" id="instagram" onclick="close_info()">
                            <label class="form-check-label" for="instagram">Instagram</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="radios" class="form-check-input" value="facebook" id="facebook" onclick="close_info()">
                            <label class="form-check-label" for="facebook">Facebook</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="radios" class="form-check-input" value="youtube" id="youtube" onclick="close_info()">
                            <label class="form-check-label" for="youtube">Youtube</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="radios" class="form-check-input" value="tiktok" id="tiktok" onclick="close_info()">
                            <label class="form-check-label" for="tiktok">TikTok</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="radios" class="form-check-input" value="lainnya" onclick="open_info()" id="lainnya">
                            <label class="form-check-label" for="lainnya">Lainnya</label>
                        </div>
                        <div class="mb-3 form-check show_rekom" id="show_rekom">
                            <input type="text" style="display: none" name="radios2" id="input_rekomen" placeholder="Sebutkan" class="form-control form-control-sm"><br>
                        </div>

                        @if ($errors->has('info_ppdb'))
                            <span style="font-size: 10px" class="text-danger">{{ $errors->first('info_ppdb') }}</span>
                        @endif
                    </div>

                    <div class="mt-3">
                        <span for="ada_abk" class="form-label">Apakah Ananda mempunyai kebutuhan khusus (ABK)?</span>
                        <div class="form-check">
                            <input type="radio" name="abk_radios" class="form-check-input" value="ya" id="ya_option_abk" onclick="close_info()">
                            <label class="form-check-label" for="ya_option_abk">Ya</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="abk_radios" class="form-check-input" value="tidak" id="tidak_option_abk" onclick="close_info()">
                            <label class="form-check-label" for="tidak_option_abk">Tidak</label>
                        </div>
                    </div>


                    <div class="mt-3 center">
                        <button type="submit" class="btn btn-primary px-3" id="btn-submit"> Submit </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
          
    <!-- Impor SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    @if(session('status_daftar') == 3)
        <script>
            $(document).ready(function() {
                // Menampilkan modal jika session status_daftar adalah 3
                $('#modalKuotaPenuh').modal('show');

                // Menambahkan event listener untuk menghapus session setelah modal ditutup
                $('#modalKuotaPenuh').on('hidden.bs.modal', function () {
                    $.ajax({
                        url: '{{ route('clear.session.form') }}', // Route untuk menghapus session
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}', // Pastikan CSRF token ada
                        },
                        success: function(response) {
                            console.log('Session telah dihapus');
                        },
                        error: function(error) {
                            console.error('Gagal menghapus session');
                        }
                    });
                });
            });
        </script>
    @endif
    
    <!-- Modal untuk menampilkan informasi kuota penuh dengan desain lebih menarik -->
    <div id="modalKuotaPenuh" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
                <div class="modal-header" style="background: linear-gradient(90deg, #ffecd2, #fcb69f); border-top-left-radius: 15px; border-top-right-radius: 15px; padding: 20px;">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" style="padding: 30px;">
                    <div class="mb-4">
                        <svg class="bi bi-exclamation-triangle text-warning" width="50" height="50" fill="currentColor" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.938 2.016a.13.13 0 0 1 .125.09l7.146 12.24a.133.133 0 0 1-.116.184H.862a.133.133 0 0 1-.116-.184L7.892 2.106a.13.13 0 0 1 .046-.09zm-.146 1.97L1.862 13.5h12.276L7.792 3.986z"/>
                            <path d="M7.5 11.5a.5.5 0 0 1 .5-.5h.5a.5.5 0 0 1 .5.5v.5a.5.5 0 0 1-.5.5h-.5a.5.5 0 0 1-.5-.5v-.5zm0-6a.5.5 0 0 1 .5-.5h.5a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-.5.5h-.5a.5.5 0 0 1-.5-.5v-3z"/>
                        </svg>
                    </div>
                    <h5 class="modal-title fw-bold mb-3" style="color: #333;">Kuota Penuh</h5>
                    <p class="text-muted mb-4">
                        Mohon maaf, pendaftaran di {{ session('lokasi') }} belum dapat diproses karena kuota Sit In Class saat ini telah penuh.
                    </p>
                    <p class="text-muted">
                        Silakan cek halaman ini secara berkala atau hubungi Customer Service di <strong>{{ session('no_ccrs')}}</strong> untuk info pendaftaran berikutnya. Terima kasih, Ayah Bunda!
                    </p>
                    <hr style="border-color: #ddd;">
                    <footer>
                        <small class="text-muted">
                            <strong>Sit In Class:</strong> Proses observasi untuk menilai kesiapan calon siswa dalam mengikuti kegiatan sekolah.
                        </small>
                    </footer>
                </div>
                <div class="modal-footer justify-content-center" style="background: #f8f9fa; border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" style="border-radius: 10px; padding: 10px 20px;">Mengerti</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateForm() {
            // Memeriksa apakah ada radio button yang dipilih untuk 'abk_radios'
            const abkRadios = document.getElementsByName('abk_radios');
            let isAbkChecked = false;
            
            for (let i = 0; i < abkRadios.length; i++) {
                if (abkRadios[i].checked) {
                    isAbkChecked = true;
                    break;
                }
            }

            // Memeriksa apakah ada radio button yang dipilih untuk 'radios'
            const infoRadios = document.getElementsByName('radios');
            let isInfoChecked = false;

            for (let i = 0; i < infoRadios.length; i++) {
                if (infoRadios[i].checked) {
                    isInfoChecked = true;
                    break;
                }
            }

            // Menampilkan SweetAlert jika 'radios' tidak dipilih
            if (!isInfoChecked) {
                Swal.fire({
                    title: 'Peringatan!',
                    text: 'Harap pilih salah satu opsi informasi PPDB.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                return false; // Mencegah form untuk disubmit
            }

            // Menampilkan alert jika 'abk_radios' tidak dipilih
            if (!isAbkChecked) {
                alert("Harap pilih salah satu opsi pada Kebutuhan Khusus (ABK).");
                return false; // Mencegah form untuk disubmit
            }

            return true; // Jika kedua grup dipilih, form akan disubmit
        }
    </script>


    <script>
        $(document).ready(function() {
            $("#btn-submit").click(function(event) {
            event.preventDefault(); // Mencegah form untuk langsung disubmit
            var id_lokasi = document.getElementById("lokasi").value;
            var jenjang = $('#jenjang').val(); // Mengambil nilai jenjang
            var asal_sekolah = $('#asal_sekolah').val().trim();

            // Mengambil nilai dari input form
            var nama = $('#nama').val().trim();
            var tempat_lahir = $('#tempat_lahir').val().trim();
            var tgl_lahir = $('#tgl_lahir').val().trim();
            var jenis_kelamin = $('#jenis_kelamin').val();
            var lokasi = $('#lokasi').val();
            var kelas = $('#kelas').val();
            // var jenis_pendidikan = $('#jenis_pendidikan').val();
            var nama_ayah = $('#nama_ayah').val().trim();
            var nama_ibu = $('#nama_ibu').val().trim();
            var no_hp_ibu = $('#no_hp_ibu').val().trim();
            var no_hp_ayah = $('#no_hp_ayah').val().trim();
            var info_ppdb = $('input[name="radios"]:checked').val(); // Memeriksa nilai yang dipilih
            var abk_radios = $('input[name="abk_radios"]:checked').val();  // Memeriksa apakah ada pilihan pada abk_radios

            // Variabel untuk menampung pesan error
            var errorMessage = '';

            // Memeriksa setiap field dan menambahkan pesan error jika ada yang kosong
            if (!nama) errorMessage += 'Nama Lengkap, ';
            if (!tempat_lahir) errorMessage += 'Tempat Lahir, ';
            if (!tgl_lahir) errorMessage += 'Tanggal Lahir, ';
            if (!jenis_kelamin) errorMessage += 'Jenis Kelamin, ';
            if (!lokasi) errorMessage += 'Lokasi, ';
            
            // Validasi Jenjang hanya wajib diisi jika lokasi bukan UBR
            if (id_lokasi != 'UBR' && !jenjang) {
                errorMessage += 'Jenjang, ';
            }
            if (!kelas) errorMessage += 'Kelas, ';
            if (!nama_ayah) errorMessage += 'Nama Ayah, ';
            if (!nama_ibu) errorMessage += 'Nama Ibu, ';
            if (!no_hp_ibu) errorMessage += 'No Whatsapp Ibu, ';
            if (!no_hp_ayah) errorMessage += 'No Whatsapp Ayah, ';
            
            // Validasi Asal Sekolah
            if (id_lokasi == 'UBR' && !asal_sekolah) {
                // Asal Sekolah wajib diisi jika lokasi adalah UBR
                errorMessage += 'Asal Sekolah, ';
            } else if (id_lokasi != 'UBR' && jenjang > 3 && !asal_sekolah) {
                // Asal Sekolah wajib diisi jika lokasi selain UBR dan jenjang lebih dari 4
                errorMessage += 'Asal Sekolah, ';
            }
            
            if (!info_ppdb) errorMessage += 'Informasi PPDB, ';
            if (!abk_radios) errorMessage += 'Kebutuhan Khusus (ABK), ';

            // Menghapus koma terakhir jika ada
            if (errorMessage.length > 0) {
                errorMessage = errorMessage.slice(0, -2);  // Menghapus koma dan spasi terakhir
            }

            // Jika ada error (field yang kosong), munculkan SweetAlert dengan pesan yang sesuai
            if (errorMessage) {
                Swal.fire({
                    title: 'Peringatan!',
                    text: 'Harap lengkapi data berikut: ' + errorMessage,
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Reset tombol submit jika ada kesalahan dan menampilkan kembali button normal
                    $("#btn-submit").prop("disabled", false);
                    $("#btn-submit").html('Submit');
                });
            } else {
                // Jika semua data lengkap, disable tombol dan tampilkan spinner
                $(this).prop("disabled", true);
                $(this).html(
                    `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`
                );
                // Submit form setelah semua validasi terpenuhi
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
                $('#form_boarding').hide();
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