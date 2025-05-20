@extends ('ortu.layouts.app')

@section('content')
    @include('ortu.palestine_day.top-navigate')
    <div class="container">
        <div class="center mb-3">
            <img src="{{ asset('assets/images/header_merchandise.jpg') }}" alt="katalog" style="border-radius: 0.4rem" width="100%">
        </div>
        <div class="d-grid-card">
            @if ($get_merch->count() > 0)
                @foreach ($get_merch as $item)
                        <a href="{{route('detail.merchandise', $item->id)}}" style="text-decoration: none">
                        <div class="card catalog mb-1">
                            <img src="{{ asset('storage/'.$item->image_1) }}" class="card-img-top" alt="palestine" style="max-height: 180px">
                            <div class="card-body pt-1">
                                <h6 class="card-title mb-0">{{$item->nama_produk}}</h6>
                                @if ($item->diskon == null || $item->diskon == 0)
                                    <p class="mb-2 price-diskon" ><b> Rp. {{number_format($item->harga_awal)}} </b> </p>
                                    <p class="mb-0" style="font-size: 10px">
                                        <span> <i class="fa-solid fa-paper-plane fa-sm"></i> Sekolah Rabbani </span> 
                                    </p>
                                @else 
                                    <p class="mb-0 price-diskon" ><b> Rp. {{number_format($item->harga_awal * (100-$item->diskon)/100)}} </b> </p>
                                    <p class="mb-1 price-normal"><s> Rp. {{number_format($item->harga_awal)}} </s> </p>
                                    <p class="mb-0" style="font-size: 10px"> Disc. 
                                        <span class="bg-danger p-1"> {{($item->diskon)}}% </span> 
                                        <span class="mx-2"> <i class="fa-solid fa-paper-plane fa-sm"></i> Sekolah Rabbani </span> 
                                    </p>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            @else
                <div class="center mt-5">
                    <h3 class="text-danger"> Kami lagi menyiapkan merchandise spesial, Mohon Menunggu yaa.. </h3>
                </div>
            @endif
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
         function submit_cart() {
            $('#cart_submit').submit();
        }
    </script>
@endsection
