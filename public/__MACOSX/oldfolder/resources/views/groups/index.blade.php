@extends('layouts.master')

@section('title','Groups')

@section('content')

@php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
@endphp

@section('css')
<link rel="stylesheet" href="{{ asset('css/group.css') }}">
@endsection

@if($isAdmin || hasPermission('group_view_all') || hasPermission('group_view_own'))

<x-breadcrumb title="Group Management" page="Group" />

<div class="pro-card">

<!-- ===== TOP BAR ===== -->
<div class="top-bar">

<div></div>

@if($isAdmin || hasPermission('group_add'))
<a href="{{ route('groups.create') }}" class="create-btn">
    <i class="fa fa-plus"></i>
    Create Group
</a>
@endif

</div>

<!-- ===== TABLE ===== -->
<div class="table-responsive">

<table class="table datatable align-middle" data-table="group">

<thead>
<tr>
    <th>#</th>
    <th>Group Name</th>
    <th>Location</th>
    <th>Department</th>
    <th>Employees</th>
    <th>Created By</th>
    <th>Action</th>
</tr>
</thead>

<tbody>

@foreach($groups as $key => $group)
<tr>

<td>{{ $key+1 }}</td>

<td>
    <strong>{{ $group->group_name }}</strong>
</td>

<td>
    {{ $group->location->name ?? 'N/A' }}
</td>

<td>
    {{ $group->department->dept_name ?? 'N/A' }}
</td>

<td>

@php
$emps  = $group->employees;
$count = $emps->count();
@endphp

<div class="d-flex align-items-center">

@if($count > 0)

    @foreach($emps->take(3) as $emp)

        @php
            $img = (!empty($emp->image))
                ? asset('uploads/employees/'.$emp->image)
                : asset('uploads/employees/user.png');
        @endphp

        <img src="{{ $img }}"
             title="{{ $emp->user->name }}"
             class="rounded-circle border shadow-sm me-n2"
             width="38"
             height="38"
             style="object-fit:cover; cursor:pointer;">

    @endforeach

    @if($count > 3)

    <button type="button"
            class="btn btn-primary rounded-circle ms-2 d-flex align-items-center justify-content-center"
            style="width:38px; height:38px; padding:0;"
            onclick="loadGroupEmployees({{ $group->id }})">

        +{{ $count - 3 }}

    </button>

    @endif

@else

<span class="badge bg-light text-dark px-3 py-2">
    No Employee
</span>

@endif

</div>

</td>

<td>
    <span style="color:#6b7280;">
        {{ $group->user->name ?? 'N/A' }}
    </span>
</td>

<td>
<div class="action-group">

@if($isAdmin || hasPermission('group_view_all') || hasPermission('group_view_own'))
<a href="{{ route('groups.show',$group->id) }}"
   class="icon-btn view-btn">
   <i class="fa fa-eye"></i>
</a>
@endif

@if($isAdmin || hasPermission('group_edit'))
<a href="{{ route('groups.edit',$group->id) }}"
   class="icon-btn edit-btn">
   <i class="fa fa-pen"></i>
</a>
@endif

@if($isAdmin || hasPermission('group_delete'))
<form action="{{ route('groups.destroy',$group->id) }}"
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

<!-- ===== EMPLOYEE MODAL ===== -->
<div class="modal fade" id="employeeModal" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <h5>Group Employees</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="employeeModalBody">
                <p class="text-muted">Loading...</p>
            </div>

        </div>
    </div>
</div>

@else

<div class="alert alert-danger">
    You do not have permission to view groups.
</div>

@endif

@endsection


@section('script')
<script src="{{ asset('js/group.js') }}"></script>
@endsection