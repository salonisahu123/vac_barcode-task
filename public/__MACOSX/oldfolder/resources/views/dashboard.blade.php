@extends('layouts.master')

@section('title','Dashboard')

@section('css')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
</style>

<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection


@section('content')

@php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
@endphp
    
{{-- Cards --}}
@php
    $isEmployee = Auth::user()->user_type == 'employee';
@endphp
<div class="dashboard-page">

    {{-- Greeting + Dropdown --}}
<div class="dashboard-top">
    <div class="dashboard-top-inner">

        {{-- LEFT --}}
        <div class="left-side">
            <div class="greeting-box">
                <h6>Welcome Back</h6>
                <h4>{{ Auth::user()->name }}</h4>
            </div>
        </div>

        {{-- RIGHT --}}
        <div class="right-side">

            @if(!$isEmployee)

            {{-- Pending Task Button --}}
           {{-- Pending Tasks Icon --}}
        <div class="pending-task-icon" style="position: relative; display: inline-block;">
        
            <a href="{{ route('tasks.pending') }}" style="text-decoration: none; color: inherit;">
        
               <i class="fa fa-bars" style="font-size:18px;"></i>
        
                {{-- Badge --}}
                <span class="task-badge"
                      style="
                        position: absolute;
                        top: -6px;
                        right: -5px;
                        background: red;
                        color: #fff;
                        font-size: 10px;
                        width: 18px;
                        height: 18px;
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                      ">
                    {{ $pendingTaskCount ?? 0 }}
                </span>
        
            </a>
        
        </div>

        <form method="GET" action="{{ route('dashboard') }}" 
              class="d-flex align-items-center flex-wrap" 
              style="gap:10px;" id="filterForm">

            {{-- Main Dropdown --}}
            <select name="filter_type" id="filterType" class="filter-select">

                <option value="location"
                    {{ request('filter_type','location') == 'location' ? 'selected' : '' }}>
                    Location
                </option>

                <option value="department"
                    {{ request('filter_type') == 'department' ? 'selected' : '' }}>
                    Department
                </option>

            </select>

            {{-- Location Dropdown --}}
            <div id="locationBox">
           <select name="location_id" class="filter-select"
        onchange="document.getElementById('filterForm').submit()">

        <option value="" {{ empty($locationId) ? 'selected' : '' }}>
            Select Location
        </option>
        
        <option value="all" {{ $locationId === 'all' ? 'selected' : '' }}>
            All Location
        </option>
            @foreach($locations as $location)
                <option value="{{ $location->id }}"
                    {{ request('location_id') == $location->id ? 'selected' : '' }}>
                    {{ $location->name }}
                </option>
            @endforeach
        
        </select>
            </div>

            {{-- Department Dropdown --}}
            <div id="departmentBox">
            <select name="department_id" class="filter-select"
        onchange="document.getElementById('filterForm').submit()">

      <option value="" {{ $departmentId == '' ? 'selected' : '' }}>
        Select Department
    </option>
    
    <option value="all" {{ $departmentId == 'all' ? 'selected' : '' }}>
        All Department
    </option>
    
        @foreach($departments as $department)
            <option value="{{ $department->id }}"
                {{ request('department_id') == $department->id ? 'selected' : '' }}>
                {{ $department->dept_name }}
            </option>
        @endforeach
    
    </select>
            </div>

        </form>

            @endif

        </div>

    </div>
</div>



<div class="row">

    {{-- ================= EMPLOYEES ================= --}}
    @if(!$isEmployee)
    <div class="col-lg-3 col-md-6">
        <a href="{{ route('employees.index') }}" class="card-link">
            <div class="dashboard-card small-card">

                <span class="card-badge yellow-badge">
                    {{ ucfirst($filterType) }} Wise
                </span>

                <div class="card-body-flex">
                    <div class="card-icon yellow">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="card-content">
                        <p class="total">{{ $userCount }}</p>
                        <p class="label">Employees</p>
                    </div>
                </div>

            </div>
        </a>
    </div>
    @endif


    {{-- ================= TOTAL TASKS ================= --}}
    @if(!$isEmployee)
    <div class="col-lg-3 col-md-6">
        <a href="{{ route('tasks.index') }}" class="card-link">
            <div class="dashboard-card small-card">

                <span class="card-badge purple-badge">System</span>

                <div class="card-body-flex">
                    <div class="card-icon purple">
                        <i class="fa fa-tasks"></i>
                    </div>
                    <div class="card-content">
                        <p class="total">{{ $globalTaskCount }}</p>
                        <p class="label">All Tasks</p>
                    </div>
                </div>

            </div>
        </a>
    </div>
    @endif


    {{-- ================= ASSIGNED TASKS ================= --}}
    <div class="col-lg-3 col-md-6">
        <div class="dashboard-card small-card">

            <span class="card-badge purple-badge">
                {{ ucfirst($filterType) }} Wise
            </span>

            <div class="card-body-flex">
                <div class="card-icon purple">
                    <i class="fa fa-user-check"></i>
                </div>
                <div class="card-content">
                    <p class="total">{{ $taskCount }}</p>
                    <p class="label">Assigned Tasks</p>
                </div>
            </div>

        </div>
    </div>


    {{-- ================= TOTAL TICKETS ================= --}}
    @if(!$isEmployee)
    <div class="col-lg-3 col-md-6">
        <a href="{{ route('tickets.index') }}" class="card-link">
            <div class="dashboard-card small-card">

                <span class="card-badge orange-badge">System</span>

                <div class="card-body-flex">
                    <div class="card-icon orange">
                        <i class="fa fa-ticket"></i>
                    </div>
                    <div class="card-content">
                        <p class="total">{{ $globalTicketCount }}</p>
                        <p class="label">All Tickets</p>
                    </div>
                </div>

            </div>
        </a>
    </div>
    @endif


    {{-- ================= ASSIGNED TICKETS ================= --}}
    <div class="col-lg-3 col-md-6">
        <div class="dashboard-card small-card">

            <span class="card-badge orange-badge">
                {{ ucfirst($filterType) }} Wise
            </span>

            <div class="card-body-flex">
                <div class="card-icon orange">
                    <i class="fa fa-user-tag"></i>
                </div>
                <div class="card-content">
                    <p class="total">{{ $ticketCount }}</p>
                    <p class="label">Assigned Tickets</p>
                </div>
            </div>

        </div>
    </div>

    {{-- ================= BASIC PENDING ================= --}}
    
    @if(!$isEmployee)
    <div class="col-lg-3 col-md-6">
        <div class="dashboard-card small-card">
    
            <span class="card-badge orange-badge">
                {{ ucfirst($filterType) }} Wise
            </span>
    
            <div class="card-body-flex">
                <div class="card-icon orange">
                    <i class="fa fa-tasks"></i>
                </div>
                <div class="card-content">
                    <p class="total">{{ $basicTaskPending }}</p>
                    <p class="label">Pending task</p>
                </div>
            </div>
    
        </div>
    </div>
    
    
    {{-- ================= PENDING TICKETS ================= --}}
<div class="col-lg-3 col-md-6">
    <div class="dashboard-card small-card">

        <span class="card-badge orange-badge">
            System
        </span>

        <div class="card-body-flex">
            <div class="card-icon orange">
                <i class="fa fa-ticket"></i>
            </div>
            <div class="card-content">
                <p class="total">{{ $pendingTicketCount }}</p>
                <p class="label">Pending Tickets</p>
            </div>
        </div>

    </div>
</div>

{{-- ================= LOCATIONS ================= --}}
<div class="col-lg-3 col-md-6">
    <div class="dashboard-card small-card">

        <span class="card-badge yellow-badge">
            System
        </span>

        <div class="card-body-flex">
            <div class="card-icon yellow">
                <i class="fa fa-map-marker"></i>
            </div>
            <div class="card-content">
                <p class="total">{{ $locationCount }}</p>
                <p class="label">Locations</p>
            </div>
        </div>

    </div>
</div>

{{-- ================= DEPARTMENTS ================= --}}
<div class="col-lg-3 col-md-6">
    <div class="dashboard-card small-card">

        <span class="card-badge purple-badge">
            System
        </span>

        <div class="card-body-flex">
            <div class="card-icon purple">
                <i class="fa fa-building"></i>
            </div>
            <div class="card-content">
                <p class="total">{{ $departmentCount }}</p>
                <p class="label">Departments</p>
            </div>
        </div>

    </div>
</div>

{{-- ================= ROLES ================= --}}
<div class="col-lg-3 col-md-6">
    <div class="dashboard-card small-card">

        <span class="card-badge orange-badge">
            System
        </span>

        <div class="card-body-flex">
            <div class="card-icon orange">
                <i class="fa fa-user-shield"></i>
            </div>
            <div class="card-content">
                <p class="total">{{ $roleCount }}</p>
                <p class="label">Roles</p>
            </div>
        </div>

    </div>
</div>

{{-- ================= GROUPS ================= --}}
<div class="col-lg-3 col-md-6">
    <div class="dashboard-card small-card">

        <span class="card-badge purple-badge">
            System
        </span>

        <div class="card-body-flex">
            <div class="card-icon purple">
                <i class="fa fa-users"></i>
            </div>
            <div class="card-content">
                <p class="total">{{ $groupCount }}</p>
                <p class="label">Groups</p>
            </div>
        </div>

    </div>
</div>

@endif
 </div>
    
   {{-- ================= Graph Section Start================= --}}
   
     <div class="row mt-2">

    {{-- LEFT : TASK GRAPH --}}
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card graph-card">

            {{-- Top Row --}}
            <div class="graph-head-line">
                <div class="graph-title">
                    <i class="fa fa-tasks text-primary mr-2"></i>
                    Task Analytics
                </div>

                <div class="graph-right-filter">
                   <select class="graph-select task-filter" name="task_filter">
                    <option value="day" {{ request('task_filter')=='day'?'selected':'' }}>Day Wise</option>
                    <option value="month" {{ request('task_filter','month')=='month'?'selected':'' }}>Month Wise</option>
                    <option value="year" {{ request('task_filter')=='year'?'selected':'' }}>Year Wise</option>
                </select>
                
                <select class="graph-select task-user" name="task_user_id">
                    <option value="">All Users</option>
                    @foreach($users as $u)
                        <option value="{{ $u->id }}" {{ request('task_user_id')==$u->id?'selected':'' }}>
                            {{ $u->name }}
                        </option>
                    @endforeach
                </select>
                </div>
            </div>

            {{-- Graph --}}
            <div class="chart-box">
                <canvas id="taskChart"></canvas>
            </div>

        </div>
    </div>



    {{-- RIGHT : TICKET GRAPH --}}
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card graph-card">

            {{-- Top Row --}}
            <div class="graph-head-line">
                <div class="graph-title">
                    <i class="fa fa-ticket text-warning mr-2"></i>
                    Ticket Analytics
                </div>

                <div class="graph-right-filter">
                <select class="graph-select ticket-filter" name="ticket_filter">
                <option value="day" {{ request('ticket_filter')=='day'?'selected':'' }}>Day Wise</option>
                <option value="month" {{ request('ticket_filter','month')=='month'?'selected':'' }}>Month Wise</option>
                <option value="year" {{ request('ticket_filter')=='year'?'selected':'' }}>Year Wise</option>
            </select>
            
            <select class="graph-select ticket-user" name="ticket_user_id">
                <option value="">All Users</option>
                @foreach($users as $u)
                    <option value="{{ $u->id }}" {{ request('ticket_user_id')==$u->id?'selected':'' }}>
                        {{ $u->name }}
                    </option>
                @endforeach
            </select>
                </div>
            </div>

            {{-- Graph --}}
            <div class="chart-box">
                <canvas id="ticketChart"></canvas>
            </div>
            

        </div>
    </div>

</div>

</div>

@endsection






@section('js')
<script>
window.dashboardEmployees = @json($users);
</script>
<script>

const ticketCtx = document.getElementById('ticketChart').getContext('2d');
const taskCtx = document.getElementById('taskChart').getContext('2d');

const commonOptions = {
    responsive: true,
    maintainAspectRatio: false,
    cutout: '60%',
    plugins: {
        legend: {
            position: 'bottom',
            labels: {
                usePointStyle: true,
                padding: 12,
                boxWidth: 10,
                font: {
                    size: 12
                }
            }
        }
    }
};

/* ================= TASK CHART ================= */

const taskData = [
    {{ $taskStatus->pending ?? 0 }},
    {{ $taskStatus->in_progress ?? 0 }},
    {{ $taskStatus->completed ?? 0 }}
];

const totalTaskSum = taskData.reduce((a,b)=>a+b,0);

if(totalTaskSum === 0){

    document.getElementById('taskChart').parentElement.innerHTML =
        "<h6 class='text-center mt-5 text-muted'>No Task Data Available</h6>";

} else {

    new Chart(taskCtx, {
        type: 'doughnut',   // 👈 SAME TYPE
        data: {
            labels: ['Pending', 'In Progress', 'Completed'],
            datasets: [{
                data: taskData,
                backgroundColor: ['#ef4444','#f59e0b','#22c55e'],
                borderColor: '#ffffff',
                borderWidth: 2
            }]
        },
        options: commonOptions
    });

}

/* ================= TICKET CHART ================= */

const ticketData = [
    {{ $ticketStatus->pending ?? 0 }},
    {{ $ticketStatus->in_progress ?? 0 }},
    {{ $ticketStatus->hold ?? 0 }},
    {{ $ticketStatus->close_request ?? 0 }},
    {{ $ticketStatus->closed ?? 0 }},
    {{ $ticketStatus->reopen ?? 0 }},
    {{ $ticketStatus->assigned ?? 0 }}
];

const totalTicketSum = ticketData.reduce((a,b)=>a+b,0);

if(totalTicketSum === 0){

    document.getElementById('ticketChart').parentElement.innerHTML =
        "<h6 class='text-center mt-5 text-muted'>No Ticket Data Available</h6>";

} else {

    new Chart(ticketCtx, {
        type: 'doughnut',   // 👈 SAME TYPE
        data: {
            labels: [
                'Pending','In Progress','Hold',
                'Close Request','Closed','Reopen','Assigned'
            ],
            datasets: [{
                data: ticketData,
                backgroundColor: [
                    '#ef4444','#f59e0b','#3b82f6',
                    '#a855f7','#22c55e','#14b8a6','#64748b'
                ],
                borderColor: '#ffffff',
                borderWidth: 2
            }]
        },
        options: commonOptions
    });

}

</script>

<script>
    
document.addEventListener("DOMContentLoaded", function(){

    const filterType = document.getElementById("filterType");
    const locationBox = document.getElementById("locationBox");
    const departmentBox = document.getElementById("departmentBox");

    function toggleDropdown(){
        if(filterType.value === "location"){
            locationBox.style.display = "block";
            departmentBox.style.display = "none";
        }else{
            locationBox.style.display = "none";
            departmentBox.style.display = "block";
        }
    }

    toggleDropdown();

    filterType.addEventListener("change", toggleDropdown);

});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    // TASK FILTER CHANGE
    document.querySelector(".task-filter").addEventListener("change", function () {
        submitGraphFilters();
    });

    document.querySelector(".task-user").addEventListener("change", function () {
        submitGraphFilters();
    });

    // TICKET FILTER CHANGE
    document.querySelector(".ticket-filter").addEventListener("change", function () {
        submitGraphFilters();
    });

    document.querySelector(".ticket-user").addEventListener("change", function () {
        submitGraphFilters();
    });

    function submitGraphFilters() {

        let url = new URL(window.location.href);

        // TASK
        let task_filter = document.querySelector(".task-filter").value;
        let task_user_id = document.querySelector(".task-user").value;

        // TICKET
        let ticket_filter = document.querySelector(".ticket-filter").value;
        let ticket_user_id = document.querySelector(".ticket-user").value;

        url.searchParams.set("task_filter", task_filter);
        url.searchParams.set("task_user_id", task_user_id);

        url.searchParams.set("ticket_filter", ticket_filter);
        url.searchParams.set("ticket_user_id", ticket_user_id);

        window.location.href = url.toString();
    }

});
/////////////////filter reset /////////////////////////
document.getElementById("filterType").addEventListener("change", function () {

    let url = new URL(window.location.href);

    // reset both filters on switch
    url.searchParams.delete("location_id");
    url.searchParams.delete("department_id");

    url.searchParams.set("filter_type", this.value);

    window.location.href = url.toString();
});

///////////////////// TASK STATUS CHANGE /////////////////////////
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


</script>

@endsection



