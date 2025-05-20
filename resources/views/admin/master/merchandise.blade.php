@extends('admin.layouts.app')

@section('content')
    <div class="iq-navbar-header">
        <div style="position: absolute; z-index:-1; top:0; height: 263px">
            <img src="{{asset('assets/images/top-header.png')}} " alt="header" class="theme-color-default-img img-fluid w-100 h-100">
        </div>
        <div class="title my-3">
            <h1 class="text-white" style="margin-left: 1rem">List Merchandise </h1>
        </div>
    </div>
    <div class="container iq-container px-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex" style="justify-content: flex-end">
                    <button class="btn btn-primary btn-sm mx-2" data-bs-toggle="modal" data-bs-target="#add_merchandise"> Add Merchandise </button>
                </div>
                <div class="table-responsive mt-3">
                    <table id="list_merchandise" class="table table-striped" data-toggle="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Merchandise</th>
                                <th>Jenis</th>
                                <th>Deskripsi</th>
                                <th>Harga</th>
                                <th>Diskon (%)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($merchandise as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$item->nama_produk}}</td>
                                    <td>{{$item->jenis_merch->jenis}}</td>
                                    <td>{{$item->deskripsi}}</td>
                                    <td>Rp. {{number_format($item->harga_awal)}}</td>
                                    <td>{{$item->diskon}}</td>
                                    <td class="d-flex">
                                        <a href="#" class="btn btn-sm btn-warning" title="Edit"><i class="fa-solid fa-pencil"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add_merchandise" tabindex="-1" role="dialog" aria-labelledby="merchandise" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="merchandise">Tambah Merchandise</h5>
                </div>
                <form action="{{route('store_merchandise')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_merchandise" class="form-control-label">Nama Merchandise</label>
                            <input type="text" class="form-control" name="nama_merchandise" id="nama_merchandise" required>
                        </div>

                        <div class="form-group">
                            <label for="jenis" class="form-control-label">Jenis</label>
                            <select name="jenis" id="jenis" class="select2 form-control form-control-sm" aria-label=".form-select-sm" >
                                <option value="" disabled selected> </option>
                                    @foreach ($jenis_merchandise as $item)
                                        <option value="{{ $item->id }}" >{{ $item->jenis }}</option>
                                    @endforeach
                            </select>
                            <span> Buat jenis baru? <a href="#add_jenis" data-bs-toggle="modal" data-bs-target="#add_jenis"> Klik disini </a> </span>
                        </div>

                        <div class="form-group">
                            <label for="deskripsi" class="form-control-label">Deskripsi</label>
                            <input type="text" class="form-control" name="deskripsi" id="deskripsi" required>
                        </div>

                        <div class="form-group">
                            <label for="harga" class="form-control-label">Harga</label>
                            <input type="text" class="form-control" name="harga" id="harga" required>
                        </div>

                        <div class="form-group">
                            <label for="diskon" class="form-control-label">Diskon</label>
                            <input type="text" class="form-control" name="diskon" id="diskon" required>
                        </div>

                        <div class="form-group">
                            <label for="image_1" class="form-control-label">Image 1</label>
                            <input type="file" class="form-control" name="image_1" id="image_1" required>
                        </div>

                        <div class="form-group">
                            <label for="image_2" class="form-control-label">Image 2</label>
                            <input type="file" class="form-control" name="image_2" id="image_2">
                        </div>

                        <div class="form-group">
                            <label for="image_3" class="form-control-label">Image 3</label>
                            <input type="file" class="form-control" name="image_3" id="image_3">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success btn-sm" >Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add_jenis" tabindex="-1" role="dialog" aria-labelledby="jenis_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jenis_modal">Tambah Jenis</h5>
                </div>
                <form action="{{route('master.create_jenis')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_jenis" class="form-control-label">Jenis</label>
                            <input type="text" class="form-control" name="nama_jenis" id="nama_jenis" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success btn-sm" >Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

