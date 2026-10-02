@extends('layouts.master')

@section('title','Permissions')

@section('css')
<link rel="stylesheet" href="{{ asset('css/permission.css') }}">
@endsection

@section('content')

@php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
@endphp

<x-breadcrumb title="Permission Management" page="Permission" />

<div class="row">

<!-- ================= LEFT TABLE ================= -->
<div class="col-md-7">

<div class="custom-card">

<h5 class="mb-3 section-title">Permission List</h5>

<table class="custom-table">

<thead>
<tr>
    <th>#</th>
    <th>Name</th>
    <th>Action</th>
    <th>Module</th>
    <th>Manage</th>
</tr>
</thead>

<tbody>

@foreach($permissions as $key => $perm)
<tr>

<td>{{ $key+1 }}</td>

<td>{{ $perm->name }}</td>

<td>
    <span class="badge-custom">
        {{ ucfirst($perm->action) }}
    </span>
</td>

<td>{{ $perm->module }}</td>

<td style="display:flex; gap:6px;">

{{-- EDIT --}}
@if($isAdmin || hasPermission('permission_edit'))
<a href="{{ route('permissions.edit',$perm->id) }}"
         class="icon-btn edit-btn">
      <i class="fa fa-pen"></i>
</a>
@endif

{{-- DELETE --}}
@if($isAdmin || hasPermission('permission_delete'))
<form action="{{ route('permissions.destroy',$perm->id) }}" method="POST">
@csrf
@method('DELETE')

<button type="submit"
class="icon-btn delete-btn delete-btn-action">
        <i class="fa fa-trash"></i>
</button>
</form>
@endif

</td>

</tr>
@endforeach

</tbody>

</table>

</div>
</div>

<!-- ================= RIGHT FORM ================= -->
<div class="col-md-5">

<div class="custom-card">

<h5 class="mb-3 section-title">
    {{ isset($editPermission) ? 'Edit Permission' : 'Add Permission' }}
</h5>

<form method="POST"
action="{{ isset($editPermission)
    ? route('permissions.update',$editPermission->id)
    : route('permissions.store') }}">

@csrf
@if(isset($editPermission))
    @method('PUT')
@endif

{{-- MODULE --}}
<div class="mb-3">
<label class="form-label">Module Name</label>

<input type="text"
       name="module"
       class="form-control"
       value="{{ old('module',$editPermission->module ?? '') }}"
       placeholder="Enter module name">

@error('module')
<small class="text-danger">{{ $message }}</small>
@enderror
</div>

{{-- ACTION --}}
<div class="mb-3">
    <label class="form-label">Select Action</label>

    @php
        $actions = ['view','add','edit','delete','change_status'];
    @endphp

    <div class="custom-select-wrapper">
        <select name="action" class="form-select action-select">

            <option value="">Choose Action</option>

            @foreach($actions as $action)
                <option value="{{ $action }}"
                {{ (old('action',$editPermission->action ?? '') == $action) ? 'selected' : '' }}>
                    {{ ucfirst($action) }}
                </option>
            @endforeach

        </select>

@error('action')
<small class="text-danger">{{ $message }}</small>
@enderror
        
    </div>
</div>

<button class="save-btn">
    {{ isset($editPermission) ? 'Update Permission' : 'Save Permission' }}
</button>

</form>

</div>
</div>

</div>

@endsection