@extends('layouts.app')
@section('page-title', 'retrospectives/' . $sprint->id)

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-10">
        <div>
            <a href="{{ route('projects.show', $sprint->project_id) }}" class="inline-flex items-center gap-2 text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-indigo-600 transition-colors mb-3 block">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                Back to Project
            </a>
            <h2 class="text-3xl font-black text-gray-900 tracking-tight leading-none italic">Sprint Reflection Board</h2>
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-2 ml-1">Archive: {{ $sprint->name }}</p>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-8">
        @forelse($retrospectives as $retro)
            <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm p-10 relative overflow-hidden group">
                <div class="absolute -right-8 -top-8 w-32 h-32 bg-indigo-50 rounded-full opacity-20 group-hover:scale-125 transition-transform duration-1000"></div>
                
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-600 text-white flex items-center justify-center font-black text-lg shadow-xl shadow-indigo-100">
                        {{ strtoupper(substr($retro->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="text-base font-black text-gray-900 tracking-tight">{{ $retro->user->name }}</h4>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Published {{ $retro->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                <div class="bg-gray-50/50 rounded-3xl p-8 border border-gray-100/50 relative">
                    <div class="absolute -left-2 -top-2 w-8 h-8 bg-indigo-50 border border-indigo-100 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-indigo-400" viewBox="0 0 24 24" fill="currentColor"><path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C20.1216 16 21.017 16.8954 21.017 18V21C21.017 22.1046 20.1216 23 19.017 23H16.017C14.9124 23 14.017 22.1046 14.017 21ZM14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C20.1216 16 21.017 16.8954 21.017 18V21C21.017 22.1046 20.1216 23 19.017 23H16.017C14.9124 23 14.017 22.1046 14.017 21Z" opacity="0.1"/><path d="M3.58003 18.9151L3.58003 16.0151C3.58003 13.9151 5.28003 12.2151 7.38003 12.2151L10.28 12.2151C10.8323 12.2151 11.28 12.6628 11.28 13.2151C11.28 13.7674 10.8323 14.2151 10.28 14.2151L7.38003 14.2151C6.38592 14.2151 5.58003 15.021 5.58003 16.0151L5.58003 18.9151C5.58003 19.9092 6.38592 20.7151 7.38003 20.7151L10.28 20.7151C10.8323 20.7151 11.28 21.1628 11.28 21.7151C11.28 22.2674 10.8323 22.7151 10.28 22.7151L7.38003 22.7151C5.28003 22.7151 3.58003 21.0151 3.58003 18.9151Z" fill="#6366F1"/></svg>
                    </div>
                    <p class="text-sm font-medium text-gray-600 leading-relaxed italic">"{{ $retro->content }}"</p>
                </div>
            </div>
        @empty
            <div class="col-span-2 bg-white rounded-[3rem] p-32 text-center border border-dashed border-gray-200">
                <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-8 text-gray-300">
                    <svg class="w-12 h-12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21V9m0 0l-4 4m4-4l4 4M21 12A9 9 0 113 12a9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-sm text-gray-400 font-black uppercase tracking-widest italic opacity-60 leading-loose">No reflections have been shared for this sprint yet.<br>Individual contributions will appear here once submitted.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
