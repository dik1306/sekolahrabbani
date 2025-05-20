@extends ('ortu.layouts.app')

@section('content')
    <div class="top-navigate sticky-top">
        <div class="d-flex" style="justify-content: stretch; width: 100%;">
            <a href="{{route('palestine.smp')}}" class="mt-1" style="text-decoration: none; color: black">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h4 class="mx-2"> {{$materi->judul}} </h4>
        </div>
    </div>    
    
    <div class="row justify-content-center">
        <object  data="{{ asset('storage/'.$materi->file) }}" type="application/pdf" height="600" >
            <iframe src="https://docs.google.com/gview?url={{asset('storage/'.$materi->file)}}&embedded=true" width="100%" style="height: 600px" scrolling="auto" type='application/pdf' >
                This browser does not support PDFs. Please download the PDF to view it: <a href="#">Download PDF</a>
            </iframe>
        </object>
        <span style="font-size: 12px"> Jika materi PDF tidak dapat di<i>scroll</i>, silahkan klik <a href="https://docs.google.com/viewerng/viewer?url={{asset('storage/'.$materi->file)}}&embedded=true" target="_blank"> link disini </a> </span>
    </div>

    <div class="center my-3">
        @if ($sudah_baca == null)
            <h3> Apakah Ananda sudah mempresentasikan infografis ini kepada Ayah/Bunda? </h3>
            <a href="#" class="btn btn-danger px-4 mx-2" id="btn-belum" data-bs-toggle="modal" data-bs-target="#modal_belum">Belum</a>
            <a href="#" class="btn btn-success px-4" id="btn-sudah" onclick="sudah('{{$materi->id}}')">Sudah</a>
        @else 
            <h3> Ayah/Bunda sudah baca materi ini, ayo <span class="text-success"> ceritakan kembali </span> pada anaknya </h3>
        @endif
    </div>

    <div class="modal fade" id="modal_belum" tabindex="-1" role="dialog" aria-labelledby="belum" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="px-2" style="text-align: right">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="d-flex">
                        <img src="{{asset('assets/images/sad_emoticon.png')}}" width="15%" alt="sad emoticon">
                        <h6 class="mt-3 mx-3"> Yaaaahh, sayang sekaliii... </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modal_sudah" tabindex="-1" role="dialog" aria-labelledby="sudah" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="px-2" style="text-align: right">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="d-flex">
                        <img src="{{asset('assets/images/happy_emoticon.png')}}" width="15%" alt="happy emoticon">
                        <h6 class="mt-3  mx-3"> Alhamdulillah, yeaaayy... </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>

        function sudah(id) {
            var materi_id = id

            $.ajax({
                url: "{{route('sudah_baca')}}",
                type: 'POST',
                data: {
                    materi_id: materi_id,
                    _token: '{{csrf_token()}}'

                },
                success: function (result) {
                    setTimeout(function(){
                        window.location.reload(); // you can pass true to reload function to ignore the client cache and reload from the server
                    }, 2000);
                    $('#modal_sudah').modal('show');       
                }
            })
        }
    </script>
@endsection