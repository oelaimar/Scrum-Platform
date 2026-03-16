@extends('layouts.app')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            @if (auth()->user()->role === \App\Enums\UserRole::TEACHER)
                @include('dashboard.teacher')
            @else
                @include('dashboard.student')
            @endif
        </div>
    </div>
@endsection
