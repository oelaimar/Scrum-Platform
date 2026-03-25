<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\Retrospective;
use App\Models\Standup;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
            'status' => UserStatus::class,
        ];
    }
    public function isTeacher(): bool
    {
        return $this->role === UserRole::TEACHER;
    }
    public function isStudent(): bool
    {
        return $this->role === UserRole::STUDENT;
    }
    public function managedProjects()
    {
        return $this->hasMany(Project::class, 'teacher_id');
    }
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_user')->withTimestamps();
    }
    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_user')
            ->withPivot('status', 'solution_link', 'teacher_feedback')
            ->withTimestamps();
    }
    public function standups()
    {
        return $this->hasMany(Standup::class);
    }
    public function retrospectives()
    {
        return $this->hasMany(Retrospective::class);
    }
    public function taskProgress()
    {
        return $this->hasMany(TaskProgress::class);
    }
}
