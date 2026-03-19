@extends('layouts.app')
@section('page-title', 'projects.create')

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-indigo-600 transition-colors mb-8">
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Back to Dashboard
    </a>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/50 overflow-hidden">
        <div class="px-10 py-8 border-b border-gray-50 bg-gray-50/50">
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Create New Project</h2>
            <p class="text-xs text-gray-500 font-medium mt-1">Initiate a new scrum team and define its scope.</p>
        </div>
        <div class="p-10">
            <form action="{{ route('projects.store') }}" method="POST" class="space-y-8">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">Project Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           placeholder="e.g., Global E-Commerce Overhaul"
                           class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-6 py-4 text-sm font-medium text-gray-900 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none">
                    @error('name') <p class="text-xs text-red-500 mt-2 ml-1 font-medium">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">Scope & Description</label>
                    <textarea name="description" rows="5" required
                              placeholder="Define the primary objectives, tech stack, and key stakeholders..."
                              class="w-full bg-gray-50 border border-gray-100 rounded-3xl px-6 py-4 text-sm font-medium text-gray-900 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none leading-relaxed">{{ old('description') }}</textarea>
                    @error('description') <p class="text-xs text-red-500 mt-2 ml-1 font-medium">{{ $message }}</p> @enderror
                </div>
                <div class="flex items-center justify-end gap-4 pt-4">
                    <a href="{{ route('dashboard') }}" class="text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-gray-600 px-6 py-4">Cancel</a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 px-10 rounded-2xl shadow-xl shadow-indigo-100 transition-all active:scale-95 uppercase tracking-widest text-[10px]">
                        Initialize Project
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
