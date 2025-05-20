@extends('karir.layouts.app')

@section('content')
    <div class="karir">
        <div class="container mt-3">
            <div class="row mt-4">
                @include('karir.profile.sidebar')
                <div class="col-md">
                    <div class="card">
                        <div class="card-body mb-3 row">
                            <form role="form" action="{{route('karir.store_profile', auth()->user()->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <div class="card-title mb-3">
                                    <h4> Edit Data Diri</h4>
                                </div>
                                <div class="form-group row mb-3">
                                    <div class="col-sm-2    ">
                                        <label for="nama_lengkap">Nama Lengkap</label>
                                        <p style="font-size: 9px">*dengan gelar</p>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{$user->csdm != null ? $user->csdm->nama_lengkap : $user->name}}"  >
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-8">
                                        <input type="email" class="form-control" id="email" name="email" value="{{auth()->user()->email}}" readonly >
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for ="jenis_kelamin" class="col-sm-2">Jenis Kelamin</label>
                                    <div class="col-sm-8">
                                        @if ($user->csdm == null)
                                            <input type="checkbox" id="ikhwan" name="jenis_kelamin" value="1">
                                            <label for="ikhwan"> Ikhwan </label>
                                            <input type="checkbox" id="akhwat" name="jenis_kelamin" value="2">
                                            <label for="akhwat"> Akhwat </label>
                                        @elseif ($user->csdm->jenis_kelamin == 1)
                                            <input type="checkbox" id="ikhwan" name="jenis_kelamin" value="1" checked>
                                            <label for="ikhwan"> Ikhwan </label>
                                            <input type="checkbox" id="akhwat" name="jenis_kelamin" value="2">
                                            <label for="akhwat"> Akhwat </label>
                                        @else
                                            <input type="checkbox" id="ikhwan" name="jenis_kelamin" value="1">
                                            <label for="ikhwan"> Ikhwan </label>
                                            <input type="checkbox" id="akhwat" name="jenis_kelamin" value="2" checked>
                                            <label for="akhwat"> Akhwat </label>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for ="tempat_lahir" class="col-sm-2 col-form-label">Tempat Lahir</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{$user->csdm != null ? $user->csdm->tempat_lahir : ''}}" required >
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for ="tgl_lahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="{{$user->csdm != null ? $user->csdm->tgl_lahir : ''}}" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for ="posisi_dilamar" class="col-sm-2 col-form-label">Posisi Dilamar</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="posisi_dilamar" name="posisi_dilamar" value="{{$user->csdm != null ? $user->csdm->posisi_dilamar : ''}}" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for ="domisili_sekarang" class="col-sm-2 col-form-label">Domisili Saat Ini</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="domisili_sekarang" name="domisili_sekarang" value="{{$user->csdm != null ? $user->csdm->domisili_sekarang:''}}" required>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label for ="foto_profile" class="col-sm-2 col-form-label mt-3">Foto Profile</label>
                                    <div class="col-sm-8">
                                        <input type="hidden" name="oldImage" value="{{$user->csdm != null ? $user->csdm->foto_profile : ''}}">
                                        @if ($user->csdm != null)
                                            <img src="{{asset('storage/'. $user->csdm->foto_profile)}}" class="img-preview img-fluid mb-3" style="width: 20%">
                                        @else
                                            <img class="img-preview img-fluid mb-3 col-sm-5">
                                        @endif
                                        <input type="file" class="form-control" id="foto_profile" name="foto_profile" onchange="previewImage()" required>
                                    </div>
                                </div>
                                <div class="d-flex" style="justify-content: flex-end">
                                    <button type="submit" class="btn btn-primary mx-1">Update Profile</button>
                                    <a href="{{route('karir.profile')}}" class="btn btn-secondary" style="border-radius: 1rem">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage() {
            const image = document.querySelector('#foto_profile');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';
            imgPreview.style.width = '20%';


            const ofReader = new FileReader();
            ofReader.readAsDataURL(image.files[0]);

            ofReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result
            }
        }
    </script>
    
@endsection