<?php

namespace App\Http\Controllers;

use App\Models\SuratKeterangan;
use Illuminate\Http\Request;

class SuratPrintController extends Controller
{
    public function print($id)
    {
        \Carbon\Carbon::setLocale('id');
        $surat = SuratKeterangan::with(['penduduk', 'penduduk.dusun'])->findOrFail($id);

        // Try to find dynamic template
        $template = \App\Models\LetterTemplate::where('key', $surat->jenis_surat)->first();

        if ($template) {
            $content = $template->content;
            $penduduk = $surat->penduduk;

            // Define replacements
            $replacements = [
                '[NAMA]' => strtoupper($penduduk->nama_lengkap),
                '[NIK]' => $penduduk->nik,
                '[TTL]' => $penduduk->tempat_lahir . ', ' . \Carbon\Carbon::parse($penduduk->tanggal_lahir)->translatedFormat('d F Y'),
                '[JK]' => $penduduk->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
                '[AGAMA]' => $penduduk->agama,
                '[PEKERJAAN]' => $penduduk->pekerjaan,
                '[ALAMAT]' => 'Dusun ' . ($penduduk->dusun ? $penduduk->dusun->nama_dusun : '-') . ', Desa Naisau',
                '[KEPERLUAN]' => $surat->keperluan,
                '[NOMOR_SURAT]' => $surat->nomor_surat,
                '[TANGGAL_SURAT]' => \Carbon\Carbon::now()->translatedFormat('d F Y'),
            ];

            // Perform replacement
            foreach ($replacements as $key => $value) {
                $content = str_replace($key, $value ?? '-', $content);
            }

            return view('surat.print.dynamic', compact('surat', 'content'));
        }

        // Fallback to static views if no template found (backup)
        $viewMap = [
            'domisili' => 'surat.print.domisili',
            'tidak_mampu' => 'surat.print.sktm',
            'usaha' => 'surat.print.usaha',
            'kelahiran' => 'surat.print.kelahiran',
            'kematian' => 'surat.print.kematian',
        ];

        // Determine view, default to generic if not found
        $view = $viewMap[$surat->jenis_surat] ?? 'surat.print.default';

        return view($view, compact('surat'));
    }
}
