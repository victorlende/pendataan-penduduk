<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyncLog extends Model
{
    use HasFactory;

    protected $table = 'sync_logs';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'device_id',
        'action',
        'table_name',
        'record_count',
        'success_count',
        'failed_count',
        'errors',
        'created_at',
    ];

    protected $casts = [
        'errors' => 'array',
        'created_at' => 'datetime',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope untuk filter by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope untuk filter by table
     */
    public function scopeByTable($query, $tableName)
    {
        return $query->where('table_name', $tableName);
    }

    /**
     * Get success rate
     */
    public function getSuccessRateAttribute()
    {
        if ($this->record_count == 0) {
            return 0;
        }

        return round(($this->success_count / $this->record_count) * 100, 2);
    }
}
