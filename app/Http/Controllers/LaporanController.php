<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        // 1. Jenis Kelamin
        $gender = Penduduk::select('jenis_kelamin', DB::raw('count(*) as total'))
                    ->groupBy('jenis_kelamin')
                    ->pluck('total', 'jenis_kelamin');

        // 2. Pendidikan Terakhir
        $pendidikan = Penduduk::select('pendidikan_terakhir', DB::raw('count(*) as total'))
                        ->whereNotNull('pendidikan_terakhir')
                        ->groupBy('pendidikan_terakhir')
                        ->orderBy('total', 'desc')
                        ->limit(10)
                        ->pluck('total', 'pendidikan_terakhir');

        // 3. Pekerjaan (Top 10)
        $pekerjaan = Penduduk::select('pekerjaan', DB::raw('count(*) as total'))
                        ->whereNotNull('pekerjaan')
                        ->groupBy('pekerjaan')
                        ->orderBy('total', 'desc')
                        ->limit(10)
                        ->pluck('total', 'pekerjaan');

        // 4. Status Perkawinan
        $perkawinan = Penduduk::select('status_perkawinan', DB::raw('count(*) as total'))
                        ->whereNotNull('status_perkawinan')
                        ->groupBy('status_perkawinan')
                        ->pluck('total', 'status_perkawinan');
        
        // 5. Agama
        $agama = Penduduk::select('agama', DB::raw('count(*) as total'))
                    ->whereNotNull('agama')
                    ->groupBy('agama')
                    ->pluck('total', 'agama');

        // 6. Kelompok Umur (Logic PHP)
        $all_dob = Penduduk::pluck('tanggal_lahir');
        $umur_stats = [
            'Balita (0-5)' => 0,
            'Anak (6-12)' => 0,
            'Remaja (13-17)' => 0,
            'Dewasa (18-59)' => 0,
            'Lansia (60+)' => 0,
        ];

        foreach ($all_dob as $dob) {
            if (!$dob) continue;
            $age = Carbon::parse($dob)->age;

            if ($age <= 5) $umur_stats['Balita (0-5)']++;
            elseif ($age <= 12) $umur_stats['Anak (6-12)']++;
            elseif ($age <= 17) $umur_stats['Remaja (13-17)']++;
            elseif ($age <= 59) $umur_stats['Dewasa (18-59)']++;
            else $umur_stats['Lansia (60+)']++;
        }

        return view('laporan.index', compact(
            'gender', 
            'pendidikan', 
            'pekerjaan', 
            'perkawinan', 
            'agama', 
            'umur_stats'
        ));
    }

    // Placeholder method if routes point to these, to avoid errors
    public function pendudukPerDusun() { return abort(404); }
    public function pendudukPerKK() { return abort(404); }
    public function rekapPenduduk() { return abort(404); }
}
