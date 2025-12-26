<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dusun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $petugas = User::where('role', 'petugas')->with('dusun')->latest()->get();
        $dusuns = Dusun::all();
        return view('petugas.index', compact('petugas', 'dusuns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('petugas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'nik' => 'required|string|size:16|unique:users',
            'phone_number' => 'required|string|max:15',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nik' => $request->nik,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'role' => 'petugas',
        ]);

        return redirect()->route('petugas.index')
            ->with('success', 'Petugas berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Not implemented
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $petugas = User::findOrFail($id);
        return view('petugas.edit', compact('petugas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'nik' => 'required|string|size:16|unique:users,nik,'.$id,
            'phone_number' => 'required|string|max:15',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $petugas = User::findOrFail($id);
        
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'nik' => $request->nik,
            'phone_number' => $request->phone_number,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $petugas->update($data);

        return redirect()->route('petugas.index')
            ->with('success', 'Data petugas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $petugas = User::findOrFail($id);
        
        // Prevent deleting self just in case, though role check helps
        if (auth()->id() == $id) {
             return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $petugas->delete();

        return redirect()->route('petugas.index')
            ->with('success', 'Petugas berhasil dihapus.');
    }

    /**
     * Assign petugas to dusun.
     */
    public function assignDusun(Request $request, string $id)
    {
        $request->validate([
            'dusun_id' => 'required|exists:dusuns,id',
        ]);

        $petugas = User::findOrFail($id);
        $petugas->update(['dusun_id' => $request->dusun_id]);

        return redirect()->route('petugas.index')
            ->with('success', 'Wilayah tugas berhasil diperbarui.');
    }
}
