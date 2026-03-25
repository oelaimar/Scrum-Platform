@extends('layouts.app')
@section('page-title', 'tasks/' . $task->id . '/evaluate')

@section('content')
<div class="max-w-6xl mx-auto">
    <a href="{{ route('projects.show', $task->sprint->project_id) }}" class="inline-flex items-center gap-2 text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-indigo-600 transition-colors mb-8">
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Back to Project
    </a>

    {{-- Task Overview Card --}}
    <div class="bg-white rounded-[2rem] p-10 border border-gray-100 shadow-sm mb-10">
        <div class="flex items-center gap-6 mb-8">
            <span class="text-[10px] font-black px-4 py-2 bg-indigo-50 text-indigo-600 rounded-full uppercase tracking-widest">Evaluation: {{ $task->story_points }} Pts</span>
            <div class="h-px bg-gray-100 flex-1"></div>
        </div>
        <h2 class="text-2xl font-black text-gray-900 tracking-tight leading-tight mb-4">{{ $task->title }}</h2>
        <p class="text-sm text-gray-500 font-medium leading-relaxed max-w-4xl italic p-6 bg-gray-50 rounded-2xl border border-gray-100/50">{{ $task->description }}</p>
    </div>

    {{-- Evaluation Section --}}
    <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-xl shadow-gray-200/50 overflow-hidden">
        <div class="px-10 py-6 border-b border-gray-50 bg-gray-50/30 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-black text-gray-900 tracking-tight">Active Submissions</h3>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">{{ $progressRecords->count() }} Team Member(s)</p>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-10 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Member</th>
                        <th class="px-10 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Reference</th>
                        <th class="px-10 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Milestones</th>
                        <th class="px-10 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Evaluation & Insight</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($progressRecords as $progress)
                        <tr class="group hover:bg-gray-50/30 transition-colors">
                            <td class="px-10 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-black text-base shadow-sm">
                                        {{ strtoupper(substr($progress->user->name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-black text-gray-900 truncate">{{ $progress->user->name }}</p>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter truncate">{{ $progress->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-6 text-center">
                                @if($progress->solution_link)
                                    <a href="{{ $progress->solution_link }}" target="_blank" 
                                       class="inline-flex items-center gap-1.5 text-[10px] font-black text-indigo-600 uppercase tracking-widest px-4 py-2 bg-indigo-50 rounded-xl hover:bg-indigo-100 transition-all">
                                        View Pull Request <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6M15 3h6v6M10 14L21 3"/></svg>
                                    </a>
                                @else
                                    <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest">Awaiting Artifact</span>
                                @endif
                            </td>
                            <td class="px-10 py-6 text-center">
                                @php 
                                    $status = $progress->status;
                                    [$bg,$fg,$text] = match($status) { 
                                        \App\Enums\TaskStatus::DONE        => ['bg-teal-50', 'text-teal-600', 'Done'], 
                                        \App\Enums\TaskStatus::IN_PROGRESS => ['bg-indigo-50', 'text-indigo-600', 'Active'], 
                                        default                            => ['bg-gray-100', 'text-gray-400', 'Todo'] 
                                    };
                                @endphp
                                <span class="inline-block text-[10px] font-black px-4 py-1.5 {{ $bg }} {{ $fg }} rounded-full uppercase tracking-widest border {{ str_replace('text-', 'border-', $fg) }} border-opacity-20">{{ $text }}</span>
                            </td>
                            <td class="px-10 py-6 min-w-[320px]">
                                <form action="{{ route('tasks.evaluate', ['task'=>$task->id,'student'=>$progress->user->id]) }}" method="POST" class="space-y-3">
                                    @csrf @method('PUT')
                                    <div class="flex gap-2">
                                        <select name="status" class="flex-1 bg-gray-50 border border-gray-100 rounded-xl px-4 py-2.5 text-[10px] font-black uppercase tracking-widest focus:bg-white focus:border-indigo-500 transition-all outline-none appearance-none cursor-pointer">
                                            @foreach(\App\Enums\TaskStatus::cases() as $s)
                                                <option value="{{ $s->value }}" {{ $progress->status === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s->value)) }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-black px-5 py-2.5 rounded-xl shadow-lg shadow-indigo-100 transition-all active:scale-95 text-[10px] uppercase tracking-widest">
                                            Save Evaluation
                                        </button>
                                    </div>
                                    <textarea name="teacher_feedback" rows="2" 
                                              placeholder="Provide specific, actionable feedback for this milestone..." 
                                              class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-3 text-xs font-medium text-gray-600 focus:bg-white focus:border-indigo-500 transition-all outline-none leading-relaxed resize-none">{{ $progress->teacher_feedback }}</textarea>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
