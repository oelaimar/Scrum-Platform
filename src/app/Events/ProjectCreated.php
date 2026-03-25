<?php

namespace App\Events;

use App\Models\Project;
use Illuminate\Queue\SerializesModels;

class ProjectCreated
{
    use SerializesModels;

    public function __construct(public Project $project)
    {
    }
}
