@extends('admin.layouts.app')

@section('content')
    <div class="iq-navbar-header">
        <div style="position: absolute; z-index:-1; top:0; height: 263px">
            <img src="{{asset('assets/images/top-header.png')}} " alt="header" class="theme-color-default-img img-fluid w-100 h-100">
        </div>
        <div class="title mt-3">
            <h1 class="text-white" style="margin-left: 1rem">Dashboard </h1>
        </div>
    </div>
    <div class="container iq-container px-3">
        <div class="row mt-3">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">Total Tagihan</h5>
                            <span class="badge bg-primary">Monthly</span>
                        </div>
                        <br>
                        <?php $sum_tot_tagihan = 0 ?>
                        @foreach ($tot_tagihan as $item)
                            <div class="d-flex" style="justify-content: space-between">
                                <p style="font-size: 14px"> {{$item->nama_lengkap}} </p>
                                <h6 style="text-align: right"> Rp. {{($tot_tagihan->count() > 0) ? number_format($item->total_tagihan) : '-'}} </h6>
                            </div>
                            <?php $sum_tot_tagihan += $item->total_tagihan ?>
                        @endforeach
                        <hr>
                        <div class="d-flex mb-3" style="justify-content: space-between">
                            <h6> Total </h6>
                            <h6 style="text-align: right"> Rp. {{number_format($sum_tot_tagihan)}} </h6>
                        </div>
                        <button type="button" class="btn btn-info btn-sm" style="border-radius: 1rem" data-bs-toggle="modal" data-bs-target="#detail_tagihan">Detail</button>
                    </div>
                </div>
            </div>       
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">Total Tunggakan</h5>
                            <span class="badge bg-danger">Until This Month</span>
                        </div>
                        <br>
                        <?php $sum_tot_tunggakan = 0 ?>
                        @foreach ($tot_tunggakan as $item)
                            <div class="d-flex" style="justify-content: space-between">
                                <p style="font-size: 14px"> {{$item->nama_lengkap}} </p>
                                <h6 style="text-align: right"> Rp. {{($tot_tunggakan->count() > 0) ? number_format($item->total_tunggakan) : '-'}} </h6>
                            </div>
                            <?php $sum_tot_tunggakan += $item->total_tunggakan ?>
                        @endforeach
                        <hr>
                        <div class="d-flex mb-3" style="justify-content: space-between">
                            <h6> Total </h6>
                            <h6 style="text-align: right"> Rp. {{number_format($sum_tot_tunggakan)}} </h6>
                        </div>
                        <button type="button" class="btn btn-info btn-sm" style="border-radius: 1rem" data-bs-toggle="modal" data-bs-target="#detail_tunggakan">Detail</button>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">History Pembayaran</h5>
                            <span class="badge bg-success">Monthly</span>
                        </div>
                        <br>
                        <?php $sum_tot_lunas = 0 ?>
                        @foreach ($lunas_spp as $item)
                            <div class="d-flex" style="justify-content: space-between">
                                <p style="font-size: 14px"> {{$item->nama_lengkap}} </p>
                                <h6 style="text-align: right"> Rp. {{($lunas_spp->count() > 0) ? number_format($item->lunas_spp) : '-'}} </h6>
                            </div>
                            <?php $sum_tot_lunas += $item->lunas_spp ?>
                        @endforeach
                        <hr>
                        <div class="d-flex mb-3" style="justify-content: space-between">
                            <h6> Total </h6>
                            <h6 style="text-align: right"> Rp. {{number_format($sum_tot_lunas)}} </h6>
                        </div>
                        <button type="button" class="btn btn-info btn-sm" style="border-radius: 1rem" data-bs-toggle="modal" data-bs-target="#detail_penerimaan">Detail</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detail_tagihan" tabindex="-1" role="dialog" aria-labelledby="biaya_tagihan" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="biaya_tagihan">Detail Tagihan</h5>
                </div>
                <div class="modal-body">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            @foreach ($get_nis as $key => $item)
                                <button class="nav-link {{$key == 0 ? 'active' : ''}}" id="nav-{{$item->nis}}-tab" data-bs-toggle="tab" data-bs-target="#nav-{{$item->nis}}" type="button" role="tab" aria-controls="nav-{{$item->nis}}" aria-selected="true">{{$item->nis}} </button>
                            @endforeach
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        @foreach ($get_nis as $key => $nis)
                        <div class="tab-pane fade {{$key == 0 ? 'show active' : ''}} " id="nav-{{$nis->nis}}" role="tabpanel" aria-labelledby="nav-{{$nis->nis}}-tab" tabindex="0">
                            <div class="table-responsive">
                                <table class="table  table-striped dt-responsive">
                                    <thead>
                                        <tr>
                                            <th>No Tagihan</th>
                                            <th>Bulan</th>
                                            <th>Jenis</th>
                                            <th>Nilai Tagihan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tagihan as $item)
                                        @if ($nis->nis == $item ->nis)
                                            <tr>
                                                <td>{{$item->no_tagihan}}</td>
                                                <td>{{$item->bulan_pendapatan}} </td>
                                                <td>{{$item->jenis_penerimaan}}</td>
                                                <td>{{number_format($item->nilai_tagihan)}}</td>
                                            </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="detail_tunggakan" tabindex="-1" role="dialog" aria-labelledby="biaya_tunggakan" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="biaya_tunggakan">Detail Biaya Tunggakan</h5>
                </div>
                <div class="modal-body">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            @foreach ($get_nis as $key => $item)
                                <button class="nav-link {{$key == 0 ? 'active' : ''}}" id="nav-tunggakan{{$item->nis}}-tab" data-bs-toggle="tab" data-bs-target="#nav-tunggakan{{$item->nis}}" type="button" role="tab" aria-controls="nav-tunggakan{{$item->nis}}" aria-selected="true">{{$item->nis}} </button>
                            @endforeach
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        @foreach ($get_nis as $key => $nis)
                        <div class="tab-pane fade {{$key == 0 ? 'show active' : ''}} " id="nav-tunggakan{{$nis->nis}}" role="tabpanel" aria-labelledby="nav-tunggakan{{$nis->nis}}-tab" tabindex="0">
                            <div class="table-responsive">
                                <table class="table  table-striped dt-responsive">
                                    <thead>
                                        <tr>
                                            <th>No Tagihan</th>
                                            <th>Bulan</th>
                                            <th>Status</th>
                                            <th>Jenis</th>
                                            <th>Nilai Tagihan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tunggakan as $item)
                                            @if ($nis->nis == $item->nis)
                                                <tr>
                                                    <td>{{$item->no_tagihan}}</td>
                                                    <td>{{$item->bulan_pendapatan}} </td>
                                                    @if($item->status = 1)
                                                    <td class="text-white badge bg-danger"> Belum Lunas</td>
                                                    @else
                                                    <td class="badge bg-success"> Lunas</td>
                                                    @endif
                                                    <td>{{$item->jenis_penerimaan}}</td>
                                                    <td>{{number_format($item->nilai_tagihan)}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    {{-- <div class="table-responsive">
                        <table class="table  table-striped dt-responsive">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Tagihan</th>
                                    <th>NIS</th>
                                    <th>Bulan</th>
                                    <th>Status</th>
                                    <th>Jenis</th>
                                    <th>Nilai Tagihan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tunggakan as $item)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item->no_tagihan}}</td>
                                        <td>{{$item->nis}}</td>
                                        <td>{{$item->bulan_pendapatan}} </td>
                                        @if($item->status = 1)
                                        <td class="text-white badge bg-danger"> Belum Lunas</td>
                                        @else
                                        <td class="badge bg-success"> Lunas</td>
                                        @endif
                                        <td>{{$item->jenis_penerimaan}}</td>
                                        <td>{{number_format($item->nilai_tagihan)}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detail_penerimaan" tabindex="-1" role="dialog" aria-labelledby="history_bayar" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="history_bayar">History Pembayaran</h5>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table  table-striped dt-responsive">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Transaksi</th>
                                    <th>NIS</th>
                                    <th>Periode</th>
                                    <th>Jenis</th>
                                    <th>Status</th>
                                    <th>Nilai Bayar</th>
                                    <th>Tanggal Bayar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($penerimaan as $item)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item->no_penerimaan}}</td>
                                        <td>{{$item->nis}} </td>
                                        <td>{{$item->bulan_pendapatan}} </td>
                                        <td>{{$item->jenis_penerimaan}}</td>
                                        @if($item->status = 1 )
                                        <td class="text-white badge bg-success"> Lunas </td>
                                        @else
                                        <td class="badge bg-danger">Belum Lunas </td>
                                        @endif
                                        <td>{{number_format($item->nilai_bayar)}}</td>
                                        <td>{{$item->tanggal_bayar}}</td>
                                        <td class="d-flex">
                                            <a href="{{route('bukti_bayar', $item->no_penerimaan)}}" target="_blank" class="btn btn-sm btn-warning" title="lihat"><i class="fa-solid fa-eye"></i></a>
                                            <a href="#" class="btn btn-sm btn-success mx-1" title="download"><i class="fa-solid fa-download"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
