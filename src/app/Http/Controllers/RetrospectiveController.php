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
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->isStudent() || $sprint->status !== \App\Enums\SprintStatus::COMPLETED) {
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

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->retrospectives()->create([
            'sprint_id' => $sprint->id,
            'what_went_well' => $request->what_went_well,
            'what_needs_improvement' => $request->what_needs_improvement,
            'action_items' => $request->action_items,
        ]);
        return redirect()->route('dashboard')->with('success', 'Retrospective submitted!');
    }
    public function index(Sprint $sprint)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->isTeacher() || $sprint->project->teacher_id !== $user->id) {
            abort(403);
        }

        $retrospectives = $sprint->retrospectives()->with('user')->get();

        return view('retrospectives.index', compact('sprint', 'retrospectives'));
    }
}
