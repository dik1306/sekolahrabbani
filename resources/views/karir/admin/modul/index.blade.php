@extends('karir.layouts.app')

@section('content')
    <div class="karir">
        <div class="container mt-3">
            <div class="row mt-4">
                @include('karir.admin.sidebar')
                <div class="col-md">
                    <div class="card">
                        <div class="card-body mb-3">
                            <h3 class="card-title">Modul Diklat</h3>
                            <div class="mb-2" style="text-align: right">
                                <a href="{{route('admin.create_modul')}}" class="btn btn-success">Tambah Modul</a>
                            </div>
                            <div class="table-responsive">
                                <table id="modul_diklat" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Judul Modul</th>
                                            <th scope="col">Deskripsi Modul</th>
                                            <th scope="col">File Modul</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($modulDiklat as $item)
                                            <tr>
                                                <th scope="row">{{$loop->iteration}}</th>
                                                <td>{{$item->judul_modul}}</td>
                                                <td>{{$item->deskripsi_modul}}</td>
                                                <td>{{$item->file_modul}}</td>
                                                <td class="d-flex">
                                                    <a href="{{route('admin.edit_modul', $item->id)}}" class="btn btn-sm btn-warning" title="edit"><i class="fa-solid fa-pencil"></i></a>
                                                    <form action="{{route('admin.delete_modul', $item->id)}}" method="post">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger mx-2" title="delete"><i class="fa-solid fa-trash"></i></button>
                                                    </form>
                                                    {{-- <a href="{{route('admin.delete_modul', $item->id)}}" class="btn btn-danger mx-2" title="delete"><i class="fa-solid fa-trash"></i></a> --}}
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

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#modul_diklat').DataTable( {
                responsive: true,
            });
        });
    </script>
@endsection