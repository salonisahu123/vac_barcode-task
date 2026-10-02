

<?php $__env->startSection('title','Create Custom Dashboard'); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/custom_dash.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">

    <div class="dashboard-card">

        <div class="dashboard-title">
            Create Custom Dashboard
        </div>

        <form method="POST" action="<?php echo e(route('custom-dashboards.store')); ?>">

            <?php echo csrf_field(); ?>

            
            <div class="mb-4">

                <label class="form-label fw-bold mb-2">
                    Dashboard Name
                </label>

                <input type="text"
                       name="dash_name"
                       class="form-control"
                       placeholder="Enter dashboard name"
                       value="<?php echo e(old('dash_name')); ?>">

                <?php $__errorArgs = ['dash_name'];
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

            <?php

            $modules = [
                'Location Module',
                'Department Module',
                'Employee Module',
                'Group Module',
            ];

            ?>

            <div class="table-responsive">

                <table class="dashboard-table">

                    <thead>

                        <tr>
                            <th width="28%">
                                All Modules
                            </th>

                            <th width="72%">
                                Dashboard Components
                            </th>
                        </tr>

                    </thead>

                    <tbody>

                        
                        <tr>

                            <td>
                                <div class="module-name">
                                    Task Module
                                </div>
                            </td>

                            <td>

                                <div class="permission-box">

                                    
                                    <!--<div class="permission-item">-->

                                    <!--    <input type="checkbox"-->
                                    <!--           id="task_chart"-->
                                    <!--           name="view_json[task_module][chart]"-->
                                    <!--           value="1">-->

                                    <!--    <label for="task_chart">-->
                                    <!--        Chart-->
                                    <!--    </label>-->

                                    <!--</div>-->
                                    
                                    
                                    <!--<div class="permission-item">-->
                        
                                    <!--    <input type="checkbox"-->
                                    <!--           id="task_redirect"-->
                                    <!--           name="view_json[task_module][redirect_div]"-->
                                    <!--           value="1">-->
                        
                                    <!--    <label for="task_redirect">-->
                                    <!--        Redirect Div-->
                                    <!--    </label>-->
                        
                                    <!--</div>-->

                                    
                                    <?php $__currentLoopData = $subtasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $subtask): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <div class="permission-item">

                                        <input type="checkbox"
                                               id="subtask_<?php echo e($index); ?>"
                                               name="view_json[task_module][subtasks][]"
                                               value="<?php echo e($subtask->subtask); ?>">

                                        <label for="subtask_<?php echo e($index); ?>">
                                            <?php echo e($subtask->subtask); ?>

                                        </label>

                                    </div>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </div>

                            </td>

                        </tr>


                        
                        <!--<tr>-->

                        <!--    <td>-->

                        <!--        <div class="module-name">-->
                        <!--            Ticket Module-->
                        <!--        </div>-->

                        <!--    </td>-->

                        <!--    <td>-->

                        <!--        <div class="permission-box">-->

                        <!--            <div class="permission-item">-->

                        <!--                <input type="checkbox"-->
                        <!--                       id="ticket_chart"-->
                        <!--                       name="view_json[ticket_module][chart]"-->
                        <!--                       value="1">-->

                        <!--                <label for="ticket_chart">-->
                        <!--                    Chart-->
                        <!--                </label>-->

                        <!--            </div>-->

                        <!--            <div class="permission-item">-->

                        <!--                <input type="checkbox"-->
                        <!--                       id="ticket_redirect"-->
                        <!--                       name="view_json[ticket_module][redirect_div]"-->
                        <!--                       value="1">-->

                        <!--                <label for="ticket_redirect">-->
                        <!--                    Redirect Div-->
                        <!--                </label>-->

                        <!--            </div>-->

                        <!--            <div class="permission-item">-->

                        <!--                <input type="checkbox"-->
                        <!--                       id="ticket_table"-->
                        <!--                       name="view_json[ticket_module][table]"-->
                        <!--                       value="1">-->

                        <!--                <label for="ticket_table">-->
                        <!--                    Table-->
                        <!--                </label>-->

                        <!--            </div>-->

                        <!--        </div>-->

                        <!--    </td>-->

                        <!--</tr>-->


                        
                        <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <!--<tr>-->

                        <!--    <td>-->

                        <!--        <div class="module-name">-->
                        <!--            <?php echo e($module); ?>-->
                        <!--        </div>-->

                        <!--    </td>-->

                        <!--    <td>-->

                        <!--        <div class="permission-box">-->

                        <!--            <div class="permission-item">-->

                        <!--                <input type="checkbox"-->
                        <!--                       id="redirect_<?php echo e($key); ?>"-->
                        <!--                       name="view_json[modules][<?php echo e($key); ?>][redirect_div]"-->
                        <!--                       value="1">-->

                        <!--                <label for="redirect_<?php echo e($key); ?>">-->
                        <!--                    Redirect Div-->
                        <!--                </label>-->

                        <!--            </div>-->

                        <!--            <div class="permission-item">-->

                        <!--                <input type="checkbox"-->
                        <!--                       id="table_<?php echo e($key); ?>"-->
                        <!--                       name="view_json[modules][<?php echo e($key); ?>][table]"-->
                        <!--                       value="1">-->

                        <!--                <label for="table_<?php echo e($key); ?>">-->
                        <!--                    Table-->
                        <!--                </label>-->

                        <!--            </div>-->

                        <!--        </div>-->

                        <!--    </td>-->

                        <!--</tr>-->

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tbody>

                </table>

            </div>

            <button type="submit" class="save-btn">
                Save Dashboard
            </button>

        </form>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\vac-barcode-task\resources\views/custom-dashboard/create.blade.php ENDPATH**/ ?>