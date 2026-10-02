

<?php $__env->startSection('title','Custom Dashboards'); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/custom_dash.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
?>


<?php if($isAdmin || hasPermission('dashboard_view_all') || hasPermission('dashboard_view_own')): ?>

<?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['title' => 'Custom Dashboards Management','page' => 'Custom dashboard']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Custom Dashboards Management','page' => 'Custom dashboard']); ?>
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

<div class="container-fluid">

    <div class="dashboard-list-card">

        
        <div class="dashboard-header">

            <div class="dashboard-title">
                Custom Dashboards
            </div>

            
            <?php if($isAdmin || hasPermission('dashboard_view_all')): ?>
            <a href="<?php echo e(route('custom-dashboards.create')); ?>" class="add-btn">
                <i class="fa fa-plus me-1"></i>
                Create Dashboard
            </a>
            <?php endif; ?>

        </div>

        
        <div class="table-responsive">

            <table class="dashboard-table">

                <thead>

                    <tr>
                        <th>#</th>
                        <th>Dashboard Name</th>
                        <th>Created By</th>
                        <th>Created Date</th>
                        <th>Action</th>
                    </tr>

                </thead>

                <tbody>

                    <?php $__empty_1 = true; $__currentLoopData = $dashboards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $dashboard): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                    <tr>

                        <td><?php echo e($key + 1); ?></td>

                        <td>
                            <div class="dashboard-name">
                                <?php echo e($dashboard->dash_name); ?>

                            </div>
                        </td>

                        <td>
                            <?php echo e($dashboard->user->name ?? '-'); ?>

                        </td>

                        <td>
                            <?php echo e($dashboard->created_at->format('d M Y')); ?>

                        </td>

                        <td>

                            <div class="action-box">

                                
                                <?php if($isAdmin || hasPermission('dashboard_view_all') || hasPermission('dashboard_view_own')): ?>
                                <a href="<?php echo e(route('custom-dashboards.show', $dashboard->id)); ?>"
                                   class="icon-btn">
                                    <i class="fa fa-eye text-info"></i>
                                </a>

                                
                                <a href="<?php echo e(route('custom-dashboards.edit', $dashboard->id)); ?>"
                                   class="icon-btn">
                                    <i class="fa fa-edit edit-icon"></i>
                                </a>
                                
                                
                                <form action="<?php echo e(route('custom-dashboards.destroy', $dashboard->id)); ?>"
                                      method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>

                                    <button type="submit"
                                            class="icon-btn"
                                            onclick="return confirm('Delete this dashboard?')">
                                        <i class="fa fa-trash delete-icon"></i>
                                    </button>

                                </form>
                                <?php endif; ?>

                            </div>

                        </td>

                    </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                    <tr>
                        <td colspan="5">
                            <div class="empty-data">
                                No Custom Dashboard Found
                            </div>
                        </td>
                    </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php else: ?>

<div class="alert alert-danger">
    You do not have permission to view dashboards.
</div>

<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\vac-barcode-task\resources\views/custom-dashboard/index.blade.php ENDPATH**/ ?>