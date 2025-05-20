<?php

namespace App\Exports;

use App\Models\Wishlist;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WishlistExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = Wishlist::select('m_produk_seragam.nama_produk', 'mhs.kode_produk', 'mjps.jenis_produk', 't_wishlist_seragam.ukuran', 
                        't_wishlist_seragam.quantity',  't_wishlist_seragam.created_at')
                        ->leftJoin('m_produk_seragam', 'm_produk_seragam.id', 't_wishlist_seragam.produk_id')
                        ->leftJoin('m_jenis_produk_seragam as mjps', 'mjps.id', 't_wishlist_seragam.jenis')
                        ->leftJoin('m_ukuran_seragam as mus', 'mus.ukuran_seragam', 't_wishlist_seragam.ukuran')
                        ->leftJoin('m_harga_seragam as mhs', function($join)
                        { $join->on('mhs.produk_id', '=', 'm_produk_seragam.id') 
                            ->on('mhs.jenis_produk_id', '=', 'mjps.id')
                            ->on('mus.id', '=', 'mhs.ukuran_id'); 
                        })
                        ->where('t_wishlist_seragam.status_wl', 1)
                        ->get();

        return $data;
    }

    public function headings(): array
    {
        return [
            'Nama Produk',
            'Kode Produk',
            'Jenis Produk',
            'Ukuran',
            'Quantity',
            'Created_at'
        ];
    }
}
