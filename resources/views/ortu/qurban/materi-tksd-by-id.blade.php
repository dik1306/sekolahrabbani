@extends ('ortu.layouts.app')

@section('content')
    <div class="top-navigate sticky-top">
        <div class="d-flex" style="justify-content: stretch; width: 100%;">
            <a href="{{route('qurban.tksd')}}" class="mt-1" style="text-decoration: none; color: black">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h4 class="mx-2"> {{$materi->judul}} </h4>
        </div>
    </div>    
    <div class="mx-1 embed-youtube">
        <iframe src="{{$materi->link_video}}" style="width: 100%" allow="autoplay" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    </div>

    <div class="center my-3">
        @if ($sudah_nonton == null)
            <h3> Apakah Ayah/Bunda sudah menceritakan ini kepada anaknya? </h3>
            <a href="#" class="btn btn-danger px-4 mx-2" id="btn-belum" data-bs-toggle="modal" data-bs-target="#modal_belum">Belum</a>
            <a href="#" class="btn btn-success px-4" id="btn-sudah" onclick="sudah('{{$materi->id}}')">Sudah</a>
        @else
            <h3> Ayah/Bunda sudah nonton ini, Ayo <span class="text-success"> Ceritakan Kembali </span> kepada Anaknya </h3>
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

        // document.getElementById("theFrame").contentWindow.onload = function() {
        //     this.document.getElementsByTagName("img")[0].style.width="100%";
        // };

        setTimeout(function () {
        var startY = 0;
        var startX = 0;
        var b = document.body;
        b.addEventListener('touchstart', function (event) {
            parent.window.scrollTo(0, 1);
            startY = event.targetTouches[0].pageY;
            startX = event.targetTouches[0].pageX;
        });
        b.addEventListener('touchmove', function (event) {
            event.preventDefault();
            var posy = event.targetTouches[0].pageY;
            var h = parent.document.getElementById("theFrame");
            var sty = h.scrollTop;

            var posx = event.targetTouches[0].pageX;
            var stx = h.scrollLeft;
            h.scrollTop = sty - (posy - startY);
            h.scrollLeft = stx - (posx - startX);
            startY = posy;
            startX = posx;
        });
        }, 1000);

        function sudah(id) {
            var materi_id = id

            $.ajax({
                url: "{{route('qurban_sudah_baca')}}",
                type: 'POST',
                data: {
                    materi_id: materi_id,
                    _token: '{{csrf_token()}}'

                },
                success: function (result) {
                    setTimeout(function(){
                        window.location.reload(); // you can pass true to reload function to ignore the client cache and reload from the server
                    }, 2000);
                   $('#modal_sudah').modal('show')                    
                }
            })
        }
    </script>
@endsection