<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporans';

    protected $fillable = [
        'created_by',
        'total_penduduk',
        'total_kk',
        'total_lahir',
        'total_meninggal',
        'total_pindah',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
