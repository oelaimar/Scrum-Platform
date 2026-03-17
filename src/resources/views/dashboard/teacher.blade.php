<div class="flex justify-between items-center mb-4">
    <h3 class="text-lg font-medium text-gray-900">Teacher Dashboard</h3>
    <a href="{{ route('projects.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-md hover:bg-indigo-700">
        + Create New Project
    </a>
</div>

{{-- Invitation Form --}}
<div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
    <h4 class="font-bold text-blue-800 mb-3">Invite Student to a Project</h4>
    <form action="{{ route('teacher.invite.store') }}" method="POST">
        @csrf
        <div class="flex items-end space-x-3">
            <div class="flex-grow">
                <label for="invite_email" class="block text-sm font-medium text-gray-700">Student Email</label>
                <input type="email" name="email" id="invite_email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required value="{{ old('email') }}">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="flex-grow">
                <label for="project_id" class="block text-sm font-medium text-gray-700">Select Project</label>
                <select name="project_id" id="project_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    <option value="">-- Select Project --</option>
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
                @error('project_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Send Invite</button>
        </div>
    </form>
    @if (session('success'))
        <div class="mt-3 p-2 bg-green-100 text-green-700 rounded text-sm break-all">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mt-3 p-2 bg-red-100 text-red-700 rounded text-sm">
            {{ session('error') }}
        </div>
    @endif
</div>

{{-- Pending Student Registrations (This section might become obsolete soon with the invite system) --}}
<div class="mb-6">
    <h4 class="font-bold">Pending Student Registrations (via old flow)</h4>
    <ul>
        @forelse ($pendingStudents as $student)
            <li class="flex justify-between items-center py-2 border-b">
                <span>{{ $student->name }} ({{ $student->email }})</span>
                <form action="{{ route('teacher.student.approve', $student) }}" method="POST">
                    @csrf
                    <button type="submit" class="text-xs bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600">
                        Approverr
                    </button>
                </form>
            </li>
        @empty
            <p class="text-sm text-gray-500">No students are currently waiting for approval.</p>
        @endforelse
    </ul>
</div>
