<?php $__env->startSection('title','Edit Group'); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/group.css')); ?>?v=<?php echo e(time()); ?>">
<style>
/* Force Select2 to 100% width and align properly */
.select2-container {
    width: 100% !important;
}
.select2-container .select2-selection--single {
    height: 42px !important;
    border-radius: 10px !important;
    border: 1px solid #dbe3ec !important;
    display: flex;
    align-items: center;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: normal !important;
    padding-left: 12px;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 40px !important;
}
</style>
<?php $__env->stopSection(); ?>

<?php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
?>

<?php if($isAdmin || hasPermission('group_edit')): ?>

<?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['title' => 'Group Management','page' => 'Edit Group']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Group Management','page' => 'Edit Group']); ?>
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
<hr>

<div class="row">
<div class="col-md-10 m-auto">

<div class="white_shd full p-4 shadow-sm">

<h4 class="mb-3">
<i class="fa fa-edit text-primary"></i> Edit Group
</h4>

<form method="POST" action="<?php echo e(route('groups.update',$group->id)); ?>">
<?php echo csrf_field(); ?>
<?php echo method_field('PUT'); ?>

<!-- GROUP NAME -->
<div class="mb-3">
<label>Group Name</label>

<input type="text"
name="group_name"
value="<?php echo e(old('group_name',$group->group_name)); ?>"
class="form-control <?php $__errorArgs = ['group_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

<?php $__errorArgs = ['group_name'];
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

<!-- LOCATION -->
<div class="mb-3">
<label>Select Location</label>

<select name="location_id"
id="location_id"
class="form-control custom-select2 <?php $__errorArgs = ['location_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

<option value="">Select Location</option>

<?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<option value="<?php echo e($location->id); ?>"
<?php echo e($group->location_id == $location->id ? 'selected' : ''); ?>>
<?php echo e($location->name); ?>

</option>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</select>

<?php $__errorArgs = ['location_id'];
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

<!-- DEPARTMENT -->
<div class="mb-3" id="department_div">
<label>Select Department (Optional)</label>

<select name="department_id"
id="department_id"
class="form-control custom-select2 <?php $__errorArgs = ['department_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

<option value="">Select Department (Optional)</option>

<?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<option value="<?php echo e($department->id); ?>"
<?php echo e($group->department_id == $department->id ? 'selected' : ''); ?>>
<?php echo e($department->dept_name); ?>

</option>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</select>

<?php $__errorArgs = ['department_id'];
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

<!-- EMPLOYEE -->
<div class="mb-3" id="employee_div">
<label>Select Employees</label>

<select name="employees[]"
id="employees"
multiple
class="form-control select2 <?php $__errorArgs = ['employees'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

<?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<option value="<?php echo e($emp->id); ?>"
<?php echo e(in_array($emp->id,$group->employees->pluck('id')->toArray()) ? 'selected' : ''); ?>>
<?php echo e($emp->user->name); ?>

</option>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</select>

<?php $__errorArgs = ['employees'];
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

<div class="text-end">

<a href="<?php echo e(route('groups.index')); ?>"
class="btn btn-light border btn-sm">
Cancel
</a>

<button class="btn btn-primary btn-sm">
Update Group
</button>

</div>

</form>

</div>
</div>
</div>

<?php else: ?>

<div class="alert alert-danger">
    You do not have permission to edit group.
</div>

<?php endif; ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>

<script>
$(document).ready(function(){

// Initialize custom select2 for single dropdowns to avoid master.blade.php global placeholder
$('.custom-select2').select2({
    width: '100%'
});

// Fetch employees function
function fetchEmployees(locationId, departmentId) {
    $('#employees').html('<option>Loading...</option>');
    if (locationId != '') {
        $('#employee_div').show();
        let dep = departmentId ? departmentId : 'all';
        $.ajax({
            url: "/groups/get-employees/" + locationId + "/" + dep,
            type: "GET",
            success: function(response) {
                let html = '';
                if (response.length > 0) {
                    // We need to keep the currently selected employees selected if we fetch anew, 
                    // but usually in edit they just use select2 normally. 
                    // Since it's AJAX fetching, we overwrite options.
                    $.each(response, function(key, row) {
                        html += '<option value="' + row.id + '">' + row.user.name + '</option>';
                    });
                } else {
                    html = '<option value="">No Employee Found</option>';
                }
                $('#employees').html(html).trigger('change');
            }
        });
    } else {
        $('#employee_div').hide();
        $('#employees').trigger('change');
    }
}

// LOCATION CHANGE
$('#location_id').change(function(){

let locationId = $(this).val();

$('#department_id').html('<option>Loading...</option>').trigger('change');
$('#employees').html('').trigger('change');
$('#employee_div').hide();

if(locationId != '')
{
    $('#employee_div').show();
    $.ajax({
    url: "/groups/get-departments/" + locationId,
    type: "GET",

    success:function(response)
    {
    let html = '<option value="">Select Department (Optional)</option>';

    $.each(response,function(key,row){
    html += '<option value="'+row.id+'">'+row.dept_name+'</option>';
    });

    $('#department_id').html(html).trigger('change');
    }
    });
    
    // Fetch Employees for Location
    fetchEmployees(locationId, '');
}
});


// DEPARTMENT CHANGE
$('#department_id').change(function(){

let departmentId = $(this).val();
let locationId   = $('#location_id').val();

fetchEmployees(locationId, departmentId);

});

});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\vac-barcode-task\resources\views/groups/edit.blade.php ENDPATH**/ ?>