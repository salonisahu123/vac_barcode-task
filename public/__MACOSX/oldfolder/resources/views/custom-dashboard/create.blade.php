@extends('layouts.master')

@section('title','Create Custom Dashboard')

@section('css')
<link rel="stylesheet" href="{{ asset('css/custom_dash.css') }}">
@endsection

@section('content')

<div class="container-fluid">

    <div class="dashboard-card">

        <div class="dashboard-title">
            Create Custom Dashboard
        </div>

        <form method="POST" action="{{ route('custom-dashboards.store') }}">

            @csrf

            {{-- DASHBOARD NAME --}}
            <div class="mb-4">

                <label class="form-label fw-bold mb-2">
                    Dashboard Name
                </label>

                <input type="text"
                       name="dash_name"
                       class="form-control"
                       placeholder="Enter dashboard name"
                       value="{{ old('dash_name') }}">

                @error('dash_name')

                    <small class="text-danger">
                        {{ $message }}
                    </small>

                @enderror

            </div>

            @php

            $modules = [
                'Location Module',
                'Department Module',
                'Employee Module',
                'Group Module',
            ];

            @endphp

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
                                    <!--           id="task_chart"-->
                                    <!--           name="view_json[task_module][chart]"-->
                                    <!--           value="1">-->

                                    <!--    <label for="task_chart">-->
                                    <!--        Chart-->
                                    <!--    </label>-->

                                    <!--</div>-->
                                    
                                    {{-- REDIRECT DIV --}}
                                    <!--<div class="permission-item">-->
                        
                                    <!--    <input type="checkbox"-->
                                    <!--           id="task_redirect"-->
                                    <!--           name="view_json[task_module][redirect_div]"-->
                                    <!--           value="1">-->
                        
                                    <!--    <label for="task_redirect">-->
                                    <!--        Redirect Div-->
                                    <!--    </label>-->
                        
                                    <!--</div>-->

                                    {{-- SUBTASKS --}}
                                    @foreach($subtasks as $index => $subtask)

                                    <div class="permission-item">

                                        <input type="checkbox"
                                               id="subtask_{{ $index }}"
                                               name="view_json[task_module][subtasks][]"
                                               value="{{ $subtask->subtask }}">

                                        <label for="subtask_{{ $index }}">
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
                        <!--                       id="ticket_chart"-->
                        <!--                       name="view_json[ticket_module][chart]"-->
                        <!--                       value="1">-->

                        <!--                <label for="ticket_chart">-->
                        <!--                    Chart-->
                        <!--                </label>-->

                        <!--            </div>-->

                        <!--            <div class="permission-item">-->

                        <!--                <input type="checkbox"-->
                        <!--                       id="ticket_redirect"-->
                        <!--                       name="view_json[ticket_module][redirect_div]"-->
                        <!--                       value="1">-->

                        <!--                <label for="ticket_redirect">-->
                        <!--                    Redirect Div-->
                        <!--                </label>-->

                        <!--            </div>-->

                        <!--            <div class="permission-item">-->

                        <!--                <input type="checkbox"-->
                        <!--                       id="ticket_table"-->
                        <!--                       name="view_json[ticket_module][table]"-->
                        <!--                       value="1">-->

                        <!--                <label for="ticket_table">-->
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
                        <!--                       id="redirect_{{ $key }}"-->
                        <!--                       name="view_json[modules][{{ $key }}][redirect_div]"-->
                        <!--                       value="1">-->

                        <!--                <label for="redirect_{{ $key }}">-->
                        <!--                    Redirect Div-->
                        <!--                </label>-->

                        <!--            </div>-->

                        <!--            <div class="permission-item">-->

                        <!--                <input type="checkbox"-->
                        <!--                       id="table_{{ $key }}"-->
                        <!--                       name="view_json[modules][{{ $key }}][table]"-->
                        <!--                       value="1">-->

                        <!--                <label for="table_{{ $key }}">-->
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

            <button type="submit" class="save-btn">
                Save Dashboard
            </button>

        </form>

    </div>

</div>

@endsection