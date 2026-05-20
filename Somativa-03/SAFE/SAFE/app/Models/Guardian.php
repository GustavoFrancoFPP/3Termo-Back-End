<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guardian extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'relationship',
        'document',
        'can_authorize_exit',
        'receive_notifications',
        'notification_preferences',
    ];

    protected $casts = [
        'can_authorize_exit' => 'boolean',
        'receive_notifications' => 'boolean',
    ];

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function authorizations(): HasMany
    {
        return $this->hasMany(Authorization::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(SafeNotification::class);
    }
}
