<?php

namespace App\Exports;

use App\Models\Penduduk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RekapPendudukExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Penduduk::select(
            'nik',
            'nama',
            'jenis_kelamin',
            'dusun',
            'status'
        )->get();
    }

    public function headings(): array
    {
        return [
            'NIK',
            'Nama',
            'Jenis Kelamin',
            'Dusun',
            'Status'
        ];
    }
}
