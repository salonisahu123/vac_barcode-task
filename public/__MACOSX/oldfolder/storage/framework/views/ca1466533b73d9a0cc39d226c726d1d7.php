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
<tr>
    <td colspan="12" class="text-center text-muted">
        No tasks found
    </td>
</tr>
<?php endif; ?><?php /**PATH E:\xampp\htdocs\vac-barcode-task\resources\views/tasks/partials/rows.blade.php ENDPATH**/ ?>