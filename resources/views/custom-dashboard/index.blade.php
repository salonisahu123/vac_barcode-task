@extends('layouts.master')

@section('title','Custom Dashboards')

@section('css')
<link rel="stylesheet" href="{{ asset('css/custom_dash.css') }}">
@endsection

@section('content')

@php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
@endphp

{{-- 🔐 DASHBOARD VIEW PERMISSION (ONLY 2) --}}
@if($isAdmin || hasPermission('dashboard_view_all') || hasPermission('dashboard_view_own'))

<x-breadcrumb title="Custom Dashboards Management" page="Custom dashboard" />

<div class="container-fluid">

    <div class="dashboard-list-card">

        {{-- HEADER --}}
        <div class="dashboard-header">

            <div class="dashboard-title">
                Custom Dashboards
            </div>

            {{-- CREATE BUTTON (only if allowed via view_all or admin) --}}
            @if($isAdmin || hasPermission('dashboard_view_all'))
            <a href="{{ route('custom-dashboards.create') }}" class="add-btn">
                <i class="fa fa-plus me-1"></i>
                Create Dashboard
            </a>
            @endif

        </div>

        {{-- TABLE --}}
        <div class="table-responsive">

            <table class="dashboard-table">

                <thead>

                    <tr>
                        <th>#</th>
                        <th>Dashboard Name</th>
                        <th>Created By</th>
                        <th>Created Date</th>
                        <th>Action</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($dashboards as $key => $dashboard)

                    <tr>

                        <td>{{ $key + 1 }}</td>

                        <td>
                            <div class="dashboard-name">
                                {{ $dashboard->dash_name }}
                            </div>
                        </td>

                        <td>
                            {{ $dashboard->user->name ?? '-' }}
                        </td>

                        <td>
                            {{ $dashboard->created_at->format('d M Y') }}
                        </td>

                        <td>

                            <div class="action-box">

                                {{-- VIEW --}}
                                @if($isAdmin || hasPermission('dashboard_view_all') || hasPermission('dashboard_view_own'))
                                <a href="{{ route('custom-dashboards.show', $dashboard->id) }}"
                                   class="icon-btn">
                                    <i class="fa fa-eye text-info"></i>
                                </a>

                                {{-- EDIT (only full access) --}}
                                <a href="{{ route('custom-dashboards.edit', $dashboard->id) }}"
                                   class="icon-btn">
                                    <i class="fa fa-edit edit-icon"></i>
                                </a>
                                
                                {{-- DELETE (only full access) --}}
                                <form action="{{ route('custom-dashboards.destroy', $dashboard->id) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="icon-btn"
                                            onclick="return confirm('Delete this dashboard?')">
                                        <i class="fa fa-trash delete-icon"></i>
                                    </button>

                                </form>
                                @endif

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="5">
                            <div class="empty-data">
                                No Custom Dashboard Found
                            </div>
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@else

<div class="alert alert-danger">
    You do not have permission to view dashboards.
</div>

@endif

@endsection