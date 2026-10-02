@extends('layouts.master')

@section('title', 'Locations')

@section('content')

@php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
@endphp

@section('css')
<link rel="stylesheet" href="{{ asset('css/location.css') }}">
@endsection

<x-breadcrumb title="Location Management" page="Location" />

<div class="row">

<!-- ================= LEFT TABLE ================= -->
<div class="col-md-7">

<div class="pro-card">

<div class="section-title">Location List</div>

<div class="table-responsive">

<table class="table table-bordered">

<thead>
<tr>
    <th>#</th>
    <th>Location Name</th>
    <th>Created By</th>
    <th>Action</th>
</tr>
</thead>

<tbody>

@foreach($locations as $key => $location)
<tr>

<td>{{ $key + 1 }}</td>

<td>
    <span class="pro-badge">
        {{ $location->name }}
    </span>
</td>

<td>
    {{ $location->user->name ?? 'Admin' }}
</td>

<td>
<div class="action-group">

@if($isAdmin || hasPermission('location_edit'))
<a href="{{ route('locations.edit', $location->id) }}"
   class="icon-btn edit-btn">
    <i class="fa-solid fa-pen"></i>
</a>
@endif

@if($isAdmin || hasPermission('location_delete'))
<form action="{{ route('locations.destroy', $location->id) }}"
      method="POST"
      class="delete-form">

    @csrf
    @method('DELETE')

    <button type="button" class="icon-btn delete-btn">
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
@if($isAdmin || hasPermission('location_add') || isset($editLocation))
<div class="col-md-5">

<div class="pro-card">

<div class="section-title">
    {{ isset($editLocation) ? 'Edit Location' : 'Add Location' }}
</div>

<form method="POST"
action="{{ isset($editLocation)
    ? route('locations.update', $editLocation->id)
    : route('locations.store') }}">

@csrf

@if(isset($editLocation))
    @method('PUT')
@endif

<div class="mb-3">

    <label class="form-label">Location Name</label>

    <input type="text"
           name="name"
           class="form-control @error('name') is-invalid @enderror"
           placeholder="Enter location name"
           value="{{ old('name', $editLocation->name ?? '') }}">

    @error('name')
        <small class="text-danger d-block mt-1">
            {{ $message }}
        </small>
    @enderror

</div>

<button class="btn primary-btn w-100">
    {{ isset($editLocation) ? 'Update' : 'Save' }}
</button>

</form>

</div>

</div>
@endif

</div>

@endsection