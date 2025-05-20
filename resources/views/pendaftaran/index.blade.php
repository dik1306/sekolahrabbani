@extends('layouts.app')

@section('content')
    <div class="">
        <div class="container">
            <div class="center my-3">
               <h1 style="color: #704996">Informasi Pendaftaran Sekolah Rabbani</h1>
            </div>
            <div class="row mt-5">
                <div class="col-md-6">
                    <img src="{{ asset('assets/images/Siswa.png') }}" alt="siswa" class="img-fluid center" width="480">
                </div>
                <div class="col-md-6">
                    <div class="title center my-5">
                        <h2 >Bergabunglah Bersama Kami</h2>
                        <p >"Membentuk Sumber Daya Manusia yang <i>RABBANI</i> untuk Menjadi Peserta Didik Berjiwa
                            <b>Qur'anic Leaderpreneur (QLP)</b>"
                        </p>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="#" class="btn btn-primary px-3" data-bs-toggle="modal" data-bs-target="#daftar_modal">Daftar Sekolah</a>
                        <a href="#" id="cp" class="btn btn-blue mx-2 px-3" data-bs-toggle="modal" data-bs-target="#cp_modal">Contact Person</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>

        function belum() {
            // alert('nect')
            $('#alert_cp').show();
            $('#btn-belum').hide();
            $('#btn-close').show();
        }
    </script>
    
    <div class="modal fade" id="cp_modal" tabindex="-1" role="dialog" aria-labelledby="label_surat_perjanjian" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="label_surat_perjanjian">Contact Person Sekolah Rabbani</h5>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table  table-striped dt-responsive">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>No Telp</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contact_person as $item)
                                <?php $message = 'Assalamualaikum, saya mau daftar sekolah rabbani, boleh minta informasi/surat pernyataan?' ?>
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item->nama}} </td>
                                        <td>
                                            <a target="_blank" href="https://wa.me/{{$item->telp}}?text={{$message}}">
                                            {{$item->telp}} </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="daftar_modal" tabindex="-1" role="dialog" aria-labelledby="label_pendaftaran" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    <h5 class="modal-title" id="label_pendaftaran">Apakah anda sudah mengetahui dan menyetujui Surat Pernyataan Pendaftaran ?</h5>
                    <span class="text-danger" style="font-size: 12px; display: none;" id="alert_cp">
                        Silahkan Hubungi Contact Person Sekolah <a href="#" id="klik_disini" data-bs-toggle="modal" data-bs-target="#cp_modal">Disini</a>
                    </span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" id="btn-belum" onclick="belum()">Belum</button>
                    {{-- <a href="#" id="belum"  class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#cp_modal">Belum</a> --}}
                    <button type="button" class="btn btn-secondary btn-sm" id="btn-close" style="display: none" data-bs-dismiss="modal" >Close</button>
                    <a href="{{route('form.pendaftaran')}}" class="btn btn-success btn-sm" >Ya, Sudah</a>
                </div>
            </div>
        </div>
    </div>
@endsection
