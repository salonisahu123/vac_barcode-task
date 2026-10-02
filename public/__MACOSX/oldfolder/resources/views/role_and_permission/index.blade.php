@extends('layouts.master')

@section('title','Role & Permission')

@section('css')
<link rel="stylesheet" href="{{ asset('css/role-permission.css') }}">
@endsection

@section('content')

@php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
@endphp

@if($isAdmin || hasPermission('role_permission_view_own') || hasPermission('role_permission_view_all') || hasPermission('role_permission_add') || hasPermission('role_permission_edit') || hasPermission('role_permission_delete'))

<x-breadcrumb title="Role Management" page="Role & Permissions" />

<div class="mt-2"></div>

<div class="row">
    <div class="col-md-12">

        <div class="white_shd full margin_bottom_30 p-3 shadow-sm">

            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-3">

                <div></div>

                @if($isAdmin || hasPermission('role_permission_add'))
                <a href="{{ route('roles_permissions.assign') }}"
                   class="btn btn-primary btn-sm d-flex align-items-center"
                   style="border-radius:6px;">
                    <i class="fa fa-plus me-1"></i> Assign Permission
                </a>
                @endif

            </div>

            <!-- TABLE -->
            <div class="table-responsive">

                <table class="table table-bordered align-middle">

                    <thead>
                        <tr style="font-size:13px; background:#f8f9fa;">
                            <th>#</th>
                            <th>Role</th>
                            <th width="150">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($roles as $key => $role)
                        <tr style="font-size:13px;">

                            <td>{{ $key+1 }}</td>

                            <td>
                                <span style="font-weight:500;">
                                    {{ $role->name }}
                                </span>
                            </td>

                            <td>
                                <div class="d-flex gap-1">

                                    {{-- VIEW --}}
                                    @if($isAdmin || hasPermission('role_permission_view_own') || hasPermission('role_permission_view_all'))
                                    <a href="{{ route('roles_permissions.show',$role->id) }}"
                                       class="btn btn-light btn-sm border"
                                       title="View">
                                        <i class="fa fa-eye text-info"></i>
                                    </a>
                                    @endif

                                    {{-- EDIT --}}
                                    @if($isAdmin || hasPermission('role_permission_edit'))
                                    <a href="{{ route('roles_permissions.edit',$role->id) }}"
                                       class="btn btn-light btn-sm border"
                                       title="Edit">
                                        <i class="fa fa-edit text-warning"></i>
                                    </a>
                                    @endif

                                    {{-- DELETE --}}
                                    @if($isAdmin || hasPermission('role_permission_delete'))
                                    <form action="{{ route('roles_permissions.destroy',$role->id) }}"
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
    You do not have permission to access this page.
</div>

@endif

@endsection