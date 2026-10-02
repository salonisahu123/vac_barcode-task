

<?php $__env->startSection('title','Assign Permissions'); ?>
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/role-permission.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
?>

<?php if($isAdmin || hasPermission('role_permission_add')): ?>

<div class="permission-card">

<div class="page-title">Assign Permissions</div>

<form method="POST" action="<?php echo e(route('roles_permissions.store')); ?>">
<?php echo csrf_field(); ?>


<div class="role-box mb-3">
    <label>Select Role</label>

    <select name="role_id" class="form-control">
        <option value="">Select Role</option>
        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($role->id); ?>"><?php echo e($role->name); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <?php $__errorArgs = ['role_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="role-error"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>


<table class="permission-table">

<thead>
<tr>
    <th style="width:200px;">Module</th>
    <th>Permissions</th>
</tr>
</thead>

<tbody>

<?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<tr>

<td>
    <div class="module-name"><?php echo e($module); ?></div>
</td>

<td>

    
    <div class="perm-grid">

        <?php $__currentLoopData = $items->pluck('action')->unique(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <?php
                $perm = $items->firstWhere('action', $action);
            ?>

            <?php if($perm && !($action == 'delete' && Auth::id() != 1)): ?>
            <div class="perm-item">

                <span><?php echo e(ucfirst($action)); ?></span>

                <label class="switch">
                    <input type="checkbox"
                           name="permissions[]"
                           value="<?php echo e($perm->id); ?>">
                    <span class="slider"></span>
                </label>

            </div>
            <?php endif; ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>

</td>

</tr>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</tbody>

</table>

<button class="save-btn">Save Permissions</button>

</form>

</div>

<?php else: ?>
<div class="alert alert-danger">
    You do not have permission to access this page.
</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\vac-barcode-task\resources\views/role_and_permission/assign.blade.php ENDPATH**/ ?>