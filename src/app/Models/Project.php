<?php

namespace App\Models;

use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'teacher_id',
        'status',
    ];
    protected function casts(): array
    {
        return [
          'status' => ProjectStatus::class,
        ];
    }
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function students()
    {
        return $this->belongsToMany(User::class, 'project_user')->withTimestamps();
    }
    public function sprints()
    {
        return $this->hasMany(Sprint::class);
    }
    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }
}
