@extends('karir.layouts.app')

@section('content')
    <div class="karir">
        <div class="container mt-3">
            <div class="row mt-4">
                @include('karir.admin.sidebar')
                <div class="col-md">
                    <div class="card">
                        <div class="card-body mb-3">
                            <h3 class="card-title">Tugas Diklat</h3>
                            <div class="mb-2" style="text-align: right">
                                <a href="{{route('admin.create_tugas')}}" class="btn btn-success">Tambah tugas</a>
                            </div>
                            <div class="table-responsive">
                                <table id="tugas_diklat" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Judul tugas</th>
                                            <th scope="col">Deskripsi tugas</th>
                                            <th scope="col">File tugas</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tugasDiklat as $item)
                                            <tr>
                                                <th scope="row">{{$loop->iteration}}</th>
                                                <td>{{$item->judul_tugas}}</td>
                                                <td>{{$item->deskripsi_tugas}}</td>
                                                <td>{{$item->file_tugas}}</td>
                                                <td class="d-flex">
                                                    <a href="{{route('admin.edit_tugas', $item->id)}}" class="btn btn-sm btn-warning" title="edit"><i class="fa-solid fa-pencil"></i></a>
                                                    <form action="{{route('admin.delete_tugas', $item->id)}}" method="post">
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

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tugas_diklat').DataTable( {
                responsive: true,
            });
        });
    </script>
@endsection