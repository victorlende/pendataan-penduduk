<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dusun extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_dusun',
        'kepala_dusun',
    ];

    public function kks()
    {
        return $this->hasMany(Kk::class);
    }

    public function petugas()
    {
        return $this->hasMany(User::class, 'dusun_id')->where('role', 'petugas');
    }
}
