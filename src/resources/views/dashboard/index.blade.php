@extends('layouts.app')

@section('page-title', 'Overview')

@section('content')
    {{-- DASHBOARD REDIRECTOR --}}
    @auth
        @if(auth()->user()->role === \App\Enums\UserRole::TEACHER)
            @include('dashboard.teacher')
        @elseif(auth()->user()->role === \App\Enums\UserRole::ADMIN)
            @include('dashboard.admin')
        @else
            @include('dashboard.student')
        @endif
    @endauth
@endsection
