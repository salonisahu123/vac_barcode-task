

<?php $__env->startSection('title','Edit Ticket'); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/ticket.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
?>


<?php if($isAdmin || hasPermission('ticket_edit')): ?>

<?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['title' => 'Ticket Management','page' => 'Edit Ticket']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Ticket Management','page' => 'Edit Ticket']); ?>
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

<div class="main-card p-3">

<form method="POST" action="<?php echo e(route('tickets.update',$ticket->id)); ?>" enctype="multipart/form-data">
<?php echo csrf_field(); ?>
<?php echo method_field('PUT'); ?>

<div class="row">

    
    <div class="col-md-4 field-box">
        <label class="form-label">Title</label>
        <input type="text" name="title"
               class="form-control"
               value="<?php echo e(old('title',$ticket->title)); ?>">

        <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="error-text"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    
    <div class="col-md-4 field-box">
        <label class="form-label">Department</label>

        <select name="department_id" class="form-control">
            <option value="">Select</option>

            <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($dept->id); ?>"
                <?php echo e(old('department_id',$ticket->department_id) == $dept->id ? 'selected' : ''); ?>>
                <?php echo e($dept->dept_name); ?>

            </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <?php $__errorArgs = ['department_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="error-text"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    
    <div class="col-md-4 field-box">
        <label class="form-label">Ticket Type</label>

        <select name="ticket_type" id="ticket_type" class="form-control">
            <option value="">Select</option>

            <option value="individual"
                <?php echo e(old('ticket_type',$ticket->ticket_type) == 'individual' ? 'selected' : ''); ?>>
                Individual
            </option>

            <option value="location"
                <?php echo e(old('ticket_type',$ticket->ticket_type) == 'location' ? 'selected' : ''); ?>>
                Location
            </option>
        </select>

        <?php $__errorArgs = ['ticket_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="error-text"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    
    
    
    <div class="col-md-4 field-box d-none" id="locationBox">
        <label class="form-label">Location</label>

        <select name="location_id" id="location_id" class="form-control" data-old="<?php echo e(old('location_id',$ticket->location_id)); ?>">
            <option value="">Select</option>

            <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($loc->id); ?>"
                <?php echo e(old('location_id',$ticket->location_id) == $loc->id ? 'selected' : ''); ?>>
                <?php echo e($loc->name); ?>

            </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </select>

        <?php $__errorArgs = ['location_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="error-text"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    
    <div class="col-md-4 field-box">
        <label class="form-label">Priority</label>

        <select name="priority" class="form-control">
            <option value="">Select</option>

            <option value="low"
                <?php echo e(old('priority',$ticket->priority) == 'low' ? 'selected' : ''); ?>>
                Low
            </option>

            <option value="medium"
                <?php echo e(old('priority',$ticket->priority) == 'medium' ? 'selected' : ''); ?>>
                Medium
            </option>

            <option value="high"
                <?php echo e(old('priority',$ticket->priority) == 'high' ? 'selected' : ''); ?>>
                High
            </option>
        </select>

        <?php $__errorArgs = ['priority'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="error-text"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    
    <div class="col-md-4 field-box">
        <label class="form-label">Subject</label>

        <input type="text"
               name="subject"
               class="form-control"
               value="<?php echo e(old('subject',$ticket->subject)); ?>">

        <?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="error-text"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    
    <div class="col-md-4 field-box">
        <label class="form-label">Attachment</label>

        <input type="file" name="attachment" class="form-control">

        <?php if($ticket->attachment): ?>
        <small class="text-success d-block mt-1">
            Current File :
            <a href="<?php echo e(asset('uploads/tickets/'.$ticket->attachment)); ?>" target="_blank">
                View File
            </a>
        </small>
        <?php endif; ?>

        <?php $__errorArgs = ['attachment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="error-text"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    
    <div class="col-md-12 field-box">
        <label class="form-label">Description</label>

        <textarea name="description"
                  class="form-control"
                  rows="5"><?php echo e(old('description',$ticket->description)); ?></textarea>

        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="error-text"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

</div>

<div class="mt-3">
    <button type="submit" class="btn btn-primary">
        Update Ticket
    </button>

    <a href="<?php echo e(route('tickets.index')); ?>" class="btn btn-secondary">
        Back
    </a>
</div>

</form>

</div>
</div>
</div>

<?php else: ?>

<div class="alert alert-danger">
    You do not have permission to edit ticket.
</div>

<?php endif; ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
<script>
$(function () {

    let savedLocation = "<?php echo e(old('location_id', $ticket->location_id)); ?>";

    function toggleLocation() {

        let type = $('#ticket_type').val();

        if(type === 'location')
        {
            $('#locationBox').removeClass('d-none');

            // restore saved location every time
            $('#location_id').val(savedLocation);
        }
        else
        {
            $('#locationBox').addClass('d-none');
        }
    }

    toggleLocation();

    $('#ticket_type').on('change', function () {
        toggleLocation();
    });

});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\vac-barcode-task\resources\views/tickets/edit.blade.php ENDPATH**/ ?>