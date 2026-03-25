<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Retrospective extends Model
{
    protected $fillable = [
        'user_id',
        'sprint_id',
        'what_went_well',
        'what_needs_improvement',
        'action_items',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function sprint()
    {
        return $this->belongsTo(Sprint::class);
    }
}
