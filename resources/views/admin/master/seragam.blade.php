@extends('admin.layouts.app')

@section('content')
    <div class="iq-navbar-header">
        <div style="position: absolute; z-index:-1; top:0; height: 263px">
            <img src="{{asset('assets/images/top-header.png')}} " alt="header" class="theme-color-default-img img-fluid w-100 h-100">
        </div>
        <div class="title my-3">
            <h1 class="text-white" style="margin-left: 1rem">List Seragam </h1>
        </div>
    </div>
    <div class="container iq-container px-3">
        <div class="card">
            <div class="card-body">
                <form action="{{route('list-seragam')}}" method="GET" role="form" >                                                    
                    <div class="form-group mt-3">
                        <div class="d-flex" style="justify-content: space-between">
                            <select name="nama_produk" id="nama_produk" class="select2 form-control form-control-sm" aria-label=".form-select-sm" >
                                <option value="" disabled selected> Nama Produk </option>
                                    @foreach ($list_produk as $item)
                                        <option value="{{ $item->id }}" {{($item->id == $nama_produk) ? 'selected' : ''}} >{{ $item->nama_produk }}</option>
                                    @endforeach
                            </select>
                            <select name="ukuran" id="ukuran" class="form-control form-control-sm mx-1">
                                <option value="" disabled selected> Ukuran</option>
                                @foreach ($list_ukuran as $item)
                                    <option value="{{ $item->id }}" {{($item->id == $ukuran) ? 'selected' : ''}} >{{ $item->ukuran_seragam }}</option>
                                @endforeach
                            </select>
                            <select name="jenis_produk" id="jenis_produk" class="form-control form-control-sm" aria-label=".form-select-sm" >
                                <option value="" disabled selected> Jenis Produk </option>
                                    @foreach ($list_jenis as $item)
                                        <option value="{{ $item->id }}" {{($item->id == $jenis_produk) ? 'selected' : ''}}>{{ $item->jenis_produk }}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-success btn-sm">Tampilkan</button>
                            <a href="{{route('list-seragam')}}" class="btn btn-dim btn-outline-danger btn-sm mx-1">Reset</a>   
                        </div>                       
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="d-flex" style="justify-content: flex-end">
                    <button class="btn btn-primary btn-sm mx-2" data-bs-toggle="modal" data-bs-target="#add_seragam"> Add Seragam </button>
                    <form action="{{route('export-seragam')}}" method="GET" ><button class="btn btn-success btn-sm" > Export Excel </button> </form>
                </div>
                <div class="table-responsive mt-3">
                    <table id="list_seragam" class="table table-striped" data-toggle="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Jenis Produk </th>
                                <th>Ukuran</th>
                                <th>Kode Produk</th>
                                <th>Harga</th>
                                <th>Diskon (%)</th>
                                <th>Harga Setelah Diskon</th>
                                <th>Stok </th>
                                {{-- @if ($id_role == 1) --}}
                                    <th>Action</th>
                            {{-- @endif --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list_seragam as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$item->nama_produk}}</td>
                                    <td>{{$item->jenis_produk}}</td>
                                    <td>{{$item->ukuran_seragam}} </td>
                                    <td>{{$item->kode_produk}}</td>
                                    <td>Rp {{number_format($item->harga)}}</td>
                                    <td>{{$item->diskon}}</td>
                                    <td>Rp. {{ number_format($item->harga - ($item->harga * $item->diskon / 100)) }}</td>
                                    <td>{{$item->qty}}</td>
                                    {{-- @if ($id_role == 1) --}}
                                        <td class="d-flex">
                                            <button class="btn btn-sm btn-warning" title="Edit" onclick="edit_data('{{$item->id}}')" data-bs-toggle="modal" data-bs-target="#edit_seragam">
                                                <i class="fa-solid fa-pencil"></i>
                                            </button>
                                        </td>
                                    {{-- @endif --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
    <script>

        $(document).ready(function() {
            $('#nama_produk').select2();
            $('#ukuran').select2();
            $('#jenis_produk').select2();
        });

        function edit_data(id) {
            fetch('/master/seragam/' + id)
                .then(response => response.json())
                .then(data => {
                    var product_name = data.nama_produk + ', ' + data.jenis_produk + ', ' +data.ukuran_seragam
                    $("#product_name").val(product_name)
                    $("#kode_produk").val(data.kode_produk)
                    $("#product_variant").val(data.jenis_produk)
                    $("#size").val(data.ukuran_seragam)
                    $("#harga").val(data.harga)
                    $("#diskon").val(data.diskon)
                    $("#stock").val(data.qty)
                    $("#id_harga_seragam").val(id)

                })
        }

        function update_seragam() {
            var id = $('#id_harga_seragam').val();
            var harga = $('#harga').val();
            var diskon = $('#diskon').val();
            var kode_produk = $('#kode_produk').val();
            var stock = $('#stock').val();
            var keterangan = $('#keterangan').val();

            var url = "{{ route('update-seragam', ":id") }}";
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: 'PUT',
                data: {
                    harga: harga,
                    diskon: diskon,
                    kode_produk: kode_produk,
                    id: id,
                    stock: stock,
                    keterangan: keterangan,
                    _token: '{{csrf_token()}}'
                },
                success: function (result) {
                    window.location.reload()
                }
            })
        }

    </script>

    <div class="modal fade" id="edit_seragam" tabindex="-1" role="dialog" aria-labelledby="label_surat_perjanjian" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="label_surat_perjanjian">Input Stock Seragam</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="product_name" class="form-control-label">Nama Produk</label>
                        <input type="text" class="form-control" name="product_name" id="product_name" readonly>
                    </div>

                    <div class="form-group">
                        <label for="harga" class="form-control-label">Harga</label>
                        <input type="text" class="form-control" name="harga" id="harga">
                    </div>

                    <div class="form-group">
                        <label for="diskon" class="form-control-label">Diskon</label>
                        <input type="text" class="form-control" name="diskon" id="diskon">
                    </div>

                    <div class="form-group">
                        <label for="kode_produk" class="form-control-label">Kode Produk</label>
                        <input type="text" class="form-control" name="kode_produk" id="kode_produk" required>
                    </div>

                    <div class="form-group">
                        <label for="stock" class="form-control-label">Stok</label>
                        <input type="text" class="form-control" name="stock" id="stock" required>
                    </div>

                    <div class="form-group">
                        <label for="keterangan" class="form-control-label">Keterangan</label>
                        <input type="text" class="form-control" name="keterangan" id="keterangan" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <input type="hidden" id="id_harga_seragam">
                    <button type="button" class="btn btn-success btn-sm" onclick="update_seragam()" >Update</button>
                </div>
            </div>
        </div>
    </div>

    {{-- create seragam --}}
    <div class="modal fade" id="add_seragam" tabindex="-1" role="dialog" aria-labelledby="create_seragam" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="create_seragam">Tambah Seragam</h5>
                </div>
                <form action="{{route('create-seragam')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="product_name_add" class="form-control-label">Nama Produk</label>
                            <select name="product_name_add" id="product_name_add" class="select2 form-control form-control-sm" aria-label=".form-select-sm" >
                                <option value="" disabled selected> </option>
                                    @foreach ($list_produk as $item)
                                        <option value="{{ $item->id }}" {{($item->id == $nama_produk) ? 'selected' : ''}} >{{ $item->nama_produk }}</option>
                                    @endforeach
                            </select>
                            <span style="font-size: 10px"> Tidak ada dalam list? Tambah Disini </span>
                        </div>

                        <div class="form-group">
                            <label for="ukuran_produk_add" class="form-control-label">Ukuran Produk</label>
                            <select name="ukuran_produk_add" id="ukuran_produk_add" class="select2 form-control form-control-sm" aria-label=".form-select-sm" >
                                <option value="" disabled selected> </option>
                                    @foreach ($list_ukuran as $item)
                                        <option value="{{ $item->id }}" >{{ $item->ukuran_seragam }}</option>
                                    @endforeach
                            </select>
                            <span style="font-size: 10px"> Tidak ada dalam list? Tambah Disini </span>
                        </div>

                        <div class="form-group">
                            <label for="jenis_produk_add" class="form-control-label">Jenis Produk</label>
                            <select name="jenis_produk_add" id="jenis_produk_add" class="select2 form-control form-control-sm" aria-label=".form-select-sm" >
                                <option value="" disabled selected> </option>
                                    @foreach ($list_jenis as $item)
                                        <option value="{{ $item->id }}" >{{ $item->jenis_produk }}</option>
                                    @endforeach
                            </select>
                            <span style="font-size: 10px"> Tidak ada dalam list? Tambah Disini </span>
                        </div>

                        <div class="form-group">
                            <label for="harga_add" class="form-control-label">Harga</label>
                            <input type="text" class="form-control" name="harga_add" id="harga_add">
                        </div>

                        <div class="form-group">
                            <label for="diskon_add" class="form-control-label">Diskon</label>
                            <input type="text" class="form-control" name="diskon_add" id="diskon_add">
                        </div>

                        <div class="form-group">
                            <label for="kode_produk_add" class="form-control-label">Kode Produk</label>
                            <input type="text" class="form-control" name="kode_produk_add" id="kode_produk_add" required>
                        </div>

                        <div class="form-group">
                            <label for="barcode15_add" class="form-control-label">Barcode 15</label>
                            <input type="text" class="form-control" name="barcode15_add" id="barcode15_add" required>
                        </div>

                        <div class="form-group">
                            <label for="style_produk_add" class="form-control-label">Style Produk</label>
                            <input type="text" class="form-control" name="style_produk_add" id="style_produk_add" required>
                        </div>

                        <div class="form-group">
                            <label for="stock_add" class="form-control-label">Stok</label>
                            <input type="text" class="form-control" name="stock_add" id="stock_add" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <input type="hidden" id="id_harga_seragam">
                        <button type="submit" class="btn btn-success btn-sm" >Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection