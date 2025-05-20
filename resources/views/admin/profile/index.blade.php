@extends('admin.layouts.app')

@section('content')
    <div class="iq-navbar-header">        
        <div style="position: absolute; z-index:-1; top:0; height: 263px">
            <img src="{{asset('assets/images/top-header.png')}} " alt="header" class="theme-color-default-img img-fluid w-100 h-100">
        </div>
        <div class="d-flex title mt-3" style="justify-content: space-between">
            <h1 class="text-white" style="margin-left: 1rem">Profile </h1>
            <button type="submit" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#member"> <i class="fa-regular fa-id-card"></i> Member</button>
        </div>
    </div>
    <div class="container iq-container px-3">
        <div class="mt-3">
            @foreach ($profile as $item)
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <form style="font-size: 0.95rem">
                            <div class="d-flex">
                                <label for="nis" class="form-label form-label-sm col-4">NIS</label>
                                <div id="nis" name="nis" >: {{$item->nis}} </div>
                            </div>
                            <div class="d-flex">
                                <label for="nama_lengkap" class="form-label col-4">Nama</label>
                                <div id="nama_lengkap" name="nama_lengkap" >: {{$item->nama_lengkap}} </div>
                            </div>
                            <div class="d-flex">
                                <label for="tahun_masuk" class="form-label col-4">Tahun Masuk</label>
                                <div id="tahun_masuk" name="tahun_masuk" >: {{$item->tahun_masuk}} </div>
                            </div>
                            <div class="d-flex">
                                <label for="kelas" class="form-label col-4">Kelas</label>
                                <div id="kelas" name="kelas" >: {{$item->kelas_id}} </div>
                            </div>
                            <div class="d-flex">
                                <label for="jenjang" class="form-label col-4">Jenjang</label>
                                <div id="jenjang" name="jenjang" >: {{$item->jenjang_id}} </div>
                            </div>
                            <div class="d-flex">
                                <label for="no_hp_ibu" class="form-label col-4">No Hp Ibu</label>
                                <div id="no_hp_ibu" name="no_hp_ibu" >: {{$item->no_hp_ibu}} </div>
                            </div>
                            <div class="d-flex">
                                <label for="no_hp_ayah" class="form-label col-4">No Hp Ayah</label>
                                <div id="no_hp_ayah" name="no_hp_ayah" >: {{$item->no_hp_ayah}} </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

<div class="modal fade" id="member" tabindex="-1" role="dialog" aria-labelledby="member_rbn" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="member_rbn">Anggota Member Rabbani</h5>
            </div>
            <div class="modal-body">
                <small > Gunakan Kartu Member ini untuk berbelanja di Toko Rabbani kesayangan Anda. <b> Dapatkan Diskon Speial !! </b> </small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>