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

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $penduduk = $query->latest()->get();

        return view('penduduk.index', [
            'penduduk' => $penduduk,
            'currentStatus' => $status
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kks = Kk::all();
        return view('penduduk.create', compact('kks'));
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
        ]);

        $kk = Kk::findOrFail($request->kk_id);

        $data = $request->all();
        $data['created_by'] = Auth::id();
        $data['no_kk'] = $kk->no_kk; // Get no_kk from the selected KK
        $data['rt_rw'] = $kk->rt . '/' . $kk->rw; // Get rt_rw from the selected KK
        $data['status'] = 'verified'; // Data added by admin is automatically verified

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
        return view('penduduk.edit', compact('penduduk', 'kks'));
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
        ]);

        $kk = Kk::findOrFail($request->kk_id);

        $data = $request->all();
        $data['no_kk'] = $kk->no_kk; // Update no_kk from the selected KK
        $data['rt_rw'] = $kk->rt . '/' . $kk->rw; // Update rt_rw from the selected KK

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
}
