{{-- TEACHER DASHBOARD --}}

{{-- Stat strip --}}
<div class="grid grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7v10c0 1.1.9 2 2 2h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2zM9 5v4M15 5v4M9 14h6"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Total Projects</p>
                <p class="text-3xl font-black text-gray-900 leading-tight">{{ $projects->count() }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-600">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Pending Students</p>
                <p class="text-3xl font-black text-gray-900 leading-tight">{{ $pendingStudents->count() }}</p>
            </div>
        </div>
    </div>
</div>

{{-- Invite form --}}
<div class="bg-white rounded-3xl border border-gray-100 shadow-sm mb-8 overflow-hidden">
    <div class="px-8 py-5 border-b border-gray-50 bg-gray-50/50 flex items-center justify-between">
        <div>
            <h3 class="text-sm font-black text-gray-900 tracking-tight">Invite Student</h3>
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">Generate secure invitation link</p>
        </div>
    </div>
    <div class="p-8">
        <form action="{{ route('teacher.invite.store') }}" method="POST" class="flex flex-wrap items-end gap-6">
            @csrf
            <div class="flex-1 min-w-[240px]">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Student Email</label>
                <input type="email" name="email" required value="{{ old('email') }}" placeholder="student@school.com"
                       class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-3 text-sm font-medium focus:bg-white focus:border-indigo-500 transition-all outline-none">
                @error('email') <p class="text-xs text-red-500 mt-1.5 ml-1">{{ $message }}</p> @enderror
            </div>
            <div class="flex-1 min-w-[240px]">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Target Project</label>
                <select name="project_id" required class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-3 text-sm font-medium focus:bg-white focus:border-indigo-500 transition-all outline-none appearance-none">
                    <option value="">Select Project</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                    @endforeach
                </select>
                @error('project_id') <p class="text-xs text-red-500 mt-1.5 ml-1">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-black py-3.5 px-8 rounded-2xl shadow-lg shadow-indigo-100 transition-all active:scale-95 uppercase tracking-widest text-[10px]">
                Send Invitation
            </button>
        </form>
    </div>
</div>

<div class="grid grid-cols-3 gap-8">
    {{-- Projects list --}}
    <div class="col-span-2 space-y-4">
        <div class="flex items-center justify-between mb-2 px-1">
            <h3 class="text-sm font-black text-gray-900 tracking-tight">Active Projects</h3>
            <a href="{{ route('projects.create') }}" class="text-[10px] font-black text-indigo-600 uppercase tracking-widest hover:underline">+ New Project</a>
        </div>
        
        @forelse($projects as $project)
            <a href="{{ route('projects.show', $project->id) }}" class="block bg-white rounded-3xl p-6 border border-gray-100 shadow-sm hover:border-indigo-200 hover:shadow-md transition-all group">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-black text-gray-900 text-lg group-hover:text-indigo-600 transition-colors">{{ $project->name }}</h4>
                    <span class="text-[10px] font-black px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full uppercase tracking-widest">{{ $project->status }}</span>
                </div>
                <p class="text-sm text-gray-500 line-clamp-2 leading-relaxed">{{ $project->description }}</p>
                <div class="mt-6 pt-6 border-t border-gray-50 flex items-center justify-between text-[10px] font-black text-gray-400 uppercase tracking-widest">
                    <span class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> {{ $project->sprints->count() }} Sprints</span>
                    <div class="flex items-center gap-4">
                        <a href="{{ route('teacher.projects.invites', $project->id) }}" class="hover:text-indigo-600 transition-colors">Manage Invites</a>
                        <span class="text-indigo-500 flex items-center gap-1">Manage Project <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
                    </div>
                </div>
            </a>
        @empty
            <div class="bg-white rounded-3xl p-12 text-center border border-dashed border-gray-200">
                <p class="text-sm text-gray-400 font-bold uppercase tracking-widest">No projects found</p>
            </div>
        @endforelse
    </div>

    {{-- Pending Approvals --}}
    <div class="space-y-4">
        <h3 class="text-sm font-black text-gray-900 tracking-tight mb-2 px-1">Pending Approvals</h3>
        @forelse($pendingStudents as $student)
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center font-black text-sm">
                        {{ strtoupper(substr($student->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-black text-gray-900 truncate">{{ $student->name }}</p>
                        <p class="text-[10px] text-gray-400 font-bold truncate uppercase tracking-tighter">{{ $student->email }}</p>
                    </div>
                </div>
                <form action="{{ route('teacher.student.approve', $student) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-teal-500 hover:bg-teal-600 text-white font-black py-2.5 rounded-xl transition-all text-[10px] uppercase tracking-widest shadow-lg shadow-teal-100">
                        Approve Access
                    </button>
                </form>
            </div>
        @empty
            <div class="bg-gray-50 rounded-3xl p-8 text-center border border-gray-100">
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">All clear</p>
            </div>
        @endforelse
    </div>
</div>
