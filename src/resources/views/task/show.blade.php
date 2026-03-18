@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Left Column: Task Details --}}
        <div class="md:col-span-2 bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:underline text-sm">&larr; Back to Dashboard</a>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $task->title }}</h2>
            <span class="inline-block bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full font-semibold mb-4">
            {{ $task->story_points }} Story Points
        </span>

            <div class="prose max-w-none text-gray-700 mt-4 border-t pt-4">
                <h4 class="font-bold text-lg mb-2">Description</h4>
                <p>{{ $task->description }}</p>
            </div>
        </div>

        {{-- Right Column: Student Progress Form --}}
        <div class="bg-white p-6 rounded-lg shadow-md h-fit">
            <h3 class="font-bold text-lg text-gray-800 mb-4">My Progress</h3>

            {{-- Success Message --}}
            @if (session('success'))
                <div class="mb-4 text-sm text-green-700 bg-green-100 p-2 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('tasks.progress.update', $task->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- We use PUT for updating data --}}

                <!-- Status Dropdown -->
                <div class="mb-4">
                    <label for="status" class="block text-sm font-bold text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="w-full border-gray-300 rounded-md shadow-sm">
                        @foreach(\App\Enums\TaskStatus::cases() as $status)
                            <option value="{{ $status->value }}" {{ $taskProgress->status === $status->value ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $status->value)) }}
                            </option>
                        @endforeach
                    </select>
                    @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Solution Link -->
                <div class="mb-4">
                    <label for="solution_link" class="block text-sm font-bold text-gray-700 mb-1">Solution Link (GitHub, etc.)</label>
                    <input type="url" name="solution_link" id="solution_link" value="{{ old('solution_link', $taskProgress->solution_link) }}"
                           class="w-full border-gray-300 rounded-md shadow-sm" placeholder="https://github.com/...">
                    @error('solution_link') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-2 px-4 rounded hover:bg-indigo-700">
                    Update Progress
                </button>
            </form>

            {{-- Teacher Feedback (If any) --}}
            @if($taskProgress->teacher_feedback)
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <h4 class="font-bold text-sm text-red-600 mb-1">Teacher Feedback:</h4>
                    <p class="text-sm text-gray-700 bg-red-50 p-2 rounded">{{ $taskProgress->teacher_feedback }}</p>
                </div>
            @endif
        </div>
    </div>
@endsection

