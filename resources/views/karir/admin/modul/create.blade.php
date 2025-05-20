@extends('karir.layouts.app')

@section('content')
    <div class="karir">
        <div class="container mt-3">
            <div class="row mt-4">
                @include('karir.admin.sidebar')
                <div class="col-md">
                    <div class="card">
                        <div class="card-body mb-3">
                            <h3 class="card-title">Tambah modul</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.store_modul')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="judul_modul" class="form-label">Judul Modul</label>
                                    <input type="text" class="form-control" id="judul_modul" name="judul_modul" required>
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi_modul" class="form-label">Deskripsi</label>
                                    <input type="text" class="form-control" id="deskripsi_modul" name="deskripsi_modul" required>
                                </div>
                                <div class="mb-3">
                                    <label for="kelas_diklat_id" class="form-label">Modul Pertemuan Ke</label>
                                    <select name="kelas_diklat_id" id="kelas_diklat_id" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih Pertemuan --</option>
                                        @foreach ($kelasDiklat as $item)
                                            <option value="{{ $item->id }}"> Pertemuan ke-{{ $item->pertemuan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="status_modul" class="form-label">Status Modul</label>
                                    <select name="status_modul" id="status_modul" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih Status --</option>
                                        <option value="1"> Aktif</option>
                                        <option value="0"> Non Aktif</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="file_modul" class="form-label">File Modul</label>
                                    <input type="file" class="form-control" id="file_modul" name="file_modul" required>
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