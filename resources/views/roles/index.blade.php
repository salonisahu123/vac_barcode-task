@extends('layouts.master')

@section('title','Roles')

@section('content')

@php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
@endphp

@section('css')
<link rel="stylesheet" href="{{ asset('css/roles.css') }}">
@endsection

<x-breadcrumb title="Role Management" page="Role" />

<div class="row">

<!-- ================= LEFT TABLE ================= -->
<div class="col-md-7">

<div class="pro-card">

<div class="section-title">Role List</div>

<div class="table-responsive">

<table class="table">

<thead>
<tr>
    <th>#</th>
    <th>Name</th>
    <th>Action</th>
</tr>
</thead>

<tbody>

@foreach($roles as $key => $role)
<tr>

<td>{{ $key+1 }}</td>

<td>
    <span class="pro-badge">
        {{ $role->name }}
    </span>
</td>

<td>
<div class="action-group">

@if($isAdmin || hasPermission('role_edit'))
<a href="{{ route('roles.edit',$role->id) }}"
   class="icon-btn edit-btn">
   <i class="fa fa-pen"></i>
</a>
@endif

@if($isAdmin || hasPermission('role_delete'))
<form action="{{ route('roles.destroy',$role->id) }}"
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
    (!isset($editRole) && hasPermission('role_add')) ||
    (isset($editRole) && hasPermission('role_edit'))
)
<div class="col-md-5">

<div class="pro-card">

<div class="section-title">
    {{ isset($editRole) ? 'Edit Role' : 'Add Role' }}
</div>

<form method="POST"
action="{{ isset($editRole)
    ? route('roles.update',$editRole->id)
    : route('roles.store') }}">

@csrf

@if(isset($editRole))
    @method('PUT')
@endif

<div class="mb-3">
<label class="form-label">Role Name</label>

<input type="text"
       name="name"
       class="form-control"
       value="{{ old('name',$editRole->name ?? '') }}">

@error('name')
<small class="text-danger">{{ $message }}</small>
@enderror

</div>

<button class="btn primary-btn w-100">
    {{ isset($editRole) ? 'Update' : 'Save' }}
</button>

</form>

</div>

</div>
@endif

</div>

@endsection