@extends('layouts.master')

@section('title','Group Details')

@section('content')

@php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
@endphp

{{-- 🔐 VIEW ACCESS CHECK --}}
@if($isAdmin || hasPermission('group_view') || hasPermission('group_view_all') || hasPermission('group_view_own'))

<x-breadcrumb title="Group Management" page="Group Details" />

<div class="mt-3"></div>

<div class="row">
    <div class="col-md-12 m-auto">

        <!-- 🔥 GROUP CARD -->
        <div class="white_shd full p-4 shadow-sm mb-4"
             style="border-radius:10px;">

            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <h4 style="font-weight:600;">
                        {{ $group->group_name }}
                    </h4>

                    <small class="text-muted">
                        Total Employees: {{ $group->employees->count() }}
                    </small>
                </div>

                <span class="badge bg-dark text-white px-3 py-2">
                    Group Module
                </span>

            </div>

        </div>

        <!-- 🔥 EMPLOYEES LIST -->
        <div class="white_shd full p-4 shadow-sm"
             style="border-radius:10px;">

            <h5 class="mb-3" style="font-weight:600;">
                👥 Group Employees
            </h5>

            <div class="row">

                @foreach($group->employees as $emp)

                <div class="col-md-6 mb-3">

                    <!-- EMPLOYEE CARD -->
                    <div class="p-3 border rounded shadow-sm h-100"
                         style="background:#fff;">

                        <div class="d-flex align-items-center">

                            @php
                                $img = (!empty($emp->image))
                                    ? asset('uploads/employees/'.$emp->image)
                                    : asset('uploads/employees/user.png');
                            @endphp
                            
                            <!-- IMAGE -->
                            <div class="me-3">
                                <img src="{{ $img }}"
                                     style="width:55px;height:55px;border-radius:50%;object-fit:cover;border:2px solid #eee;">
                            </div>

                            <!-- INFO -->
                            <div>

                                <h6 class="mb-1" style="font-weight:600;">
                                    {{ $emp->user->name }}
                                </h6>

                                <small class="text-muted">
                                    {{ $emp->user->email }}
                                </small>

                            </div>

                        </div>

                        <hr>

                        <!-- DETAILS -->
                        <div class="row" style="font-size:13px;">

                            <div class="col-6 mb-1">
                                <b>📍 Location:</b><br>
                                <span class="text-primary">
                                    {{ $emp->location->name ?? 'N/A' }}
                                </span>
                            </div>

                            <div class="col-6 mb-1">
                                <b>🏢 Department:</b><br>
                                <span class="text-success">
                                    {{ $emp->department->dept_name ?? 'N/A' }}
                                </span>
                            </div>

                            <div class="col-6 mb-1">
                                <b>🎯 Role:</b><br>
                                <span class="text-warning">
                                    {{ $emp->role->name ?? 'N/A' }}
                                </span>
                            </div>

                            <div class="col-6 mb-1">
                                <b>📅 Joining:</b><br>
                                <span class="text-muted">
                                    {{ $emp->joining_date ?? '-' }}
                                </span>
                            </div>

                        </div>

                    </div>

                </div>

                @endforeach

            </div>

        </div>

    </div>
</div>

@else

<div class="alert alert-danger">
    You do not have permission to view group details.
</div>

@endif

@endsection