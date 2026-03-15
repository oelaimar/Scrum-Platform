<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'sprint_id',
        'title',
        'description',
        'story_point',
    ];
    public function sprint()
    {
        return $this->belongsTo(Sprint::class);
    }
    public function students()
    {
        return $this->belongsToMany(User::class, 'task_user')
            ->withPivot('status', 'solution_link', 'teacher_feedback')
            ->withTimestamps();
    }
}

