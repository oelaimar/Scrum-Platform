@extends('layouts.app')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Daily Stand-up for: {{ $sprint->name }}</h2>

        @if (session('info'))
            <div class="mb-4 text-sm text-blue-700 bg-blue-100 p-3 rounded">
                {{ session('info') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 text-sm text-red-700 bg-red-100 p-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('standups.store', $sprint->id) }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="work_done" class="block text-gray-700 text-sm font-bold mb-2">What did you do yesterday?</label>
                <textarea id="work_done" name="work_done" rows="4"
                          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('work_done') border-red-500 @enderror"
                          required>{{ old('work_done') }}</textarea>
                @error('work_done')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="work_planned" class="block text-gray-700 text-sm font-bold mb-2">What will you do today?</label>
                <textarea id="work_planned" name="work_planned" rows="4"
                          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('work_planned') border-red-500 @enderror"
                          required>{{ old('work_planned') }}</textarea>
                @error('work_planned')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="blockers" class="block text-gray-700 text-sm font-bold mb-2">Any impediments or blockers?</label>
                <textarea id="blockers" name="blockers" rows="3"
                          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('blockers') border-red-500 @enderror"
                          placeholder="e.g., Waiting for API key, need help with XYZ...">{{ old('blockers') }}</textarea>
                @error('blockers')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end">
                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Submit Stand-up
                </button>
            </div>
        </form>
    </div>
@endsection
