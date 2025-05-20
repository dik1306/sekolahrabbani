@extends('admin.layouts.app')

@section('content')
    <div class="iq-navbar-header">
        <div style="position: absolute; z-index:-1; top:0; height: 263px">
            <img src="{{asset('assets/images/top-header.png')}} " alt="header" class="theme-color-default-img img-fluid w-100 h-100">
        </div>
        <div class="title my-3">
            <h1 class="text-white" style="margin-left: 1rem">List Jersey </h1>
        </div>
    </div>
    <div class="container iq-container px-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex" style="justify-content: flex-end">
                    <button class="btn btn-primary btn-sm mx-2" data-bs-toggle="modal" data-bs-target="#add_jersey"> Add jersey </button>
                </div>
                <div class="table-responsive mt-3">
                    <table id="list_jersey" class="table table-striped" data-toggle="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama jersey</th>
                                <th>Jenjang</th>
                                <th>Deskripsi</th>
                                <th>Harga</th>
                                <th>Diskon (%)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jersey as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$item->nama_jersey}}</td>
                                    <td>{{$item->nama_jenjang}}</td>
                                    <td>{{$item->deskripsi}}</td>
                                    <td>Rp. {{number_format($item->harga_awal)}}</td>
                                    <td>{{$item->persen_diskon}}</td>
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

    <div class="modal fade" id="add_jersey" tabindex="-1" role="dialog" aria-labelledby="jersey" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jersey">Tambah jersey</h5>
                </div>
                <form action="{{route('store_jersey')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_jersey" class="form-control-label">Nama jersey</label>
                            <input type="text" class="form-control" name="nama_jersey" id="nama_jersey" required>
                        </div>

                        <div class="form-group">
                            <label for="jenis_ekskul" class="form-control-label">Jenis Ekskul</label>
                            <select name="jenis_ekskul" id="jenis_ekskul" class="select2 form-control form-control-sm" aria-label=".form-select-sm" >
                                <option value="" disabled selected>--Pilih Ekskul-- </option>
                                @foreach ($jenis_ekskul as $item)
                                    <option value="{{ $item->id }}" >{{ $item->ekskul }}</option>
                                @endforeach
                            </select>
                            <span style="font-size: 11px"> Buat jenis baru? <a href="#" data-bs-toggle="modal" data-bs-target="#add_jenis_ekskul"> Klik disini </a> </span>
                        </div>

                        <div class="form-group">
                            <label for="jenis_kelamin" class="form-control-label">Jenis kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="select2 form-control form-control-sm" aria-label=".form-select-sm" >
                                <option value="" disabled selected> --Pilih jenis kelamin-- </option>
                                    <option value="L" >Ikhwan</option>
                                    <option value="P" >Akhwat</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="jenjang" class="form-control-label">Jenjang</label>
                            <select name="jenjang" id="jenjang" class="select2 form-control form-control-sm" aria-label=".form-select-sm" >
                                <option value="" disabled selected>--Pilih Jenjang-- </option>
                                @foreach ($jenjang as $item)
                                    <option value="{{ $item->value }}" >{{ $item->nama_jenjang }}</option>
                                @endforeach
                            </select>
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

                        <div class="form-group">
                            <label for="image_4" class="form-control-label">Image 4</label>
                            <input type="file" class="form-control" name="image_4" id="image_4">
                        </div>

                        <div class="form-group">
                            <label for="image_5" class="form-control-label">Image 5</label>
                            <input type="file" class="form-control" name="image_5" id="image_5">
                        </div>

                        <div class="form-group">
                            <label for="image_6" class="form-control-label">Image 6</label>
                            <input type="file" class="form-control" name="image_6" id="image_6">
                        </div>

                        <div class="form-group">
                            <label for="image_7" class="form-control-label">Image 7</label>
                            <input type="file" class="form-control" name="image_7" id="image_7">
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

    <div class="modal fade" id="add_jenis_ekskul" tabindex="-1" role="dialog" aria-labelledby="jenis_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jenis_modal">Tambah Jenis Ekskul</h5>
                </div>
                <form action="{{route('master.create_jenis_ekskul')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_ekskul" class="form-control-label">Jenis</label>
                            <input type="text" class="form-control" name="nama_ekskul" id="nama_ekskul" required>
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

