@extends('admin.layouts.app')

@section('content')
    <div class="iq-navbar-header">
        <div style="position: absolute; z-index:-1; top:0; height: 263px">
            <img src="{{asset('assets/images/top-header.png')}} " alt="header" class="theme-color-default-img img-fluid w-100 h-100">
        </div>
        <div class="title my-3">
            <h1 class="text-white" style="margin-left: 1rem">List Order Merchandise </h1>
        </div>
    </div>
    <div class="container iq-container px-3">
        <div class="card">
            <div class="card-body">
                <form action="{{route('list-order-merchandise')}}" method="GET" role="form" id="filter_tanggal" >  
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
                        <a href="{{route('list-order-merchandise')}}" class="btn btn-dim btn-outline-danger btn-sm mx-1">Reset</a>   
                    </div>
                </form> 
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="d-flex" style="justify-content: flex-end">
                    <form action="{{route('list-order.export')}}" method="GET" >
                        <input type="hidden" name="date_start_ex" value="{{$date_start}}" class="form-control">
                        <input type="hidden" name="date_end_ex" value="{{$date_end}}" class="form-control">
                        <button type="submit" class="btn btn-success btn-sm" > Export Excel </button> 
                    </form>
                </div>
                <div class="table-responsive mt-3">
                    <table id="list_order" class="table table-striped" data-toggle="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Invoice</th>
                                <th>Nama Pemesan</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Metode Bayar</th>
                                <th>Waktu Pesanan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list_order as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$item->no_pesanan}}</td>
                                    <td>{{$item->nama_pemesan}}</td>
                                    <td>Rp. {{number_format($item->total_harga)}}</td>
                                    @if ($item->status == 'success') 
                                        <td> <span class="badge rounded-pill bg-success" >Paid </span></td>
                                    @else
                                        <td> <span class="badge rounded-pill bg-danger"> Unpaid </span> </td>
                                    @endif
                                    <td>{{$item->metode_pembayaran}}</td>
                                    <td>{{date_format($item->updated_at, 'Y-m-d H:i:s')}}</td>
                                    <td class="d-flex">
                                        <button class="btn btn-sm btn-warning" title="Detail" onclick="detail('{{$item->no_pesanan}}')">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <a href="{{route('download.invoice-merchandise', $item->no_pesanan)}}" class="btn btn-sm btn-info mx-1" title="Print" >
                                            <i class="fa-solid fa-print"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="show_detail" tabindex="-1" role="dialog" aria-labelledby="desain" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail <span id="detail_no_pesanan" style="color: blueviolet"> </span></h5>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" >
                            <thead>
                                <tr>
                                    <th> No </th>
                                    <th> Nama Siswa </th>
                                    <th> Lokasi </th>
                                    <th> Kelas </th>
                                    <th> Merchandise </th>
                                    <th> Design </th>
                                    <th> Quantity </th>
                                    <th> Aksi </th>
                                </tr>
                            </thead>
                            <tbody id="detail_order">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
    <script> 
        function detail(no_pesanan) {
            var id = no_pesanan;
            // console.log(no_pesanan);
            $('#detail_no_pesanan').html(id)

            var url = "{{ route('get_pesanan_merchandise_by_invoice', ":id") }}";
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: 'GET',
                success: function (result) {
                   $('#show_detail').modal('show')
                   $('#detail_order').html('');

                   $.each(result, function(key, item) {
                        // var url = 'http://sekolahrabbani.test/'
                        var url = 'https://sekolahrabbani.sch.id/'

                        var url_link = url + 'master/desain/download/' + item.design_id;
                        var url_image = url + 'storage/' + item.image_file;

                        var kategori = item.kategori != null ? item.kategori : ''
                        var warna = item.warna != null ? item.warna : ''
                        var template = item.template != null ? item.template : ''
                        var ukuran_seragam = item.ukuran_id != null ? item.ukuran_id : ''
                        var design_id = item.design_id;

                        var download =''
                        if (design_id != null) {
                            download = `<a href="${url_link}" class="btn btn-sm btn-success mx-2" title="Download">
                                            <i class="fa-solid fa-download"></i>
                                        </a>`
                        } else {
                            download = `<a href="#" class="btn btn-sm btn-success mx-2" title="Download" disabled>
                                            <i class="fa-solid fa-download"></i>
                                        </a>`
                        }
                        
                        $('#detail_order').append(
                            `<tr>
                                <td>${key+1}</td>
                                <td>${item.siswa}</td>
                                <td>${item.sekolah_id}</td>
                                <td>${item.kelas}</td>
                                <td>${item.nama_produk} ${warna} ${template}, ${kategori} ${ukuran_seragam}  </td>
                                <td><img src="${url_image}"  id="img_cover_${item.design_id}" width="20px"></td>
                                <td>${item.quantity}</td>
                                <td>${download}</td>
                            </tr>
                            `
                    )
                   })
                }
            });
        }
    </script>
@endsection

