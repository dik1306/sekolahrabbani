@extends('admin.layouts.app')

@section('content')
    <div class="iq-navbar-header">
        <div style="position: absolute; z-index:-1; top:0; height: 263px">
            <img src="{{asset('assets/images/top-header.png')}} " alt="header" class="theme-color-default-img img-fluid w-100 h-100">
        </div>
        <div class="title my-3">
            <h1 class="text-white" style="margin-left: 1rem">Kumpulan Desain </h1>
        </div>
    </div>
    <div class="container iq-container px-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex" style="justify-content: flex-end">
                    <button class="btn btn-primary btn-sm mx-2" data-bs-toggle="modal" data-bs-target="#add_desain"> Add desain </button>
                    <form action="{{route('export.karya')}}" method="GET" ><button class="btn btn-success btn-sm" > Export Excel </button> </form>
                </div>
                <div class="table-responsive mt-3">
                    <table id="list_desain" class="table table-striped" data-toggle="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Sekolah</th>
                                <th>Kelas</th>
                                <th>Waktu</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list_desain as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$item->nis}} - {{$item->nama_siswa}}</td>
                                    <td>{{$item->lokasi}}</td>
                                    <td>{{$item->nama_kelas}}</td>
                                    <td>{{$item->created_at}}</td>
                                    <td class="d-flex">
                                        <button class="btn btn-sm btn-warning" title="Edit" onclick="edit_desain('{{$item->id}}')" data-bs-toggle="modal" data-bs-target="#edit_materi">
                                            <i class="fa-solid fa-pencil"></i>
                                        </button>
                                        <a href="{{route('download_desain', $item->id)}}" class="btn btn-sm btn-success mx-2" title="Download">
                                            <i class="fa-solid fa-download"></i>
                                        </a>
                                        <button class="btn btn-sm btn-info" title="Lihat Karya" onclick="zoomImage('{{asset('storage/'.$item->image_file)}}')">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add_desain" tabindex="-1" role="dialog" aria-labelledby="desain" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="desain">Tambah desain</h5>
                </div>
                <form action="{{route('master.store_desain')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="sekolah" class="form-control-label">Sekolah</label>
                            <select name="sekolah" id="sekolah" class="select form-control form-control-sm" aria-label=".form-select-sm" onchange="get_kelas()" >
                                <option value="" disabled selected>-- Pilih Sekolah -- </option>
                                    @foreach ($sekolah as $item)
                                        <option value="{{ $item->id_lokasi }}" >{{ $item->sublokasi }}</option>
                                    @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="kelas" class="form-control-label">Kelas</label>
                            <select name="kelas" id="kelas" class="form-control" onchange="get_siswa()" required>
                                <option value="" disabled selected>-- Pilih Kelas --</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="nama_siswa" class="form-control-label">Nama siswa</label>
                            <select name="nama_siswa" id="nama_siswa" class="form-control" required>
                                <option value="" disabled selected>-- Pilih Siswa --</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="image_file" class="form-control-label">Image</label>
                            <input type="file" class="form-control" name="image_file" id="image_file" required>
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

      {{-- edit --}}
    <div class="modal fade" id="edit_materi" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit">Edit Desain</h5>
                </div>
                <form action="#" method="post" enctype="multipart/form-data" id="editForm">
                    @csrf @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="sekolah_edit" class="form-control-label">sekolah</label>
                            <select name="sekolah_edit" id="sekolah_edit" class="form-control form-control-sm" required>
                                <option value="" disabled selected>-- Pilih Sekolah -- </option>
                                @foreach ($sekolah as $item)
                                    <option value="{{ $item->id_lokasi }}" >{{ $item->sublokasi }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="kelas_edit" class="form-control-label">Nama Kelas</label>
                            <input type="text" class="form-control" name="kelas_edit" id="kelas_edit" required>
                        </div>

                        <div class="form-group">
                            <label for="nama_siswa_edit" class="form-control-label">Nama Siswa</label>
                            <input type="text" class="form-control" name="nama_siswa_edit" id="nama_siswa_edit">
                        </div>

                        {{-- <div class="form-group">
                            <label for="gambar" class="form-control-label">Gambar</label>
                            <input type="file" class="form-control" name="gambar" id="gambar_edit" required>
                        </div>

                        <div class="form-group" id="file_group_edit">
                            <label for="file" class="form-control-label">File</label>
                            <input type="file" class="form-control" name="file" id="file_edit">
                        </div> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success btn-sm" >Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

      {{-- modal zoom image --}}
      <div class="modal fade" id="zoom_image" tabindex="-1" role="dialog" aria-labelledby="zoom" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <img id="img_modal" src="#" alt="image-cover" width="100%" >
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
    <script> 
        function get_kelas() {
            var id_sekolah = document.getElementById("sekolah").value

            $.ajax({
                url: "{{route('get_kelas_master')}}",
                type: 'POST',
                data: {
                    id_sekolah: id_sekolah,
                     _token: '{{csrf_token()}}'
                },
                success: function (result) {
                    $('#kelas').html('<option value="" disabled selected>-- Pilih Kelas --</option>');
                    $.each(result.kelas, function (key, item) {
                        $("#kelas").append('<option value="' + item.nama_kelas + '">' + item.nama_kelas + '</option>');
                    });
                }
            });
        }

        function get_siswa() {
            var id_sekolah = document.getElementById("sekolah").value
            var id_kelas = document.getElementById("kelas").value

            $.ajax({
                url: "{{route('get_siswa_master')}}",
                type: 'POST',
                data: {
                    id_sekolah: id_sekolah,
                    id_kelas: id_kelas,
                     _token: '{{csrf_token()}}'
                },
                success: function (result) {
                    $('#nama_siswa').html('<option value="" disabled selected>-- Pilih Siswa --</option>');
                    $.each(result.siswa, function (key, item) {
                        $("#nama_siswa").append('<option value="' + item.nis + '">' + item.nama_lengkap + '</option>');
                    });
                }
            });
        }

        function zoomImage(file)
        {
           $('#zoom_image').modal('show')
           $('#img_modal').attr('src', file)
        }

        function edit_desain(id) {
            $('#penulis_group_edit').hide();
            fetch('/master/kumpul-desain/' + id)
                .then(response => response.json())
                .then(data => {
                    $("#sekolah_edit").val(data.sekolah_id)
                    $("#kelas_edit").val(data.nama_kelas)
                    $("#nama_siswa_edit").val(data.nama_siswa)
                    $("#design_by_edit").val(data.design_by)
                    $("#gambar_edit").val(data.image)
                    $("#file_edit").val(data.file)
                    $("#editForm").attr('action', '/master/kumpul-desain/' + id)
                    $("input[name='_method']").val('PUT')
                })
        }

    </script>
@endsection

