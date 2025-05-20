@extends('karir.layouts.app')

@section('content')
    <div class="karir">
        <div class="container mt-3">
            <div class="row mt-4">
                @include('karir.admin.sidebar')
                <div class="col-md">
                    <div class="card">
                        <div class="card-body mb-3">
                            <h3 class="card-title">Kumpulan Tugas CSDM</h3>
                            <div class="mb-2" style="text-align: right">
                                <a href="{{route('multiple_download')}}" class="btn btn-success">Download All</a>
                            </div>
                            <div class="table-responsive">
                                <table id="kumpul_tugas" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Tugas ke</th>
                                            <th scope="col">File tugas</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kumpul_tugas as $item)
                                            <tr>
                                                <th scope="row">{{$loop->iteration}}</th>
                                                <td>{{$item->user->name}}</td>
                                                <td>{{$item->tugas_id}}</td>
                                                <td>{{$item->file}}</td>
                                                <td class="d-flex">
                                                    <a href="{{route('download_kumpulan_tugas', $item->id)}}" class="btn btn-sm btn-warning" title="download"><i class="fa-solid fa-download"></i></a>
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
            $('#kumpul_tugas').DataTable( {
                responsive: true,
            });
        });
    </script>
@endsection