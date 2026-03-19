@extends('layouts.app')
@section('page-title', 'projects/' . $project->id)

@section('content')
    {{-- Project Header --}}
    <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm mb-8">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-indigo-600 transition-colors mb-4">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                    Dashboard
                </a>
                <h2 class="text-3xl font-black text-gray-900 tracking-tight mb-2">{{ $project->name }}</h2>
                <div class="flex items-center gap-6">
                    <span class="text-[10px] font-black px-4 py-1.5 bg-indigo-50 text-indigo-600 rounded-full uppercase tracking-widest border border-indigo-100">Status: {{ $project->status }}</span>
                    <p class="text-sm text-gray-500 font-medium leading-relaxed max-w-2xl">{{ $project->description }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Sprints --}}
    <div class="space-y-6">
        <div class="flex items-center justify-between px-2">
            <div>
                <h3 class="text-lg font-black text-gray-900 tracking-tight">Development Sprints</h3>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">{{ $project->sprints->count() }} Sprints Managed</p>
            </div>
            @if(auth()->user()->isTeacher())
                <a href="{{ route('sprints.create', $project->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-black py-3 px-8 rounded-2xl shadow-lg shadow-indigo-100 transition-all active:scale-95 uppercase tracking-widest text-[10px]">
                    Create New Sprint
                </a>
            @endif
        </div>

        @forelse($project->sprints as $sprint)
            @php
                $st = $sprint->status->value;
                [$bg,$fg,$icon] = match($st) {
                    'active'    => ['bg-teal-50', 'text-teal-600', 'Active Now'],
                    'completed' => ['bg-gray-50', 'text-gray-400', 'Completed'],
                    default     => ['bg-indigo-50', 'text-indigo-400', 'Planned']
                };
            @endphp
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition-all">
                {{-- Sprint Header --}}
                <div class="px-8 py-6 flex items-center justify-between border-b border-gray-50 bg-gray-50/20">
                    <div class="flex items-center gap-6">
                        <div class="w-14 h-14 rounded-2xl {{ $bg }} flex items-center justify-center {{ $fg }}">
                            <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <div>
                            <span class="text-[10px] font-black uppercase tracking-widest {{ $fg }} mb-1 block">{{ $icon }}</span>
                            <h4 class="text-lg font-black text-gray-900 tracking-tight">{{ $sprint->name }}</h4>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">
                                {{ \Carbon\Carbon::parse($sprint->start_date)->format('M d') }} — {{ \Carbon\Carbon::parse($sprint->end_date)->format('M d, Y') }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        @if(auth()->user()->isTeacher())
                            <a href="{{ route('tasks.create', $sprint->id) }}" class="text-[10px] font-black text-indigo-600 uppercase tracking-widest px-4 py-2 hover:bg-indigo-50 rounded-xl transition-all">+ Task</a>
                            <a href="{{ route('standups.index', $sprint->id) }}" class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-4 py-2 hover:bg-gray-100 rounded-xl transition-all">Stand-ups</a>
                            @if($st === 'active')
                                <form action="{{ route('sprints.complete', $sprint->id) }}" method="POST" onsubmit="return confirm('Archive this sprint?')">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="text-[10px] font-black text-red-500 uppercase tracking-widest px-4 py-2 hover:bg-red-50 rounded-xl transition-all">Archive</button>
                                </form>
                            @endif
                            @if($st === 'completed')
                                <a href="{{ route('retrospectives.index', $sprint->id) }}" class="text-[10px] font-black text-orange-500 uppercase tracking-widest px-4 py-2 hover:bg-orange-50 rounded-xl transition-all">Retrospectives</a>
                            @endif
                        @endif
                    </div>
                </div>

                {{-- Task Sub-list --}}
                <div class="divide-y divide-gray-50">
                    @forelse($sprint->tasks as $task)
                        <a href="{{ route('tasks.show', $task->id) }}" class="flex items-center justify-between px-8 py-4 hover:bg-gray-50/50 transition-colors group">
                            <span class="text-sm font-bold text-gray-600 group-hover:text-indigo-600 transition-colors">{{ $task->title }}</span>
                            <div class="flex items-center gap-4">
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $task->story_points }} Pts</span>
                                <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-300 group-hover:text-indigo-600 group-hover:bg-indigo-50 transition-all">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M9 18l6-6-6-6"/></svg>
                                </div>
                            </div>
                        </a>
                    @empty
                        <p class="px-8 py-6 text-xs text-gray-400 font-bold uppercase tracking-widest text-center italic">No tasks assigned to this sprint yet.</p>
                    @endforelse
                </div>
            </div>
        @empty
            <div class="bg-white rounded-3xl p-16 text-center border border-dashed border-gray-200">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300">
                    <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <p class="text-sm text-gray-400 font-bold uppercase tracking-widest">No sprints defined for this project.</p>
            </div>
        @endforelse
    </div>
@endsection
