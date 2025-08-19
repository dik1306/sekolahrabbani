<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $order_id }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background-color: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 100px;
            margin-bottom: 20px;
        }

        h2 {
            margin: 0;
            font-size: 26px;
            color: #333;
        }

        p {
            font-size: 16px;
            color: #666;
        }

        .header2 {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
        }

        .logo img {
            width: 150px;  /* Ukuran logo yang lebih kecil */
            height: auto;
        }

        .stamp {
            position: absolute;
            top: 0px;
            right: 00px;
            background-color: #28a745;
            color: white;
            padding: 10px 30px;
            font-weight: bold;
            font-size: 18px;
            border-radius: 50%;
            opacity: 0.8;
        }

        .table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .table th, .table td {
            padding: 10px 20px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .table th {
            background-color: #f1f1f1;
            font-weight: bold;
        }

        .table td {
            font-size: 16px;
            color: #555;
        }

        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table tr:hover {
            background-color: #f1f1f1;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 14px;
            color: #888;
        }

        .btn-download {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            margin-top: 20px;
            text-align: center;
        }

        .btn-download:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header2">
        <div class="logo">
            <img src="https://sekolahrabbani.sch.id/assets/images/logo.png" alt="Sekolah Rabbani Logo" class="logo">
        </div>

        <!-- Stamp "Telah Dibayar" -->
        @if ($status_pembayaran == 1)
            <div class="stamp">TELAH DIBAYAR</div>
        @endif
    </div>

    <div class="header">
        <h2>Invoice Pembayaran</h2>
        <p>Detail Pembayaran Pendaftaran Siswa Baru<br>
            <b>{{ $order_id }}</b>
        </p>
    </div>
    

   

    <table class="table">
        <tr>
            <th>ID Pendaftaran</th>
            <td>{{ $id_anak }}</td>
        </tr>
        <tr>
            <th>Nama Lengkap</th>
            <td>{{ $nama }}</td>
        </tr>
        <tr>
            <th>Status Pembayaran</th>
            <td>
                @if ($status_pembayaran == 0)
                    <span style="color: #dc3545;">Belum Bayar</span>
                @else
                    <span style="color: #28a745;">Sudah Bayar</span>
                @endif
            </td>
        </tr>
        <tr>
            <th>Metode Pembayaran</th>
            <td>{{ ucfirst($metode_pembayaran) }}</td>
        </tr>
        <tr>
            <th>Tanggal Pembayaran</th>
            <td>{{ $tgl_bayar }}</td>
        </tr>
        <tr>
            <th>Total Pembayaran</th>
            <td>Rp {{ $total_harga }}</td>
        </tr>
    </table>

    <div class="footer">
    <p>Status pendaftaran Ananda kini resmi tercatat di sistem Sekolah Rabbani dan akan diproses ke tahap selanjutnya.</p>
    <p>Untuk informasi lebih lanjut atau pertanyaan, silakan hubungi Customer Service kami di +6285173273274.</p>
    <p>Terima kasih atas kepercayaan Ayah/Bunda kepada Sekolah Rabbani.</p>

    <!-- Menempatkan 'Hormat Kami' dan 'Sekolah Rabbani' di pojok kanan bawah -->
    <div class="footer-signature">
        <p>Hormat kami,</p>
        <p>Sekolah Rabbani</p>
    </div>
</div>

<style>
    .footer {
        margin-top: 40px;
        text-align: justify; /* Membuat teks lainnya rata kiri */
        font-size: 14px;
        color: #888;
    }

    .footer-signature {
        position: absolute;
        bottom: 20px;
        right: 20px;
        text-align: right;
        font-weight: bold;
        color: #333;
    }

    .footer p {
        margin: 10px 0;
    }
</style>

</div>

</body>
</html>
