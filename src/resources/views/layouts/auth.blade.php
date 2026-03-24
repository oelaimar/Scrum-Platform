<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'ScrumSchool') }} — @yield('auth-title', 'Auth')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center relative overflow-hidden bg-gray-50" style="font-family:'Inter',sans-serif;">
    
    {{-- Animated soft blobs --}}
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full opacity-50 blur-[100px] blob-1"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full opacity-50 blur-[100px] blob-2"></div>

    <div class="w-full max-w-md relative z-10 px-6">
        <div class="text-center mb-10">
            <div class="w-16 h-16 bg-white rounded-2xl shadow-xl shadow-indigo-100 flex items-center justify-center mx-auto mb-6 transform rotate-3">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white font-black text-xl" style="background:linear-gradient(135deg,#6366F1,#818CF8);">
                    S
                </div>
            </div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight mb-2">Welcome Back</h1>
            <p class="text-gray-500 font-medium">ScrumSchool Management Tool</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-teal-50 border border-teal-100 text-teal-700 text-xs font-bold flex items-center gap-3">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-100 text-red-700 text-xs font-bold flex items-center gap-3">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M18 6L6 18M6 6l12 12"/></svg>
                {{ session('error') }}
            </div>
        @endif

        @if(session('info'))
            <div class="mb-6 p-4 rounded-2xl bg-blue-50 border border-blue-100 text-blue-700 text-xs font-bold flex items-center gap-3">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('info') }}
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-2xl shadow-gray-200/50 border border-white p-8 md:p-10">
            @yield('content')
        </div>

        <div class="text-center mt-10">
            <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">&copy; {{ date('Y') }} Scrum School Platform</p>
        </div>
    </div>
</body>
</html>
