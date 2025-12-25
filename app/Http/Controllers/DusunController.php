<?php

namespace App\Http\Controllers;

use App\Models\Dusun;
use Illuminate\Http\Request;

class DusunController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dusuns = Dusun::latest()->get();
        return view('dusun.index', compact('dusuns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dusun.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_dusun' => 'required|string|max:50|unique:dusuns',
            'kepala_dusun' => 'required|string|max:100',
        ]);

        Dusun::create($request->all());

        return redirect()->route('dusun.index')
            ->with('success', 'Data Dusun berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dusun $dusun)
    {
        // For simplicity, we'll redirect to the edit page.
        return redirect()->route('dusun.edit', $dusun);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dusun $dusun)
    {
        return view('dusun.edit', compact('dusun'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dusun $dusun)
    {
        $request->validate([
            'nama_dusun' => 'required|string|max:50|unique:dusuns,nama_dusun,' . $dusun->id,
            'kepala_dusun' => 'required|string|max:100',
        ]);

        $dusun->update($request->all());

        return redirect()->route('dusun.index')
            ->with('success', 'Data Dusun berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dusun $dusun)
    {
        $dusun->delete();

        return redirect()->route('dusun.index')
            ->with('success', 'Data Dusun berhasil dihapus.');
    }
}