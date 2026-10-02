@extends('layouts.master')

@section('title','Edit Ticket')

@section('css')
<link rel="stylesheet" href="{{ asset('css/ticket.css') }}">
@endsection

@section('content')

@php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
@endphp

{{-- 🔐 PERMISSION CHECK --}}
@if($isAdmin || hasPermission('ticket_edit'))

<x-breadcrumb title="Ticket Management" page="Edit Ticket" />

<div class="row">
<div class="col-md-12">

<div class="main-card p-3">

<form method="POST" action="{{ route('tickets.update',$ticket->id) }}" enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="row">

    {{-- TITLE --}}
    <div class="col-md-4 field-box">
        <label class="form-label">Title</label>
        <input type="text" name="title"
               class="form-control"
               value="{{ old('title',$ticket->title) }}">

        @error('title')
        <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    {{-- DEPARTMENT --}}
    <div class="col-md-4 field-box">
        <label class="form-label">Department</label>

        <select name="department_id" class="form-control">
            <option value="">Select</option>

            @foreach($departments as $dept)
            <option value="{{ $dept->id }}"
                {{ old('department_id',$ticket->department_id) == $dept->id ? 'selected' : '' }}>
                {{ $dept->dept_name }}
            </option>
            @endforeach
        </select>

        @error('department_id')
        <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    {{-- TICKET TYPE --}}
    <div class="col-md-4 field-box">
        <label class="form-label">Ticket Type</label>

        <select name="ticket_type" id="ticket_type" class="form-control">
            <option value="">Select</option>

            <option value="individual"
                {{ old('ticket_type',$ticket->ticket_type) == 'individual' ? 'selected' : '' }}>
                Individual
            </option>

            <option value="location"
                {{ old('ticket_type',$ticket->ticket_type) == 'location' ? 'selected' : '' }}>
                Location
            </option>
        </select>

        @error('ticket_type')
        <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    {{-- LOCATION --}}
    
    
    <div class="col-md-4 field-box d-none" id="locationBox">
        <label class="form-label">Location</label>

        <select name="location_id" id="location_id" class="form-control" data-old="{{ old('location_id',$ticket->location_id) }}">
            <option value="">Select</option>

            @foreach($locations as $loc)
            <option value="{{ $loc->id }}"
                {{ old('location_id',$ticket->location_id) == $loc->id ? 'selected' : '' }}>
                {{ $loc->name }}
            </option>
            @endforeach

        </select>

        @error('location_id')
        <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    {{-- PRIORITY --}}
    <div class="col-md-4 field-box">
        <label class="form-label">Priority</label>

        <select name="priority" class="form-control">
            <option value="">Select</option>

            <option value="low"
                {{ old('priority',$ticket->priority) == 'low' ? 'selected' : '' }}>
                Low
            </option>

            <option value="medium"
                {{ old('priority',$ticket->priority) == 'medium' ? 'selected' : '' }}>
                Medium
            </option>

            <option value="high"
                {{ old('priority',$ticket->priority) == 'high' ? 'selected' : '' }}>
                High
            </option>
        </select>

        @error('priority')
        <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    {{-- SUBJECT --}}
    <div class="col-md-4 field-box">
        <label class="form-label">Subject</label>

        <input type="text"
               name="subject"
               class="form-control"
               value="{{ old('subject',$ticket->subject) }}">

        @error('subject')
        <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    {{-- ATTACHMENT --}}
    <div class="col-md-4 field-box">
        <label class="form-label">Attachment</label>

        <input type="file" name="attachment" class="form-control">

        @if($ticket->attachment)
        <small class="text-success d-block mt-1">
            Current File :
            <a href="{{ asset('uploads/tickets/'.$ticket->attachment) }}" target="_blank">
                View File
            </a>
        </small>
        @endif

        @error('attachment')
        <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

    {{-- DESCRIPTION --}}
    <div class="col-md-12 field-box">
        <label class="form-label">Description</label>

        <textarea name="description"
                  class="form-control"
                  rows="5">{{ old('description',$ticket->description) }}</textarea>

        @error('description')
        <div class="error-text">{{ $message }}</div>
        @enderror
    </div>

</div>

<div class="mt-3">
    <button type="submit" class="btn btn-primary">
        Update Ticket
    </button>

    <a href="{{ route('tickets.index') }}" class="btn btn-secondary">
        Back
    </a>
</div>

</form>

</div>
</div>
</div>

@else

<div class="alert alert-danger">
    You do not have permission to edit ticket.
</div>

@endif

@endsection


@section('script')
<script>
$(function () {

    let savedLocation = "{{ old('location_id', $ticket->location_id) }}";

    function toggleLocation() {

        let type = $('#ticket_type').val();

        if(type === 'location')
        {
            $('#locationBox').removeClass('d-none');

            // restore saved location every time
            $('#location_id').val(savedLocation);
        }
        else
        {
            $('#locationBox').addClass('d-none');
        }
    }

    toggleLocation();

    $('#ticket_type').on('change', function () {
        toggleLocation();
    });

});
</script>
@endsection
