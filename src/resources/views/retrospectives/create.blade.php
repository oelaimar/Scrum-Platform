@extends('layouts.app')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-md max-w-3xl mx-auto">
        <div class="mb-6 border-b pb-4">
            <h2 class="text-2xl font-bold text-gray-800">Sprint Retrospective: {{ $sprint->name }}</h2>
            <p class="text-gray-600 mt-1">The sprint is over! Take a moment to reflect on your work so we can improve next time.</p>
        </div>

        <form action="{{ route('retrospectives.store', $sprint->id) }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="positives" class="block text-gray-800 font-bold mb-2">🟢 What went well? (Positives)</label>
                <textarea id="positives" name="positives" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 @error('positives') border-red-500 @enderror" placeholder="e.g., I learned Laravel routing quickly, teamwork was great..." required>{{ old('positives') }}</textarea>
                @error('positives') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="difficulties" class="block text-gray-800 font-bold mb-2">🔴 What were the difficulties? (Challenges)</label>
                <textarea id="difficulties" name="difficulties" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500 @error('difficulties') border-red-500 @enderror" placeholder="e.g., I struggled with the database relationships..." required>{{ old('difficulties') }}</textarea>
                @error('difficulties') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="improvements" class="block text-gray-800 font-bold mb-2">🔵 How can we improve? (Action Items)</label>
                <textarea id="improvements" name="improvements" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('improvements') border-red-500 @enderror" placeholder="e.g., We should have daily standups earlier in the day..." required>{{ old('improvements') }}</textarea>
                @error('improvements') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded shadow">
                    Submit Retrospective
                </button>
            </div>
        </form>
    </div>
@endsection
