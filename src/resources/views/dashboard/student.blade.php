<h3 class="text-lg font-medium text-gray-900 mb-4">Student Dashboard</h3>

{{-- Daily Stand-up Card --}}
<div class="mb-6 bg-white p-6 shadow rounded-lg">
    <div class="flex justify-between items-center mb-4">
        <h4 class="font-bold text-gray-800">My Daily Stand-up</h4>
        @php
            // Find the first active sprint the student is part of
            $activeSprint = Auth::user()->projects()->first()?->sprints()->where('status', \App\Enums\SprintStatus::ACTIVE)->first();
        @endphp

        @if($activeSprint)
            <a href="{{ route('standups.create', $activeSprint->id) }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-md hover:bg-indigo-700">
                Submit Today's Stand-up
            </a>
        @else
            <span class="text-sm text-gray-500">No active sprints.</span>
        @endif
    </div>
    <p class="text-sm text-gray-700">Keep your team updated on your progress and any blockers.</p>
</div>

<div class="mb-6 bg-white p-6 shadow rounded-lg">
    <h4 class="font-bold mb-4 text-gray-800">My Active Tasks</h4>

    @if ($myTasks->isNotEmpty())
        <ul class="space-y-3">
            @foreach ($myTasks as $task)
                <li>
                    <a href="{{ route('tasks.show', $task->id) }}" class="flex justify-between items-center p-3 border rounded-md hover:bg-gray-50 transition">
                        <span class="font-semibold text-indigo-600">{{ $task->title }}</span>
                        <span class="text-xs bg-blue-100 text-blue-800 p-1 rounded font-bold uppercase tracking-wide">
                            {{ str_replace('_', ' ', $task->pivot->status) }}
                        </span>
                    </a>
                </li>
            @endforeach
        </ul>
        @php
            // Find a recently completed sprint where the student HAS NOT submitted a retrospective yet
            $completedSprintNeedsRetro = Auth::user()->projects()->first()
                ?->sprints()
                ->where('status', \App\Enums\SprintStatus::COMPLETED)
                ->whereDoesntHave('retrospectives', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->first();
        @endphp

        @if($completedSprintNeedsRetro)
            <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 shadow rounded-r-lg">
                <div class="flex justify-between items-center">
                    <div>
                        <h4 class="font-bold text-yellow-800">Sprint Completed!</h4>
                        <p class="text-sm text-yellow-700">"{{ $completedSprintNeedsRetro->name }}" has ended. Please submit your retrospective.</p>
                    </div>
                    <a href="{{ route('retrospectives.create', $completedSprintNeedsRetro->id) }}" class="px-4 py-2 bg-yellow-500 text-white text-sm font-bold rounded shadow hover:bg-yellow-600">
                        Start Retrospective
                    </a>
                </div>
            </div>
        @endif

    @else
        <p class="text-sm text-gray-500 border p-4 rounded bg-gray-50">You have no tasks assigned to you right now.</p>
    @endif
</div>
