<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Authorization extends Model
{
    protected $fillable = [
        'student_id',
        'guardian_id',
        'teacher_id',
        'admin_id',
        'professor_id',
        'type',
        'scheduled_time',
        'status',
        'authorized_at',
        'validated_at',
        'analyzed_by_professor_at',
        'professor_decision',
        'professor_notes',
        'checked_by_portaria_at',
        'portaria_status',
        'reason',
        'rejection_reason',
        'validation_code',
        'expires_at',
    ];

    protected $casts = [
        'authorized_at' => 'datetime',
        'validated_at' => 'datetime',
        'analyzed_by_professor_at' => 'datetime',
        'checked_by_portaria_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function getScheduledTimeFormattedAttribute(): string
    {
        if (!$this->scheduled_time) {
            return '-';
        }

        return substr((string) $this->scheduled_time, 0, 5);
    }

    public function getScheduledTimeLabelAttribute(): string
    {
        return $this->type === 'entry' ? 'Horario de entrada' : 'Horario de saida';
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function guardian(): BelongsTo
    {
        return $this->belongsTo(Guardian::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function professor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'professor_id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(SafeNotification::class);
    }
}
