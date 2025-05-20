@extends('admin.layouts.app')

@section('content')
    <div class="iq-navbar-header">
        <div style="position: absolute; z-index:-1; top:0; height: 263px">
            <img src="{{asset('assets/images/top-header.png')}} " alt="header" class="theme-color-default-img img-fluid w-100 h-100">
        </div>
        <div class="title my-3">
            <h1 class="text-white" style="margin-left: 1rem">List Menu </h1>
        </div>
    </div>
    <div class="container iq-container px-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex" style="justify-content: flex-end">
                    <button class="btn btn-primary btn-sm mx-2" data-bs-toggle="modal" data-bs-target="#add_menu"> Add Menu </button>
                </div>
                <div class="table-responsive mt-3">
                    <table id="list_artikel" class="table table-striped" data-toggle="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Menu</th>
                                <th>Icon</th>
                                <th>Root</th>
                                <th>No</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$item->name}}</td>
                                    <td> <i class="{{$item->icon}}"> </i> </td>
                                    <td>{{$item->root}}</td>
                                    <td>{{$item->no}}</td>
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

    {{-- create seragam --}}
    <div class="modal fade" id="add_menu" tabindex="-1" role="dialog" aria-labelledby="create-menu" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="create_menu">Tambah Menu</h5>
                </div>
                <form action="{{route('master.create_menu')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_menu" class="form-control-label">Nama Menu</label>
                            <input type="text" class="form-control" name="nama_menu" id="nama_menu" required>
                        </div>

                        <div class="form-group">
                            <label for="icon" class="form-control-label">Icon</label>
                            <input type="text" class="form-control" name="icon" id="icon" required>
                        </div>

                        <div class="form-group">
                            <label for="url" class="form-control-label">URL</label>
                            <input type="text" class="form-control" name="url" id="url" required>
                        </div>

                        <div class="form-group">
                            <label for="root" class="form-control-label">Root</label>
                            <select name="root" id="root" class="select form-control form-control-sm" aria-label=".form-select-sm" >
                                <option value="" disabled selected> </option>
                                    @foreach ($root as $item)
                                        <option value="{{ $item->id }}" >{{ $item->name }}</option>
                                    @endforeach
                            </select>
                            <span> Buat root baru? <a href="#add_root" data-bs-toggle="modal" data-bs-target="#add_root"> Klik disini </a> </span>
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

    <div class="modal fade" id="add_root" tabindex="-1" role="dialog" aria-labelledby="root" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="root">Tambah Menu</h5>
                </div>
                <form action="{{route('master.create_root')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_root" class="form-control-label">Nama Root</label>
                            <input type="text" class="form-control" name="nama_root" id="nama_root" required>
                        </div>

                        <div class="form-group">
                            <label for="icon_root" class="form-control-label">Icon</label>
                            <input type="text" class="form-control" name="icon_root" id="icon_root" required>
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

