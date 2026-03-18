<?php

namespace App\Http\Controllers;

use App\Enums\SprintStatus;
use App\Http\Requests\SprintRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SprintController extends Controller
{
    public function create(Project $project)
    {
        if(!Auth::user()->isTeacher() || Auth::id() !== $project->teacher_id ){
            abort(403, 'Unauthorized action.');
        }
        return view('sprint.create', compact('project'));
    }
    public function store(SprintRequest $request, Project $project)
    {
        if(!Auth::user()->isTeacher() || Auth::id() !== $project->teacher_id ){
            abort(403, 'Unauthorized action.');
        }
        $project->sprints()->create([
            'name' => $request->name,
            'objective' => $request->objective,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => SprintStatus::PLANNED->value,
        ]);
        return redirect()->route('projects.show', $project->id)
            ->with('success', 'Sprint created successfully!');
    }
}
