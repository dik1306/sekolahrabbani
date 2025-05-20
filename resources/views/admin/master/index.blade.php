@extends('admin.layouts.app')

@section('content')
    <div class="iq-navbar-header">
        <div style="position: absolute; z-index:-1; top:0; height: 263px">
            <img src="{{asset('assets/images/top-header.png')}} " alt="header" class="theme-color-default-img img-fluid w-100 h-100">
        </div>
        <div class="title my-3">
            <h1 class="text-white" style="margin-left: 1rem">List User </h1>
        </div>
    </div>
    <div class="container iq-container px-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex" style="justify-content: flex-end">
                    <button class="btn btn-primary btn-sm"  data-bs-toggle="modal" data-bs-target="#add_user"> Add User </button>
                    <form action="{{route('get-user.api')}}" method="GET">
                        <button class="btn btn-warning btn-sm mx-2"> Get Ortu </button>
                    </form>
                    <form action="{{route('get-guru.api')}}" method="GET">
                        <button class="btn btn-success btn-sm "> Get Guru </button>
                    </form>
                </div>
                <div class="table-responsive mt-3">
                    <table id="list_user" class="table table-striped" data-toggle="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                {{-- <th>NIS</th> --}}
                                <th>No Hp </th>
                                <th>No Hp Kedua</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list_user as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$item->name}}</td>
                                    {{-- <td>{{$item->nis}}</td> --}}
                                    <td>{{$item->no_hp}} </td>
                                    <td>{{$item->no_hp_2}}</td>
                                    <td> {{$item->role_name}} </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- modal create user --}}
    <div class="modal fade" id="add_user" tabindex="-1" role="dialog" aria-labelledby="create_user" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="create_user">Tambah user</h5>
                </div>
                <form action="{{route('add-user')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_lengkap" class="form-control-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap">
                        
                        </div>

                        <div class="form-group">
                            <label for="no_hp" class="form-control-label">No Hp</label>
                            <input type="text" class="form-control" name="no_hp" id="no_hp">
                            
                        </div>

                        <div class="form-group">
                            <label for="id_role" class="form-control-label">Role</label>
                            <select name="id_role" id="id_role" class="select2 form-control form-control-sm" aria-label=".form-select-sm" >
                                <option value="" disabled selected> </option>
                                    @foreach ($list_role as $item)
                                        <option value="{{ $item->id }}" >{{ $item->name }}</option>
                                    @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-control-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <input type="hidden" id="id_harga_user">
                        <button type="submit" class="btn btn-success btn-sm" onclick="#" >Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection