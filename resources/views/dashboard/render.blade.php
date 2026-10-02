@extends('layouts.master')

@section('title','Pending Tasks')

@section('css')

<link rel="stylesheet" href="{{ asset('/css/pendingtask.css') }}">

<style>

/* =========================================================
   PAGE
========================================================= */

.dashboard-page{
    width:100%;
    padding:20px;
    background:#f5f7fb;
    min-height:100vh;
}

/* =========================================================
   TOP BAR
========================================================= */

.dashboard-top{
    width:100%;
    margin-bottom:25px;
}

.dashboard-top-inner{
    width:100%;
    background:#fff;
    border-radius:18px;
    padding:18px 22px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:20px;
    box-shadow:0 4px 18px rgba(0,0,0,0.06);
    flex-wrap:wrap;
}

/* LEFT */

.left-side{
    display:flex;
    align-items:center;
    gap:15px;
}

.greeting-box h6{
    margin:0;
    font-size:13px;
    font-weight:500;
    color:#888;
    font-family:'Poppins',sans-serif;
}

.greeting-box h4{
    margin:2px 0 0;
    font-size:24px;
    font-weight:700;
    color:#222;
    font-family:'Poppins',sans-serif;
}

/* RIGHT */

.right-side{
    display:flex;
    align-items:center;
    gap:12px;
    flex-wrap:wrap;
}

/* =========================================================
   FILTER
========================================================= */

.filter-select{
    height:42px;
    border:1px solid #ddd;
    border-radius:10px;
    padding:0 14px;
    min-width:180px;
    background:#fff;
    font-size:14px;
    font-weight:500;
    color:#333;
    outline:none;
    transition:0.3s;
    font-family:'Poppins',sans-serif;
}

.filter-select:focus{
    border-color:#6c63ff;
    box-shadow:0 0 0 3px rgba(108,99,255,0.12);
}

/* =========================================================
   BOARD WRAPPER
========================================================= */

.board-wrapper{
    width:100%;
    display:flex;
    flex-wrap:wrap;
    gap:15px;
    overflow-x:hidden;
}

/* SCROLLBAR */

.board-wrapper::-webkit-scrollbar{
    height:7px;
}

.board-wrapper::-webkit-scrollbar-thumb{
    background:#cfcfcf;
    border-radius:20px;
}

/* =========================================================
   COLUMN
========================================================= */

.task-list{
    width:calc(25% - 12px); /* 4 items per row */
    min-width:auto;
    max-width:none;
    height:450px; /* Added Height */
    background:#fff;
    border-radius:18px;
    box-shadow:0 6px 20px rgba(0,0,0,0.06);
    display:flex;
    flex-direction:column;
    overflow:hidden;
    border:1px solid #ececec;
}
/* =========================================================
   COLUMN HEADER
========================================================= */

.task-list .header{
    width:100%;
    padding:16px 18px;
    border-bottom:1px solid #f1f1f1;
    display:flex;
    justify-content:space-between;
    align-items:center;
    background:#fff;
}

.task-list .header h2{
    margin:0;
    font-size:16px;
    font-weight:700;
    color:#222;
    font-family:'Poppins',sans-serif;
}

/* BADGE */

.task-list .header .badge{
    min-width:28px;
    height:28px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:50px;
    background:#6c63ff;
    color:#fff;
    font-size:12px;
    font-weight:600;
    padding:0 10px;
}

/* =========================================================
   TASK LIST
========================================================= */

.list{
    list-style:none;
    margin:0;
    padding:14px;
    overflow-y:auto;
    max-height:72vh;
}

/* SCROLLBAR */

.list::-webkit-scrollbar{
    width:5px;
}

.list::-webkit-scrollbar-thumb{
    background:#d8d8d8;
    border-radius:20px;
}

/* =========================================================
   TASK CARD
========================================================= */
.task-item{
    min-height:auto !important;
    height:auto !important;
}
.task-item{
    width:100%;
    background:#fff;
    border:1px solid #ededed;
    border-radius:12px;
    padding:10px 12px;
    margin-bottom:10px;
    display:inline-block;
}
.task-item:hover{
    transform:translateY(-3px);
    box-shadow:0 8px 18px rgba(0,0,0,0.08);
}

@keyframes blink-recent {
    0% { box-shadow: 0 0 0 0 rgba(22, 119, 255, 0.4); border-color: transparent; }
    50% { box-shadow: 0 0 15px 4px rgba(22, 119, 255, 0.8) !important; border-color: #1677ff !important; }
    100% { box-shadow: 0 0 0 0 rgba(22, 119, 255, 0.4); border-color: transparent; }
}
.blink-recent-task {
    animation: blink-recent 1.5s infinite !important;
}

/* =========================================================
   CONTENT
========================================================= */

.task-content h4{
    margin:0;
    font-size:14px;
    font-weight:600;
    line-height:1.4;
    color:#222;
}

.task-content p{
    margin:0;
    font-size:13px;
    color:#777;
    line-height:1.7;
    font-family:'Poppins',sans-serif;
}

/* =========================================================
   ACTION AREA
========================================================= */

.task-action{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:10px;
    margin-top:14px;
}

/* =========================================================
   VIEW BUTTON
========================================================= */

.view-btn{
    padding:7px 14px;
    border-radius:8px;
    text-decoration:none;
    background:#f3f4f8;
    color:#333;
    font-size:12px;
    font-weight:600;
    border:1px solid #e2e2e2;
    transition:0.3s ease;
    font-family:'Poppins',sans-serif;
}

.view-btn:hover{
    background:#6c63ff;
    border-color:#6c63ff;
    color:#fff;
}

/* =========================================================
   STATUS BADGE
========================================================= */

.status-badge{
    padding:6px 12px;
    border-radius:30px;
    font-size:11px;
    font-weight:600;
    text-transform:capitalize;
    font-family:'Poppins',sans-serif;
}

/* =========================================================
   EMPTY TASK
========================================================= */

.empty-task{
    padding:12px;
    text-align:center;
    font-size:13px;
    color:#999;
    font-family:'Poppins',sans-serif;
}

/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width:991px){

    .task-list{
        width:calc(50% - 8px);
    }

}

@media(max-width:576px){

    .task-list{
        width:100%;
    }

}

@media(max-width:991px){

    .dashboard-top-inner{
        flex-direction:column;
        align-items:flex-start;
    }

    .right-side{
        width:100%;
    }

    .filter-select{
        width:100%;
    }

}

@media(max-width:768px){

    .dashboard-page{
        padding:15px;
    }

    .greeting-box h4{
        font-size:20px;
    }

    .task-list{
        min-width:290px;
        max-width:290px;
    }

}

.task-item.overdue-highlight{
    background: #fff0f0 !important;
    border: 1px solid #ffb3b3 !important;
    border-left: 6px solid #ff0000 !important;
    box-shadow: 0 2px 8px rgba(255,0,0,0.15);
}

.task-item.inprogress-overdue-highlight{
    background: #f9f0ff !important;
    border: 1px solid #d3adf7 !important;
    border-left: 6px solid #722ed1 !important;
    box-shadow: 0 2px 8px rgba(114,46,209,0.15);
}

.task-item.due-today-highlight{
    background: #fff7e6 !important;
    border: 1px solid #ffd591 !important;
    border-left: 6px solid #fa8c16 !important;
    box-shadow: 0 2px 8px rgba(250,140,22,0.15);
}

.task-item.inprogress-neardue-highlight{
    background: #fef9c3 !important;
    border: 1px solid #fde047 !important;
    border-left: 6px solid #eab308 !important;
    box-shadow: 0 2px 8px rgba(234,179,8,0.15);
}

.task-item.in-progress-highlight{
    background: #f6ffed !important;
    border: 1px solid #b7eb8f !important;
    border-left: 6px solid #52c41a !important;
    box-shadow: 0 2px 8px rgba(82,196,26,0.15);
}

.task-item.recent-highlight{
    background: #e6f4ff !important;
    border: 1px solid #91caff !important;
    border-left: 6px solid #1677ff !important;
    box-shadow: 0 2px 8px rgba(22,119,255,0.15);
}

</style>

@endsection


@section('content')

@php
$user = Auth::user();
$isEmployee = $user->user_type == 'employee';
@endphp

<div class="dashboard-page">

    {{-- TOP --}}
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
            <!--<div class="right-side">-->

            <!--    @if(!$isEmployee)-->

            <!--    <form method="GET"-->
            <!--          action="{{ route('tasks.pending') }}"-->
            <!--          class="d-flex align-items-center flex-wrap"-->
            <!--          style="gap:12px;"-->
            <!--          id="filterForm">-->

            <!--        {{-- FILTER TYPE --}}-->
            <!--        <select name="filter_type"-->
            <!--                id="filterType"-->
            <!--                class="filter-select">-->

            <!--            <option value="location"-->
            <!--                {{ request('filter_type','location') == 'location' ? 'selected' : '' }}>-->
            <!--                Location-->
            <!--            </option>-->

            <!--            <option value="department"-->
            <!--                {{ request('filter_type') == 'department' ? 'selected' : '' }}>-->
            <!--                Department-->
            <!--            </option>-->

            <!--        </select>-->

            <!--        {{-- LOCATION --}}-->
            <!--        <div id="locationBox">-->

            <!--            <select name="location_id"-->
            <!--                    class="filter-select"-->
            <!--                    onchange="document.getElementById('filterForm').submit()">-->

            <!--                <option value=""-->
            <!--                    {{ empty($locationId) ? 'selected' : '' }}>-->
            <!--                    Select Location-->
            <!--                </option>-->

            <!--                <option value="all"-->
            <!--                    {{ $locationId === 'all' ? 'selected' : '' }}>-->
            <!--                    All Location-->
            <!--                </option>-->

            <!--                @foreach($locations as $location)-->

            <!--                    <option value="{{ $location->id }}"-->
            <!--                        {{ request('location_id') == $location->id ? 'selected' : '' }}>-->
            <!--                        {{ $location->name }}-->
            <!--                    </option>-->

            <!--                @endforeach-->

            <!--            </select>-->

            <!--        </div>-->

            <!--        {{-- DEPARTMENT --}}-->
            <!--        <div id="departmentBox">-->

            <!--            <select name="department_id"-->
            <!--                    class="filter-select"-->
            <!--                    onchange="document.getElementById('filterForm').submit()">-->

            <!--                <option value=""-->
            <!--                    {{ $departmentId == '' ? 'selected' : '' }}>-->
            <!--                    Select Department-->
            <!--                </option>-->

            <!--                <option value="all"-->
            <!--                    {{ $departmentId == 'all' ? 'selected' : '' }}>-->
            <!--                    All Department-->
            <!--                </option>-->

            <!--                @foreach($departments as $department)-->

            <!--                    <option value="{{ $department->id }}"-->
            <!--                        {{ request('department_id') == $department->id ? 'selected' : '' }}>-->
            <!--                        {{ $department->dept_name }}-->
            <!--                    </option>-->

            <!--                @endforeach-->

            <!--            </select>-->

            <!--        </div>-->

            <!--    </form>-->

            <!--    @endif-->

            <!--</div>-->

        </div>

    </div>
    
<div class="color-indicators d-flex align-items-center mb-3" style="gap:15px; flex-wrap:wrap; padding:15px; background:#fff; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,0.04);">
    <div class="d-flex align-items-center">
        <span style="width:16px; height:16px; background:#ff0000; border-radius:4px; display:inline-block; margin-right:8px;"></span>
        <span style="font-size:13px; font-weight:600; color:#444;">Without Starting - Already Over Due</span>
    </div>
    <div class="d-flex align-items-center">
        <span style="width:16px; height:16px; background:#722ed1; border-radius:4px; display:inline-block; margin-right:8px;"></span>
        <span style="font-size:13px; font-weight:600; color:#444;">In Progress - Already Over Due</span>
    </div>
    <div class="d-flex align-items-center">
        <span style="width:16px; height:16px; background:#fa8c16; border-radius:4px; display:inline-block; margin-right:8px;"></span>
        <span style="font-size:13px; font-weight:600; color:#444;">Without Starting - Today/Tomorrow Due</span>
    </div>
    <div class="d-flex align-items-center">
        <span style="width:16px; height:16px; background:#eab308; border-radius:4px; display:inline-block; margin-right:8px;"></span>
        <span style="font-size:13px; font-weight:600; color:#444;">In Progress - Today/Tomorrow Due</span>
    </div>
    <div class="d-flex align-items-center">
        <span style="width:16px; height:16px; background:#52c41a; border-radius:4px; display:inline-block; margin-right:8px;"></span>
        <span style="font-size:13px; font-weight:600; color:#444;">In Progress</span>
    </div>
    <div class="d-flex align-items-center">
        <span style="width:16px; height:16px; background:#1677ff; border-radius:4px; display:inline-block; margin-right:8px;"></span>
        <span style="font-size:13px; font-weight:600; color:#444;">Recently Added</span>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <strong>Next Refresh Time:</strong>
        <span id="nextRefreshTime">05:00</span>
    </div>

    <button type="button" class="btn btn-primary btn-sm" onclick="location.reload();">
        Refresh Now
    </button>
</div>

    {{-- =====================================================
         BOARD
    ====================================================== --}}

    <div class="board-wrapper" id="board">

        @foreach($subtasks as $subtask)

            @php
                $subtaskTasks = $tasks[$subtask->id] ?? collect();
            @endphp

            <div class="task-list">

                {{-- HEADER --}}
                <div class="header">

                    <h2>{{ $subtask->subtask }}</h2>

                    <span class="badge">
                        {{ $subtaskTasks->count() }}
                    </span>

                </div>

                {{-- LIST --}}
                <ul class="list">

                    @forelse($subtaskTasks as $task)

@php
    $today = \Carbon\Carbon::today();
    $toDate = \Carbon\Carbon::parse($task->to_date)->startOfDay();
    
    $isPending = trim(strtolower($task->status)) === 'pending';
    $isInProgress = trim(strtolower($task->status)) === 'in_progress';
    
    $isOverdue = $toDate->lessThan($today);
    $isNearToDue = ($toDate->equalTo($today) || $toDate->equalTo($today->copy()->addDay()));
    $isRecentlyAdded = $task->created_at ? $task->created_at->greaterThanOrEqualTo(now()->subHours(24)) : false;
    
    $highlightClass = '';
    
    if ($isPending && $isOverdue) {
        $highlightClass = 'overdue-highlight';
    } elseif ($isInProgress && $isOverdue) {
        $highlightClass = 'inprogress-overdue-highlight';
    } elseif ($isInProgress && $isNearToDue) {
        $highlightClass = 'inprogress-neardue-highlight';
    } elseif ($isPending && $isNearToDue) {
        $highlightClass = 'due-today-highlight';
    } elseif ($isInProgress) {
        $highlightClass = 'in-progress-highlight';
    } elseif ($isRecentlyAdded) {
        $highlightClass = 'recent-highlight';
    }
@endphp

<li class="task-item {{ $highlightClass }} {{ $isRecentlyAdded ? 'blink-recent-task' : '' }}">

                            {{-- CONTENT --}}
                            <div class="task-content">

                            <h4>
    <a href="{{ route('tasks.show', $task->id) }}" style="color: inherit; text-decoration: none;" class="task-link-hover">
        {{ $task->title }}
    </a>
    <small class="text-muted d-block mt-1">
        {{ \Carbon\Carbon::parse($task->from_date)->format('d M Y') }}
        -
        {{ \Carbon\Carbon::parse($task->to_date)->format('d M Y') }}
    </small>
</h4>

                            </div>

                            @php

                                $statusColor = match($task->status) {

                                    'pending' => '#d39e00',
                                    'in_progress' => '#0d6efd',
                                    'completed' => '#198754',
                                    default => '#6c757d'

                                };

                                $statusBg = match($task->status) {

                                    'pending' => '#fff3cd',
                                    'in_progress' => '#dbeafe',
                                    'completed' => '#d1fae5',
                                    default => '#ececec'

                                };

                            @endphp

                        </li>

                    @empty

                        <li class="empty-task">
                            No tasks found
                        </li>

                    @endforelse

                </ul>

            </div>

        @endforeach

    </div>

</div>

@endsection


@section('script')

<script src="{{ asset('js/pendingtask.js') }}"></script>

<script>

/* =========================================================
   FILTER TOGGLE
========================================================= */

document.addEventListener("DOMContentLoaded", function(){

    const filterType   = document.getElementById("filterType");
    const locationBox  = document.getElementById("locationBox");
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

/* =========================================================
   RESET FILTER
========================================================= */

document.getElementById("filterType").addEventListener("change", function () {

    let url = new URL(window.location.href);

    url.searchParams.delete("location_id");
    url.searchParams.delete("department_id");

    url.searchParams.set("filter_type", this.value);

    window.location.href = url.toString();

});

</script>

<script>
    let refreshSeconds = 300; 

    function updateRefreshTimer() {
        let minutes = Math.floor(refreshSeconds / 60);
        let seconds = refreshSeconds % 60;

        document.getElementById('nextRefreshTime').innerText =
            String(minutes).padStart(2, '0') + ':' +
            String(seconds).padStart(2, '0');

        if (refreshSeconds <= 0) {
            location.reload();
            return;
        }

        refreshSeconds--;
    }

    updateRefreshTimer();
    setInterval(updateRefreshTimer, 1000);
</script>

@endsection