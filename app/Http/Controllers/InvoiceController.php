<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Models\Pendaftaran;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function generateInvoice($id_anak)
    {
        // Ambil data pendaftaran
        $data_pendaftaran = Pendaftaran::where('id_anak', $id_anak)->first();

        // dd($id_anak, $data_pendaftaran->id_anak);

        if (!$data_pendaftaran) {
            return redirect()->back()->with('error', 'Data pendaftaran tidak ditemukan');
        }

        // Format data untuk ditampilkan di PDF
        $data = [
            'nama' => $data_pendaftaran->nama_lengkap,
            'order_id' => $data_pendaftaran->order_id,
            'id_anak' => $data_pendaftaran->id_anak,
            'tgl_bayar' => $data_pendaftaran->tgl_bayar ? Carbon::parse($data_pendaftaran->tgl_bayar)->locale('id')->isoFormat('D MMMM YYYY HH:mm') : 'Belum bayar',
            'status_pembayaran' => $data_pendaftaran->status_pembayaran,
            'metode_pembayaran' => ucfirst($data_pendaftaran->metode_pembayaran),
            'total_harga' => number_format($data_pendaftaran->total_harga, 0, ',', '.'),
            'expire_time' => $data_pendaftaran->expire_time ? Carbon::parse($data_pendaftaran->expire_time)->locale('id')->isoFormat('D MMMM YYYY HH:mm') : 'Tidak berlaku',
        ];

        // Load view untuk invoice
        $pdf = PDF::loadView('ortu.invoices.invoice_pendaftaran', $data);
        
        // Generate PDF dan langsung download
        return $pdf->stream('invoice_' . $data_pendaftaran->id_anak . '.pdf');
    }
}
