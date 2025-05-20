<?php

namespace App\Exports;

use App\Models\OrderMerchandise;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderMerchandiseExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $from_date;
    private $to_date;

    public function __construct($from_date, $to_date) {
        $this->from_date = $from_date;
        $this->to_date = $to_date;
    }

    public function collection()
    {
        $data = OrderMerchandise::select('no_pesanan', 'nama_pemesan', 'no_hp', 'total_harga', 'status', 'metode_pembayaran', 'kategori_metode', 'updated_at')
        ->where('status', 'success')
        ->whereBetween('updated_at', [$this->from_date,$this->to_date])
        ->get();

        return $data;
    }

    public function headings(): array
    {
        return [
            'No Invoice',
            'Nama Pemesan',
            'No Hp',
            'Total Harga',
            'Status',
            'Metode Pembayaran',
            'Kategori',
            'Waktu',
        ];
    }
}
