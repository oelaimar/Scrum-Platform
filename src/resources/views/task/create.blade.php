@extends('layouts.app')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Add Task to: {{ $sprint->name }}</h2>

        <form action="{{ route('tasks.store', $sprint->id) }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Task Title</label>
                <input type="text" name="title" class="shadow border rounded w-full py-2 px-3" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Story Points (Complexity)</label>
                <select name="story_points" class="shadow border rounded w-full py-2 px-3">
                    <option value="1">1 (Very Easy)</option>
                    <option value="2">2</option>
                    <option value="3">3 (Normal)</option>
                    <option value="5">5</option>
                    <option value="8">8 (Complex)</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Description / Instructions</label>
                <textarea name="description" rows="4" class="shadow border rounded w-full py-2 px-3" required></textarea>
            </div>

            <div class="flex items-center justify-end">
                <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">
                    Create & Assign Task
                </button>
            </div>
        </form>
    </div>
@endsection
