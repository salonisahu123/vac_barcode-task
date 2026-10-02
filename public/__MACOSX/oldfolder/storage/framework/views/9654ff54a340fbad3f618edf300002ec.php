

<?php $__env->startSection('title','View Custom Dashboard'); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/custom_dash.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php

$viewJson = json_decode($dashboard->view_json, true);

$modules = [
    'Location Module',
    'Department Module',
    'Employee Module',
    'Group Module',
];

?>

<div class="container-fluid">

    <div class="dashboard-card">

        <div class="dashboard-title">
            View Custom Dashboard
        </div>

        
        <div class="mb-4">

            <label class="form-label fw-bold mb-2">
                Dashboard Name
            </label>

            <input type="text"
                   class="form-control"
                   value="<?php echo e($dashboard->dash_name); ?>"
                   readonly>

        </div>

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
                                <!--           disabled-->

                                <!--           <?php echo e(!empty($viewJson['task_module']['chart']) ? 'checked' : ''); ?>>-->

                                <!--    <label>-->
                                <!--        Chart-->
                                <!--    </label>-->

                                <!--</div>-->

                                
                                <!--<div class="permission-item">-->

                                <!--    <input type="checkbox"-->
                                <!--           disabled-->

                                <!--           <?php echo e(!empty($viewJson['task_module']['redirect_div']) ? 'checked' : ''); ?>>-->

                                <!--    <label>-->
                                <!--        Redirect Div-->
                                <!--    </label>-->

                                <!--</div>-->

                                
                                <?php $__currentLoopData = $subtasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subtask): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <div class="permission-item">

                                    <input type="checkbox"
                                           disabled

                                           <?php echo e(!empty($viewJson['task_module']['subtasks'][$subtask->subtask]) ? 'checked' : ''); ?>>

                                    <label>
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
                    <!--                       disabled-->

                    <!--                       <?php echo e(!empty($viewJson['ticket_module']['chart']) ? 'checked' : ''); ?>>-->

                    <!--                <label>-->
                    <!--                    Chart-->
                    <!--                </label>-->

                    <!--            </div>-->

                    <!--            <div class="permission-item">-->

                    <!--                <input type="checkbox"-->
                    <!--                       disabled-->

                    <!--                       <?php echo e(!empty($viewJson['ticket_module']['redirect_div']) ? 'checked' : ''); ?>>-->

                    <!--                <label>-->
                    <!--                    Redirect Div-->
                    <!--                </label>-->

                    <!--            </div>-->

                    <!--            <div class="permission-item">-->

                    <!--                <input type="checkbox"-->
                    <!--                       disabled-->

                    <!--                       <?php echo e(!empty($viewJson['ticket_module']['table']) ? 'checked' : ''); ?>>-->

                    <!--                <label>-->
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
                    <!--                       disabled-->

                    <!--                       <?php echo e(!empty($viewJson['modules'][$module]['redirect_div']) ? 'checked' : ''); ?>>-->

                    <!--                <label>-->
                    <!--                    Redirect Div-->
                    <!--                </label>-->

                    <!--            </div>-->

                    <!--            <div class="permission-item">-->

                    <!--                <input type="checkbox"-->
                    <!--                       disabled-->

                    <!--                       <?php echo e(!empty($viewJson['modules'][$module]['table']) ? 'checked' : ''); ?>>-->

                    <!--                <label>-->
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

        <a href="<?php echo e(route('custom-dashboards.index')); ?>"
           class="back-btn">

            Back

        </a>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\vac-barcode-task\resources\views/custom-dashboard/show.blade.php ENDPATH**/ ?>