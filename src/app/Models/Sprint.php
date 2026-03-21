<?php

namespace App\Models;

use App\Enums\SprintStatus;
use Illuminate\Database\Eloquent\Model;

class Sprint extends Model
{
    protected $fillable = [
        'project_id',
        'name',
        'objective',
        'start_date',
        'end_date',
        'status',
    ];
    protected function casts(): array
    {
        return [
            'status' => SprintStatus::class,
            'start_date' => 'date',
            'end_date' => 'date' ,
        ];
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function retrospectives()
    {
        return $this->hasMany(Retrospective::class);
    }
    public function standups()
    {
        return $this->hasMany(Standup::class);
    }
}
