<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\Kk;
use App\Models\SuratKeterangan;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_penduduk' => Penduduk::count(),
            'total_kk' => Kk::count(),
            'surat_pending' => SuratKeterangan::where('status', 'pending')->count(),
            'user_pending' => User::where('status', 'pending')->where('role', 'masyarakat')->count(),
        ];


        $latest_surat = SuratKeterangan::with('penduduk')->latest()->take(5)->get();

        return view('dashboard.index', compact('stats', 'latest_surat'));
    }
}
