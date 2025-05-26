@extends('layouts.app')

@section('content')
    <div class="">
        <img class="banner-2" src="{{ asset('assets/images/home_rabbani_school-2.png') }}" alt="banner">
        <div class="centered text-white mt-3">
            <h1> Formulir Pendaftaran </h1>
        </div>
    </div>
   
    <div class="container" style="position: relative; z-index:1000">
        <div class="row mx-auto">
            <div class="col-md">
                <h6 class="mt-1" style="color: #ED145B">Pendaftaran Trial Class</h6>
                <h4 class="mb-3">Data Calon Siswa</h4>
                <form action="{{route('store.trial.class')}}"  method="POST" id="form_daftar_trial_class">
                    @csrf

                    <div class="form-group mt-3">
                        <label for="nama_anak" class="form-label">Nama Anak </label>
                        <input class="form-control" id="nama_anak" name="nama_anak" placeholder="Nama Anak" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="tgl_lahir" class="form-label">Tanggal Lahir </label>
                        <input type="date" class="form-control" id="tgl_lahir" maxlength="2" name="tgl_lahir" placeholder="Tanggal Lahir Anak" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="no_wa" class="form-label">No Whatsapp Ayah/Bunda</label>
                        <input class="form-control" id="no_wa" type="tel" name="no_wa" placeholder="08123xxx" minlength="10" maxlength="13" onkeypress="return /[0-9]/i.test(event.key)" required>
                        @if ($errors->has('no_wa'))
                            <span style="font-size: 10px" class="text-danger">{{ $errors->first('no_wa') }}</span>
                        @endif
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
                        <select name="jenjang" id="jenjang" class="form-control" required>
                            <option value="" disabled selected>-- Pilih Jenjang --</option>
                        </select>
                    </div>

                    <div class="mt-3">
                        <span for="asal_sekolah" class="form-label">Asal Sekolah</span>
                        <input class="form-control form-control-sm px-3" id="asal_sekolah" name="asal_sekolah"  placeholder="Sekolah Sebelumnya" required >
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

                var nama_anak = $('#nama_anak').val();
                var usia_anak = $('#usia_anak').val();
                var no_wa = $('#no_wa').val();
                var asal_sekolah = $('#asal_sekolah').val();
                if (nama_anak == '' || asal_sekolah == '' || no_wa == '' || usia_anak == '' ) {

                } else {
                    // disable button
                    $(this).prop("disabled", true);
                    // add spinner to button
                    $(this).html(
                        `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`
                    );
                    $("#form_daftar_trial_class").submit();
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
                $('#form_jenjang').hide();

                $.ajax({
                    url: "{{route('get_kelas_smp')}}",
                    type: 'POST',
                    data: {
                        id_lokasi: id_lokasi,
                         _token: '{{csrf_token()}}'
                    },
                    success: function (result) {
                    //    console.log(result);
                    }
                });
            } else {
                $('#form_jenjang').show();

                $.ajax({
                    url: "{{route('get_jenjang_trial')}}",
                    type: 'POST',
                    data: {
                        id_lokasi: id_lokasi,
                         _token: '{{csrf_token()}}'
                    },
                    success: function (result) {
                        $('#jenjang').html('<option value="" disabled selected>-- Pilih Jenjang --</option>');
                        $.each(result.data, function (key, item) {
                            let tingkat = item.tingkat.toUpperCase();
                            $("#jenjang").append('<option value="' + item
                                .jenjang + '">' + tingkat + '</option>');
                        });
                    }
                });
               
            }
        }
        
    </script>
@endsection