<?php

namespace App\Exports;

use App\Models\Penduduk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PendudukPerDusunExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Penduduk::select('dusun')
            ->selectRaw('COUNT(*) as jumlah_penduduk')
            ->groupBy('dusun')
            ->get();
    }

    public function headings(): array
    {
        return ['Dusun', 'Jumlah Penduduk'];
    }
}
