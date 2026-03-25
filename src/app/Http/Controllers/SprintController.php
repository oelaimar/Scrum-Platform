<?php

namespace App\Http\Controllers;

use App\Enums\SprintStatus;
use App\Http\Requests\SprintRequest;
use App\Models\Project;
use App\Models\Sprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\SprintService;

class SprintController extends Controller
{
    public function __construct(
        protected SprintService $sprintService
    ) {}

    public function create(Project $project)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if(!$user->isTeacher() || $user->id !== $project->teacher_id ){
            abort(403, 'Unauthorized action.');
        }
        return view('sprint.create', compact('project'));
    }
    public function store(SprintRequest $request, Project $project)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if(!$user->isTeacher() || $user->id !== $project->teacher_id ){
            abort(403, 'Unauthorized action.');
        }

        $this->sprintService->createSprint($project, [
            'name' => $request->name,
            'goal' => $request->goal,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('projects.show', $project->id)
            ->with('success', 'Sprint created successfully!');
    }
    public function start(Sprint $sprint)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->isTeacher() || $sprint->project->teacher_id !== $user->id) {
            abort(403);
        }

        $this->sprintService->startSprint($sprint);

        return back()->with('success', 'Sprint started! Students can now submit their daily stand-ups.');
    }
    public function complete(Sprint $sprint)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->isTeacher() || $sprint->project->teacher_id !== $user->id) {
            abort(403);
        }

        $this->sprintService->completeSprint($sprint);

        return back()->with('success', 'Sprint marked as Completed! Students can now submit their retrospectives.');
    }
}
