<?php

namespace App\Exports;

use App\Models\Penduduk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PendudukPerKKExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Penduduk::select('no_kk')
            ->selectRaw('COUNT(*) as jumlah_anggota')
            ->groupBy('no_kk')
            ->get();
    }

    public function headings(): array
    {
        return ['Nomor KK', 'Jumlah Anggota'];
    }
}
