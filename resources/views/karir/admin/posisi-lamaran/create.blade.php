@extends('karir.layouts.app')

@section('content')
    <div class="karir">
        <div class="container mt-3">
            <div class="row mt-4">
                @include('karir.admin.sidebar')
                <div class="col-md">
                    <div class="card">
                        <div class="card-body mb-3">
                            <h3 class="card-title">Tambah posisi</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.store_posisi')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="posisi_dilamar" class="form-label">Posisi Dilamar</label>
                                    <input type="text" class="form-control" id="posisi_dilamar" name="posisi_dilamar" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tingkat_jabatan" class="form-label">Tingkat Jabatan</label>
                                    <input type="text" class="form-control" id="tingkat_jabatan" name="tingkat_jabatan" required>
                                </div>
                                <div class="mb-3">
                                    <label for="divisi" class="form-label">Divisi</label>
                                    <input type="text" class="form-control" id="divisi" name="divisi" required>
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