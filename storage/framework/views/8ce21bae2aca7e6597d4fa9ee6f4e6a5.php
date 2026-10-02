

<?php $__env->startSection('title','Groups'); ?>

<?php $__env->startSection('content'); ?>

<?php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/group.css')); ?>">
<?php $__env->stopSection(); ?>

<?php if($isAdmin || hasPermission('group_view_all') || hasPermission('group_view_own')): ?>

<?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['title' => 'Group Management','page' => 'Group']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Group Management','page' => 'Group']); ?>
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

<div class="pro-card">

<!-- ===== TOP BAR ===== -->
<div class="top-bar">

<div></div>

<?php if($isAdmin || hasPermission('group_add')): ?>
<a href="<?php echo e(route('groups.create')); ?>" class="create-btn">
    <i class="fa fa-plus"></i>
    Create Group
</a>
<?php endif; ?>

</div>

<!-- ===== TABLE ===== -->
<div class="table-responsive">

<table class="table datatable align-middle" data-table="group">

<thead>
<tr>
    <th>#</th>
    <th>Group Name</th>
    <th>Location</th>
    <th>Department</th>
    <th>Employees</th>
    <th>Created By</th>
    <th>Action</th>
</tr>
</thead>

<tbody>

<?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>

<td><?php echo e($key+1); ?></td>

<td>
    <strong><?php echo e($group->group_name); ?></strong>
</td>

<td>
    <?php echo e($group->location->name ?? 'N/A'); ?>

</td>

<td>
    <?php echo e($group->department->dept_name ?? 'N/A'); ?>

</td>

<td>

<?php
$emps  = $group->employees;
$count = $emps->count();
?>

<div class="d-flex align-items-center">

<?php if($count > 0): ?>

    <?php $__currentLoopData = $emps->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <?php
            $img = (!empty($emp->image))
                ? asset('uploads/employees/'.$emp->image)
                : asset('uploads/employees/user.png');
        ?>

        <img src="<?php echo e($img); ?>"
             title="<?php echo e($emp->user->name); ?>"
             class="rounded-circle border shadow-sm me-n2"
             width="38"
             height="38"
             style="object-fit:cover; cursor:pointer;">

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php if($count > 3): ?>

    <button type="button"
            class="btn btn-primary rounded-circle ms-2 d-flex align-items-center justify-content-center"
            style="width:38px; height:38px; padding:0;"
            onclick="loadGroupEmployees(<?php echo e($group->id); ?>)">

        +<?php echo e($count - 3); ?>


    </button>

    <?php endif; ?>

<?php else: ?>

<span class="badge bg-light text-dark px-3 py-2">
    No Employee
</span>

<?php endif; ?>

</div>

</td>

<td>
    <span style="color:#6b7280;">
        <?php echo e($group->user->name ?? 'N/A'); ?>

    </span>
</td>

<td>
<div class="action-group">

<?php if($isAdmin || hasPermission('group_view_all') || hasPermission('group_view_own')): ?>
<a href="<?php echo e(route('groups.show',$group->id)); ?>"
   class="icon-btn view-btn">
   <i class="fa fa-eye"></i>
</a>
<?php endif; ?>

<?php if($isAdmin || hasPermission('group_edit')): ?>
<a href="<?php echo e(route('groups.edit',$group->id)); ?>"
   class="icon-btn edit-btn">
   <i class="fa fa-pen"></i>
</a>
<?php endif; ?>

<?php if($isAdmin || hasPermission('group_delete')): ?>
<form action="<?php echo e(route('groups.destroy',$group->id)); ?>"
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

<!-- ===== EMPLOYEE MODAL ===== -->
<div class="modal fade" id="employeeModal" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <h5>Group Employees</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="employeeModalBody">
                <p class="text-muted">Loading...</p>
            </div>

        </div>
    </div>
</div>

<?php else: ?>

<div class="alert alert-danger">
    You do not have permission to view groups.
</div>

<?php endif; ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
<script src="<?php echo e(asset('js/group.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\vac-barcode-task\resources\views/groups/index.blade.php ENDPATH**/ ?>