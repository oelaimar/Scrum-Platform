<h3 class="text-lg font-medium text-gray-900 mb-4">Student Dashboard</h3>

<div class="mb-6">
    <h4 class="font-bold">My Active Tasks</h4>
    @if ($myTasks->isNotEmpty())
        <ul>
            @foreach ($myTasks as $task)
                <li class="py-2 border-b">
                    <span class="font-semibold">{{ $task->title }}</span>
                    <span class="text-xs bg-blue-100 text-blue-800 p-1 rounded">{{ $task->pivot->status }}</span>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-sm text-gray-500">You have no tasks assigned to you yet.</p>
    @endif
</div>
