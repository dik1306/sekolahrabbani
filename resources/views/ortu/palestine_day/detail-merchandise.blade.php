@extends ('ortu.layouts.app')

@section('content')
    @include('ortu.palestine_day.top-navigate')    
    <div id="image-carousel" class="carousel slide px-0">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#image-carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#image-carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#image-carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#image-carousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
            <button type="button" data-bs-target="#image-carousel" data-bs-slide-to="4" aria-label="Slide 5"></button>
            <button type="button" data-bs-target="#image-carousel" data-bs-slide-to="5" aria-label="Slide 6"></button>
            <button type="button" data-bs-target="#image-carousel" data-bs-slide-to="6" aria-label="Slide 7"></button>
            <button type="button" data-bs-target="#image-carousel" data-bs-slide-to="7" aria-label="Slide 8"></button>
            <button type="button" data-bs-target="#image-carousel" data-bs-slide-to="8" aria-label="Slide 9"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="img-detail-card" src="{{ asset('storage/'.$merchandise->image_1) }}" alt="{{$merchandise->image_1}}">
            </div>

            @if ($merchandise->jenis_id == 1 )
                @foreach ($design_anak as $item)
                    <div class="carousel-item">
                        <img class="img-detail-card" src="{{ asset('storage/'.$item->image_file) }}" alt="{{$item->image_file}}">
                    </div>
                @endforeach

                @foreach ($template_kaos as $item)
                    <div class="carousel-item">
                        <img class="img-detail-card" src="{{ asset('storage/'.$item->image_1) }}" alt="{{$item->image_1}}">
                    </div>
                @endforeach
            @elseif ($merchandise->jenis_id == 2)
                @foreach ($design_anak as $item)
                    <div class="carousel-item">
                        <img class="img-detail-card" src="{{ asset('storage/'.$item->image_file) }}" alt="{{$item->image_file}}">
                    </div>
                @endforeach

                @foreach ($template_kaos_akhwat as $item)
                    <div class="carousel-item">
                        <img class="img-detail-card" src="{{ asset('storage/'.$item->image_1) }}" alt="{{$item->image_1}}">
                    </div>
                @endforeach
            @elseif ($merchandise->jenis_id == 3)
                @foreach ($design_anak as $item)
                    <div class="carousel-item">
                        <img class="img-detail-card" src="{{ asset('storage/'.$item->image_file) }}" alt="{{$item->image_file}}">
                    </div>
                @endforeach

                @foreach ($template_kerudung as $item)
                    <div class="carousel-item">
                        <img class="img-detail-card" src="{{ asset('storage/'.$item->image_1) }}" alt="{{$item->image_1}}">
                    </div>
                @endforeach
            @endif

            <div class="carousel-item">
                <img class="img-detail-card" src="{{ asset('storage/'.$merchandise->image_2) }}" alt="{{$merchandise->image_2}}">
            </div>

            <div class="carousel-item">
                <img class="img-detail-card" src="{{ asset('storage/'.$merchandise->image_3) }}" alt="{{$merchandise->image_3}}">
            </div>
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
            <input type="hidden" id="merchandise_id" value="{{$merchandise->id}}">
            <div class="produk-title">
                <h5 class="card-title mb-0">{{$merchandise->nama_produk}}</h5>
                <p class="mb-1 price-diskon-detail" ><b> Rp. {{number_format($merchandise->harga_awal)}} </b> </p>
            </div>

            <div class="produk-deskripsi mt-4">
                <h6 style="color:  #3152A4"><b> Deskripsi Produk </b> </h6>
                <p style="font-size: 14px"> {{$merchandise->deskripsi}} </p>
            </div> 
        </div>
    </div>

    <div class="bottom-navigate sticky-bottom">
        <div class="d-flex" style="justify-content: end">
            <a href="#" class="btn btn-primary px-3" data-bs-toggle="modal" data-bs-target="#pre_order" > <i class="fa-solid fa-plus"></i> Keranjang </a>
            <a href="#" class="btn btn-purple mx-2 px-3" data-bs-toggle="modal" data-bs-target="#pre_order" > Pre Order </a>
        </div>
    </div>


    <div class="modal fade" id="pre_order" tabindex="-1" role="dialog" aria-labelledby="po" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="align-items: flex-end">
            <div class="modal-content animate-bottom ">
                <div class="modal-body">
                    <div class="d-flex mx-1" style="justify-content: space-between">
                        <div class="frame">
                            <img src="{{asset('storage/'.$merchandise->image_1)}}" width="100%" style="height: 100%; object-fit:cover; border-radius:1rem">
                        </div>
                        <div class="mx-2 mt-2" style="width: 255px">
                            <div class="titel">
                                <p class="card-title mb-0"> <b> {{$merchandise->nama_produk}} </b> </p>
                                <p class="mb-1 price-diskon" style="font-size: 24px"> <b> Rp. <span id="harga_awal"> {{number_format($merchandise->harga_awal) }} </span> </b> </p>
                            </div>
                        </div>
                        <div class="close">
                            <a style="color:gray; text-decoration:none" data-bs-dismiss="modal" ><i class="fa-solid fa-chevron-down"></i></a>
                        </div>
                    </div>

                    <div class="produk-detail d-flex">
                        <div class="frame-detail" id="frame_karya" style="display: none">
                            <img src="#" id="image_karya" width="100%" style="height: 100%; object-fit:cover; border-radius:1rem">
                        </div>
                        <div class="frame-detail" id="frame_template" style="display: none">
                            <img src="#" id="image_template" width="100%" style="height: 100%; object-fit:cover; border-radius:1rem">
                        </div>
                        <div class="frame-detail" id="frame_warna" style="display: none">
                            <img src="#" id="image_warna" width="100%" style="height: 100%; object-fit:cover; border-radius:1rem">
                        </div>
                    </div>

                    @if ($merchandise->jenis_id == '1')
                        <div class="produk-karya mt-3">
                            <h6 style="color: #3152A4"><b> Karya </b> </h6>
                            <div class="d-flex" style="flex-direction: column">
                                @foreach ($design_anak as $item)
                                    <div class="button-karya mt-1">
                                        <input class="form-check-input" type="radio" name="design" id="design_{{$item->id}}" value="{{$item->id}}">
                                        <label class="form-check-label" for="design_{{$item->id}}">
                                        <span class="px-2" style="font-size: 10px"> {{$item->nama_siswa}} </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <span class="mb-0 text-danger" style="font-size: 10px; display: none" id="valid_karya" > Pilih karya terlebih dahulu! </span>
                        </div>

                        <div class="produk-template mt-3">
                            <h6 style="color: #3152A4"><b> Template </b> </h6>
                            <div class="d-flex">
                                @foreach ($template_kaos as $item)
                                    <div class="button-jenis">
                                        <input class="form-check-input" type="radio" name="template" id="template_{{$item->id}}" value="{{$item->id}}">
                                        <label class="form-check-label" for="template_{{$item->id}}">
                                        <span style="font-size: 12px"> {{$item->judul}} </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <span class="mb-0 text-danger" style="font-size: 10px; display: none" id="valid_template" > Pilih Template terlebih dahulu! </span>
                        </div>

                        <div class="produk-warna mt-3">
                            <h6 style="color: #3152A4"><b> Warna </b> </h6>
                            <div class="d-flex">
                                @foreach ($warna_kaos_ikhwan as $item)
                                    <div class="button-jenis">
                                        <input class="form-check-input" type="radio" name="warna" id="warna_{{$item->id}}" value="{{$item->id}}">
                                        <label class="form-check-label" for="warna_{{$item->id}}">
                                        <span style="font-size: 11px;"> {{$item->warna}} </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <span class="mb-0 text-danger" style="font-size: 10px; display: none" id="valid_warna" > Pilih warna terlebih dahulu! </span>
                        </div>

                        <div class="produk-kategori mt-3">
                            <h6 style="color: #3152A4"><b> Kategori </b> </h6>
                            <div class="d-flex">
                                @foreach ($kategori as $item)
                                    <div class="button-jenis">
                                        <input class="form-check-input" type="radio" name="kategori" id="kategori_{{$item->id}}" value="{{$item->id}}">
                                        <label class="form-check-label" for="kategori_{{$item->id}}">
                                        <span> {{$item->kategori}} </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <span class="mb-0 text-danger" style="font-size: 10px; display: none" id="valid_kategori" > Pilih Kategori terlebih dahulu! </span>

                        </div>

                        <div class="produk-ukuran mt-3" id="ukuran_dewasa">
                            <h6 style="color: #3152A4"><b> Ukuran </b> </h6>
                            <div class="d-flex">
                                @foreach($ukuran_dewasa as $item)
                                    <div class="button-ukuran">
                                        <input class="form-check-input" type="radio" name="ukuran_dewasa"  id="uk_dewasa_{{$item->ukuran_seragam}}_{{$item->id}}" value="{{$item->id}}">
                                        <label class="form-check-label" for="uk_dewasa_{{$item->ukuran_seragam}}_{{$item->id}}">
                                        <span>{{$item->ukuran_seragam}} </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <span class="mb-0 text-danger" style="font-size: 10px; display: none" id="valid_ukuran_{{$item->id}}" > Pilih ukuran terlebih dahulu! </span>
                        </div>

                        <div class="produk-ukuran mt-3" id="ukuran_anak" style="display: none">
                            <h6 style="color: #3152A4"><b> Ukuran </b> </h6>
                            <div class="d-flex">
                                @foreach($ukuran_anak as $item)
                                    <div class="button-ukuran">
                                        <input class="form-check-input" type="radio" name="ukuran_anak"  id="uk_anak_{{$item->ukuran_seragam}}_{{$item->id}}" value="{{$item->id}}">
                                        <label class="form-check-label" for="uk_anak_{{$item->ukuran_seragam}}_{{$item->id}}">
                                        <span>{{$item->aliases}} </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <span class="mb-0 text-danger" style="font-size: 10px; display: none" id="valid_ukuran_{{$item->id}}" > Pilih ukuran terlebih dahulu! </span>
                        </div>
                    @elseif ($merchandise->jenis_id == '2')

                        <div class="produk-karya mt-3">
                            <h6 style="color: #3152A4"><b> Karya </b> </h6>
                            <div class="d-flex" style="flex-direction: column">
                                @foreach ($design_anak as $item)
                                    <div class="button-karya mt-1">
                                        <input class="form-check-input" type="radio" name="design" id="design_{{$item->id}}" value="{{$item->id}}">
                                        <label class="form-check-label" for="design_{{$item->id}}">
                                        <span class="px-2" style="font-size: 10px"> {{$item->nama_siswa}} </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <span class="mb-0 text-danger" style="font-size: 10px; display: none" id="valid_karya" > Pilih karya terlebih dahulu! </span>
                        </div>

                        <div class="produk-template mt-3">
                            <h6 style="color: #3152A4"><b> Template </b> </h6>
                            <div class="d-flex">
                                @foreach ($template_kaos as $item)
                                    <div class="button-jenis">
                                        <input class="form-check-input" type="radio" name="template" id="template_{{$item->id}}" value="{{$item->id}}">
                                        <label class="form-check-label" for="template_{{$item->id}}">
                                        <span style="font-size: 12px"> {{$item->judul}} </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <span class="mb-0 text-danger" style="font-size: 10px; display: none" id="valid_template" > Pilih template terlebih dahulu! </span>
                        </div>

                        <div class="produk-warna mt-3">
                            <h6 style="color: #3152A4"><b> Warna </b> </h6>
                            <div class="d-flex">
                                @foreach ($warna_kaos_akhwat as $item)
                                    <div class="button-jenis">
                                        <input class="form-check-input" type="radio" name="warna" id="warna_{{$item->id}}" value="{{$item->id}}">
                                        <label class="form-check-label" for="warna_{{$item->id}}">
                                        <span style="font-size: 11px;"> {{$item->warna}} </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <span class="mb-0 text-danger" style="font-size: 10px; display: none" id="valid_warna" > Pilih warna terlebih dahulu! </span>
                        </div>

                        <div class="produk-kategori mt-3">
                            <h6 style="color: #3152A4"><b> Kategori </b> </h6>
                            <div class="d-flex">
                                @foreach ($kategori as $item)
                                    <div class="button-jenis">
                                        <input class="form-check-input" type="radio" name="kategori" id="kategori_{{$item->id}}" value="{{$item->id}}">
                                        <label class="form-check-label" for="kategori_{{$item->id}}">
                                        <span> {{$item->kategori}} </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <span class="mb-0 text-danger" style="font-size: 10px; display: none" id="valid_kategori" > Pilih kategori terlebih dahulu! </span>

                        </div>

                        <div class="produk-ukuran mt-3" id="ukuran_dewasa">
                            <h6 style="color: #3152A4"><b> Ukuran </b> </h6>
                            <div class="d-flex">
                                @foreach($ukuran_dewasa as $item)
                                    <div class="button-ukuran">
                                        <input class="form-check-input" type="radio" name="ukuran_dewasa"  id="uk_dewasa_{{$item->ukuran_seragam}}_{{$item->id}}" value="{{$item->id}}">
                                        <label class="form-check-label" for="uk_dewasa_{{$item->ukuran_seragam}}_{{$item->id}}">
                                        <span>{{$item->ukuran_seragam}} </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <span class="mb-0 text-danger" style="font-size: 10px; display: none" id="valid_ukuran_{{$item->id}}" > Pilih ukuran terlebih dahulu! </span>
                        </div>

                        <div class="produk-ukuran mt-3" id="ukuran_anak" style="display: none">
                            <h6 style="color: #3152A4"><b> Ukuran </b> </h6>
                            <div class="d-flex">
                                @foreach($ukuran_anak as $item)
                                    <div class="button-ukuran">
                                        <input class="form-check-input" type="radio" name="ukuran_anak"  id="uk_anak_{{$item->ukuran_seragam}}_{{$item->id}}" value="{{$item->id}}">
                                        <label class="form-check-label" for="uk_anak_{{$item->ukuran_seragam}}_{{$item->id}}">
                                        <span>{{$item->aliases}} </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <span class="mb-0 text-danger" style="font-size: 10px; display: none" id="valid_ukuran_{{$item->id}}" > Pilih ukuran terlebih dahulu! </span>
                        </div>

                    @elseif ( $merchandise->jenis_id == '3')
                        <div class="produk-karya mt-3">
                            <h6 style="color: #3152A4"><b> Karya </b> </h6>
                            <div class="d-flex" style="flex-direction: column">
                                @foreach ($design_anak as $item)
                                    <div class="button-karya mt-1">
                                        <input class="form-check-input" type="radio" name="design" id="design_{{$item->id}}" value="{{$item->id}}">
                                        <label class="form-check-label" for="design_{{$item->id}}">
                                        <span class="px-2" style="font-size: 10px"> {{$item->nama_siswa}} </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <span class="mb-0 text-danger" style="font-size: 10px; display: none" id="valid_karya" > Pilih karya terlebih dahulu! </span>
                        </div>

                        <div class="produk-template mt-3">
                            <h6 style="color: #3152A4"><b> Template </b> </h6>
                            <div class="d-flex">
                                @foreach ($template_kerudung as $item)
                                    <div class="button-jenis">
                                        <input class="form-check-input" type="radio" name="template" id="template_{{$item->id}}" value="{{$item->id}}">
                                        <label class="form-check-label" for="template_{{$item->id}}">
                                        <span style="font-size: 12px"> {{$item->judul}} </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <span class="mb-0 text-danger" style="font-size: 10px; display: none" id="valid_template" > Pilih template terlebih dahulu! </span>
                        </div>

                        <div class="produk-warna mt-3">
                            <h6 style="color: #3152A4"><b> Warna </b> </h6>
                            <div class="d-flex">
                                @foreach ($warna_kerudung as $item)
                                    <div class="button-jenis">
                                        <input class="form-check-input" type="radio" name="warna" id="warna_{{$item->id}}" value="{{$item->id}}">
                                        <label class="form-check-label" for="warna_{{$item->id}}">
                                        <span style="font-size: 11px"> {{$item->warna}} </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <span class="mb-0 text-danger" style="font-size: 10px; display: none" id="valid_warna" > Pilih warna terlebih dahulu! </span>
                        </div>

                        <div class="produk-ukuran mt-3">
                            <h6 style="color: #3152A4"><b> Ukuran </b> </h6>
                            <div class="d-flex" id="ukuran_seragam">
                                @foreach($ukuran_kerudung as $item)
                                    <div class="button-ukuran">
                                        <input class="form-check-input" type="radio" name="ukuran_dewasa" id="uk_{{$item->ukuran_seragam}}_{{$item->id}}" value="{{$item->id}}">
                                        <label class="form-check-label" for="uk_{{$item->ukuran_seragam}}_{{$item->id}}">
                                        <span>{{$item->ukuran_seragam}} </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <span class="mb-0 text-danger" style="font-size: 10px; display: none" id="valid_ukuran_{{$item->id}}" > Pilih ukuran terlebih dahulu! </span>
                        </div>
                    
                    @endif

                    <div class="produk-jumlah my-4">
                        <h6 class="mt-1" style="color: #3152A4"><b> Jumlah </b> </h6>
                        <div class="input-group mx-3" style="border: none;">
                            <div class="button minus">
                                <button type="button" class="btn btn-outline-plus-minus btn-number" disabled="disabled" data-type="minus" data-field="quant[{{$merchandise->id}}]">
                                    <i class="fas fa-minus-circle"></i>
                                </button>
                            </div>
                            <input type="text" name="quant[{{$merchandise->id}}]" id="quant_{{$merchandise->id}}" class="input-number" value="1" min="1" max="10">
                            <div class="button plus">
                                <button type="button" class="btn btn-outline-plus-minus btn-number" data-type="plus" data-field="quant[{{$merchandise->id}}]">
                                    <i class="fas fa-plus-circle"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex mt-3" style="justify-content: end">
                        <button type="button" class="btn btn-primary px-3 " onclick="addToCart('{{$merchandise->id}}')" > <i class="fa-solid fa-plus"></i> Keranjang </button>
                        <form action="{{route('pre_order')}}" method="POST" id="po_now">
                            @csrf
                            <input type="hidden" name="data" id="data" value="">
                            <button type="button" class="btn btn-purple mx-2 px-3" onclick="pre_order('{{$merchandise->id}}')" > Pre Order (30 Hari) </button>
                        </form>
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

        // pilih karya produk
        $('input[name="design"]').change(function(){
            var design_id = $('input[name="design"]:checked').val();

            get_design(design_id);
        })

        // pilih template produk
        $('input[name="template"]').change(function(){
            var template_id = $('input[name="template"]:checked').val();

            get_template(template_id);
        })

        // pilih warna produk
        $('input[name="warna"]').change(function(){
            var warna_id = $('input[name="warna"]:checked').val();
            var merch_id = $('#merchandise_id').val();

            get_warna(warna_id, merch_id);
        })

         // pilih kategori produk
        $('input[name="kategori"]').change(function(){
          var kategori = $('input[name="kategori"]:checked').val();
          var merch_id = $('#merchandise_id').val();
          if (kategori == '1') {
            $('#ukuran_anak').show();
            $('#ukuran_dewasa').hide();

          } else {
            $('#ukuran_dewasa').show();
            $('#ukuran_anak').hide();

          }
          update_price(kategori, merch_id);
          $('input[name="ukuran_anak"]').prop('checked', false)
          $('input[name="ukuran_dewasa"]').prop('checked', false)

        });

        function update_price(kategori, merch_id){
            $.ajax({
                url: "{{route('harga_per_kategori')}}",
                type: 'POST',
                data: {
                    kategori_id: kategori,
                    merch_id : merch_id,
                    _token: '{{csrf_token()}}'
                },
                success: function (result) {
                    $.each(result, function (key, item) {
                        var harga = parseInt(item.harga);
                        var diskon = parseInt(item.diskon);
                        var harga_diskon = (harga - diskon/100*harga);
                        var formatter = new Intl.NumberFormat("en-US");
                        var format_harga = formatter.format(harga);
                        var format_harga_diskon = formatter.format(harga_diskon);
                
                        $("#harga_awal").html(format_harga);
                    });
                }
            })
        }

        
        // var url = 'http://sekolahrabbani.test/'
        var url = 'https://sekolahrabbani.sch.id/'

        function get_design(design_id) {
            $.ajax({
                url: "{{route('get_design')}}",
                type: 'POST',
                data: {
                    design_id: design_id,
                    _token: '{{csrf_token()}}'
                },
                success: function (result) {
                    var path_image = result.image_file;

                    var src_img = url + 'storage/' + path_image;
                    $('#frame_karya').show();
                    $('#image_karya').attr('src', src_img)
                }
            })
        }

        function get_template(template_id) {
            $.ajax({
                url: "{{route('get_template')}}",
                type: 'POST',
                data: {
                    template_id: template_id,
                    _token: '{{csrf_token()}}'
                },
                success: function (result) {
                    var path_image = result.image_1;

                    var src_img = url + 'storage/' + path_image;
                    $('#frame_template').show();
                    $('#image_template').attr('src', src_img)
                }
            })
        }

        function get_warna(warna_id, merch_id) {
            $.ajax({
                url: "{{route('get_warna')}}",
                type: 'POST',
                data: {
                    warna_id: warna_id,
                    merch_id: merch_id,
                    _token: '{{csrf_token()}}'
                },
                success: function (result) {
                    var path_image = result.image_file;

                    var src_img = url + 'storage/' + path_image;
                    $('#frame_warna').show();
                    $('#image_warna').attr('src', src_img)
                }
            })
        }

        var cart_now = $('#count_cart').html();
        var cart_num = parseInt(cart_now);
        function addToCart(id) {
            var item_id = id;
            var quantity = $('.input-number').val();
            var ukuran_dewasa = $('input[name="ukuran_dewasa"]:checked').val();
            var ukuran_anak = $('input[name="ukuran_anak"]:checked').val();
            var template = $('input[name="template"]:checked').val();
            var warna = $('input[name="warna"]:checked').val();
            var kategori = $('input[name="kategori"]:checked').val();
            var design = $('input[name="design"]:checked').val();
            var ukuran = '';
            if (ukuran_anak == null) {
                var ukuran = ukuran_dewasa;
            } else if (ukuran_dewasa == null) {
                var ukuran = ukuran_anak;
            }

            if (design == '' || design == null || design == undefined)  {
                $('#valid_karya').show();
            } else if (template == '' || template == null || template == undefined)  {
                $('#valid_template').show();
            } else if (warna == '' || warna == null || warna == undefined)  {
                $('#valid_warna').show();
            } else if (ukuran == '' || ukuran == null || ukuran == undefined) {
                $('#valid_ukuran_'+item_id).show();
            } else {
                $('#valid_ukuran_'+item_id).hide(); 
                $('#valid_template').hide();
                $('#valid_karya').hide();
                $('#valid_warna').hide();

                $.ajax({
                    url: "{{route('cart_post_merchandise')}}",
                    type: 'POST',
                    data: {
                        merchandise_id : item_id,
                        quantity : quantity,
                        ukuran : ukuran,
                        template_id : template,
                        warna_id : warna,
                        kategori_id : kategori,
                        design_id : design,
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

                $('#pre_order').modal('hide')
            }    
        }

        function submit_cart() {
            $('#cart_submit').submit();
        }

        var pesanan = []
        function pre_order(id) {
            var new_pesanan = {};
            var merch_id = id;
            var quantity = $('.input-number').val();
            var ukuran_dewasa = $('input[name="ukuran_dewasa"]:checked').val(); 
            var ukuran_anak = $('input[name="ukuran_anak"]:checked').val(); 
            var template = $('input[name="template"]:checked').val();
            var warna = $('input[name="warna"]:checked').val();
            var kategori = $('input[name="kategori"]:checked').val();
            if (kategori == null || kategori ==''){
                kategori = ''
            }

            var design = $('input[name="design"]:checked').val();

            if (ukuran_anak == null) {
                var ukuran = ukuran_dewasa;
            } else if (ukuran_dewasa == null) {
                var ukuran = ukuran_anak;
            }

            if (design == '' || design == null || design == undefined)  {
                $('#valid_karya').show();
            } else if (template == '' || template == null || template == undefined)  {
                $('#valid_template').show();
            } else if (warna == '' || warna == null || warna == undefined)  {
                $('#valid_warna').show();
            } else if (ukuran == '' || ukuran == null || ukuran == undefined) {
                $('#valid_ukuran_'+merch_id).show();
            } else {
                $('#valid_ukuran_'+merch_id).hide(); 
                $('#valid_template').hide();
                $('#valid_karya').hide();
                $('#valid_warna').hide();

                new_pesanan['merch_id'] = merch_id;
                new_pesanan['quantity'] = quantity;
                new_pesanan['ukuran'] = ukuran;
                new_pesanan['template'] = template;
                new_pesanan['warna'] = warna;
                new_pesanan['kategori'] = kategori;
                new_pesanan['design'] = design;

                pesanan.push(new_pesanan);
                $('#data').val(JSON.stringify(pesanan));
                $('#po_now').submit();
                $('#pre_order').modal('hide');
            }
        }

    </script>
@endsection
