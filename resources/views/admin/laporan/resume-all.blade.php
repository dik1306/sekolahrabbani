@extends('admin.layouts.app')

@section('content')
    <div class="iq-navbar-header">
        <div style="position: absolute; z-index:-1; top:0; height: 263px">
            <img src="{{asset('assets/images/top-header.png')}} " alt="header" class="theme-color-default-img img-fluid w-100 h-100">
        </div>
        <div class="title my-3">
            <h3 class="text-white" style="margin-left: 1rem">Resume Order Merchandise </h3>
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
                                <h4 >Rp. {{number_format($order_success->grand_total)}}</h4>
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
                                <h4 >Rp. {{ number_format($hpp->total_hpp)}}</h4>
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
                                <h4 >Rp. {{number_format($profit)}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-auto">
                <div class="card" style="width: 15rem">
                    <div class="card-body">
                        <div class="d-flex" style="align-items: center">
                            <i class="fa-solid fa-shirt fa-xl" style="color: #5653ed"></i>
                            <div class="progress-detail mx-3">
                                <p  class="mb-2">Total Produk</p>
                                <h4 >{{$total_item->total_item}}</h4>
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
                        <h6> Sales Item By Produk, Kategori & Warna </h6>
                        <div class="table-responsive mt-3">
                            <table id="list_order" class="table table-striped" style="font-size: 14px;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Quantity</th>
                                        <th>Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total_harga = 0; ?>
                                    @foreach ($total_item_by_merch_and_kategori as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->nama_produk}} {{$item->kategori}} {{$item->warna}}</td>
                                            <td>{{$item->total_item}}</td>
                                            <td style="text-align: right">Rp. {{number_format($item->harga * $item->total_item)}}</td>
                                        </tr>
                                        <?php $total_harga += $item->harga * $item->total_item ?>
                                    @endforeach
                                        <tr>
                                            <td class="text-center" colspan="3"> <b> Total </b></td>
                                            <td > <i> Rp. {{number_format($total_harga)}} </i></td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <h6> Sales by School </h6>
                        <div class="table-responsive mt-3">
                            <table id="list_order" class="table table-striped" style="font-size: 12px;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Sekolah</th>
                                        <th>Total Item</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sales_by_school as $item)
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

                    <div class="col-lg-3">
                        <h6> Sales by Product </h6>
                        <div class="table-responsive mt-3">
                            <table id="list_order" class="table table-striped" style="font-size: 12px">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Total Item</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total_item = 0; ?>
                                    @foreach ($sales_by_produk as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->nama_produk}}</td>
                                            <td>{{$item->total_item}}</td>
                                        </tr>
                                        <?php $total_item += $item->total_item ?>
                                    @endforeach
                                        <tr>
                                            <td class="text-center" colspan="2"> <b> Total </b></td>
                                            <td > <i>{{$total_item}} </i></td>
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

