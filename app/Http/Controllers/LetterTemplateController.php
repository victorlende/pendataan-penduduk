<?php

namespace App\Http\Controllers;

use App\Models\LetterTemplate;
use Illuminate\Http\Request;

class LetterTemplateController extends Controller
{
    public function index()
    {
        $templates = LetterTemplate::all();
        return view('surat.templates.index', compact('templates'));
    }

    public function edit($id)
    {
        $template = LetterTemplate::findOrFail($id);
        
        $availableVariables = [
            '[NAMA]' => 'Nama Lengkap Penduduk',
            '[NIK]' => 'Nomor Induk Kependudukan',
            '[TTL]' => 'Tempat, Tanggal Lahir (Format: Kupang, 20 Januari 1990)',
            '[JK]' => 'Jenis Kelamin (Laki-laki / Perempuan)',
            '[AGAMA]' => 'Agama',
            '[PEKERJAAN]' => 'Pekerjaan',
            '[ALAMAT]' => 'Alamat (Dusun)',
            '[KEPERLUAN]' => 'Keperluan Pembuatan Surat',
            '[NOMOR_SURAT]' => 'Nomor Surat',
            '[TANGGAL_SURAT]' => 'Tanggal Hari Ini (Format: 26 Desember 2025)',
        ];

        return view('surat.templates.edit', compact('template', 'availableVariables'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $template = LetterTemplate::findOrFail($id);
        $template->update([
            'content' => $request->content,
        ]);

        return redirect()->route('letter-templates.index')
            ->with('success', 'Template surat berhasil diperbarui.');
    }
}
