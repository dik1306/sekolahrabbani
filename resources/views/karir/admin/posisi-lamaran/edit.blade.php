@extends('karir.layouts.app')

@section('content')
    <div class="karir">
        <div class="container mt-3">
            <div class="row mt-4">
                @include('karir.admin.sidebar')
                <div class="col-md">
                    <div class="card">
                        <div class="card-body mb-3">
                            <h3 class="card-title">Edit posisi</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.update_posisi', $posisiLamaran->id)}}" method="post" enctype="multipart/form-data">
                                @csrf @method('PUT')
                                <div class="mb-3">
                                    <label for="posisi_dilamar" class="form-label">Posisi Dilamar</label>
                                    <input type="text" class="form-control" id="posisi_dilamar" name="posisi_dilamar" value="{{$posisiLamaran->posisi_dilamar}}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tingkat_jabatan" class="form-label">Tingkat jabatan</label>
                                    <input type="text" class="form-control" id="tingkat_jabatan" name="tingkat_jabatan" value="{{$posisiLamaran->tingkat_jabatan}}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="divisi" class="form-label">Divisi</label>
                                    <input type="text" class="form-control" id="divisi" name="divisi" value="{{$posisiLamaran->divisi}}">
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection