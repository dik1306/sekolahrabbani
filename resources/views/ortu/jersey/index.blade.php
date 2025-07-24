@extends ('ortu.layouts.app')

@section('content')    
    <div class="top-navigate sticky-top">
        <div class="d-flex" style="justify-content: stretch; width: 100%;">
            <a onclick="window.location.href='{{ route('dashboard') }}'; return false;" class="mt-1" style="text-decoration: none; color: black">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h4 class="mx-2"> Belanja </h4>
            <div class="input-group mx-2" style="width: 100% !important; max-height: 30px">
                <span class="input-group-text" style="max-height: 26px"><i class="fa fa-search fa-xs"></i></span>
                <input class="form-control form-control-sm shadow-none" id="search" style="border: none; font-size: 0.675rem" placeholder="Cari" type="text" name="search" >
            </div>
            {{-- <div class="py-1">
                <svg class="icon-32 mx-1" width="30" viewBox="0 2 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="color: #704996" onclick="filter_modal()"> 
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.56517 3C3.70108 3 3 3.71286 3 4.5904V5.52644C3 6.17647 3.24719 6.80158 3.68936 7.27177L8.5351 12.4243L8.53723 12.4211C9.47271 13.3788 9.99905 14.6734 9.99905 16.0233V20.5952C9.99905 20.9007 10.3187 21.0957 10.584 20.9516L13.3436 19.4479C13.7602 19.2204 14.0201 18.7784 14.0201 18.2984V16.0114C14.0201 14.6691 14.539 13.3799 15.466 12.4243L20.3117 7.27177C20.7528 6.80158 21 6.17647 21 5.52644V4.5904C21 3.71286 20.3 3 19.4359 3H4.56517Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    </path>                                
                </svg>                            
            </div> --}}
            <form action="{{route('jersey.cart')}}" method="GET" class="mt-1 mb-0" id="cart_submit">
                <a href="#"  onclick="submit_cart()" style="text-decoration: none; color: black">
                    @if ($cart_detail->count() > 0)
                        <i class="fa-solid fa-cart-shopping fa-xl" style="color: #704996"> <span id="count_cart" class="count-cart py-1" >{{$cart_detail->count()}}</span> </i>
                    @else 
                        <i class="fa-solid fa-cart-shopping fa-xl" style="color: #704996"> <span id="count_cart" class="count-cart py-1" style="display:none;" > {{$cart_detail->count()}} </span> </i>
                    @endif
                </a>
            </form>
        </div>
    </div>
    <div class="container">
        <div class="row mx-auto" id="card_main_seragam">       
            <div class="col-md">
                <div class="center mb-3">
                    <img src="{{ asset('assets/images/header_futsal.png') }}" alt="katalog" style="border-radius: 0.4rem" width="100%">
                </div>

                <div class="d-grid-card">
                    @foreach ($jersey_futsal as $item)
                        <a href="{{route('jersey.detail', $item->id)}}" style="text-decoration: none">
                            <div class="card catalog mb-1">
                                <img src="{{ asset('storage/'.$item->image_1) }}" class="card-img-top" alt="{{$item->image_1}}" style="max-height: 180px">
                                <div class="card-body pt-1 px-2">
                                    <h6 class="card-title mb-0">{{$item->nama_jersey}}</h6>
                                    <p class="mb-0 price-diskon" ><b> Rp. {{number_format($item->harga_awal * ((100-$item->persen_diskon)/100))}}/set </b> </p>
                                    <p class="mb-1 price-normal"><s> Rp. {{number_format($item->harga_awal)}} </s> </p>
                                    <p class="mb-0" style="font-size: 9px"> Disc. 
                                        <span class="bg-danger p-1"> {{($item->persen_diskon)}}% </span> 
                                        <span class="mx-1"> <i class="fa-solid fa-paper-plane fa-sm"></i> Sekolah Rabbani </span> 
                                    </p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="center my-3">
                    <img src="{{ asset('assets/images/header_badminton.png') }}" alt="katalog" style="border-radius: 0.4rem" width="100%">
                </div>

                <div class="d-grid-card">
                    @foreach ($jersey_badminton as $item)
                        <a href="{{route('jersey.detail', $item->id)}}" style="text-decoration: none">
                            <div class="card catalog mb-1">
                                <img src="{{ asset('storage/'.$item->image_1) }}" class="card-img-top" alt="{{$item->image_1}}" style="max-height: 180px">
                                <div class="card-body pt-1 px-2">
                                    <h6 class="card-title mb-0">{{$item->nama_jersey}}</h6>
                                    <p class="mb-0 price-diskon" ><b> Rp. {{number_format($item->harga_awal * ((100-$item->persen_diskon)/100))}}/set </b> </p>
                                    <p class="mb-1 price-normal"><s> Rp. {{number_format($item->harga_awal)}} </s> </p>
                                    <p class="mb-0" style="font-size: 9px"> Disc. 
                                        <span class="bg-danger p-1"> {{($item->persen_diskon)}}% </span> 
                                        <span class="mx-1"> <i class="fa-solid fa-paper-plane fa-sm"></i> Sekolah Rabbani </span> 
                                    </p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="center my-3">
                    <img src="{{ asset('assets/images/header_basket.png') }}" alt="katalog" style="border-radius: 0.4rem" width="100%">
                </div>

                <div class="d-grid-card">
                    @foreach ($jersey_basket as $item)
                        <a href="{{route('jersey.detail', $item->id)}}" style="text-decoration: none">
                            <div class="card catalog mb-1">
                                <img src="{{ asset('storage/'.$item->image_1) }}" class="card-img-top" alt="{{$item->image_1}}" style="max-height: 180px">
                                <div class="card-body pt-1 px-2">
                                    <h6 class="card-title mb-0">{{$item->nama_jersey}}</h6>
                                    <p class="mb-0 price-diskon" ><b> Rp. {{number_format($item->harga_awal * ((100-$item->persen_diskon)/100))}}/set </b> </p>
                                    <p class="mb-1 price-normal"><s> Rp. {{number_format($item->harga_awal)}} </s> </p>
                                    <p class="mb-0" style="font-size: 9px"> Disc. 
                                        <span class="bg-danger p-1"> {{($item->persen_diskon)}}% </span> 
                                        <span class="mx-1"> <i class="fa-solid fa-paper-plane fa-sm"></i> Sekolah Rabbani </span> 
                                    </p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="center my-3">
                    <img src="{{ asset('assets/images/header_memanah.png') }}" alt="katalog" style="border-radius: 0.4rem" width="100%">
                </div>

                <div class="d-grid-card">
                    @foreach ($jersey_memanah as $item)
                        <a href="{{route('jersey.detail', $item->id)}}" style="text-decoration: none">
                            <div class="card catalog mb-1">
                                <img src="{{ asset('storage/'.$item->image_1) }}" class="card-img-top" alt="{{$item->image_1}}" style="max-height: 180px">
                                <div class="card-body pt-1 px-2">
                                    <h6 class="card-title mb-0">{{$item->nama_jersey}}</h6>
                                    <p class="mb-0 price-diskon" ><b> Rp. {{number_format($item->harga_awal * ((100-$item->persen_diskon)/100))}}/kaos </b> </p>
                                    <p class="mb-1 price-normal"><s> Rp. {{number_format($item->harga_awal)}} </s> </p>
                                    <p class="mb-0" style="font-size: 9px"> Disc. 
                                        <span class="bg-danger p-1"> {{($item->persen_diskon)}}% </span> 
                                        <span class="mx-1"> <i class="fa-solid fa-paper-plane fa-sm"></i> Sekolah Rabbani </span> 
                                    </p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <br>
                <br>
            </div>
        </div>

        <div class="row mx-auto" id="card_second" style="display: none" >
            <div class="col-md">
                <div class="d-grid-card" id="card_search">

                </div>
            </div>
        </div>
    </div>
@include('ortu.footer.index')

    <div class="modal fade" id="modal_filter" tabindex="-1" role="dialog" aria-labelledby="filter_skarang" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="align-items: flex-end">
            <div class="modal-content animate-bottom ">
                <div class="modal-header">
                    <h6> Filter </h6>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <label> Jenjang </label>
                        <div class=" filter">
                            <select name="jenjang_filter" id="jenjang_filter" class="select form-control form-control-sm" aria-label=".form-select-sm" style="font-size: 10px">
                                <option class="text-center" value="" selected>--Jenjang-- </option>
                                @foreach ($jenjang as $item)
                                    <option value="{{ $item->value }}" >{{ $item->nama_jenjang }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex mt-3" style="justify-content: end">
                            <button class="btn btn-primary btn-sm px-3" style="font-size: 11px" onclick="apply_filter()">Apply</button>
                            <a href="{{route('seragam')}}" class="btn btn-dim btn-outline-danger btn-sm px-3 mx-1" style="font-size: 11px; border-radius: 1rem">Reset</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function submit_cart() {
            $('#cart_submit').submit();
        }

        $('#search').on('keyup', function(){
            search();
        });
        search();

        function search() {
            var keyword = $('#search').val();

            $.ajax({
                url: "{{route('seragam.search')}}",
                type: 'POST',
                data: {
                    keyword : keyword,
                    _token: '{{csrf_token()}}'
                },
                success: function (result) {
                    if (result.message == 'not') {
                        $('#card_main_seragam').show();
                        $('#card_second').hide();
                        $('#card_search').hide();
                    } else if (result.message == 'success') {
                        $('#card_search').show();
                        $('#card_search').html(result.output);
                        $('#card_second').show();
                        $('#card_main_seragam').hide();
                    }
                }
            })
        }

        function filter_modal(){
            $('#modal_filter').modal('show')
        }

        function apply_filter(){
            var jenjang = $('#jenjang_filter').val();
            var jenis = $('#jenis_filter').val();

            $.ajax({
                url: "{{route('seragam.filter')}}",
                type: 'POST',
                data: {
                    jenjang : jenjang,
                    jenis : jenis,
                    _token: '{{csrf_token()}}'
                },
                success: function (result) {
                    if (result.message == 'not') {
                        $('#card_main_seragam').show();
                        $('#card_second').hide();
                        $('#card_search').hide();
                    } else if (result.message == 'success') {
                        $('#card_search').show();
                        $('#card_search').html(result.output);
                        $('#card_second').show();
                        $('#card_main_seragam').hide();
                        $('#modal_filter').modal('hide');
                    }
                }
            })
        }
    </script>
@endsection
