@extends ('ortu.layouts.app')
    
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.0/dist/sweetalert2.min.css" rel="stylesheet">


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
                        <button id="pay-button" class="btn btn-primary btn-sm"><i class="fa fa-qrcode" aria-hidden="true"></i> Lihat QRIS</button>
                    </span>
                </div>
            @elseif(in_array($order->metode_pembayaran, ['gopay', 'shopeepay']))
                <!-- Untuk metode E-wallet seperti GoPay atau ShopeePay -->
                <div class="d-flex" style="justify-content: space-between; font-size: 14px">
                    <span> E-Wallet Pembayaran </span>
                    <span>
                        <button id="pay-button" class="btn btn-primary btn-sm"><i class="fa fa-wallet" aria-hidden="true"></i> Bayar E-Wallet</button>
                    </span>
                </div>
            @else
                <!-- Untuk metode VA atau lainnya -->
                <div class="d-flex" style="justify-content: space-between; font-size: 14px">
                    <span> No VA Pembayaran </span>
                    <button id="pay-button" class="btn btn-primary btn-sm"><i class="fa fa-credit-card" aria-hidden="true"></i> Lihat VA</button>    
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
        <hr>

    @if($tglUpdateBaru && $orderStatus)
    {{-- <div class="container">   --}}
        <div class="tracking-container">
            <div class="tracking-header">
                            <h6>Detail Pengiriman Jersey</h6>
                            <button class="toggle-button" onclick="toggleTracking()">▶</button>
                        </div>
                        <hr class="divider">
                        <div class="tracking-content" id="trackingContent">
                            <div class="tracking-steps">
                                <!-- Poin 1: Tanggal Distribusi ke Sekolah -->
                                @if($item->status_do == 1 && $item->status_order == 1 )
                                    <div class="tracking-step completed">
                                        <div class="step-indicator">
                                            <div class="circle completed"></div>
                                        </div>
                                        <div class="step-details">
                                            <span class="step-title">Status Delivery Order</span> <br>
                                            <span class="step-date">{{ \Carbon\Carbon::parse($item->tgl_do)->locale('id')->isoFormat('dddd, D MMMM YYYY | HH:mm') }}</span>
                                            <p class="step-status">Jersey telah terdistribusi ke sekolah</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="tracking-step pending">
                                        <div class="step-indicator">
                                            <div class="circle pending"></div>
                                        </div>
                                        <div class="step-details">
                                            <span class="step-title">Status Delivery Order</span> <br>
                                            <span class="step-date">Menunggu Distribusi...</span>
                                            <p class="step-status">Jersey sedang disiapkan, mohon sabar menunggu</p>
                                        </div>
                                    </div>
                                @endif

                                <!-- Poin 2: Tanggal Terima Distribusi -->
                                @if($item->status_terima_tu == 1)
                                    <div class="tracking-step completed">
                                        <div class="step-indicator">
                                            <div class="circle completed"></div>
                                        </div>
                                        <div class="step-details">
                                            <span class="step-title">Status Terima TU</span> <br>
                                            <span class="step-date">{{ \Carbon\Carbon::parse($item->tgl_terima_tu)->locale('id')->isoFormat('dddd, D MMMM YYYY | HH:mm') }}</span>
                                            <p class="step-status">Distribusi telah diterima oleh Tata Usaha</p>
                                        </div>
                                    </div>
                                    
                                @else
                                    <div class="tracking-step pending">
                                        <div class="step-indicator">
                                            <div class="circle pending"></div>
                                        </div>
                                        <div class="step-details">
                                            <span class="step-title">Status Terima TU</span> <br>
                                            <span class="step-date">Menunggu Penerimaan...</span>
                                            <p class="step-status">Tata Usaha belum menerima jersey, mohon ditunggu</p>
                                        </div>
                                    </div>
                                @endif

                                <!-- Poin 3: Tanggal Distribusi TU-->
                                @if($item->status_distribusi_tu == 1)
                                    <div class="tracking-step completed">
                                        <div class="step-indicator">
                                            <div class="circle completed"></div>
                                        </div>
                                        <div class="step-details">
                                            <span class="step-title">Status Distribusi TU</span> <br>
                                            <span class="step-date">{{ \Carbon\Carbon::parse($item->tgl_terima_tu)->locale('id')->isoFormat('dddd, D MMMM YYYY | HH:mm') }}</span>
                                            <p class="step-status">Tata Usaha telah melakukan distribusi jersey</p>
                                        </div>
                                    </div>
                                @else
                                    @if($item->status_terima_tu == 1)
                                        <div class="tracking-step pending">
                                            <div class="step-indicator">
                                                <div class="circle pending"></div>
                                            </div>
                                            <div class="step-details">
                                                <span class="step-title">Status Distribusi TU</span> <br>
                                                <span class="step-date">Distribusi sedang direncanakan TU</span>
                                                <p class="step-status">Tata Usaha akan segera mendistribusikan jersey, mohon ditunggu</p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="tracking-step pending">
                                            <div class="step-indicator">
                                                <div class="circle pending"></div>
                                            </div>
                                            <div class="step-details">
                                                <span class="step-title">Status Distribusi TU</span> <br>
                                                <span class="step-date">Menunggu Penerimaan...</span>
                                                <p class="step-status">Tata Usaha belum bisa merencanakan distribusi</p>
                                            </div>
                                        </div>
                                    @endif
                                @endif

                                <!-- Poin 4: Tanggal Terima oleh Orangtua -->
                                @if($item->tgl_terima_ortu !== null)
                                    <div class="tracking-step completed">
                                        <div class="step-indicator">
                                            <div class="circle completed"></div>
                                        </div>
                                        <div class="step-details">
                                            <span class="step-title">Status Terima Ortu</span> <br>
                                            <span class="step-date">{{ \Carbon\Carbon::parse($item->tgl_terima_ortu)->locale('id')->isoFormat('dddd, D MMMM YYYY | HH:mm') }}</span>
                                            <p class="step-status step-status-ortu">Jersey telah diterima oleh orangtua ✔</p>
                                        </div>
                                    </div>
                                @else
                                    @if($item->status_distribusi_tu == 1)
                                        <div class="tracking-step pending">
                                            <div class="step-indicator">
                                                <div class="circle pending"></div>
                                            </div>
                                            <div class="step-details">
                                                <span class="step-title">Status Terima Ortu</span> <br>
                                                <span class="step-date">Menuju Orangtua...</span>
                                                <p class="step-status">Jersey sedang dalam proses kepada orangtua <br>
                                                    Klik 'Terima Pesanan' ketika barang telah diterima
                                                </p>
                                            </div>
                                        </div>
                                        <div class="deliv-button">
                                            <button class="receive-button" 
                                                @if($item->status_distribusi_tu != 1) disabled @endif
                                                data-no-pemesanan="{{ $item->no_pesanan }}">
                                                Terima Pesanan
                                            </button>
                                        </div>
                                    @elseif($item->status_terima_tu == 1)
                                        <div class="tracking-step pending">
                                            <div class="step-indicator">
                                                <div class="circle pending"></div>
                                            </div>
                                            <div class="step-details">
                                                <span class="step-title">Status Terima Ortu</span> <br>
                                                <span class="step-date">Menunggu distribusi oleh TU</span>
                                                <p class="step-status">Jersey dalam perencanaan distribusi oleh TU</p>
                                            </div>
                                        </div>
                                        <div class="deliv-button">
                                            <button class="receive-button" 
                                                @if($item->status_distribusi_tu != 1) disabled @endif
                                                data-no-pemesanan="{{ $item->no_pesanan }}">
                                                Terima Pesanan
                                            </button>
                                        </div>
                                        
                                    @else
                                        <div class="tracking-step pending">
                                            <div class="step-indicator">
                                                <div class="circle pending"></div>
                                            </div>
                                            <div class="step-details">
                                                <span class="step-title">Status Terima Ortu</span> <br>
                                                <span class="step-date">Menungguu Penerimaan TU...</span>
                                                <p class="step-status">Jersey dalam perencanaan distribusi</p>
                                            </div>
                                        </div>
                                    @endif
                                @endif

                                <!-- Poin 4: Tanggal Retur -->
                                @if($item->tgl_retur !== null)
                                    <div class="tracking-step retur">
                                        <div class="step-indicator">
                                            <div class="circle retur"></div>
                                        </div>
                                        <div class="step-details">
                                            <span class="step-title">Status Retur</span> <br>
                                            <span class="step-date">{{ \Carbon\Carbon::parse($item->tgl_retur)->locale('id')->isoFormat('dddd, D MMMM YYYY | HH:mm') }}</span>
                                            <p class="step-status">Retur jersey telah dilakukan</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                {{-- </div> --}}
            @endif
    </div>
    
            <br>
            <br>
    
    @if($order->status == 'success')
        <a href="{{route('invoice-jersey', $order->no_pesanan)}}" target="_blank">
            <div class="d-grid gap-2 mt-3 bottom-navigate">
                <button class="btn btn-purple btn-block py-2" > Download Invoice </button>
            </div>
        </a>
    @endif

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('assets/js/jquery.countdown/jquery.countdown.min.js') }}"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.0/dist/sweetalert2.min.js"></script>
    <script>
        function toggleTracking() {
            const content = document.getElementById('trackingContent');
            const button = document.querySelector('.toggle-button');
            content.classList.toggle('collapsed');
            button.classList.toggle('collapsed');
            button.textContent = content.classList.contains('collapsed') ? '▶' : '▶';
        }
    </script>

    <script>
       // Fungsi untuk mengambil waktu lokal perangkat dan mengonversinya ke format yang benar
        function getLocalTime() {
            // Ambil waktu lokal saat tombol diklik
            let localTime = new Date();

            // Format menjadi 'YYYY-MM-DD HH:mm:ss'
            let formattedTime = localTime.getFullYear() + '-' 
                                + String(localTime.getMonth() + 1).padStart(2, '0') + '-'
                                + String(localTime.getDate()).padStart(2, '0') + ' '
                                + String(localTime.getHours()).padStart(2, '0') + ':'
                                + String(localTime.getMinutes()).padStart(2, '0') + ':'
                                + String(localTime.getSeconds()).padStart(2, '0');

            return formattedTime;
        }

        document.querySelectorAll('.receive-button').forEach(button => {
            button.addEventListener('click', function() {
                // Ambil no_pemesanan dari atribut data
                let noPemesanan = this.getAttribute('data-no-pemesanan');
                
                // Ambil waktu lokal saat tombol diklik (WIB) dengan format 'YYYY-MM-DD HH:mm:ss'
                let tglTerimaOrtu = getLocalTime(); 

                // Kirim AJAX request
                fetch(`{{ route('terima.jersey', ['no_pemesanan' => '__no_pemesanan__', 'tgl_terima_ortu' => '__tgl_terima_ortu__']) }}`
                    .replace('__no_pemesanan__', noPemesanan)
                    .replace('__tgl_terima_ortu__', tglTerimaOrtu), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'  // Sertakan token CSRF untuk keamanan
                        },
                        body: JSON.stringify({
                            no_pemesanan: noPemesanan,
                            tgl_terima_ortu: tglTerimaOrtu
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            // Menampilkan pesan sukses dengan SweetAlert
                            Swal.fire({
                                title: 'Berhasil!',
                                text: data.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                // Jika sukses, refresh halaman
                                location.reload();  // Refresh halaman
                            });
                        } else if (data.error) {
                            // Menampilkan pesan error dengan SweetAlert
                            Swal.fire({
                                title: 'Terjadi Kesalahan!',
                                text: data.error,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                // Jika error, refresh halaman atau lanjutkan dengan logika lainnya
                                location.reload();  // Refresh halaman
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Terjadi Kesalahan!',
                            text: 'Terjadi kesalahan saat memproses permintaan.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Jika error, refresh halaman
                            location.reload();  // Refresh halaman
                        });
                    });
            });
        });
    </script>

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