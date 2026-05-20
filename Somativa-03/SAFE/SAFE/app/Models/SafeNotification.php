<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SafeNotification extends Model
{
    protected $fillable = [
        'authorization_id',
        'guardian_id',
        'channel',
        'type',
        'message',
        'status',
        'response',
        'sent_at',
        'error_message',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function authorization(): BelongsTo
    {
        return $this->belongsTo(Authorization::class);
    }

    public function guardian(): BelongsTo
    {
        return $this->belongsTo(Guardian::class);
    }
}
