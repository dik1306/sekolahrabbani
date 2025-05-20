@extends('karir.layouts.app')

@section('content')
    <div class="karir">
        <div class="container mt-3">
            <div class="row mt-4">
                @include('karir.admin.sidebar')
                <div class="col-md">
                    <div class="card">
                        <div class="card-body mb-3">
                            <h3 class="card-title">Edit modul</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.update_modul', $modulDiklat->id)}}" method="post" enctype="multipart/form-data">
                                @csrf @method('PUT')
                                <div class="mb-3">
                                    <label for="judul_modul" class="form-label">Judul Modul</label>
                                    <input type="text" class="form-control" id="judul_modul" name="judul_modul" value="{{$modulDiklat->judul_modul}}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi_modul" class="form-label">Deskripsi</label>
                                    <input type="text" class="form-control" id="deskripsi_modul" name="deskripsi_modul" value="{{$modulDiklat->deskripsi_modul}}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="kelas_diklat_id" class="form-label">Modul Pertemuan Ke</label>
                                    <select name="kelas_diklat_id" id="kelas_diklat_id" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih Pertemuan --</option>
                                        @foreach ($kelasDiklat as $item)
                                            <option value="{{ $item->id }}" {{$modulDiklat->kelas_diklat_id == $item->id ? 'selected' : ''}}> Pertemuan ke-{{ $item->pertemuan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="status_modul" class="form-label">Status Modul</label>
                                    <select name="status_modul" id="status_modul" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih Status --</option>
                                        <option value="1" {{$modulDiklat->status_modul == 1 ? 'selected' : ''}}> Aktif</option>
                                        <option value="0" {{$modulDiklat->status_modul == 0 ? 'selected' : ''}}> Non Aktif</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="file_modul" class="form-label">File Modul</label>
                                    @if($modulDiklat->file_modul)
                                        <a href="{{route('download_modul_master', $modulDiklat->id)}}" class="btn btn-sm btn-warning" title="download"><i class="fa-solid fa-download"></i> {{$modulDiklat->file_modul}}</a>
                                        <input type="hidden" class="form-control" id="file_modul_prev" name="file_modul_prev" value="{{$modulDiklat->file_modul}}">
                                    @endif
                                    <input type="file" class="form-control" id="file_modul" name="file_modul" value="{{$modulDiklat->file_modul}}">
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