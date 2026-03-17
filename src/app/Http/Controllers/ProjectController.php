<?php

namespace App\Http\Controllers;

use App\Enums\ProjectStatus;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        if(!$user->isTeacher()){
            abort(403);
        }
        view('project.create');
    }
    public function store(ProjectRequest $request)
    {
        $user = Auth::user();
        if(!$user->isTeacher()){
            abort(403);
        }
        Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'teacher_id' => $user->id ,
            'status' => ProjectStatus::DRAFT,
        ]);

        return redirect()->route('dashboard')->with('success', 'New project has been created successfully!');
    }
    public function show(Project $project)
    {
        $user = Auth::user();
        if($user->isTeacher()){
            if($project->teacher_id !== $user->id){
                abort(403, 'You do not own this project.');
            }
        }else{
            if(!$project->students()->where('user', $user->id)->exists()){
                abort('You are not assigned to this project.');
            }
        }
        $project->load('sprint');
        return view('project.show', compact('project'));
    }

}
