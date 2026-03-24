@extends('layouts.app')

@section('page-title', 'Manage Invitations - ' . $project->name)

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div>
            <a href="{{ route('projects.show', $project->id) }}" class="inline-flex items-center gap-2 text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-indigo-600 transition-colors mb-4">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                Back to Project
            </a>
            <h2 class="text-3xl font-black text-gray-900 tracking-tight">Project Invitations</h2>
            <p class="text-sm text-gray-500 font-medium">Manage pending access links for {{ $project->name }}</p>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-xl shadow-gray-200/50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-10 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Recipient Email</th>
                        <th class="px-10 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Expires At</th>
                        <th class="px-10 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-10 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($invitations as $invite)
                        <tr class="group hover:bg-gray-50/30 transition-colors">
                            <td class="px-10 py-6">
                                <p class="text-sm font-black text-gray-900">{{ $invite->email }}</p>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tight">{{ $invite->token }}</p>
                            </td>
                            <td class="px-10 py-6 text-center">
                                <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">
                                    {{ $invite->expires_at->format('M d, Y H:i') }}
                                </span>
                            </td>
                            <td class="px-10 py-6 text-center">
                                @if($invite->expires_at->isPast())
                                    <span class="inline-block text-[10px] font-black px-3 py-1 bg-red-50 text-red-600 rounded-full uppercase tracking-widest border border-red-100/50">Expired</span>
                                @else
                                    <span class="inline-block text-[10px] font-black px-3 py-1 bg-teal-50 text-teal-600 rounded-full uppercase tracking-widest border border-teal-100/50">Active</span>
                                @endif
                            </td>
                            <td class="px-10 py-6">
                                <div class="flex items-center gap-3">
                                    <button onclick="copyToClipboard('{{ route('register.invite', $invite->token) }}?email={{ $invite->email }}')" 
                                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-black px-4 py-2 rounded-xl transition-all active:scale-95 text-[10px] uppercase tracking-widest">
                                        Copy Link
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-10 py-20 text-center">
                                <p class="text-sm text-gray-400 font-bold uppercase tracking-widest">No pending invitations</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert('Link copied to clipboard!');
    });
}
</script>
@endsection
