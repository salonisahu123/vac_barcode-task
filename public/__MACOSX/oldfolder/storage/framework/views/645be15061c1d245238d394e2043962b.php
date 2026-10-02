

<?php $__env->startSection('title','Edit Permissions'); ?>
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/role-permission.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
?>

<?php if($isAdmin || hasPermission('role_permission_edit')): ?>

<div class="permission-card">

<div class="d-flex justify-content-between align-items-center">
    <div class="page-title">Edit Permissions</div>

    <a href="<?php echo e(route('roles_permissions.index')); ?>" class="btn btn-secondary btn-sm">
        Back
    </a>
</div>

<form method="POST" action="<?php echo e(route('roles_permissions.update', $role->id)); ?>">
<?php echo csrf_field(); ?>
<?php echo method_field('PUT'); ?>


<div class="role-box mb-3">
    <label>Role</label>

    <select name="role_id" class="form-control">
    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($r->id); ?>" 
            <?php echo e($r->id == $role->id ? 'selected' : ''); ?>>
            <?php echo e($r->name); ?>

        </option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
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
<td><div class="module-name"><?php echo e($module); ?></div></td>

<td>
<div class="perm-grid">

<?php $__currentLoopData = $items->pluck('action')->unique(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<?php $perm = $items->firstWhere('action',$action); ?>

<?php if($perm && !($action == 'delete' && Auth::id() != 1)): ?>
<div class="perm-item">

<span><?php echo e(ucfirst($action)); ?></span>

<label class="switch">
    <input type="checkbox"
           name="permissions[]"
           value="<?php echo e($perm->id); ?>"
           <?php echo e(in_array($perm->id,$assigned) ? 'checked' : ''); ?>>
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

<button class="save-btn">Update Permissions</button>

</form>

</div>

<?php else: ?>
<div class="alert alert-danger">
    You do not have permission to access this page.
</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\vac-barcode-task\resources\views/role_and_permission/edit.blade.php ENDPATH**/ ?>