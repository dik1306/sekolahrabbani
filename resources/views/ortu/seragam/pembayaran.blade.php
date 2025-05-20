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
        <?php $harga = (($produk_seragam->harga) - ($produk_seragam->diskon/100 * $produk_seragam->harga)) * $quantity; ?>
        <?php $diskon =  ($produk_seragam->diskon/100 * $produk_seragam->harga) * $quantity; ?>
        <?php $diskon_persen =  ($produk_seragam->diskon); ?>
        <?php $harga_awal = $produk_seragam->harga * $quantity; ?>
        <input type="hidden" id="harga" value="{{$harga}}">
        <input type="hidden" id="harga_awal" value="{{$harga_awal}}">
        <input type="hidden" id="diskon" value="{{$diskon}}">
        <input type="hidden" id="diskon_persen" value="{{$diskon_persen}}">
        <input type="hidden" id="kode_produk" value="{{$produk_seragam->kode_produk}}">
        <input type="hidden" id="hpp" value="{{$produk_seragam->hpp}}">
        <input type="hidden" id="ppn" value="{{$produk_seragam->ppn}}">
        <input type="hidden" id="quantity" value="{{$quantity}}">
        <input type="hidden" id="ukuran" value="{{$ukuran}}">
        <input type="hidden" id="jenis_produk" value="{{$produk_seragam->jenis_produk_id}}">
        <input type="hidden" id="produk_id" value="{{$produk_id}}">
        <input type="hidden" id="nama_siswa" value="{{$profile->nama_lengkap}}">
        <input type="hidden" id="nama_kelas" value="{{$profile->nama_kelas}}">
        <input type="hidden" id="sekolah_id" value="{{$profile->sekolah_id}}">
        <div class="container">
            <div class="row-card mx-1">
                <div class="frame-bayar">
                    <img src="{{asset('assets/images/'.$produk_seragam->image)}}" width="100%" style="height: 100%; object-fit:cover; border-radius:1rem">
                </div>

                <div class="d-flex mx-2">
                    <div class="" style="width: 200px">
                        <p class="mb-0" style="font-size: 14px;"> {{$produk_seragam->nama_produk}} </p>
                        <p class="mb-0 price-diskon"> <b> Rp. {{number_format($harga) }} </b> </p>
                        <p class="mb-0" style="color: gray; font-size: 10px"> <s> Rp. {{number_format($harga_awal)}} </s> </p>     
                        <p class="mb-0" style="font-size: 10px">Quantity: {{$quantity}}, Size: {{$ukuran}}, Jenis: {{$produk_seragam->jenis_produk}} </p>
                        <p class="mb-1" style="font-size: 10px">Sekolah: {{$profile->sublokasi}}, Kelas: {{$profile->nama_kelas}} </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="">
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

        <div class="bottom-navigate mt-3" style="background-color: #f5f5f5">
            <a href="#" style="font-size: 10px; text-decoration: none; color: #624F8F" data-bs-toggle="modal" data-bs-target="#privacy_policy"><i class="fa-solid fa-circle-info"></i> Privacy Policy </a>
            <div class="p-2 d-flex" style="justify-content: space-between">
                <h6> Total Pembayaran <br> <b> Rp. <span id="total_bayar"> {{number_format($harga)}} </span> </b> </h6>
                <input type="hidden" value="{{$harga}}" id="total_akhir" >
                <button id="pay-button" type="submit" class="btn btn-purple btn-sm px-4" onclick="bayar_seragam()" style="letter-spacing: 1px"> <b>Bayar</b> </button>
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
                        <img src="{{asset('assets/images/'.$item->image)}}" width="100%" style="height: 100%; object-fit:cover; border-radius:1rem">
                    </div>

                    <div class="d-flex mx-2">
                        <div class="" style="width: 200px">
                            <input type="hidden" class="kode_produk_fc" name="kode_produk[]" id="kode_produk_fc" value="{{$item->kode_produk}}">
                            <p class="mb-0" style="font-size: 14px;"> {{$item->nama_produk}} </p>
                            <p class="mb-0 price-diskon"> <b> Rp. {{number_format((($item['harga']) - ($item['diskon']/100 * $item['harga'])) * $item['quantity']) }} </b> </p>
                            <p class="mb-0" style="color: gray; font-size: 10px"> <s> Rp. {{number_format($item->harga * $item['quantity'])}} </s> </p>     
                            <p class="mb-0" style="font-size: 10px">Quantity: {{$item['quantity']}}, Size: {{$item['ukuran']}} </p>
                            <p class="mb-1" style="font-size: 10px">Sekolah: {{$item['sekolah']}}, Kelas: {{$item['nama_kelas']}} </p>

                        </div>
                    </div>
                </div>
            <?php $total_awal += (($item['harga'] * $item['quantity']) ); ?>
            <?php $total_diskon += ($item['diskon']/100 * $item['harga'] * $item['quantity']); ?>
            <?php $total_akhir = $total_awal - $total_diskon; ?>
            @endforeach
        </div>

        <div class="">
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

        <div class="bottom-navigate mt-3" style="background-color: #f5f5f5">
            <a href="#" style="font-size: 10px; text-decoration: none; color: #624F8F" data-bs-toggle="modal" data-bs-target="#privacy_policy"><i class="fa-solid fa-circle-info"></i> Privacy Policy </a>
            <div class="p-2 d-flex" style="justify-content: space-between">
                <h6> Total Pembayaran <br> <b> Rp. <span id="total_bayar"> {{number_format($total_akhir)}} </span> </b> </h6>
                <input type="hidden" value="{{$total_akhir}}" id="total_akhir" >
                @if ($total_akhir != 0)
                    <button id="pay-button" type="submit" class="btn btn-purple btn-sm px-4" onclick="bayar_seragam()" style="letter-spacing: 1px"> <b>Bayar</b> </button>
                @else 
                    <button id="pay-button" type="submit" class="btn btn-purple btn-sm px-4" onclick="bayar_seragam()" style="letter-spacing: 1px" disabled> <b>Bayar</b> </button>
                @endif
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
        var nama_siswa = $('#nama_siswa').val();
        var nama_kelas = $('#nama_kelas').val();
        var sekolah_id = $('#sekolah_id').val();
        var kode_produk = $('#kode_produk').val();
        var hpp = $('#hpp').val();
        var ppn = $('#ppn').val();
        var quantity = $('#quantity').val();
        var ukuran = $('#ukuran').val();
        var produk_id = $('#produk_id').val();
        var jenis_produk = $('#jenis_produk').val();
        var kode_produk_fc = $('input[name^=kode_produk]').map(function(idx, elem) {
                        return $(elem).val();
                    }).get();

        function bayar_seragam() {
            $(this).prop("disabled", true);
                // add spinner to button
                $(this).html(
                    `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`
            );

            
            if(kode_produk == undefined || kode_produk == null) {
                // from cart url:pembayaran
                $.each(kode_produk_fc, function (key, item) {
                    var kd_barang = item
                    var kode_barang = kd_barang;

                    $.ajax({
                        url: "{{route('check.stock')}}",
                        type: 'GET',
                        data: {
                            kode_produk: kode_barang
                        },
                        success: function (res) {
                            if (res == 0) {
                                $('#info_stok').modal('show')
                            }
                        }
                    })
                })
                
                $.ajax({
                    url: "{{route('seragam.store')}}",
                    type: 'POST',
                    data: {
                        total_harga : total_harga,
                        harga_awal: harga_awal,
                        diskon: diskon,
                        diskon_persen: diskon_persen,
                        nama_siswa: nama_siswa,
                        nama_kelas: nama_kelas,
                        sekolah_id: sekolah_id,
                        kode_produk: kode_produk,
                        produk_id: produk_id,
                        quantity: quantity,
                        ukuran: ukuran,
                        jenis_produk: jenis_produk,
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
                
            } else {
                // beli sekarang url:payment
                var kode_barang = kode_produk;

                $.ajax({
                    url: "{{route('check.stock')}}",
                    type: 'GET',
                    data: {
                        kode_produk: kode_barang
                    },
                    success: function (res) {
                        if (res > 0) {
                             $.ajax({
                                url: "{{route('seragam.store')}}",
                                type: 'POST',
                                data: {
                                    total_harga : total_harga,
                                    harga_awal: harga_awal,
                                    diskon: diskon,
                                    diskon_persen: diskon_persen,
                                    nama_siswa: nama_siswa,
                                    nama_kelas: nama_kelas,
                                    sekolah_id: sekolah_id,
                                    kode_produk: kode_produk,
                                    hpp: hpp,
                                    ppn: ppn,
                                    produk_id: produk_id,
                                    quantity: quantity,
                                    ukuran: ukuran,
                                    jenis_produk: jenis_produk,
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
                        } else {
                            $('#info_stok').modal('show')
                        }
                    }
                })
            }
        }

    </script>

    <div class="modal fade" id="info_stok" tabindex="-1" role="dialog" aria-labelledby="stok" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6 class="modal-title" id="stok">Mohon Maaf, Produk yang Anda Pilih Sudah Habis Stok</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="privacy_policy" tabindex="-1" role="dialog" aria-labelledby="stok" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3> Privacy Policy </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ol type="1"> 
                        <li> Jika ada salah pembelian, tidak ada kebijakan refund atau pengembalian uang</li>
                        <li> Jika salah ukuran maka dapat ditukar dengan barang sejenis maksimal H+1 setelah barang diterima dan hanya dapat dilakukan 1 kali</li>
                        <li> Penukaran barang sejenis dimulai dari ukuran XS s.d. 3XL</li>
                        <li> Proses penukaran membutuhkan waktu maksimal 14 hari kerja</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

@endsection