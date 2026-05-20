<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    protected $fillable = [
        'name',
        'email',
        'registration',
        'class',
        'can_authorize_exit',
        'is_active',
    ];

    protected $casts = [
        'can_authorize_exit' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function authorizations(): HasMany
    {
        return $this->hasMany(Authorization::class);
    }
}
