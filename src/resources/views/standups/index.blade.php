@extends('layouts.app')
@section('page-title', 'standups/' . $sprint->id)

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div>
            <a href="{{ route('projects.show', $sprint->project_id) }}" class="inline-flex items-center gap-2 text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-indigo-600 transition-colors mb-3 block">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                Back to Project
            </a>
            <h2 class="text-3xl font-black text-gray-900 tracking-tight leading-none">Scrum Board</h2>
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-2 ml-1">Daily Stand-ups: {{ $sprint->name }}</p>
        </div>
    </div>

    @forelse($standups as $date => $dayStandups)
        <div class="mb-12">
            <div class="flex items-center gap-4 mb-6 px-1">
                <span class="text-[10px] font-black px-4 py-1.5 bg-gray-100 text-gray-400 rounded-full uppercase tracking-widest border border-gray-200 shadow-sm">{{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</span>
                <div class="h-px bg-gray-100 flex-1"></div>
            </div>
            
            <div class="grid grid-cols-2 gap-8">
                @foreach($dayStandups as $standup)
                    <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm p-8 hover:shadow-md transition-all group relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 w-16 h-16 bg-gray-50 rounded-full opacity-20 group-hover:scale-150 transition-transform duration-700"></div>
                        
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-black text-base shadow-sm">
                                {{ strtoupper(substr($standup->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="text-sm font-black text-gray-900">{{ $standup->user->name }}</h4>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{{ $standup->created_at->format('h:i A') }}</p>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="bg-gray-50/50 rounded-2xl p-5 border border-gray-100/50">
                                <p class="text-[10px] font-black text-indigo-500 uppercase tracking-widest mb-2 opacity-60">Yesterday</p>
                                <p class="text-xs text-gray-600 font-medium leading-relaxed">{{ $standup->did_yesterday }}</p>
                            </div>
                            <div class="bg-indigo-50/30 rounded-2xl p-5 border border-indigo-100/30">
                                <p class="text-[10px] font-black text-teal-500 uppercase tracking-widest mb-2 opacity-60">Today</p>
                                <p class="text-xs text-gray-600 font-medium leading-relaxed">{{ $standup->will_do_today }}</p>
                            </div>
                            @if($standup->blockers)
                                <div class="bg-orange-50 rounded-2xl p-5 border border-orange-100">
                                    <p class="text-[10px] font-black text-orange-500 uppercase tracking-widest mb-2">Blockers</p>
                                    <p class="text-xs text-orange-950 font-bold leading-relaxed">{{ $standup->blockers }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <div class="bg-white rounded-[3rem] p-24 text-center border border-dashed border-gray-200">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300">
                <svg class="w-10 h-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
            </div>
            <p class="text-sm text-gray-400 font-black uppercase tracking-widest italic opacity-60">No daily stand-ups recorded for this iteration.</p>
        </div>
    @endforelse
</div>
@endsection
