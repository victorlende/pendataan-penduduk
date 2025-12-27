<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exports\PendudukExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Laporan;
use App\Models\Kk;
use App\Models\Mutasi;
use App\Exports\LaporanExport;

class LaporanController extends Controller
{
    public function index()
    {
        $history = Laporan::with('creator')->latest()->get();

        // 1. Jenis Kelamin
        $gender = Penduduk::select('jenis_kelamin', DB::raw('count(*) as total'))
                    ->groupBy('jenis_kelamin')
                    ->pluck('total', 'jenis_kelamin');

        $pendidikan = Penduduk::select('pendidikan_terakhir', DB::raw('count(*) as total'))
                        ->whereNotNull('pendidikan_terakhir')
                        ->groupBy('pendidikan_terakhir')
                        ->orderBy('total', 'desc')
                        ->limit(10)
                        ->pluck('total', 'pendidikan_terakhir');


        $pekerjaan = Penduduk::select('pekerjaan', DB::raw('count(*) as total'))
                        ->whereNotNull('pekerjaan')
                        ->groupBy('pekerjaan')
                        ->orderBy('total', 'desc')
                        ->limit(10)
                        ->pluck('total', 'pekerjaan');


        $perkawinan = Penduduk::select('status_perkawinan', DB::raw('count(*) as total'))
                        ->whereNotNull('status_perkawinan')
                        ->groupBy('status_perkawinan')
                        ->pluck('total', 'status_perkawinan');
        
        $agama = Penduduk::select('agama', DB::raw('count(*) as total'))
                    ->whereNotNull('agama')
                    ->groupBy('agama')
                    ->pluck('total', 'agama');

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
            'umur_stats',
            'history'
        ));
    }

    public function store(Request $request)
    {
        // Calculate Statistics
        $totalPenduduk = Penduduk::count();
        $totalKk = Kk::count();
        
        // Mutasi logic: CHANGED to All-Time (Cumulative) as per user request.
        // NOTE: 'Kelahiran' currently is not supported in MutasiController (valid types: Meninggal, Pindah).
        // If needed, we might need to count Penduduk with status 'Lahir' or similar. 
        // For now we keep looking for 'Kelahiran' in case it's added later, or manual entries.
        $totalLahir = Mutasi::where('jenis_mutasi', 'Kelahiran')->count();
                        
        $totalMeninggal = Mutasi::where('jenis_mutasi', 'Meninggal')->count();

        $totalPindah = Mutasi::where('jenis_mutasi', 'Pindah')->count();

        Laporan::create([
            'created_by' => auth()->id(),
            'total_penduduk' => $totalPenduduk,
            'total_kk' => $totalKk,
            'total_lahir' => $totalLahir,
            'total_meninggal' => $totalMeninggal,
            'total_pindah' => $totalPindah,
        ]);

        return redirect()->back()->with('success', 'Rekap laporan berhasil disimpan.');
    }

    public function download(Request $request)
    {
        $category = $request->query('kategori');
        $value = $request->query('nilai');

        if ($category === 'rekap_laporan') {
            $fileName = 'rekap-laporan-'.now()->format('Y-m-d-His').'.xlsx';
            return Excel::download(new LaporanExport(), $fileName);
        }

        $fileName = 'data-penduduk-'.now()->format('Y-m-d-His').'.xlsx';

        return Excel::download(new PendudukExport($category, $value), $fileName);
    }

    public function pendudukPerDusun() { return abort(404); }
    public function pendudukPerKK() { return abort(404); }
    public function rekapPenduduk() { return abort(404); }
}
