<?php

namespace App\Services;

use App\Models\Project;
use App\Models\User;
use App\Models\TaskProgress;

class ProjectService
{
    public function createProject(User $teacher, array $data): Project
    {
        return Project::create([
            'teacher_id' => $teacher->id,
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
        ]);
    }
    public function updateProject(Project $project, array $data): Project
    {
        $project->update([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
        ]);

        return $project->fresh();
    }
    public function getProjectStats(Project $project): array
    {
        $studentCount = $project->students()->count();
        $sprintCount = $project->sprints()->count();
        $taskCount = $project->tasks()->count();
        $activeSprint = $project->sprints()->where('status', '=', \App\Enums\SprintStatus::ACTIVE->value)->first();

        return [
            'student_count' => $studentCount,
            'sprint_count' => $sprintCount,
            'task_count' => $taskCount,
            'active_sprint' => $activeSprint,
            'has_active_sprint' => $activeSprint !== null,
        ];
    }
    public function addStudent(Project $project, User $student): void
    {
        $project->students()->syncWithoutDetaching([$student->id]);

        // Initialize task progress for any active sprint
        $activeSprint = $project->activeSprint;
        if ($activeSprint) {
            foreach ($activeSprint->tasks as $task) {
                TaskProgress::firstOrCreate([
                    'task_id' => $task->id,
                    'user_id' => $student->id,
                ], [
                    'status' => \App\Enums\TaskStatus::TODO,
                ]);
            }
        }
    }
    public function removeStudent(Project $project, User $student): void
    {
        $project->students()->detach($student->id);
    }
}
