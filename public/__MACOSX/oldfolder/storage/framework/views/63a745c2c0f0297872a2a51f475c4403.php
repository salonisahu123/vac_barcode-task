

<?php $__env->startSection('title','Dashboard'); ?>

<?php $__env->startSection('css'); ?>
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
</style>

<link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

<?php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
?>
    

<?php
    $isEmployee = Auth::user()->user_type == 'employee';
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

        
        <div class="right-side">

            <?php if(!$isEmployee): ?>

            
           
        <div class="pending-task-icon" style="position: relative; display: inline-block;">
        
            <a href="<?php echo e(route('tasks.pending')); ?>" style="text-decoration: none; color: inherit;">
        
               <i class="fa fa-bars" style="font-size:18px;"></i>
        
                
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
                    <?php echo e($pendingTaskCount ?? 0); ?>

                </span>
        
            </a>
        
        </div>

        <form method="GET" action="<?php echo e(route('dashboard')); ?>" 
              class="d-flex align-items-center flex-wrap" 
              style="gap:10px;" id="filterForm">

            
            <select name="filter_type" id="filterType" class="filter-select">

                <option value="location"
                    <?php echo e(request('filter_type','location') == 'location' ? 'selected' : ''); ?>>
                    Location
                </option>

                <option value="department"
                    <?php echo e(request('filter_type') == 'department' ? 'selected' : ''); ?>>
                    Department
                </option>

            </select>

            
            <div id="locationBox">
           <select name="location_id" class="filter-select"
        onchange="document.getElementById('filterForm').submit()">

        <option value="" <?php echo e(empty($locationId) ? 'selected' : ''); ?>>
            Select Location
        </option>
        
        <option value="all" <?php echo e($locationId === 'all' ? 'selected' : ''); ?>>
            All Location
        </option>
            <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($location->id); ?>"
                    <?php echo e(request('location_id') == $location->id ? 'selected' : ''); ?>>
                    <?php echo e($location->name); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
        </select>
            </div>

            
            <div id="departmentBox">
            <select name="department_id" class="filter-select"
        onchange="document.getElementById('filterForm').submit()">

      <option value="" <?php echo e($departmentId == '' ? 'selected' : ''); ?>>
        Select Department
    </option>
    
    <option value="all" <?php echo e($departmentId == 'all' ? 'selected' : ''); ?>>
        All Department
    </option>
    
        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($department->id); ?>"
                <?php echo e(request('department_id') == $department->id ? 'selected' : ''); ?>>
                <?php echo e($department->dept_name); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
    </select>
            </div>

        </form>

            <?php endif; ?>

        </div>

    </div>
</div>



<div class="row">

    
    <?php if(!$isEmployee): ?>
    <div class="col-lg-3 col-md-6">
        <a href="<?php echo e(route('employees.index')); ?>" class="card-link">
            <div class="dashboard-card small-card">

                <span class="card-badge yellow-badge">
                    <?php echo e(ucfirst($filterType)); ?> Wise
                </span>

                <div class="card-body-flex">
                    <div class="card-icon yellow">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="card-content">
                        <p class="total"><?php echo e($userCount); ?></p>
                        <p class="label">Employees</p>
                    </div>
                </div>

            </div>
        </a>
    </div>
    <?php endif; ?>


    
    <?php if(!$isEmployee): ?>
    <div class="col-lg-3 col-md-6">
        <a href="<?php echo e(route('tasks.index')); ?>" class="card-link">
            <div class="dashboard-card small-card">

                <span class="card-badge purple-badge">System</span>

                <div class="card-body-flex">
                    <div class="card-icon purple">
                        <i class="fa fa-tasks"></i>
                    </div>
                    <div class="card-content">
                        <p class="total"><?php echo e($globalTaskCount); ?></p>
                        <p class="label">All Tasks</p>
                    </div>
                </div>

            </div>
        </a>
    </div>
    <?php endif; ?>


    
    <div class="col-lg-3 col-md-6">
        <div class="dashboard-card small-card">

            <span class="card-badge purple-badge">
                <?php echo e(ucfirst($filterType)); ?> Wise
            </span>

            <div class="card-body-flex">
                <div class="card-icon purple">
                    <i class="fa fa-user-check"></i>
                </div>
                <div class="card-content">
                    <p class="total"><?php echo e($taskCount); ?></p>
                    <p class="label">Assigned Tasks</p>
                </div>
            </div>

        </div>
    </div>


    
    <?php if(!$isEmployee): ?>
    <div class="col-lg-3 col-md-6">
        <a href="<?php echo e(route('tickets.index')); ?>" class="card-link">
            <div class="dashboard-card small-card">

                <span class="card-badge orange-badge">System</span>

                <div class="card-body-flex">
                    <div class="card-icon orange">
                        <i class="fa fa-ticket"></i>
                    </div>
                    <div class="card-content">
                        <p class="total"><?php echo e($globalTicketCount); ?></p>
                        <p class="label">All Tickets</p>
                    </div>
                </div>

            </div>
        </a>
    </div>
    <?php endif; ?>


    
    <div class="col-lg-3 col-md-6">
        <div class="dashboard-card small-card">

            <span class="card-badge orange-badge">
                <?php echo e(ucfirst($filterType)); ?> Wise
            </span>

            <div class="card-body-flex">
                <div class="card-icon orange">
                    <i class="fa fa-user-tag"></i>
                </div>
                <div class="card-content">
                    <p class="total"><?php echo e($ticketCount); ?></p>
                    <p class="label">Assigned Tickets</p>
                </div>
            </div>

        </div>
    </div>

    
    
    <?php if(!$isEmployee): ?>
    <div class="col-lg-3 col-md-6">
        <div class="dashboard-card small-card">
    
            <span class="card-badge orange-badge">
                <?php echo e(ucfirst($filterType)); ?> Wise
            </span>
    
            <div class="card-body-flex">
                <div class="card-icon orange">
                    <i class="fa fa-tasks"></i>
                </div>
                <div class="card-content">
                    <p class="total"><?php echo e($basicTaskPending); ?></p>
                    <p class="label">Pending task</p>
                </div>
            </div>
    
        </div>
    </div>
    
    
    
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
                <p class="total"><?php echo e($pendingTicketCount); ?></p>
                <p class="label">Pending Tickets</p>
            </div>
        </div>

    </div>
</div>


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
                <p class="total"><?php echo e($locationCount); ?></p>
                <p class="label">Locations</p>
            </div>
        </div>

    </div>
</div>


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
                <p class="total"><?php echo e($departmentCount); ?></p>
                <p class="label">Departments</p>
            </div>
        </div>

    </div>
</div>


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
                <p class="total"><?php echo e($roleCount); ?></p>
                <p class="label">Roles</p>
            </div>
        </div>

    </div>
</div>


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
                <p class="total"><?php echo e($groupCount); ?></p>
                <p class="label">Groups</p>
            </div>
        </div>

    </div>
</div>

<?php endif; ?>
 </div>
    
   
   
     <div class="row mt-2">

    
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card graph-card">

            
            <div class="graph-head-line">
                <div class="graph-title">
                    <i class="fa fa-tasks text-primary mr-2"></i>
                    Task Analytics
                </div>

                <div class="graph-right-filter">
                   <select class="graph-select task-filter" name="task_filter">
                    <option value="day" <?php echo e(request('task_filter')=='day'?'selected':''); ?>>Day Wise</option>
                    <option value="month" <?php echo e(request('task_filter','month')=='month'?'selected':''); ?>>Month Wise</option>
                    <option value="year" <?php echo e(request('task_filter')=='year'?'selected':''); ?>>Year Wise</option>
                </select>
                
                <select class="graph-select task-user" name="task_user_id">
                    <option value="">All Users</option>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($u->id); ?>" <?php echo e(request('task_user_id')==$u->id?'selected':''); ?>>
                            <?php echo e($u->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                </div>
            </div>

            
            <div class="chart-box">
                <canvas id="taskChart"></canvas>
            </div>

        </div>
    </div>



    
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card graph-card">

            
            <div class="graph-head-line">
                <div class="graph-title">
                    <i class="fa fa-ticket text-warning mr-2"></i>
                    Ticket Analytics
                </div>

                <div class="graph-right-filter">
                <select class="graph-select ticket-filter" name="ticket_filter">
                <option value="day" <?php echo e(request('ticket_filter')=='day'?'selected':''); ?>>Day Wise</option>
                <option value="month" <?php echo e(request('ticket_filter','month')=='month'?'selected':''); ?>>Month Wise</option>
                <option value="year" <?php echo e(request('ticket_filter')=='year'?'selected':''); ?>>Year Wise</option>
            </select>
            
            <select class="graph-select ticket-user" name="ticket_user_id">
                <option value="">All Users</option>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($u->id); ?>" <?php echo e(request('ticket_user_id')==$u->id?'selected':''); ?>>
                        <?php echo e($u->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
                </div>
            </div>

            
            <div class="chart-box">
                <canvas id="ticketChart"></canvas>
            </div>
            

        </div>
    </div>

</div>

</div>

<?php $__env->stopSection(); ?>






<?php $__env->startSection('js'); ?>
<script>
window.dashboardEmployees = <?php echo json_encode($users, 15, 512) ?>;
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
    <?php echo e($taskStatus->pending ?? 0); ?>,
    <?php echo e($taskStatus->in_progress ?? 0); ?>,
    <?php echo e($taskStatus->completed ?? 0); ?>

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
    <?php echo e($ticketStatus->pending ?? 0); ?>,
    <?php echo e($ticketStatus->in_progress ?? 0); ?>,
    <?php echo e($ticketStatus->hold ?? 0); ?>,
    <?php echo e($ticketStatus->close_request ?? 0); ?>,
    <?php echo e($ticketStatus->closed ?? 0); ?>,
    <?php echo e($ticketStatus->reopen ?? 0); ?>,
    <?php echo e($ticketStatus->assigned ?? 0); ?>

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
            _token: '<?php echo e(csrf_token()); ?>',
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

<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\vac-barcode-task\resources\views/dashboard.blade.php ENDPATH**/ ?>