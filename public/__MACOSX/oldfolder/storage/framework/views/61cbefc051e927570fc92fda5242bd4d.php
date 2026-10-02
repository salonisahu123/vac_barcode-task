

<?php $__env->startSection('title','Tasks'); ?>

<?php $__env->startSection('css'); ?>
<!-- ADD -->
<link rel="stylesheet" href="<?php echo e(asset('css/task.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['title' => 'Task Management','page' => 'Task List']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Task Management','page' => 'Task List']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2)): ?>
<?php $attributes = $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2; ?>
<?php unset($__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale19f62b34dfe0bfdf95075badcb45bc2)): ?>
<?php $component = $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2; ?>
<?php unset($__componentOriginale19f62b34dfe0bfdf95075badcb45bc2); ?>
<?php endif; ?>

<?php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
?>


<?php if($isAdmin || hasPermission('task_view_all') || hasPermission('task_view_own')): ?>


<div class="mt-2"></div>

<div class="row">
    <div class="col-md-12">

        <div class="white_shd full margin_bottom_30 p-3 shadow-sm">

            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-3">

                <div></div>
                
                
                <?php if($isAdmin || hasPermission('task_add')): ?>
                <a href="<?php echo e(route('tasks.create')); ?>"
                   class="btn btn-primary btn-sm d-flex align-items-center"
                   style="border-radius:6px;">
                    <i class="fa fa-plus me-1"></i> Create Task
                </a>
                <?php endif; ?>

            </div>
            
            <!--{ ================== FILTER START=============================}-->
<div class="card p-3 mb-3">

    <div class="row">

        <div class="col-md-4">
            <label>Location</label>
            <select id="filter_location" class="form-control">
                <option value="">All</option>
                <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($loc->id); ?>"><?php echo e($loc->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="col-md-4">
            <label>Group</label>
            <select id="filter_group" class="form-control">
                <option value="">All</option>
                <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($grp->id); ?>"><?php echo e($grp->group_name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        
        <div class="col-md-4">
            <label>Status</label>
        
            <select id="filter_status" class="form-control">
                <option value="">Pending & In Progress</option>
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>
        </div>

    </div>

</div>
<!--{ ================== FILTER END=============================}-->

            <!-- TABLE -->
            <div class="table-responsive">

                <table class="table datatable align-middle" data-table="task">

                    <thead>
                        <tr style="font-size:13px; background:#f8f9fa;">
                            <th>#</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Sub Task</th>
                            <th>Location</th>
                            <th>Group</th>
                            <th>from</th>
                            <th>To date</th>
                            <th>Assigned</th>
                            <th>Created By</th>
                            <th width="160">Action</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody id="taskTableBody">

                       <?php $__empty_1 = true; $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
             <tr style="font-size:13px;">
            
                <td><?php echo e($key+1); ?></td>
            
                <td><span style="font-weight:500;"><?php echo e($task->title); ?></span></td>
            
             <td>
            <span class="badge"
                  style="background:#eef2ff; color:#4338ca; font-weight:500;">
                <?php echo e(ucfirst($task->task_type)); ?>

            </span>
        </td>
        
        <td>
    <span class="badge"
          style="background:#ecfdf3; color:#027a48; font-weight:500;">

        <?php echo e($subtasks[$task->subtask_id] ?? '-'); ?>


    </span>
</td>

    <td><?php echo e($task->location->name ?? '-'); ?></td>

    <td><?php echo e($task->group->group_name ?? '-'); ?></td>

    <td style="color:#6c757d;"><?php echo e($task->from_date); ?></td>

    <td style="color:#6c757d;"><?php echo e($task->to_date); ?></td>

    <!-- Assigned -->
    <td>
        <div class="d-flex align-items-center">
            <?php $count = $task->taskUsers->count(); ?>

            <?php $__currentLoopData = $task->taskUsers->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <img src="<?php echo e(!empty($assign->employee->image) 
                ? asset('uploads/employees/'.$assign->employee->image) 
                : asset('uploads/employees/user.png')); ?>"
             title="<?php echo e($assign->employee->user->name); ?>"
             style="width:32px;height:32px;border-radius:50%;object-fit:cover;border:2px solid #fff;margin-left:-8px;">
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php if($count > 3): ?>
                <div style="width:32px;height:32px;border-radius:50%;background:#0d6efd;color:#fff;font-size:11px;display:flex;align-items:center;justify-content:center;margin-left:-8px;border:2px solid #fff;">
                    +<?php echo e($count - 3); ?>

                </div>
            <?php endif; ?>
        </div>
    </td>

    <td><?php echo e($task->createdBy->name ?? '-'); ?></td>

    <!-- ACTION -->
    <td>
        <div class="d-flex gap-1">
            <?php if($isAdmin || hasPermission('task_view_all') || hasPermission('task_view_own')): ?>
            <a href="<?php echo e(route('tasks.show',$task->id)); ?>" class="btn btn-light btn-sm border">
                <i class="fa fa-eye text-info"></i>
            </a>
            <?php endif; ?>

            <?php if($isAdmin || hasPermission('task_edit')): ?>
            <a href="<?php echo e(route('tasks.edit',$task->id)); ?>" class="btn btn-light btn-sm border">
                <i class="fa fa-edit text-warning"></i>
            </a>
            <?php endif; ?>

            <?php if(hasPermission('task_delete')): ?>
            <form action="<?php echo e(route('tasks.destroy',$task->id)); ?>" method="POST" class="delete-form">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button type="button" class="btn btn-light btn-sm border delete-btn">
                    <i class="fa fa-trash text-danger"></i>
                </button>
            </form>
            <?php endif; ?>
            
            <button type="button"
        class="btn btn-outline-primary btn-sm remarkBtn"
        data-id="<?php echo e($task->id); ?>"
        data-title="<?php echo e($task->title); ?>">
    Remark
</button>
        </div>
    </td>

    <!-- STATUS -->
    <td style="min-width:160px;">
        <?php if($isAdmin || hasPermission('task_change_status')): ?>

        <select class="form-select form-select-sm changeStatus"
                data-id="<?php echo e($task->id); ?>">

            <option value="pending" <?php echo e($task->status=='pending' ? 'selected' : ''); ?>>Pending</option>
            <option value="in_progress" <?php echo e($task->status=='in_progress' ? 'selected' : ''); ?>>In Progress</option>
            <option value="completed" <?php echo e($task->status=='completed' ? 'selected' : ''); ?>>Completed</option>

        </select>

        <?php else: ?>

            <?php if($task->status == 'pending'): ?>
                <span class="task-status-badge task-status-pending">Pending</span>

            <?php elseif($task->status == 'in_progress'): ?>
                <span class="task-status-badge task-status-progress">In Progress</span>

            <?php else: ?>
                <span class="task-status-badge task-status-completed">Completed</span>
            <?php endif; ?>

        <?php endif; ?>
    </td>

</tr>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

<?php endif; ?>
                    </tbody>

                </table>

            </div>

        </div>

    </div>
</div>

<?php else: ?>

<div class="alert alert-danger">
    You do not have permission to view tasks list.
</div>

<?php endif; ?>

<!--//////////////////////// Remark model ////////////////////////////-->
<div class="modal fade" id="remarkModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Remark</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="remark_task_id">

                <label>Remark</label>
                <textarea id="remark_text" class="form-control" rows="4"></textarea>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" id="submitRemark">Submit</button>
            </div>

        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<script>

// FILTER
function loadTasks(){
    $.ajax({
        url: "<?php echo e(route('tasks.filter')); ?>",
        type: "GET",
       data: {
                location_id: $('#filter_location').val(),
                group_id: $('#filter_group').val(),
                status: $('#filter_status').val()
             },
        success:function(res){
            $('#taskTableBody').html(res.html);
        }
    });
}

$('#filter_location, #filter_group, #filter_status').on('change', function () {
    loadTasks();
});

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

    loadTasks();
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

///////////////////////////////// Remark //////////////////////////////
$(document).on('click', '.remarkBtn', function () {
    $('#remark_task_id').val($(this).data('id'));
    $('#remark_text').val('');
    $('#remarkModal').modal('show');
});

$('#submitRemark').on('click', function () {
    let id = $('#remark_task_id').val();
    let remark = $('#remark_text').val();

    if (remark.trim() === '') {
        Swal.fire('Error', 'Please enter remark', 'error');
        return;
    }

    $.ajax({
        url: '/tasks/' + id + '/remark',
        type: 'POST',
        data: {
            _token: '<?php echo e(csrf_token()); ?>',
            remark: remark
        },
        success: function (res) {
            if (res.status === true) {
                $('#remarkModal').modal('hide');
                Swal.fire('Success', res.message, 'success');
            } else {
                Swal.fire('Error', res.message || 'Something went wrong', 'error');
            }
        },
        error: function (xhr) {
            Swal.fire('Error', xhr.responseJSON?.message || 'Server error', 'error');
        }
    });
});

</script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\vac-barcode-task\resources\views/tasks/index.blade.php ENDPATH**/ ?>