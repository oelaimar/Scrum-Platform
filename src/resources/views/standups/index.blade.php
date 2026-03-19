@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('projects.show', $sprint->project_id) }}" class="text-indigo-600 hover:underline text-sm">&larr; Back to Project</a>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Daily Stand-ups for: {{ $sprint->name }}</h2>
            <p class="text-gray-600 mt-2">Overview of student progress and blockers.</p>
        </div>

        @forelse($standups as $date => $standupsByDate)
            <div class="bg-white shadow-md rounded-lg mb-6">
                <div class="px-6 py-3 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800">{{ \Carbon\Carbon::parse($date)->format('F j, Y') }}</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    @foreach($standupsByDate as $standup)
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-2">
                                <h4 class="font-semibold text-indigo-600">{{ $standup->user->name }}</h4>
                                <span class="text-xs text-gray-500">{{ $standup->created_at->format('h:i A') }}</span>
                            </div>
                            <div class="mb-3">
                                <p class="text-gray-700 text-sm"><span class="font-bold">Work Done:</span> {{ $standup->work_done }}</p>
                                <p class="text-gray-700 text-sm"><span class="font-bold">Work Planned:</span> {{ $standup->work_planned }}</p>
                            </div>
                            @if($standup->blockers)
                                <div class="p-2 bg-red-50 border border-red-200 rounded text-sm text-red-700">
                                    <span class="font-bold">Blockers:</span> {{ $standup->blockers }}
                                </div>
                            @else
                                <p class="text-sm text-gray-500">No blockers reported.</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <p class="text-gray-500 italic">No daily stand-ups submitted for this sprint yet.</p>
        @endforelse
    </div>
@endsection
