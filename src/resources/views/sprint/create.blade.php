@extends('layouts.app')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('projects.show', $project->id) }}" class="text-indigo-600 hover:text-indigo-800 mr-4">&larr; Back to Project</a>
            <h2 class="text-2xl font-bold text-gray-800">Create New Sprint for: {{ $project->name }}</h2>
        </div>

        <form action="{{ route('sprints.store', $project->id) }}" method="POST">
            @csrf

            <!-- Sprint Name -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Sprint Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                       placeholder="e.g., Sprint 1: User Authentication"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror"
                       required>
                @error('name')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Sprint Objective -->
            <div class="mb-6">
                <label for="objective" class="block text-gray-700 text-sm font-bold mb-2">Sprint Objective</label>
                <textarea id="objective" name="objective" rows="4"
                          placeholder="What is the main goal for this period?"
                          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('objective') border-red-500 @enderror"
                          required>{{ old('objective') }}</textarea>
                @error('objective')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Dates -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">Start Date</label>
                    <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('start_date') border-red-500 @enderror"
                           required>
                    @error('start_date')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="end_date" class="block text-gray-700 text-sm font-bold mb-2">End Date</label>
                    <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('end_date') border-red-500 @enderror"
                           required>
                    @error('end_date')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end">
                <a href="{{ route('projects.show', $project->id) }}" class="text-gray-600 mr-4">Cancel</a>
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Save Sprint
                </button>
            </div>
        </form>
    </div>
@endsection
