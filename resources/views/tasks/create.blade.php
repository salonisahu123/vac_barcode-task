@extends('layouts.master')

@section('title','Create Task')

@section('css')
<!-- ADD -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<link rel="stylesheet" href="{{ asset('css/task.css') }}">
@endsection

@section('content')

@php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
@endphp

{{-- 🔐 PERMISSION CHECK --}}
@if($isAdmin || hasPermission('task_add'))


<x-breadcrumb title="Task Management" page="Create Task" />

<div class="row">
<div class="col-md-12">

<div class="main-card">

<form method="POST" action="{{ route('tasks.store') }}" enctype="multipart/form-data">
@csrf

<div class="dynamic-grid">

    {{-- Title --}}
    <div class="field-box" id="box_title">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" placeholder="Enter title" value="{{ old('title') }}">
        @error('title')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Task Type --}}
    <div class="field-box" id="box_task_type">
        <label class="form-label">Task Type</label>
        <select name="task_type" id="task_type" class="form-control">
            <option value="">Select</option>
            <option value="individual" {{ old('task_type')=='individual'?'selected':'' }}>Individual</option>
            <option value="location" {{ old('task_type')=='location'?'selected':'' }}>Location</option>
        </select>

        @error('task_type')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>


    {{-- Individual Employee --}}
    <div class="field-box d-none" id="individual_box">
        <label class="form-label">Employees</label>
       <select name="assigned_to[]" class="form-control choices" multiple>
        @foreach($employees as $emp)
        <option value="{{ $emp->id }}"
        {{ collect(old('assigned_to'))->contains($emp->id) ? 'selected' : '' }}>
        {{ $emp->user->name }}
        </option>
        @endforeach
        </select>

        @error('assigned_to')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- Mode --}}
    <div class="field-box d-none" id="location_box">
        <label class="form-label">Mode</label>

        <select id="mode" name="mode" class="form-control">
            <option value="">Select</option>
            <option value="location_wise" {{ old('mode')=='location_wise' ? 'selected' : '' }}>Location Wise</option>
            <option value="group_team" {{ old('mode')=='group_team' ? 'selected' : '' }}>Group / Team</option>
        </select>

        @error('mode')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

   {{-- Location --}}
<div class="field-box d-none" id="location_select_box">
    <label class="form-label">Location</label>

    <select id="location_select" name="location_id" class="form-control choices">
        <option value="">Select</option>
        @foreach($locations as $loc)
            <option value="{{ $loc->id }}"
                {{ old('location_id') == $loc->id ? 'selected' : '' }}>
                {{ $loc->name }}
            </option>
        @endforeach
    </select>

    @error('location_id')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>


{{-- Group --}}
<div class="field-box d-none" id="group_box">
    <label class="form-label">Group / Team</label>

    <select name="group_id" class="form-control choices">
        <option value="">Select</option>
        @foreach($groups as $group)
            <option value="{{ $group->id }}"
                {{ old('group_id') == $group->id ? 'selected' : '' }}>
                {{ $group->group_name }}
            </option>
        @endforeach
    </select>

    @error('group_id')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

     {{-- Location Employee --}}
<div class="field-box d-none" id="location_employee_box">
    <label class="form-label">Employees</label>

    <select name="assigned_to[]" id="location_employees" class="form-control choices" multiple></select>

    @error('assigned_to')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

    {{-- Sub Task --}}
<div class="field-box" id="box_subtask">
    <label class="form-label">Sub Task</label>

    <select name="subtask_id" id="subtask_id" class="form-control">
        <option value="">Select Sub Task</option>

        @foreach($subtask as $item)
            <option value="{{ $item->id }}"
                {{ old('subtask_id') == $item->id ? 'selected' : '' }}>
                {{ $item->subtask }}
            </option>
        @endforeach
    </select>

    @error('subtask_id')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

      {{-- Status --}}
  <div class="field-box" id="box_status">
    <label class="form-label">Status</label>

    <input type="text" class="form-control" value="Pending" readonly>

    <!-- hidden for submit -->
    <input type="hidden" name="status" value="pending">
</div>

   

    {{-- From --}}
    <div class="field-box">
        <label class="form-label">From Date</label>
        <input type="date" name="from_date" class="form-control">
        @error('from_date')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- To --}}
    <div class="field-box">
        <label class="form-label">To Date</label>
        <input type="date" name="to_date" class="form-control">
        @error('to_date')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    {{-- File --}}
    <div class="field-box">
        <label class="form-label">File</label>
        <input type="file" name="file" class="form-control">
    </div>

    {{-- Description --}}
    <div class="field-box" style="width:100%;">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control"></textarea>
    </div>
    
  

</div>

<div class="mt-3">
    <button type="submit" class="btn btn-save">Save Task</button>
</div>

</form>

</div>
</div>
</div>

@else

<div class="alert alert-danger">
    You do not have permission to create tasks.
</div>

@endif

@endsection

@section('script')

<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

let employeeChoice; 

$(document).ready(function(){

    // ✅ DataTable safe init
    if ($.fn.DataTable) {
        $('#table').DataTable();
    }

    // ✅ Init Choices (EXCEPT dynamic employee)
    document.querySelectorAll('.choices').forEach(function(el){
        if(el.id !== 'location_employees'){
            new Choices(el, {
                removeItemButton: true,
                searchEnabled: true,
                shouldSort: false,
                itemSelectText: ''
            });
        }
    });

    // ✅ Init dynamic employee dropdown separately
    employeeChoice = new Choices('#location_employees', {
        removeItemButton: true,
        searchEnabled: true,
        shouldSort: false,
        itemSelectText: ''
    });

    // ================= RESET =================
    function resetAll(){
        $('#individual_box').addClass('d-none');
        $('#location_box').addClass('d-none');
        $('#location_select_box').addClass('d-none');
        $('#location_employee_box').addClass('d-none');
        $('#group_box').addClass('d-none');
    }

    // ================= TASK TYPE =================
    $('#task_type').change(function(){

        resetAll();

        let type = $(this).val();

        if(type == 'individual'){
            $('#individual_box').removeClass('d-none');
        }

        if(type == 'location'){
            $('#location_box').removeClass('d-none');
        }
    });

    // ================= MODE =================
    $('#mode').change(function(){

        $('#location_select_box').addClass('d-none');
        $('#location_employee_box').addClass('d-none');
        $('#group_box').addClass('d-none');

        let mode = $(this).val();

        if(mode == 'location_wise'){
            $('#location_select_box').removeClass('d-none');
        }

        if(mode == 'group_team'){
            $('#group_box').removeClass('d-none');
        }
    });

    // ================= LOCATION CHANGE (🔥 FIXED) =================
    $('#location_select').change(function(){

        let locationId = $(this).val();
        let data = [];

        @foreach($employees as $emp)
            if("{{ $emp->location_id }}" == locationId){
                data.push({
                    value: "{{ $emp->id }}",
                    label: "{{ $emp->user->name }}"
                });
            }
        @endforeach

        // 🔥 clear + set choices (IMPORTANT)
        employeeChoice.clearChoices();
        employeeChoice.setChoices(data, 'value', 'label', true);

        // show/hide
        if(locationId != ''){
            $('#location_employee_box').removeClass('d-none');
        }else{
            $('#location_employee_box').addClass('d-none');
        }

    });

    // ================= OLD VALUE RESTORE =================
    let oldTaskType = "{{ old('task_type') }}";
    let oldMode     = "{{ old('mode') }}";
    let oldLocation = "{{ old('location_id') }}";

    if(oldTaskType){
        $('#task_type').val(oldTaskType).trigger('change');
    }

    if(oldMode){
        $('#mode').val(oldMode).trigger('change');
    }

    if(oldLocation){
        $('#location_select').val(oldLocation).trigger('change');
    }

});


</script>

@endsection

