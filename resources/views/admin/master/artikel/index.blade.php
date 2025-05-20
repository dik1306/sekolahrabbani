@extends('admin.layouts.app')

@section('content')
    <div class="iq-navbar-header">
        <div style="position: absolute; z-index:-1; top:0; height: 263px">
            <img src="{{asset('assets/images/top-header.png')}} " alt="header" class="theme-color-default-img img-fluid w-100 h-100">
        </div>
        <div class="title my-3">
            <h1 class="text-white" style="margin-left: 1rem">List Artikel </h1>
        </div>
    </div>
    <div class="container iq-container px-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex" style="justify-content: flex-end">
                    <form action="#" method="GET" class="mx-2">
                        <button class="btn btn-primary btn-sm"> Add Artikel </button>
                    </form>
                </div>
                <div class="table-responsive mt-3">
                    <table id="list_artikel" class="table table-striped" data-toggle="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Artikel</th>
                                <th style="width: 250px !important;">Deskripsi </th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Upload By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($artikel as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$item->judul}}</td>
                                    <td>{{$item->isi_artikel, 30}}</td>
                                    <td>{{$item->image}} </td>
                                    <td>{{$item->status}}</td>
                                    <td>{{($item->upload_by)}}</td>
                                    <td class="d-flex">
                                        <a href="{{route('artikel.edit', $item->id)}}" class="btn btn-sm btn-warning" title="Edit"><i class="fa-solid fa-pencil"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

   
@endsection

<style>
    table.dataTable th:nth-child(3) {
        width: 400px;
        max-width: 400px;
        word-break: break-all;
        white-space: pre-line;
    }

    table.dataTable td:nth-child(3) {
        width: 400px;
        max-width: 400px;
        word-break: break-all;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
