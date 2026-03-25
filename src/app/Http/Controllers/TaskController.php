<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Http\Requests\EvaluateTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskProgressRequest;
use App\Models\Sprint;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\TaskService;
use App\Events\TaskCreated;
use App\Models\TaskProgress;

class TaskController extends Controller
{
    public function __construct(
        protected TaskService $taskService
    ) {}

    public function create(Sprint $sprint)
    {
        if($sprint->project->teacher_id !== Auth::id()){
            abort(403);
        }
        return view('tasks.create', compact('sprint'));
    }

    public function store(StoreTaskRequest $request, Sprint $sprint)
    {
        $task = $this->taskService->createTask($sprint, $request->validated());

        $students = $sprint->project->students;
        foreach ($students as $student) {
            TaskProgress::create([
                'task_id' => $task->id,
                'user_id' => $student->id,
                'status' => \App\Enums\TaskStatus::TODO->value,
            ]);
        }

        event(new TaskCreated($task));
        return redirect()->route('projects.show', $sprint->project_id)
            ->with('success', 'Task created and assigned to all students!');
    }
    public function show(Task $task)
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user->isStudent() && !$user->tasks()->where('tasks.id', $task->id)->exists()){
            abort(403, 'You are not assigned to this task.');
        }
        if ($user->isTeacher()){
            if ($task->sprint->project->teacher_id !== $user->id) abort(403);
            $progressRecords = $task->progress()->with('user')->get();
            return view('tasks.teacher_show', compact('task', 'progressRecords'));
        }
        $taskProgress = $user->taskProgress()->where('task_id', '=', $task->id)->first();
        return view('tasks.student_show', compact('task', 'taskProgress'));
    }
    public function updateProgress(UpdateTaskProgressRequest $request, Task $task)
    {
        /** @var User $user */
        $user = Auth::user();

        $this->taskService->updateProgress(
            $task,
            $user,
            $request->status,
            $request->solution_link
        );

        return back()->with('success', 'Task progress updated successfully!');
    }
    public function evaluate(EvaluateTaskRequest $request, Task $task, User $student)
    {
        if ($task->sprint->project->teacher_id !== Auth::id()) abort(403);

        $progress = $task->progress()->where('user_id', $student->id)->firstOrFail();

        $this->taskService->addFeedback($progress, $request->teacher_feedback);

        // Also update status if teacher changed it
        if ($request->has('status')) {
            $progress->update(['status' => $request->status]);
        }

        return back()->with('success', "Feedback saved for {$student->name}.");
    }
}
