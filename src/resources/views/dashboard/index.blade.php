@extends('layouts.app')

@section('page-title', 'Overview')

@section('content')
    {{-- DASHBOARD REDIRECTOR --}}
    @auth
        @if(auth()->user()->role === \App\Enums\UserRole::TEACHER)
            @include('dashboard.teacher')
        @else
            @include('dashboard.student')
        @endif
    @endauth
@endsection
