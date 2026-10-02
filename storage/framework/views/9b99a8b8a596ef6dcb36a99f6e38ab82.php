

<?php $__env->startSection('title','Roles'); ?>

<?php $__env->startSection('content'); ?>

<?php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/roles.css')); ?>">
<?php $__env->stopSection(); ?>

<?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['title' => 'Role Management','page' => 'Role']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Role Management','page' => 'Role']); ?>
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

<div class="row">

<!-- ================= LEFT TABLE ================= -->
<div class="col-md-7">

<div class="pro-card">

<div class="section-title">Role List</div>

<div class="table-responsive">

<table class="table">

<thead>
<tr>
    <th>#</th>
    <th>Name</th>
    <th>Action</th>
</tr>
</thead>

<tbody>

<?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>

<td><?php echo e($key+1); ?></td>

<td>
    <span class="pro-badge">
        <?php echo e($role->name); ?>

    </span>
</td>

<td>
<div class="action-group">

<?php if($isAdmin || hasPermission('role_edit')): ?>
<a href="<?php echo e(route('roles.edit',$role->id)); ?>"
   class="icon-btn edit-btn">
   <i class="fa fa-pen"></i>
</a>
<?php endif; ?>

<?php if($isAdmin || hasPermission('role_delete')): ?>
<form action="<?php echo e(route('roles.destroy',$role->id)); ?>"
      method="POST">

<?php echo csrf_field(); ?>
<?php echo method_field('DELETE'); ?>

<button type="button"
        class="icon-btn delete-btn delete-btn-action">
    <i class="fa fa-trash"></i>
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


<!-- ================= RIGHT FORM ================= -->
<?php if(
    $isAdmin ||
    (!isset($editRole) && hasPermission('role_add')) ||
    (isset($editRole) && hasPermission('role_edit'))
): ?>
<div class="col-md-5">

<div class="pro-card">

<div class="section-title">
    <?php echo e(isset($editRole) ? 'Edit Role' : 'Add Role'); ?>

</div>

<form method="POST"
action="<?php echo e(isset($editRole)
    ? route('roles.update',$editRole->id)
    : route('roles.store')); ?>">

<?php echo csrf_field(); ?>

<?php if(isset($editRole)): ?>
    <?php echo method_field('PUT'); ?>
<?php endif; ?>

<div class="mb-3">
<label class="form-label">Role Name</label>

<input type="text"
       name="name"
       class="form-control"
       value="<?php echo e(old('name',$editRole->name ?? '')); ?>">

<?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
<small class="text-danger"><?php echo e($message); ?></small>
<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

</div>

<button class="btn primary-btn w-100">
    <?php echo e(isset($editRole) ? 'Update' : 'Save'); ?>

</button>

</form>

</div>

</div>
<?php endif; ?>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\vac-barcode-task\resources\views/roles/index.blade.php ENDPATH**/ ?>