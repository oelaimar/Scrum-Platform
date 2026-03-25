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
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">What went well?</label>
                    <textarea name="what_went_well" rows="4" required
                              placeholder="Discuss collaboration, processes, and tools that were effective..."
                              class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-6 py-4 text-sm font-medium text-gray-900 focus:bg-white focus:border-indigo-500 transition-all outline-none leading-relaxed">{{ old('what_went_well') }}</textarea>
                    @error('what_went_well') <p class="text-xs text-red-500 mt-2 ml-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">What were the difficulties?</label>
                    <textarea name="what_needs_improvement" rows="4" required
                              placeholder="Describe the challenges and blockers you faced..."
                              class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-6 py-4 text-sm font-medium text-gray-900 focus:bg-white focus:border-indigo-500 transition-all outline-none leading-relaxed">{{ old('what_needs_improvement') }}</textarea>
                    @error('what_needs_improvement') <p class="text-xs text-red-500 mt-2 ml-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">What can be improved?</label>
                    <textarea name="action_items" rows="4" required
                              placeholder="Suggest at least one improvement for the next sprint..."
                              class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-6 py-4 text-sm font-medium text-gray-900 focus:bg-white focus:border-indigo-500 transition-all outline-none leading-relaxed">{{ old('action_items') }}</textarea>
                    @error('action_items') <p class="text-xs text-red-500 mt-2 ml-1">{{ $message }}</p> @enderror
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
