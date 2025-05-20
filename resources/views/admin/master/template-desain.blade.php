@extends('admin.layouts.app')

@section('content')
    <div class="iq-navbar-header">
        <div style="position: absolute; z-index:-1; top:0; height: 263px">
            <img src="{{asset('assets/images/top-header.png')}} " alt="header" class="theme-color-default-img img-fluid w-100 h-100">
        </div>
        <div class="title my-3">
            <h1 class="text-white" style="margin-left: 1rem">List Template </h1>
        </div>
    </div>
    <div class="container iq-container px-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex" style="justify-content: flex-end">
                    <button class="btn btn-primary btn-sm mx-2" data-bs-toggle="modal" data-bs-target="#add_template"> Add Template </button>
                </div>
                <div class="table-responsive mt-3">
                    <table id="list_template" class="table table-striped" data-toggle="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jenis</th>
                                <th>Nama Template</th>
                                <th>Image</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($template as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$item->jenis_id}}</td>
                                    <td>{{$item->judul}}</td>
                                    <td><img src="{{asset('storage/'.$item->image_1)}}"  id="img_cover_{{$item->id}}" onclick="zoomImage('{{asset('storage/'.$item->image_1)}}')" width="20px"></td>
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

    <div class="modal fade" id="add_template" tabindex="-1" role="dialog" aria-labelledby="template" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="template">Tambah Template</h5>
                </div>
                <form action="{{route('store_template')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_template" class="form-control-label">Nama Template</label>
                            <input type="text" class="form-control" name="nama_template" id="nama_template" required>
                        </div>

                        <div class="form-group">
                            <label for="jenis" class="form-control-label">Jenis</label>
                            <select name="jenis" id="jenis" class="select2 form-control form-control-sm" aria-label=".form-select-sm" >
                                <option value="" disabled selected> </option>
                                    @foreach ($jenis_merchandise as $item)
                                        <option value="{{ $item->id }}" >{{ $item->jenis }}</option>
                                    @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="image_1" class="form-control-label">Image 1</label>
                            <input type="file" class="form-control" name="image_1" id="image_1" required>
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

     {{-- modal zoom image --}}
     <div class="modal fade" id="zoom_image" tabindex="-1" role="dialog" aria-labelledby="zoom" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <img id="img_modal" src="#" alt="image-cover" width="100%" >
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function zoomImage(file)
        {
        $('#zoom_image').modal('show')
        $('#img_modal').attr('src', file)
        }
    </script>
@endsection

