@extends('layouts.master')

@section('title','Tasks')

@section('css')
<!-- ADD -->
<link rel="stylesheet" href="{{ asset('css/task.css') }}">
@endsection

@section('content')

<x-breadcrumb title="Task Management" page="Task List" />

@php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
@endphp


@if($isAdmin || hasPermission('task_view_all') || hasPermission('task_view_own'))


<div class="mt-2"></div>

<div class="row">
    <div class="col-md-12">

        <div class="white_shd full margin_bottom_30 p-3 shadow-sm">

            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-3">

                <div></div>
                
                {{-- ADD TASK PERMISSION --}}
                @if($isAdmin || hasPermission('task_add'))
                <a href="{{ route('tasks.create') }}"
                   class="btn btn-primary btn-sm d-flex align-items-center"
                   style="border-radius:6px;">
                    <i class="fa fa-plus me-1"></i> Create Task
                </a>
                @endif

            </div>
            
            <!--{ ================== FILTER START=============================}-->
<div class="card p-3 mb-3">

    <div class="row align-items-end">

        <div class="col-md-2">
            <label>Location</label>
            <select id="filter_location" class="form-control">
                <option value="">All</option>
                @foreach($locations as $loc)
                    <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label>Group</label>
            <select id="filter_group" class="form-control">
                <option value="">All</option>
                @foreach($groups as $grp)
                    <option value="{{ $grp->id }}">{{ $grp->group_name }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="col-md-3">
            <label>Employee</label>
            <select id="filter_user" class="form-control">
                <option value="">All</option>
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}">{{ $emp->user->name ?? 'Unknown' }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label>Status</label>
        
            <select id="filter_status" class="form-control">
                <option value="">Pending & In Progress</option>
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>
        </div>

        <div class="col-md-2">
            <button id="btn_refresh_filter" class="btn btn-primary w-100" style="border-radius:6px; padding: 7px 12px;">
                <i class="fa fa-filter"></i> Refresh Filter
            </button>
        </div>

    </div>

</div>
<!--{ ================== FILTER END=============================}-->

            <!-- TABLE -->
            <div class="table-responsive">

                <table class="table datatable align-middle" data-table="task">

                    <thead>
                        <tr style="font-size:13px; background:#f8f9fa;">
                            <th>#</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Sub Task</th>
                            <th>Location</th>
                            <th>Group</th>
                            <th>from</th>
                            <th>To date</th>
                            <th>Assigned</th>
                            <th>Created By</th>
                            <th width="160">Action</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody id="taskTableBody">

                       @forelse($tasks as $key => $task)
             <tr style="font-size:13px;">
            
                <td>{{ $key+1 }}</td>
            
                <td><span style="font-weight:500;">{{ $task->title }}</span></td>
            
             <td>
            <span class="badge"
                  style="background:#eef2ff; color:#4338ca; font-weight:500;">
                {{ ucfirst($task->task_type) }}
            </span>
        </td>
        
        <td>
            @if($isAdmin || hasPermission('task_edit'))
                <select class="form-select form-select-sm changeSubtask shadow-sm" data-id="{{ $task->id }}" style="min-width: 130px; background-color: #f8f9fa; color: #495057; font-weight: 500; border: 1px solid #ced4da; border-radius: 6px; cursor: pointer;">
                    <option value="" style="color: #6c757d;">- Select Subtask -</option>
                    @foreach($subtasks as $id => $name)
                        <option value="{{ $id }}" {{ $task->subtask_id == $id ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            @else
                <span class="badge" style="background:#ecfdf3; color:#027a48; font-weight:500;">
                    {{ $subtasks[$task->subtask_id] ?? '-' }}
                </span>
            @endif
        </td>

    <td>{{ $task->location->name ?? '-' }}</td>

    <td>{{ $task->group->group_name ?? '-' }}</td>

    <td style="color:#6c757d;">{{ $task->from_date }}</td>

    <td style="color:#6c757d;">{{ $task->to_date }}</td>

    <!-- Assigned -->
    <!-- <td>
        <div class="d-flex align-items-center">
            @php $count = $task->taskUsers->count(); @endphp

            @foreach($task->taskUsers->take(3) as $assign)
               <img src="{{ !empty($assign->employee->image) 
                ? asset('uploads/employees/'.$assign->employee->image) 
                : asset('uploads/employees/user.png') }}"
             title="{{ $assign->employee->user->name }}"
             style="width:32px;height:32px;border-radius:50%;object-fit:cover;border:2px solid #fff;margin-left:-8px;">
            @endforeach

            @if($count > 3)
                <div style="width:32px;height:32px;border-radius:50%;background:#0d6efd;color:#fff;font-size:11px;display:flex;align-items:center;justify-content:center;margin-left:-8px;border:2px solid #fff;">
                    +{{ $count - 3 }}
                </div>
            @endif
        </div>
    </td> -->
    <!-- Assigned -->
<td>
    @php
        $assignedNames = $task->taskUsers
            ->map(function ($assign) {
                return $assign->employee->user->name ?? null;
            })
            ->filter()
            ->implode(', ');

        $count = $task->taskUsers->count();
    @endphp

    <div class="d-flex align-items-center">
        @foreach($task->taskUsers->take(3) as $assign)
            <img src="{{ !empty($assign->employee->image) 
                ? asset('uploads/employees/'.$assign->employee->image) 
                : asset('uploads/employees/user.png') }}"
                title="{{ $assign->employee->user->name ?? 'Unknown' }}"
                style="width:32px;height:32px;border-radius:50%;object-fit:cover;border:2px solid #fff;margin-left:-8px;">
        @endforeach

        @if($count > 3)
            <div style="width:32px;height:32px;border-radius:50%;background:#0d6efd;color:#fff;font-size:11px;display:flex;align-items:center;justify-content:center;margin-left:-8px;border:2px solid #fff;">
                +{{ $count - 3 }}
            </div>
        @endif
    </div>

    {{-- Excel export text --}}
    <span style="display:none;" class="export-data">
        {{ $assignedNames ?: '-' }}
    </span>
</td>

    <td>{{ $task->createdBy->name ?? '-' }}</td>

    <!-- ACTION -->
    <td>
        <div class="d-flex gap-1">
            @if($isAdmin || hasPermission('task_view_all') || hasPermission('task_view_own'))
            <a href="{{ route('tasks.show',$task->id) }}" class="btn btn-light btn-sm border">
                <i class="fa fa-eye text-info"></i>
            </a>
            @endif

            <!-- @if($isAdmin || hasPermission('task_edit'))
            <a href="{{ route('tasks.edit',$task->id) }}" class="btn btn-light btn-sm border">
                <i class="fa fa-edit text-warning"></i>
            </a>
            @endif -->
            @if(
                $isAdmin
                || hasPermission('task_edit')
                || (
                    hasPermission('task_view_own')
                    && (
                        $task->taskUsers->contains('assigned_to', $employeeId)
                        || $task->user_id == auth()->id()
                    )
                )
            )
                <a href="{{ route('tasks.edit', $task->id) }}"
                class="btn btn-light btn-sm border">
                    <i class="fa fa-edit text-warning"></i>
                </a>
            @endif

            @if(hasPermission('task_delete'))
            <form action="{{ route('tasks.destroy',$task->id) }}" method="POST" class="delete-form">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-light btn-sm border delete-btn">
                    <i class="fa fa-trash text-danger"></i>
                </button>
            </form>
            @endif
            
            <button type="button"
        class="btn btn-outline-primary btn-sm remarkBtn"
        data-id="{{ $task->id }}"
        data-title="{{ $task->title }}">
    Remark
</button>
        </div>
    </td>

    <!-- STATUS -->
    <td style="min-width:160px;">
        @if($isAdmin || hasPermission('task_change_status'))

        <select class="form-select form-select-sm changeStatus"
                data-id="{{ $task->id }}">

            <option value="pending" {{ $task->status=='pending' ? 'selected' : '' }}>Pending</option>
            <option value="in_progress" {{ $task->status=='in_progress' ? 'selected' : '' }}>In Progress</option>
            <option value="completed" {{ $task->status=='completed' ? 'selected' : '' }}>Completed</option>

        </select>

        @else

            @if($task->status == 'pending')
                <span class="task-status-badge task-status-pending">Pending</span>

            @elseif($task->status == 'in_progress')
                <span class="task-status-badge task-status-progress">In Progress</span>

            @else
                <span class="task-status-badge task-status-completed">Completed</span>
            @endif

        @endif
    </td>

</tr>

@empty

@endforelse
                    </tbody>

                </table>

            </div>

        </div>

    </div>
</div>

@else

<div class="alert alert-danger">
    You do not have permission to view tasks list.
</div>

@endif

<!--//////////////////////// Remark model ////////////////////////////-->
<div class="modal fade" id="remarkModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Remark</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="remark_task_id">

                <label>Remark</label>
                <textarea id="remark_text" class="form-control" rows="4"></textarea>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="submitRemark">Submit</button>
            </div>

        </div>
    </div>
</div>

@endsection

@section('script')

<script>

// FILTER
function loadTasks(){
    $.ajax({
        url: "{{ route('tasks.filter') }}",
        type: "GET",
       data: {
                location_id: $('#filter_location').val(),
                group_id: $('#filter_group').val(),
                status: $('#filter_status').val(),
                employee_id: $('#filter_user').val()
             },
        success:function(res){
            if ($.fn.DataTable.isDataTable('.datatable')) {
                $('.datatable').DataTable().clear().destroy();
            }
            $('#taskTableBody').html(res.html);
            if (typeof window.initDataTables === 'function') {
                window.initDataTables();
            }
        }
    });
}

$('#btn_refresh_filter').on('click', function () {
    loadTasks();
});

// STATUS CHANGE
$(document).on('change', '.changeStatus', function () {

    let id = $(this).data('id');
    let status = $(this).val();

    $.ajax({
        url: '/tasks/' + id + '/status',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            status: status
        },

      success: function (res) {

if (res && res.status === true) {

    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: res.message,
        confirmButtonText: 'OK',
        allowOutsideClick: true,
        allowEscapeKey: true
    });

    loadTasks();
} else {

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: res.message || 'Something went wrong'
        });

    }
},

error: function (xhr) {

    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: xhr.responseJSON?.message || 'Server error'
    });

}
    });

});

// SUBTASK CHANGE
$(document).on('change', '.changeSubtask', function () {
    let id = $(this).data('id');
    let subtaskId = $(this).val();

    $.ajax({
        url: '/tasks/' + id + '/subtask',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            subtask_id: subtaskId
        },
        success: function (res) {
            if (res && res.status === true) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: res.message,
                    confirmButtonText: 'OK'
                });
                loadTasks();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: res.message || 'Something went wrong'
                });
            }
        },
        error: function (xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: xhr.responseJSON?.message || 'Server error'
            });
        }
    });
});

///////////////////////////////// Remark //////////////////////////////
$(document).on('click', '.remarkBtn', function () {
    $('#remark_task_id').val($(this).data('id'));
    $('#remark_text').val('');
    $('#remarkModal').modal('show');
});

$('#submitRemark').on('click', function () {
    let id = $('#remark_task_id').val();
    let remark = $('#remark_text').val();

    if (remark.trim() === '') {
        Swal.fire('Error', 'Please enter remark', 'error');
        return;
    }

    $.ajax({
        url: '/tasks/' + id + '/remark',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            remark: remark
        },
        success: function (res) {
            if (res.status === true) {
                $('#remarkModal').modal('hide');
                Swal.fire('Success', res.message, 'success');
            } else {
                Swal.fire('Error', res.message || 'Something went wrong', 'error');
            }
        },
        error: function (xhr) {
            Swal.fire('Error', xhr.responseJSON?.message || 'Server error', 'error');
        }
    });
});

</script>

@endsection

