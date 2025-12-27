<?php

namespace App\Exports;

use App\Models\Laporan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function collection()
    {
        return Laporan::with('creator')->latest()->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal Generate',
            'Jam Generate',
            'Total Penduduk',
            'Total KK',
            'Lahir (Total)',
            'Meninggal (Total)',
            'Pindah (Total)',
            'Dibuat Oleh',
        ];
    }

    public function map($row): array
    {
        return [
            $row->created_at->format('d-m-Y'),
            $row->created_at->format('H:i:s'),
            $row->total_penduduk,
            $row->total_kk,
            $row->total_lahir,
            $row->total_meninggal,
            $row->total_pindah,
            $row->creator ? $row->creator->name : 'System',
        ];
    }
}
