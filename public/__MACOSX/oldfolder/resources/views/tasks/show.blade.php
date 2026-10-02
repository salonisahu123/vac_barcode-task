@extends('layouts.master')

@section('title','Task Details')

@section('css')
<!-- ADD -->
<link rel="stylesheet" href="{{ asset('css/task.css') }}">
@endsection

@section('content')

@if(auth()->user()->user_type == 'admin' || hasPermission('task_view_all') || hasPermission('task_view_own'))

<x-breadcrumb title="Task Management" page="Task Details" />

<div class="container-fluid mt-3">

<div class="task-card">

    {{-- HEADER --}}
   {{-- HEADER --}}
<div class="task-header d-flex justify-content-between align-items-center">

    {{-- LEFT SIDE --}}
    <div>
        <div class="task-title">
            <i class="fa fa-tasks text-primary"></i>
            {{ $task['title'] }}
        </div>
        <small class="text-muted">
            Created By {{ $task['created_by'] }}
        </small>
    </div>

    {{-- RIGHT SIDE ACTION BUTTONS --}}
    <div class="d-flex gap-2">

        {{-- BACK BUTTON --}}
        <a href="{{ route('tasks.index') }}"
           class="btn btn-light btn-sm shadow-sm"
           style="border-radius:8px;">
            <i class="fa fa-arrow-left"></i> Back
        </a>

        {{-- EDIT BUTTON --}}
        @if(auth()->user()->user_type == 'admin' || hasPermission('task_edit'))
            <a href="{{ route('tasks.edit', $task['id'] ?? $task->id) }}"
               class="btn btn-primary btn-sm shadow-sm"
               style="border-radius:8px;">
                <i class="fa fa-edit"></i> Edit
            </a>
        @endif

    </div>

</div>

    {{-- TABS --}}
    <div class="tab-box">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#overview">Overview</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#activity">Activity</a>
            </li>
        </ul>
    </div>

    <div class="tab-content p-3">

        {{-- OVERVIEW --}}

<div class="tab-pane fade show active" id="overview">

    <div class="row">

        {{-- LEFT SIDE --}}
        <div class="col-md-4">

           {{-- TITLE --}}
            <div class="card border-0 shadow-sm mb-3 rounded-lg">
                <div class="card-body">
                    <small class="text-muted">Task Title</small>
                    <h5 class="mb-0 mt-1">
                        {{ $task->title ?? 'No Title' }}
                    </h5>
                    <small class="text-muted">
                        Created By: {{ $task->createdBy->name ?? 'Unknown' }}
                    </small>
                </div>
            </div>

            {{-- STATUS --}}
            @php
                $statusClass = [
                    'pending' => 'warning',
                    'in_progress' => 'info',
                    'completed' => 'success'
                ];
            @endphp

            <div class="card border-0 shadow-sm mb-3 rounded-lg">
                <div class="card-body">
                    <small class="text-muted">Status</small><br>
                    <span class="badge badge-{{ $statusClass[$task->status] ?? 'secondary' }} px-3 py-2 mt-1">
                        {{ ucfirst($task->status ?? 'Not Available') }}
                    </span>
                </div>
            </div>

            {{-- MODE --}}
            <div class="card border-0 shadow-sm mb-3 rounded-lg">
                <div class="card-body">
                    <small class="text-muted">Mode</small><br>

                    @if(!empty($task->mode))
                        <span class="badge badge-dark px-3 py-2 mt-1">
                            {{ ucfirst($task->mode) }}
                        </span>
                    @else
                        <span class="text-danger">No Mode</span>
                    @endif
                </div>
            </div>

            {{-- DATES --}}
            <div class="card border-0 shadow-sm mb-3 rounded-lg">
                <div class="card-body">
                    <small class="text-muted">Timeline</small>

                    <p class="mb-1 mt-2">
                        <b>From:</b>
                        {{ $task->from_date ?? 'Not Available' }}
                    </p>

                    <p class="mb-0">
                        <b>To:</b>
                        {{ $task->to_date ?? 'Not Available' }}
                    </p>
                </div>
            </div>

        </div>

        {{-- RIGHT SIDE --}}
        <div class="col-md-8">
            
             
              {{-- TASK TYPE --}}
            <div class="card border-0 shadow-sm mb-3 rounded-lg">
                <div class="card-body">
                    <small class="text-muted">Task Type</small><br>
                    <span class="badge badge-primary px-3 py-2 mt-1">
                        {{ ucfirst($task->task_type ?? 'Not Available') }}
                    </span>
                </div>
            </div>
            
            {{-- SUB TASK --}}
            <div class="card border-0 shadow-sm mb-3 rounded-lg">
                <div class="card-body">
                    <small class="text-muted">Sub Task</small><br>
            
                    <span class="badge badge-success px-3 py-2 mt-1">
                        {{ $task->subtask_name }}
                    </span>
                </div>
            </div>

            {{-- DESCRIPTION --}}
            <div class="card border-0 shadow-sm mb-3 rounded-lg">
                <div class="card-body">
                    <small class="text-muted">Description</small>

                    <p class="mb-0 mt-2 text-secondary">
                        {{ $task->description ?? 'No Description Available' }}
                    </p>
                </div>
            </div>

            {{-- FILE --}}
            <div class="card border-0 shadow-sm mb-3 rounded-lg">
                <div class="card-body">
                    <small class="text-muted">Attachment</small>

                    <div class="mt-2">
                        @if(!empty($task->file))
                            <a href="{{ asset('uploads/tasks/'.$task->file) }}"
                               target="_blank"
                               class="btn btn-sm btn-outline-primary">
                                View File
                            </a>
                        @else
                            <span class="text-muted">No File Attached</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ASSIGNED EMPLOYEES --}}
            <div class="card border-0 shadow-sm mb-3 rounded-lg">
                <div class="card-body">

                    <small class="text-muted">Assigned Employees</small>

                    <div class="d-flex flex-wrap mt-3">

                        @forelse($task->taskUsers as $assign)

                            @php
                                $emp = $assign->employee->user ?? null;
                            @endphp

                            <div class="text-center mr-3 mb-3">

                                <img src="{{ !empty($assign->employee->image) 
                                    ? asset('uploads/employees/'.$assign->employee->image) 
                                    : asset('uploads/employees/user.png') }}"
                                 class="rounded-circle shadow-sm"
                                 width="50"
                                 height="50">

                                <div style="font-size:12px;" class="mt-1">
                                    {{ $emp->name ?? 'Employee' }}
                                </div>

                            </div>

                        @empty
                            <span class="text-muted">No Employees Assigned</span>
                        @endforelse

                    </div>

                </div>
            </div>

        </div>

    </div>

</div>

{{-- ACTIVITY (FULL HISTORY) --}}
    

<div class="tab-pane fade" id="activity">

    <div class="activity-wrapper">

        {{-- HEADER --}}
        <div class="activity-header">
            <i class="fa fa-history text-primary"></i>
            <span>Activity Timeline</span>
        </div>

        {{-- TIMELINE --}}
        <div class="timeline">

            @forelse($activities as $act)

                @php
                    $empName = null;

                    if($act->table_name == 'ticket_assignments') {
                        $assign = \App\Models\TicketAssignment::with('employee.user')
                            ->find($act->table_id);

                        $empName = $assign->employee->user->name ?? null;
                    }
                @endphp
                
                @php
                $userName = \App\Models\User::find($act->user_id)?->name;
            @endphp

                <div class="timeline-item">

                    {{-- DOT --}}
                    <div class="timeline-dot"></div>

                    {{-- CONTENT --}}
                    <div class="timeline-content">

                        <div class="timeline-title">
                            {{ ucfirst($act->operation) }}
                        </div>
                        
                        @if($userName)
    <div class="timeline-user">
        <strong>By :</strong> {{ $userName }}
    </div>
@endif

                        <div class="timeline-desc">
                            @if($empName)
                                {{ str_replace('employee ID', $empName, $act->description) }}
                            @else
                                {{ $act->description }}
                            @endif
                        </div>

                        <div class="timeline-time">
                            <i class="fa fa-clock"></i>
                            {{ \Carbon\Carbon::parse($act->created_at)->format('d M Y h:i A') }}
                        </div>

                    </div>

                </div>

            @empty
                <div class="text-muted p-3">No activity found</div>
            @endforelse

        </div>

    </div>

</div>

    </div>

</div>

</div>

@else
<div class="alert alert-danger">No Permission</div>
@endif

@endsection