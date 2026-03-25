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
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->isStudent() || !$user->projects->contains($sprint->project)) abort(403);
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

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->standups()->create([
            'sprint_id' => $sprint->id,
            'did_yesterday' => $request->did_yesterday,
            'will_do_today' => $request->will_do_today,
            'blockers' => $request->blockers,
            'date' => today(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Daily Stand-up submitted successfully!');
    }
    public function index(Sprint $sprint)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user->isTeacher() || $sprint->project->teacher_id !== $user->id) {
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
