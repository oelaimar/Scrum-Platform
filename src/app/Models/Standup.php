<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Standup extends Model
{
    protected $fillable = [
        'user_id',
        'sprint_id',
        'work_done',
        'work_planned',
        'blockers',
        'date',
    ];
    protected $casts = ['date' => 'date',];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function sprint()
    {
        return $this->belongsTo(Sprint::class);
    }
    public function scopeToday($query)
    {
        return $query->whereDate('date', today());
    }
}
