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
                <div class="flex flex-wrap items-center gap-6">
                    <span class="text-[10px] font-black px-4 py-1.5 bg-indigo-50 text-indigo-600 rounded-full uppercase tracking-widest border border-indigo-100 whitespace-nowrap">Status: {{ $project->status->value }}</span>
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest flex items-center gap-1.5 whitespace-nowrap">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                        {{ $project->students->count() }} Members
                    </span>
                    <p class="text-sm text-gray-500 font-medium leading-relaxed max-w-2xl flex-1">{{ $project->description }}</p>
                </div>
            </div>
            @if(auth()->user()->isTeacher())
            <div class="flex flex-col gap-2">
                {{-- Invitation links removed in favor of direct management below --}}
            </div>
            @endif
        </div>
    </div>

    {{-- Team & Sprints Grid --}}
    <div class="grid grid-cols-3 gap-8 mb-12">
        {{-- Team Sidebar --}}
        <div class="space-y-6">
            <h3 class="text-lg font-black text-gray-900 tracking-tight px-2">Project Team</h3>
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 space-y-4">
                @if(auth()->user()->isTeacher())
                    <form action="{{ route('projects.addStudent', $project->id) }}" method="POST" class="mb-6 flex gap-2">
                        @csrf
                        <select name="student_id" required class="flex-1 bg-gray-50 border border-gray-100 rounded-xl px-4 py-2 text-xs font-medium outline-none focus:ring-2 focus:ring-indigo-500/20">
                            <option value="">Select Student to Add</option>
                            @foreach($availableStudents as $student)
                                <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-indigo-600 text-white text-[10px] font-black uppercase tracking-widest px-4 py-2 rounded-xl hover:bg-indigo-700 transition-all">Add</button>
                    </form>
                @endif

                @forelse($project->students as $student)
                    <div class="flex items-center justify-between group/student">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 font-black text-xs border border-gray-100">
                                {{ strtoupper(substr($student->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-black text-gray-900 truncate">{{ $student->name }}</p>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter truncate">{{ $student->email }}</p>
                            </div>
                        </div>
                        @if(auth()->user()->isTeacher())
                            <form action="{{ route('projects.removeStudent', [$project->id, $student->id]) }}" method="POST" class="opacity-0 group-hover/student:opacity-100 transition-opacity">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Remove student from project?')" class="text-red-400 hover:text-red-600">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </form>
                        @endif
                    </div>
                @empty
                    <p class="text-center py-4 text-[10px] text-gray-400 font-black uppercase tracking-widest">No members yet</p>
                @endforelse
            </div>
        </div>

        {{-- Sprints List --}}
        <div class="col-span-2 space-y-6">
            <div class="flex items-center justify-between px-2">
                <h3 class="text-lg font-black text-gray-900 tracking-tight">Development Sprints</h3>
                @if(auth()->user()->isTeacher())
                    <a href="{{ route('sprints.create', $project->id) }}" class="text-[10px] font-black text-indigo-600 uppercase tracking-widest hover:underline">+ New Sprint</a>
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
                            @if($sprint->goal)
                                <p class="text-xs text-gray-500 font-medium mt-1 leading-relaxed">{{ $sprint->goal }}</p>
                            @endif
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-2">
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
                            @if($st === 'planned')
                                <form action="{{ route('sprints.start', $sprint->id) }}" method="POST" onsubmit="return confirm('Start this sprint now?')">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="text-[10px] font-black text-teal-600 uppercase tracking-widest px-4 py-2 hover:bg-teal-50 rounded-xl transition-all">Start Sprint</button>
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
