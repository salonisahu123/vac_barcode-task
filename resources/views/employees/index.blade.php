@extends('layouts.master')

@section('title','Employees')

@section('content')

@php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
@endphp

{{-- 🔐 PERMISSION CHECK (VIEW ACCESS) --}}
@if($isAdmin || hasPermission('employee_view_all') || hasPermission('employee_view_own'))

<x-breadcrumb title="Employee Management" page="Employees" />

<div class="mt-2"></div>

<div class="row">
    <div class="col-md-12">

        <div class="white_shd full margin_bottom_30 p-3 shadow-sm">

            <!-- 🔥 HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-3">

                <div></div>

                {{-- ADD BUTTON PERMISSION --}}
                @if($isAdmin || hasPermission('employee_add'))
         <a href="{{ route('employees.create') }}"
   class="btn btn-primary btn-sm d-flex align-items-center"
   style="border-radius:6px; padding:9px 18px; font-size:14px;">
    <i class="fa fa-plus me-1" style="margin-right:8px; font-size:14px;"></i> Add Employee
</a>
                @endif

            </div>

            <!-- TABLE -->
            <div class="table-responsive">

                <table class="table datatable align-middle" data-table="employee">

                    <thead>
                        <tr style="font-size:13px; background:#f8f9fa;">
                            <th>#</th>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Location</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th width="150">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($employees as $key => $emp)
                        <tr style="font-size:13px;">

                            <td>{{ $key+1 }}</td>

                            <td>
                                @if($emp->image)
                                    <img src="{{ asset('uploads/employees/'.$emp->image) }}"
                                        style="width:40px; height:40px; border-radius:50%; object-fit:cover; border:1px solid #ddd;">
                                @else
                                    <img src="{{ asset('uploads/employees/user.png') }}"
                                        style="width:40px; height:40px; border-radius:50%; object-fit:cover; border:1px solid #ddd;">
                                @endif
                            </td>

                            <td>
                                <span style="font-weight:500;">
                                    {{ $emp->user->name }}
                                </span>
                            </td>

                            <td style="color:#6c757d;">
                                {{ $emp->user->email }}
                            </td>
                            
                            <td>
                                <span class="badge"
                                      style="background:#e7f1ff; color:#0d6efd; font-weight:500;">
                                    {{ $emp->role->name ?? 'N/A' }}
                                </span>
                            </td>

                            <td>
                                <span class="badge"
                                      style="background:#e7f1ff; color:#0d6efd; font-weight:500;">
                                    {{ $emp->location->name }}
                                </span>
                            </td>

                            <td>
                                <span class="badge"
                                      style="background:#eef2ff; color:#4338ca; font-weight:500;">
                                    {{ $emp->department->dept_name }}
                                </span>
                            </td>

                            <td>
                                @if($isAdmin || hasPermission('employee_edit'))
                                    <form action="{{ route('employees.updateStatus') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="employee_id" value="{{ $emp->id }}">
                                        <select name="is_active" class="form-select form-select-sm" onchange="this.form.submit()" style="width:100px; font-size:12px; @if($emp->user->is_active) background-color:#d1e7dd; color:#0f5132; @else background-color:#f8d7da; color:#842029; @endif border:none; cursor:pointer; padding: 4px 8px; border-radius: 4px; font-weight: 500; appearance: none; -moz-appearance: none; -webkit-appearance: none; text-align: center;">
                                            <option value="1" {{ $emp->user->is_active ? 'selected' : '' }} style="background-color: white; color: black; text-align: left;">Active</option>
                                            <option value="0" {{ !$emp->user->is_active ? 'selected' : '' }} style="background-color: white; color: black; text-align: left;">Inactive</option>
                                        </select>
                                    </form>
                                @else
                                    @if($emp->user->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                @endif
                            </td>

                            <td>
                                <div class="d-flex gap-1">

                                    {{-- VIEW --}}
                                    @if($isAdmin || hasPermission('employee_view_all') || hasPermission('employee_view_own'))
                                    <a href="{{ route('employees.show',$emp->id) }}"
                                       class="btn btn-light btn-sm border"
                                       title="View">
                                       <i class="fa fa-eye text-info"></i>
                                    </a>
                                    @endif

                                    {{-- EDIT --}}
                                    @if($isAdmin || hasPermission('employee_edit'))
                                    <a href="{{ route('employees.edit',$emp->id) }}"
                                       class="btn btn-light btn-sm border"
                                       title="Edit">
                                       <i class="fa fa-edit text-warning"></i>
                                    </a>
                                    @endif

                                    {{-- DELETE --}}
                                    @if($isAdmin || hasPermission('employee_delete'))
                                    <form action="{{ route('employees.destroy',$emp->id) }}"
                                          method="POST"
                                          class="delete-form">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button"
                                                class="btn btn-light btn-sm border delete-btn"
                                                title="Delete">
                                            <i class="fa fa-trash text-danger"></i>
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
</div>

@else

<div class="alert alert-danger">
    You do not have permission to view employees list.
</div>

@endif

@endsection