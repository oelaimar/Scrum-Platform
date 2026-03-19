<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Scrum Platform | Modern Management</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white text-gray-900 antialiased font-sans overflow-x-hidden">
        {{-- Background Blobs --}}
        <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
            <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] rounded-full opacity-20 blur-[120px]" style="background: radial-gradient(circle, #6366F1, transparent);"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] rounded-full opacity-20 blur-[120px]" style="background: radial-gradient(circle, #10B981, transparent);"></div>
        </div>

        <nav class="relative z-10 px-8 py-6 flex items-center justify-between max-w-7xl mx-auto">
            <div class="flex items-center gap-3 group cursor-pointer">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-black shadow-lg shadow-indigo-100" style="background:linear-gradient(135deg,#6366F1,#818CF8);">
                    S
                </div>
                <span class="text-xl font-black tracking-tight text-gray-900 group-hover:text-indigo-600 transition-colors">Scrum.</span>
            </div>
            <div class="flex items-center gap-8">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-indigo-600 transition-colors">Go to Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-indigo-600 transition-colors">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-black px-6 py-2.5 rounded-xl shadow-lg shadow-indigo-50 transition-all active:scale-95 text-[10px] uppercase tracking-widest">
                                Start Building
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>

        <main class="relative z-10 flex flex-col items-center justify-center pt-24 pb-32 px-6">
            <div class="text-center max-w-4xl mx-auto">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-50 border border-indigo-100 mb-8">
                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse"></span>
                    <span class="text-[10px] font-black text-indigo-600 uppercase tracking-widest">Version 2.0 Live</span>
                </div>
                <h1 class="text-6xl md:text-8xl font-black text-gray-900 tracking-tighter leading-none mb-8">
                    Manage your <span class="text-indigo-600">Sprints</span><br>with pure confidence.
                </h1>
                <p class="text-lg md:text-xl text-gray-500 font-medium leading-relaxed max-w-2xl mx-auto mb-12 italic">
                    A streamlined, modern Scrum platform built for teachers and students. Transparency, speed, and beautiful design.
                </p>
                <div class="flex flex-wrap items-center justify-center gap-4">
                    <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-black px-10 py-5 rounded-2xl shadow-xl shadow-indigo-100 transition-all active:scale-95 text-xs uppercase tracking-widest">
                        Join the Playground
                    </a>
                    <a href="#" class="bg-white hover:bg-gray-50 text-gray-900 font-black px-10 py-5 rounded-2xl border border-gray-100 shadow-sm transition-all active:scale-95 text-xs uppercase tracking-widest">
                        Documentation
                    </a>
                </div>
            </div>
        </main>

        <section class="max-w-6xl mx-auto px-6 pb-24 relative z-10">
            <div class="grid grid-cols-3 gap-8">
                @foreach(['Sprint Board' => 'Teal','Evaluation' => 'Indigo','Reflections' => 'Orange'] as $title => $color)
                <div class="bg-white rounded-[2rem] p-10 border border-gray-100 shadow-sm group hover:shadow-xl hover:shadow-gray-200/50 transition-all duration-500 cursor-default">
                    <div class="w-12 h-12 rounded-2xl bg-{{ strtolower($color) }}-50 text-{{ strtolower($color) }}-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4m0-4h.01"/></svg>
                    </div>
                    <h3 class="text-xl font-black text-gray-900 tracking-tight mb-2">{{ $title }}</h3>
                    <p class="text-sm font-medium text-gray-400 leading-relaxed italic">Experience a unique, refined interface for managing {{ strtolower($title) }}.</p>
                </div>
                @endforeach
            </div>
        </section>
    </body>
</html>
