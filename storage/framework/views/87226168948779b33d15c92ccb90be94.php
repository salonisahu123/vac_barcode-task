

<?php $__env->startSection('title','Create Task'); ?>

<?php $__env->startSection('css'); ?>
<!-- ADD -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<link rel="stylesheet" href="<?php echo e(asset('css/task.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
?>


<?php if($isAdmin || hasPermission('task_add')): ?>


<?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['title' => 'Task Management','page' => 'Create Task']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Task Management','page' => 'Create Task']); ?>
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
<div class="col-md-12">

<div class="main-card">

<form method="POST" action="<?php echo e(route('tasks.store')); ?>" enctype="multipart/form-data">
<?php echo csrf_field(); ?>

<div class="dynamic-grid">

    
    <div class="field-box" id="box_title">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" placeholder="Enter title" value="<?php echo e(old('title')); ?>">
        <?php $__errorArgs = ['title'];
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

    
    <div class="field-box" id="box_task_type">
        <label class="form-label">Task Type</label>
        <select name="task_type" id="task_type" class="form-control">
            <option value="">Select</option>
            <option value="individual" <?php echo e(old('task_type')=='individual'?'selected':''); ?>>Individual</option>
            <option value="location" <?php echo e(old('task_type')=='location'?'selected':''); ?>>Location</option>
        </select>

        <?php $__errorArgs = ['task_type'];
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


    
    <div class="field-box d-none" id="individual_box">
        <label class="form-label">Employees</label>
       <select name="assigned_to[]" class="form-control choices" multiple>
        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($emp->id); ?>"
        <?php echo e(collect(old('assigned_to'))->contains($emp->id) ? 'selected' : ''); ?>>
        <?php echo e($emp->user->name); ?>

        </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <?php $__errorArgs = ['assigned_to'];
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

    
    <div class="field-box d-none" id="location_box">
        <label class="form-label">Mode</label>

        <select id="mode" name="mode" class="form-control">
            <option value="">Select</option>
            <option value="location_wise" <?php echo e(old('mode')=='location_wise' ? 'selected' : ''); ?>>Location Wise</option>
            <option value="group_team" <?php echo e(old('mode')=='group_team' ? 'selected' : ''); ?>>Group / Team</option>
        </select>

        <?php $__errorArgs = ['mode'];
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

   
<div class="field-box d-none" id="location_select_box">
    <label class="form-label">Location</label>

    <select id="location_select" name="location_id" class="form-control choices">
        <option value="">Select</option>
        <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($loc->id); ?>"
                <?php echo e(old('location_id') == $loc->id ? 'selected' : ''); ?>>
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



<div class="field-box d-none" id="group_box">
    <label class="form-label">Group / Team</label>

    <select name="group_id" class="form-control choices">
        <option value="">Select</option>
        <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($group->id); ?>"
                <?php echo e(old('group_id') == $group->id ? 'selected' : ''); ?>>
                <?php echo e($group->group_name); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <?php $__errorArgs = ['group_id'];
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

     
<div class="field-box d-none" id="location_employee_box">
    <label class="form-label">Employees</label>

    <select name="assigned_to[]" id="location_employees" class="form-control choices" multiple></select>

    <?php $__errorArgs = ['assigned_to'];
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

    
<div class="field-box" id="box_subtask">
    <label class="form-label">Sub Task</label>

    <select name="subtask_id" id="subtask_id" class="form-control">
        <option value="">Select Sub Task</option>

        <?php $__currentLoopData = $subtask; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($item->id); ?>"
                <?php echo e(old('subtask_id') == $item->id ? 'selected' : ''); ?>>
                <?php echo e($item->subtask); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <?php $__errorArgs = ['subtask_id'];
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

      
  <div class="field-box" id="box_status">
    <label class="form-label">Status</label>

    <input type="text" class="form-control" value="Pending" readonly>

    <!-- hidden for submit -->
    <input type="hidden" name="status" value="pending">
</div>

   

    
    <div class="field-box">
        <label class="form-label">From Date</label>
        <input type="date" name="from_date" class="form-control">
        <?php $__errorArgs = ['from_date'];
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

    
    <div class="field-box">
        <label class="form-label">To Date</label>
        <input type="date" name="to_date" class="form-control">
        <?php $__errorArgs = ['to_date'];
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

    
    <div class="field-box">
        <label class="form-label">File</label>
        <input type="file" name="file" class="form-control">
    </div>

    
    <div class="field-box" style="width:100%;">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control"></textarea>
    </div>
    
  

</div>

<div class="mt-3">
    <button type="submit" class="btn btn-save">Save Task</button>
</div>

</form>

</div>
</div>
</div>

<?php else: ?>

<div class="alert alert-danger">
    You do not have permission to create tasks.
</div>

<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

let employeeChoice; 

$(document).ready(function(){

    // ✅ DataTable safe init
    if ($.fn.DataTable) {
        $('#table').DataTable();
    }

    // ✅ Init Choices (EXCEPT dynamic employee)
    document.querySelectorAll('.choices').forEach(function(el){
        if(el.id !== 'location_employees'){
            new Choices(el, {
                removeItemButton: true,
                searchEnabled: true,
                shouldSort: false,
                itemSelectText: ''
            });
        }
    });

    // ✅ Init dynamic employee dropdown separately
    employeeChoice = new Choices('#location_employees', {
        removeItemButton: true,
        searchEnabled: true,
        shouldSort: false,
        itemSelectText: ''
    });

    // ================= RESET =================
    function resetAll(){
        $('#individual_box').addClass('d-none');
        $('#location_box').addClass('d-none');
        $('#location_select_box').addClass('d-none');
        $('#location_employee_box').addClass('d-none');
        $('#group_box').addClass('d-none');
    }

    // ================= TASK TYPE =================
    $('#task_type').change(function(){

        resetAll();

        let type = $(this).val();

        if(type == 'individual'){
            $('#individual_box').removeClass('d-none');
        }

        if(type == 'location'){
            $('#location_box').removeClass('d-none');
        }
    });

    // ================= MODE =================
    $('#mode').change(function(){

        $('#location_select_box').addClass('d-none');
        $('#location_employee_box').addClass('d-none');
        $('#group_box').addClass('d-none');

        let mode = $(this).val();

        if(mode == 'location_wise'){
            $('#location_select_box').removeClass('d-none');
        }

        if(mode == 'group_team'){
            $('#group_box').removeClass('d-none');
        }
    });

    // ================= LOCATION CHANGE (🔥 FIXED) =================
    $('#location_select').change(function(){

        let locationId = $(this).val();
        let data = [];

        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            if("<?php echo e($emp->location_id); ?>" == locationId){
                data.push({
                    value: "<?php echo e($emp->id); ?>",
                    label: "<?php echo e($emp->user->name); ?>"
                });
            }
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        // 🔥 clear + set choices (IMPORTANT)
        employeeChoice.clearChoices();
        employeeChoice.setChoices(data, 'value', 'label', true);

        // show/hide
        if(locationId != ''){
            $('#location_employee_box').removeClass('d-none');
        }else{
            $('#location_employee_box').addClass('d-none');
        }

    });

    // ================= OLD VALUE RESTORE =================
    let oldTaskType = "<?php echo e(old('task_type')); ?>";
    let oldMode     = "<?php echo e(old('mode')); ?>";
    let oldLocation = "<?php echo e(old('location_id')); ?>";

    if(oldTaskType){
        $('#task_type').val(oldTaskType).trigger('change');
    }

    if(oldMode){
        $('#mode').val(oldMode).trigger('change');
    }

    if(oldLocation){
        $('#location_select').val(oldLocation).trigger('change');
    }

});


</script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\vac-barcode-task\resources\views/tasks/create.blade.php ENDPATH**/ ?>