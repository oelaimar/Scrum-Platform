<?php

namespace App\Http\Controllers;

use App\Enums\ProjectStatus;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\ProjectService;
use App\Events\ProjectCreated;

class ProjectController extends Controller
{
    public function __construct(
        protected ProjectService $projectService
    ) {}

    public function create()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if(!$user->isTeacher()){
            abort(403);
        }
        return view('project.create');
    }
    public function store(ProjectRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if(!$user->isTeacher()){
            abort(403);
        }
        $project = $this->projectService->createProject($user, [
            'name' => $request->name,
            'description' => $request->description,
        ]);

        event(new ProjectCreated($project));

        return redirect()->route('dashboard')->with('success', 'New project has been created successfully!');
    }
    public function show(Project $project)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if($user->isTeacher()){
            if($project->teacher_id !== $user->id){
                abort(403, 'You do not own this project.');
            }
        }else{
            if(!$project->students()->where('user_id', $user->id)->exists()){
                abort(403, 'You are not assigned to this project.');
            }
        }
        $project->load('sprints');
        
        $availableStudents = \App\Models\User::where('role', \App\Enums\UserRole::STUDENT)
            ->where('status', \App\Enums\UserStatus::ACTIVE)
            ->whereDoesntHave('projects', function($q) use ($project) {
                $q->where('projects.id', $project->id);
            })->get();

        return view('project.show', compact('project', 'availableStudents'));
    }

    public function addStudent(Request $request, Project $project)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($project->teacher_id !== $user->id) abort(403);
        
        $student = \App\Models\User::findOrFail($request->student_id);
        $this->projectService->addStudent($project, $student);
        
        return back()->with('success', $student->name . ' added to project.');
    }

    public function removeStudent(Project $project, \App\Models\User $student)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($project->teacher_id !== $user->id) abort(403);
        
        $this->projectService->removeStudent($project, $student);
        
        return back()->with('success', $student->name . ' removed from project.');
    }

}
