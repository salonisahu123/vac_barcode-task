
@php
$config = $config ?? [];
$isAdminUser = in_array($roleSlug, ['super-admin', 'admin']);
@endphp


<div class="row g-2">

    {{-- EMPLOYEES --}}
    @if(!$isEmployee && ($config['modules']['Employee Module']['redirect_div'] ?? false))
    <div class="col-xl-3 col-lg-3 col-md-6 col-12 mb-3">
        <a href="{{ route('employees.index') }}">
            <div class="dashboard-card small-card">
                <i class="fa fa-user icon yellow"></i>
                <div class="text">
                    <span class="count">{{ $userCount }}</span>
                    <span class="label">Total Employees</span>
                </div>
            </div>
        </a>
    </div>
    @endif


    {{-- ALL TASKS --}}
    @if(!$isEmployee && ($config['task_module']['redirect_div'] ?? false))
    <div class="col-xl-3 col-lg-3 col-md-6 col-12 mb-3">
        <a href="{{ route('tasks.index') }}">
            <div class="dashboard-card small-card">
                <i class="fa fa-tasks icon purple"></i>
                <div class="text">
                    <span class="count">{{ $globalTaskCount }}</span>
                    <span class="label">All Tasks</span>
                </div>
            </div>
        </a>
    </div>
    @endif


    {{-- ASSIGNED TASKS --}}
    @if($config['task_module']['redirect_div'] ?? false)
    <div class="col-xl-3 col-lg-3 col-md-6 col-12 mb-3">
        <div class="dashboard-card small-card">
            <i class="fa fa-user-check icon purple"></i>
            <div class="text">
                <span class="count">{{ $taskCount }}</span>
                <span class="label">{{ $isAdminUser ? 'My Assigned Tasks' : 'My Tasks' }}</span>
            </div>
        </div>
    </div>
    @endif
    
      {{-- TASK PENDING (CLEAR NAME FIX) --}}
    @if($config['task_module']['redirect_div'] ?? false)
    <div class="col-xl-3 col-lg-3 col-md-6 col-12 mb-3">
        <div class="dashboard-card small-card">
            <i class="fa fa-exclamation-circle icon red"></i>
            <div class="text">
                <span class="count">{{ $basicTaskPending }}</span>
                <span class="label">{{ $isAdminUser ? 'Pending Tasks' : 'My Pending Tasks' }}</span>
            </div>
        </div>
    </div>
    @endif


    {{-- ALL TICKETS --}}
    @if(!$isEmployee && ($config['ticket_module']['redirect_div'] ?? false))
    <div class="col-xl-3 col-lg-3 col-md-6 col-12 mb-3">
        <a href="{{ route('tickets.index') }}">
            <div class="dashboard-card small-card">
                <i class="fa fa-ticket icon orange"></i>
                <div class="text">
                    <span class="count">{{ $globalTicketCount }}</span>
                    <span class="label">All Tickets</span>
                </div>
            </div>
        </a>
    </div>
    @endif


    {{-- ASSIGNED TICKETS --}}
    @if($config['ticket_module']['redirect_div'] ?? false)
    <div class="col-xl-3 col-lg-3 col-md-6 col-12 mb-3">
        <div class="dashboard-card small-card">
            <i class="fa fa-ticket icon blue"></i>
            <div class="text">
                <span class="count">{{ $assignedTicketCount }}</span>
                <span class="label"> {{ $isAdminUser ? 'My Assigned Tickets' : 'My Tickets' }}</span>
            </div>
        </div>
    </div>
    @endif
    
    {{-- UNASSIGNED PENDING TICKETS --}}
    @if(!$isEmployee && ($config['ticket_module']['redirect_div'] ?? false))
    <div class="col-xl-3 col-lg-3 col-md-6 col-12 mb-3">
        <div class="dashboard-card small-card">
            <i class="fa fa-exclamation-circle icon red"></i>
    
            <div class="text">
                <span class="count">{{ $pendingUnassignedTickets }}</span>
    
                <span class="label">
                    Pending Unassigned Tickets
                </span>
            </div>
        </div>
    </div>
    @endif

    {{-- DASHBOARD LIST --}}
    @if($config['modules']['Employee Module']['redirect_div'] ?? false)
    <div class="col-xl-3 col-lg-3 col-md-6 col-12 mb-3">
        <a href="{{ route('custom-dashboards.index') }}">
            <div class="dashboard-card small-card">
                <i class="fa fa-chart-pie icon blue"></i>
                <div class="text">
                    <span class="count">{{ $customDashboardCount }}</span>
                    <span class="label">Available Dashboards</span>
                </div>
            </div>
        </a>
    </div>
    @endif

    {{-- LOCATION --}}
    @if($config['modules']['Location Module']['redirect_div'] ?? false)
    <div class="col-xl-3 col-lg-3 col-md-6 col-12 mb-3">
        <a href="{{ route('locations.index') }}">
            <div class="dashboard-card small-card">
                <i class="fa fa-map-marker icon yellow"></i>
                <div class="text">
                    <span class="count">{{ $locationCount }}</span>
                    <span class="label">Total Locations</span>
                </div>
            </div>
        </a>
    </div>
    @endif


    {{-- DEPARTMENT --}}
    @if($config['modules']['Department Module']['redirect_div'] ?? false)
    <div class="col-xl-3 col-lg-3 col-md-6 col-12 mb-3">
        <a href="{{ route('departments.index') }}">
            <div class="dashboard-card small-card">
                <i class="fa fa-building icon purple"></i>
                <div class="text">
                    <span class="count">{{ $departmentCount }}</span>
                    <span class="label">Total Departments</span>
                </div>
            </div>
        </a>
    </div>
    @endif
    
   {{-- GROUP --}}
    @if($config['modules']['Group Module']['redirect_div'] ?? false)
    <div class="col-xl-3 col-lg-3 col-md-6 col-12 mb-3">
        <a href="{{ route('groups.index') }}">
            <div class="dashboard-card small-card">
                <i class="fa fa-users icon green"></i>
                <div class="text">
                    <span class="count">{{ $groupCount ?? 0 }}</span>
                    <span class="label">Total Groups</span>
                </div>
            </div>
        </a>
    </div>
    @endif

</div>