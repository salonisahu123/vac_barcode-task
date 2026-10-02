

<?php $__env->startSection('title','Employees'); ?>

<?php $__env->startSection('content'); ?>

<?php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
?>


<?php if($isAdmin || hasPermission('employee_view_all') || hasPermission('employee_view_own')): ?>

<?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['title' => 'Employee Management','page' => 'Employees']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Employee Management','page' => 'Employees']); ?>
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

            <!-- 🔥 HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-3">

                <div></div>

                
                <?php if($isAdmin || hasPermission('employee_add')): ?>
         <a href="<?php echo e(route('employees.create')); ?>"
   class="btn btn-primary btn-sm d-flex align-items-center"
   style="border-radius:6px; padding:9px 18px; font-size:14px;">
    <i class="fa fa-plus me-1" style="margin-right:8px; font-size:14px;"></i> Add Employee
</a>
                <?php endif; ?>

            </div>

            <!-- TABLE -->
            <div class="table-responsive">

                <table class="table datatable align-middle" data-table="employee">

                    <thead>
                        <tr style="font-size:13px; background:#f8f9fa;">
                            <th>#</th>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Location</th>
                            <th>Department</th>
                            <th width="150">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr style="font-size:13px;">

                            <td><?php echo e($key+1); ?></td>

                            <td>
                                <?php if($emp->image): ?>
                                    <img src="<?php echo e(asset('uploads/employees/'.$emp->image)); ?>"
                                        style="width:40px; height:40px; border-radius:50%; object-fit:cover; border:1px solid #ddd;">
                                <?php else: ?>
                                    <img src="<?php echo e(asset('uploads/employees/user.png')); ?>"
                                        style="width:40px; height:40px; border-radius:50%; object-fit:cover; border:1px solid #ddd;">
                                <?php endif; ?>
                            </td>

                            <td>
                                <span style="font-weight:500;">
                                    <?php echo e($emp->user->name); ?>

                                </span>
                            </td>

                            <td style="color:#6c757d;">
                                <?php echo e($emp->user->email); ?>

                            </td>
                            
                            <td>
                                <span class="badge"
                                      style="background:#e7f1ff; color:#0d6efd; font-weight:500;">
                                    <?php echo e($emp->role->name ?? 'N/A'); ?>

                                </span>
                            </td>

                            <td>
                                <span class="badge"
                                      style="background:#e7f1ff; color:#0d6efd; font-weight:500;">
                                    <?php echo e($emp->location->name); ?>

                                </span>
                            </td>

                            <td>
                                <span class="badge"
                                      style="background:#eef2ff; color:#4338ca; font-weight:500;">
                                    <?php echo e($emp->department->dept_name); ?>

                                </span>
                            </td>

                            <td>
                                <div class="d-flex gap-1">

                                    
                                    <?php if($isAdmin || hasPermission('employee_view_all') || hasPermission('employee_view_own')): ?>
                                    <a href="<?php echo e(route('employees.show',$emp->id)); ?>"
                                       class="btn btn-light btn-sm border"
                                       title="View">
                                       <i class="fa fa-eye text-info"></i>
                                    </a>
                                    <?php endif; ?>

                                    
                                    <?php if($isAdmin || hasPermission('employee_edit')): ?>
                                    <a href="<?php echo e(route('employees.edit',$emp->id)); ?>"
                                       class="btn btn-light btn-sm border"
                                       title="Edit">
                                       <i class="fa fa-edit text-warning"></i>
                                    </a>
                                    <?php endif; ?>

                                    
                                    <?php if($isAdmin || hasPermission('employee_delete')): ?>
                                    <form action="<?php echo e(route('employees.destroy',$emp->id)); ?>"
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
    You do not have permission to view employees list.
</div>

<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\vac-barcode-task\resources\views/employees/index.blade.php ENDPATH**/ ?>