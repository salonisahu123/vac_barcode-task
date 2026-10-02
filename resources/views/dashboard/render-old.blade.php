@extends('layouts.master')

@section('title','Dashboard')

@section('css')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
</style>

<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection


@section('content')

@php
    $isEmployee = Auth::user()->user_type == 'employee';
@endphp


<div class="dashboard-page">

    {{-- Greeting --}}
    <div class="dashboard-top">
        <div class="dashboard-top-inner">

            <div class="greeting-box">
                <h6>Welcome Back</h6>
                <h4>{{ Auth::user()->name }}</h4>
            </div>

            <form method="GET"
                  action="{{ route('dashboard') }}"
                  class="d-flex align-items-center flex-wrap"
                  style="gap:10px;"
                  id="filterForm">
            </form>

        </div>
    </div>

   {{-- CARDS --}}
    @include('dashboard.partials.cards')
    
    {{-- CHARTS --}}
    @include('dashboard.partials.charts')
    
    {{-- TABLES --}}
    @include('dashboard.partials.tables')
    
    </div>
    
    @endsection
    
    
    @section('js')
        @include('dashboard.partials.scripts')
    @endsection


