@extends('layouts.master')

@section('title','Edit Permissions')
@section('css')
<link rel="stylesheet" href="{{ asset('css/role-permission.css') }}">
@endsection

@section('content')

@php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
@endphp

@if($isAdmin || hasPermission('role_permission_edit'))

<div class="permission-card">

<div class="d-flex justify-content-between align-items-center">
    <div class="page-title">Edit Permissions</div>

    <a href="{{ route('roles_permissions.index') }}" class="btn btn-secondary btn-sm">
        Back
    </a>
</div>

<form method="POST" action="{{ route('roles_permissions.update', $role->id) }}">
@csrf
@method('PUT')

{{-- ROLE --}}
<div class="role-box mb-3">
    <label>Role</label>

    <select name="role_id" class="form-control">
    @foreach($roles as $r)
        <option value="{{ $r->id }}" 
            {{ $r->id == $role->id ? 'selected' : '' }}>
            {{ $r->name }}
        </option>
    @endforeach
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
           name="permissions[]"
           value="{{ $perm->id }}"
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

<button class="save-btn">Update Permissions</button>

</form>

</div>

@else
<div class="alert alert-danger">
    You do not have permission to access this page.
</div>
@endif

@endsection