

<?php $__env->startSection('title','Pending Tasks'); ?>

<?php $__env->startSection('css'); ?>

<link rel="stylesheet" href="<?php echo e(asset('/css/pendingtask.css')); ?>">

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

.task-item.new-task-highlight{
    background:#fff3cd !important;
    border:2px solid #ffc107 !important;
    box-shadow:0 0 15px rgba(255,193,7,0.45);
}

</style>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

<?php
$user = Auth::user();
$isEmployee = $user->user_type == 'employee';
?>

<div class="dashboard-page">

    
    <div class="dashboard-top">

        <div class="dashboard-top-inner">

            
            <div class="left-side">

                <div class="greeting-box">
                    <h6>Welcome Back</h6>
                    <h4><?php echo e(Auth::user()->name); ?></h4>
                </div>

            </div>

            
            <!--<div class="right-side">-->

            <!--    <?php if(!$isEmployee): ?>-->

            <!--    <form method="GET"-->
            <!--          action="<?php echo e(route('tasks.pending')); ?>"-->
            <!--          class="d-flex align-items-center flex-wrap"-->
            <!--          style="gap:12px;"-->
            <!--          id="filterForm">-->

            <!--        -->
            <!--        <select name="filter_type"-->
            <!--                id="filterType"-->
            <!--                class="filter-select">-->

            <!--            <option value="location"-->
            <!--                <?php echo e(request('filter_type','location') == 'location' ? 'selected' : ''); ?>>-->
            <!--                Location-->
            <!--            </option>-->

            <!--            <option value="department"-->
            <!--                <?php echo e(request('filter_type') == 'department' ? 'selected' : ''); ?>>-->
            <!--                Department-->
            <!--            </option>-->

            <!--        </select>-->

            <!--        -->
            <!--        <div id="locationBox">-->

            <!--            <select name="location_id"-->
            <!--                    class="filter-select"-->
            <!--                    onchange="document.getElementById('filterForm').submit()">-->

            <!--                <option value=""-->
            <!--                    <?php echo e(empty($locationId) ? 'selected' : ''); ?>>-->
            <!--                    Select Location-->
            <!--                </option>-->

            <!--                <option value="all"-->
            <!--                    <?php echo e($locationId === 'all' ? 'selected' : ''); ?>>-->
            <!--                    All Location-->
            <!--                </option>-->

            <!--                <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>-->

            <!--                    <option value="<?php echo e($location->id); ?>"-->
            <!--                        <?php echo e(request('location_id') == $location->id ? 'selected' : ''); ?>>-->
            <!--                        <?php echo e($location->name); ?>-->
            <!--                    </option>-->

            <!--                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>-->

            <!--            </select>-->

            <!--        </div>-->

            <!--        -->
            <!--        <div id="departmentBox">-->

            <!--            <select name="department_id"-->
            <!--                    class="filter-select"-->
            <!--                    onchange="document.getElementById('filterForm').submit()">-->

            <!--                <option value=""-->
            <!--                    <?php echo e($departmentId == '' ? 'selected' : ''); ?>>-->
            <!--                    Select Department-->
            <!--                </option>-->

            <!--                <option value="all"-->
            <!--                    <?php echo e($departmentId == 'all' ? 'selected' : ''); ?>>-->
            <!--                    All Department-->
            <!--                </option>-->

            <!--                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>-->

            <!--                    <option value="<?php echo e($department->id); ?>"-->
            <!--                        <?php echo e(request('department_id') == $department->id ? 'selected' : ''); ?>>-->
            <!--                        <?php echo e($department->dept_name); ?>-->
            <!--                    </option>-->

            <!--                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>-->

            <!--            </select>-->

            <!--        </div>-->

            <!--    </form>-->

            <!--    <?php endif; ?>-->

            <!--</div>-->

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

    

    <div class="board-wrapper" id="board">

        <?php $__currentLoopData = $subtasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subtask): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <?php
                $subtaskTasks = $tasks[$subtask->id] ?? collect();
            ?>

            <div class="task-list">

                
                <div class="header">

                    <h2><?php echo e($subtask->subtask); ?></h2>

                    <span class="badge">
                        <?php echo e($subtaskTasks->count()); ?>

                    </span>

                </div>

                
                <ul class="list">

                    <?php $__empty_1 = true; $__currentLoopData = $subtaskTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                        <?php
    $isNewTask = now()->lessThanOrEqualTo($task->created_at->copy()->addMinutes(5));
?>

<li class="task-item <?php echo e($isNewTask ? 'new-task-highlight' : ''); ?>">

                            
                            <div class="task-content">

                            <h4>
    <?php echo e($task->title); ?>

    <small class="text-muted d-block mt-1">
        <?php echo e(\Carbon\Carbon::parse($task->from_date)->format('d M Y')); ?>

        -
        <?php echo e(\Carbon\Carbon::parse($task->to_date)->format('d M Y')); ?>

    </small>
</h4>

                            </div>

                            <?php

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

                            ?>

                        </li>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <li class="empty-task">
                            No tasks found
                        </li>

                    <?php endif; ?>

                </ul>

            </div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>

</div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>

<script src="<?php echo e(asset('js/pendingtask.js')); ?>"></script>

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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\vac-barcode-task\resources\views/dashboard/render.blade.php ENDPATH**/ ?>