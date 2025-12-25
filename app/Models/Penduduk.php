<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Penduduk extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'penduduk';

    protected $fillable = [
        'uuid',
        'nik',
        'no_kk',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'pendidikan_terakhir',
        'pekerjaan',
        'status_perkawinan',
        'golongan_darah',
        'kewarganegaraan',
        'status_dalam_keluarga',
        'nama_ayah',
        'nama_ibu',
        'rt_rw',
        'kecamatan',
        'kelurahan',
        'alamat_lengkap',
        'no_telp',
        'photo_ktp',
        'user_id',
        'created_by',
        'is_synced',
        'synced_at',
        'kk_id',
        'status_penduduk',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'is_synced' => 'boolean',
        'synced_at' => 'datetime',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generate UUID saat create
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Relasi ke Kartu Keluarga (KK)
     */
    public function kk()
    {
        return $this->belongsTo(Kk::class);
    }

    /**
     * Relasi ke Mutasi
     */
    public function mutasi()
    {
        return $this->hasMany(Mutasi::class);
    }

    /**
     * Relasi ke User (akun masyarakat)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke User (petugas yang input)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relasi ke Surat Keterangan
     */
    public function suratKeterangan()
    {
        return $this->hasMany(SuratKeterangan::class, 'pemohon_id');
    }

    /**
     * Scope untuk filter berdasarkan RT/RW
     */
    public function scopeByRtRw($query, $rtRw)
    {
        return $query->where('rt_rw', $rtRw);
    }

    /**
     * Scope untuk data yang belum di-sync
     */
    public function scopeNotSynced($query)
    {
        return $query->where('is_synced', false);
    }

    /**
     * Scope untuk pencarian
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('nik', 'like', "%{$keyword}%")
                ->orWhere('nama_lengkap', 'like', "%{$keyword}%")
                ->orWhere('no_kk', 'like', "%{$keyword}%");
        });
    }

    /**
     * Get anggota keluarga berdasarkan no_kk
     */
    public function getAnggotaKeluargaAttribute()
    {
        return static::where('no_kk', $this->no_kk)
            ->where('id', '!=', $this->id)
            ->get();
    }
}
