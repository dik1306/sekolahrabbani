@extends('admin.layouts.app')

@section('content')
    <div class="iq-navbar-header">
        <div style="position: absolute; z-index:-1; top:0; height: 263px">
            <img src="{{asset('assets/images/top-header.png')}} " alt="header" class="theme-color-default-img img-fluid w-100 h-100">
        </div>
        <div class="title my-3">
            <h1 class="text-white" style="margin-left: 1rem">List Order Jersey </h1>
        </div>
    </div>
    <div class="container iq-container px-3">
        <div class="card">
            <div class="card-body">
                <form action="{{route('list_order_jersey')}}" method="GET" role="form" id="filter_tanggal" >  
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
                        <a href="{{route('list_order_jersey')}}" class="btn btn-dim btn-outline-danger btn-sm mx-1">Reset</a>   
                    </div>
                </form> 
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="d-flex" style="justify-content: flex-end">
                    <form action="{{route('order-jersey.export')}}" method="GET" >
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
                                <th>Kategori</th>
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
                                    @endif
                                    <td>{{$item->metode_pembayaran}}</td>
                                    <td>{{date_format($item->updated_at, 'Y-m-d H:i:s')}}</td>
                                    <td>{{$item->role_name}}</td>
                                    <td class="d-flex">
                                        <button class="btn btn-sm btn-success" title="Detail" onclick="detail('{{$item->no_pesanan}}')">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                       
                                        <a href="{{route('download.invoice-jersey', $item->no_pesanan)}}" class="btn btn-sm btn-info mx-1" title="Print" >
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
                                    <th> Jersey </th>
                                    <th> Nama Punggung </th>
                                    <th> No Punggung </th>
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
            $('#detail_no_pesanan').html(id)

            var url = "{{ route('order_jersey_detail', ":id") }}";
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: 'GET',
                success: function (result) {
                   $('#show_detail').modal('show')
                   $('#detail_order').html('');

                   $.each(result, function(key, item) {
                        var kategori = item.kategori != null ? item.kategori : ''
                        var warna = item.warna != null ? item.warna : ''
                        var template = item.template != null ? item.template : ''
                        var ukuran_seragam = item.ukuran_id != null ? item.ukuran_id : ''
                        var design_id = item.design_id;
                        
                        $('#detail_order').append(
                            `<tr>
                                <td>${key+1}</td>
                                <td>${item.nama_siswa}</td>
                                <td>${item.lokasi_sekolah}</td>
                                <td>${item.nama_kelas}</td>
                                <td>${item.nama_jersey}, ${ukuran_seragam}  </td>
                                <td>${item.nama_punggung}</td>
                                <td>${item.no_punggung}</td>
                                <td>${item.quantity}</td>
                                <td> 
                                    <button class="btn btn-sm btn-warning mx-1" title="Edit" onclick="edit_jersey('${item.no_pesanan}', '${item.jersey_id}', '${item.no_punggung}')" data-bs-toggle="modal" data-bs-target="#edit_jersey">
                                            <i class="fa-solid fa-pencil"></i>
                                    </button>
                                </td>
                            </tr>
                            `
                    )
                   })
                }
            });
        }

        function edit_jersey(id, jersey_id, no_punggung) {
            fetch('/laporan/jersey/edit/' + id +'/' +jersey_id + '/' +no_punggung)
                .then(response => response.json())
                .then(data => {
                    $("#jersey_id").val(data.jersey_id)
                    $("#ukuran").val(data.ukuran_id)
                    $("#nama_punggung").val(data.nama_punggung)
                    $("#no_punggung").val(data.no_punggung)
                    $("#no_pesanan").val(id)
                    $("#old_jersey_id").val(jersey_id)
                    $("#old_no_punggung").val(no_punggung)
                })
        }

        function update_jersey() {
            var id = $('#no_pesanan').val();
            var jersey_id = $('#jersey_id').val();
            var ukuran = $('#ukuran').val();
            var nama_punggung = $('#nama_punggung').val();
            var no_punggung = $('#no_punggung').val();
            var old_jersey_id = $('#old_jersey_id').val();
            var old_no_punggung = $('#old_no_punggung').val();

            var url = "{{ route('update-jersey', ":id") }}";
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: 'PUT',
                data: {
                    id: id,
                    jersey_id: jersey_id,
                    old_jersey_id: old_jersey_id,
                    ukuran: ukuran,
                    nama_punggung: nama_punggung,
                    no_punggung: no_punggung,
                    old_no_punggung: old_no_punggung,
                    _token: '{{csrf_token()}}'
                },
                success: function (result) {
                    window.location.reload()
                }
            })
        }
    </script>

    <div class="modal fade" id="edit_jersey" tabindex="-1" role="dialog" aria-labelledby="label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="label">Edit Jersey</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="jersey_id" class="form-control-label">Nama Jersey</label>
                        <select name="jersey_id" id="jersey_id" class="select form-control form-control-sm" aria-label=".form-select-sm" onchange="get_kelas()" >
                            <option value="" disabled selected>-- Pilih Jersey -- </option>
                                @foreach ($list_jersey as $item)
                                    <option value="{{ $item->id }}" >{{ $item->nama_jersey }}</option>
                                @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="ukuran" class="form-control-label">Ukuran</label>
                        <select name="ukuran" id="ukuran" class="select form-control form-control-sm" aria-label=".form-select-sm" onchange="get_kelas()" >
                            <option value="" disabled selected>-- Pilih Ukuran -- </option>
                                @foreach ($list_ukuran as $item)
                                    <option value="{{ $item->ukuran_seragam }}" >{{ $item->ukuran_seragam }}</option>
                                @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nama_punggung" class="form-control-label">Nama Punggung</label>
                        <input type="text" class="form-control" name="nama_punggung" id="nama_punggung">
                    </div>

                    <div class="form-group">
                        <label for="no_punggung" class="form-control-label">No Punggung</label>
                        <input type="text" class="form-control" name="no_punggung" id="no_punggung">
                        <input type="hidden" class="form-control" name="no_pesanan" id="no_pesanan">
                        <input type="hidden" class="form-control" name="old_jersey_id" id="old_jersey_id">
                        <input type="hidden" class="form-control" name="old_no_punggung" id="old_no_punggung">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <input type="hidden" id="id_harga_seragam">
                    <button type="button" class="btn btn-success btn-sm" onclick="update_jersey()" >Update</button>
                </div>
            </div>
        </div>
    </div>
@endsection

