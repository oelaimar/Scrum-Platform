<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Sprint;

use App\Enums\SprintStatus;

class SprintService
{
    public function createSprint(Project $project, array $data): Sprint
    {
        return Sprint::create([
            'project_id' => $project->id,
            'name' => $data['name'],
            'goal' => $data['goal'] ?? null,
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'status' => SprintStatus::PLANNED,
        ]);
    }
    public function updateSprint(Sprint $sprint, array $data): Sprint
    {
        $sprint->update([
            'name' => $data['name'],
            'goal' => $data['goal'] ?? null,
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
        ]);

        return $sprint->fresh();
    }
    public function startSprint(Sprint $sprint): bool
    {
        return $sprint->update(['status' => SprintStatus::ACTIVE]);
    }
    public function completeSprint(Sprint $sprint): bool
    {
        return $sprint->update(['status' => SprintStatus::COMPLETED]);
    }
    public function getSprintStats(Sprint $sprint): array
    {
        $tasks = $sprint->tasks;
        $totalTasks = $tasks->count();

        // In Scrum-Platform, task progress is currently in a pivot table task_user
        // We'll calculate stats based on the pivot for now, until TaskProgress model is added.
        $completedCount = 0;
        $inProgressCount = 0;
        $todoCount = 0;

        foreach ($tasks as $task) {
            // Task status in Scrum-Platform is in the task_user pivot or the task itself?
            // Checking Task controller/model again.
        }

        // For now, return basic stats
        return [
            'total_tasks' => $totalTasks,
            'stand_up_count' => $sprint->standups()->count(),
            'retrospective_count' => $sprint->retrospectives()->count(),
        ];
    }
}
