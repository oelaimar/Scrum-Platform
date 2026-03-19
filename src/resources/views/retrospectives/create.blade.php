@extends('layouts.app')
@section('page-title', 'retrospectives.create')

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-indigo-600 transition-colors mb-8">
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Back to Dashboard
    </a>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/50 overflow-hidden">
        <div class="px-10 py-8 border-b border-gray-50 bg-gray-50/50">
            <h2 class="text-2xl font-black text-gray-900 tracking-tight leading-tight mb-1">Sprint Retrospective</h2>
            <p class="text-xs text-gray-500 font-medium">Reflection: <span class="text-indigo-600 font-black underline">{{ $sprint->name }}</span></p>
        </div>
        <div class="p-10">
            <form action="{{ route('retrospectives.store', $sprint->id) }}" method="POST" class="space-y-8">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">Team Dynamics (What went well?)</label>
                    <textarea name="content" rows="6" required
                              placeholder="Discuss collaboration, processes, and tools that were effective..."
                              class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-6 py-4 text-sm font-medium text-gray-900 focus:bg-white focus:border-indigo-500 transition-all outline-none leading-relaxed"></textarea>
                </div>
                <div>
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 rounded-2xl shadow-xl shadow-indigo-100 transition-all active:scale-95 uppercase tracking-widest text-[10px]">
                        Publish Reflection
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
