<?php

namespace App\Exports;

use App\Models\StokSeragam;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StokExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = StokSeragam::select('mhs.kode_produk', 'mps.nama_produk', 'mjps.jenis_produk', 'mus.ukuran_seragam', 'mhs.harga', 'mhs.diskon', 't_stok_seragam.qty')
                ->leftJoin('m_harga_seragam as mhs', 'mhs.kode_produk', 't_stok_seragam.kd_barang')
                ->leftJoin('m_produk_seragam as mps', 'mhs.produk_id', 'mps.id')
                ->leftJoin('m_jenis_produk_seragam as mjps', 'mhs.jenis_produk_id', 'mjps.id')
                ->leftJoin('m_ukuran_seragam as mus', 'mhs.ukuran_id', 'mus.id')
                ->get();
        return $data;
    }

    public function headings(): array
    {
        return [
            'Kode Produk',
            'Nama Produk',
            'Jenis Produk',
            'Ukuran',
            'Harga',
            'Diskon',
            'Quantity',
        ];
    }
}
