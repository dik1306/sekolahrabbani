@extends('layouts.app')

@section('content')
    <div class="karir">
        <div class="container">
            <div class="center my-3">
               <h1 style="color: #704996">Kejar Potensi Bersama Rabbani</h1>
            </div>
            <div class="row mt-5">
                <div class="col-md-6">
                    <img src="{{ asset('assets/images/img-kegiatan-1.png') }}" alt="karir" class="img-fluid center" width="450">
                </div>
                <div class="col-md-6">
                    <div class="title center my-5">
                        <h2 >Bergabunglah Bersama Kami</h2>
                        <p >"Membentuk Sumber Daya Manusia yang <i>RABBANI</i> untuk Mencetak Peserta Didik Berjiwa
                            <b>Qur'anic Leaderpreneur (QLP)</b>"
                        </p>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="https://bit.ly/DaftarYRA" target="_blank" class="btn btn-primary mx-3">Apply Now</a>
                        <a href="{{route('karir.login')}}" class="btn btn-primary">Login CSDM</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection