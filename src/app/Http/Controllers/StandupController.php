<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStandupRequest;
use App\Models\Sprint;
use App\Models\Standup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StandupController extends Controller
{
    public function create(Sprint $sprint)
    {
        if (!Auth::user()->isStudent() || !Auth::user()->projects->contains($sprint->project)) abort(403);
        $existingStandup = Standup::where('user_id', Auth::id())
            ->where('sprint_id', $sprint->id)
            ->whereDate('date', today())
            ->first();
        if ($existingStandup){
            return redirect()->route('dashboard')
                ->with('info', 'You have already submitted your standup for today.');
        }
        return view('standups.create', compact('sprint'));
    }
    public function store(StoreStandupRequest $request, Sprint $sprint)
    {
        $existingStandup = Standup::where('user_id', Auth::id())
            ->where('sprint_id', $sprint->id)
            ->whereDate('date', today())
            ->first();
        if ($existingStandup) {
            return back()->with('error', 'You have already submitted your standup for today.')->withInput();
        }

        Auth::user()->standups()->create([
            'sprint_id' => $sprint->id,
            'work_done' => $request->work_done,
            'work_planned' => $request->work_planned,
            'blockers' => $request->blockers,
            'date' => today(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Daily Stand-up submitted successfully!');
    }
    public function index(Sprint $sprint)
    {
        if (!Auth::user()->isTeacher() || $sprint->project->teacher_id !== Auth::id()) {
            abort(403);
        }

        $standups = Standup::where('sprint_id', $sprint->id)
            ->with('user')
            ->orderBy('date', 'desc')
            ->get()
            ->groupBy(function($standup) {
                return $standup->date->format('Y-m-d');
            });

        return view('standups.index', compact('sprint', 'standups'));
    }
}
