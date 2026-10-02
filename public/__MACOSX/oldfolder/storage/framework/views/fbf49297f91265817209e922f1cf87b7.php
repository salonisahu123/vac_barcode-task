<?php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
?>

<style>
.fa-angle-down.rotate {
    transform: rotate(180deg);
    transition: 0.3s;
}
.submenu {
    transition: all 0.3s ease;
}

.fa-angle-down.rotate {
    transform: rotate(180deg);
    transition: 0.3s;
}

.submenu li a {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 6px 10px;
}

.submenu li a i {
    width: 18px;
    text-align: center;
}
</style>

<nav id="sidebar">

   <div class="sidebar_blog_1">
      <div class="sidebar-header">
         <div class="logo_section">
            <a href="<?php echo e(url('/')); ?>">
               <img class="logo_icon img-responsive"
                  src="<?php echo e(asset('images/logo/logo_icon.png')); ?>" />
            </a>
         </div>
      </div>

      <div class="sidebar_user_info">
         <div class="user_profle_side">
            <div class="user_img">

    <?php
        $image = Auth::user()->employee->image ?? null;
    ?>

    <img class="img-responsive"
         src="<?php echo e($image ? asset('uploads/employees/' . $image)
                        : asset('images/layout_img/user_img.jpg')); ?>" />

</div>
            <div class="user_info">
               <h6><?php echo e($user->name); ?></h6>
               <p><span class="online_animation"></span> Online</p>
            </div>
         </div>
      </div>
   </div>

   <div class="sidebar_blog_2">
      <h4>General</h4>

      <ul class="list-unstyled components">
  
          
        <?php
$user = Auth::user();

// employee record
$employee = \App\Models\Employee::where('user_id', $user->id)->first();

if ($user->user_type == 'admin') {

    // ADMIN → all dashboards
    $dashboards = \App\Models\CustomDashboard::all();

} else {

    // EMPLOYEE → only assigned dashboards
    $dashboardIds = \DB::table('employee_dashboards')
        ->where('employee_id', $employee->id ?? 0)
        ->pluck('dashboard_id');

    $dashboards = \App\Models\CustomDashboard::whereIn('id', $dashboardIds)->get();
}
?>

<?php
$defaultDash = $dashboards->first();
?>

<?php
$defaultDash = $dashboards->first();
?>



<?php if($isAdmin): ?>

<li class="has-submenu">

    <a href="javascript:void(0)" class="menu-toggle">
        <i class="fa fa-dashboard yellow_color"></i>
        <span>Dashboard</span>
        <i class="fa fa-angle-down" style="float:right;"></i>
    </a>

    <ul class="submenu" style="display:none;">

        <li>
            <a href="<?php echo e(route('tasks.pending')); ?>">
                <i class="fa fa-list-check text-warning"></i>
                <span>Pending Task Dashboard</span>
            </a>
        </li>

        <li>
            <a href="<?php echo e(route('dashboard')); ?>">
                <i class="fa fa-home text-primary"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <?php $__currentLoopData = $dashboards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dash): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <a href="<?php echo e(route('dashboard.render', $dash->id)); ?>">
                    <i class="fa fa-tachometer-alt" style="color:#10b981;"></i>
                    <span>
                        <?php echo e(ucwords(str_replace('_', ' ', $dash->dash_name))); ?>

                    </span>
                </a>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </ul>

</li>

<?php elseif($defaultDash): ?>

<li>
    <a href="<?php echo e(route('dashboard.render', $defaultDash->id)); ?>">
        <i class="fa fa-dashboard yellow_color"></i>
        <span>Dashboard</span>
    </a>
</li>

<?php endif; ?>



<?php if($isAdmin): ?>

<li>
    <a href="<?php echo e(route('custom-dashboards.index')); ?>">
        <i class="fa fa-chart-line text-danger"></i>
        <span>Custom Dashboard</span>
    </a>
</li>

<?php endif; ?>
            
         

         
         <?php if($isAdmin || hasAnyPermission(['location_view_own','location_view_all'])): ?>
         <li>
            <a href="<?php echo e(route('locations.index')); ?>">
               <i class="fa fa-map-marker green_color"></i>
               <span>Location Module</span>
            </a>
         </li>
         <?php endif; ?>


         
         <?php if($isAdmin || hasAnyPermission(['department_view_own','department_view_all'])): ?>
         <li>
            <a href="<?php echo e(route('departments.index')); ?>">
               <i class="fa fa-building purple_color"></i>
               <span>Department Module</span>
            </a>
         </li>
         <?php endif; ?>


         
         <?php if($isAdmin || hasAnyPermission(['role_view_own','role_view_all'])): ?>
         <li>
            <a href="<?php echo e(route('roles.index')); ?>">
               <i class="fa fa-user-shield blue_color"></i>
               <span>Role Module</span>
            </a>
         </li>
         <?php endif; ?>


         
         <?php if($isAdmin || hasAnyPermission([
            'role_permission_view_own',
            'role_permission_view_all'
         ])): ?>
         <li>
            <a href="<?php echo e(route('roles_permissions.index')); ?>">
               <i class="fa fa-link green_color"></i>
               <span>Assign Permission</span>
            </a>
         </li>
         <?php endif; ?>


         
         <?php if($isAdmin || hasAnyPermission(['employee_view_own','employee_view_all'])): ?>
         <li>
            <a href="<?php echo e(route('employees.index')); ?>">
               <i class="fa fa-user orange_color"></i>
               <span>Employee Module</span>
            </a>
         </li>
         <?php endif; ?>


         
         <?php if($isAdmin || hasAnyPermission(['group_view_own','group_view_all'])): ?>
         <li>
            <a href="<?php echo e(route('groups.index')); ?>">
               <i class="fa fa-users green_color"></i>
               <span>Group Module</span>
            </a>
         </li>
         <?php endif; ?>



         

         
         <?php if($isAdmin || hasAnyPermission(['task_view_own','task_view_all'])): ?>
         
        
         <?php if($isAdmin): ?>
        <li>
               <a href="<?php echo e(route('subtasks.index')); ?>">
                  <i class="fa fa-check-square text-info"></i>
                  <span>Subtask Module</span>
               </a>
        </li>

         <?php endif; ?>
         
         <li>
            <a href="<?php echo e(route('tasks.index')); ?>">
               <i class="fa fa-tasks red_color"></i>
               <span>Task Module</span>
            </a>
         </li>
         
      
         <?php endif; ?>
         
         

         
         <?php if($isAdmin || hasAnyPermission(['ticket_view_own','ticket_view_all'])): ?>
         <li>
            <a href="<?php echo e(route('tickets.index')); ?>">
               <i class="fa fa-ticket yellow_color"></i>
               <span>Ticket Module</span>
            </a>
         </li>
         <?php endif; ?>


         

         
         <!--<?php if($isAdmin || hasAnyPermission(['production_view_own','production_view_all'])): ?>-->
         <!--<li>-->
         <!--   <a href="<?php echo e(url('production-process-index')); ?>">-->
         <!--      <i class="fa fa-clock-o orange_color"></i>-->
         <!--      <span>Production Module</span>-->
         <!--   </a>-->
         <!--</li>-->
         <!--<?php endif; ?>-->


         <!---->
         <!--<?php if($isAdmin || hasAnyPermission(['packing_view_own','packing_view_all'])): ?>-->
         <!--<li>-->
         <!--   <a href="<?php echo e(route('packing.slip.index')); ?>">-->
         <!--      <i class="fa fa-table purple_color2"></i>-->
         <!--      <span>Packing Module</span>-->
         <!--   </a>-->
         <!--</li>-->
         <!--<?php endif; ?>-->



         
         <!--<?php if($isAdmin || hasAnyPermission(['import_report_view_own','import_report_view_all'])): ?>-->
         <!--<li>-->
         <!--   <a href="#reports" data-toggle="collapse" class="dropdown-toggle">-->
         <!--      <i class="fa fa-diamond purple_color"></i>-->
         <!--      <span>Reports</span>-->
         <!--   </a>-->

         <!--   <ul class="collapse list-unstyled" id="reports">-->

         <!--      <?php if($isAdmin || hasPermission('import_report_view_own') || hasPermission('import_report_view_all')): ?>-->
         <!--      <li>-->
         <!--         <a href="<?php echo e(route('barcode.reports')); ?>">-->
         <!--            Import Report-->
         <!--         </a>-->
         <!--      </li>-->

         <!--      <li>-->
         <!--         <a href="<?php echo e(route('admin.reportsview')); ?>">-->
         <!--            View Report-->
         <!--         </a>-->
         <!--      </li>-->
         <!--      <?php endif; ?>-->

         <!--   </ul>-->
         <!--</li>-->
         <!--<?php endif; ?>-->



         
         <li>
            <form id="logout-form"
               action="<?php echo e(route('logout')); ?>"
               method="POST"
               style="display:none;">
               <?php echo csrf_field(); ?>
            </form>

            <a href="#"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
               <i class="fa fa-sign-out yellow_color"></i>
               <span>Logout</span>
            </a>
         </li>

      </ul>
   </div>

</nav>

<script>
document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll(".menu-toggle").forEach(function (toggle) {
        
        toggle.addEventListener("click", function () {

            let submenu = this.nextElementSibling;
            let icon = this.querySelector(".fa-angle-down");

            if (submenu.style.display === "block") {
                submenu.style.display = "none";
                icon.classList.remove("rotate");
            } else {
                submenu.style.display = "block";
                icon.classList.add("rotate");
            }

        });

    });

});
</script>

<?php /**PATH E:\xampp\htdocs\vac-barcode-task\resources\views/components/sidebar.blade.php ENDPATH**/ ?>