

<?php $__env->startSection('title','Employee Details'); ?>

<?php $__env->startSection('content'); ?>

<?php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
?>

<?php if($isAdmin || hasPermission('employee_view') || hasPermission('employee_view_all') || hasPermission('employee_view_own')): ?>

<?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['title' => 'Employee Management','page' => 'Employee Details']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Employee Management','page' => 'Employee Details']); ?>
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

<div class="mt-3"></div>

<div class="row justify-content-center">

    <div class="col-md-10">

        <div class="white_shd full p-4 shadow-sm rounded">

            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>
                    <h4 class="mb-1" style="font-weight:600;">
                        <i class="fa fa-user text-primary me-2"></i>
                        <?php echo e($employee->user->name); ?>

                    </h4>
                    <small class="text-muted">Employee Profile Details</small>
                </div>

                <a href="<?php echo e(route('employees.index')); ?>"
                   class="btn btn-light btn-sm border">
                    ← Back
                </a>

            </div>

            <div class="row">

                <!-- LEFT SIDE (IMAGE CARD) -->
                <div class="col-md-4 mb-3">

                    <div class="text-center p-3 border rounded shadow-sm">

                        <?php if($employee->image): ?>
                            <img src="<?php echo e(asset('uploads/employees/'.$employee->image)); ?>"
                                 class="rounded-circle shadow-sm"
                                 width="120" height="120"
                                 style="object-fit:cover;">
                        <?php else: ?>
                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto"
                                 style="width:120px;height:120px;">
                                <i class="fa fa-user fa-2x text-secondary"></i>
                            </div>
                        <?php endif; ?>

                        <h5 class="mt-3 mb-0"><?php echo e($employee->user->name); ?></h5>
                        <small class="text-muted"><?php echo e($employee->department->dept_name); ?></small>

                    </div>

                </div>

                <!-- RIGHT SIDE (DETAILS) -->
                <div class="col-md-8">

                    <div class="card border-0 shadow-sm">

                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label class="text-muted">Email</label>
                                    <h6><?php echo e($employee->user->email); ?></h6>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="text-muted">Mobile</label>
                                    <h6><?php echo e($employee->user->mobile ?? '-'); ?></h6>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="text-muted">Location</label>
                                    <span class="badge px-3 py-2"
                                    style="background: linear-gradient(135deg,#17a2b8,#0dcaf0);
                                            color:#fff;
                                            border-radius:50px;
                                            font-weight:500;
                                            box-shadow:0 3px 10px rgba(23,162,184,0.25);">
                                    <?php echo e($employee->location->name); ?>

                                </span>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="text-muted">Department</label>
                                    <span class="badge px-3 py-2"
                                    style="background: linear-gradient(135deg,#6f42c1,#9b59b6);
                                            color:#fff;
                                            border-radius:50px;
                                            font-weight:500;
                                            box-shadow:0 3px 10px rgba(111,66,193,0.25);">
                                    <?php echo e($employee->department->dept_name); ?>

                                </span>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="text-muted">Gender</label>
                                    <h6 class="text-capitalize"><?php echo e($employee->gender); ?></h6>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="text-muted">Joining Date</label>
                                    <h6><?php echo e($employee->joining_date); ?></h6>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="text-muted">Address</label>
                                    <h6><?php echo e($employee->user->address ?? '-'); ?></h6>
                                </div>
                                
                                <div class="col-md-12 mb-3">

                                    <label class="text-muted">Custom Dashboards</label>
                                
                                    <div class="mt-2">
                                
                                        <?php $__empty_1 = true; $__currentLoopData = $dashboards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dash): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                
                                            <span class="badge px-3 py-2 me-1 mb-1"
                                                style="background: linear-gradient(135deg,#28a745,#20c997);
                                                       color:#fff;
                                                       border-radius:50px;
                                                       font-weight:500;
                                                       box-shadow:0 3px 10px rgba(40,167,69,0.25);">
                                
                                                <?php echo e(str_replace('_', ' ', $dash->dash_name)); ?>

                                
                                            </span>
                                
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                
                                            <span class="text-muted">No Dashboard Assigned</span>
                                
                                        <?php endif; ?>
                                
                                    </div>
                                
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php else: ?>

<div class="alert alert-danger">
    You do not have permission to view this employee details.
</div>

<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\vac-barcode-task\resources\views/employees/show.blade.php ENDPATH**/ ?>