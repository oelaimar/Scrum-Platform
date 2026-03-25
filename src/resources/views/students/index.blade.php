@extends('layouts.app')

@section('page-title', 'Student Management')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h3 class="text-xl font-black text-gray-900 tracking-tight">Student Management</h3>
        <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mt-1">Manage global student accounts and approvals</p>
    </div>
</div>

<div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="p-0">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100">
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Student</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Email</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Projects</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($students as $student)
                    @php /** @var \App\Models\User $student */ @endphp
                    <tr class="group hover:bg-gray-50/30 transition-all">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-black text-sm uppercase">
                                    {{ substr($student->name, 0, 1) }}
                                </div>
                                <span class="text-sm font-bold text-gray-900">{{ $student->name }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-sm font-medium text-gray-500">{{ $student->email }}</td>
                        <td class="px-8 py-5 text-center">
                            <span class="text-[10px] font-black px-3 py-1 bg-gray-100 text-gray-500 rounded-full uppercase tracking-widest">
                                {{ $student->projects_count }} Projects
                            </span>
                        </td>
                        <td class="px-8 py-5 text-center">
                            @if($student->status === \App\Enums\UserStatus::PENDING)
                                <span class="text-[10px] font-black px-3 py-1 bg-orange-50 text-orange-600 rounded-full uppercase tracking-widest">Pending</span>
                            @else
                                <span class="text-[10px] font-black px-3 py-1 bg-teal-50 text-teal-600 rounded-full uppercase tracking-widest">Active</span>
                            @endif
                        </td>
                        <td class="px-8 py-5 text-right">
                            @if($student->status === \App\Enums\UserStatus::PENDING)
                                <form action="{{ route('teacher.student.approve', $student->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-black py-2.5 px-6 rounded-2xl shadow-lg shadow-indigo-100 transition-all active:scale-95 uppercase tracking-widest text-[10px]">
                                        Approve
                                    </button>
                                </form>
                            @else
                                <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest italic">No Actions</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
