<?php

namespace App\Http\Controllers;

use App\Models\Mutasi;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MutasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mutasi = Mutasi::with('penduduk')->latest()->get();
        return view('mutasi.index', compact('mutasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Only show penduduk that are currently active (Tetap/Pendatang)
        $penduduk = Penduduk::whereIn('status_penduduk', ['Tetap', 'Pendatang'])->get();
        return view('mutasi.create', compact('penduduk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'penduduk_id' => 'required|exists:penduduk,id',
            'jenis_mutasi' => 'required|in:Meninggal,Pindah', // Only allow negative mutations for now
            'tanggal_mutasi' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // 1. Create Mutasi Record
                Mutasi::create([
                    'penduduk_id' => $request->penduduk_id,
                    'jenis_mutasi' => $request->jenis_mutasi,
                    'tanggal_mutasi' => $request->tanggal_mutasi,
                    'keterangan' => $request->keterangan,
                ]);

                // 2. Update Penduduk Status
                $penduduk = Penduduk::findOrFail($request->penduduk_id);
                $penduduk->status_penduduk = $request->jenis_mutasi; // 'Meninggal' or 'Pindah'
                $penduduk->save();
            });

            return redirect()->route('mutasi.index')
                ->with('success', 'Data mutasi berhasil dicatat dan status penduduk diperbarui.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data mutasi: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $mutasi = Mutasi::findOrFail($id);
        
        // Optional: Revert penduduk status if mutasi delete?
        // For now, let's keep it simple and just delete the log, or maybe warn user.
        // Ideally, deleting mutasi log shouldn't necessarily revive a person, but for data consistency it might be needed.
        // Let's implement reversion for safety.
        
        try {
            DB::transaction(function () use ($mutasi) {
                $penduduk = $mutasi->penduduk;
                
                // Only revert if the current status matches the mutasi type (to prevent conflicting updates)
                if ($penduduk->status_penduduk == $mutasi->jenis_mutasi) {
                    $penduduk->status_penduduk = 'Tetap'; // Default back to Tetap
                    $penduduk->save();
                }

                $mutasi->delete();
            });

            return redirect()->route('mutasi.index')->with('success', 'Data mutasi dihapus (Status penduduk dikembalikan ke Tetap jika sesuai).');
        } catch (\Exception $e) {
             return back()->with('error', 'Gagal menghapus mutasi.');
        }
    }
}
