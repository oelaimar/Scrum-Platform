{{-- STUDENT DASHBOARD --}}
@php
    $projects = Auth::user()->projects()->with(['activeSprint', 'sprints' => function($q) {
        $q->where('status', \App\Enums\SprintStatus::COMPLETED)
          ->whereDoesntHave('retrospectives', function ($q) { $q->where('user_id', Auth::id()); });
    }])->get();
    
    $activeSprints = $projects->map->activeSprint->filter();
    $needsRetroSprints = $projects->flatMap->sprints->filter();
@endphp

<div class="grid grid-cols-3 gap-8">
    <div class="col-span-2 space-y-8">
        {{-- Retrospective Alerts --}}
        @foreach($needsRetroSprints as $retroSprint)
            <div class="bg-orange-50 border border-orange-100 rounded-3xl p-6 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-orange-100 flex items-center justify-center text-orange-600">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                    </div>
                    <div>
                        <h4 class="font-black text-gray-900 tracking-tight">Sprint Reflection Needed</h4>
                        <p class="text-xs text-orange-700 font-medium mt-1">"{{ $retroSprint->name }}" in {{ $retroSprint->project->name }} has ended.</p>
                    </div>
                </div>
                <a href="{{ route('retrospectives.create', $retroSprint->id) }}" 
                   class="bg-orange-500 hover:bg-orange-600 text-white font-black py-3 px-6 rounded-2xl shadow-lg shadow-orange-100 transition-all text-[10px] uppercase tracking-widest whitespace-nowrap">
                    Start Retro
                </a>
            </div>
        @endforeach

        {{-- Tasks Section --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-8 py-5 border-b border-gray-50 bg-gray-50/50 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-black text-gray-900 tracking-tight">Assigned Tasks</h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">Focus on your current priorities</p>
                </div>
            </div>
            
            <div class="divide-y divide-gray-50">
                @forelse($taskProgress as $progress)
                    @php
                        $status = $progress->status;
                        [$bg,$fg,$text] = match($status) { 
                            \App\Enums\TaskStatus::IN_PROGRESS => ['bg-indigo-50', 'text-indigo-600', 'In Progress'], 
                            \App\Enums\TaskStatus::DONE        => ['bg-teal-50', 'text-teal-600', 'Done'], 
                            default                            => ['bg-gray-50', 'text-gray-400', 'To Do'] 
                        };
                    @endphp
                    <a href="{{ route('tasks.show', $progress->task->id) }}" class="flex items-center justify-between p-6 hover:bg-gray-50/80 transition-all group">
                        <div class="flex items-center gap-4">
                            <div class="w-2 h-8 rounded-full {{ str_replace('text-', 'bg-', $fg) }} opacity-20"></div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $progress->task->title }}</h4>
                                <div class="flex items-center gap-3 mt-1">
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest flex items-center gap-1">
                                        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                                        {{ $progress->task->story_points }} Pts
                                    </span>
                                </div>
                            </div>
                        </div>
                        <span class="text-[10px] font-black px-4 py-1.5 {{ $bg }} {{ $fg }} rounded-full uppercase tracking-widest">{{ $text }}</span>
                    </a>
                @empty
                    <div class="p-16 text-center">
                        <div class="w-16 h-16 bg-teal-50 rounded-full flex items-center justify-center mx-auto mb-4 text-teal-500">
                            <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                        </div>
                        <p class="text-sm text-gray-400 font-bold uppercase tracking-widest">All tasks completed!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="space-y-8">
        {{-- Active Sprint Cards --}}
        @forelse($activeSprints as $sprint)
            <div class="bg-indigo-600 rounded-3xl p-8 text-white shadow-xl shadow-indigo-100 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 transform translate-x-4 -translate-y-1">
                    <svg class="w-32 h-32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <p class="text-[10px] font-black uppercase tracking-widest opacity-60 mb-1">{{ $sprint->project->name }}</p>
                <h3 class="text-xl font-black tracking-tight mb-4 leading-tight">{{ $sprint->name }}</h3>
                
                @php
                    $sprintTaskProgress = $taskProgress->filter(fn($p) => $p->task->sprint_id === $sprint->id);
                    $totalTasks = $sprintTaskProgress->count();
                    $doneTasks = $sprintTaskProgress->where('status', \App\Enums\TaskStatus::DONE)->count();
                    $percentage = $totalTasks > 0 ? round(($doneTasks / $totalTasks) * 100) : 0;
                @endphp

                <div class="space-y-4 mb-8">
                    <div class="flex items-center justify-between text-[10px] font-black uppercase tracking-widest">
                        <span>Progress</span>
                        <span>{{ $percentage }}%</span>
                    </div>
                    <div class="h-2 bg-indigo-400 bg-opacity-30 rounded-full overflow-hidden">
                        <div class="h-full bg-white" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
                <a href="{{ route('standups.create', $sprint->id) }}" 
                   class="inline-block w-full bg-white text-indigo-600 text-center font-black py-3.5 rounded-2xl transition-all hover:bg-indigo-50 active:scale-95 text-[10px] uppercase tracking-widest">
                    Submit Daily Stand-up
                </a>
            </div>
        @empty
            <div class="bg-indigo-600 rounded-3xl p-8 text-white shadow-xl shadow-indigo-100 relative overflow-hidden group">
                <h3 class="text-xl font-black tracking-tight mb-6">No Active Sprint</h3>
                <p class="text-xs opacity-60 mb-8 font-medium italic">Wait for your teacher to start a new sprint.</p>
                <div class="py-4 border border-white/20 rounded-2xl text-center text-[10px] font-black uppercase tracking-widest opacity-40">Stand-by Phase</div>
            </div>
        @endforelse

        {{-- Sprint Stats --}}
        <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
            <h4 class="text-sm font-black text-gray-900 tracking-tight mb-6">Overview</h4>
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Points</span>
                    <span class="text-sm font-black text-gray-900">{{ $taskProgress->sum(fn($p) => $p->task->story_points) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Done</span>
                    <span class="text-sm font-black text-teal-600">{{ $taskProgress->where('status', \App\Enums\TaskStatus::DONE)->sum(fn($p) => $p->task->story_points) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">In Progress</span>
                    <span class="text-sm font-black text-indigo-600">{{ $taskProgress->where('status', \App\Enums\TaskStatus::IN_PROGRESS)->sum(fn($p) => $p->task->story_points) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
