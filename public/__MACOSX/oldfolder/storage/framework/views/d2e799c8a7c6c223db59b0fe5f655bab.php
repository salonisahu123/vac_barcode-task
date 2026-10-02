

<?php $__env->startSection('title','Role & Permission'); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/role-permission.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
?>

<?php if($isAdmin || hasPermission('role_permission_view_own') || hasPermission('role_permission_view_all') || hasPermission('role_permission_add') || hasPermission('role_permission_edit') || hasPermission('role_permission_delete')): ?>

<?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['title' => 'Role Management','page' => 'Role & Permissions']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Role Management','page' => 'Role & Permissions']); ?>
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

<div class="mt-2"></div>

<div class="row">
    <div class="col-md-12">

        <div class="white_shd full margin_bottom_30 p-3 shadow-sm">

            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-3">

                <div></div>

                <?php if($isAdmin || hasPermission('role_permission_add')): ?>
                <a href="<?php echo e(route('roles_permissions.assign')); ?>"
                   class="btn btn-primary btn-sm d-flex align-items-center"
                   style="border-radius:6px;">
                    <i class="fa fa-plus me-1"></i> Assign Permission
                </a>
                <?php endif; ?>

            </div>

            <!-- TABLE -->
            <div class="table-responsive">

                <table class="table table-bordered align-middle">

                    <thead>
                        <tr style="font-size:13px; background:#f8f9fa;">
                            <th>#</th>
                            <th>Role</th>
                            <th width="150">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr style="font-size:13px;">

                            <td><?php echo e($key+1); ?></td>

                            <td>
                                <span style="font-weight:500;">
                                    <?php echo e($role->name); ?>

                                </span>
                            </td>

                            <td>
                                <div class="d-flex gap-1">

                                    
                                    <?php if($isAdmin || hasPermission('role_permission_view_own') || hasPermission('role_permission_view_all')): ?>
                                    <a href="<?php echo e(route('roles_permissions.show',$role->id)); ?>"
                                       class="btn btn-light btn-sm border"
                                       title="View">
                                        <i class="fa fa-eye text-info"></i>
                                    </a>
                                    <?php endif; ?>

                                    
                                    <?php if($isAdmin || hasPermission('role_permission_edit')): ?>
                                    <a href="<?php echo e(route('roles_permissions.edit',$role->id)); ?>"
                                       class="btn btn-light btn-sm border"
                                       title="Edit">
                                        <i class="fa fa-edit text-warning"></i>
                                    </a>
                                    <?php endif; ?>

                                    
                                    <?php if($isAdmin || hasPermission('role_permission_delete')): ?>
                                    <form action="<?php echo e(route('roles_permissions.destroy',$role->id)); ?>"
                                          method="POST"
                                          class="delete-form">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>

                                        <button type="button"
                                                class="btn btn-light btn-sm border delete-btn"
                                                title="Delete">
                                            <i class="fa fa-trash text-danger"></i>
                                        </button>
                                    </form>
                                    <?php endif; ?>

                                </div>
                            </td>

                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>
</div>

<?php else: ?>

<div class="alert alert-danger">
    You do not have permission to access this page.
</div>

<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\vac-barcode-task\resources\views/role_and_permission/index.blade.php ENDPATH**/ ?>