@extends('layouts.master')

@section('title','Assign Permissions')
@section('css')
<link rel="stylesheet" href="{{ asset('css/role-permission.css') }}">
@endsection

@section('content')

@php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
@endphp

@if($isAdmin || hasPermission('role_permission_add'))

<div class="permission-card">

<div class="page-title">Assign Permissions</div>

<form method="POST" action="{{ route('roles_permissions.store') }}">
@csrf

{{-- ROLE --}}
<div class="role-box mb-3">
    <label>Select Role</label>

    <select name="role_id" class="form-control">
        <option value="">Select Role</option>
        @foreach($roles as $role)
            <option value="{{ $role->id }}">{{ $role->name }}</option>
        @endforeach
    </select>

    @error('role_id')
        <div class="role-error">{{ $message }}</div>
    @enderror
</div>


<table class="permission-table">

<thead>
<tr>
    <th style="width:200px;">Module</th>
    <th>Permissions</th>
</tr>
</thead>

<tbody>

@foreach($permissions as $module => $items)

<tr>

<td>
    <div class="module-name">{{ $module }}</div>
</td>

<td>

    {{-- 🔥 FIXED GRID --}}
    <div class="perm-grid">

        @foreach($items->pluck('action')->unique() as $action)

            @php
                $perm = $items->firstWhere('action', $action);
            @endphp

            @if($perm && !($action == 'delete' && Auth::id() != 1))
            <div class="perm-item">

                <span>{{ ucfirst($action) }}</span>

                <label class="switch">
                    <input type="checkbox"
                           name="permissions[]"
                           value="{{ $perm->id }}">
                    <span class="slider"></span>
                </label>

            </div>
            @endif

        @endforeach

    </div>

</td>

</tr>

@endforeach

</tbody>

</table>

<button class="save-btn">Save Permissions</button>

</form>

</div>

@else
<div class="alert alert-danger">
    You do not have permission to access this page.
</div>
@endif

@endsection