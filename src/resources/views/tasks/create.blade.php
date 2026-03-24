@extends('layouts.app')
@section('page-title', 'tasks.create')

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ route('projects.show', $sprint->project_id) }}" class="inline-flex items-center gap-2 text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-indigo-600 transition-colors mb-8">
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Back to Project
    </a>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/50 overflow-hidden">
        <div class="px-10 py-8 border-b border-gray-50 bg-gray-50/50">
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Create New Task</h2>
            <p class="text-xs text-gray-500 font-medium mt-1">Sprint: <span class="text-indigo-600 font-bold underline">{{ $sprint->name }}</span></p>
        </div>
        <div class="p-10">
            <form action="{{ route('tasks.store', $sprint->id) }}" method="POST" class="space-y-8">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">Task Title</label>
                    <input type="text" name="title" required placeholder="e.g., Design the user profile component"
                           class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-6 py-4 text-sm font-medium text-gray-900 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none">
                    @error('title') <p class="text-xs text-red-500 mt-2 ml-1 font-medium">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">Story Points (Complexity)</label>
                    <div class="flex gap-4">
                        @foreach([1=>'1 Easy',2=>'2',3=>'3 Normal',5=>'5 Complex',8=>'8 Hard'] as $pts => $label)
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="story_points" value="{{ $pts }}" class="sr-only peer" {{ $pts == 3 ? 'checked' : '' }}>
                                <div class="w-full text-center py-4 rounded-2xl border border-gray-100 bg-gray-50 text-[10px] font-black uppercase tracking-widest text-gray-400 peer-checked:bg-white peer-checked:border-indigo-500 peer-checked:text-indigo-600 peer-checked:shadow-lg peer-checked:shadow-indigo-50 peer-checked:ring-4 peer-checked:ring-indigo-500/5 transition-all">
                                    {{ $label }}
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">Task Description</label>
                    <textarea name="description" rows="5" required
                              placeholder="Detail the technical requirements and expected outcome..."
                              class="w-full bg-gray-50 border border-gray-100 rounded-3xl px-6 py-4 text-sm font-medium text-gray-900 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none leading-relaxed"></textarea>
                    @error('description') <p class="text-xs text-red-500 mt-2 ml-1 font-medium">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center justify-end gap-4 pt-4">
                    <a href="{{ route('projects.show', $sprint->project_id) }}" class="text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-gray-600 px-6 py-4">Discard</a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 px-10 rounded-2xl shadow-xl shadow-indigo-100 transition-all active:scale-95 uppercase tracking-widest text-[10px]">
                        Save Task
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
