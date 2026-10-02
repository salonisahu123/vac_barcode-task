@extends('layouts.master')

@section('title','View Custom Dashboard')

@section('css')
<link rel="stylesheet" href="{{ asset('css/custom_dash.css') }}">
@endsection

@section('content')

@php

$viewJson = json_decode($dashboard->view_json, true);

$modules = [
    'Location Module',
    'Department Module',
    'Employee Module',
    'Group Module',
];

@endphp

<div class="container-fluid">

    <div class="dashboard-card">

        <div class="dashboard-title">
            View Custom Dashboard
        </div>

        {{-- DASHBOARD NAME --}}
        <div class="mb-4">

            <label class="form-label fw-bold mb-2">
                Dashboard Name
            </label>

            <input type="text"
                   class="form-control"
                   value="{{ $dashboard->dash_name }}"
                   readonly>

        </div>

        <div class="table-responsive">

            <table class="dashboard-table">

                <thead>

                    <tr>
                        <th width="28%">
                            All Modules
                        </th>

                        <th width="72%">
                            Dashboard Components
                        </th>
                    </tr>

                </thead>

                <tbody>

                    {{-- TASK MODULE --}}
                    <tr>

                        <td>
                            <div class="module-name">
                                Task Module
                            </div>
                        </td>

                        <td>

                            <div class="permission-box">

                                {{-- CHART --}}
                                <!--<div class="permission-item">-->

                                <!--    <input type="checkbox"-->
                                <!--           disabled-->

                                <!--           {{ !empty($viewJson['task_module']['chart']) ? 'checked' : '' }}>-->

                                <!--    <label>-->
                                <!--        Chart-->
                                <!--    </label>-->

                                <!--</div>-->

                                {{-- REDIRECT DIV --}}
                                <!--<div class="permission-item">-->

                                <!--    <input type="checkbox"-->
                                <!--           disabled-->

                                <!--           {{ !empty($viewJson['task_module']['redirect_div']) ? 'checked' : '' }}>-->

                                <!--    <label>-->
                                <!--        Redirect Div-->
                                <!--    </label>-->

                                <!--</div>-->

                                {{-- SUBTASKS --}}
                                @foreach($subtasks as $subtask)

                                <div class="permission-item">

                                    <input type="checkbox"
                                           disabled

                                           {{ !empty($viewJson['task_module']['subtasks'][$subtask->subtask]) ? 'checked' : '' }}>

                                    <label>
                                        {{ $subtask->subtask }}
                                    </label>

                                </div>

                                @endforeach

                            </div>

                        </td>

                    </tr>


                    {{-- TICKET MODULE --}}
                    <!--<tr>-->

                    <!--    <td>-->

                    <!--        <div class="module-name">-->
                    <!--            Ticket Module-->
                    <!--        </div>-->

                    <!--    </td>-->

                    <!--    <td>-->

                    <!--        <div class="permission-box">-->

                    <!--            <div class="permission-item">-->

                    <!--                <input type="checkbox"-->
                    <!--                       disabled-->

                    <!--                       {{ !empty($viewJson['ticket_module']['chart']) ? 'checked' : '' }}>-->

                    <!--                <label>-->
                    <!--                    Chart-->
                    <!--                </label>-->

                    <!--            </div>-->

                    <!--            <div class="permission-item">-->

                    <!--                <input type="checkbox"-->
                    <!--                       disabled-->

                    <!--                       {{ !empty($viewJson['ticket_module']['redirect_div']) ? 'checked' : '' }}>-->

                    <!--                <label>-->
                    <!--                    Redirect Div-->
                    <!--                </label>-->

                    <!--            </div>-->

                    <!--            <div class="permission-item">-->

                    <!--                <input type="checkbox"-->
                    <!--                       disabled-->

                    <!--                       {{ !empty($viewJson['ticket_module']['table']) ? 'checked' : '' }}>-->

                    <!--                <label>-->
                    <!--                    Table-->
                    <!--                </label>-->

                    <!--            </div>-->

                    <!--        </div>-->

                    <!--    </td>-->

                    <!--</tr>-->


                    {{-- OTHER MODULES --}}
                    @foreach($modules as $key => $module)

                    <!--<tr>-->

                    <!--    <td>-->

                    <!--        <div class="module-name">-->
                    <!--            {{ $module }}-->
                    <!--        </div>-->

                    <!--    </td>-->

                    <!--    <td>-->

                    <!--        <div class="permission-box">-->

                    <!--            <div class="permission-item">-->

                    <!--                <input type="checkbox"-->
                    <!--                       disabled-->

                    <!--                       {{ !empty($viewJson['modules'][$module]['redirect_div']) ? 'checked' : '' }}>-->

                    <!--                <label>-->
                    <!--                    Redirect Div-->
                    <!--                </label>-->

                    <!--            </div>-->

                    <!--            <div class="permission-item">-->

                    <!--                <input type="checkbox"-->
                    <!--                       disabled-->

                    <!--                       {{ !empty($viewJson['modules'][$module]['table']) ? 'checked' : '' }}>-->

                    <!--                <label>-->
                    <!--                    Table-->
                    <!--                </label>-->

                    <!--            </div>-->

                    <!--        </div>-->

                    <!--    </td>-->

                    <!--</tr>-->

                    @endforeach

                </tbody>

            </table>

        </div>

        <a href="{{ route('custom-dashboards.index') }}"
           class="back-btn">

            Back

        </a>

    </div>

</div>

@endsection