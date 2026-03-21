{{-- ADMIN DASHBOARD --}}
<div class="p-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Admin Dashboard</h1>
    <div class="grid grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-sm text-gray-500 uppercase tracking-widest">Total Users</p>
            <p class="text-4xl font-black text-indigo-600 mt-2">{{ $totalUsers }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-sm text-gray-500 uppercase tracking-widest">Pending Approvals</p>
            <p class="text-4xl font-black text-yellow-500 mt-2">{{ $pendingStudents->count() }}</p>
        </div>
    </div>
</div>
