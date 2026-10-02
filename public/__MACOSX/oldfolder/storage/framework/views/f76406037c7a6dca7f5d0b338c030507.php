

<?php $__env->startSection('title','Group Details'); ?>

<?php $__env->startSection('content'); ?>

<?php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
?>


<?php if($isAdmin || hasPermission('group_view') || hasPermission('group_view_all') || hasPermission('group_view_own')): ?>

<?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['title' => 'Group Management','page' => 'Group Details']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Group Management','page' => 'Group Details']); ?>
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

<div class="row">
    <div class="col-md-12 m-auto">

        <!-- 🔥 GROUP CARD -->
        <div class="white_shd full p-4 shadow-sm mb-4"
             style="border-radius:10px;">

            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <h4 style="font-weight:600;">
                        <?php echo e($group->group_name); ?>

                    </h4>

                    <small class="text-muted">
                        Total Employees: <?php echo e($group->employees->count()); ?>

                    </small>
                </div>

                <span class="badge bg-dark text-white px-3 py-2">
                    Group Module
                </span>

            </div>

        </div>

        <!-- 🔥 EMPLOYEES LIST -->
        <div class="white_shd full p-4 shadow-sm"
             style="border-radius:10px;">

            <h5 class="mb-3" style="font-weight:600;">
                👥 Group Employees
            </h5>

            <div class="row">

                <?php $__currentLoopData = $group->employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <div class="col-md-6 mb-3">

                    <!-- EMPLOYEE CARD -->
                    <div class="p-3 border rounded shadow-sm h-100"
                         style="background:#fff;">

                        <div class="d-flex align-items-center">

                            <?php
                                $img = (!empty($emp->image))
                                    ? asset('uploads/employees/'.$emp->image)
                                    : asset('uploads/employees/user.png');
                            ?>
                            
                            <!-- IMAGE -->
                            <div class="me-3">
                                <img src="<?php echo e($img); ?>"
                                     style="width:55px;height:55px;border-radius:50%;object-fit:cover;border:2px solid #eee;">
                            </div>

                            <!-- INFO -->
                            <div>

                                <h6 class="mb-1" style="font-weight:600;">
                                    <?php echo e($emp->user->name); ?>

                                </h6>

                                <small class="text-muted">
                                    <?php echo e($emp->user->email); ?>

                                </small>

                            </div>

                        </div>

                        <hr>

                        <!-- DETAILS -->
                        <div class="row" style="font-size:13px;">

                            <div class="col-6 mb-1">
                                <b>📍 Location:</b><br>
                                <span class="text-primary">
                                    <?php echo e($emp->location->name ?? 'N/A'); ?>

                                </span>
                            </div>

                            <div class="col-6 mb-1">
                                <b>🏢 Department:</b><br>
                                <span class="text-success">
                                    <?php echo e($emp->department->dept_name ?? 'N/A'); ?>

                                </span>
                            </div>

                            <div class="col-6 mb-1">
                                <b>🎯 Role:</b><br>
                                <span class="text-warning">
                                    <?php echo e($emp->role->name ?? 'N/A'); ?>

                                </span>
                            </div>

                            <div class="col-6 mb-1">
                                <b>📅 Joining:</b><br>
                                <span class="text-muted">
                                    <?php echo e($emp->joining_date ?? '-'); ?>

                                </span>
                            </div>

                        </div>

                    </div>

                </div>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>

        </div>

    </div>
</div>

<?php else: ?>

<div class="alert alert-danger">
    You do not have permission to view group details.
</div>

<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\vac-barcode-task\resources\views/groups/show.blade.php ENDPATH**/ ?>