@extends('layouts.app')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $project->name }}</h2>
                <p class="text-gray-600 mt-2">{{ $project->description }}</p>
            </div>
            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
            {{ $project->status }}
        </span>
        </div>
    </div>

    {{-- Sprints Section (We will build this out next!) --}}
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-800">Sprints (Périodes)</h3>

            @if(auth()->user()->isTeacher())
                {{-- We will create this route next --}}
                <a href="{{ route('sprints.create', $project->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700">
                    + Create Sprint
                </a>
            @endif
        </div>

        @if($project->sprints->isNotEmpty())
            <div class="space-y-4">
                @foreach($project->sprints as $sprint)
                    <div class="p-4 border rounded-md">
                        <h4 class="font-bold text-lg">{{ $sprint->name }}</h4>
                        <p class="text-sm text-gray-500">
                            {{ $sprint->start_date->format('M d, Y') }} - {{ $sprint->end_date->format('M d, Y') }}
                            @if(auth()->user()->isTeacher())
                                <a href="{{ route('tasks.create', $sprint->id) }}" class="text-sm text-blue-600 hover:underline">
                                    + Add Task
                                </a>
                            @endif
                        </p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-sm">No sprints have been created for this project yet.</p>
        @endif
    </div>
@endsection
