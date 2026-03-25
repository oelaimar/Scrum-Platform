<?php

namespace App\Services;

use App\Models\Sprint;
use App\Models\Task;
use App\Models\User;
use App\Enums\TaskStatus;

class TaskService
{
    /**
     * Create a new task for a sprint.
     */
    public function createTask(Sprint $sprint, array $data): Task
    {
        return Task::create([
            'sprint_id' => $sprint->id,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'priority' => $data['priority'] ?? 'medium',
        ]);
    }

    /**
     * Update a task.
     */
    public function updateTask(Task $task, array $data): Task
    {
        $task->update([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'priority' => $data['priority'] ?? $task->priority,
        ]);

        return $task->fresh();
    }

    /**
     * Update student's progress on a task.
     */
    public function updateProgress(
        Task $task,
        User $student,
        string $status,
        ?string $solutionLink = null
    ): \App\Models\TaskProgress {
        $progress = $task->getOrCreateProgressForStudent($student);

        $progress->update([
            'status' => $status,
            'solution_link' => $solutionLink ?? $progress->solution_link,
        ]);

        return $progress->fresh();
    }

    /**
     * Add teacher feedback to a student's task progress.
     */
    public function addFeedback(\App\Models\TaskProgress $progress, string $feedback): \App\Models\TaskProgress
    {
        $progress->update([
            'teacher_feedback' => $feedback,
        ]);

        return $progress->fresh();
    }
}
