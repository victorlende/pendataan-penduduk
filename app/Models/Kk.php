<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kk extends Model
{
    use HasFactory;

    protected $table = 'kks';

    protected $fillable = [
        'no_kk',
        'dusun_id',
        'alamat',
        'rt',
        'rw',
        'created_by',
    ];

    public function dusun()
    {
        return $this->belongsTo(Dusun::class);
    }

    public function penduduks()
    {
        return $this->hasMany(Penduduk::class, 'kk_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
