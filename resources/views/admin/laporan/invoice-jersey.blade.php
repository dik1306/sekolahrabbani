<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>

    <style>

        body {
            font-family: 'Nunito', sans-serif;
            line-height: 1.5;
        }

        .text-center {
            text-align: center
        }

        .mt-3 {
            margin-top: 1rem;
        }

        .table-bordered {
            padding: 5px;
            border-collapse: collapse;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid black;
        }

        .bg-pink {
            background-color: #EB3C97;
            color: white;
        }
        .footer { 
            position: fixed; left: 0px; bottom: 0px; right: 0px; background-color: #3FA2F6;
        }
    </style>

</head>
<body>
    <div>
        <table style="font-size: 14px">
            <tr>
            </tr>
            <tr>
                <td colspan="5">
                    <table id="table-logo">
                        <tr>
                            <td>
                                <img src="{{ url('assets/images/logo-yayasan_1_comp.png') }}" alt="Logo" width="100" class="logo" />
                            </td>
                            <td class="">
                                <span style="font-size: 24px"><b>Yayasan Rabbani Asysa</b> <br> </span>
                                <span style="font-size: 12px" >Jl. Jati No.5, Cisaranten Kulon, Kec. Arcamanik, Kota Bandung, Jawa Barat 40293</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="5" style="height: 20px">
                </td>
            </tr>

            <tr>
                <td colspan="5" class="text-center">
                    <span style="font-size: 20px;"> <b> Bukti Pembayaran </b> </span> 
                </td>
            </tr>

            <tr>
                <td colspan="5" style="height: 20px">
                </td>
            </tr>

            <tr class="mt-3">
                <td style="width:30%">
                    <span>Kepada :</span> <br>
                    <span> <b> {{$order->nama_pemesan}} </b> </span>
                    <span> <b> {{$order->no_hp}} </b> </span>
                </td>

                <td>
                </td>

                <td>
                </td>

                <td>
                </td>

                <td style="width: 35%" >
                    <span style="font-size: 14px">Invoice No: {{$order->no_pesanan}} </span> <br>
                    <span style="font-size: 14px">Tanggal : {{date('d-F-Y', strtotime($order->created_at))}} </span>
                </td>
            </tr>
        </table>
    </div>
 
    <div class="mt-3">
        <table class="table table-bordered">
            <thead style="font-size: 16px" >
                <tr>
                    <th class="bg-pink" style="width: 25px" >No</th>
                    <th class="bg-pink" colspan="2" style="width: 300px">Deskripsi Item</th>
                    <th class="bg-pink" style="width: 120px">Harga</th>
                    <th class="bg-pink" style="width: 80px">Jumlah</th>
                    <th class="bg-pink" style="width: 100px">Total</th>
                </tr>
            </thead>
            <tbody style="font-size: 13px">
                <?php $total_harga = 0; ?>
                <?php $total_diskon = 0; ?>
                @foreach($order_detail as $item)
                
                <tr class="items">
                    <td class="text-center">
                        {{$loop->iteration}}
                    </td>
                    <td colspan="2">
                        {{ $item->nama_jersey}}
                    </td>
                    <td class="text-center">
                        {{ number_format($item->harga) }}
                    </td>
                    <td class="text-center">
                        {{ $item->quantity }}
                    </td>
                    <td>
                        Rp {{ number_format($item->harga *  $item->quantity)}}
                    </td>
                </tr>
                <?php $total_harga += $item->harga * $item->quantity; ?>
                <?php $total_diskon += ($item->persen_diskon/100 * $item->harga * $item->quantity); ?>
                <?php $harga_akhir = $total_harga - $total_diskon; ?>

                
                @endforeach
                <tr>
                    <td colspan="5" class="text-center"><span style="font-size: 13px">Sub Total</span></td>
                    <td id="total_harga" colspan="1"><span style="font-size: 13px">Rp {{number_format($total_harga)}} </span></td>
                </tr>
                <tr>
                    <td colspan="5" class="text-center"><span style="font-size: 13px">Diskon</span></td>
                    <td id="diskon" colspan="1"><span style="font-size: 13px; color:red">Rp {{number_format($total_diskon)}}</span></td>
                </tr>
                <tr>
                    <td colspan="5" class="text-center"><span style="font-size: 13px"><b>Total Harga</b></span></td>
                    <td colspan="1"><span style="font-size: 13px"><b>Rp {{number_format($harga_akhir)}} </b> </span></td>
                </tr>
            </tbody>
        </table>
    </div>
 
    <div class="mt-3"><i> Terimakasih </i></div>
 
    <div class="footer">
        <table>
            <tr>
                <td colspan="2" style="width: 250px">
                    <img src="{{ url('assets/images/icon-world.png') }}" alt="icon" width="10" />
                    <span style="font-size: 10px"> www.sekolahrabbani.sch.id</span>
                </td>
                <td colspan="2" class="text-center" style="width: 400px" >
                    <img src="{{ url('assets/images/icon-ig.png') }}" alt="icon" width="10" />
                    <span style="font-size: 10px">sekolahrabbani</span>
                </td>
                <td colspan="2" style="width: 250px" class="text-center">
                    <img src="{{ url('assets/images/icon-wa.png') }}" alt="icon" width="10" />
                    <span style="font-size: 10px">+62 851-7327-3274</span>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>