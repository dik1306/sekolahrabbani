@extends('layouts.app')

@section('content')
    <div class="">
        <img class="banner-2" src="{{ asset('assets/images/home_rabbani_school-2.png') }}" alt="banner">
        <div class="centered text-white">
            <h2 class="mt-5"> Sekolah Rabbani </h2>
        </div>
    </div>
    {{-- <div>
        <img src="{{ asset('assets/images/awan1.png') }}" class="cloud-hms"  alt="cloud">
        <img src="{{ asset('assets/images/awan2.png') }}" class="cloud-hms2"  alt="cloud">
    </div> --}}
    <div class="container" style="position: relative; z-index:1000">
        <div class="d-flex row center">
            <h5 class="mt-4"> {{$jenjang_detail[0]->nama_jenjang}} </h5>
            @foreach ($jenjang_detail as $item)
            <div class="col-md-4 mb-3">
                <img src="{{ asset($item->image) }}" alt="sr_{{$item->lokasi}}" width="100%">
                <span> {{$item->alamat}} </span>
            </div>
            @endforeach
        </div>
    </div>
                
@endsection