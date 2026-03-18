<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Http\Requests\TaskRequest;
use App\Models\Sprint;
use App\Models\Task;
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
    public function store(TaskRequest $request, Sprint $sprint){

        $task = $sprint->tasks()->create($request->validated());

        $students =$sprint->project->students;
        foreach ($students as $student){
            //Create an individual progress entry for each student in the pivot table
            $task->students()->attach($student->id, ['status' => TaskStatus::TODO->value]);
        }
        return redirect()->route('projects.show', $sprint->project_id)
            ->with('success', 'Task created and assigned to all students!');
    }
}
