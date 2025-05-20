@extends('admin.layouts.app')

@section('content')
    <div class="iq-navbar-header">
        <div style="position: absolute; z-index:-1; top:0; height: 263px">
            <img src="{{asset('assets/images/top-header.png')}} " alt="header" class="theme-color-default-img img-fluid w-100 h-100">
        </div>
        <div class="title my-3">
            <h1 class="text-white" style="margin-left: 1rem">List Materi Palestine Day </h1>
        </div>
    </div>
    <div class="container iq-container px-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex" style="justify-content: flex-end">
                    <button class="btn btn-success btn-sm mx-2" data-bs-toggle="modal" data-bs-target="#add_materi"> Add Materi </button>
                </div>
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-tksd-tab" data-bs-toggle="tab" data-bs-target="#nav-tksd" type="button" role="tab" aria-controls="nav-tksd" aria-selected="true">TK SD</button>
                        <button class="nav-link" id="nav-smp-tab" data-bs-toggle="tab" data-bs-target="#nav-smp" type="button" role="tab" aria-controls="nav-smp" aria-selected="false">SMP</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-tksd" role="tabpanel" aria-labelledby="nav-tksd-tab" tabindex="0">
                        <div class="table-responsive mt-3">
                            <table id="data_tksd" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>File </th>
                                        <th>Image</th>
                                        <th>Status</th>
                                        <th>Penulis</th>
                                        <th>Created at</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($materi_tksd as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->judul}}</td>
                                            <td> 
                                                <img src="{{asset('storage/'.$item->image)}}" id="img_cover_{{$item->id}}" onclick="zoomImage('{{asset('storage/'.$item->image)}}')" width="20px">
                                            </td>
                                            <td>{{$item->file}}</td>
                                            @if ($item->status == 0) 
                                                <td> <span class="badge rounded-pill bg-danger" >Tidak Aktif </span></td>
                                            @else
                                                <td> <span class="badge rounded-pill bg-success"> Aktif </span> </td>
                                            @endif
                                            <td>{{$item->created_by}}</td>
                                            <td>{{$item->created_at}}</td>
                                            <td class="d-flex">
                                                <button class="btn btn-sm btn-warning" title="Edit" onclick="edit_data_tksd('{{$item->id}}')" data-bs-toggle="modal" data-bs-target="#edit_materi">
                                                    <i class="fa-solid fa-pencil"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-smp" role="tabpanel" aria-labelledby="nav-smp-tab" tabindex="0">
                        <div class="table-responsive mt-3">
                            <table id="data_smp" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Image </th>
                                        <th>File </th>
                                        <th>Design by </th>
                                        <th>Status</th>
                                        <th>Terbit</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($materi_smp as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->judul}}</td>
                                            <td><img src="{{asset('storage/'.$item->image)}}"  id="img_cover_{{$item->id}}" onclick="zoomImage('{{asset('storage/'.$item->image)}}')" width="20px"></td>
                                            <td>{{$item->file}}</td>
                                            <td>{{$item->design_by}}</td>
                                            @if ($item->status == 0) 
                                                <td> <span class="badge rounded-pill bg-danger" >Tidak Aktif </span></td>
                                            @else
                                                <td> <span class="badge rounded-pill bg-success"> Aktif </span> </td>
                                            @endif
                                            <td>{{$item->terbit}}</td>
                                            <td class="d-flex">
                                                <button class="btn btn-sm btn-warning" title="Edit" onclick="edit_data_smp('{{$item->id}}')" data-bs-toggle="modal" data-bs-target="#edit_materi">
                                                    <i class="fa-solid fa-pencil"></i>
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
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    {{-- create materi --}}
    <div class="modal fade" id="add_materi" tabindex="-1" role="dialog" aria-labelledby="create_materi" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{route('materi.store')}}" enctype="multipart/form-data" method="post" >
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="create_materi">Tambah materi</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="jenjang" class="form-control-label">Jenjang</label>
                            <select name="jenjang" id="jenjang" onchange="getMateri()" class="form-control form-control-sm" required>
                                <option value="" disabled selected> </option>
                                <option value="1" >Kober - TK - SD </option>
                                <option value="2" >SMP </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="judul" class="form-control-label">Judul</label>
                            <input type="text" class="form-control" name="judul" id="judul" required>
                        </div>

                        <div class="form-group">
                            <label for="warna" class="form-control-label">Warna</label>
                            <input type="warna" class="form-control" name="warna" id="warna">
                        </div>

                        <div class="form-group" id="penulis_group">
                            <label for="penulis" class="form-control-label">Penulis</label>
                            <input type="text" class="form-control" name="penulis" id="penulis">
                        </div>

                        <div class="form-group" id="design_by_group">
                            <label for="design_by" class="form-control-label">Design by</label>
                            <input type="text" class="form-control" name="design_by" id="design_by">
                        </div>

                        <div class="form-group" id="terbit_group">
                            <label for="terbit" class="form-control-label">Terbit</label>
                            <input type="date" class="form-control" name="terbit" id="terbit">
                        </div>

                        <div class="form-group">
                            <label for="gambar" class="form-control-label">Gambar</label>
                            <input type="file" class="form-control" name="gambar" id="gambar" required>
                        </div>

                        <div class="form-group" id="file_group">
                            <label for="file" class="form-control-label">File</label>
                            <input type="file" class="form-control" name="file" id="file">
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
                    <h5 class="modal-title" id="edit">Edit materi</h5>
                </div>
                <form action="#" method="post" enctype="multipart/form-data" id="editForm">
                    @csrf @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="jenjang_edit" class="form-control-label">Jenjang</label>
                            <select name="jenjang_edit" id="jenjang_edit" onchange="getMateri()" class="form-control form-control-sm" required>
                                <option value="" disabled selected> </option>
                                <option value="1" >Kober - TK - SD </option>
                                <option value="2" >SMP </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="judul_edit" class="form-control-label">Judul</label>
                            <input type="text" class="form-control" name="judul_edit" id="judul_edit" required>
                        </div>

                        <div class="form-group">
                            <label for="warna_edit" class="form-control-label">Warna</label>
                            <input type="text" class="form-control" name="warna_edit" id="warna_edit">
                        </div>

                        <div class="form-group" id="penulis_group_edit">
                            <label for="penulis_edit" class="form-control-label">Penulis</label>
                            <input type="text" class="form-control" name="penulis_edit" id="penulis_edit">
                        </div>

                        <div class="form-group" id="design_by_group_edit">
                            <label for="design_by_edit" class="form-control-label">Design by</label>
                            <input type="text" class="form-control" name="design_by_edit" id="design_by_edit">
                        </div>

                        <div class="form-group" id="terbit_group_edit">
                            <label for="terbit_edit" class="form-control-label">Terbit</label>
                            <input type="date" class="form-control" name="terbit_edit" id="terbit_edit">
                        </div>

                        <div class="form-group" id="evaluasi_group_edit">
                            <label for="evaluasi_edit" class="form-control-label">Link Evaluasi</label>
                            <input type="text" class="form-control" name="evaluasi_edit" id="evaluasi_edit">
                        </div>

                        <div class="form-group">
                            <label for="status_edit" class="form-control-label">Status</label>
                            <select name="status_edit" id="status_edit" class="form-control form-control-sm" required>
                                <option value="" disabled selected> </option>
                                <option value="1" >Aktif</option>
                                <option value="0" >Tidak Aktif </option>
                            </select>
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
        
        function getMateri() {
            var jenjang = document.getElementById("jenjang").value

            if (jenjang == 2) {
                $('#penulis_group').hide();
                $('#terbit_group').show();
                $('#design_by_group').show();
            } else {
                $('#terbit_group').hide();
                $('#penulis_group').show();
                $('#design_by_group').hide();
            }
        }

        function edit_data_smp(id) {
            $('#penulis_group_edit').hide();
            fetch('/master/palestine-day/' + id)
                .then(response => response.json())
                .then(data => {
                    $("#jenjang_edit").val(data.jenjang)
                    $("#judul_edit").val(data.judul)
                    $("#warna_edit").val(data.style)
                    $("#design_by_edit").val(data.design_by)
                    $("#terbit_edit").val(data.terbit)
                    $("#evaluasi_edit").val(data.link_evaluasi)
                    $("#status_edit").val(data.status)
                    $("#gambar_edit").val(data.image)
                    $("#file_edit").val(data.file)
                    $("#editForm").attr('action', '/master/palestine-day/' + id)
                    $("input[name='_method']").val('PUT')
                })
        }

        function edit_data_tksd(id) {
            var url = "{{ route('master.update-materi', '') }}" + "/" + id;
            $('#terbit_group_edit').hide();
            $('#design_by_group_edit').hide();
            fetch('/master/palestine-day/' + id)
                .then(response => response.json())
                .then(data => {
                    $("#jenjang_edit").val(data.jenjang)
                    $("#judul_edit").val(data.judul)
                    $("#warna_edit").val(data.style)
                    $("#penulis_edit").val(data.created_by)
                    $("#status_edit").val(data.status)
                    $("#evaluasi_edit").val(data.link_evaluasi)
                    $("#gambar_edit").val(data.image)
                    $("#file_edit").val(data.file)
                    $("#editForm").attr('action', url)
                    $("input[name='_method']").val('PUT')
                })
        }

        function zoomImage(file)
        {
           $('#zoom_image').modal('show')
           $('#img_modal').attr('src', file)
        }

    </script>
@endsection

<style>
   
    table.dataTable th:nth-child(4) {
        width: 300px;
        max-width: 300px;
        word-break: break-all;
        white-space: pre-line;
    }

    table.dataTable td:nth-child(4) {
        width: 300px;
        max-width: 300px;
        word-break: break-all;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
