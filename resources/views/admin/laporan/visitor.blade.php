@extends('admin.layouts.app')

@section('content')
    <div class="iq-navbar-header">
        <div style="position: absolute; z-index:-1; top:0; height: 263px">
            <img src="{{asset('assets/images/top-header.png')}} " alt="header" class="theme-color-default-img img-fluid w-100 h-100">
        </div>
        <div class="title my-3">
            <h3 class="text-white" style="margin-left: 1rem">Laporan Visitors </h3>
        </div>
    </div>
    <div class="container iq-container px-3">
        <div class="row">
            <div class="col-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex" style="align-items: center">
                            <i class="fa-solid fa-school fa-lg" style="color: #474E93"></i>
                            <div class="progress-detail mx-3">
                                <p  class="mb-2" style="font-size: 14px">Total Kunjungan Web Sekolah</p>
                                <h4 class="counter">{{number_format($count_visitor)}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex" style="align-items: center">
                            <i class="fa-solid fa-newspaper fa-lg" style="color: #EB5B00"></i>
                            <div class="progress-detail mx-3">
                                <p  class="mb-2" style="font-size: 14px">Total Kunjungan Web PPDB</p>
                                <h4 class="counter">{{number_format($count_visitor_ppdb)}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-5">
                        <h6> Visitors Web Sekolah by Location </h6>
                        <div class="table-responsive mt-3">
                            <table id="list_visitor" class="table table-striped" style="font-size: 12px">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Lokasi</th>
                                        <th>Total Kunjungan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total_kunjungan = 0; ?>
                                    @foreach ($visitor_by_location as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->location}}</td>
                                            <td>{{$item->total}}</td>
                                        </tr>
                                        <?php $total_kunjungan += $item->total ?>
                                    @endforeach
                                        <tr>
                                            <td class="text-center" colspan="2"> <b> Total </b></td>
                                            <td > <i>{{number_format($total_kunjungan)}} </i></td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <h6> Visitors Web PPDB by Location </h6>
                        <div class="table-responsive mt-3">
                            <table id="list_visitor" class="table table-striped" style="font-size: 12px">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Lokasi</th>
                                        <th>Total Kunjungan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total_kunjungan = 0; ?>
                                    @foreach ($visitor_ppdb_by_location as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->location}}</td>
                                            <td>{{$item->total}}</td>
                                        </tr>
                                        <?php $total_kunjungan += $item->total ?>
                                    @endforeach
                                        <tr>
                                            <td class="text-center" colspan="2"> <b> Total </b></td>
                                            <td > <i> {{number_format($total_kunjungan)}} </i></td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection

