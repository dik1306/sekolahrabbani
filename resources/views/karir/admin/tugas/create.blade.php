@extends('karir.layouts.app')

@section('content')
    <div class="karir">
        <div class="container mt-3">
            <div class="row mt-4">
                @include('karir.admin.sidebar')
                <div class="col-md">
                    <div class="card">
                        <div class="card-body mb-3">
                            <h3 class="card-title">Tambah tugas</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.store_tugas')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="judul_tugas" class="form-label">Judul tugas</label>
                                    <input type="text" class="form-control" id="judul_tugas" name="judul_tugas" required>
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi_tugas" class="form-label">Deskripsi</label>
                                    <input type="text" class="form-control" id="deskripsi_tugas" name="deskripsi_tugas" required>
                                </div>
                                <div class="mb-3">
                                    <label for="modul_id" class="form-label">Tugas dari Modul Ke</label>
                                    <select name="modul_id" id="modul_id" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih Modul --</option>
                                        @foreach ($modulDiklat as $item)
                                            <option value="{{ $item->id }}">{{ $item->judul_modul }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="deadline_tugas" class="form-label">Batas Tanggal Pengumpulan</label>
                                    <input type="date" class="form-control" id="deadline_tugas" name="deadline_tugas" required>
                                </div>
                                <div class="mb-3">
                                    <label for="status_tugas" class="form-label">Status tugas</label>
                                    <select name="status_tugas" id="status_tugas" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih Status --</option>
                                        <option value="1"> Aktif</option>
                                        <option value="0"> Non Aktif</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="file_tugas" class="form-label">File tugas</label>
                                    <input type="file" class="form-control" id="file_tugas" name="file_tugas" required>
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