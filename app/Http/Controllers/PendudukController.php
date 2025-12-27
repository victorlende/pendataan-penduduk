<?php

namespace App\Http\Controllers;

use App\Models\Dusun;
use App\Models\Kk;
use App\Models\Penduduk;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendudukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending'); // Default to 'pending'

        $query = Penduduk::query()->with('kk.dusun');

        // Filter by verification status
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        // Filter by NIK
        if ($request->filled('nik')) {
            $query->where('nik', 'like', '%' . $request->nik . '%');
        }

        // Filter by Nama
        if ($request->filled('nama')) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama . '%');
        }

        // Filter by Jenis Kelamin
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        // Filter by Dusun
        if ($request->filled('dusun_id')) {
            $query->whereHas('kk', function($q) use ($request) {
                $q->where('dusun_id', $request->dusun_id);
            });
        }

        // Filter by RT
        if ($request->filled('rt')) {
            $query->whereHas('kk', function($q) use ($request) {
                $q->where('rt', $request->rt);
            });
        }

        // Filter by RW
        if ($request->filled('rw')) {
            $query->whereHas('kk', function($q) use ($request) {
                $q->where('rw', $request->rw);
            });
        }

        // Filter by Agama
        if ($request->filled('agama')) {
            $query->where('agama', $request->agama);
        }

        // Filter by Status Kependudukan
        if ($request->filled('status_penduduk')) {
            $query->where('status_penduduk', $request->status_penduduk);
        }

        // Filter by Pekerjaan
        if ($request->filled('pekerjaan')) {
            $query->where('pekerjaan', 'like', '%' . $request->pekerjaan . '%');
        }

        $penduduk = $query->latest()->get();
        $pendingCount = Penduduk::where('status', 'pending')->count();

        return view('penduduk.index', [
            'penduduk' => $penduduk,
            'currentStatus' => $status,
            'pendingCount' => $pendingCount
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kks = Kk::all();
        $dusuns = Dusun::all();
        return view('penduduk.create', compact('kks', 'dusuns'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|max:16|unique:penduduk',
            'kk_id' => 'required|exists:kks,id',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string',
            'status_perkawinan' => 'required|string',
            'status_penduduk' => 'required|string',
            'pendidikan_terakhir' => 'nullable|string',
            'pekerjaan' => 'nullable|string',
            'alamat_lengkap' => 'required|string',
            'golongan_darah' => 'nullable|string',
            'kewarganegaraan' => 'required|string',
            'status_dalam_keluarga' => 'required|string',
            'nama_ayah' => 'required|string',
            'nama_ibu' => 'required|string',
            'no_telp' => 'nullable|string',
            'dusun_id' => 'required|exists:dusuns,id',
            'rt' => 'required|string',
            'rw' => 'required|string',
            'photo_ktp' => 'nullable|image|max:2048', // Max 2MB
        ]);

        $kk = Kk::findOrFail($request->kk_id);

        $data = $request->except(['rt', 'rw']);
        $data['created_by'] = Auth::id();
        $data['no_kk'] = $kk->no_kk; // Get no_kk from the selected KK
        $data['rt_rw'] = $request->rt . '/' . $request->rw;
        $data['status'] = 'verified'; // Data added by admin is automatically verified

        if ($request->hasFile('photo_ktp')) {
            $data['photo_ktp'] = $request->file('photo_ktp')->store('ktp_photos', 'public');
        }

        Penduduk::create($data);

        return redirect()->route('penduduk.index')
            ->with('success', 'Data penduduk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $penduduk = Penduduk::with('kk.dusun', 'creator')->findOrFail($id);
        return view('penduduk.show', compact('penduduk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penduduk $penduduk)
    {
        $kks = Kk::all();
        $dusuns = Dusun::all();
        return view('penduduk.edit', compact('penduduk', 'kks', 'dusuns'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penduduk $penduduk)
    {
        $request->validate([
            'nik' => 'required|string|max:16|unique:penduduk,nik,' . $penduduk->id,
            'kk_id' => 'required|exists:kks,id',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string',
            'status_perkawinan' => 'required|string',
            'status_penduduk' => 'required|string',
            'pendidikan_terakhir' => 'nullable|string',
            'pekerjaan' => 'nullable|string',
            'alamat_lengkap' => 'required|string',
            'golongan_darah' => 'nullable|string',
            'kewarganegaraan' => 'required|string',
            'status_dalam_keluarga' => 'required|string',
            'nama_ayah' => 'required|string',
            'nama_ibu' => 'required|string',
            'no_telp' => 'nullable|string',
            'dusun_id' => 'required|exists:dusuns,id',
            'rt' => 'required|string',
            'rw' => 'required|string',
            'photo_ktp' => 'nullable|image|max:2048',
        ]);

        $kk = Kk::findOrFail($request->kk_id);

        $data = $request->except(['rt', 'rw']);
        $data['no_kk'] = $kk->no_kk; // Update no_kk from the selected KK
        $data['rt_rw'] = $request->rt . '/' . $request->rw;

        if ($request->hasFile('photo_ktp')) {
            // Delete old photo if exists
            if ($penduduk->photo_ktp && \Illuminate\Support\Facades\Storage::disk('public')->exists($penduduk->photo_ktp)) {
                 \Illuminate\Support\Facades\Storage::disk('public')->delete($penduduk->photo_ktp);
            }
            $data['photo_ktp'] = $request->file('photo_ktp')->store('ktp_photos', 'public');
        }

        $penduduk->update($data);

        return redirect()->route('penduduk.index')
            ->with('success', 'Data penduduk berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penduduk $penduduk)
    {
        $penduduk->delete();
        return redirect()->route('penduduk.index')
            ->with('success', 'Data penduduk berhasil dihapus.');
    }


    /**
     * Verifikasi data (hasil input mobile)
     */
    public function verify($id)
    {
        $penduduk = Penduduk::findOrFail($id);

        $penduduk->status = 'verified';
        $penduduk->save();

        // kirim notifikasi ke petugas
        Notification::create([
            'user_id' => $penduduk->created_by,
            'title'   => 'Data Diverifikasi',
            'message' => 'Data penduduk atas nama '.$penduduk->nama_lengkap.' telah diverifikasi oleh admin.'
        ]);

        return redirect()->route('penduduk.index')
            ->with('success', 'Data penduduk berhasil diverifikasi.');
    }

    /**
     * Tolak data (hasil input mobile)
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string|max:500'
        ]);

        $penduduk = Penduduk::findOrFail($id);

        $penduduk->status = 'rejected';
        $penduduk->alasan_penolakan = $request->alasan_penolakan;
        $penduduk->save();

        // kirim notifikasi ke petugas/masyarakat
        Notification::create([
            'user_id' => $penduduk->created_by,
            'title'   => 'Data Ditolak',
            'message' => 'Data penduduk atas nama '.$penduduk->nama_lengkap.' ditolak. Alasan: ' . $request->alasan_penolakan
        ]);

        return redirect()->route('penduduk.index')
            ->with('success', 'Data penduduk berhasil ditolak.');
    }
}
