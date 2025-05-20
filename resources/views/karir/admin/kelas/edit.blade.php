@extends('karir.layouts.app')

@section('content')
    <div class="karir">
        <div class="container mt-3">
            <div class="row mt-4">
                @include('karir.admin.sidebar')
                <div class="col-md">
                    <div class="card">
                        <div class="card-body mb-3">
                            <h3 class="card-title">Edit Kelas</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.update_kelas', $kelasDiklat->id)}}" method="post">
                                @csrf @method('PUT')
                                <div class="mb-3">
                                    <label for="pertemuan" class="form-label">Pertemuan</label>
                                    <input type="number" class="form-control" id="pertemuan" name="pertemuan" value="{{$kelasDiklat->pertemuan}}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="forum_link" class="form-label">Link</label>
                                    <input type="text" class="form-control" id="forum_link" name="forum_link" value="{{$kelasDiklat->forum_link}}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi_kelas" class="form-label">Deskripsi</label>
                                    <input type="text" class="form-control" id="deskripsi_kelas" name="deskripsi_kelas" value="{{$kelasDiklat->deskripsi_kelas}}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="status_kelas" class="form-label">Status Kelas</label>
                                    <select name="status_kelas" id="status_kelas" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih Status --</option>
                                        <option value="1" {{$kelasDiklat->status_kelas == 1 ? 'selected' : ''}}> Aktif</option>
                                        <option value="0" {{$kelasDiklat->status_kelas == 0 ? 'selected' : ''}}> Non Aktif</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="tgl_buka_kelas" class="form-label">Tanggal Buka Kelas</label>
                                    <input type="date" class="form-control" id="tgl_buka_kelas" name="tgl_buka_kelas" value="{{$kelasDiklat->tgl_buka_kelas}}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="jam_buka_kelas" class="form-label">Jam Buka Kelas</label>
                                    <input type="time" class="form-control" id="jam_buka_kelas" name="jam_buka_kelas"  value="{{$kelasDiklat->jam_buka_kelas}}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="jam_selesai" class="form-label">Jam Selesai Kelas</label>
                                    <input type="time" class="form-control" id="jam_selesai" name="jam_selesai"  value="{{$kelasDiklat->jam_selesai}}" required>
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