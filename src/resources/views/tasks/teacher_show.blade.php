@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('projects.show', $task->sprint->project_id) }}" class="text-indigo-600 hover:underline text-sm">&larr; Back to Project</a>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-2xl font-bold text-gray-800">{{ $task->title }}</h2>
            <p class="text-gray-600 mt-2">{{ $task->description }}</p>
        </div>

        @if (session('success'))
            <div class="mb-4 text-sm text-green-700 bg-green-100 p-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Solution Link</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Evaluation</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($students as $student)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium text-gray-900">{{ $student->name }}</div>
                            <div class="text-sm text-gray-500">{{ $student->email }}</div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($student->pivot->solution_link)
                                <a href="{{ $student->pivot->solution_link }}" target="_blank" class="text-blue-600 hover:underline text-sm">View Work &nearr;</a>
                            @else
                                <span class="text-gray-400 text-sm">No link submitted</span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            <form action="{{ route('tasks.evaluate', ['task' => $task->id, 'student' => $student->id]) }}" method="POST" class="flex flex-col space-y-2">
                                @csrf
                                @method('PUT')

                                <div class="flex space-x-2 items-center">
                                    <select name="status" class="text-sm border-gray-300 rounded-md shadow-sm w-36">
                                        @foreach(\App\Enums\TaskStatus::cases() as $status)
                                            <option value="{{ $status->value }}" {{ $student->pivot->status === $status->value ? 'selected' : '' }}>
                                                {{ ucfirst(str_replace('_', ' ', $status->value)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="bg-green-600 text-white text-xs px-3 py-2 rounded hover:bg-green-700">Save</button>
                                </div>

                                <textarea name="teacher_feedback" rows="2" class="text-sm border-gray-300 rounded-md shadow-sm w-full" placeholder="Leave feedback...">{{ $student->pivot->teacher_feedback }}</textarea>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
