<?php

namespace App\Exports;

use App\Models\HaveRead;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HaveReadList implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = HaveRead::select('mpro.nis', 'mpro.nama_lengkap', 'mls.sublokasi as lokasi', 'mpro.nama_kelas', 'mpd.judul', 't_sudah_baca_materi.created_at', )
                    ->leftJoin('m_palestine_day as mpd', 'mpd.id', 't_sudah_baca_materi.materi_id')
                    ->leftJoin('m_profile as mpro', 'mpro.nis', 't_sudah_baca_materi.nis')
                    ->leftJoin('mst_lokasi_sub as mls', 'mpro.sekolah_id', 'mls.id')
                    ->groupby('t_sudah_baca_materi.materi_id', 't_sudah_baca_materi.nis')
                    ->get();
        return $data;
    }

    public function headings(): array
    {
        return [
            'NIS',
            'Nama Lengkap',
            'Lokasi/Sekolah',
            'Nama Kelas',
            'Judul',
            'Waktu',
        ];
    }
}
