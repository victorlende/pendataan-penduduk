<?php

namespace App\Exports;

use App\Models\Penduduk;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class PendudukExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $category;
    protected $value;

    public function __construct($category = null, $value = null)
    {
        $this->category = $category;
        $this->value = $value;
    }

    public function query()
    {
        $query = Penduduk::query()->with('dusun');

        if ($this->category) {
            switch ($this->category) {
                // Special handling for Age which needs sorting by DOB
                case 'kelompok_umur':
                    $query->orderBy('tanggal_lahir', 'desc');
                    break;
                // Otherwise sort by the column
                case 'jenis_kelamin':
                case 'agama':
                case 'pendidikan_terakhir':
                case 'pekerjaan':
                case 'status_perkawinan':
                    $query->orderBy($this->category);
                    break;
            }
        } else {
            // Default sort if no category
             $query->orderBy('updated_at', 'desc');
        }

        return $query;
    }



    public function headings(): array
    {
        return [
            'NIK',
            'No. KK',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Agama',
            'Pendidikan Terakhir',
            'Pekerjaan',
            'Status Perkawinan',
            'Golongan Darah',
            'Dusun',
            'RT/RW',
            'Alamat Lengkap',
            'Ayah',
            'Ibu',
        ];
    }

    public function map($row): array
    {
        return [
            $row->nik . ' ', // Force string to prevent scientific notation in Excel
            $row->no_kk . ' ',
            $row->nama_lengkap,
            $row->jenis_kelamin,
            $row->tempat_lahir,
            $row->tanggal_lahir ? $row->tanggal_lahir->format('d-m-Y') : '-',
            $row->agama,
            $row->pendidikan_terakhir,
            $row->pekerjaan,
            $row->status_perkawinan,
            $row->golongan_darah,
            $row->dusun ? $row->dusun->nama_dusun : '-',
            $row->rt_rw,
            $row->alamat_lengkap,
            $row->nama_ayah,
            $row->nama_ibu,
        ];
    }
}
