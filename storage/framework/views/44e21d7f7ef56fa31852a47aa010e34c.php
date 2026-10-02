

<?php $__env->startSection('title','Edit Employee'); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/employee.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
?>

<?php if($isAdmin || hasPermission('employee_edit')): ?>

<?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['title' => 'Employee','page' => 'Edit Employee']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Employee','page' => 'Edit Employee']); ?>
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
<div class="col-md-12">
<div class="main-card">

<!-- HEADER -->
<div class="form-header mb-2">
    <h4><i class="fa fa-user-edit me-1"></i> Edit Employee</h4>
    <small>Update employee details carefully</small>
</div>

<div class="section-line"></div>

<!-- FORM -->
<form method="POST"
      enctype="multipart/form-data"
      action="<?php echo e(route('employees.update',$employee->id)); ?>">

<?php echo csrf_field(); ?>
<?php echo method_field('PUT'); ?>

<div class="row">

<!-- NAME -->
<div class="col-md-4 form-group mb-3">
<label class="form-label">Name</label>

<input type="text"
       name="name"
       value="<?php echo e(old('name',$employee->user->name)); ?>"
       class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

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

<!-- EMAIL -->
<div class="col-md-4 form-group mb-3">
<label class="form-label">Email</label>

<input type="email"
       name="email"
       value="<?php echo e(old('email',$employee->user->email)); ?>"
       class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

<?php $__errorArgs = ['email'];
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

<!-- MOBILE -->
<div class="col-md-4 form-group mb-3">
<label class="form-label">Mobile</label>

<input type="text"
       name="mobile"
       value="<?php echo e(old('mobile',$employee->user->mobile)); ?>"
       class="form-control <?php $__errorArgs = ['mobile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

<?php $__errorArgs = ['mobile'];
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

<!-- PASSWORD -->
<div class="col-md-4 form-group mb-3">
<label class="form-label">Password</label>

<div class="position-relative">

<input type="password"
       name="password"
       id="password"
       placeholder="Leave blank to keep old password"
       class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

<span onclick="togglePassword()" class="eye-icon">
<i class="fa fa-eye" id="eyeIcon"></i>
</span>

</div>

<?php $__errorArgs = ['password'];
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
<div class="col-md-4 form-group mb-3">
<label class="form-label">Location</label>

<select name="location_id"
        id="location_id"
        class="form-control <?php $__errorArgs = ['location_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

<option value="">Select Location</option>

<?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<option value="<?php echo e($loc->id); ?>"
<?php echo e(old('location_id',$employee->location_id) == $loc->id ? 'selected' : ''); ?>>
<?php echo e($loc->name); ?>

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
<div class="col-md-4 form-group mb-3">
<label class="form-label">Department</label>

<select name="department_id"
        id="department_id"
        class="form-control <?php $__errorArgs = ['department_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

<option value="">Loading...</option>

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

<!-- ROLE -->
<div class="col-md-4 form-group mb-3">
<label class="form-label">Role</label>

<select name="role_id"
        class="form-control <?php $__errorArgs = ['role_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

<option value="">Select Role</option>

<?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<option value="<?php echo e($role->id); ?>"
<?php echo e(old('role_id',$employee->role_id) == $role->id ? 'selected' : ''); ?>>
<?php echo e($role->name); ?>

</option>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</select>

<?php $__errorArgs = ['role_id'];
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

<!-- GENDER -->
<div class="col-md-4 form-group mb-3">
<label class="form-label">Gender</label>

<select name="gender"
class="form-control <?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

<option value="">Select Gender</option>

<option value="male"
<?php echo e(old('gender',$employee->gender)=='male' ? 'selected' : ''); ?>>
Male
</option>

<option value="female"
<?php echo e(old('gender',$employee->gender)=='female' ? 'selected' : ''); ?>>
Female
</option>

<option value="other"
<?php echo e(old('gender',$employee->gender)=='other' ? 'selected' : ''); ?>>
Other
</option>

</select>

<?php $__errorArgs = ['gender'];
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

<!-- IS ACTIVE -->
<div class="col-md-4 form-group mb-3">
    <label class="form-label d-block" style="opacity: 0; pointer-events: none;">Status</label>
    <div class="form-check d-flex align-items-center h-100" style="min-height: 44px; margin-top: -10px;">
        <input class="form-check-input mt-0 me-2" type="checkbox" name="is_active" id="is_active" value="1" <?php echo e(old('is_active', $employee->user->is_active) ? 'checked' : ''); ?> style="width: 20px; height: 20px; cursor: pointer;">
        <label class="form-check-label mb-0" for="is_active" style="cursor: pointer; padding-top: 2px; font-weight: 500; color: #475569;">
            Active Employee
        </label>
    </div>
</div>

<!-- CUSTOM DASHBOARD -->
<div class="col-md-4 form-group mb-3">

    <label class="form-label">Custom Dashboard</label>

    <select name="dashboard_ids[]" class="form-control choices" multiple>

        <?php $__currentLoopData = $customdashboards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customdashboard): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <option value="<?php echo e($customdashboard->id); ?>"
                <?php echo e(in_array($customdashboard->id, $assignedDashboards ?? []) ? 'selected' : ''); ?>>

                <?php echo e($customdashboard->dash_name); ?>


            </option>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </select>

    <?php $__errorArgs = ['dashboard_ids'];
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

<!-- JOINING DATE -->
<div class="col-md-4 form-group mb-3">
<label class="form-label">Joining Date</label>

<input type="date"
       name="joining_date"
       value="<?php echo e(old('joining_date',$employee->joining_date)); ?>"
       class="form-control <?php $__errorArgs = ['joining_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

<?php $__errorArgs = ['joining_date'];
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

<!-- IMAGE -->
<div class="col-md-4 form-group mb-3">
<label class="form-label">Image</label>

<input type="file"
       name="image"
       class="form-control <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
       onchange="previewImage(event)">

<?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
<small class="text-danger"><?php echo e($message); ?></small>
<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

<img id="previewImg"
     class="preview-img mt-2"
     src="<?php echo e($employee->image ? asset('uploads/employees/'.$employee->image) : ''); ?>"
     style="<?php echo e($employee->image ? 'display:block;width:80px;' : 'display:none;width:80px;'); ?>">
</div>

<!-- ADDRESS -->
<div class="col-md-12 form-group mb-3">
<label class="form-label">Address</label>

<textarea name="address"
          rows="3"
          class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('address',$employee->user->address)); ?></textarea>

<?php $__errorArgs = ['address'];
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

</div>

<div class="section-line"></div>

<!-- BUTTON -->
<div class="button-group">

<a href="<?php echo e(route('employees.index')); ?>"
class="btn btn-light border btn-sm">
Cancel
</a>

<button class="btn btn-primary btn-sm">
<i class="fa fa-save me-1"></i> Update Employee
</button>

</div>

</form>

</div>
</div>
</div>

<?php else: ?>

<div class="alert alert-danger">
    You do not have permission to access this page.
</div>

<?php endif; ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

/* PASSWORD SHOW HIDE */
function togglePassword()
{
    let pass = document.getElementById('password');
    let icon = document.getElementById('eyeIcon');

    if(pass.type === 'password')
    {
        pass.type = 'text';
        icon.classList.replace('fa-eye','fa-eye-slash');
    }
    else
    {
        pass.type = 'password';
        icon.classList.replace('fa-eye-slash','fa-eye');
    }
}

/* IMAGE PREVIEW */
function previewImage(event)
{
    let img = document.getElementById('previewImg');

    img.src = URL.createObjectURL(event.target.files[0]);
    img.style.display = 'block';
}

/* LOCATION WISE DEPARTMENT */
$(document).ready(function () {

    function loadDepartments(locationId, selectedDepartment = '')
    {
        $('#department_id').html('<option>Loading...</option>');

        $.ajax({
            url: "<?php echo e(route('employees.departments','')); ?>/" + locationId,
            type: "GET",

            success:function(response)
            {
                let html = '<option value="">Select Department</option>';

                $.each(response, function(key,row){

                    let selected =
                        selectedDepartment == row.id ? 'selected' : '';

                    html += '<option value="'+row.id+'" '+selected+'>'
                         + row.dept_name +
                         '</option>';
                });

                $('#department_id').html(html);
            },

            error:function(){
                $('#department_id').html(
                    '<option value="">No Department Found</option>'
                );
            }
        });
    }

    $('#location_id').change(function(){

        let locationId = $(this).val();

        if(locationId != '')
        {
            loadDepartments(locationId);
        }
        else
        {
            $('#department_id').html(
                '<option value="">Select Location First</option>'
            );
        }
    });

    let oldLocation =
        "<?php echo e(old('location_id',$employee->location_id)); ?>";

    let oldDepartment =
        "<?php echo e(old('department_id',$employee->department_id)); ?>";

    if(oldLocation != '')
    {
        loadDepartments(oldLocation, oldDepartment);
    }

});

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\vac-barcode-task\resources\views/employees/edit.blade.php ENDPATH**/ ?>