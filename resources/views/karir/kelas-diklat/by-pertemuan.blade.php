@extends('karir.layouts.app')

@section('content')
    <div class="karir">
        <div class="container mt-3">
            <div class="row mt-4">
                <div class="col-md-2">
                    <div class="card">
                        <div class="card-body">
                            <nav class="nav flex-column nav-menu">
                               @foreach ($kelasDiklat as $item)
                                    <a class="nav-link" href="{{route('karir.kelas_pertemuan', $item->pertemuan)}}">Pertemuan {{$item->pertemuan}}</a>
                               @endforeach
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="card">
                        <div class="card-body mb-3">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="nav-forum-tab" data-bs-toggle="tab" data-bs-target="#nav-forum" type="button" role="tab" aria-controls="nav-forum" aria-selected="true">Forum</button>
                                <button class="nav-link" id="nav-modul-tab" data-bs-toggle="tab" data-bs-target="#nav-modul" type="button" role="tab" aria-controls="nav-modul" aria-selected="false">Modul</button>
                                <button class="nav-link" id="nav-tugas-tab" data-bs-toggle="tab" data-bs-target="#nav-tugas" type="button" role="tab" aria-controls="nav-tugas" aria-selected="false">Tugas</button>
                                </div>
                            </nav>
                            @foreach ($kelas_with_modul as $item)
                                <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-forum" role="tabpanel" aria-labelledby="nav-forum-tab" tabindex="0">
                                    <p class="mt-3">Waktu mulai sesi ini : {{$item->tgl_buka_kelas}}, {{$item->jam_buka_kelas}} - {{$item->jam_selesai}} </p>
                                    <p class="mt-3">Deskripsi : {{$item->deskripsi_kelas}} </p>
                                    @if ($item->tgl_buka_kelas < date('Y-m-d'))
                                        <p class="mt-3">Link sesi ini : <a href="#" style="text-decoration: none"> Kelas sudah terlewati </a></p>
                                    @else 
                                        <p class="mt-3">Link sesi ini : <a href="{{$item->forum_link}}" target="_blank"> {{$item->forum_link}} </a></p>
                                    @endif
                                </div>
                                <div class="tab-pane fade" id="nav-modul" role="tabpanel" aria-labelledby="nav-modul-tab" tabindex="0">
                                    <h5 class="mt-3">Judul Modul: {{$item->modul[0]->judul_modul}}</h5>
                                    <p class="mt-3">Deskripsi Modul : {{$item->modul[0]->deskripsi_modul}} </p>
                                    @if ($item->modul[0]->status_modul == 1)
                                        <a href="{{route('download_modul', $item->modul[0]->kelas_diklat_id)}}" class="btn btn-primary btn-modul">Download Modul</a>
                                    @else
                                        <a href="" onclick="return false" class="btn btn-primary btn-modul">Download Modul</a>
                                    @endif
                                </div>
                                <div class="tab-pane fade" id="nav-tugas" role="tabpanel" aria-labelledby="nav-tugas-tab" tabindex="0">
                                    <h5 class="mt-3">Judul Tugas: {{$item->modul[0]->tugas->judul_tugas}} </h5>
                                    <p class="mt-3">Deskripsi Tugas: {{$item->modul[0]->tugas->deskripsi_tugas}} </p>
                                    <h6 class="mt-3"> Status Tugas </h6>
                                    <p> Waktu Pengumpulan : {{$item->modul[0]->tugas->deadline_tugas}} </p>

                                    @if ($kumpul_tugas_by_id != null)
                                    <a href="{{route('download_tugas_uploaded', $kumpul_tugas_by_id->id)}}" class="btn btn-sm btn-warning" title="download"><i class="fa-solid fa-download"></i> {{$kumpul_tugas_by_id->file}}</a>
                                    <input type="hidden" class="form-control" id="file_modul_prev" name="file_modul_prev" value="{{$kumpul_tugas_by_id->file}}">
                                    <p> Terakhir diupload : <i> {{$kumpul_tugas_by_id->updated_at}} </i> </p>
                                    @else
                                    <p> Terakhir diupload : <i> - </i> </p>
                                    @endif

                                    <div class="d-flex">
                                        @if($item->modul[0]->tugas->deadline_tugas < date('Y-m-d') || $item->modul[0]->tugas->status_tugas == 0)
                                            <a href="/" class="btn btn-primary mx-2" onclick="return false" >Download Tugas</a>                                          
                                            <button type="button" class="btn btn-warning" style="border-radius: 1rem" data-bs-toggle="modal" data-bs-target="#upload_tugas" disabled>Upload Tugas</button>
                                        @else
                                            <a href="{{route('download_tugas', $item->modul[0]->tugas->modul_id)}}" class="btn btn-primary mx-2">Download Tugas</a>
                                            <button type="button" class="btn btn-warning" style="border-radius: 1rem" data-bs-toggle="modal" data-bs-target="#upload_tugas">Upload Tugas</button>
                                        @endif
                                    </div>
                                    <p class="mt-3 mr-3" style="font-size: 12px;"><i>notes: maksimal upload file 1 MB </i></p>
                                </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="upload_tugas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post" action="{{route('upload_tugas')}}" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Upload Tugas</h5>
                    </div>
                    <div class="modal-body">

                        {{ csrf_field() }}

                        <label>Pilih tugas ke berapa</label>
                        <select class="form-select" name="pertemuan_ke" aria-label="Default select example">
                            <option value="" selected>Open this select menu</option>
                            @foreach($kelasDiklat as $item)
                                <option name="tugas_pertemuan" value="{{$item->pertemuan}}">Pertemuan {{$item->pertemuan}} </option>
                            @endforeach
                        </select>
                        <br>
                        <label>Pilih file tugas</label>
                        <div class="form-group">
                            <input type="file" name="file" required="required">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Upload</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll(".nav-link").forEach((link) => {
            if (link.href === window.location.href) {
                link.classList.add("active");
                link.setAttribute("aria-current", "page");
            }
        });
    </script>
@endsection