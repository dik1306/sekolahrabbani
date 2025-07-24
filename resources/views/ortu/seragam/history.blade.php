@extends ('ortu.layouts.app')

@section('content')
    <div class="top-navigate sticky-top">
        <div class="d-flex" style="justify-content: stretch; width: 100%;">
            <a onclick="window.location.href='{{ route('dashboard') }}'; return false;" class="mt-1" style="text-decoration: none; color: black">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h4 class="mx-3"> Riwayat Transaksi </h4>
        </div>

        <nav class="mt-3">
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-seragam-tab" data-bs-toggle="tab" data-bs-target="#nav-seragam" type="button" role="tab" aria-controls="nav-seragam" aria-selected="true">Seragam</button>
                <button class="nav-link" id="nav-merch-tab" data-bs-toggle="tab" data-bs-target="#nav-merch" type="button" role="tab" aria-controls="nav-merch" aria-selected="false">Merchandise</button>
                <button class="nav-link" id="nav-jersey-tab" data-bs-toggle="tab" data-bs-target="#nav-jersey" type="button" role="tab" aria-controls="nav-jersey" aria-selected="false">Jersey</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active mb-5" id="nav-seragam" role="tabpanel" aria-labelledby="nav-seragam-tab" tabindex="0">
                @foreach ($order as $item)
                    <a href="{{route('seragam.history.detail', $item->no_pemesanan)}}" style="text-decoration: none">
                        <div class="card card-history mt-3">
                            <div class="card-header d-flex" style="justify-content: space-between; font-size: 12px">
                                <span class=""> No Pesanan </span>
                                <span > {{$item->no_pemesanan}} </span>
                            </div>
                            <div class="card-body d-flex">
                                <div class="frame-bayar">
                                    <img src="{{asset('assets/images/'.$item->image)}}" width="100%" style="height: 100%; object-fit:cover; border-radius:1rem">
                                </div>
                                <div class="d-flex mx-2">
                                    <div class="" style="width: 150px">
                                        <p class="mb-0" style="font-size: 14px;"> {{$item->nama_produk}} </p>
                                        <p class="mb-0 price-diskon"> <b> Rp. {{number_format((($item->total_harga))) }} </b> </p>
                                        <p class="mb-0" style="font-size: 8px">Waktu Pesan: {{$item->created_at}} </p>
                
                                    </div>
                                </div>
                                <div class="status" style="margin-left: auto">
                                    @if ($item->status == 'success')
                                        <span class="badge bg-success" style="font-size: 12px"> {{$item->status}} </span>
        
                                    @elseif($item->status == 'pending')
                                        <span class="badge bg-warning" style="font-size: 12px"> Menunggu </span>
        
                                    @elseif($item->status == 'cancel' || $item->status == 'failed' || $item->status == 'expired' )
                                        <span class="badge bg-danger" style="font-size: 12px"> Gagal </span>
                                        
                                    @endif
        
                                    {{-- <span class="badge bg-danger" style="font-size: 12px"> {{$item->status}} </span> --}}
        
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="tab-pane fade mb-5" id="nav-merch" role="tabpanel" aria-labelledby="nav-merch-tab" tabindex="0">
                @foreach ($order_detail_merch as $item)
                    <a href="{{route('merchandise.history.detail', $item->no_pesanan)}}" style="text-decoration: none">
                        <div class="card card-history mt-3">
                            <div class="card-header d-flex" style="justify-content: space-between; font-size: 12px">
                                <span class=""> No Pesanan </span>
                                <span > {{$item->no_pesanan}} </span>
                            </div>
                            <div class="card-body d-flex">
                                <div class="frame-bayar">
                                    <img src="{{asset('storage/'.$item->image_1)}}" width="100%" style="height: 100%; object-fit:cover; border-radius:1rem">
                                </div>
                                <div class="d-flex mx-2">
                                    <div class="" style="width: 150px">
                                        <p class="mb-0" style="font-size: 14px;"> {{$item->nama_produk}} </p>
                                        <p class="mb-0 price-diskon"> <b> Rp. {{number_format((($item->total_harga))) }} </b> </p>
                                        <p class="mb-0" style="font-size: 8px">Waktu Pesan: {{$item->created_at}} </p>
                
                                    </div>
                                </div>
                                <div class="status" style="margin-left: auto">
                                    @if ($item->status == 'success')
                                        <span class="badge bg-success" style="font-size: 12px"> {{$item->status}} </span>
        
                                    @elseif($item->status == 'pending')
                                        <span class="badge bg-warning" style="font-size: 12px"> Menunggu </span>
        
                                    @elseif($item->status == 'cancel' || $item->status == 'failed' || $item->status == 'expired' )
                                        <span class="badge bg-danger" style="font-size: 12px"> Gagal </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="tab-pane fade mb-5" id="nav-jersey" role="tabpanel" aria-labelledby="nav-jersey-tab" tabindex="0">
                @foreach ($order_jersey as $item)
                    <a href="{{route('jersey.history.detail', $item->no_pesanan)}}" style="text-decoration: none">
                        <div class="card card-history mt-3">
                            <div class="card-header d-flex" style="justify-content: space-between; font-size: 12px">
                                <span class=""> No Pesanan </span>
                                <span > {{$item->no_pesanan}} </span>
                            </div>
                            <div class="card-body d-flex">
                                <div class="frame-bayar">
                                    <img src="{{asset('storage/'.$item->image_1)}}" width="100%" style="height: 100%; object-fit:cover; border-radius:1rem">
                                </div>
                                <div class="d-flex mx-2">
                                    <div class="" style="width: 150px">
                                        <p class="mb-0" style="font-size: 14px;"> {{$item->nama_jersey}} </p>
                                        <p class="mb-0 price-diskon"> <b> Rp. {{number_format((($item->total_harga))) }} </b> </p>
                                        <p class="mb-0" style="font-size: 8px">Waktu Pesan: {{$item->created_at}} </p>
                
                                    </div>
                                </div>
                                <div class="status" style="margin-left: auto">
                                    @if ($item->status == 'success')
                                        <span class="badge bg-success" style="font-size: 12px"> {{$item->status}} </span>
        
                                    @elseif($item->status == 'pending')
                                        <span class="badge bg-warning" style="font-size: 12px"> Menunggu </span>
        
                                    @elseif($item->status == 'cancel' || $item->status == 'failed' || $item->status == 'expired' )
                                        <span class="badge bg-danger" style="font-size: 12px"> Gagal </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
           
        </div>
{{-- 
        <div class="d-flex mt-1" style="justify-content: space-evenly">
            <div class="toggle-1">
                <input type="radio" class="btn-check" name="history_order" id="option_seragam" autocomplete="off" checked>
                <label class="btn btn-sm" for="option_seragam" onclick="history_seragam()">Seragam</label>
            </div>

            <div class="toggle-2">
                <input type="radio" class="btn-check" name="history_order" id="option_merch" autocomplete="off">
                <label class="btn btn-sm" for="option_merch" onclick="history_merchandise()">Merchandise</label>
            </div>

            <div class="toggle-3">
                <input type="radio" class="btn-check" name="history_order" id="option_jersey" autocomplete="off">
                <label class="btn btn-sm" for="option_jersey" onclick="history_jersey()">Jersey</label>
            </div>
        </div> --}}

    </div>
    @include('ortu.footer.index')
@endsection