
{{-- TASK TABLE --}}
@if($showTaskTable && $canViewTaskTable)

<div class="dashboard-table-wrapper mb-4">

    <div class="table-title mb-3">
        <h4 class="fw-bold">Task Table</h4>
    </div>

    @include('dashboard.partials.task-table')

</div>

@endif


{{-- TICKET TABLE --}}
@if(
    data_get($config, 'ticket_module.table') == true
    && $canViewTicketTable
)

<div class="dashboard-table-wrapper mb-4">

    <div class="table-title mb-3">
        <h4 class="fw-bold">Ticket Table</h4>
    </div>

    @include('dashboard.partials.ticket-table')

</div>

@endif

{{-- EMPLOYEE TABLE --}}
@if(
    data_get($config, 'modules.Employee Module.table') == true
    && $canViewEmployeeTable
)

<div class="dashboard-table-wrapper mb-4">

    <div class="table-title mb-3">
        <h4 class="fw-bold">Employee Table</h4>
    </div>

    @include('dashboard.partials.employee-table')

</div>

@endif

{{-- LOCATION TABLE --}}
@if(
    data_get($config, 'modules.Location Module.table') == true
    && $canViewLocationTable
)

<div class="dashboard-table-wrapper mb-4">

    <div class="table-title mb-3">
        <h4 class="fw-bold">Location Table</h4>
    </div>

    @include('dashboard.partials.location-table')

</div>

@endif


{{-- DEPARTMENT TABLE --}}
@if(
    data_get($config, 'modules.Department Module.table') == true
    && $canViewDepartmentTable
)

<div class="dashboard-table-wrapper mb-4">

    <div class="table-title mb-3">
        <h4 class="fw-bold">Department Table</h4>
    </div>

    @include('dashboard.partials.department-table')

</div>

@endif


{{-- GROUP TABLE --}}
@if(
    data_get($config, 'modules.Group Module.table') == true
    && $canViewGroupTable
)

<div class="dashboard-table-wrapper mb-4">

    <div class="table-title mb-3">
        <h4 class="fw-bold">Group Table</h4>
    </div>

    @include('dashboard.partials.group-table')

</div>

@endif





