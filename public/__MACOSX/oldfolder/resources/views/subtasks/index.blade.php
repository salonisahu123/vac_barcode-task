@extends('layouts.master')

@section('title', 'Subtasks')

@section('content')

@php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
@endphp

@section('css')
<link rel="stylesheet" href="{{ asset('css/location.css') }}">
@endsection

<x-breadcrumb title="Subtask Management" page="Subtask" />

<div class="row">

<!-- ================= LEFT TABLE ================= -->
<div class="col-md-7">

<div class="pro-card">

<div class="section-title">Subtask List</div>

<div class="table-responsive">

<table class="table table-bordered">

<thead>
<tr>
    <th>#</th>
    <th>Subtask Name</th>
    <th>Created By</th>
    <th>Action</th>
</tr>
</thead>

<tbody>

@foreach($subtasks as $key => $subtask)
<tr>

<td>{{ $key + 1 }}</td>

<td>
    <span class="pro-badge">
        {{ $subtask->subtask }}
    </span>
</td>

<td>
    {{ $subtask->user->name ?? 'Admin' }}
</td>

<td>
<div class="action-group">

<a href="{{ route('subtasks.edit', $subtask->id) }}"
   class="icon-btn edit-btn">
    <i class="fa-solid fa-pen"></i>
</a>

<form action="{{ route('subtasks.destroy', $subtask->id) }}"
      method="POST"
      class="delete-form">

    @csrf
    @method('DELETE')

    <button type="button" class="icon-btn delete-btn">
        <i class="fa fa-trash"></i>
    </button>

</form>

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
<div class="col-md-5">

<div class="pro-card">

<div class="section-title">
    {{ isset($editSubtask) ? 'Edit Subtask' : 'Add Subtask' }}
</div>

<form method="POST"
action="{{ isset($editSubtask)
    ? route('subtasks.update', $editSubtask->id)
    : route('subtasks.store') }}">

@csrf

@if(isset($editSubtask))
    @method('PUT')
@endif

<div class="mb-3">

    <label class="form-label">Subtask Name</label>

    <input type="text"
           name="subtask"
           class="form-control @error('subtask') is-invalid @enderror"
           placeholder="Enter Subtask name"
           value="{{ old('subtask', $editSubtask->subtask ?? '') }}">

    @error('subtask')
        <small class="text-danger d-block mt-1">
            {{ $message }}
        </small>
    @enderror

</div>

<button class="btn primary-btn w-100">
    {{ isset($editSubtask) ? 'Update' : 'Save' }}
</button>

</form>

</div>

</div>

</div>

@endsection