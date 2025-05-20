@extends ('ortu.layouts.app')

@section('content')
    @include('ortu.palestine_day.top-navigate')    
    <div id="image-carousel" class="carousel slide px-0">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#image-carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#image-carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="img-detail-card" src="{{ asset('storage/'.$merchandise_kaos->image_file) }}" alt="{{$merchandise_kaos->image_1}}">
            </div>

            <div class="carousel-item">
                <img class="img-detail-card" src="{{ asset('storage/'.$detail_kaos->image_1) }}" alt="{{$merchandise_kaos->image_2}}">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#image-carousel"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#image-carousel"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="container">
        <div class="produk-detail">
            <input type="hidden" id="produk_id" value="{{$merchandise_kaos->id}}">
            <div class="produk-title">
                <h5 class="card-title mb-0">Kaos Custom Exclusive by {{$merchandise_kaos->nama_siswa}}</h5>
                <p class="mb-1 price-diskon-detail" ><b> Rp. {{number_format($detail_kaos->harga_awal)}} </b> </p>
            </div>

            <div class="produk-deskripsi mt-4">
                <h6 style="color:  #3152A4"><b> Deskripsi Produk </b> </h6>
                <p style="font-size: 14px"> {{$detail_kaos->deskripsi}} </p>
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
                            <img src="{{asset('storage/'.$merchandise_kaos->image_file)}}" width="100%" style="height: 100%; object-fit:cover; border-radius:1rem">
                        </div>
                        <div class="mx-2 mt-2" style="width: 255px">
                            <div class="titel">
                                <p class="card-title mb-0"> <b>Kaos Custom Exclusive by {{$merchandise_kaos->nama_siswa}} </b> </p>
                                <p class="mb-1 price-diskon" style="font-size: 24px"> <b> Rp. <span id="harga_awal"> {{number_format($detail_kaos->harga_awal) }} </span> </b> </p>
                            </div>
                        </div>
                        <div class="close">
                            <a style="color:gray; text-decoration:none" data-bs-dismiss="modal" ><i class="fa-solid fa-chevron-down"></i></a>
                        </div>
                    </div>

                    <div class="produk-jenis mt-3">
                        <h6 style="color: #3152A4"><b> Jenis </b> </h6>
                        <div class="d-flex">
                            @foreach ($jenis_kaos as $item)
                                <div class="button-jenis">
                                    <input class="form-check-input" type="radio" name="jenis_{{$detail_kaos->id}}" onclick="handleRadio('{{$detail_kaos->id}}')" id="jenis_{{$detail_kaos->id}}_{{$item->id}}" value="{{$item->id}}">
                                    <label class="form-check-label" for="jenis_{{$detail_kaos->id}}_{{$item->id}}">
                                    <span> {{$item->jenis}} </span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <span class="mb-0 text-danger" style="font-size: 10px; display: none" id="valid_jenis_{{$detail_kaos->id}}" > Pilih jenis terlebih dahulu! </span>
                    </div>

                    <div class="produk-lengan mt-3" id="produk_lengan">
                        <h6 style="color: #3152A4"><b> Lengan </b> </h6>
                        <div class="d-flex">
                            @foreach ($lengan_kaos as $item)
                                <div class="button-jenis">
                                    <input class="form-check-input" type="radio" name="lengan_{{$detail_kaos->id}}" id="lengan_{{$detail_kaos->id}}_{{$item->id}}" value="{{$item->id}}">
                                    <label class="form-check-label" for="lengan_{{$detail_kaos->id}}_{{$item->id}}">
                                    <span> {{$item->lengan}} </span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <span class="mb-0 text-danger" style="font-size: 10px; display: none" id="valid_lengan_{{$detail_kaos->id}}" > Pilih lengan baju terlebih dahulu! </span>

                    </div>

                    <div class="produk-warna mt-3">
                        <h6 style="color: #3152A4"><b> Warna </b> </h6>
                        <div class="d-flex">
                            @foreach ($warna_kaos as $item)
                                <div class="button-jenis">
                                    <input class="form-check-input" type="radio" name="warna_{{$detail_kaos->id}}" id="warna_{{$detail_kaos->id}}_{{$item->id}}" value="{{$item->id}}">
                                    <label class="form-check-label" for="warna_{{$detail_kaos->id}}_{{$item->id}}">
                                    <span> {{$item->warna}} </span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <span class="mb-0 text-danger" style="font-size: 10px; display: none" id="valid_warna_{{$detail_kaos->id}}" > Pilih warna terlebih dahulu! </span>
                    </div>

                    <div class="produk-kategori mt-3">
                        <h6 style="color: #3152A4"><b> Kategori </b> </h6>
                        <div class="d-flex">
                            @foreach ($kategori as $item)
                                <div class="button-jenis">
                                    <input class="form-check-input" type="radio" name="kategori_{{$detail_kaos->id}}" id="kategori_{{$detail_kaos->id}}_{{$item->id}}" value="{{$item->id}}">
                                    <label class="form-check-label" for="kategori_{{$detail_kaos->id}}_{{$item->id}}">
                                    <span> {{$item->kategori}} </span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <span class="mb-0 text-danger" style="font-size: 10px; display: none" id="valid_kategori_{{$detail_kaos->id}}" > Pilih lengan baju terlebih dahulu! </span>

                    </div>

                    <div class="produk-ukuran mt-3">
                        <h6 style="color: #3152A4"><b> Ukuran </b> </h6>
                        <div class="d-flex" id="ukuran_seragam">
                            @foreach($ukuran as $item)
                                <div class="button-ukuran">
                                    <input class="form-check-input" type="radio" name="ukuran_{{$detail_kaos->id}}"  id="uk_{{$item->ukuran_seragam}}_{{$detail_kaos->id}}" value="{{$item->ukuran_seragam}}">
                                    <label class="form-check-label" for="uk_{{$item->ukuran_seragam}}_{{$detail_kaos->id}}">
                                    <span>{{$item->ukuran_seragam}} </span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <span class="mb-0 text-danger" style="font-size: 10px; display: none" id="valid_ukuran_{{$detail_kaos->id}}" > Pilih ukuran terlebih dahulu! </span>
                        <span class="mb-0 text-danger" style="font-size: 10px; display: none" id="valid_stok" > Mohon Maaf Stok Tidak Ada! </span>
                    </div>

                    <div class="produk-jumlah my-4">
                        <h6 class="mt-1" style="color: #3152A4"><b> Jumlah </b> </h6>
                        <div class="input-group mx-3" style="border: none;">
                            <div class="button minus">
                                <button type="button" class="btn btn-outline-plus-minus btn-number" disabled="disabled" data-type="minus" data-field="quant[{{$merchandise_kaos->id}}]">
                                    <i class="fas fa-minus-circle"></i>
                                </button>
                            </div>
                            <input type="text" name="quant[{{$merchandise_kaos->id}}]" id="quant_{{$merchandise_kaos->id}}" class="input-number" value="1" min="1" max="10">
                            <div class="button plus">
                                <button type="button" class="btn btn-outline-plus-minus btn-number" data-type="plus" data-field="quant[{{$merchandise_kaos->id}}]">
                                    <i class="fas fa-plus-circle"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="produk-siswa d-flex">
                        <h6 class="mt-1" style="color: #3152A4; width: 150px;"><b> Nama Siswa </b> </h6>
                        <select id="nama_siswa" name="nama_siswa" class="select form-control form-control-sm px-3" required>
                            @foreach ($profile as $item)
                                <option value="{{ $item->nis }}" >{{ $item->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div> --}}

                    <div class="d-flex mt-3" style="justify-content: end">
                        <button type="button" class="btn btn-primary px-3 " onclick="addToCart('{{$merchandise_kaos->id}}', '{{$detail_kaos->id}}')" > <i class="fa-solid fa-plus"></i> Keranjang </button>
                        <form action="{{route('pre_order')}}" method="POST" id="po_now">
                            @csrf
                            <input type="hidden" name="data" id="data" value="">
                            <button type="button" class="btn btn-purple mx-2 px-3" onclick="pre_order('{{$merchandise_kaos->id}}', '{{$detail_kaos->id}}')" > Pre Order </button>
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

        var cart_now = $('#count_cart').html();
        var cart_num = parseInt(cart_now);

        function addToCart(id, merch_id) {
            var design_id = id;
            var merchandise_id = merch_id;
            var ukuran = $('input[name="ukuran_'+merchandise_id+'"]:checked').val();
            var jenis = $('input[name="jenis_'+merchandise_id+'"]:checked').val();
            var warna = $('input[name="warna_'+merchandise_id+'"]:checked').val();
            var quantity = $('.input-number').val();

                $.ajax({
                    url: "{{route('cart_post_merchandise')}}",
                    type: 'POST',
                    data: {
                        design_id : design_id,
                        merchandise_id : merchandise_id,
                        ukuran_id : ukuran,
                        jenis_id : jenis,
                        warna_id : warna,
                        quantity : quantity,
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

        function handleRadio(id) {
            var merch_id = id;
            var jenis = $('input[name="jenis_'+merch_id+'"]:checked').val();
            if (jenis == 1) {
                $('#produk_lengan').show()
            } else if (jenis == 2){
                $('#produk_lengan').hide()
                $('input[name="lengan_'+merch_id+'"]:checked').each(function(){
                    $(this).prop('checked', false)  
                });
            }
        }

        function submit_cart() {
            $('#cart_submit').submit();
        }

        var pesanan = []
        function pre_order(id, merch_id) {
            var new_pesanan = {};
            var design_id = id;
            var merch_id = merch_id;
            var ukuran = $('input[name="ukuran_'+merch_id+'"]:checked').val();
            var lengan = $('input[name="lengan_'+merch_id+'"]:checked').val();
            var warna = $('input[name="warna_'+merch_id+'"]:checked').val();
            var quantity = $('.input-number').val();

            if (ukuran == '' || ukuran == null || ukuran == undefined) {
                $('#valid_ukuran_'+merch_id).show();
            } else if (lengan == '' || lengan == null || lengan == undefined)  {
                $('#valid_lengan_'+merch_id).show();
            } else if (warna == '' || warna == null || warna == undefined)  {
                $('#valid_warna_'+merch_id).show();
            } else {
                $('#valid_ukuran_'+merch_id).hide(); 
                $('#valid_warna_'+merch_id).hide();
                $('#valid_lengan_'+merch_id).hide();

                new_pesanan['design_id'] = design_id;
                new_pesanan['merch_id'] = merch_id;
                new_pesanan['ukuran'] = ukuran;
                new_pesanan['lengan'] = lengan;
                new_pesanan['warna'] = warna;
                new_pesanan['quantity'] = quantity;

                pesanan.push(new_pesanan);
                $('#data').val(JSON.stringify(pesanan));
                $('#po_now').submit();

            }
        }

    </script>
@endsection
