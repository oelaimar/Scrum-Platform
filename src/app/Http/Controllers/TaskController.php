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

class TaskController extends Controller
{
    public function create(Sprint $sprint)
    {
        if($sprint->project->teacher_id !== Auth::id()){
            abort(403);
        }
        return view('task.create', compact('sprint'));
    }
    public function store(StoreTaskRequest $request, Sprint $sprint){

        $task = $sprint->tasks()->create($request->validated());

        $students =$sprint->project->students;
        foreach ($students as $student){
            //Create an individual progress entry for each student in the pivot table
            $task->students()->attach($student->id, ['status' => TaskStatus::TODO->value]);
        }
        return redirect()->route('projects.show', $sprint->project_id)
            ->with('success', 'Task created and assigned to all students!');
    }
    public function show(Task $task)
    {
        $user = Auth::user();
        if ($user->isStudent() && !$user->tasks()->where('task_id', $task->id)->exists()){
            abort(403, 'You are not assigned to this task.');
        }
        if ($user->isTeacher()){
            if ($task->sprint->project->techer_id !== $user->id) abort(403,);
            $students = $task->students()->get();
            return view('tasks.teacher_show', compact('task', 'students'));
        }
        $taskProgress = $user->tasks()->where('task_id', $task->id)->first()->pivot;
        return view('task.show', compact('task', 'taskProgress'));
    }
    public function updateProgress(UpdateTaskProgressRequest $request, Task $task)
    {
        $user = Auth::user();
        // This updates ONLY the data in the middle table for this specific user and task!
        $user->tasks()->updateExistingPivot($task->id, [
           'status' => $request->status,
            'solution_link' => $request->solution_link,
        ]);
        return back()->with('success', 'Task progress updated successfully!');
    }
    public function evaluate(EvaluateTaskRequest $request, Task $task, User $student)
    {
        if ($task->sprint->project->teacher_id != Auth::id()) abort(4030);
        $task->students()->updateExistingPivot($student->id, [
            'status' => $request->status,
            'teacher_feedback' => $request->teacher_feedback,
        ]);
        return back()->with('success', "Feedback saved for {$student->name}.");
    }
}
