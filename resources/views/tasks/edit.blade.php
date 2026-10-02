@extends('layouts.master')

@section('title', 'Edit Task')

@section('css')

<link rel="stylesheet" href="{{ asset('css/task.css') }}">

<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">

@endsection


@section('content')

@php

$user = Auth::user();

$isAdmin = $user->user_type == 'admin';

$employeeId = \App\Models\Employee::where(
    'user_id',
    $user->id
)->value('id');

$isAssigned = $task->taskUsers
    ->where('assigned_to', $employeeId)
    ->count() > 0;

$isCreator = $task->user_id == $user->id;

$canEditTask =
    $isAdmin ||
    hasPermission('task_edit') ||
    (
        hasPermission('task_view_own') &&
        ($isAssigned || $isCreator)
    );

@endphp


@if($canEditTask)

<x-breadcrumb title="Task Management" page="Edit Task" />


@php

$selectedEmployees = $task->taskUsers
    ->pluck('assigned_to')
    ->toArray();

$individualEmployees = ($task->task_type === 'individual')
    ? $selectedEmployees
    : [];

$locationEmployees = ($task->task_type !== 'individual')
    ? $selectedEmployees
    : [];

@endphp


<div class="row">

    <div class="col-md-12">

        <div class="main-card">

            <form method="POST"
                  action="{{ route('tasks.update', $task->id) }}"
                  enctype="multipart/form-data">

                @csrf

                @method('PUT')


                <div class="dynamic-grid">


                    {{-- TITLE --}}
                    <div class="field-box">

                        <label class="form-label">
                            Title
                        </label>

                        <input type="text"
                               name="title"
                               class="form-control"
                               value="{{ $task->title }}">

                        @error('title')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- TASK TYPE --}}
                    <div class="field-box">

                        <label class="form-label">
                            Task Type
                        </label>

                        <select name="task_type"
                                id="task_type"
                                class="form-control">

                            <option value="">
                                Select
                            </option>

                            <option value="individual"
                                {{ $task->task_type == 'individual' ? 'selected' : '' }}>
                                Individual
                            </option>

                            <option value="location"
                                {{ $task->task_type == 'location' ? 'selected' : '' }}>
                                Location
                            </option>

                        </select>

                        @error('task_type')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- INDIVIDUAL EMPLOYEES --}}
                    <div class="field-box d-none"
                         id="individual_box">

                        <label class="form-label">
                            Employees
                        </label>

                        <select name="assigned_to[]"
                                class="form-control choices"
                                multiple>

                            @foreach($employees as $emp)

                                <option value="{{ $emp->id }}"
                                    {{ in_array($emp->id, $individualEmployees) ? 'selected' : '' }}>

                                    {{ $emp->user->name }}

                                </option>

                            @endforeach

                        </select>

                        @error('assigned_to')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- MODE --}}
                    <div class="field-box d-none"
                         id="location_box">

                        <label class="form-label">
                            Mode
                        </label>

                        <select name="mode"
                                id="mode"
                                class="form-control">

                            <option value="">
                                Select
                            </option>

                            <option value="location_wise"
                                {{ $task->mode == 'location_wise' ? 'selected' : '' }}>
                                Location Wise
                            </option>

                            <option value="group_team"
                                {{ $task->mode == 'group_team' ? 'selected' : '' }}>
                                Group Team
                            </option>

                        </select>

                        @error('mode')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- LOCATION --}}
                    <div class="field-box d-none"
                         id="location_select_box">

                        <label class="form-label">
                            Location
                        </label>

                        <select name="location_id"
                                id="location_select"
                                class="form-control choices">

                            <option value="">
                                Select
                            </option>

                            @foreach($locations as $loc)

                                <option value="{{ $loc->id }}"
                                    {{ $task->location_id == $loc->id ? 'selected' : '' }}>

                                    {{ $loc->name }}

                                </option>

                            @endforeach

                        </select>

                        @error('location_id')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- GROUP --}}
                    <div class="field-box d-none"
                         id="group_box">

                        <label class="form-label">
                            Group
                        </label>

                        <select name="group_id"
                                class="form-control choices">

                            <option value="">
                                Select
                            </option>

                            @foreach($groups as $group)

                                <option value="{{ $group->id }}"
                                    {{ $task->group_id == $group->id ? 'selected' : '' }}>

                                    {{ $group->group_name }}

                                </option>

                            @endforeach

                        </select>

                        @error('group_id')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- LOCATION EMPLOYEES --}}
                    <div class="field-box d-none"
                         id="location_employee_box">

                        <label class="form-label">
                            Employees
                        </label>

                        <select id="location_employees"
                                name="assigned_to[]"
                                class="form-control"
                                multiple>
                        </select>

                        @error('assigned_to')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- SUB TASK --}}
                    <div class="field-box">

                        <label class="form-label">
                            Sub Task
                        </label>

                        <select name="subtask_id"
                                class="form-control">

                            <option value="">
                                Select Sub Task
                            </option>

                            @foreach($subtask as $item)

                                <option value="{{ $item->id }}"
                                    {{ $task->subtask_id == $item->id ? 'selected' : '' }}>

                                    {{ $item->subtask }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- STATUS --}}
                    <div class="field-box">

                        <label class="form-label">
                            Status
                        </label>

                        <select name="status"
                                class="form-control">

                            <option value="pending"
                                {{ $task->status == 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>

                            <option value="in_progress"
                                {{ $task->status == 'in_progress' ? 'selected' : '' }}>
                                In Progress
                            </option>

                            <option value="completed"
                                {{ $task->status == 'completed' ? 'selected' : '' }}>
                                Completed
                            </option>

                        </select>

                        @error('status')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- FROM DATE --}}
                    <div class="field-box">

                        <label class="form-label">
                            From Date
                        </label>

                        <input type="date"
                               name="from_date"
                               class="form-control"
                               value="{{ $task->from_date }}">

                        @error('from_date')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- TO DATE --}}
                    <div class="field-box">

                        <label class="form-label">
                            To Date
                        </label>

                        <input type="date"
                               name="to_date"
                               class="form-control"
                               value="{{ $task->to_date }}">

                        @error('to_date')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- FILE --}}
                    <div class="field-box">

                        <label class="form-label">
                            File
                        </label>

                        <input type="file"
                               name="file"
                               class="form-control">

                        @if($task->file)

                            <div class="mt-2">

                                <a href="{{ asset('uploads/tasks/' . $task->file) }}"
                                   target="_blank"
                                   class="btn btn-sm btn-info">

                                    View Current File

                                </a>

                            </div>

                        @endif

                        @error('file')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- DESCRIPTION --}}
                    <div class="field-box"
                         style="width:100%;">

                        <label class="form-label">
                            Description
                        </label>

                        <textarea name="description"
                                  class="form-control">{{ $task->description }}</textarea>

                        @error('description')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                </div>


                <button type="submit"
                        class="btn btn-save mt-3">

                    Update Task

                </button>


            </form>

        </div>

    </div>

</div>


@else

    <div class="alert alert-danger">

        You do not have permission to edit tasks.

    </div>

@endif

@endsection


@section('script')

<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>

let employeeChoice;


$(document).ready(function () {


    // ==============================
    // DATA FROM LARAVEL
    // ==============================

    let employees = @json($employees);

    let individualSelected = @json($individualEmployees);

    let locationSelected = @json($locationEmployees);


    // ==============================
    // NORMAL CHOICES
    // ==============================

    document.querySelectorAll('.choices').forEach(function (el) {

        new Choices(el, {

            removeItemButton: true,

            searchEnabled: true,

            shouldSort: false,

            itemSelectText: ''

        });

    });


    // ==============================
    // LOCATION EMPLOYEE CHOICES
    // ==============================

    employeeChoice = new Choices('#location_employees', {

        removeItemButton: true,

        searchEnabled: true,

        shouldSort: false,

        itemSelectText: ''

    });


    // ==============================
    // RESET UI
    // ==============================

    function resetAll() {

        $('#individual_box').addClass('d-none');

        $('#location_box').addClass('d-none');

        $('#location_select_box').addClass('d-none');

        $('#location_employee_box').addClass('d-none');

        $('#group_box').addClass('d-none');

    }


    // ==============================
    // LOAD LOCATION EMPLOYEES
    // ==============================

    function loadLocationEmployees(locationId) {

        let data = [];

        employees.forEach(function (emp) {

            if (emp.location_id == locationId) {

                data.push({

                    value: emp.id,

                    label: emp.user.name,

                    selected: locationSelected.includes(emp.id)

                });

            }

        });


        employeeChoice.clearChoices();


        employeeChoice.setChoices(
            data,
            'value',
            'label',
            true
        );

    }


    // ==============================
    // TOGGLE UI
    // ==============================

    function toggleUI() {

        let type = $('#task_type').val();

        let mode = $('#mode').val();


        resetAll();


        // INDIVIDUAL
        if (type === 'individual') {

            $('#individual_box')
                .removeClass('d-none');

        }


        // LOCATION
        if (type === 'location') {

            $('#location_box')
                .removeClass('d-none');


            // LOCATION WISE
            if (mode === 'location_wise') {

                $('#location_select_box')
                    .removeClass('d-none');


                let locationId =
                    $('#location_select').val();


                if (locationId) {

                    $('#location_employee_box')
                        .removeClass('d-none');

                    loadLocationEmployees(locationId);

                }

            }


            // GROUP TEAM
            if (mode === 'group_team') {

                $('#group_box')
                    .removeClass('d-none');

            }

        }

    }


    // ==============================
    // TASK TYPE CHANGE
    // ==============================

    $('#task_type').on('change', function () {

        let type = $(this).val();


        if (type === 'individual') {

            employeeChoice.clearChoices();

        }


        if (type === 'location') {

            // Individual selected employees clear
            $('select[name="assigned_to[]"]')
                .val([]);

        }


        toggleUI();

    });


    // ==============================
    // MODE CHANGE
    // ==============================

    $('#mode').on('change', function () {

        toggleUI();

    });


    // ==============================
    // LOCATION CHANGE
    // ==============================

    $('#location_select').on('change', function () {

        let locationId = $(this).val();


        if (locationId) {

            $('#location_employee_box')
                .removeClass('d-none');

            loadLocationEmployees(locationId);

        } else {

            $('#location_employee_box')
                .addClass('d-none');

            employeeChoice.clearChoices();

        }

    });


    // ==============================
    // INITIAL LOAD
    // ==============================

    toggleUI();


});

</script>

@endsection