<?php

namespace App\Http\Controllers;

use App\Models\SuratKeterangan;
use App\Models\Notification;
use Illuminate\Http\Request;

class SuratKeteranganController extends Controller
{

    public function index()
    {
        $surat = SuratKeterangan::with('penduduk')
                    ->latest()
                    ->get();

        return view('surat.index', compact('surat'));
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required'
        ]);

        $surat = SuratKeterangan::findOrFail($id);
        $surat->status = $request->status;
        $surat->save();

        Notification::create([
            'user_id' => $surat->penduduk->created_by,
            'title'   => 'Status Surat Diperbarui',
            'message' => 'Permohonan surat Anda saat ini berstatus: '.$request->status
        ]);

        return back()->with('success','Status surat berhasil diperbarui.');
    }

    public function mySurat()
    {
        // Get the logged in user's penduduk ID
        $penduduk = auth()->user()->penduduk;
        
        if (!$penduduk) {
            return back()->with('error', 'Data kependudukan belum terhubung dengan akun Anda.');
        }

        $surat = SuratKeterangan::where('pemohon_id', $penduduk->id)
                    ->latest()
                    ->get();

        return view('surat.my', compact('surat'));
    }

    public function storeRequest(Request $request)
    {
        $request->validate([
            'jenis_surat' => 'required',
            'keperluan' => 'required|string',
        ]);

        $penduduk = auth()->user()->penduduk;

        if (!$penduduk) {
             return back()->with('error', 'Akun Anda tidak terhubung dengan data penduduk.');
        }

        try {
            $nomorSurat = SuratKeterangan::generateNomorSurat($request->jenis_surat);

            SuratKeterangan::create([
                'nomor_surat' => $nomorSurat,
                'pemohon_id' => $penduduk->id,
                'jenis_surat' => $request->jenis_surat,
                'keperluan' => $request->keperluan,
                'status' => 'pending',
            ]);

            return back()->with('success', 'Permohonan surat berhasil dikirim. Menunggu persetujuan admin.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim permohonan: ' . $e->getMessage());
        }
    }
}
