<?php

namespace App\Http\Controllers;

use App\Models\SuratKeterangan;
use App\Models\Notification;
use App\Services\TelegramService;
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
        $oldStatus = $surat->status;
        $surat->status = $request->status;
        $surat->save();

        // Buat notifikasi in-app
        Notification::create([
            'user_id' => $surat->penduduk->created_by,
            'title'   => 'Status Surat Diperbarui',
            'message' => 'Permohonan surat Anda saat ini berstatus: '.$request->status
        ]);

        // Kirim notifikasi Telegram ke masyarakat (jika sudah setup)
        $user = $surat->penduduk->user;
        if ($user && $user->telegram_chat_id) {
            $telegram = new TelegramService();

            $statusText = $this->getStatusText($request->status);
            $message = "📬 <b>Status Surat Diperbarui</b>\n\n" .
                       "📄 <b>Jenis Surat:</b> " . $surat->jenis_surat . "\n" .
                       "📋 <b>Nomor:</b> " . $surat->nomor_surat . "\n" .
                       "📊 <b>Status:</b> " . $statusText . "\n\n" .
                       ($request->status == 'selesai' ?
                           "✅ Surat Anda sudah selesai dan dapat diambil di kantor desa." :
                           "Mohon ditunggu untuk proses selanjutnya.");

            $telegram->notifyUser($user->telegram_chat_id, $message);
        }

        return back()->with('success','Status surat berhasil diperbarui.');
    }

    private function getStatusText($status)
    {
        $statusMap = [
            'pending' => '⏳ Pending',
            'diproses' => '🔄 Sedang Diproses',
            'selesai' => '✅ Selesai',
            'ditolak' => '❌ Ditolak',
        ];

        return $statusMap[$status] ?? $status;
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

            // Kirim notifikasi Telegram ke Admin
            $telegram = new TelegramService();
            $message = "🔔 <b>Permintaan Surat Baru</b>\n\n" .
                       "👤 <b>Pemohon:</b> " . $penduduk->nama . "\n" .
                       "📄 <b>Jenis:</b> " . $request->jenis_surat . "\n" .
                       "📝 <b>Keperluan:</b> " . $request->keperluan . "\n\n" .
                       "Mohon segera dicek di panel admin.";

            $telegram->notifyAdmin($message);

            return back()->with('success', 'Permohonan surat berhasil dikirim. Menunggu persetujuan admin.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim permohonan: ' . $e->getMessage());
        }
    }
}
