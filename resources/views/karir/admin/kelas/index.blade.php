@extends('karir.layouts.app')

@section('content')
    <div class="karir">
        <div class="container mt-3">
            <div class="row mt-4">
                @include('karir.admin.sidebar')
                <div class="col-md">
                    <div class="card">
                        <div class="card-body mb-3">
                            <h3 class="card-title">Kelas Diklat</h3>
                            <div class="mb-2" style="text-align: right">
                                <a href="{{route('admin.create_kelas')}}" class="btn btn-success">Tambah Kelas</a>
                            </div>
                            <div class="table-responsive">
                                <table id="kelas_diklat" class="table table-striped dt-responsive" >
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Pertemuan</th>
                                            <th scope="col">Link</th>
                                            <th scope="col">Deskripsi</th>
                                            <th scope="col">Tanggal dan Jam</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kelasDiklat as $item)
                                            <tr>
                                                <th scope="row">{{$loop->iteration}}</th>
                                                <td>Pertemuan {{$item->pertemuan}}</td>
                                                <td><a href="{{$item->forum_link}}" target="_blank"> {{$item->forum_link}} </a></td>
                                                <td>{{$item->deskripsi_kelas}}</td>
                                                <td>{{$item->tgl_buka_kelas}}, Jam : {{$item->jam_buka_kelas}} - {{$item->jam_selesai}}</td>
                                                <td class="d-flex">
                                                    <a href="{{route('admin.edit_kelas', $item->id)}}" class="btn btn-sm btn-warning" title="edit"><i class="fa-solid fa-pencil"></i></a>
                                                    <form action="{{route('admin.delete_kelas', $item->id)}}" method="post">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger mx-2" title="delete"><i class="fa-solid fa-trash"></i></button>
                                                    </form>
                                                    {{-- <a href="{{route('admin.delete_kelas', $item->id)}}" class="btn btn-danger mx-2" title="delete"><i class="fa-solid fa-trash"></i></a> --}}
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
            $('#kelas_diklat').DataTable( {
                responsive: true,
            });
        });
    </script>
@endsection