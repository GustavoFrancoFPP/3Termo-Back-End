<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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
     * Salas que este professor ministra aulas.
     */
    public function classrooms(): BelongsToMany
    {
        return $this->belongsToMany(
            Classroom::class,
            'teacher_classroom',
            'teacher_id',
            'classroom_id'
        )->withTimestamps();
    }

    /**
     * Alunos que este professor tem nas suas salas.
     */
    public function students()
    {
        return Student::whereIn('class', $this->classrooms()->pluck('name'))->get();
    }

    /**
     * Autorizações criadas por este admin.
     */
    public function createdAuthorizations()
    {
        return $this->hasMany(Authorization::class, 'admin_id');
    }

    /**
     * Autorizações para analisar (professor).
     */
    public function authorizationsToAnalyze()
    {
        return $this->hasMany(Authorization::class, 'professor_id');
    }

    /**
     * Verificar se é admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Verificar se é professor.
     */
    public function isProfessor(): bool
    {
        return $this->role === 'professor';
    }

    /**
     * Verificar se é portaria.
     */
    public function isPortaria(): bool
    {
        return $this->role === 'portaria';
    }
}
