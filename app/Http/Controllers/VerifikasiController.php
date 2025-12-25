<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    /**
     * Display a listing of pending users.
     */
    public function index()
    {
        $users = User::where('status', 'pending')->where('role', 'masyarakat')->latest()->get();
        return view('verifikasi.index', compact('users'));
    }

    /**
     * Approve user status.
     */
    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'active';
        $user->save();

        return back()->with('success', 'Akun ' . $user->name . ' berhasil disetujui.');
    }

    /**
     * Reject user status.
     */
    public function reject($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'rejected';
        $user->save();

        return back()->with('success', 'Akun ' . $user->name . ' telah ditolak.');
    }
}
