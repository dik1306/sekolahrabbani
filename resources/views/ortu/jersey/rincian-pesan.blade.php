@extends ('ortu.layouts.app')

@section('content')
    <div class="top-navigate sticky-top">
        <div class="d-flex" style="justify-content: stretch; width: 100%;">
            <a onclick="window.history.go(-1); return false;" class="mt-1" style="text-decoration: none; color: black">
                <i class="fa-solid fa-arrow-left fa-lg"></i>
            </a>
            <h4 class="mx-3"> Rincian Pesanan </h4>
        </div>
    </div>
        
    <div class="container">
        <?php $total_awal = 0; ?>
        <?php $total_diskon = 0; ?>
        <?php $total_akhir = 0; ?>
        @foreach ($order_detail as $item)
            <div class="row-card ">
                <div class="frame-bayar">
                    <img src="{{asset('storage/'.$item->image_1)}}" width="100%" style="height: 100%; object-fit:cover; border-radius:1rem">
                </div>
                <div class="d-flex mx-2">
                    <div class="" style="width: 200px">
                        <p class="mb-0" style="font-size: 14px;"> {{$item->nama_jersey}} Size: {{$item->ukuran_id}} </p>
                        <p class="mb-0 price-diskon"> <b> Rp. {{number_format($item->harga_awal * $item['quantity']  - ($item->persen_diskon/100 * $item->harga_awal * $item['quantity']))}} </b> </p>
                        <p class="mb-0" style="color: gray; font-size: 10px"> <s> Rp. {{number_format($item->harga_awal * $item['quantity'])}} </s> </p>     
                        <p class="mb-0" style="font-size: 10px">Nama: {{$item['nama_siswa']}}, Qty: {{$item['quantity']}} </p>
                        @if ($item->ekskul_id == 1 || $item->ekskul_id == 2)
                            <p class="mb-1" style="font-size: 10px">Nama Punggung: {{$item['nama_punggung']}}, No Punggung: {{$item['no_punggung']}} </p>
                        @endif
                    </div>
                </div>
            </div>
            <?php $total_awal += (($item->harga_awal * $item->quantity) ); ?>
            <?php $total_diskon += ($item->persen_diskon/100 * $item->harga_awal * $item->quantity);?>
            <?php $total_akhir = ($total_awal - $total_diskon); ?>
        @endforeach

        <div class="d-flex mt-3" style="justify-content: space-between; font-size: 14px">
            <input type="text" style="display: none" value="{{$total_akhir}}" id="nominal" >
            <span> Total Pesanan </span>
            <span> Rp. {{number_format($total_akhir)}} <i class="fa solid fa-copy" onclick="copy_nominal()" title="salin"> </i> </span>
        </div>
        <hr>

        <div class="d-flex mt-3" style="justify-content: space-between; font-size: 14px">
            <span> Metode Pembayaran </span>
            <span> {{ strtoupper($order->metode_pembayaran) }} </span>
        </div>

        @if($order->status == 'pending')
            @if($order->metode_pembayaran == 'qris')
                <!-- Untuk metode QRIS -->
                <div class="d-flex" style="justify-content: space-between; font-size: 14px">
                    <span> QRIS Pembayaran </span>
                    <span>
                        <button id="pay-button" class="btn btn-primary btn-sm">Bayar QRIS</button>
                    </span>
                </div>
            @elseif(in_array($order->metode_pembayaran, ['gopay', 'shopeepay']))
                <!-- Untuk metode E-wallet seperti GoPay atau ShopeePay -->
                <div class="d-flex" style="justify-content: space-between; font-size: 14px">
                    <span> E-Wallet Pembayaran </span>
                    <span>
                        <button id="pay-button" class="btn btn-primary btn-sm">Bayar E-Wallet</button>
                    </span>
                </div>
            @else
                <!-- Untuk metode VA atau lainnya -->
                <div class="d-flex" style="justify-content: space-between; font-size: 14px">
                    <span> No VA Pembayaran </span>
                    <button id="pay-button" class="btn btn-primary btn-sm">Lihat VA</button>    
                </div>
            @endif

            <div class="d-flex" style="justify-content: space-between; font-size: 14px">
                <span> Batas Pembayaran </span>
                <span class="text-danger" style="font-weight: bold" id="batas_pembayaran" data-countdown="{{ date('Y-m-d H:i:s', strtotime($order->expire_time))}}">
                    {{$order->expire_time}}
                </span>
            </div>
        @endif

        <hr>

        <!-- Tempat untuk menampilkan formulir pembayaran Snap -->
        <div id="payment-area" style="display:none;">
            <h5>Menunggu Pembayaran...</h5>
            <div id="snap-container"></div> <!-- Form pembayaran Midtrans Snap -->
        </div>

        <!-- Modal Dialog Box -->
        {{-- <div id="paymentModal" class="modal" style="display:none;">
            <div class="modal-content">
                <span id="closeModal" class="close">&times;</span>
                <h2 id="modalTitle"></h2>
                <p id="modalMessage"></p>
                <div id="modalActions">
                    <!-- Dynamic actions will be added here -->
                </div>
            </div>
        </div> --}}

        <!-- Script untuk Snap.js -->
        <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

        <script type="text/javascript">
            // Mendapatkan snap_token dari $order->snap_token
            const snapToken = '{{ $order->snap_token }}';

            // Menangani klik tombol bayar
            document.getElementById('pay-button').onclick = function() {
                // Menggunakan Snap.js untuk memulai transaksi pembayaran
                snap.pay(snapToken, {
                    onSuccess: function(result) {
                        // Tampilkan modal untuk pembayaran berhasil
                        // showModal('Pembayaran Berhasil', 'Terima kasih, pembayaran Anda telah berhasil diproses!', 'success');
                        window.location.href = '{{route('checkout.success')}}';
                    },
                    onPending: function(result) {
                        // Tampilkan modal untuk pembayaran yang masih pending
                        // showModal('Pembayaran Pending', 'Transaksi ini belum dilakukan pembayaran, silakan lihat detailnya.', 'warning');
                    },
                    onError: function(result) {
                        // Tampilkan modal untuk kesalahan pembayaran
                        // showModal('Pembayaran Gagal', 'Terjadi kesalahan saat memproses pembayaran, silakan coba lagi.', 'error');
                    }
                });

                // Menampilkan area pembayaran setelah tombol diklik
                document.getElementById('payment-area').style.display = 'block';
            };

            // Function to show the modal
            function showModal(title, message, type) {
                const modal = document.getElementById('paymentModal');
                const modalTitle = document.getElementById('modalTitle');
                const modalMessage = document.getElementById('modalMessage');
                const modalActions = document.getElementById('modalActions');
                
                // Set title and message
                modalTitle.innerText = title;
                modalMessage.innerText = message;

                // Change modal style based on the type
                if (type === 'success') {
                    modal.style.backgroundColor = '#d4edda';
                    modalTitle.style.color = '#155724';
                } else if (type === 'warning') {
                    modal.style.backgroundColor = '#fff3cd';
                    modalTitle.style.color = '#856404';
                } else if (type === 'error') {
                    modal.style.backgroundColor = '#f8d7da';
                    modalTitle.style.color = '#721c24';
                }

                // Add button for closing modal
                modalActions.innerHTML = '<button onclick="closeModal()" class="btn btn-secondary">Tutup</button>';

                // Show modal
                modal.style.display = 'block';
            }

            // Function to close modal
            function closeModal() {
                document.getElementById('paymentModal').style.display = 'none';
            }

            // Close the modal when the user clicks on the close button (×)
            document.getElementById('closeModal').onclick = closeModal;

            // Close the modal if the user clicks anywhere outside of the modal
            window.onclick = function(event) {
                if (event.target == document.getElementById('paymentModal')) {
                    closeModal();
                }
            }
        </script>


        <div class="d-flex mt-3" style="justify-content: space-between; font-size: 14px">
            <span> No Pesanan </span>
            <span> {{$order->no_pesanan}} </span>
        </div>

        @if($order->status == 'success')
            <div class="d-flex mb-5" style="justify-content: space-between; font-size: 14px">
                <span> Waktu Pembayaran </span>
                <span> {{$order->updated_at}} </span>
            </div>
        @endif

    </div>
    
    @if($order->status == 'success')
        <a href="{{route('invoice-jersey', $order->no_pesanan)}}" target="_blank">
            <div class="d-grid gap-2 mt-3 bottom-navigate">
                <button class="btn btn-purple btn-block py-2" > Download Invoice </button>
            </div>
        </a>
    @endif

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('assets/js/jquery.countdown/jquery.countdown.min.js') }}"></script>
    <script>
          $('[data-countdown]').each(function() {
            var $this = $(this), finalDate = $(this).data('countdown');
            $this.countdown(finalDate, function(event) {
                $this.html(event.strftime('%H:%M:%S'));
            });
        });

        function copy_number() {
            var copyText = document.getElementById("va_number");
            var textArea = document.createElement("textarea");
            textArea.value = copyText.textContent;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand("Copy");
            alert("No VA berhasil disalin");
            textArea.remove();
        }

        function copy_nominal() {
            var hidden = document.getElementById("nominal");
            hidden.style.display = 'block';
            hidden.select();
            hidden.setSelectionRange(0, 99999)
            document.execCommand("copy");
            alert("Nominal berhasil disalin");
            hidden.style.display = 'none';
        }
    </script>
@endsection