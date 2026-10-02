@extends('layouts.master')

@section('title','View Permissions')
@section('css')
<link rel="stylesheet" href="{{ asset('css/role-permission.css') }}">
@endsection

@section('content')

@php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
@endphp

@if($isAdmin || hasPermission('role_permission_view_own') || hasPermission('role_permission_view_all'))

<div class="permission-card">

<div class="d-flex justify-content-between align-items-center">
    <div class="page-title">View Permissions</div>

    <a href="{{ route('roles_permissions.index') }}" class="btn btn-secondary btn-sm">
        Back
    </a>
</div>

{{-- ROLE --}}
<div class="role-box mb-3">
    <label>Role</label>

    <select class="form-control" disabled>
        <option>{{ $role->name }}</option>
    </select>
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
<td><div class="module-name">{{ $module }}</div></td>

<td>
<div class="perm-grid">

@foreach($items->pluck('action')->unique() as $action)

@php $perm = $items->firstWhere('action',$action); @endphp

@if($perm && !($action == 'delete' && Auth::id() != 1))
<div class="perm-item">

<span>{{ ucfirst($action) }}</span>

<label class="switch">
    <input type="checkbox"
           disabled
           {{ in_array($perm->id,$assigned) ? 'checked' : '' }}>
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

</div>

@else
<div class="alert alert-danger">
    You do not have permission to access this page.
</div>
@endif

@endsection