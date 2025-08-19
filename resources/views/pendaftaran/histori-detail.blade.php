@extends('layouts.app')

@section('content')
    <style>
        .status-bayar {
            padding: 5px 10px;
            font-weight: bold;
            color: #fff;
            border-radius: 5px;
            display: inline-flex;
            align-items: center;
        }

        .belum-bayar {
            background-color: #e74c3c; /* Merah */
        }

        .sudah-bayar {
            background-color: #2ecc71; /* Hijau */
        }

        .status-bayar i {
            margin-right: 5px;
        }

        .table th {
            background-color: #f8f9fa;
        }

        .badge {
            font-weight: normal;
            font-size: 0.9em;
            padding: 5px 10px;
        }

        .badge.bg-danger {
            background-color: #e74c3c;
        }

        .badge.bg-warning {
            background-color: #f39c12;
        }

        .badge.bg-success {
            background-color: #2ecc71;
        }

        #countdown {
            font-weight: bold;
            color: #e74c3c;
        }

        .btn-warning, .btn-success {
            width: 100%;
            padding: 10px;
        }

        .btn-warning {
            background-color: #f39c12;
            color: white;
        }

        .btn-success {
            background-color: #2ecc71;
            color: white;
        }

        .btn-primary {
            background-color: #3498db;
            color: white;
        }

        .btn-sm {
            width: auto;
        }

        /* Payment Modal Styles */
        .payment-modal .modal-content {
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        }

        .payment-modal .modal-header {
            border-bottom: none;
            padding-bottom: 0;
        }

        .payment-modal .modal-header h2 {
            font-size: 24px;
            font-weight: 600;
            color: #1a1a1a;
        }

        .payment-amount {
            background: #f8f9fa;
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }

        .payment-amount label {
            font-size: 16px;
            color: #333;
            font-weight: 500;
        }

        .payment-amount span {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a1a;
            display: block;
            margin-top: 8px;
        }

        .payment-section {
            margin-bottom: 16px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 8px;
            transition: background 0.3s;
        }

        .section-title:hover {
            background: #e9ecef;
        }

        .section-title::after {
            content: '▾';
            transition: transform 0.3s;
        }

        .section-title.active::after {
            transform: rotate(180deg);
        }

        .payment-options {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

        .payment-options.active {
            max-height: 500px;
        }

        .payment-option {
            display: flex;
            align-items: center;
            padding: 12px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: background 0.2s;
        }

        .payment-option:hover {
            background: #f1f3f5;
        }

        .payment-option img {
            width: 40px;
            height: 40px;
            margin-right: 12px;
            object-fit: contain;
        }

        .payment-option input[type="radio"] {
            margin-right: 8px;
        }

        .payment-option label {
            font-size: 16px;
            color: #333;
            flex-grow: 1;
        }

        .continue-btn {
            width: 100%;
            padding: 12px;
            background: #3498db;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            transition: background 0.3s;
        }

        .continue-btn:hover {
            background: #2874b2;
        }

        @media (max-width: 480px) {
            .payment-modal .modal-content {
                padding: 16px;
            }

            .payment-modal .modal-header h2 {
                font-size: 20px;
            }

            .payment-amount span {
                font-size: 20px;
            }

            .section-title {
                font-size: 16px;
            }

            .payment-option img {
                width: 32px;
                height: 32px;
            }

            .payment-option label {
                font-size: 14px;
            }

            .continue-btn {
                font-size: 14px;
                padding: 10px;
            }
        }
    </style>

    <div class="">
        <img class="banner-2" src="{{ asset('assets/images/home_rabbani_school-2.png') }}" alt="banner">
    </div>
    <div class="container" style="position: relative; z-index:1000">
        <div class="row mx-auto">
            <div class="col-md">
                <h6 class="mt-1" style="color: #ED145B">Detail Data Pendaftaran</h6>
                <h4 class="mb-3">Data Calon Siswa</h4>
                <form action="{{route('form.histori.detail')}}" method="GET">
                    <div class="form-group">
                        <div class="d-flex">
                            <input type="text" name="no_registrasi" id="no_registrasi" class="form-control form-control-sm px-3" aria-label=".form-control-sm px-3 example" value="{{$no_registrasi}}" placeholder="Masukkan No Registrasi/Pendaftaran">
                            <button type="submit" class="btn btn-primary mx-3">Cari</button>
                        </div>
                    </div>
                    <small>Lupa No Registrasi/Pendaftaran? <a href="#" data-bs-toggle="modal" data-bs-target="#lupa_no_regis">Klik Disini</a></small>
                </form>
                @if ($data_pendaftaran != null)
                    <div class="container" style="position: relative; z-index:1000">
                        <div class="row mx-auto">
                            <div class="col-md">
                                <h3>Detail Pendaftaran Anak</h3>

                                <!-- Tabel Data Pendaftaran -->
                                <h5 class="mt-4">Data Pendaftaran</h5>
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th>ID Anak (No Registrasi)</th>
                                        <td>{{ $data_pendaftaran->id_anak }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Lengkap</th>
                                        <td>{{ $data_pendaftaran->nama_lengkap }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Kelamin</th>
                                        <td>
                                            @if ($data_pendaftaran->jenis_kelamin == 'L')
                                                Laki-Laki
                                            @else
                                                Perempuan
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tempat Lahir</th>
                                        <td>{{ $data_pendaftaran->tempat_lahir }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Lahir</th>
                                        <td>{{ \Carbon\Carbon::parse($data_pendaftaran->tgl_lahir)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Lokasi</th>
                                        <td>{{ $lokasi }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenjang</th>
                                        <td>
                                            @if ($data_pendaftaran->tingkat == 'tka')
                                                TK A
                                            @elseif ($data_pendaftaran->tingkat == 'tkb')
                                                TK B
                                            @else 
                                                {{ $data_pendaftaran->tingkat }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        @php
                                            $angka_ke_kata = [
                                                '1' => 'Satu',
                                                '2' => 'Dua',
                                                '3' => 'Tiga',
                                                '4' => 'Empat',
                                                '5' => 'Lima',
                                                '6' => 'Enam',
                                                '7' => 'Tujuh',
                                                '8' => 'Delapan',
                                                '9' => 'Sembilan'
                                            ];
                                            $kelas = isset($angka_ke_kata[$data_pendaftaran->kelas]) ? $angka_ke_kata[$data_pendaftaran->kelas] : null;
                                        @endphp
                                        <th>Kelas</th>
                                        <td>
                                            @if ($data_pendaftaran->kelas == 'tka')
                                                TK A
                                            @elseif ($data_pendaftaran->kelas == 'tkb')
                                                TK B
                                            @else
                                                {{ $data_pendaftaran->kelas }}
                                            @endif
                                            @if ($kelas)
                                                ({{ $kelas }})
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Nama Ayah</th>
                                        <td>{{ $get_profile_ayah->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Ibu</th>
                                        <td>{{ $get_profile_ibu->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th>Informasi PPDB</th>
                                        <td>{{ ucwords($data_pendaftaran->info_ppdb) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ananda mempunyai kebutuhan khusus (ABK)</th>
                                        <td>{{ ucfirst($data_pendaftaran->info_apakah_abk) }}</td>
                                    </tr>
                                    @if ($data_pendaftaran->jenjang >= 4)
                                        <tr>
                                            <th>Asal Sekolah</th>
                                            <td>{{ $data_pendaftaran->asal_sekolah ?? "-"}}</td>
                                        </tr>
                                    @endif
                                </table>

                                <!-- Status Pembayaran -->
                                <h5 class="mt-4">Status Pembayaran</h5>
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th>Status Pembayaran</th>
                                        <td>
                                            @if ($data_pendaftaran->status_pembayaran == 0)
                                                <span class="badge bg-danger">Belum Bayar</span>
                                            @else
                                                <span class="badge bg-success">Sudah Bayar</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Status Pembayaran (Midtrans)</th>
                                        <td>
                                            <span class="badge {{ $data_pendaftaran->status_midtrans == 'success' ? 'bg-success' : ($data_pendaftaran->status_midtrans == 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                                {{ ucfirst($data_pendaftaran->status_midtrans ?? 'Tidak ada data') }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>

                                <!-- Detail Pembayaran -->
                                <h5 class="mt-4">Detail Pembayaran</h5>
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th>Metode Pembayaran</th>
                                        <td>{{ ucfirst($data_pendaftaran->metode_pembayaran ?? 'Belum dipilih') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Expire Time</th>
                                        <td>
                                            @if ($data_pendaftaran->expire_time && $data_pendaftaran->status_midtrans != 'success')
                                                <span id="countdown"></span>
                                                (Kedaluwarsa pada {{ \Carbon\Carbon::parse($data_pendaftaran->expire_time)->locale('id')->isoFormat('D MMMM YYYY HH:mm') }})
                                            @else
                                                Tidak berlaku
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Bayar</th>
                                        <td>
                                            @if ($data_pendaftaran->tgl_bayar)
                                                {{ \Carbon\Carbon::parse($data_pendaftaran->tgl_bayar)->locale('id')->isoFormat('D MMMM YYYY HH:mm') }}
                                            @else
                                                Belum bayar
                                            @endif
                                        </td>
                                    </tr>
                                </table>

                                <!-- Tombol Aksi Dinamis -->
                                @if ($data_pendaftaran->status_pembayaran == 0 && $data_pendaftaran->status_midtrans == 'expired')
                                                                        
                                @elseif ($data_pendaftaran->status_pembayaran == 1 && $data_pendaftaran->status_midtrans == 'success')
                                    <h5 class="mt-4">Aksi</h5>
                                    <form action="{{ route('pendaftaran.invoice', $no_registrasi) }}" method="GET">
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            <i class="fa fa-file-invoice" aria-hidden="true"></i> Unduh Invoice
                                        </button>
                                    </form>
                                @elseif ($data_pendaftaran->status_midtrans == 'pending')
                                    <h5 class="mt-4">Aksi</h5>
                                    <button id="pay-button" class="btn btn-primary btn-sm">
                                        <i class="fa fa-wallet" aria-hidden="true"></i> Lihat Pembayaran
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <div>
                        <h3 class="center">Data Tidak Ditemukan</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Lupa No Registrasi -->
    <div class="modal fade" id="lupa_no_regis" tabindex="-1" role="dialog" aria-labelledby="lupa_regis" aria-hidden="true">
        <div class="modal-dialog">
            <form role="form" method="POST" action="{{route('forget_no_regis')}}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="lupa_regis">Lupa No Pendaftaran / Registrasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Masukkan No HP Anda</label>
                            <input type="text" name="no_hp" class="form-control form-control-sm px-3" placeholder="08xx">
                        </div>
                        <div class="form-group mt-2">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control form-control-sm px-3" placeholder="Masukkan Nama Anak Anda">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm my-4 text-white">Kirim</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal fade payment-modal bd-example-modal-lg" id="payment-modal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="paymentModalLabel">Pilih Metode Pembayaran</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @csrf
                <div class="modal-body">
                    <!-- Payment Amount -->
                    <div class="payment-amount">
                        <label>Nominal Pembayaran</label>
                        <span id="payment-amount">Rp {{ number_format($biaya ?? 0, 0, ',', '.') }}</span>
                    </div>

                    <!-- QRIS -->
                    <div class="payment-section">
                        <div class="payment-option">
                            <img src="{{ asset('assets/images/_other_assets/payment_icons/qris.png') }}" alt="QRIS">
                            <input type="radio" id="qris" name="paymentMethod" value="other_qris" data-adminID="qris">
                            <label for="qris">QRIS</label>
                        </div>
                    </div>

                    <!-- E-Wallet -->
                    <div class="payment-section">
                        <div class="section-title" onclick="toggleSection(this)">E-Wallet</div>
                        <div class="payment-options">
                            <div class="payment-option">
                                <img src="{{ asset('assets/images/_other_assets/payment_icons/gopay.png') }}" alt="GoPay">
                                <input type="radio" id="gopay" name="paymentMethod" value="gopay" data-adminID="qris">
                                <label for="gopay">GoPay</label>
                            </div>
                            <div class="payment-option">
                                <img src="{{ asset('assets/images/_other_assets/payment_icons/shopeepay.png') }}" alt="ShopeePay">
                                <input type="radio" id="shopeepay" name="paymentMethod" value="shopeepay" data-adminID="qris">
                                <label for="shopeepay">ShopeePay</label>
                            </div>
                        </div>
                    </div>

                    <!-- Virtual Account -->
                    <div class="payment-section">
                        <div class="section-title" onclick="toggleSection(this)">Virtual Account</div>
                        <div class="payment-options">
                            <div class="payment-option">
                                <img src="{{ asset('assets/images/_other_assets/payment_icons/bca.png') }}" alt="BCA">
                                <input type="radio" id="bca" name="paymentMethod" value="bca_va" data-adminID="va">
                                <label for="bca">BCA Virtual Account</label>
                            </div>
                            <div class="payment-option">
                                <img src="{{ asset('assets/images/_other_assets/payment_icons/bni.png') }}" alt="BNI">
                                <input type="radio" id="bni" name="paymentMethod" value="bni_va" data-adminID="va">
                                <label for="bni">BNI Virtual Account</label>
                            </div>
                            <div class="payment-option">
                                <img src="{{ asset('assets/images/_other_assets/payment_icons/bri.png') }}" alt="BRI">
                                <input type="radio" id="bri" name="paymentMethod" value="bri_va" data-adminID="va">
                                <label for="bri">BRI Virtual Account</label>
                            </div>
                            <div class="payment-option">
                                <img src="{{ asset('assets/images/_other_assets/payment_icons/mandiri.png') }}" alt="Mandiri">
                                <input type="radio" id="mandiri" name="paymentMethod" value="echannel" data-adminID="va">
                                <label for="mandiri">Mandiri Virtual Account</label>
                            </div>
                            <div class="payment-option">
                                <img src="{{ asset('assets/images/_other_assets/payment_icons/cimb.png') }}" alt="CIMB">
                                <input type="radio" id="cimb" name="paymentMethod" value="cimb_va" data-adminID="va">
                                <label for="cimb">CIMB Virtual Account</label>
                            </div>
                            <div class="payment-option">
                                <img src="{{ asset('assets/images/_other_assets/payment_icons/permata.png') }}" alt="Permata">
                                <input type="radio" id="permata" name="paymentMethod" value="permata_va" data-adminID="va">
                                <label for="permata">Permata Virtual Account</label>
                            </div>
                        </div>
                    </div>

                    <button class="continue-btn" onclick="proceedPayment()">Lanjutkan Pembayaran</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Impor SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Script untuk hitung mundur expire_time -->
    

    @if ($data_pendaftaran != null)
        @if ($data_pendaftaran && $data_pendaftaran->expire_time && $data_pendaftaran->status_midtrans != 'success')
            <script>
                $(document).ready(function() {
                    // Validate expire_time
                    var expireTime = "{{ $data_pendaftaran->expire_time }}";
                    if (!expireTime || isNaN(new Date(expireTime).getTime())) {
                        console.error('Invalid or missing expire_time:', expireTime);
                        document.getElementById("countdown").innerHTML = "EXPIRED or Invalid Time";
                        return;
                    }

                    var countDownDate = new Date(expireTime).getTime();
                    var x = setInterval(function() {
                        var now = new Date().getTime();
                        var distance = countDownDate - now;
                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                        document.getElementById("countdown").innerHTML = days + "h " + hours + "j " + minutes + "m " + seconds + "d ";
                        if (distance < 0) {
                            clearInterval(x);
                            document.getElementById("countdown").innerHTML = "KEDALUWARSA";
                        }
                    }, 1000);
                });
            </script>
        @endif

        <!-- Script untuk Snap.js -->
        <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
        <script>
            const statusMidtrans = '{{ $data_pendaftaran->status_midtrans ?? "kosong" }}';
            let snapToken = '{{ $data_pendaftaran->snap_token ?? "kosong" }}';
            const idAnak = '{{ $data_pendaftaran->id_anak }}';
            const baseAmount = {{ $biaya ?? 0 }}; // Base amount from server

            let tglDaftar = '{{ $data_pendaftaran->created_at ?? "ajuanLama" }}';
            // Format tanggal yang akan dibandingkan (19 Agustus 2025)
            const batasTanggal = new Date('2025-08-19T00:00:00');
            // Mengubah tglDaftar menjadi objek Date JavaScript
            let tanggalPendaftaran = new Date(tglDaftar);
            // Mengecek apakah tanggal pendaftaran lebih kecil dari batasTanggal
            if (tanggalPendaftaran < batasTanggal) {
                tglDaftar = "ajuanLama";
            }

            // Format number as currency (Rp X.XXX.XXX)
            function formatCurrency(amount) {
                return 'Rp ' + amount.toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
            }

            // Update payment amount based on selected payment method
            function updatePaymentAmount() {
                const selectedMethod = document.querySelector('input[name="paymentMethod"]:checked');
                const paymentAmountElement = document.getElementById('payment-amount');
                let totalAmount = baseAmount;

                if (selectedMethod) {
                    const adminId = selectedMethod.getAttribute('data-adminID');
                    if (adminId === 'qris') {
                        totalAmount = baseAmount + (baseAmount * 0.007); // +0.7% fee
                    } else if (adminId === 'va') {
                        totalAmount = baseAmount + 4400; // +4400 fixed fee
                    } else if (adminId === 'deeplink') {
                        totalAmount = baseAmount + (baseAmount * 0.02); // +2% fee
                    }
                }

                paymentAmountElement.textContent = formatCurrency(Math.round(totalAmount));
            }

            // Add event listeners to radio buttons
            document.querySelectorAll('input[name="paymentMethod"]').forEach(radio => {
                radio.addEventListener('change', updatePaymentAmount);
            });

            function toggleSection(element) {
                const options = element.nextElementSibling;
                const isActive = options.classList.contains('active');
                document.querySelectorAll('.payment-options').forEach(opt => {
                    opt.classList.remove('active');
                    opt.previousElementSibling.classList.remove('active');
                });
                if (!isActive) {
                    options.classList.add('active');
                    element.classList.add('active');
                }
            }

            function openSnapPayment() {
                snap.pay(snapToken, {
                    onSuccess: function(result) {
                        // window.location.reload();
                    },
                    onPending: function(result) {
                        // No action needed; Snap.js handles the pending UI
                    },
                    onError: function(result) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Pembayaran Gagal',
                            text: 'Terjadi kesalahan saat memproses pembayaran, silakan coba lagi.',
                        });
                    },
                    onClose: function() {
                        // No action on close
                        window.location.reload();
                    }
                });
            }

            function proceedPayment() {
                const selectedMethod = document.querySelector('input[name="paymentMethod"]:checked');
                if (!selectedMethod) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Pilih Metode',
                        text: 'Silakan pilih metode pembayaran terlebih dahulu.',
                    });
                    return;
                }

                const adminId = selectedMethod.getAttribute('data-adminID');
                console.log('Sending data:', { id_anak: idAnak, payment_method: selectedMethod.value, admin_id: adminId });

                fetch('{{ route("pendaftaran.store.pembayaran") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        id_anak: idAnak,
                        payment_method: selectedMethod.value,
                        admin_id: adminId
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw new Error(JSON.stringify(err)) });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.snap_token) {
                        snapToken = data.snap_token;
                        $('#payment-modal').modal('hide');
                        snap.pay(snapToken, {
                            onPending: function(result) {
                                // No action needed; Snap.js handles the pending UI
                                window.location.reload();
                            },
                            onError: function(result) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Pembayaran Gagal',
                                    text: 'Terjadi kesalahan saat memproses pembayaran, silakan coba lagi.',
                                });
                            },
                            onClose: function() {
                                // No action on close
                                window.location.reload();
                            }
                        });
                        // window.location.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Gagal mendapatkan token pembayaran: ' + (data.failed || 'Unknown error'),
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan: ' + error.message,
                    });
                });
            }

            function openModalPayment() {
                const modal = $('#payment-modal');
                if (modal.length) {
                    modal.modal('show');
                } else {
                    console.error('Modal element #payment-modal not found in the DOM');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Modal pembayaran tidak ditemukan di halaman.',
                    });
                }
            }


            function checkPaymentStatus() {
                fetch('{{ route("cek.status.pembayaran") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ id_anak: idAnak })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status_midtrans === 'success' && statusMidtrans === 'pending') {
                        window.location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error checking payment status:', error);
                });
            }

            // Wrap the initial check in $(document).ready()
            $(document).ready(function() {
                if (tglDaftar === 'ajuanLama') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Pendaftaran Sebelum Skema Baru',
                        text: 'Harap diperhatikan, ini adalah pendaftaran sebelum diterapkannya skema baru. Oleh karena itu, tidak ada data pembayaran yang tersedia.',
                    });
                } else if (statusMidtrans === 'kosong'){
                    openModalPayment();
                }else if (statusMidtrans === 'expire') {
                    Swal.fire({
                        icon: 'error',
                        title: 'WAKTU PEMBAYARAN HABIS',
                        text: 'Status Pembayaran telah kedaluwarsa, silakan mengisi form pendaftaran kembali, Terima kasih',
                    });
                } else if (statusMidtrans != 'expire' && statusMidtrans != 'success'){
                    openSnapPayment(); // Proceed with Snap payment if status is not 'kosong'
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'PEMBAYARAN BERHASIL',
                        text: 'Pendaftaran Telah diterima silakan menunggu informasi lebih lanjut, Terima kasih',
                    });
                }
            });

            document.getElementById('pay-button')?.addEventListener('click', function() {
                if (tglDaftar === 'ajuanLama') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Pendaftaran Sebelum Skema Baru',
                        text: 'Harap diperhatikan, ini adalah pendaftaran sebelum diterapkannya skema baru. Oleh karena itu, tidak ada data pembayaran yang tersedia.',
                    });
                } else if (statusMidtrans === 'kosong') {
                    openModalPayment();
                } else {
                    openSnapPayment();
                }
            });
        </script>
    @endif
@endsection