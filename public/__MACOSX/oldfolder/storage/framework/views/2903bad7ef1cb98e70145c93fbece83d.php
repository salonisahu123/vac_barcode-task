<?php $__empty_1 = true; $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

<tr style="font-size:13px;">

    <td><?php echo e($key+1); ?></td>

    <td><b><?php echo e($ticket->title); ?></b></td>

    <td>
        <span class="badge">
            <?php echo e(ucfirst($ticket->ticket_type)); ?>

        </span>
    </td>

    <!--<td>-->
    <!--    <span class="badge">-->
    <!--        <?php echo e(ucfirst($ticket->priority)); ?>-->
    <!--    </span>-->
    <!--</td>-->

<td>

<span class="status-badge status-<?php echo e(str_replace('_','-',$ticket->status)); ?>">
    <?php echo e(ucfirst(str_replace('_',' ',$ticket->status))); ?>

</span>

<?php
    $canEditStatus = $ticket->can_edit_status ?? [];
?>

<?php if(
    in_array($ticket->status, ['assigned', 'in_progress', 'hold', 'close_request'])
    && ($canEditStatus['assigned_to_me'] ?? false)
    && $ticket->status != 'close_request'
): ?>
    <button class="btn btn-sm btn-outline-primary changeStatusBtn"
        data-id="<?php echo e($ticket->id); ?>"
        data-status="<?php echo e($ticket->status); ?>"
        data-assigned="<?php echo e($canEditStatus['assigned_to_me'] ?? 0); ?>"
        data-created="<?php echo e($canEditStatus['created_by_me'] ?? 0); ?>">
        Change
    </button>
<?php endif; ?>

</td>


    <!--<td><?php echo e($ticket->department->dept_name ?? '-'); ?></td>-->
    <td>
        <?php echo e($ticket->location->name ?? '-'); ?>

    </td>
    
    <td>
    <?php
        $groupName = $ticket->assignments
            ->pluck('group.group_name')
            ->filter()
            ->unique()
            ->implode(', ');
    ?>

    <?php echo e($groupName ?: '-'); ?>

   </td>

    
    <?php if($isAdmin): ?>
    <td>
        <div class="d-flex align-items-center">
    
            <?php $count = $ticket->assignments->count(); ?>
    
            <?php $__empty_2 = true; $__currentLoopData = $ticket->assignments->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                <?php if($assign->employee && $assign->employee->user): ?>
    
                    <img src="<?php echo e(!empty($assign->employee->image) && file_exists(public_path('uploads/employees/'.$assign->employee->image)) 
                                ? asset('uploads/employees/'.$assign->employee->image) 
                                : asset('uploads/employees/user.png')); ?>"
                         
                         title="<?php echo e($assign->employee->user->name); ?>"
                         style="width:32px;height:32px;border-radius:50%;object-fit:cover;margin-left:-6px;border:2px solid #fff;">
    
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                <span class="text-muted">Not Assigned</span>
            <?php endif; ?>
    
            <?php if($count > 3): ?>
            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                 style="width:32px;height:32px;font-size:11px;margin-left:-6px;">
                +<?php echo e($count - 3); ?>

            </div>
            <?php endif; ?>
    
        </div>
    </td>
    <?php endif; ?>

    <!--<td><?php echo e($ticket->creator->name ?? '-'); ?></td>-->

    
    <td>
    <div class="d-flex gap-1 align-items-center">

        
        <?php if(($isAdmin || hasPermission('ticket_assign')) && $ticket->status == 'pending'): ?>

        <button class="action-btn assignBtn"
            data-id="<?php echo e($ticket->id); ?>"
            data-type="<?php echo e($ticket->ticket_type); ?>"
            data-location="<?php echo e($ticket->location->name ?? ''); ?>"
            data-locationid="<?php echo e($ticket->location_id); ?>"
            title="Assign">

            <i class="fa fa-user-plus text-dark"></i>
        </button>

        <?php endif; ?>


        
        <?php if($ticket->status == 'close_request' && $ticket->user_id == auth()->id()): ?>

            
            <button class="action-btn btn-close-ticket"
                data-id="<?php echo e($ticket->id); ?>"
                title="Close Ticket">
                <i class="fa fa-check text-success"></i>
            </button>

            
            <button class="action-btn btn-reopen-ticket"
                data-id="<?php echo e($ticket->id); ?>"
                title="Reopen Ticket">
                <i class="fa fa-undo text-warning"></i>
            </button>

        <?php endif; ?>


        
        <a href="<?php echo e(route('tickets.show',$ticket->id)); ?>"
           class="action-btn">
            <i class="fa fa-eye text-info"></i>
        </a>
        
        
        <?php if(
            ($isAdmin || hasPermission('ticket_edit')) 
            && in_array($ticket->status, ['pending', 'close_request'])
        ): ?>
        <a href="<?php echo e(route('tickets.edit',$ticket->id)); ?>"
           class="action-btn">
            <i class="fa fa-edit text-warning"></i>
        </a>
        <?php endif; ?>

        
        <?php if($isAdmin || hasPermission('ticket_delete')): ?>
        <form action="<?php echo e(route('tickets.destroy',$ticket->id)); ?>"
              method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>

            <button type="button" class="action-btn delete-btn">
                <i class="fa fa-trash text-danger"></i>
            </button>
        </form>
        <?php endif; ?>

    </div>
</td>

</tr>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<tr>
    <td colspan="7" class="text-center text-muted">
        No Tickets Found
    </td>
</tr>
<?php endif; ?><?php /**PATH E:\xampp\htdocs\vac-barcode-task\resources\views/tickets/partials/rows.blade.php ENDPATH**/ ?>