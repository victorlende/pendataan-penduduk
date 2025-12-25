<?php

namespace App\Http\Controllers;

use App\Models\Dusun;
use App\Models\Kk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kks = Kk::with('dusun')->latest()->get();
        return view('kk.index', compact('kks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dusuns = Dusun::all();
        return view('kk.create', compact('dusuns'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_kk' => 'required|string|max:20|unique:kks',
            'dusun_id' => 'required|exists:dusuns,id',
            'alamat' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
        ]);

        $data = $request->all();
        $data['created_by'] = Auth::id();

        Kk::create($data);

        return redirect()->route('kk.index')
            ->with('success', 'Data Kartu Keluarga berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kk $kk)
    {
        $kk->load('penduduks', 'dusun', 'creator');
        return view('kk.show', compact('kk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kk $kk)
    {
        $dusuns = Dusun::all();
        return view('kk.edit', compact('kk', 'dusuns'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kk $kk)
    {
        $request->validate([
            'no_kk' => 'required|string|max:20|unique:kks,no_kk,' . $kk->id,
            'dusun_id' => 'required|exists:dusuns,id',
            'alamat' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
        ]);

        $kk->update($request->all());

        return redirect()->route('kk.index')
            ->with('success', 'Data Kartu Keluarga berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kk $kk)
    {
        // Add a check to prevent deletion if there are still members in the KK
        if ($kk->penduduks()->count() > 0) {
            return redirect()->route('kk.index')
                ->with('error', 'Tidak dapat menghapus KK yang masih memiliki anggota.');
        }

        $kk->delete();

        return redirect()->route('kk.index')
            ->with('success', 'Data Kartu Keluarga berhasil dihapus.');
    }
}