@extends('karir.layouts.app')

@section('content')
    <div class="karir">
        <div class="container mt-3">
            <div class="row mt-4">
                @include('karir.admin.sidebar')
                <div class="col-md">
                    <div class="card">
                        <div class="card-body mb-3">
                            <h3 class="card-title">Edit User CSDM</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.update_csdm', $user_csdm->id)}}" method="post">
                                @csrf @method('PUT')
                                <div class="mb-3">
                                    <label for="kode_csdm" class="form-label">Kode CSDM</label>
                                    <input type="text" class="form-control" id="kode_csdm" name="kode_csdm" value="{{$user_csdm->kode_csdm}}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{$user_csdm->name}}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{$user_csdm->email}}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="no_hp" class="form-label">No Hp</label>
                                    <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{$user_csdm->no_hp}}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection