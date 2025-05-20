@extends('karir.layouts.app')

@section('content')
    <div class="karir">
        <div class="container mt-3">
            <div class="row mt-4">
                @include('karir.admin.sidebar')
                <div class="col-md">
                    <div class="card">
                        <div class="card-body mb-3">
                            <h3 class="card-title">Jadwal Kontrak</h3>
                            <div class="mb-2" style="text-align: right">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#upload_nilai"><i class="fa-solid fa-file"></i>
                                    Upload Jadwal
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table id="jadwal_kontrak" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">File nilai</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jadwalKontrak as $item)
                                            <tr>
                                                <th scope="row">{{$loop->iteration}}</th>
                                                <td>{{$item->nama}}</td>
                                                <td>{{$item->file}}</td>
                                                <td class="d-flex">
                                                    <a href="#" class="btn btn-sm btn-warning" title="edit"><i class="fa-solid fa-pencil"></i></a>
                                                    <form action="#" method="post">
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
            <form method="post" action="{{route('upload_jadwal_kontrak')}}" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Upload nilai</h5>
                    </div>
                    <div class="modal-body">

                        {{ csrf_field() }}

                        <label>Nama Deskripsi</label>
                        <div class="form-group mb-3">
                            <input type="text" name="nama" required="required">
                        </div>

                        <label>Pilih Dokumen Jadwal Kontrak</label>
                        <div class="form-group">
                            <input type="file" name="file" required="required">
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

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#jadwal_kontrak').DataTable( {
                responsive: true,
            });
        });
    </script>
@endsection