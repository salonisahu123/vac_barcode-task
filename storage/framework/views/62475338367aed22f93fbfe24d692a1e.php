

<?php $__env->startSection('title', 'Subtasks'); ?>

<?php $__env->startSection('content'); ?>

<?php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/location.css')); ?>">
<?php $__env->stopSection(); ?>

<?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['title' => 'Subtask Management','page' => 'Subtask']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Subtask Management','page' => 'Subtask']); ?>
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

<div class="section-title">Subtask List</div>

<div class="table-responsive">

<table class="table table-bordered">

<thead>
<tr>
    <th>#</th>
    <th>Subtask Name</th>
    <th>Created By</th>
    <th>Action</th>
</tr>
</thead>

<tbody>

<?php $__currentLoopData = $subtasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $subtask): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>

<td><?php echo e($key + 1); ?></td>

<td>
    <span class="pro-badge">
        <?php echo e($subtask->subtask); ?>

    </span>
</td>

<td>
    <?php echo e($subtask->user->name ?? 'Admin'); ?>

</td>

<td>
<div class="action-group">

<a href="<?php echo e(route('subtasks.edit', $subtask->id)); ?>"
   class="icon-btn edit-btn">
    <i class="fa-solid fa-pen"></i>
</a>

<form action="<?php echo e(route('subtasks.destroy', $subtask->id)); ?>"
      method="POST"
      class="delete-form">

    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>

    <button type="button" class="icon-btn delete-btn">
        <i class="fa fa-trash"></i>
    </button>

</form>

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
<div class="col-md-5">

<div class="pro-card">

<div class="section-title">
    <?php echo e(isset($editSubtask) ? 'Edit Subtask' : 'Add Subtask'); ?>

</div>

<form method="POST"
action="<?php echo e(isset($editSubtask)
    ? route('subtasks.update', $editSubtask->id)
    : route('subtasks.store')); ?>">

<?php echo csrf_field(); ?>

<?php if(isset($editSubtask)): ?>
    <?php echo method_field('PUT'); ?>
<?php endif; ?>

<div class="mb-3">

    <label class="form-label">Subtask Name</label>

    <input type="text"
           name="subtask"
           class="form-control <?php $__errorArgs = ['subtask'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
           placeholder="Enter Subtask name"
           value="<?php echo e(old('subtask', $editSubtask->subtask ?? '')); ?>">

    <?php $__errorArgs = ['subtask'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <small class="text-danger d-block mt-1">
            <?php echo e($message); ?>

        </small>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

</div>

<button class="btn primary-btn w-100">
    <?php echo e(isset($editSubtask) ? 'Update' : 'Save'); ?>

</button>

</form>

</div>

</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\vac-barcode-task\resources\views/subtasks/index.blade.php ENDPATH**/ ?>