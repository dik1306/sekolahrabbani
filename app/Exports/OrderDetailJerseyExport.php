<?php

namespace App\Exports;

use App\Models\OrderDetailJersey;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderDetailJerseyExport implements FromCollection, WithHeadings
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
        $data = OrderDetailJersey::select('t_pesan_jersey_detail.no_pesanan', 't_pesan_jersey_detail.nama_siswa', 't_pesan_jersey_detail.lokasi_sekolah',
                    't_pesan_jersey_detail.nama_kelas', 'mj.nama_jersey', 't_pesan_jersey_detail.ukuran_id', 't_pesan_jersey_detail.quantity', 
                    't_pesan_jersey_detail.nama_punggung', 't_pesan_jersey_detail.no_punggung', 't_pesan_jersey_detail.created_at',)
                    ->leftJoin('t_pesan_jersey as tpj', 'tpj.no_pesanan', 't_pesan_jersey_detail.no_pesanan')
                    ->leftJoin('m_jersey as mj', 'mj.id', 't_pesan_jersey_detail.jersey_id')
                    ->leftJoin('m_ukuran_seragam as mus', 'mus.id', 't_pesan_jersey_detail.ukuran_id')
                    ->where('tpj.status', 'success')
                    ->whereBetween('tpj.updated_at', [$this->from_date,$this->to_date])
                    ->get();
        return $data;
    }

    public function headings(): array
    {
        return [
            'No Invoice',
            'Nama Siswa',
            'Sekolah',
            'Nama Kelas',
            'Nama Produk',
            'Ukuran',
            'Quantity',
            'Nama Punggung',
            'No Punggung',
            'Waktu',
        ];
    }
}
