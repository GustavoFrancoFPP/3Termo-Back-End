<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Classroom extends Model
{
    protected $fillable = [
        'name',
        'code',
        'block',
        'capacity',
        'location',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'capacity' => 'integer',
    ];

    /**
     * Professores que ministram aulas nesta sala.
     */
    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'teacher_classroom',
            'classroom_id',
            'teacher_id'
        )->where('role', 'professor')->withTimestamps();
    }

    /**
     * Alunos desta sala.
     */
    public function students()
    {
        return Student::where('class', $this->name)->get();
    }
}
