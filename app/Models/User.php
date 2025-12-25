<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'rt_rw',
        'telegram_chat_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke Penduduk (yang dibuat user ini)
     */
    public function pendudukCreated()
    {
        return $this->hasMany(Penduduk::class, 'created_by');
    }

    /**
     * Relasi ke Penduduk (akun masyarakat)
     */
    public function penduduk()
    {
        return $this->hasOne(Penduduk::class, 'user_id');
    }

    /**
     * Relasi ke SyncLog
     */
    public function syncLogs()
    {
        return $this->hasMany(SyncLog::class);
    }

    /**
     * Relasi ke Notification
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is petugas
     */
    public function isPetugas()
    {
        return $this->role === 'petugas';
    }

    /**
     * Check if user is masyarakat
     */
    public function isMasyarakat()
    {
        return $this->role === 'masyarakat';
    }

    /**
     * Scope untuk filter by role
     */
    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Scope untuk admin
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope untuk petugas
     */
    public function scopePetugas($query)
    {
        return $query->where('role', 'petugas');
    }

    /**
     * Scope untuk masyarakat
     */
    public function scopeMasyarakat($query)
    {
        return $query->where('role', 'masyarakat');
    }
}
