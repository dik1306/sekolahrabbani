@extends('karir.layouts.app')

@section('content')
    <div class="karir">
        <div class="container mt-3">
            <div class="row mt-4">
                @include('karir.admin.sidebar')
                <div class="col-md">
                    <div class="card">
                        <div class="card-body mb-3">
                            <h3 class="card-title">Tambah Kelas</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.store_kelas')}}" method="POST">
                                @csrf
                                <div class="d-flex mb-3">
                                    <label for="pertemuan" class="col-3 mt-2 form-label">Pertemuan</label>
                                    <input type="number" class="form-control" id="pertemuan" name="pertemuan" required>
                                </div>
                                <div class="d-flex mb-3">
                                    <label for="forum_link" class="col-3 mt-2 form-label">Link</label>
                                    <input type="text" class="form-control" id="forum_link" name="forum_link" required>
                                </div>
                                <div class="d-flex mb-3">
                                    <label for="deskripsi_kelas" class="col-3 mt-2 form-label">Deskripsi</label>
                                    <input type="text" class="form-control" id="deskripsi_kelas" name="deskripsi_kelas" required>
                                </div>
                                <div class="d-flex mb-3">
                                    <label for="status_kelas" class="col-3 mt-2 form-label">Status Kelas</label>
                                    <select name="status_kelas" id="status_kelas" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih Status --</option>
                                        <option value="1"> Aktif</option>
                                        <option value="0"> Non Aktif</option>
                                    </select>
                                </div>
                                <div class="d-flex mb-3">
                                    <label for="tgl_buka_kelas" class="col-3 mt-2 form-label">Tanggal Buka Kelas</label>
                                    <input type="date" class="form-control" id="tgl_buka_kelas" name="tgl_buka_kelas" required>
                                </div>
                                <div class="d-flex mb-3">
                                    <label for="jam_buka_kelas" class="col-3 mt-2 form-label">Jam Buka Kelas</label>
                                    <input type="time" class="form-control" id="jam_buka_kelas" name="jam_buka_kelas" required>
                                </div>
                                <div class="d-flex mb-3">
                                    <label for="jam_selesai" class="col-3 mt-2 form-label">Jam Selesai Kelas</label>
                                    <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" required>
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