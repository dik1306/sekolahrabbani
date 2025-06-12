@extends('admin.layouts.app')

@section('content')
    <div class="iq-navbar-header">
        <div style="position: absolute; z-index:-1; top:0; height: 263px">
            <img src="{{asset('assets/images/top-header.png')}} " alt="header" class="theme-color-default-img img-fluid w-100 h-100">
        </div>
        <div class="title my-3">
            <h1 class="text-white" style="margin-left: 1rem">List Trial Class </h1>
        </div>
    </div>
    <div class="container iq-container px-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex" style="justify-content: flex-end">
                    {{-- <button class="btn btn-primary btn-sm mx-2" data-bs-toggle="modal" data-bs-target="#add_merchandise"> Add Merchandise </button> --}}
                </div>
                <div class="table-responsive mt-3">
                    <table id="list_merchandise" class="table table-striped" data-toggle="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Id</th>
                                <th>Nama Anak</th>
                                <th>Usia</th>
                                <th>Asal Sekolah</th>
                                <th>Lokasi</th>
                                <th>Jenjang</th>
                                <th>Tahun Ajaran</th>
                                <th>Tgl. Input</th>
                                <th>Nomor Whatsapp</th>
                                <th>Jadwal TC</th>
                                <th>Status TC</th>
                                <th>Hasil TC</th>
                                <th>Ket.</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($get_data_trial_class as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->nama_anak}}</td>
                                    <td>{{$item->tgl_lahir}}</td>
                                    <td>{{$item->asal_sekolah}}</td>
                                    <td>{{$item->tujuan_sekolah}}</td>
                                    <td>{{$item->nama_jenjang}}</td>
                                    <td>{{$item->tahun_ajar}}</td>
                                    <td>{{date('d-m-Y H:i:s', strtotime($item->created_at))}}</td>
                                    <td>{{$item->no_wa}}</td>
                                    <td>
                                        @if($item->jadwal_trialclass=='')
                                            @if($item->hasil_tc=='3')
                                            @else
                                            <a href="#" class="btn btn-sm btn-success" title="Jadwal" onclick="input_jadwal('{{$item->id}}')"><i class="fa-solid fa-pencil"></i></a>
                                            @endif
                                        @else
                                        {{$item->jadwal_trialclass}}
                                        @endif
                                    </td>
                                    <td></td>
                                    <td>
                                        @if($item->hasil_tc=='1')
                                        Lanjut
                                        @elseif($item->hasil_tc=='2')
                                        Tidak
                                        @elseif($item->hasil_tc=='3')
                                        Batal
                                        @else
                                        
                                        @endif
                                    </td>
                                    <td>{{$item->keterangan}}</td>
                                    <td>
                                        @if($item->hasil_tc=='0')
                                        <a href="#" class="btn btn-sm btn-success" title="Edit" onclick="input_hasil('{{$item->id}}')"><i class="fa-solid fa-pencil"></i></a>
                                        @else
                                        
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function input_jadwal(id){
            $("#form_input_jadwal").modal('show');
            $("#id_").val(id);
        }

        function simpan(){
            var tgl_ = $("#tgl_").val();
            var id_ = $("#id_").val();
            // alert(id+' - '+komentar);
            // return;
            var url_simpan = "{{route('simpan-jadwal')}}";
            // console.log(url_simpan);
            // return;
            $("#btn-update").hide();
            $.ajax({ 
                url: url_simpan,
                type:"PUT",
                cache: false,
                data:{
                    id:id_,
                    tgl_:tgl_,
                    _token: '{{csrf_token()}}'
                },
                success: function(data) {
                    console.log(data)
                    window.location.href = "/laporan/trial-class"
                }
            });//end foreach
        }

        function input_hasil(id){
            $("#hasil_tc").modal('show');
            $("#nomor_eksekusi").val(id);
        }

        function batal_inputhasil(){
            $("#hasil_tc").modal('hide');
        }

        function simpan_hasil(){
            var nomor_eksekusi = $("#nomor_eksekusi").val();
            var stat = $("#stat").val();
            var keterangan = $("#keterangan").val();
            var url_simpan = "{{route('simpan-hasil')}}";

            // console.log(stat);
            if(stat== null){
                console.log('kosong euy');
                alert('silahkan isi hasil TC terlebih dahulu!');
                $("#stat").focus();
            }else{
                $.ajax({ 
                    url: url_simpan,
                    type:"PUT",
                    cache: false,
                    data:{
                        nomor_eksekusi:nomor_eksekusi,
                        stat:stat,
                        keterangan:keterangan,
                        _token: '{{csrf_token()}}'
                    },
                    success: function(data) {
                        console.log(data)
                        window.location.href = "/laporan/trial-class"
                    }
                });//end foreach
            }
        }
    </script>
    
    <div class="modal fade" id="form_input_jadwal" tabindex="-1" role="dialog" aria-labelledby="jenis_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >Silahkan pilih tanggal dan jam</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_jenis" class="form-control-label">Tanggal & Jam</label>
                        <input type="hidden" id="id_">
                        <input type="datetime-local" class="form-control" name="tgl_" id="tgl_" value="{{ now()->format('Y-m-d\TH:i:s') }}" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                    <span class="btn btn-primary btn-sm" id="btn-update" onclick="simpan()">Update</span>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="hasil_tc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-body">
                <form>
                <div class="form-group">
                    <input type="hidden" id="nomor_eksekusi" class="form-control">
                    <label for="recipient-name" class="col-form-label">Hasil Trial Class :</label>
                   

                    <select id="stat" class="form-control" required>
                        <option value="" disabled selected> </option>
                            @foreach ($status as $d)
                                <option value="{{ $d->id }}">{{ $d->nama_status }}</option>
                            @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="message-text" class="col-form-label">Keterangan:</label>
                    <textarea id="keterangan" name="keterangan" class="form-control" rows="3" style="display: block;"></textarea>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" onclick="batal_inputhasil()">Tutup</button>
                <span class="btn btn-primary btn-sm" onclick="simpan_hasil()">Simpan</span>
            </div>
            </div>
        </div>
        </div>

    {{-- <div class="modal fade" id="add_merchandise" tabindex="-1" role="dialog" aria-labelledby="merchandise" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="merchandise">Tambah Merchandise</h5>
                </div>
                <form action="{{route('store_merchandise')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_merchandise" class="form-control-label">Nama Merchandise</label>
                            <input type="text" class="form-control" name="nama_merchandise" id="nama_merchandise" required>
                        </div>

                        <div class="form-group">
                            <label for="jenis" class="form-control-label">Jenis</label>
                            <select name="jenis" id="jenis" class="select2 form-control form-control-sm" aria-label=".form-select-sm" >
                                <option value="" disabled selected> </option>
                                    @foreach ($jenis_merchandise as $item)
                                        <option value="{{ $item->id }}" >{{ $item->jenis }}</option>
                                    @endforeach
                            </select>
                            <span> Buat jenis baru? <a href="#add_jenis" data-bs-toggle="modal" data-bs-target="#add_jenis"> Klik disini </a> </span>
                        </div>

                        <div class="form-group">
                            <label for="deskripsi" class="form-control-label">Deskripsi</label>
                            <input type="text" class="form-control" name="deskripsi" id="deskripsi" required>
                        </div>

                        <div class="form-group">
                            <label for="harga" class="form-control-label">Harga</label>
                            <input type="text" class="form-control" name="harga" id="harga" required>
                        </div>

                        <div class="form-group">
                            <label for="diskon" class="form-control-label">Diskon</label>
                            <input type="text" class="form-control" name="diskon" id="diskon" required>
                        </div>

                        <div class="form-group">
                            <label for="image_1" class="form-control-label">Image 1</label>
                            <input type="file" class="form-control" name="image_1" id="image_1" required>
                        </div>

                        <div class="form-group">
                            <label for="image_2" class="form-control-label">Image 2</label>
                            <input type="file" class="form-control" name="image_2" id="image_2">
                        </div>

                        <div class="form-group">
                            <label for="image_3" class="form-control-label">Image 3</label>
                            <input type="file" class="form-control" name="image_3" id="image_3">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success btn-sm" >Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    --}}
@endsection

