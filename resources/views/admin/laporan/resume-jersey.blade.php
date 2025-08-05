@extends('admin.layouts.app')

@section('content')
    <div class="iq-navbar-header">
        <div style="position: absolute; z-index:-1; top:0; height: 263px">
            <img src="{{asset('assets/images/top-header.png')}} " alt="header" class="theme-color-default-img img-fluid w-100 h-100">
        </div>
        <div class="title my-3">
            <h3 class="text-white" style="margin-left: 1rem">Resume Order Jersey </h3>
        </div>
    </div>
    <div class="container iq-container px-3">
        <div class="card">
            <div class="card-body">
                <form action="{{route('resume_jersey')}}" method="GET" role="form" id="filter_tanggal" >  
                    <div class="row g-3 align-items-center">

                        <div class="col-auto">
                            <label for="sekolah" class="col-auto form-control-label">Sekolah</label>
                        </div>

                        <div class="col-auto">
                            <select name="sekolah" id="sekolah" class="col-auto select form-control form-control-sm" aria-label=".form-select-sm" >
                                <option value="" disabled selected> --Pilih Sekolah-- </option>
                                @foreach ($sekolah as $item)
                                    <option value="{{ $item->id_sekolah }}" {{($item->id_sekolah == $sekolah_id) ? 'selected' : ''}} >{{ $item->sublokasi }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-3">
                        </div>

                        <div class="col-auto">
                            <label class="col-form-label">Tanggal</label>
                        </div>

                        <div class="col-auto">
                            <input type="date" id="date_start" name="date_start" value="{{$date_start}}" class="form-control">
                        </div>

                        <div class="col-auto">
                            -
                        </div>

                        <div class="col-auto">
                            <input type="date" id="date_end" name="date_end" value="{{$date_end}}" class="form-control">
                        </div>
                    
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary btn-sm">Tampilkan</button>
                        <a href="{{route('resume_jersey')}}" class="btn btn-dim btn-outline-danger btn-sm mx-1">Reset</a>   
                    </div>
                </form> 
            </div>
        </div>
        
        <div class="row">
            <div class="col-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex" style="align-items: center">
                            <i class="fa-solid fa-credit-card fa-xl" style="color: #474E93"></i>
                            <div class="progress-detail mx-3">
                                <p  class="mb-2">Total Penjualan</p>
                                <h4 class="counter">Rp. {{number_format($order_success->grand_total)}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @if ($user_id != 1787)
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
        @endif

            <div class="col-auto">
                <div class="card" style="width: 15rem">
                    <div class="card-body">
                        <div class="d-flex" style="align-items: center">
                            <i class="fa-solid fa-shirt fa-xl" style="color: #5653ed"></i>
                            <div class="progress-detail mx-3">
                                <p  class="mb-2">Total Produk</p>
                                <h4 class="counter">{{$total_item->total_item}}</h4>
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
                        <h6> Sales Item By Produk </h6>
                        <div class="table-responsive mt-3">
                            <table id="list_order" class="table table-striped" style="font-size: 12px">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Ekskul</th>
                                        <th>Total Item</th>
                                        <th>Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total_harga = 0; ?>
                                    <?php $total_item = 0; ?>
                                    @foreach ($total_sales_by_produk as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->nama_jersey}}</td>
                                            <td>{{$item->total_quantity}}</td>
                                            <td>Rp. {{number_format($item->harga * $item->total_quantity)}}</td>
                                        </tr>
                                        <?php $total_harga += $item->harga * $item->total_quantity ?>
                                        <?php $total_item += $item->total_quantity ?>
                                    @endforeach
                                        <tr>
                                            <td class="text-center" colspan="2"> <b> Total </b></td>
                                            <td > <i> {{number_format($total_item)}} </i></td>
                                            <td > <i> Rp. {{number_format($total_harga)}} </i></td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <h6>Count Sales by School </h6>
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

                    <div class="col-lg-3">
                        <h6>Count Sales by Ekskul </h6>
                        <div class="table-responsive mt-3">
                            <table id="list_order" class="table table-striped" style="font-size: 12px;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Ekskul</th>
                                        <th>Total Item</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($total_sales_by_ekskul as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->ekskul}}</td>
                                            <td>{{$item->total_quantity}}</td>
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

