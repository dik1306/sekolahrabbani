@extends('karir.layouts.app')

@section('content')
    <div class="karir">
        <div class="container mt-3">
            <div class="row mt-4">
                @include('karir.admin.sidebar')
                <div class="col-md">
                    <div class="card">
                        <div class="card-body mb-3">
                            <h3 class="card-title">Posisi Lamaran</h3>
                            <div class="mb-2" style="text-align: right">
                                <a href="{{route('admin.create_posisi')}}" class="btn btn-success">Tambah posisi</a>
                            </div>
                            <div class="table-responsive">
                                <table id="posisi_lamaran" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Posisi dilamar</th>
                                            <th scope="col">Tingkat Jabatan</th>
                                            <th scope="col">Divisi</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($posisiLamaran as $item)
                                            <tr>
                                                <th scope="row">{{$loop->iteration}}</th>
                                                <td>{{$item->posisi_dilamar}}</td>
                                                <td>{{$item->tingkat_jabatan}}</td>
                                                <td>{{$item->divisi}}</td>
                                                <td class="d-flex">
                                                    <a href="{{route('admin.edit_posisi', $item->id)}}" class="btn btn-warning" title="edit"><i class="fa-solid fa-pencil"></i></a>
                                                    <form action="{{route('admin.delete_posisi', $item->id)}}" method="post">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-danger mx-2" title="delete"><i class="fa-solid fa-trash"></i></button>
                                                    </form>
                                                    {{-- <a href="{{route('admin.delete_posisi', $item->id)}}" class="btn btn-danger mx-2" title="delete"><i class="fa-solid fa-trash"></i></a> --}}
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
            $('#posisi_lamaran').DataTable( {
                responsive: true,
            });
        });
    </script>
@endsection