@extends('layouts.app')
@section('page-title', 'tasks/' . $task->id)

@section('content')
<div class="max-w-5xl mx-auto">
    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-indigo-600 transition-colors mb-8">
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Back to Dashboard
    </a>

    <div class="grid grid-cols-3 gap-8 items-start">
        {{-- Task Detail --}}
        <div class="col-span-2 space-y-8">
            <div class="bg-white rounded-[2rem] p-10 border border-gray-100 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 px-8 py-6">
                    <span class="text-[10px] font-black px-4 py-2 bg-indigo-50 text-indigo-600 rounded-full uppercase tracking-widest">{{ $task->story_points }} Story Pts</span>
                </div>
                
                <h2 class="text-3xl font-black text-gray-900 tracking-tight mb-8 leading-tight max-w-[80%]">{{ $task->title }}</h2>
                
                <div class="space-y-4">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none">Task Scope</p>
                    <p class="text-gray-500 font-medium leading-relaxed bg-gray-50 p-8 rounded-3xl border border-gray-100/50 italic">{{ $task->description }}</p>
                </div>
            </div>

            @if($taskProgress->teacher_feedback)
                <div class="bg-orange-50 rounded-3xl p-8 border border-orange-100 shadow-sm relative group overflow-hidden">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-orange-100/40 rounded-full blur-2xl group-hover:scale-125 transition-transform duration-700"></div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-2 h-8 bg-orange-500 rounded-full"></div>
                        <h4 class="text-[10px] font-black text-orange-600 uppercase tracking-widest">Teacher Review</h4>
                    </div>
                    <p class="text-sm font-bold text-orange-900 bg-white/60 backdrop-blur-sm p-6 rounded-2xl border border-white/80 leading-relaxed shadow-sm">{{ $taskProgress->teacher_feedback }}</p>
                </div>
            @endif
        </div>

        {{-- Progress Control --}}
        <div class="space-y-8">
            <div class="bg-white rounded-[2rem] border border-gray-100 shadow-xl shadow-gray-200/50 overflow-hidden">
                <div class="p-8 border-b border-gray-50 bg-gray-50/30">
                    <h3 class="text-sm font-black text-gray-900 tracking-tight">Report Status</h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Submit your progress</p>
                </div>
                <div class="p-8">
                    <form action="{{ route('tasks.progress.update', $task->id) }}" method="POST" class="space-y-6">
                        @csrf @method('PUT')
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">Current Status</label>
                            <select name="status" class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-3.5 text-sm font-medium focus:bg-white focus:border-indigo-500 transition-all outline-none appearance-none">
                                @foreach(\App\Enums\TaskStatus::cases() as $status)
                                    @php $isActive = ($taskProgress->status instanceof \UnitEnum ? $taskProgress->status->value : $taskProgress->status) === $status->value; @endphp
                                    <option value="{{ $status->value }}" {{ $isActive ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $status->value)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">Solution Reference (URL)</label>
                            <input type="url" name="solution_link"
                                   value="{{ old('solution_link', $taskProgress->solution_link) }}"
                                   placeholder="e.g., https://github.com/PR/42"
                                   class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-3.5 text-xs font-medium focus:bg-white focus:border-indigo-500 transition-all outline-none">
                            @error('solution_link') <p class="text-[10px] text-red-500 mt-2 ml-1 font-bold">{{ $message }}</p> @enderror
                        </div>
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 rounded-2xl shadow-xl shadow-indigo-100 transition-all active:scale-95 uppercase tracking-widest text-[10px]">
                            Post Update
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-gray-50 rounded-3xl p-8 border border-gray-100/50 flex flex-col items-center justify-center text-center group">
                <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center text-gray-300 group-hover:text-indigo-500 transition-colors shadow-sm mb-4">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4m0-4h.01"/></svg>
                </div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Need guidance?</p>
                <p class="text-[10px] text-gray-400 font-medium mt-1 leading-relaxed">Reach out to your teacher via comment board.</p>
            </div>
        </div>
    </div>
</div>
@endsection
