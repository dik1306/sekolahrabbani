<?php

namespace App\Exports;

use App\Models\DesainPalestineday;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ListKarya implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = DesainPalestineday::select('t_desain_palestineday.nis', 't_desain_palestineday.nama_siswa',
                    'mls.sublokasi', 't_desain_palestineday.nama_kelas', 't_desain_palestineday.updated_by', 't_desain_palestineday.created_at' )
                    ->leftJoin('mst_lokasi_sub as mls', 't_desain_palestineday.sekolah_id', 'mls.id')
                    ->groupby('t_desain_palestineday.nis')
                    ->get();
        return $data;
    }

    public function headings(): array
    {
        return [
            'NIS',
            'Nama Siswa',
            'Lokasi/Sekolah',
            'Nama Kelas',
            'Update By',
            'Waktu',
        ];
    }
}
