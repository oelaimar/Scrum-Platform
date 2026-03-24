<?php

namespace App\Http\Controllers;

use App\Enums\SprintStatus;
use App\Http\Requests\StoreRetrospectiveRequest;
use App\Models\Retrospective;
use App\Models\Sprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RetrospectiveController extends Controller
{
    public function create(Sprint $sprint)
    {
        if (!Auth::user()->isStudent() || $sprint->status !== \App\Enums\SprintStatus::COMPLETED) {
            abort(403, 'You can only fill a retrospective for a completed sprint.');
        }
        if ($sprint->retrospectives()->where('user_id', Auth::id())->exists()) {
            return redirect()->route('projects.show', $sprint->project_id)
                ->with('info', 'You have already submitted a retrospective for this sprint.');
        }

        return view('retrospectives.create', compact('sprint'));
    }
    public function store(StoreRetrospectiveRequest $request, Sprint $sprint)
    {
        if ($sprint->retrospectives()->where('user_id', Auth::id())->exists()) {
            return redirect()->route('projects.show', $sprint->project_id)
                ->with('error', 'You have already submitted a retrospective for this sprint.');
        }

        Auth::user()->retrospectives()->create([
            'sprint_id' => $sprint->id,
            'positives' => $request->positives,
            'difficulties' => $request->difficulties,
            'improvements' => $request->improvements,
        ]);
        return redirect()->route('dashboard')->with('success', 'Retrospective submitted!');
    }
    public function index(Sprint $sprint)
    {
        if (!Auth::user()->isTeacher() || $sprint->project->teacher_id !== Auth::id()) {
            abort(403);
        }

        $retrospectives = $sprint->retrospectives()->with('user')->get();

        return view('retrospectives.index', compact('sprint', 'retrospectives'));
    }
}
