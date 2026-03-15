<h3 class="text-lg font-medium text-gray-900 mb-4">Teacher Dashboard</h3>

<div class="mb-6">
    <h4 class="font-bold">Pending Student Registrations</h4>
    @if ($pendingStudents->isNotEmpty())
        <ul>
            @foreach ($pendingStudents as $student)
                <li class="flex justify-between items-center py-2 border-b">
                    <span>{{ $student->name }} ({{ $student->email }})</span>
                    {{-- We will add an "Approve" button here later --}}
                    <button class="text-xs bg-green-500 text-white px-2 py-1 rounded">Approve</button>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-sm text-gray-500">No students are currently waiting for approval.</p>
    @endif
</div>
