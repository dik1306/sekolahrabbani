@extends ('ortu.layouts.app')

@section('content')
    @include('ortu.jersey.top-navigate')
    <div id="image-carousel" class="carousel slide px-0">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#image-carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#image-carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#image-carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#image-carousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
            <button type="button" data-bs-target="#image-carousel" data-bs-slide-to="4" aria-label="Slide 5"></button>
            <button type="button" data-bs-target="#image-carousel" data-bs-slide-to="5" aria-label="Slide 6"></button>
            <button type="button" data-bs-target="#image-carousel" data-bs-slide-to="6" aria-label="Slide 7"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="img-detail-card" src="{{ asset('storage/'.$produk->image_1) }}" alt="{{$produk->image_1}}">
            </div>

            <div class="carousel-item">
                <img class="img-detail-card" src="{{ asset('storage/'.$produk->image_2) }}" alt="{{$produk->image_2}}">
            </div>

            <div class="carousel-item">
                <img class="img-detail-card" src="{{ asset('storage/'.$produk->image_3) }}" alt="{{$produk->image_3}}">
            </div>

            <div class="carousel-item">
                <img class="img-detail-card" src="{{ asset('storage/'.$produk->image_4) }}" alt="{{$produk->image_4}}">
            </div>

            <div class="carousel-item">
                <img class="img-detail-card" src="{{ asset('storage/'.$produk->image_5) }}" alt="{{$produk->image_5}}">
            </div>

            <div class="carousel-item">
                <img class="img-detail-card" src="{{ asset('storage/'.$produk->image_6) }}" alt="{{$produk->image_6}}">
            </div>

            @if ($produk->ekskul_id != 5)
                <div class="carousel-item">
                    <img class="img-detail-card" src="{{ asset('storage/'.$produk->image_7) }}" alt="{{$produk->image_7}}">
                </div>
            @endif
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
            <div class="produk-title">
                <h5 class="card-title mb-0">{{$produk->nama_jersey}}</h5>
                @if ($produk->ekskul_id == '5')
                    <p class="mb-1 price-diskon-detail" ><b> Rp. {{number_format($produk->harga_awal - ($produk->persen_diskon/100 * $produk->harga_awal))}}/kaos </b> </p>
                @else
                    <p class="mb-1 price-diskon-detail" ><b> Rp. {{number_format($produk->harga_awal - ($produk->persen_diskon/100 * $produk->harga_awal))}}/set </b> </p>
                @endif
                <p class="mb-0" style="font-size: 16px"> Discount 
                    <span class="bg-danger py-1 px-2"> {{($produk->persen_diskon)}}% </span>
                    <span class="mx-2" style="color: gray"> <s> Rp. {{number_format($produk->harga_awal)}} </s> </span>
                </p>
            </div>

            <div class="produk-deskripsi mt-4">
                <h6 style="color:  #3152A4"><b> Deskripsi Produk </b> </h6>
                <p style="font-size: 14px"> {{$produk->deskripsi}} </p>
            </div> 
        </div>
    </div>

    <div class="bottom-navigate sticky-bottom">
        <div class="d-flex" style="justify-content: end">
            <a href="#" class="btn btn-primary px-3" data-bs-toggle="modal" data-bs-target="#pre_order_jersey" > <i class="fa-solid fa-plus"></i> Keranjang </a>
            <a href="#" class="btn btn-purple mx-2 px-3" data-bs-toggle="modal" data-bs-target="#pre_order_jersey" > Pre Order </a>
        </div>
    </div>


    <div class="modal fade" id="pre_order_jersey" tabindex="-1" role="dialog" aria-labelledby="po" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="align-items: flex-end">
            <div class="modal-content animate-bottom ">
                <div class="modal-body">
                    <div class="d-flex mx-1" style="justify-content: space-between">
                        <div class="frame">
                            <img src="{{asset('storage/'.$produk->image_1)}}" width="100%" style="height: 100%; object-fit:cover; border-radius:1rem">
                        </div>
                        <div class="mx-2 mt-2" style="width: 255px">
                            <div class="titel">
                                <p class="card-title mb-0"> <b> {{$produk->nama_jersey}} </b> </p>
                                @if ($produk->ekskul_id == '5')
                                    <p class="mb-1 price-diskon" style="font-size: 24px"> <b> Rp. <span id="harga_awal"> {{number_format($produk->harga_awal - ($produk->persen_diskon/100 * $produk->harga_awal)) }}/kaos </span> </b> </p>
                                @else
                                    <p class="mb-1 price-diskon" style="font-size: 24px"> <b> Rp. <span id="harga_awal"> {{number_format($produk->harga_awal - ($produk->persen_diskon/100 * $produk->harga_awal)) }}/set </span> </b> </p>
                                @endif
                                <p class="mb-1" style="font-size: 13px"> Discount 
                                    <span class="bg-danger py-1 px-2" id="diskon_persen"> {{($produk->persen_diskon)}}% </span>
                                    <span class="mx-2" style="color: gray"> <s> Rp. <span id="harga_awal"> {{number_format($produk->harga_awal)}} </span> </s> </span>
                                </p>
                            </div>
                        </div>
                        <div class="close">
                            <a style="color:gray; text-decoration:none" data-bs-dismiss="modal" ><i class="fa-solid fa-chevron-down"></i></a>
                        </div>
                    </div>

                    @if ($role_id != 7)
                        <div class="produk mt-3">
                            <h6 style="color: #3152A4"><b> Nama Siswa </b> </h6>
                            <div class="d-flex" style="flex-direction: column">
                                @foreach ($profile as $item)
                                <div class="button-karya mt-1">
                                    <input class="form-check-input" type="radio" name="nama_siswa" id="nama_siswa_{{$item->nis}}" value="{{$item->nis}}">
                                    <label class="form-check-label" for="nama_siswa_{{$item->nis}}">
                                    <span class="px-2" style="font-size: 10px"> {{$item->nama_lengkap}} </span>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            <span class="mb-0 text-danger" style="font-size: 10px; display: none" id="valid_nis" > Pilih nama siswa terlebih dahulu! </span>
                        </div>
                    @endif
                    

                        @if ($produk->ekskul_id == 1 || $produk->ekskul_id == 2)
                            <div class="produk-no-punggung mt-3">
                                <div class="d-flex">
                                    <h6 style="color: #3152A4"><b> Nomor Punggung </b> </h6>
                                    <input type="text" name="no_punggung" id="no_punggung" class="input-number mx-2" min="1" max="100">
                                </div>
                                <span class="mb-0 text-danger" style="font-size: 10px; display: none" id="valid_no_punggung" > Isi No Punggung terlebih dahulu! </span>

                            </div>

                            <div class="produk-nama-punggung mt-3">
                                <div class="d-flex">
                                    <h6 style="color: #3152A4"><b> Nama Punggung </b> </h6>
                                    <input type="text" name="nama_punggung" id="nama_punggung" maxlength="10" class="input-nama-punggung mx-3 px-2" maxlength="30">
                                </div>
                                <span class="mb-0 text-danger" style="font-size: 10px; display: none" id="valid_nama_punggung" > Isi Nama Punggung terlebih dahulu! </span>

                            </div>
                        @endif


                    <input type="hidden" id="role_id" value="{{$role_id}}">

                    <div class="produk-ukuran mt-3">
                        <h6 style="color: #3152A4"><b> Ukuran </b> </h6>
                        <div class="d-flex">
                            @if ($produk->ekskul_id == '1' && $produk->jenjang_id == '4' || $produk->ekskul_id == '2' && $produk->jenjang_id == '4' && $produk->jenis_kelamin =='P')
                                @foreach($ukuran_futsal_sd as $item)
                                    <div class="button-ukuran">
                                        <input class="form-check-input" type="radio" name="ukuran"  id="uk_{{$item->id}}" value="{{$item->id}}">
                                        <label class="form-check-label" for="uk_{{$item->id}}">
                                        <span>{{$item->ukuran_seragam}} </span>
                                        </label>
                                    </div>
                                @endforeach
                            @elseif ($produk->ekskul_id == '2' && $produk->jenjang_id == '4' && $produk->jenis_kelamin =='L')
                                @foreach($ukuran_basket_sd_l as $item)
                                    <div class="button-ukuran">
                                        <input class="form-check-input" type="radio" name="ukuran"  id="uk_{{$item->id}}" value="{{$item->id}}">
                                        <label class="form-check-label" for="uk_{{$item->id}}">
                                        <span>{{$item->ukuran_seragam}} </span>
                                        </label>
                                    </div>
                                @endforeach
                            @elseif ($produk->ekskul_id == '3' && $produk->jenjang_id == '4' && $produk->jenis_kelamin =='P')
                                @foreach($ukuran_badminton_sd_p as $item)
                                    <div class="button-ukuran">
                                        <input class="form-check-input" type="radio" name="ukuran"  id="uk_{{$item->id}}" value="{{$item->id}}">
                                        <label class="form-check-label" for="uk_{{$item->id}}">
                                        <span>{{$item->ukuran_seragam}} </span>
                                        </label>
                                    </div>
                                @endforeach
                            @elseif ($produk->ekskul_id == '3' && $produk->jenjang_id =='4' && $produk->jenis_kelamin == 'L')
                                @foreach($ukuran_badminton_sd_l as $item)
                                    <div class="button-ukuran">
                                        <input class="form-check-input" type="radio" name="ukuran"  id="uk_{{$item->id}}" value="{{$item->id}}">
                                        <label class="form-check-label" for="uk_{{$item->id}}">
                                        <span>{{$item->ukuran_seragam}} </span>
                                        </label>
                                    </div>
                             @endforeach
                            @elseif ($produk->ekskul_id == '5' && $produk->jenjang_id == '4' && $produk->jenis_kelamin =='L')
                                @foreach($ukuran_memanah_sd_l as $item)
                                    <div class="button-ukuran">
                                        <input class="form-check-input" type="radio" name="ukuran"  id="uk_{{$item->id}}" value="{{$item->id}}">
                                        <label class="form-check-label" for="uk_{{$item->id}}">
                                        <span>{{$item->ukuran_seragam}} </span>
                                        </label>
                                    </div>
                                @endforeach
                            @elseif ($produk->ekskul_id == '5' && $produk->jenjang_id == '4' && $produk->jenis_kelamin =='P')
                                @foreach($ukuran_memanah_sd_p as $item)
                                    <div class="button-ukuran">
                                        <input class="form-check-input" type="radio" name="ukuran"  id="uk_{{$item->id}}" value="{{$item->id}}">
                                        <label class="form-check-label" for="uk_{{$item->id}}">
                                        <span>{{$item->ukuran_seragam}} </span>
                                        </label>
                                    </div>
                                @endforeach
                            @else 
                                @foreach($ukuran as $item)
                                    <div class="button-ukuran">
                                        <input class="form-check-input" type="radio" name="ukuran"  id="uk_{{$item->id}}" value="{{$item->id}}">
                                        <label class="form-check-label" for="uk_{{$item->id}}">
                                        <span>{{$item->ukuran_seragam}} </span>
                                        </label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <span class="mb-0 text-danger" style="font-size: 10px; display: none" id="valid_ukuran_{{$produk->id}}" > Pilih ukuran terlebih dahulu! </span>
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

                    <div class="d-flex mt-3" style="justify-content: end">
                        <button type="button" class="btn btn-primary px-3 " onclick="addToCart('{{$produk->id}}')" > <i class="fa-solid fa-plus"></i> Keranjang </button>
                        <form action="{{route('pre_order.jersey')}}" method="POST" id="po_jersey">
                            @csrf
                            <input type="hidden" name="data" id="data" value="">
                            <button type="button" class="btn btn-purple mx-2 px-3" onclick="pre_order('{{$produk->id}}')" > Pre Order (14 Hari) </button>
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

        
        var url = 'http://sekolahrabbani.test/'
        // var url = 'https://sekolahrabbani.sch.id/'

        var cart_now = $('#count_cart').html();
        var cart_num = parseInt(cart_now);
        function addToCart(id) {
            var item_id = id;
            var quantity = $('#quant_'+id).val();
            var role_id = $('#role_id').val();
            var ukuran = $('input[name="ukuran"]:checked').val();
            var nis = $('input[name="nama_siswa"]:checked').val();
            var nama_punggung = $('#nama_punggung').val() != undefined ? $('#nama_punggung').val() : '-';
            var no_punggung = $('#no_punggung').val() != undefined ? $('#no_punggung').val() : '-';

            if (role_id == 7) {
                nis = '0000';
            }

            if (nis == '' || nis == null || nis == undefined) {
                $('#valid_nis').show();
            } else if (no_punggung == '') {
                $('#valid_no_punggung').show();
            } else if (nama_punggung == '') {
                $('#valid_nama_punggung').show();
            } else if (ukuran == '' || ukuran == null || ukuran == undefined) {
                $('#valid_ukuran_'+item_id).show();
            } else {
                $('#valid_ukuran_'+item_id).hide();
                $('#valid_nis').hide();

                $.ajax({
                    url: "{{route('cart_post_jersey')}}",
                    type: 'POST',
                    data: {
                        produk_id : item_id,
                        quantity : quantity,
                        nis : nis,
                        nama_punggung : nama_punggung,
                        no_punggung : no_punggung,
                        ukuran : ukuran,
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

                $('#pre_order_jersey').modal('hide')
            }    
        }

        function submit_cart() {
            $('#cart_submit').submit();
        }

        var pesanan = []
        function pre_order(id) {
            var new_pesanan = {};
            var item_id = id;
            var quantity = $('#quant_'+id).val();
            var role_id = $('#role_id').val();
            var ukuran = $('input[name="ukuran"]:checked').val();
            var nis = $('input[name="nama_siswa"]:checked').val();
            var nama_punggung = $('#nama_punggung').val() != undefined ? $('#nama_punggung').val() : '-';
            var no_punggung = $('#no_punggung').val() != undefined ? $('#no_punggung').val() : '-';

            if (role_id == 7) {
                nis = '0000';
            }

            if (nis == '' || nis == null || nis == undefined)  {
                $('#valid_nis').show();
            } else if (no_punggung == '') {
                $('#valid_no_punggung').show();
            } else if (nama_punggung == '') {
                $('#valid_nama_punggung').show();
            } else if (ukuran == '' || ukuran == null || ukuran == undefined ) {
                $('#valid_ukuran_'+item_id).show();
            } else {
                $('#valid_ukuran_'+item_id).hide(); 
                $('#valid_nis').hide();

                new_pesanan['jersey_id'] = item_id;
                new_pesanan['quantity'] = quantity;
                new_pesanan['ukuran'] = ukuran;
                new_pesanan['nama_punggung'] = nama_punggung;
                new_pesanan['no_punggung'] = no_punggung;
                new_pesanan['nis'] = nis;

                pesanan.push(new_pesanan);
                $('#data').val(JSON.stringify(pesanan));
                $('#po_jersey').submit();
                $('#pre_order').modal('hide');
            }
        }

    </script>
@endsection
