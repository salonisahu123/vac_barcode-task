@extends('layouts.master')

@section('title', 'Departments')

@section('content')

@php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
@endphp

@section('css')
<link rel="stylesheet" href="{{ asset('css/department.css') }}">
@endsection

<x-breadcrumb title="Department Management" page="Department" />

<div class="row">

<!-- ================= LEFT TABLE ================= -->
<div class="col-md-7">

<div class="pro-card">

<div class="section-title">Department List</div>

<div class="table-responsive">

<table class="table">

<thead>
<tr>
    <th>#</th>
    <th>Department</th>
    <th>Location</th>
    <th>Created By</th>
    <th>Action</th>
</tr>
</thead>

<tbody>

@foreach($departments as $key => $dept)
<tr>

<td>{{ $key + 1 }}</td>

<td>
    <span class="pro-badge">
        {{ $dept->dept_name }}
    </span>
</td>

<td>
    <span class="pro-badge">
        {{ $dept->location->name ?? '-' }}
    </span>
</td>

<td>
    {{ $dept->user->name ?? 'Admin' }}
</td>

<td>
<div class="action-group">

@if($isAdmin || hasPermission('department_edit'))
<a href="{{ route('departments.edit', $dept->id) }}"
   class="icon-btn edit-btn">
    <i class="fa fa-pen"></i>
</a>
@endif

@if($isAdmin || hasPermission('department_delete'))
<form action="{{ route('departments.destroy', $dept->id) }}"
      method="POST">

@csrf
@method('DELETE')

<button type="button"
        class="icon-btn delete-btn delete-btn-action">
    <i class="fa fa-trash"></i>
</button>

</form>
@endif

</div>
</td>

</tr>
@endforeach

</tbody>

</table>

</div>

</div>

</div>


<!-- ================= RIGHT FORM ================= -->
@if(
    $isAdmin ||
    (!isset($editDepartment) && hasPermission('department_add')) ||
    (isset($editDepartment) && hasPermission('department_edit'))
)
<div class="col-md-5">

<div class="pro-card">

<div class="section-title">
    {{ isset($editDepartment) ? 'Edit Department' : 'Add Department' }}
</div>

<form method="POST"
action="{{ isset($editDepartment)
    ? route('departments.update', $editDepartment->id)
    : route('departments.store') }}">

@csrf

@if(isset($editDepartment))
    @method('PUT')
@endif


<!-- DEPARTMENT NAME -->
<div class="mb-3">

<label class="form-label">Department Name</label>

<input type="text"
       name="dept_name"
       class="form-control"
       placeholder="Enter department name"
       value="{{ old('dept_name', $editDepartment->dept_name ?? '') }}">

@error('dept_name')
<small class="text-danger">{{ $message }}</small>
@enderror

</div>


<!-- LOCATION -->
<div class="mb-3">

<label class="form-label">Select Location</label>

<select name="location_id" class="form-control">

<option value="">-- Select Location --</option>

@foreach($locations as $location)
<option value="{{ $location->id }}"
    {{ (old('location_id', $editDepartment->location_id ?? '') == $location->id) ? 'selected' : '' }}>
    {{ $location->name }}
</option>
@endforeach

</select>

@error('location_id')
<small class="text-danger">{{ $message }}</small>
@enderror

</div>


<button class="btn primary-btn w-100">
    {{ isset($editDepartment) ? 'Update' : 'Save' }}
</button>

</form>

</div>

</div>
@endif

</div>

@endsection