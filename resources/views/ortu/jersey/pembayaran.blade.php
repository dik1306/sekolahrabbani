@extends ('ortu.layouts.app')

@section('content')
    <div class="top-navigate sticky-top">
        <div class="d-flex" style="justify-content: stretch; width: 100%;">
            <a onclick="window.history.go(-1); return false;" class="mt-1" style="text-decoration: none; color: black">
                <i class="fa-solid fa-arrow-left fa-lg"></i>
            </a>
            <h4 class="mx-3"> Pembayaran </h4>
        </div>
    </div>
    
    @if ($order)
        <?php $harga = (($jersey->harga_awal) - ($jersey->persen_diskon/100 * $jersey->harga_awal)) * $quantity; ?>
        <?php $diskon =  ($jersey->persen_diskon/100 * $jersey->harga_awal) * $quantity; ?>
        <?php $diskon_persen =  ($jersey->persen_diskon); ?>
        <?php $harga_awal = $jersey->harga_awal * $quantity; ?>
        <input type="hidden" id="harga" value="{{$harga}}">
        <input type="hidden" id="harga_awal" value="{{$harga_awal}}">
        <input type="hidden" id="diskon" value="{{$diskon}}">
        <input type="hidden" id="diskon_persen" value="{{$diskon_persen}}">
        <input type="hidden" id="hpp" value="{{$jersey->hpp}}">
        <input type="hidden" id="ppn" value="{{$jersey->ppn}}">
        <input type="hidden" id="quantity" value="{{$quantity}}">
        <input type="hidden" id="ukuran" value="{{$ukuran->ukuran_seragam}}">
        <input type="hidden" id="jersey_id" value="{{$jersey->id}}">
        <input type="hidden" id="nis" value="{{$nis}}">
        <input type="hidden" id="nama_punggung" value="{{$nama_punggung}}">
        <input type="hidden" id="no_punggung" value="{{$no_punggung}}">

        <div class="container pt-0">
            <div class="row-card mx-1">
                <div class="frame-bayar">
                    <img src="{{asset('storage/'.$jersey->image_1)}}" width="100%" style="height: 100%; object-fit:cover; border-radius:1rem">
                </div>

                <div class="d-flex mx-2">
                    <div class="" style="width: 200px">
                        <p class="mb-0" style="font-size: 14px;"> {{$jersey->nama_jersey}} </p>
                        @if ($jersey->ekskul_id == '5')
                        <p class="mb-0 price-diskon"> <b> Rp. {{number_format($harga) }}/kaos </b> </p>
                        @else
                        <p class="mb-0 price-diskon"> <b> Rp. {{number_format($harga) }}/set </b> </p>
                        @endif
                        <p class="mb-0" style="color: gray; font-size: 10px"> <s> Rp. {{number_format($harga_awal)}} </s> </p>     
                        <p class="mb-0" style="font-size: 10px">Quantity: {{$quantity}}, Size: {{$ukuran->ukuran_seragam}} </p>
                        @if (auth()->user()->id_role != 7)
                            <p class="mb-0" style="font-size: 10px">Sekolah: {{$profile->sublokasi}}, Kelas: {{$profile->nama_kelas}} </p>
                        @else 
                            <p class="mb-0" style="font-size: 10px">Sekolah: {{$profile->sublokasi}} </p>
                        @endif
                        @if ($jersey->ekskul_id == 1 || $jersey->ekskul_id == 2)
                                <p class="mb-1" style="font-size: 10px">Nama Punggung: {{$nama_punggung}}, No Punggung: {{$no_punggung}} </p>
                            @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <p class="px-2 mb-0" style="background-color:#f5f5f5; font-size: 12px" > 
                <i class="fa-solid fa-money-bill" style="color: #624F8F"></i> 
                &nbsp; <b> Rincian Bayar </b> 
            </p>
            <div class="rincian-bayar px-2" style="color: gray">
                <span > Subtotal Produk </span>
                <span > Rp. {{number_format($harga_awal)}} </span>
            </div>
            <div class="rincian-bayar px-2" style="color: gray">
                <span > Total Diskon </span>
                <span >- Rp. {{number_format($diskon)}} </span>
            </div>
            <div class="rincian-bayar px-2">
                <span >  <b> Total Pembayaran </b> </span>
                <span style="color: #FF419C"> <b> Rp. {{number_format($harga)}} </b> </span>
            </div>
        </div>

        <div style="font-size: 9px; background-color: #f5f5f5">
            <span class="px-2"> <strong> Syarat & Ketentuan </strong> </span>
            <ol type="1">
                <li>No punggung didapatkan dari ekskul masing-masing <i>(khusus futsal dan basket) </i></li>
                <li>Setelah Pembayaran, Order tidak bisa cancel dan refund</li>
                <li>Tidak bisa ganti size</li>
                <li>Tidak bisa ganti No. Punggung dan Nama Punggung <i>(khusus futsal dan basket) </i></li>
                <li>Penerimaan jersey oleh orangtua :

                    <br>- jika memesan di pekan ke-1 dan 2, maka akan diterima di pekan ke-2 bulan
                    selanjutnya

                    <br>- jika memesan di pekan ke-3 dan 4, maka akan diterima di pekan ke-2  2 bulan
                    selanjutnya</li>
            </ol>
        </div>

        <div class="bottom-navigate mt-3" style="background-color: #f5f5f5">
            <div class="d-flex" >
                <input type="checkbox" id="checklist-sk" name="checklist-sk" class="mx-1" onclick="oncheck()" >
                <a href="#" style="font-size: 10px; color: #624F8F;" data-bs-toggle="modal" data-bs-target="#privacy_policy"> Syarat dan Ketentuan </a>
            </div>
            <div class="p-2 d-flex" style="justify-content: space-between">
                <h6> Total Pembayaran <br> <b> Rp. <span id="total_bayar"> {{number_format($harga)}} </span> </b> </h6>
                <input type="hidden" value="{{$harga}}" id="total_akhir" >
                <button id="pay-button" type="submit" class="btn btn-purple btn-sm px-4" onclick="bayar_jersey()" style="letter-spacing: 1px" disabled> <b>Bayar</b> </button>
            </div>
        </div>
    @else 
        <?php $total_awal = 0; ?>
        <?php $total_diskon = 0; ?>
        <?php $total_akhir = 0; ?>
        <div class="container">
            @foreach ($cart_detail as $item)
                <div class="row-card mx-1">
                    <div class="frame-bayar">
                        <img src="{{asset('storage/'.$item->image_1)}}" width="100%" style="height: 100%; object-fit:cover; border-radius:1rem">
                    </div>

                    <div class="d-flex mx-2">
                        <div class="" style="width: 200px">
                            <p class="mb-0" style="font-size: 14px;"> {{$item->nama_jersey}} </p>
                            @if ($item->ekskul_id == '5')
                            <p class="mb-0 price-diskon"> <b> Rp. {{number_format((($item['harga_awal']) - ($item['persen_diskon']/100 * $item['harga_awal'])) * $item['quantity']) }}/kaos </b> </p>
                            @else
                            <p class="mb-0 price-diskon"> <b> Rp. {{number_format((($item['harga_awal']) - ($item['persen_diskon']/100 * $item['harga_awal'])) * $item['quantity']) }}/set </b> </p>
                            @endif
                            <p class="mb-0" style="color: gray; font-size: 10px"> <s> Rp. {{number_format($item->harga_awal * $item['quantity'])}} </s> </p>     
                            <p class="mb-0" style="font-size: 10px">Quantity: {{$item['quantity']}}, Size: {{$item['ukuran_seragam']}} </p>
                            @if (auth()->user()->id_role != 7)
                                <p class="mb-0" style="font-size: 10px">Sekolah: {{$item['sublokasi']}}, Kelas: {{$item['nama_kelas']}} </p>
                            @else 
                                <p class="mb-0" style="font-size: 10px">Sekolah: {{$profile->sublokasi}} </p>
                            @endif
                            @if ($item->ekskul_id == 1 || $item->ekskul_id == 2)
                                <p class="mb-1" style="font-size: 10px">Nama Punggung: {{$item['nama_punggung']}}, No Punggung: {{$item['no_punggung']}} </p>
                            @endif
                        </div>
                    </div>
                </div>
            <?php $total_awal += (($item['harga_awal'] * $item['quantity']) ); ?>
            <?php $total_diskon += ($item['persen_diskon']/100 * $item['harga_awal'] * $item['quantity']); ?>
            <?php $total_akhir = $total_awal - $total_diskon; ?>
            @endforeach
        </div>

        <div class="mb-3">
            <p class="px-2 mb-0" style="background-color:#f5f5f5; font-size: 12px" > 
                <i class="fa-solid fa-money-bill" style="color: #624F8F"></i> 
                &nbsp; <b> Rincian Bayar </b> 
            </p>
            <div class="rincian-bayar px-2" style="color: gray">
                <span > Subtotal Produk </span>
                <span > Rp. {{number_format($total_awal)}} </span>
            </div>
            <div class="rincian-bayar px-2" style="color: gray">
                <span > Total Diskon </span>
                <span >- Rp. {{number_format($total_diskon)}} </span>
            </div>
            <div class="rincian-bayar px-2">
                <span >  <b> Total Pembayaran </b> </span>
                <span style="color: #FF419C"> <b> Rp. {{number_format($total_akhir)}} </b> </span>
            </div>
        </div>

        <div style="font-size: 9px; background-color: #f5f5f5">
            <span> <strong> Syarat & Ketentuan </strong> </span>
            <ol type="1">
                <li>No punggung didapatkan dari ekskul masing-masing <i>(khusus futsal dan basket) </i></li>
                <li>Setelah Pembayaran, tidak bisa cancel dan refund</li>
                <li>Tidak bisa ganti size</li>
                <li>Tidak bisa ganti No. Punggung dan Nama Punggung <i>(khusus futsal dan basket) </i></li>
                <li>Waktu Pre Order paling lambat 14 Hari Kerja</li>
            </ol>
        </div>

        <div class="bottom-navigate mt-3" style="background-color: #f5f5f5">
            <div class="d-flex" >
                <input type="checkbox" id="checklist-sk" name="checklist-sk" class="mx-1" onclick="oncheck()" >
                <a href="#" style="font-size: 10px; color: #624F8F;"> Syarat dan Ketentuan </a>
            </div>
            <div class="p-2 d-flex" style="justify-content: space-between">
                <h6> Total Pembayaran <br> <b> Rp. <span id="total_bayar"> {{number_format($total_akhir)}} </span> </b> </h6>
                <input type="hidden" value="{{$total_akhir}}" id="total_akhir" >
                <button id="pay-button" type="submit" class="btn btn-purple btn-sm px-4" onclick="bayar_jersey()" style="letter-spacing: 1px" disabled> <b>Bayar</b> </button>

                {{-- @if ($total_akhir != 0)
                    <button id="pay-button" type="submit" class="btn btn-purple btn-sm px-4" onclick="bayar_jersey()" style="letter-spacing: 1px"> <b>Bayar</b> </button>
                @else 
                    <button id="pay-button" type="submit" class="btn btn-purple btn-sm px-4" onclick="bayar_jersey()" style="letter-spacing: 1px" disabled> <b>Bayar</b> </button>
                @endif --}}
            </div>
        </div>
    @endif

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    {{-- <script src="https://app.sandbox.midtrans.com/snap/snap.js"  data-client-key="{{env('MIDTRANS_CLIENT_KEY')}}"></script>  --}}
    <script src="https://app.midtrans.com/snap/snap.js"  data-client-key="{{env('MIDTRANS_CLIENT_KEY')}}"></script>
    <script type="text/javascript">

        var harga_awal = $('#harga_awal').val();
        var diskon = $('#diskon').val();
        var diskon_persen = $('#diskon_persen').val();
        var total_harga = $('#harga').val();
        var nis = $('#nis').val();
        var hpp = $('#hpp').val();
        var ppn = $('#ppn').val();
        var quantity = $('#quantity').val();
        var ukuran = $('#ukuran').val();
        var jersey_id = $('#jersey_id').val();
        var nama_punggung = $('#nama_punggung').val();
        var no_punggung = $('#no_punggung').val();

        

        function oncheck() {
            var status_check = $('#checklist-sk').prop('checked');
            if (status_check == true) {
                $('#pay-button').prop('disabled', false);
            } else {
                $('#pay-button').prop('disabled', true);
            }
        }

        function bayar_jersey() {
            $(this).prop("disabled", true);
                // add spinner to button
                $(this).html(
                    `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`
            );
                
            $.ajax({
                url: "{{route('jersey.store')}}",
                type: 'POST',
                data: {
                    total_harga : total_harga,
                    harga_awal: harga_awal,
                    diskon_persen: diskon_persen,
                    quantity: quantity,
                    ukuran: ukuran,
                    nis: nis,
                    jersey_id: jersey_id,
                    hpp: hpp,
                    nama_punggung: nama_punggung,
                    no_punggung: no_punggung,
                    _token: '{{csrf_token()}}'
                },
                success: function (res) {
                    // SnapToken acquired from previous step
                    snap.pay(res.snap_token, {
                    // Optional
                    onSuccess: function(result){
                        window.location.href = '{{route('checkout.success')}}'
                        /* You may add your own js here, this is just example */ /*document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);*/
                    },
                    // Optional
                    onPending: function(result){
                        window.location.href = '{{route('seragam.history')}}'
                        /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    },
                    // Optional
                    onError: function(result){
                        window.location.href = '{{route('seragam.history')}}'
                        /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    }
                    });
                }
            });
        }

    </script>

@endsection