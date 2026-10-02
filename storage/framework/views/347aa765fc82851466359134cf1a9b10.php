

<?php $__env->startSection('title', 'Edit Task'); ?>

<?php $__env->startSection('css'); ?>

<link rel="stylesheet" href="<?php echo e(asset('css/task.css')); ?>">

<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

<?php

$user = Auth::user();

$isAdmin = $user->user_type == 'admin';

$employeeId = \App\Models\Employee::where(
    'user_id',
    $user->id
)->value('id');

$isAssigned = $task->taskUsers
    ->where('assigned_to', $employeeId)
    ->count() > 0;

$isCreator = $task->user_id == $user->id;

$canEditTask =
    $isAdmin ||
    hasPermission('task_edit') ||
    (
        hasPermission('task_view_own') &&
        ($isAssigned || $isCreator)
    );

?>


<?php if($canEditTask): ?>

<?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['title' => 'Task Management','page' => 'Edit Task']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Task Management','page' => 'Edit Task']); ?>
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


<?php

$selectedEmployees = $task->taskUsers
    ->pluck('assigned_to')
    ->toArray();

$individualEmployees = ($task->task_type === 'individual')
    ? $selectedEmployees
    : [];

$locationEmployees = ($task->task_type !== 'individual')
    ? $selectedEmployees
    : [];

?>


<div class="row">

    <div class="col-md-12">

        <div class="main-card">

            <form method="POST"
                  action="<?php echo e(route('tasks.update', $task->id)); ?>"
                  enctype="multipart/form-data">

                <?php echo csrf_field(); ?>

                <?php echo method_field('PUT'); ?>


                <div class="dynamic-grid">


                    
                    <div class="field-box">

                        <label class="form-label">
                            Title
                        </label>

                        <input type="text"
                               name="title"
                               class="form-control"
                               value="<?php echo e($task->title); ?>">

                        <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger">
                                <?php echo e($message); ?>

                            </small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    </div>


                    
                    <div class="field-box">

                        <label class="form-label">
                            Task Type
                        </label>

                        <select name="task_type"
                                id="task_type"
                                class="form-control">

                            <option value="">
                                Select
                            </option>

                            <option value="individual"
                                <?php echo e($task->task_type == 'individual' ? 'selected' : ''); ?>>
                                Individual
                            </option>

                            <option value="location"
                                <?php echo e($task->task_type == 'location' ? 'selected' : ''); ?>>
                                Location
                            </option>

                        </select>

                        <?php $__errorArgs = ['task_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger">
                                <?php echo e($message); ?>

                            </small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    </div>


                    
                    <div class="field-box d-none"
                         id="individual_box">

                        <label class="form-label">
                            Employees
                        </label>

                        <select name="assigned_to[]"
                                class="form-control choices"
                                multiple>

                            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <option value="<?php echo e($emp->id); ?>"
                                    <?php echo e(in_array($emp->id, $individualEmployees) ? 'selected' : ''); ?>>

                                    <?php echo e($emp->user->name); ?>


                                </option>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </select>

                        <?php $__errorArgs = ['assigned_to'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger">
                                <?php echo e($message); ?>

                            </small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    </div>


                    
                    <div class="field-box d-none"
                         id="location_box">

                        <label class="form-label">
                            Mode
                        </label>

                        <select name="mode"
                                id="mode"
                                class="form-control">

                            <option value="">
                                Select
                            </option>

                            <option value="location_wise"
                                <?php echo e($task->mode == 'location_wise' ? 'selected' : ''); ?>>
                                Location Wise
                            </option>

                            <option value="group_team"
                                <?php echo e($task->mode == 'group_team' ? 'selected' : ''); ?>>
                                Group Team
                            </option>

                        </select>

                        <?php $__errorArgs = ['mode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger">
                                <?php echo e($message); ?>

                            </small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    </div>


                    
                    <div class="field-box d-none"
                         id="location_select_box">

                        <label class="form-label">
                            Location
                        </label>

                        <select name="location_id"
                                id="location_select"
                                class="form-control choices">

                            <option value="">
                                Select
                            </option>

                            <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <option value="<?php echo e($loc->id); ?>"
                                    <?php echo e($task->location_id == $loc->id ? 'selected' : ''); ?>>

                                    <?php echo e($loc->name); ?>


                                </option>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </select>

                        <?php $__errorArgs = ['location_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger">
                                <?php echo e($message); ?>

                            </small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    </div>


                    
                    <div class="field-box d-none"
                         id="group_box">

                        <label class="form-label">
                            Group
                        </label>

                        <select name="group_id"
                                class="form-control choices">

                            <option value="">
                                Select
                            </option>

                            <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <option value="<?php echo e($group->id); ?>"
                                    <?php echo e($task->group_id == $group->id ? 'selected' : ''); ?>>

                                    <?php echo e($group->group_name); ?>


                                </option>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </select>

                        <?php $__errorArgs = ['group_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger">
                                <?php echo e($message); ?>

                            </small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    </div>


                    
                    <div class="field-box d-none"
                         id="location_employee_box">

                        <label class="form-label">
                            Employees
                        </label>

                        <select id="location_employees"
                                name="assigned_to[]"
                                class="form-control"
                                multiple>
                        </select>

                        <?php $__errorArgs = ['assigned_to'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger">
                                <?php echo e($message); ?>

                            </small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    </div>


                    
                    <div class="field-box">

                        <label class="form-label">
                            Sub Task
                        </label>

                        <select name="subtask_id"
                                class="form-control">

                            <option value="">
                                Select Sub Task
                            </option>

                            <?php $__currentLoopData = $subtask; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <option value="<?php echo e($item->id); ?>"
                                    <?php echo e($task->subtask_id == $item->id ? 'selected' : ''); ?>>

                                    <?php echo e($item->subtask); ?>


                                </option>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </select>

                    </div>


                    
                    <div class="field-box">

                        <label class="form-label">
                            Status
                        </label>

                        <select name="status"
                                class="form-control">

                            <option value="pending"
                                <?php echo e($task->status == 'pending' ? 'selected' : ''); ?>>
                                Pending
                            </option>

                            <option value="in_progress"
                                <?php echo e($task->status == 'in_progress' ? 'selected' : ''); ?>>
                                In Progress
                            </option>

                            <option value="completed"
                                <?php echo e($task->status == 'completed' ? 'selected' : ''); ?>>
                                Completed
                            </option>

                        </select>

                        <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger">
                                <?php echo e($message); ?>

                            </small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    </div>


                    
                    <div class="field-box">

                        <label class="form-label">
                            From Date
                        </label>

                        <input type="date"
                               name="from_date"
                               class="form-control"
                               value="<?php echo e($task->from_date); ?>">

                        <?php $__errorArgs = ['from_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger">
                                <?php echo e($message); ?>

                            </small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    </div>


                    
                    <div class="field-box">

                        <label class="form-label">
                            To Date
                        </label>

                        <input type="date"
                               name="to_date"
                               class="form-control"
                               value="<?php echo e($task->to_date); ?>">

                        <?php $__errorArgs = ['to_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger">
                                <?php echo e($message); ?>

                            </small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    </div>


                    
                    <div class="field-box">

                        <label class="form-label">
                            File
                        </label>

                        <input type="file"
                               name="file"
                               class="form-control">

                        <?php if($task->file): ?>

                            <div class="mt-2">

                                <a href="<?php echo e(asset('uploads/tasks/' . $task->file)); ?>"
                                   target="_blank"
                                   class="btn btn-sm btn-info">

                                    View Current File

                                </a>

                            </div>

                        <?php endif; ?>

                        <?php $__errorArgs = ['file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger">
                                <?php echo e($message); ?>

                            </small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    </div>


                    
                    <div class="field-box"
                         style="width:100%;">

                        <label class="form-label">
                            Description
                        </label>

                        <textarea name="description"
                                  class="form-control"><?php echo e($task->description); ?></textarea>

                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <small class="text-danger">
                                <?php echo e($message); ?>

                            </small>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    </div>


                </div>


                <button type="submit"
                        class="btn btn-save mt-3">

                    Update Task

                </button>


            </form>

        </div>

    </div>

</div>


<?php else: ?>

    <div class="alert alert-danger">

        You do not have permission to edit tasks.

    </div>

<?php endif; ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>

<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>

let employeeChoice;


$(document).ready(function () {


    // ==============================
    // DATA FROM LARAVEL
    // ==============================

    let employees = <?php echo json_encode($employees, 15, 512) ?>;

    let individualSelected = <?php echo json_encode($individualEmployees, 15, 512) ?>;

    let locationSelected = <?php echo json_encode($locationEmployees, 15, 512) ?>;


    // ==============================
    // NORMAL CHOICES
    // ==============================

    document.querySelectorAll('.choices').forEach(function (el) {

        new Choices(el, {

            removeItemButton: true,

            searchEnabled: true,

            shouldSort: false,

            itemSelectText: ''

        });

    });


    // ==============================
    // LOCATION EMPLOYEE CHOICES
    // ==============================

    employeeChoice = new Choices('#location_employees', {

        removeItemButton: true,

        searchEnabled: true,

        shouldSort: false,

        itemSelectText: ''

    });


    // ==============================
    // RESET UI
    // ==============================

    function resetAll() {

        $('#individual_box').addClass('d-none');

        $('#location_box').addClass('d-none');

        $('#location_select_box').addClass('d-none');

        $('#location_employee_box').addClass('d-none');

        $('#group_box').addClass('d-none');

    }


    // ==============================
    // LOAD LOCATION EMPLOYEES
    // ==============================

    function loadLocationEmployees(locationId) {

        let data = [];

        employees.forEach(function (emp) {

            if (emp.location_id == locationId) {

                data.push({

                    value: emp.id,

                    label: emp.user.name,

                    selected: locationSelected.includes(emp.id)

                });

            }

        });


        employeeChoice.clearChoices();


        employeeChoice.setChoices(
            data,
            'value',
            'label',
            true
        );

    }


    // ==============================
    // TOGGLE UI
    // ==============================

    function toggleUI() {

        let type = $('#task_type').val();

        let mode = $('#mode').val();


        resetAll();


        // INDIVIDUAL
        if (type === 'individual') {

            $('#individual_box')
                .removeClass('d-none');

        }


        // LOCATION
        if (type === 'location') {

            $('#location_box')
                .removeClass('d-none');


            // LOCATION WISE
            if (mode === 'location_wise') {

                $('#location_select_box')
                    .removeClass('d-none');


                let locationId =
                    $('#location_select').val();


                if (locationId) {

                    $('#location_employee_box')
                        .removeClass('d-none');

                    loadLocationEmployees(locationId);

                }

            }


            // GROUP TEAM
            if (mode === 'group_team') {

                $('#group_box')
                    .removeClass('d-none');

            }

        }

    }


    // ==============================
    // TASK TYPE CHANGE
    // ==============================

    $('#task_type').on('change', function () {

        let type = $(this).val();


        if (type === 'individual') {

            employeeChoice.clearChoices();

        }


        if (type === 'location') {

            // Individual selected employees clear
            $('select[name="assigned_to[]"]')
                .val([]);

        }


        toggleUI();

    });


    // ==============================
    // MODE CHANGE
    // ==============================

    $('#mode').on('change', function () {

        toggleUI();

    });


    // ==============================
    // LOCATION CHANGE
    // ==============================

    $('#location_select').on('change', function () {

        let locationId = $(this).val();


        if (locationId) {

            $('#location_employee_box')
                .removeClass('d-none');

            loadLocationEmployees(locationId);

        } else {

            $('#location_employee_box')
                .addClass('d-none');

            employeeChoice.clearChoices();

        }

    });


    // ==============================
    // INITIAL LOAD
    // ==============================

    toggleUI();


});

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\vac-barcode-task\resources\views/tasks/edit.blade.php ENDPATH**/ ?>