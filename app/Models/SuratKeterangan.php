<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeterangan extends Model
{
    use HasFactory;

    protected $table = 'surat_keterangan';

    protected $fillable = [
        'nomor_surat',
        'pemohon_id',
        'jenis_surat',
        'keperluan',
        'status',
        'file_surat',
        'catatan_admin',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    protected $appends = [
        'status_label',
        'jenis_surat_label',
    ];

    /**
     * Relasi ke Penduduk (pemohon)
     */
    public function pemohon()
    {
        return $this->belongsTo(Penduduk::class, 'pemohon_id');
    }

    /**
     * Alias for pemohon
     */
    public function penduduk()
    {
        return $this->pemohon();
    }

    /**
     * Relasi ke User (admin yang approve)
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Accessor untuk status label
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu Persetujuan',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            default => $this->status,
        };
    }

    /**
     * Accessor untuk jenis surat label
     */
    public function getJenisSuratLabelAttribute()
    {
        return match($this->jenis_surat) {
            'domisili' => 'Surat Keterangan Domisili',
            'tidak_mampu' => 'Surat Keterangan Tidak Mampu',
            'usaha' => 'Surat Keterangan Usaha',
            'kelahiran' => 'Surat Keterangan Kelahiran',
            'kematian' => 'Surat Keterangan Kematian',
            default => $this->jenis_surat,
        };
    }

    /**
     * Scope untuk filter berdasarkan status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk data pending
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Generate nomor surat
     */
    public static function generateNomorSurat($jenisSurat)
    {
        $prefix = match($jenisSurat) {
            'domisili' => 'SKD',
            'tidak_mampu' => 'SKTM',
            'usaha' => 'SKU',
            'kelahiran' => 'SKL',
            'kematian' => 'SKM',
            default => 'SK',
        };

        $bulanRomawi = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $bulan = $bulanRomawi[date('n') - 1];
        $tahun = date('Y');

        // Hitung urutan surat di bulan ini
        $count = static::whereYear('created_at', $tahun)
            ->whereMonth('created_at', date('m'))
            ->where('jenis_surat', $jenisSurat)
            ->count() + 1;

        return sprintf('%s/%03d/%s/%s', $prefix, $count, $bulan, $tahun);
    }
}
