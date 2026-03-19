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
                    <div class="p-4 border rounded-md mb-4 bg-gray-50">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="font-bold text-lg text-indigo-700">{{ $sprint->name }}</h4>
                            @if(auth()->user()->isTeacher())
                                <div class="space-x-2">
                                    <a href="{{ route('tasks.create', $sprint->id) }}" class="text-sm bg-white border border-gray-300 px-3 py-1 rounded hover:bg-gray-100">
                                        + Add Task
                                    </a>
                                    <a href="{{ route('standups.index', $sprint->id) }}" class="text-sm bg-indigo-500 text-white px-3 py-1 rounded hover:bg-indigo-600">
                                        View Stand-ups
                                    </a>
                                </div>
                            @endif
                        </div>

                        {{-- LIST THE TASKS HERE --}}
                        @if($sprint->tasks->isNotEmpty())
                            <ul class="mt-3 space-y-2">
                                @foreach($sprint->tasks as $task)
                                    <li class="bg-white border p-3 rounded flex justify-between items-center hover:shadow-sm transition">
                                        <a href="{{ route('tasks.show', $task->id) }}" class="font-semibold text-gray-800 hover:text-indigo-600">
                                            {{ $task->title }}
                                        </a>
                                        <span class="text-xs text-gray-500">{{ $task->story_points }} Pts</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-xs text-gray-500 mt-2 italic">No tasks created yet.</p>
                        @endif
                    </div>
                @endforeach
            </div>
            @if($sprint->status === \App\Enums\SprintStatus::ACTIVE && auth()->user()->isTeacher())
                <form action="{{ route('sprints.complete', $sprint) }}" method="POST">
                    @csrf
                    <button class="bg-red-600 text-white px-3 py-1 rounded text-xs">Close Sprint</button>
                </form>
            @endif
        @else
            <p class="text-gray-500 text-sm">No sprints have been created for this project yet.</p>
        @endif
        <div class="flex justify-between items-center mb-2">
            <h4 class="font-bold text-lg text-indigo-700">
                {{ $sprint->name }}
                <span class="text-xs ml-2 px-2 py-1 rounded {{ $sprint->status === \App\Enums\SprintStatus::ACTIVE->value ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-800' }}">
            {{ $sprint->status }}
        </span>
            </h4>

            @if(auth()->user()->isTeacher())
                <div class="flex space-x-2 items-center">
                    @if($sprint->status === \App\Enums\SprintStatus::ACTIVE->value)
                        <a href="{{ route('tasks.create', $sprint->id) }}" class="text-sm bg-white border border-gray-300 px-3 py-1 rounded hover:bg-gray-100">+ Add Task</a>
                        <a href="{{ route('standups.index', $sprint->id) }}" class="text-sm bg-blue-50 border border-blue-300 text-blue-700 px-3 py-1 rounded hover:bg-blue-100">Stand-ups</a>

                        {{-- Form to Complete Sprint --}}
                        <form action="{{ route('sprints.complete', $sprint->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to close this sprint?');">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-sm bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Close Sprint</button>
                        </form>
                    @elseif($sprint->status === \App\Enums\SprintStatus::COMPLETED->value)
                        <a href="{{ route('retrospectives.index', $sprint->id) }}" class="text-sm bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700">View Retrospectives</a>
                    @endif
                </div>
            @endif
        </div>

    </div>
@endsection
