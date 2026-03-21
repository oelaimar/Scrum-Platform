@extends('layouts.app')
@section('page-title', 'standups.create')

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-indigo-600 transition-colors mb-8">
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Back to Dashboard
    </a>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/50 overflow-hidden">
        <div class="px-10 py-8 border-b border-gray-50 bg-gray-50/50">
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Daily Stand-up</h2>
            <p class="text-xs text-gray-500 font-medium mt-1">Sprint: <span class="text-indigo-600 font-bold underline">{{ $sprint->name }}</span></p>
        </div>
        <div class="p-10">
            <form action="{{ route('standups.store', $sprint->id) }}" method="POST" class="space-y-8">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">Yesterday's Progress</label>
                    <textarea name="work_done" rows="3" required
                              placeholder="What did you accomplish since the last stand-up?"
                              class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-6 py-4 text-sm font-medium text-gray-900 focus:bg-white focus:border-indigo-500 transition-all outline-none leading-relaxed"></textarea>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">Today's Focus</label>
                    <textarea name="work_planned" rows="3" required
                              placeholder="What is your primary goal for today?"
                              class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-6 py-4 text-sm font-medium text-gray-900 focus:bg-white focus:border-indigo-500 transition-all outline-none leading-relaxed"></textarea>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">Blockers & Hurdles</label>
                    <textarea name="blockers" rows="2"
                              placeholder="Any obstacles slowing you down? (Leave blank if none)"
                              class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-6 py-4 text-sm font-medium text-gray-900 focus:bg-white focus:border-orange-500 transition-all outline-none leading-relaxed"></textarea>
                </div>
                <div class="flex items-center justify-end pt-4">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 px-12 rounded-2xl shadow-xl shadow-indigo-100 transition-all active:scale-95 uppercase tracking-widest text-[10px]">
                        Submit Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
