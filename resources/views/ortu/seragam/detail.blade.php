@extends ('ortu.layouts.app')

@section('content')
    @include('ortu.seragam.top-navigate')
    <div id="image-carousel" class="carousel slide px-0">
        <div class="carousel-indicators">
            @for ($i = 0; $i < count($seragam_images); $i++)
                <button type="button" data-bs-target="#image-carousel" data-bs-slide-to="{{ $i }}"
                    class="@if($i == 0) active @endif" aria-current="true" aria-label="Slide {{ $i+1 }}"></button>
            @endfor
        </div>
                  
        <div class="carousel-inner">
            @foreach($seragam_images as $idx => $img)
                <div class="carousel-item @if($idx == 0) active @endif">
                    <img class="img-detail-card" src="{{asset('assets/images/'.$img->image_url) }}" alt="{{ $img }}">
                </div>
            @endforeach

           
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#image-carousel"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon control-slide" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#image-carousel"
            data-bs-slide="next">
            <span class="carousel-control-next-icon control-slide" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="container">
        <div class="produk-detail">
            <input type="hidden" id="produk_id" value="{{$produk->id}}">

            <!-- Row (produk-title + button) -->
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                <!-- Column: produk-title -->
                <div class="produk-title">
                    <h5 class="card-title mb-0">{{$produk->nama_produk}}</h5>
                    @if ($produk->jenis_produk == 'Baju')
                        <p class="mb-1 price-diskon-detail" ><b> Rp. {{number_format($produk->harga * 80/100)}}/baju </b> </p>
                    @else
                        <p class="mb-1 price-diskon-detail" ><b> Rp. {{number_format($produk->harga * 80/100)}}/set </b> </p>
                    @endif
                    <p class="mb-0" style="font-size: 16px"> Discount 
                        <span class="bg-danger py-1 px-2"> {{($produk->diskon)}}% </span>
                        <span class="mx-2" style="color: gray"> <s> Rp. {{number_format($produk->harga)}} </s> </span>
                    </p>
                </div>

                <!-- Button: Size Chart -->
                <div>
                    <a href="#" class="btn btn-size-chart px-3" data-bs-toggle="modal" data-bs-target="#size_chart_ex">
                        <i class="fa-solid fa-shirt"></i> Size Chart
                    </a>
                </div>
            </div>

            <!-- Deskripsi Produk -->
            <div class="produk-deskripsi mt-4">
                <h6 style="color:  #3152A4"><b> Deskripsi Produk </b> </h6>
                <p style="font-size: 14px"> {{$produk->deskripsi}} </p>
            </div>
    
            {{-- Material --}}
            <div class="produk-material mt-3">
                <h6 style="color: #3152A4"><b> Material </b> </h6>
                <p style="font-size: 14px"> {{$produk->material}} </p>
            </div>      
        </div>
    </div>

    <style>
        .modal-size-custom {
            max-width: 600px;
            width: 100%;
        }
        .size-chart-empty {
            display: flex;
            justify-content: center;
            align-items: center;
            aspect-ratio: 1 / 1;
            border: 2px dashed #ff6b6b;
            border-radius: 12px;
            background-color: #fff3f3;
            text-align: center;
            padding: 20px;
            font-size: 18px;
            font-family: 'Comic Sans MS', cursive, sans-serif;
            color: #ff4d4d;
            font-weight: bold;
            box-shadow: inset 0 0 10px #ffe5e5;
        }
    </style>

    <div class="modal fade" id="size_chart_ex" tabindex="-1" aria-labelledby="carouselModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="carouselModalLabel">Size Chart {{$produk->nama_produk}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body">
                    @if($size_chart_images->isEmpty())
                        <div class="size-chart-empty">
                            😔 Mohon Maaf... <br> Size Chart Produk ini belum tersedia yaa~
                        </div>
                    @else
                        <div id="image-carousel-size" class="carousel slide px-0">
                            <div class="carousel-indicators">
                                @for ($i = 0; $i < count($size_chart_images); $i++)
                                    <button type="button" data-bs-target="#image-carousel-size" data-bs-slide-to="{{ $i }}"
                                        class="@if($i == 0) active @endif" aria-current="true" aria-label="Slide {{ $i+1 }}"></button>
                                @endfor
                            </div>

                            <div class="carousel-inner">
                                @foreach($size_chart_images as $idx => $img)
                                    <div class="carousel-item @if($idx == 0) active @endif">
                                        <img class="img-fluid w-100" src="{{asset('assets/images/'. $img->image_url)}}" alt="Gambar {{ $idx + 1 }}">
                                    </div>
                                @endforeach
                            </div>

                            <button class="carousel-control-prev" type="button" data-bs-target="#image-carousel-size" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Sebelumnya</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#image-carousel-size" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Berikutnya</span>
                            </button>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>


    <div class="bottom-navigate sticky-bottom">
        <div class="d-flex" style="justify-content: end">
            <a href="#" class="btn btn-primary px-3" data-bs-toggle="modal" data-bs-target="#buy_now" > <i class="fa-solid fa-plus"></i> Keranjang </a>
            <a href="#" class="btn btn-purple mx-1 px-3" data-bs-toggle="modal" data-bs-target="#buy_now" > Beli Sekarang </a>
            @if (auth()->user()->id == '825')
                <button class="btn px-1" onclick="showModalWL()" title="wishlist"> <i class="fa-solid fa-heart fa-xl" style="color: #E6E6E6;"></i> </button>
            @endif
        </div>
    </div>

    <div class="modal fade" id="buy_now" tabindex="-1" role="dialog" aria-labelledby="beli_sekarang" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="align-items: flex-end">
            <div class="modal-content animate-bottom ">
                <div class="modal-body">
                    <div class="d-flex mx-1" style="justify-content: space-between">
                        <div class="frame">
                            <img src="{{asset('assets/images/'.$produk->image)}}" width="100%" style="height: 100%; object-fit:cover; border-radius:1rem">
                        </div>
                        <div class="mx-2 mt-2" style="width: 255px">
                            <div class="titel">
                                <p class="card-title mb-0"> <b> {{$produk->nama_produk}} </b> </p>
                                <p class="mb-1 price-diskon" style="font-size: 24px"> <b> Rp. <span id="harga_diskon"> {{number_format(($produk['harga']) - ($produk['diskon']/100 * $produk['harga'])) }} </span> </b> </p>
                                <p class="mb-1" style="font-size: 13px"> Discount 
                                    <span class="bg-danger py-1 px-2" id="diskon_persen"> {{($produk->diskon)}}% </span>
                                    <span class="mx-2" style="color: gray"> <s> Rp. <span id="harga_awal"> {{number_format($produk->harga)}} </span> </s> </span>
                                </p>
                                <p class="mb-0 " style="font-size: 11px"> 
                                    Stok : 
                                    <input id="total_stok" style="border: none" disabled> <br>
                                    <input type="hidden" id="kode_produk">
                                    {{-- <span class="text-danger">  
                                    Segera checkout, stok sedikit!
                                    </span> --}}
                                </p>
                            </div>
                        </div>
                        <div class="close">
                            <a style="color:gray; text-decoration:none" data-bs-dismiss="modal" ><i class="fa-solid fa-chevron-down"></i></a>
                        </div>
                    </div>
    
                    <div class="produk-detail d-flex">
                        <div class="frame-detail">
                            <img src="{{asset('assets/images/'.$produk->image_2)}}" width="100%" style="height: 100%; object-fit:cover; border-radius:1rem">
                        </div>
                        <div class="frame-detail">
                            <img src="{{asset('assets/images/'.$produk->image_3)}}" width="100%" style="height: 100%; object-fit:cover; border-radius:1rem">
                        </div>
                        <div class="frame-detail">
                            <img src="{{asset('assets/images/'.$produk->image_4)}}" width="100%" style="height: 100%; object-fit:cover; border-radius:1rem">
                        </div>
                    </div>

                    <div class="produk-jenis mt-3">
                        <div class="d-flex">
                            @foreach ($jenis_produk as $item)
                                @if ($item->quantity > 0)
                                    <div class="button-jenis">
                                        <input class="form-check-input" type="radio" name="jenis_{{$produk->id}}" id="jenis_{{$produk->id}}_{{$item->id}}" value="{{$item->id}}">
                                        <label class="form-check-label" for="jenis_{{$produk->id}}_{{$item->id}}">
                                        <span> {{$item->jenis_produk}} </span>
                                        </label>
                                    </div>
                                @else 
                                    <div class="button-jenis">
                                        <input class="form-check-input" type="radio" name="jenis_{{$produk->id}}" id="jenis_{{$produk->id}}_{{$item->id}}" value="{{$item->id}}" disabled>
                                        <label class="form-check-label" for="jenis_{{$produk->id}}_{{$item->id}}">
                                        <span> {{$item->jenis_produk}} </span>
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <span class="mb-0 text-danger" style="font-size: 10px; display: none" id="valid_jenis_{{$produk->id}}" > Pilih jenis seragam terlebih dahulu! </span>

                    </div>
                    
                    <div class="produk-ukuran mt-3">
                        <h6 style="color: #3152A4"><b> Ukuran </b> </h6>
                        <div class="d-flex" id="ukuran_seragam">
                            @foreach($ukuran_seragam as $item)
                                @if ($item->quantity > 0)
                                    <div class="button-ukuran">
                                        <input class="form-check-input" type="radio" name="ukuran_{{$produk->id}}"  id="uk_{{$item->ukuran_seragam}}_{{$produk->id}}" value="{{$item->ukuran_seragam}}">
                                        <label class="form-check-label" for="uk_{{$item->ukuran_seragam}}_{{$produk->id}}">
                                        <span>{{$item->ukuran_seragam}} </span>
                                        </label>
                                    </div>
                                @else
                                    <div class="button-ukuran">
                                        <input class="form-check-input" type="radio" name="ukuran_{{$produk->id}}"  id="uk_{{$item->ukuran_seragam}}_{{$produk->id}}" value="{{$item->ukuran_seragam}}" disabled>
                                        <label class="form-check-label" for="uk_{{$item->ukuran_seragam}}_{{$produk->id}}">
                                        <span>{{$item->ukuran_seragam}} </span>
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <span class="mb-0 text-danger" style="font-size: 10px; display: none" id="valid_ukuran_{{$produk->id}}" > Pilih ukuran terlebih dahulu! </span>
                        <span class="mb-0 text-danger" style="font-size: 10px; display: none" id="valid_stok" > Mohon Maaf Stok Tidak Ada! </span>
                    </div>
                    
                    <div class="produk-jumlah my-4">
                        <h6 class="mt-1" style="color: #3152A4"><b> Jumlah </b> </h6>
                        <div class="input-group mx-3" style="border: none;">
                            <div class="button minus">
                                <button type="button" class="btn btn-outline-plus-minus btn-number" disabled="disabled" data-type="minus" data-field="quant[{{$produk->id}}]">
                                    <i class="fas fa-minus-circle"></i>
                                </button>
                            </div>
                            <input type="text" name="quant[{{$produk->id}}]" id="quant_{{$produk->id}}" class="input-number" value="1" min="1" max="10">
                            <div class="button plus">
                                <button type="button" class="btn btn-outline-plus-minus btn-number" data-type="plus" data-field="quant[{{$produk->id}}]">
                                    <i class="fas fa-plus-circle"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="produk-siswa d-flex">
                        <h6 class="mt-1" style="color: #3152A4; width: 150px;"><b> Nama Siswa </b> </h6>
                        <select id="nama_siswa" name="nama_siswa" class="select form-control form-control-sm px-3" required>
                            @foreach ($profile as $item)
                                <option value="{{ $item->nis }}" >{{ $item->nama_lengkap }} ({{ $item->nama_jenjang }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex mt-3" style="justify-content: end">
                        <button type="button" class="btn btn-primary px-3 " onclick="addToCart('{{$produk->id}}', '{{auth()->user()->name}}')" > <i class="fa-solid fa-plus"></i> Keranjang </button>
                        <form action="{{route('buy_now')}}" method="POST" id="beli_sekarang">
                            @csrf
                            <input type="hidden" name="data" id="data" value="">
                            <button type="button" class="btn btn-purple mx-2 px-3" onclick="buy_now('{{$produk->id}}')" > Beli Sekarang </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="wishlist" tabindex="-1" role="dialog" aria-labelledby="wishlist_popup" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="align-items: flex-end">
            <div class="modal-content animate-bottom ">
                <div class="modal-body">
                    <div class="d-flex mx-1" style="justify-content: space-between">
                        <div class="frame">
                            <img src="{{asset('assets/images/'.$produk->image)}}" width="100%" style="height: 100%; object-fit:cover; border-radius:1rem">
                        </div>
                        <div class="mx-2 mt-2" style="width: 255px">
                            <div class="titel">
                                <p class="card-title mb-0"> <b> {{$produk->nama_produk}} </b> </p>
                                <p class="mb-1 price-diskon" style="font-size: 24px"> <b> Rp. <span id="harga_diskon"> {{number_format(($produk['harga']) - ($produk['diskon']/100 * $produk['harga'])) }} </span> </b> </p>
                                <p class="mb-1" style="font-size: 13px"> Discount 
                                    <span class="bg-danger py-1 px-2" id="diskon_persen"> {{($produk->diskon)}}% </span>
                                    <span class="mx-2" style="color: gray"> <s> Rp. <span id="harga_awal"> {{number_format($produk->harga)}} </span> </s> </span>
                                </p>
                                <input type="hidden" id="kode_produk_wl">

                                
                            </div>
                        </div>
                        <div class="close">
                            <a style="color:gray; text-decoration:none" data-bs-dismiss="modal" ><i class="fa-solid fa-chevron-down"></i></a>
                        </div>
                    </div>
    
                    <div class="produk-detail d-flex">
                        <div class="frame-detail">
                            <img src="{{asset('assets/images/'.$produk->image_2)}}" width="100%" style="height: 100%; object-fit:cover; border-radius:1rem">
                        </div>
                        <div class="frame-detail">
                            <img src="{{asset('assets/images/'.$produk->image_3)}}" width="100%" style="height: 100%; object-fit:cover; border-radius:1rem">
                        </div>
                        <div class="frame-detail">
                            <img src="{{asset('assets/images/'.$produk->image_4)}}" width="100%" style="height: 100%; object-fit:cover; border-radius:1rem">
                        </div>
                    </div>

                    <div class="produk-jenis mt-3">
                        <div class="d-flex">
                            {{-- @foreach ($jenis_produk as $item)
                                <div class="button-jenis">
                                    <input class="form-check-input" type="radio" name="jenis_wl_{{$produk->id}}" id="jenis_wl_{{$produk->id}}_{{$item->id}}" value="{{$item->id}}">
                                    <label class="form-check-label" for="jenis_wl_{{$produk->id}}_{{$item->id}}">
                                    <span> {{$item->jenis_produk}} </span>
                                    </label>
                                </div>
                            @endforeach --}}

                            @foreach ($jenis_produk as $item)
                                @if ($item->quantity > 0)
                                    <div class="button-jenis">
                                        <input class="form-check-input" type="radio" name="jenis_wl_{{$produk->id}}" id="jenis_wl_{{$produk->id}}_{{$item->id}}" value="{{$item->id}}">
                                        <label class="form-check-label" for="jenis_wl_{{$produk->id}}_{{$item->id}}">
                                        <span> {{$item->jenis_produk}} </span>
                                        </label>
                                    </div>
                                @else 
                                    <div class="button-jenis">
                                        <input class="form-check-input" type="radio" name="jenis_wl_{{$produk->id}}" id="jenis_wl_{{$produk->id}}_{{$item->id}}" value="{{$item->id}}" disabled>
                                        <label class="form-check-label" for="jenis_wl_{{$produk->id}}_{{$item->id}}">
                                        <span> {{$item->jenis_produk}} </span>
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <span class="mb-0 text-danger" style="font-size: 10px; display: none" id="valid_jenis_wl_{{$produk->id}}" > Pilih jenis seragam terlebih dahulu! </span>

                    </div>
                    
                    <div class="produk-ukuran mt-3">
                        <h6 style="color: #3152A4"><b> Ukuran </b> </h6>
                        <div class="d-flex" id="ukuran_seragam">
                            {{-- @foreach($ukuran_seragam as $item)
                                <div class="button-ukuran">
                                    <input class="form-check-input" type="radio" name="ukuran_wl_{{$produk->id}}"  id="uk_wl_{{$item->ukuran_seragam}}_{{$produk->id}}" value="{{$item->ukuran_seragam}}">
                                    <label class="form-check-label" for="uk_wl_{{$item->ukuran_seragam}}_{{$produk->id}}">
                                    <span>{{$item->ukuran_seragam}} </span>
                                    </label>
                                </div>
                            @endforeach --}}
                            @foreach($ukuran_seragam as $item)
                                @if ($item->quantity == 0)
                                    <div class="button-ukuran">
                                        <input class="form-check-input" type="radio" name="ukuran_wl_{{$produk->id}}"  id="uk_wl_{{$item->ukuran_seragam}}_{{$produk->id}}" value="{{$item->ukuran_seragam}}">
                                        <label class="form-check-label" for="uk_wl_{{$item->ukuran_seragam}}_{{$produk->id}}">
                                        <span>{{$item->ukuran_seragam}} </span>
                                        </label>
                                    </div>
                                @else
                                    <div class="button-ukuran">
                                        <input class="form-check-input" type="radio" name="ukuran_wl_{{$produk->id}}"  id="uk_wl_{{$item->ukuran_seragam}}_{{$produk->id}}" value="{{$item->ukuran_seragam}}" disabled>
                                        <label class="form-check-label" for="uk_wl_{{$item->ukuran_seragam}}_{{$produk->id}}">
                                        <span>{{$item->ukuran_seragam}} </span>
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <span class="mb-0 text-danger" style="font-size: 10px; display: none" id="valid_ukuran_wl_{{$produk->id}}" > Pilih ukuran terlebih dahulu! </span>
                    </div>
                    
                    <div class="produk-jumlah my-4">
                        <h6 class="mt-1" style="color: #3152A4"><b> Jumlah </b> </h6>
                        <div class="input-group mx-3" style="border: none;">
                            <div class="button minus">
                                <button type="button" class="btn btn-outline-plus-minus btn-number" disabled="disabled" data-type="minus" data-field="quant_wl_[{{$produk->id}}]">
                                    <i class="fas fa-minus-circle"></i>
                                </button>
                            </div>
                            <input type="text" name="quant[{{$produk->id}}]" id="quant_wl_{{$produk->id}}" class="input-number" value="1" min="1" max="10">
                            <div class="button plus">
                                <button type="button" class="btn btn-outline-plus-minus btn-number" data-type="plus" data-field="quant_wl_[{{$produk->id}}]">
                                    <i class="fas fa-plus-circle"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="produk-siswa d-flex">
                        <h6 class="mt-1" style="color: #3152A4; width: 150px;"><b> Nama Siswa </b> </h6>
                        <select id="nama_siswa_wl" name="nama_siswa_wl" class="select form-control form-control-sm px-3" required>
                            @foreach ($profile as $item)
                                <option value="{{ $item->nis }}" >{{ $item->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex mt-3" style="justify-content: end">
                        <button type="button" class="btn btn-primary px-3 " onclick="addToWishlist('{{$produk->id}}')" > Simpan Wishlist </button>
                        <a href="{{route('seragam.wishlist')}}" class="btn btn-purple px-3 mx-1 " > Lihat Wishlist </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>

        $('.btn-number').click(function(e){
            e.preventDefault();
            
            fieldName = $(this).attr('data-field');
            type      = $(this).attr('data-type');
            var input = $("input[name='"+fieldName+"']");
            var currentVal = parseInt(input.val());
            if (!isNaN(currentVal)) {
                if(type == 'minus') {
                    
                    if(currentVal > input.attr('min')) {
                        input.val(currentVal - 1).change();
                    } 
                    if(parseInt(input.val()) == input.attr('min')) {
                        $(this).attr('disabled', true);
                    }

                } else if(type == 'plus') {

                    if(currentVal < input.attr('max')) {
                        input.val(currentVal + 1).change();
                    }
                    if(parseInt(input.val()) == input.attr('max')) {
                        $(this).attr('disabled', true);
                    }
                }
            } else {
                input.val(1);
            }
        });
        $('.input-number').focusin(function(){
        $(this).data('oldValue', $(this).val());
        });
        $('.input-number').change(function() {
            
            minValue =  parseInt($(this).attr('min'));
            maxValue =  parseInt($(this).attr('max'));
            valueCurrent = parseInt($(this).val());
            
            name = $(this).attr('name');
            if(valueCurrent >= minValue) {
                $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
            } else {
                alert('Sorry, the minimum value was reached');
                $(this).val($(this).data('oldValue'));
            }
            if(valueCurrent <= maxValue) {
                $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
            } else {
                alert('Sorry, the maximum value was reached');
                $(this).val($(this).data('oldValue'));
            }
            
            
        });
        $(".input-number").keydown(function (e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                    // Allow: Ctrl+A
                    (e.keyCode == 65 && e.ctrlKey === true) || 
                    // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                        // let it happen, don't do anything
                        return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
        });

        var item_id = $('#produk_id').val();

        // pilih jenis produk
        $('input[name="jenis_'+item_id+'"]').change(function(){
          
            var jenis_id = $('input[name="jenis_'+item_id+'"]:checked').val();
            var ukuran_id = $('input[name="ukuran_'+item_id+'"]:checked').val();
            console.log('jp1', ukuran_id, jenis_id);

            update_price(ukuran_id, jenis_id);
            update_stok(jenis_id);

           
        });
        
        // pilih ukuran
        $('input[name="ukuran_'+item_id+'"]').change(function(){
          
            var ukuran_id = $('input[name="ukuran_'+item_id+'"]:checked').val();
            var jenis_id = $('input[name="jenis_'+item_id+'"]:checked').val();
            console.log('uk1', ukuran_id, jenis_id);

            update_price(ukuran_id, jenis_id);

        });

        // pilih jenis produk wl
        $('input[name="jenis_wl_'+item_id+'"]').change(function(){
          
          var jenis_id = $('input[name="jenis_wl_'+item_id+'"]:checked').val();
          var ukuran_id = $('input[name="ukuran_wl_'+item_id+'"]:checked').val();
          console.log('jp', ukuran_id, jenis_id);

          update_price_wl(ukuran_id, jenis_id);
          update_stok_wl(jenis_id);
      });
      
      // pilih ukuran wl
      $('input[name="ukuran_wl_'+item_id+'"]').change(function(){
        
          var ukuran_id = $('input[name="ukuran_wl_'+item_id+'"]:checked').val();
          var jenis_id = $('input[name="jenis_wl_'+item_id+'"]:checked').val();
          console.log('uk', ukuran_id, jenis_id);
          update_price_wl(ukuran_id, jenis_id);

      });

        function update_price(ukuran_id, jenis_id){
            $.ajax({
                url: "{{route('harga_per_jenis')}}",
                type: 'POST',
                data: {
                    jenis_id: jenis_id,
                    produk_id : item_id,
                    ukuran_id : ukuran_id,
                    _token: '{{csrf_token()}}'

                },
                success: function (result) {
                    if (!$.trim(result)) {
                        var stok = 0;
                        $("#total_stok").val(stok);
                        $("#uk_"+ukuran_id+"_"+item_id).attr('disabled', true)
                    } else {
                        $.each(result, function (key, item) {
                            var harga = parseInt(item.harga);
                            var diskon = parseInt(item.diskon);
                            var harga_diskon = (harga - diskon/100*harga);
                            var formatter = new Intl.NumberFormat("en-US");
                            var format_harga = formatter.format(harga);
                            var format_harga_diskon = formatter.format(harga_diskon);
                            var stok = item.qty;
                            var kode_produk = item.kode_produk
                    
                            $("#harga_awal").html(format_harga);
                            $("#harga_diskon").html(format_harga_diskon)
                            $("#total_stok").val(stok)
                            $("#kode_produk").val(kode_produk)
                            $(".input-number").attr({
                                'max' : stok
                            })
                        });
                    }                    
                }
            })
        }

        function update_stok(jenis_id) {
            $.ajax({
                url: "{{route('stok')}}",
                type: 'POST',
                data: {
                    jenis_id: jenis_id,
                    produk_id : item_id,
                    _token: '{{csrf_token()}}'

                },
                success: function (result) {
                    
                    $.each(result, function (key, item) {
                        var stok = item.qty;

                        if (stok == 0 || stok == null) {
                            $("#uk_"+item.ukuran_seragam+"_"+item_id).attr('disabled', true)
                            
                        } else {
                            $("#uk_"+item.ukuran_seragam+"_"+item_id).attr('disabled', false)
                        }
                    })

                }
            })
        }

        function update_price_wl(ukuran_id, jenis_id){
            $.ajax({
                url: "{{route('harga_per_jenis')}}",
                type: 'POST',
                data: {
                    jenis_id: jenis_id,
                    produk_id : item_id,
                    ukuran_id : ukuran_id,
                    _token: '{{csrf_token()}}'

                },
                success: function (result) {
                    if (!$.trim(result)) {
                        var stok = 0;
                        $("#total_stok").val(stok);
                        $("#uk_wl_"+ukuran_id+"_"+item_id).attr('disabled', true)
                    } else {
                        $.each(result, function (key, item) {
                            var harga = parseInt(item.harga);
                            var diskon = parseInt(item.diskon);
                            var harga_diskon = (harga - diskon/100*harga);
                            var formatter = new Intl.NumberFormat("en-US");
                            var format_harga = formatter.format(harga);
                            var format_harga_diskon = formatter.format(harga_diskon);
                            var stok = item.qty;
                            var kode_produk = item.kode_produk
                            console.log(kode_produk);
                    
                            $("#harga_awal").html(format_harga);
                            $("#harga_diskon").html(format_harga_diskon)
                            $("#total_stok").val(stok)
                            $("#kode_produk_wl").val(kode_produk)
                            $(".input-number").attr({
                                'max' : stok
                            })
                        });
                    }                    
                }
            })
        }

        function update_stok_wl(jenis_id) {
            $.ajax({
                url: "{{route('stok')}}",
                type: 'POST',
                data: {
                    jenis_id: jenis_id,
                    produk_id : item_id,
                    _token: '{{csrf_token()}}'

                },
                success: function (result) {
                    
                    $.each(result, function (key, item) {
                        var stok = item.qty;

                        if (stok > 0 ) {
                            $("#uk_wl_"+item.ukuran_seragam+"_"+item_id).attr('disabled', true)
                            
                        } else {
                            $("#uk_wl_"+item.ukuran_seragam+"_"+item_id).attr('disabled', false)
                        }
                    })

                }
            })
        }

        var cart_now = $('#count_cart').html();
        var cart_num = parseInt(cart_now);
        function addToCart(id, nama_anak) {
            var item_id = id;
            var ukuran = $('input[name="ukuran_'+item_id+'"]:checked').val();
            var jenis = $('input[name="jenis_'+item_id+'"]:checked').val();
            var quantity = $('.input-number').val();
            var nama_siswa = $('#nama_siswa').val();
            var kode_produk = $('#kode_produk').val();
            var stok = $('#total_stok').val()
            

            if (ukuran == '' || ukuran == null || ukuran == undefined) {
                $('#valid_ukuran_'+item_id).show();
            } else if (jenis == '' || jenis == null || jenis == undefined)  {
                $('#valid_jenis_'+item_id).show();
            } else if (stok == null || stok == 0) {
                $('#valid_stok').show();
            } else {
                $('#valid_ukuran_'+item_id).hide(); 
                $('#valid_jenis_'+item_id).hide();
                $('#valid_stok').hide();

                $.ajax({
                    url: "{{route('cart_post')}}",
                    type: 'POST',
                    data: {
                        produk_id : item_id,
                        ukuran : ukuran,
                        quantity : quantity,
                        jenis: jenis,
                        nama_siswa: nama_siswa,
                        kode_produk: kode_produk,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (result) {
                        var qty_now = cart_num + 1
                        if (cart_num == 0) {
                            $('#count_cart').show();
                            $('#count_cart').html(qty_now)
                        } else {
                            $('#count_cart').html(qty_now)
                        }
                    }
                })

                $('#buy_now').modal('hide')
                
            }
            
        }

        var pesanan = []
        function buy_now(id) {
            var new_pesanan = {};
            var item_id = id;
            var ukuran = $('input[name="ukuran_'+item_id+'"]:checked').val();
            var jenis = $('input[name="jenis_'+item_id+'"]:checked').val();
            var quantity = $('.input-number').val();
            var nama_siswa = $('#nama_siswa').val();
            var stok = $('#total_stok').val()

            if (ukuran == '' || ukuran == null || ukuran == undefined) {
                $('#valid_ukuran_'+item_id).show();
            } else if (jenis == '' || jenis == null || jenis == undefined)  {
                $('#valid_jenis_'+item_id).show();
            } else if (stok == null || stok == 0) {
                $('#valid_stok').show();
            } else {
                $('#valid_ukuran_'+item_id).hide(); 
                $('#valid_jenis_'+item_id).hide();
                $('#valid_stok').hide();

                new_pesanan['produk_id'] = item_id;
                new_pesanan['ukuran'] = ukuran;
                new_pesanan['jenis'] = jenis;
                new_pesanan['quantity'] = quantity;
                new_pesanan['nama_siswa'] = nama_siswa;

                pesanan.push(new_pesanan);
                $('#data').val(JSON.stringify(pesanan));
                $('#beli_sekarang').submit();

            }
        }

        function showModalWL() {
            $('#wishlist').modal('show')
        }

        function addToWishlist(produk_id) {
            var produk_id = produk_id;
            var ukuran = $('input[name="ukuran_wl_'+produk_id+'"]:checked').val();
            var jenis = $('input[name="jenis_wl_'+produk_id+'"]:checked').val();
            var quantity = $('.input-number').val();
            var nama_siswa = $('#nama_siswa_wl').val();
            var kode_produk = $('#kode_produk_wl').val();



            if (ukuran == '' || ukuran == null || ukuran == undefined) {
                $('#valid_ukuran_wl_'+produk_id).show();
            } else if (jenis == '' || jenis == null || jenis == undefined)  {
                $('#valid_jenis_wl_'+produk_id).show();
            } else {
                $('#valid_ukuran_wl'+produk_id).hide(); 
                $('#valid_jenis_wl'+produk_id).hide();

                $.ajax({
                    url: "{{route('wishlist_post')}}",
                    type: 'POST',
                    data: {
                        produk_id : produk_id,
                        ukuran : ukuran,
                        quantity : quantity,
                        jenis: jenis,
                        nama_siswa: nama_siswa,
                        kode_produk: kode_produk,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (result) {
                        // console.log(result);
                    }
                })

                $('#wishlist').modal('hide')
                
            }

        }

        function submit_cart() {
            $('#cart_submit').submit();
        }

    </script>

@endsection
