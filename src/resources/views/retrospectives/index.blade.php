@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('projects.show', $sprint->project_id) }}" class="text-indigo-600 hover:underline text-sm">&larr; Back to Project</a>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Retrospectives for: {{ $sprint->name }}</h2>
            <p class="text-gray-600">Review student feedback to improve the next sprint.</p>
        </div>

        <div class="space-y-6">
            @forelse($retrospectives as $retro)
                <div class="bg-white shadow rounded-lg overflow-hidden border-l-4 border-indigo-500">
                    <div class="bg-gray-50 px-6 py-3 border-b">
                        <h3 class="font-bold text-lg text-gray-800">{{ $retro->user->name }}</h3>
                        <span class="text-xs text-gray-500">Submitted: {{ $retro->created_at->format('M d, Y h:i A') }}</span>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <h4 class="font-bold text-green-700 mb-2">🟢 Positives</h4>
                            <p class="text-sm text-gray-700 bg-green-50 p-3 rounded h-full">{{ $retro->positives }}</p>
                        </div>
                        <div>
                            <h4 class="font-bold text-red-700 mb-2">🔴 Difficulties</h4>
                            <p class="text-sm text-gray-700 bg-red-50 p-3 rounded h-full">{{ $retro->difficulties }}</p>
                        </div>
                        <div>
                            <h4 class="font-bold text-blue-700 mb-2">🔵 Improvements</h4>
                            <p class="text-sm text-gray-700 bg-blue-50 p-3 rounded h-full">{{ $retro->improvements }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white p-6 rounded shadow text-center">
                    <p class="text-gray-500 italic">No students have submitted a retrospective for this sprint yet.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
