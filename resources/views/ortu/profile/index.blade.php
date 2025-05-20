@extends ('ortu.layouts.app')

@section('content')
    <div class="top-navigate sticky-top">
        <div class="d-flex" style="justify-content: stretch; width: 100%;">
            <a onclick="window.history.go(-1); return false;" class="mt-1" style="text-decoration: none; color: black">
                <i class="fa-solid fa-arrow-left fa-lg"></i>
            </a>
            <h4 class="mx-auto"> Profile </h4>
        </div>
        <div class="row mt-3">
            <div class="accordion">
                @foreach ($menu_profile as $item)
                    @if ($item->url == '#')
                        <div class="accordion-item">
                            <span class="accordion-header" id="flush-{{$item->id}}">
                                <button class="accordion-button collapsed" style="font-size: 12px;" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{$item->id}}" aria-expanded="true" aria-controls="flush-collapse{{$item->id}}">
                                    <i class="{{$item->icon}}" style="color: {{$item->style}}"> </i> &nbsp; {{$item->name}}

                                </button>
                            </span>
                            <div id="flush-collapse{{$item->id}}" class="accordion-collapse collapse" aria-labelledby="flush-{{$item->id}}">
                                <div class="accordion-body">
                                    <div class="row">
                                        <h6> Profile Anak </h6>
                                    </div>
                                    @foreach ($profile as $data)
                                        <hr>
                                        <div style="font-size: 12px">
                                            <div class="d-flex">
                                                <label for="nis" class="form-label form-label-sm col-4">NIS</label>
                                                <div id="nis" name="nis" >: {{$data->nis}} </div>
                                            </div>
                                            <div class="d-flex">
                                                <label for="nama_lengkap" class="form-label col-4">Nama</label>
                                                <div id="nama_lengkap" name="nama_lengkap" >: {{$data->nama_lengkap}} </div>
                                            </div>
                                            <div class="d-flex">
                                                <label for="tahun_masuk" class="form-label col-4">Tahun Masuk</label>
                                                <div id="tahun_masuk" name="tahun_masuk" >: {{$data->tahun_masuk}} </div>
                                            </div>
                                            <div class="d-flex">
                                                <label for="kelas" class="form-label col-4">Kelas</label>
                                                <div id="kelas" name="kelas" >: {{$data->nama_kelas}} </div>
                                            </div>
                                            <div class="d-flex">
                                                <label for="jenjang" class="form-label col-4">Jenjang</label>
                                                <div id="jenjang" name="jenjang" >: {{$data->nama_jenjang}} </div>
                                            </div>
                                            <div class="d-flex">
                                                <label for="no_hp_ibu" class="form-label col-4">No Hp Ibu</label>
                                                <div id="no_hp_ibu" name="no_hp_ibu" >: {{$data->no_hp_ibu}} </div>
                                            </div>
                                            <div class="d-flex">
                                                <label for="no_hp_ayah" class="form-label col-4">No Hp Ayah</label>
                                                <div id="no_hp_ayah" name="no_hp_ayah" >: {{$data->no_hp_ayah}} </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else 
                        <div class="accordion-item">
                            <a href="{{$item->url}}" style="text-decoration: none">
                                <span class="accordion-header" id="flush-{{$item->id}}">
                                    <button class="accordion-button collapsed" style="font-size: 12px;" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{$item->id}}" aria-expanded="true" aria-controls="flush-collapse{{$item->id}}">
                                        <i class="{{$item->icon}}" style="color: {{$item->style}}"> </i> &nbsp; {{$item->name}}
                                    </button>
                                </span>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="row mt-3">
            <div class="center">
                <a href="#" class="btn btn-secondary btn-sm mx-2 px-3" data-bs-toggle="modal" data-bs-target="#buy_now" > Keluar </a>
            </div>
        </div>
    </div>

    <div class="modal fade" id="buy_now" tabindex="-1" role="dialog" aria-labelledby="beli_sekarang" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content center ">
                <div class="modal-body">
                    <h6> Apakah Anda Yakin akan Keluar ?</h6>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-primary btn-sm mx-3 px-3" id="btn-close" data-bs-dismiss="modal" >Tidak</button>
                        <form role="form" method="POST" action="{{ route('logout') }}" id="logout-form">
                            @csrf
                            <div class="btn btn-secondary btn-sm px-3" style="border-radius: 1rem"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <span>Keluar</span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('ortu.footer.index')
    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

@endsection