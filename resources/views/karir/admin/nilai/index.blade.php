@extends('karir.layouts.app')

@section('content')
    <div class="karir">
        <div class="container mt-3">
            <div class="row mt-4">
                @include('karir.admin.sidebar')
                <div class="col-md">
                    <div class="card">
                        <div class="card-body mb-3">
                            <h3 class="card-title">Nilai Diklat</h3>
                            <div class="mb-2" style="text-align: right">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#upload_nilai"><i class="fa-solid fa-file"></i>
                                    Upload Nilai
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table id="nilai_diklat" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Kode CSDM</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">File nilai</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($nilaiDiklat as $item)
                                            <tr>
                                                <th scope="row">{{$loop->iteration}}</th>
                                                <td>{{$item->kode_csdm}}</td>
                                                <td>{{$item->profile_csdm->nama_lengkap}}</td>
                                                <td>{{$item->file_nilai}}</td>
                                                <td class="d-flex">
                                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#edit_nilai"><i class="fa-solid fa-pencil"></i>
                                                    </button>
                                                    {{-- <a href="{{route('admin.edit_nilai', $item->id)}}" class="btn btn-sm btn-warning" title="edit"><i class="fa-solid fa-pencil"></i></a> --}}
                                                    <form action="{{route('admin.delete_nilai', $item->id)}}" method="post">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger mx-2" title="delete"><i class="fa-solid fa-trash"></i></button>
                                                    </form>
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
    </div>

    <div class="modal fade" id="upload_nilai" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post" action="{{route('upload_nilai')}}" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Upload nilai</h5>
                    </div>
                    <div class="modal-body">

                        {{ csrf_field() }}

                        <label>Pilih CSDM</label>
                        <select class="form-select" name="id_profile_csdm" aria-label="Default select example">
                            <option value="" selected disabled>--Pilih CSDM--</option>
                            @foreach($csdm as $item)
                                <option value="{{$item->id}}"> {{$item->name}} </option>
                            @endforeach
                        </select>
                        <br>
                        <label>Pilih Dokumen Nilai</label>
                        <div class="form-group">
                            <input type="file" name="file_nilai" required="required">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Upload</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- <div class="modal fade" id="edit_nilai" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post" action="{{route('upload_nilai')}}" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit nilai</h5>
                    </div>
                    <div class="modal-body">

                        {{ csrf_field() }}

                        <label>Pilih CSDM</label>
                        <select class="form-select" name="id_profile_csdm" aria-label="Default select example">
                            <option value="" selected disabled>--Pilih CSDM--</option>
                            @foreach($user as $item)
                                <option value="{{$item->id}}"> {{$item->name}} </option>
                            @endforeach
                        </select>
                        <br>
                        <label>Pilih Dokumen Nilai</label>
                        <div class="form-group">
                            <input type="file" name="file_nilai" required="required">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Upload</button>
                    </div>
                </div>
            </form>
        </div>
    </div> --}}

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#nilai_diklat').DataTable( {
                responsive: true,
            });
        });
    </script>
@endsection