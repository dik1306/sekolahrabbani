@extends('admin.layouts.app')

@section('content')
    <div class="iq-navbar-header">
        <div style="position: absolute; z-index:-1; top:0; height: 263px">
            <img src="{{asset('assets/images/top-header.png')}} " alt="header" class="theme-color-default-img img-fluid w-100 h-100">
        </div>
        <div class="title my-3">
            <h3 class="text-white" style="margin-left: 1rem">Resume Seragam </h3>
        </div>
    </div>
    <div class="container iq-container px-3">
        <div class="row">
            <div class="col-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex" style="align-items: center">
                            <i class="fa-solid fa-credit-card fa-xl" style="color: #474E93"></i>
                            <div class="progress-detail mx-3">
                                <p  class="mb-2">Total Penjualan</p>
                                <h4 class="counter">Rp. {{number_format($total_pesanan->grand_total)}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex" style="align-items: center">
                            <i class="fa-solid fa-coins fa-xl" style="color: #FFB200"></i>
                            <div class="progress-detail mx-3">
                                <p  class="mb-2">Total Cost HPP</p>
                                <h4 class="counter">Rp. {{ number_format($hpp->total_hpp)}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex" style="align-items: center">
                            <i class="fa-solid fa-money-bill-trend-up fa-xl" style="color: #DA498D"></i>
                            <div class="progress-detail mx-3">
                                <p  class="mb-2">Total Profit</p>
                                <h4 class="counter">Rp. {{number_format($profit)}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex" style="align-items: center">
                            <i class="fa-solid fa-seedling fa-xl" style="color: green"></i>
                            <div class="progress-detail mx-3">
                                <p  class="mb-2">Penjualan Bulan Ini</p>
                                <h4 class="counter">Rp. {{number_format($sales_per_month->sales_month)}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <h5> Sales by Item </h5>
                        <div class="table-responsive mt-3">
                            <table id="list_order" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Total Item</th>
                                        <th>Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($total_sales_by_item as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->nama_produk}}</td>
                                            <td>{{$item->total_quantity}}</td>
                                            <td style="text-align: right">Rp. {{number_format(($item->harga * $item->total_quantity) - ($item->diskon * $item->total_quantity))}}</td>
                                        </tr>
                                        @endforeach
                                        <tr> 
                                            @if ($count_sales_by_item->count() > 5)
                                                <td class="text-center" colspan="4"> <a href="{{route('resume_seragam_detail')}}"> See All </a> </td>
                                            @endif
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <h5> Sales by School </h5>
                        <div class="table-responsive mt-3">
                            <table id="list_order" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Sekolah</th>
                                        <th>Total Item</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($total_sales_by_school as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->sublokasi}}</td>
                                            <td>{{$item->total_item}}</td>
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

