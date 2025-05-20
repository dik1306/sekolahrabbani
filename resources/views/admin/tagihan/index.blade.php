@extends('admin.layouts.app')

@section('content')
    <div class="iq-navbar-header">
        <div style="position: absolute; z-index:-1; top:0; height: 263px">
            <img src="{{asset('assets/images/top-header.png')}} " alt="header" class="theme-color-default-img img-fluid w-100 h-100">
        </div>
        <div class="title my-3">
            <h1 class="text-white" style="margin-left: 1rem">Tagihan </h1>
        </div>
    </div>
    <div class="container iq-container px-3">
        <div class="card">
            <div class="card-body">
                <form action="{{route('tagihan.index')}}" method="GET" enctype="multipart/form-data" role="form" id="filter_periode" >                                                    
                    <div class="form-group mt-3">
                        <div class="d-flex" style="justify-content: space-between">
                            <select name="bulan_periode" id="bulan_periode" class="form-control form-control-sm" aria-label=".form-select-sm" >
                                <option value="" disabled selected> Bulan</option>
                                    @foreach ($getMonth as $i => $item)
                                        <option value="{{ $i+1 }}" {{($i+1 == $bulan_periode) ? 'selected' : ''}}>{{ $item }}</option>
                                    @endforeach
                            </select>
                            <select name="tahun_periode" id="tahun_periode" class="form-control form-control-sm mx-1">
                                <option value="" disabled selected> Tahun</option>
                                    @for ($i = 2021; $i <= date('Y'); $i++)
                                        <option value="{{ $i }}" {{($i == $tahun_periode) ? 'selected' : ''}} >{{ $i }}</option>
                                    @endfor
                            </select>
                            <select name="jenis_penerimaan" id="jenis_penerimaan" class="form-control form-control-sm" aria-label=".form-select-sm" >
                                <option value="" disabled selected> Jenis </option>
                                    @foreach ($jenis_penerimaan as $item)
                                        <option value="{{ $item->kode }}" {{($item->kode == $jenis) ? 'selected' : ''}}>{{ $item->grup }}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-success btn-sm">Tampilkan</button>
                            <a href="{{route('tagihan.index')}}" class="btn btn-dim btn-outline-danger btn-sm mx-1">Reset</a>   
                        </div>                       
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-tunggakan-tab" data-bs-toggle="tab" data-bs-target="#nav-tunggakan" type="button" role="tab" aria-controls="nav-tunggakan" aria-selected="true">Tunggakan</button>
                        <button class="nav-link" id="nav-lunas-tab" data-bs-toggle="tab" data-bs-target="#nav-lunas" type="button" role="tab" aria-controls="nav-lunas" aria-selected="false">Lunas</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-tunggakan" role="tabpanel" aria-labelledby="nav-tunggakan-tab" tabindex="0">
                        <div class="table-responsive mt-3">
                            <table id="data_tunggakan" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Tagihan</th>
                                        <th>NIS</th>
                                        <th>Periode</th>
                                        <th>Jenis</th>
                                        <th>Nilai Bayar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tagihan as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->no_tagihan}}</td>
                                            <td>{{$item->nis}}</td>
                                            <td>{{$item->bulan_pendapatan}} </td>
                                            <td>{{$item->jenis_penerimaan}}</td>
                                            <td>{{number_format($item->nilai_tagihan)}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-lunas" role="tabpanel" aria-labelledby="nav-lunas-tab" tabindex="0">
                        <div class="table-responsive mt-3">
                            <table id="data_lunas" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Tagihan</th>
                                        <th>NIS</th>
                                        <th>Periode</th>
                                        <th>Jenis</th>
                                        <th>Nilai Bayar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lunas as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->no_tagihan}}</td>
                                            <td>{{$item->nis}}</td>
                                            <td>{{$item->bulan_pendapatan}} </td>
                                            <td>{{$item->jenis_penerimaan}}</td>
                                            <td>{{number_format($item->nilai_tagihan)}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection