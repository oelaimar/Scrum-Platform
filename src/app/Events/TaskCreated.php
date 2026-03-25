<?php

namespace App\Events;

use App\Models\Task;
use Illuminate\Queue\SerializesModels;

class TaskCreated
{
    use SerializesModels;

    public function __construct(public Task $task)
    {
    }
}
