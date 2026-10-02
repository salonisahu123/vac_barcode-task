

<?php $__env->startSection('title','Task Details'); ?>

<?php $__env->startSection('css'); ?>
<!-- ADD -->
<link rel="stylesheet" href="<?php echo e(asset('css/task.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php if(auth()->user()->user_type == 'admin' || hasPermission('task_view_all') || hasPermission('task_view_own')): ?>

<?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['title' => 'Task Management','page' => 'Task Details']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Task Management','page' => 'Task Details']); ?>
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

<div class="container-fluid mt-3">

<div class="task-card">

    
   
<div class="task-header d-flex justify-content-between align-items-center">

    
    <div>
        <div class="task-title">
            <i class="fa fa-tasks text-primary"></i>
            <?php echo e($task['title']); ?>

        </div>
        <small class="text-muted">
            Created By <?php echo e($task['created_by']); ?>

        </small>
    </div>

    
    <div class="d-flex gap-2">

        
        <a href="<?php echo e(route('tasks.index')); ?>"
           class="btn btn-light btn-sm shadow-sm"
           style="border-radius:8px;">
            <i class="fa fa-arrow-left"></i> Back
        </a>

        
        <?php if(auth()->user()->user_type == 'admin' || hasPermission('task_edit')): ?>
            <a href="<?php echo e(route('tasks.edit', $task['id'] ?? $task->id)); ?>"
               class="btn btn-primary btn-sm shadow-sm"
               style="border-radius:8px;">
                <i class="fa fa-edit"></i> Edit
            </a>
        <?php endif; ?>

    </div>

</div>

    
    <div class="tab-box">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#overview">Overview</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#activity">Activity</a>
            </li>
        </ul>
    </div>

    <div class="tab-content p-3">

        

<div class="tab-pane fade show active" id="overview">

    <div class="row">

        
        <div class="col-md-4">

           
            <div class="card border-0 shadow-sm mb-3 rounded-lg">
                <div class="card-body">
                    <small class="text-muted">Task Title</small>
                    <h5 class="mb-0 mt-1">
                        <?php echo e($task->title ?? 'No Title'); ?>

                    </h5>
                    <small class="text-muted">
                        Created By: <?php echo e($task->createdBy->name ?? 'Unknown'); ?>

                    </small>
                </div>
            </div>

            
            <?php
                $statusClass = [
                    'pending' => 'warning',
                    'in_progress' => 'info',
                    'completed' => 'success'
                ];
            ?>

            <div class="card border-0 shadow-sm mb-3 rounded-lg">
                <div class="card-body">
                    <small class="text-muted">Status</small><br>
                    <span class="badge badge-<?php echo e($statusClass[$task->status] ?? 'secondary'); ?> px-3 py-2 mt-1">
                        <?php echo e(ucfirst($task->status ?? 'Not Available')); ?>

                    </span>
                </div>
            </div>

            
            <div class="card border-0 shadow-sm mb-3 rounded-lg">
                <div class="card-body">
                    <small class="text-muted">Mode</small><br>

                    <?php if(!empty($task->mode)): ?>
                        <span class="badge badge-dark px-3 py-2 mt-1">
                            <?php echo e(ucfirst($task->mode)); ?>

                        </span>
                    <?php else: ?>
                        <span class="text-danger">No Mode</span>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="card border-0 shadow-sm mb-3 rounded-lg">
                <div class="card-body">
                    <small class="text-muted">Timeline</small>

                    <p class="mb-1 mt-2">
                        <b>From:</b>
                        <?php echo e($task->from_date ?? 'Not Available'); ?>

                    </p>

                    <p class="mb-0">
                        <b>To:</b>
                        <?php echo e($task->to_date ?? 'Not Available'); ?>

                    </p>
                </div>
            </div>

        </div>

        
        <div class="col-md-8">
            
             
              
            <div class="card border-0 shadow-sm mb-3 rounded-lg">
                <div class="card-body">
                    <small class="text-muted">Task Type</small><br>
                    <span class="badge badge-primary px-3 py-2 mt-1">
                        <?php echo e(ucfirst($task->task_type ?? 'Not Available')); ?>

                    </span>
                </div>
            </div>
            
            
            <div class="card border-0 shadow-sm mb-3 rounded-lg">
                <div class="card-body">
                    <small class="text-muted">Sub Task</small><br>
            
                    <span class="badge badge-success px-3 py-2 mt-1">
                        <?php echo e($task->subtask_name); ?>

                    </span>
                </div>
            </div>

            
            <div class="card border-0 shadow-sm mb-3 rounded-lg">
                <div class="card-body">
                    <small class="text-muted">Description</small>

                    <p class="mb-0 mt-2 text-secondary">
                        <?php echo e($task->description ?? 'No Description Available'); ?>

                    </p>
                </div>
            </div>

            
            <div class="card border-0 shadow-sm mb-3 rounded-lg">
                <div class="card-body">
                    <small class="text-muted">Attachment</small>

                    <div class="mt-2">
                        <?php if(!empty($task->file)): ?>
                            <a href="<?php echo e(asset('uploads/tasks/'.$task->file)); ?>"
                               target="_blank"
                               class="btn btn-sm btn-outline-primary">
                                View File
                            </a>
                        <?php else: ?>
                            <span class="text-muted">No File Attached</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            
            <div class="card border-0 shadow-sm mb-3 rounded-lg">
                <div class="card-body">

                    <small class="text-muted">Assigned Employees</small>

                    <div class="d-flex flex-wrap mt-3">

                        <?php $__empty_1 = true; $__currentLoopData = $task->taskUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                            <?php
                                $emp = $assign->employee->user ?? null;
                            ?>

                            <div class="text-center mr-3 mb-3">

                                <img src="<?php echo e(!empty($assign->employee->image) 
                                    ? asset('uploads/employees/'.$assign->employee->image) 
                                    : asset('uploads/employees/user.png')); ?>"
                                 class="rounded-circle shadow-sm"
                                 width="50"
                                 height="50">

                                <div style="font-size:12px;" class="mt-1">
                                    <?php echo e($emp->name ?? 'Employee'); ?>

                                </div>

                            </div>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <span class="text-muted">No Employees Assigned</span>
                        <?php endif; ?>

                    </div>

                </div>
            </div>

        </div>

    </div>

</div>


    

<div class="tab-pane fade" id="activity">

    <div class="activity-wrapper">

        
        <div class="activity-header">
            <i class="fa fa-history text-primary"></i>
            <span>Activity Timeline</span>
        </div>

        
        <div class="timeline">

            <?php $__empty_1 = true; $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $act): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <?php
                    $empName = null;

                    if($act->table_name == 'ticket_assignments') {
                        $assign = \App\Models\TicketAssignment::with('employee.user')
                            ->find($act->table_id);

                        $empName = $assign->employee->user->name ?? null;
                    }
                ?>
                
                <?php
                $userName = \App\Models\User::find($act->user_id)?->name;
            ?>

                <div class="timeline-item">

                    
                    <div class="timeline-dot"></div>

                    
                    <div class="timeline-content">

                        <div class="timeline-title">
                            <?php echo e(ucfirst($act->operation)); ?>

                        </div>
                        
                        <?php if($userName): ?>
    <div class="timeline-user">
        <strong>By :</strong> <?php echo e($userName); ?>

    </div>
<?php endif; ?>

                        <div class="timeline-desc">
                            <?php if($empName): ?>
                                <?php echo e(str_replace('employee ID', $empName, $act->description)); ?>

                            <?php else: ?>
                                <?php echo e($act->description); ?>

                            <?php endif; ?>
                        </div>

                        <div class="timeline-time">
                            <i class="fa fa-clock"></i>
                            <?php echo e(\Carbon\Carbon::parse($act->created_at)->format('d M Y h:i A')); ?>

                        </div>

                    </div>

                </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-muted p-3">No activity found</div>
            <?php endif; ?>

        </div>

    </div>

</div>

    </div>

</div>

</div>

<?php else: ?>
<div class="alert alert-danger">No Permission</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\vac-barcode-task\resources\views/tasks/show.blade.php ENDPATH**/ ?>