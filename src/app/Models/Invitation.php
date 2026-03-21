<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'email',
        'token',
        'is_used',
        'expires_at',
    ];
    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'is_used' => 'boolean',
        ];
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
