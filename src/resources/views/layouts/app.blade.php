<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Scrum School') }} — @yield('page-title', 'Dashboard')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 flex antialiased" style="font-family:'Inter',sans-serif;color:#1F2937;">
    {{-- Sidebar --}}
    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col fixed inset-y-0 z-50 overflow-y-auto">
        <div class="px-7 py-10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-black shadow-lg shadow-indigo-100" style="background:linear-gradient(135deg,#6366F1,#818CF8);">
                    S
                </div>
                <div>
                    <h1 class="text-lg font-black tracking-tighter text-gray-900 leading-none">Scrum<span class="text-indigo-600">School</span></h1>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Management Tool</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-3 space-y-1">
            <a href="{{ route('dashboard') }}" 
               class="sidebar-item group flex items-center gap-3 px-4 py-3 text-[10px] font-black uppercase tracking-widest {{ request()->routeIs('dashboard') ? 'active' : 'text-gray-400' }}">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/></svg>
                Dashboard
            </a>
            
            @if(auth()->user()->role === \App\Enums\UserRole::TEACHER)
                <div class="px-7 pt-6 pb-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Teaching</div>
                <a href="#" class="sidebar-item group flex items-center gap-3 px-4 py-3 text-[10px] font-black uppercase tracking-widest text-gray-400">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                    Students
                </a>
            @endif

            <div class="px-7 pt-6 pb-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Projects</div>
            @foreach(auth()->user()->projects as $project)
                <a href="{{ route('projects.show', $project->id) }}" 
                   class="sidebar-item group flex items-center gap-3 px-4 py-3 text-[10px] font-black uppercase tracking-widest {{ request()->is('projects/'.$project->id.'*') ? 'active' : 'text-gray-400' }}">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/></svg>
                    {{ Str::limit($project->name, 16) }}
                </a>
            @endforeach
        </nav>

        {{-- User Footer --}}
        <div class="px-4 py-6 border-t border-gray-50 bg-gray-50/50 mt-auto">
            <div class="flex items-center gap-3 p-3 rounded-2xl bg-white border border-gray-100 shadow-sm relative group overflow-hidden">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-black text-sm uppercase">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-black text-gray-900 truncate tracking-tight uppercase">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-gray-400 font-bold uppercase truncate tracking-tighter">{{ auth()->user()->role->value }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="p-2 text-gray-300 hover:text-red-500 transition-colors">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Main Content --}}
    <main class="flex-1 ml-64 min-h-screen transition-all duration-300">
        {{-- Header --}}
        <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-gray-100 px-8 py-4 flex items-center justify-between">
            <h2 class="text-sm font-black text-gray-400 uppercase tracking-widest italic">
                {{ str_replace('.', ' / ', Route::currentRouteName() ?? 'Dashboard') }}
            </h2>
            <div class="flex items-center gap-6 text-[10px] font-black text-gray-300 uppercase tracking-widest">
                <span class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-teal-500 shadow-lg shadow-teal-200"></span>
                    Operational
                </span>
                <span class="w-px h-6 bg-gray-100"></span>
                <span class="text-gray-400 italic">{{ now()->format('l, M d') }}</span>
            </div>
        </header>

        {{-- Content Area --}}
        <div class="p-10 max-w-7xl mx-auto">
            @if(session('success'))
                <div class="mb-10 p-6 rounded-2xl bg-teal-50 border border-teal-100 text-teal-700 text-xs font-bold flex items-center gap-4 shadow-sm">
                    <div class="w-8 h-8 rounded-full bg-teal-500 text-white flex items-center justify-center shadow-lg shadow-teal-100">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>
                    </div>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-10 p-6 rounded-2xl bg-red-50 border border-red-100 text-red-700 text-xs font-bold flex items-center gap-4 shadow-sm">
                    <div class="w-8 h-8 rounded-full bg-red-500 text-white flex items-center justify-center shadow-lg shadow-red-100">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M18 6L6 18M6 6l12 12"/></svg>
                    </div>
                    {{ session('error') }}
                </div>
            @endif

            @if(session('info'))
                <div class="mb-10 p-6 rounded-2xl bg-blue-50 border border-blue-100 text-blue-700 text-xs font-bold flex items-center gap-4 shadow-sm">
                    <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center shadow-lg shadow-blue-100">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    {{ session('info') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>
</body>
</html>
