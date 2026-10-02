<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\PackingSlipController;
use App\Http\Middleware\RouteUnderMaintenance;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SubtaskController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\CustomDashboardController;
use App\Http\Controllers\DashboardRenderController;



/*
|--------------------------------------------------------------------------
| AUTH + GLOBAL ROUTES
|--------------------------------------------------------------------------
*/

Route::post('/import-barcode', [BarcodeController::class, 'import'])
->name('barcode.import')
->middleware(['auth', RouteUnderMaintenance::class]);


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', RouteUnderMaintenance::class])
    ->name('dashboard');

Route::get('/', [DashboardController::class, 'pendingTasks'])
    ->middleware(['auth', RouteUnderMaintenance::class])
    ->name('tasks.pending');
    
// Route::get('/', fn () => view('dashboard'))
// ->middleware(['auth', RouteUnderMaintenance::class]);

Route::get('/import-csv', [BarcodeController::class, 'index'])
->name('barcode.reports')
->middleware(['auth', RouteUnderMaintenance::class]);

Route::get('/admin-report-view', [BarcodeController::class, 'indexView'])
->name('admin.reportsview')
->middleware(['auth', RouteUnderMaintenance::class]);

Route::get('/barcode-details/{wo_no}', [BarcodeController::class, 'barcodeDetails'])
->name('barcode.details')
->middleware(['auth', RouteUnderMaintenance::class]);

Route::delete('/barcode/delete-selected', [BarcodeController::class, 'deleteSelected'])
->name('barcode.deleteSelected')
->middleware(['auth']);

Route::get('/scan-quantity', [BarcodeController::class, 'getScannedQuantity'])
->name('scan-quantity')
->middleware(['auth']);

/*
|--------------------------------------------------------------------------
| EXPORT ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/export-scanned-records', [BarcodeController::class, 'exportScannedRecords'])
->name('export.scannedRecords');

Route::get('/export-packing-records', [BarcodeController::class, 'exportPackingRecords'])
->name('export.packingRecords');

Route::get('/export-to-pdf', [BarcodeController::class, 'exportToPDF'])
->name('export.toPDF');

Route::get('/export-production-pdf', [BarcodeController::class, 'exportProductionPDF'])
->name('export.productionPDF');

Route::get('/export-to-excel', [BarcodeController::class, 'exportToExcel'])
->name('export.toExcel');

Route::get('/export-to-production', [BarcodeController::class, 'exportToExcelProduction'])
->name('export.production.Excel');

/*
|--------------------------------------------------------------------------
| PRODUCTION MODULE
|--------------------------------------------------------------------------
*/

Route::get('/get-operation-codes', [ProductionController::class, 'getOperationCodes'])
->name('get.operation.codes')
->middleware(['auth', RouteUnderMaintenance::class]);

Route::get('/packing-slip', [ProductionController::class, 'packingIndex'])
->name('packing.slip')
->middleware(['auth', RouteUnderMaintenance::class]);

Route::get('/packing-slip-index', [ProductionController::class, 'packingFileIndex'])
->name('packing.slip.index')
->middleware(['auth', RouteUnderMaintenance::class]);

Route::get('/production-process', [ProductionController::class, 'index'])
->name('production.process')
->middleware(['auth', RouteUnderMaintenance::class]);

Route::get('/production-process-index', [ProductionController::class, 'productionIndex'])
->name('production.index')
->middleware(['auth', RouteUnderMaintenance::class]);

Route::post('/scan-barcodes/store', [ProductionController::class, 'store'])
->name('scan.barcodes.store')
->middleware(['auth']);

Route::post('/manual-entry', [ProductionController::class, 'storeManualEntry'])
->name('manual.entry.store')
->middleware(['auth']);

Route::post('/update-quantity', [ProductionController::class, 'updateQuantity'])
->name('update.quantity')
->middleware(['auth']);

/*
|--------------------------------------------------------------------------
| PACKING SLIP
|--------------------------------------------------------------------------
*/

Route::post('/packing-slip', [PackingSlipController::class, 'store'])
->name('packing.slip.store')
->middleware(['auth']);

Route::post('/scan-packing', [PackingSlipController::class, 'scanPackingSlip'])
->name('scan.packingSlip')
->middleware(['auth']);

Route::put('/quantity-update/{id}', [PackingSlipController::class, 'updateQuantity'])
->name('quantity.update')
->middleware(['auth']);

/*
|--------------------------------------------------------------------------
| BARCODE
|--------------------------------------------------------------------------
*/

Route::post('/fetch-and-save', [BarcodeController::class, 'fetchAndSaveData'])
->name('fetch.and.save')
->middleware(['auth', RouteUnderMaintenance::class]);

Route::delete('/barcode/{id}', [BarcodeController::class, 'destroy'])
->name('barcode.destroy')
->middleware(['auth']);

/*
|--------------------------------------------------------------------------
| LOGIN SYSTEM
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

Route::post('/logout', [LoginController::class, 'logout'])
->name('logout')
->middleware(['auth', RouteUnderMaintenance::class]);

Route::get('/view-users', [LoginController::class, 'showUsers'])
->name('show.users')
->middleware(['auth', RouteUnderMaintenance::class]);

Route::get('/backup', [LoginController::class, 'downloadBackup'])
->name('backup.store');

Route::get('/add-users', [LoginController::class, 'addUsers'])
->name('add.users')
->middleware(['auth', RouteUnderMaintenance::class]);

Route::post('/store-users', [LoginController::class, 'store'])
->name('users.store')
->middleware(['auth', RouteUnderMaintenance::class]);

Route::delete('/users/{id}', [LoginController::class, 'destroy'])
->name('users.destroy')
->middleware(['auth', RouteUnderMaintenance::class]);

// Forgot Password
Route::get('/forgot-password', [LoginController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [LoginController::class, 'checkEmail'])->name('password.check');

Route::get('/reset-password/{email}', [LoginController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password', [LoginController::class, 'updatePassword'])->name('password.update');

/*
|--------------------------------------------------------------------------
| PERMISSION BASED MODULE ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    
    /*
    |--------------------------------------------------------------------------
    | CUSTOM DASHBOARD
    |--------------------------------------------------------------------------
    */
    
    Route::get('custom-dashboards', [CustomDashboardController::class, 'index'])
        ->name('custom-dashboards.index');
        
    Route::get('custom-dashboards/create', [CustomDashboardController::class, 'create'])
    ->name('custom-dashboards.create');
    
    Route::post('custom-dashboards', [CustomDashboardController::class, 'store'])
        ->name('custom-dashboards.store');
        
    Route::get('custom-dashboards/{id}', [CustomDashboardController::class, 'show'])
    ->name('custom-dashboards.show');
    
    Route::get('custom-dashboards/{id}/edit', [CustomDashboardController::class, 'edit'])
        ->name('custom-dashboards.edit');
    
    Route::put('custom-dashboards/{id}', [CustomDashboardController::class, 'update'])
        ->name('custom-dashboards.update');
    
    Route::delete('custom-dashboards/{id}', [CustomDashboardController::class, 'destroy'])
        ->name('custom-dashboards.destroy');
        
         /*
    |--------------------------------------------------------------------------
    | Render DASHBOARD
    |--------------------------------------------------------------------------
    */
        
    Route::get('dashboard/{id}/view', [DashboardRenderController::class, 'show'])
    ->middleware(['auth'])
    ->name('dashboard.render');

    /*
    |---------------- LOCATION ----------------
    */
    
    Route::get('locations', [LocationController::class, 'index'])
    ->name('locations.index')
    ->middleware('permission:location_view_all,location_view_own');

    Route::post('locations', [LocationController::class, 'store'])
    ->name('locations.store')
    ->middleware('permission:location_add');

    Route::get('locations/{id}/edit', [LocationController::class, 'edit'])
    ->name('locations.edit')
    ->middleware('permission:location_edit');

    Route::put('locations/{id}', [LocationController::class, 'update'])
    ->name('locations.update')
    ->middleware('permission:location_edit');

    Route::delete('locations/{id}', [LocationController::class, 'destroy'])
    ->name('locations.destroy')
    ->middleware('permission:location_delete');

    /*
    |---------------- DEPARTMENT ----------------
    */
    Route::get('departments', [DepartmentController::class, 'index'])
    ->name('departments.index')
    ->middleware('permission:department_view_all,department_view_own');

    Route::post('departments', [DepartmentController::class, 'store'])
    ->name('departments.store')
    ->middleware('permission:department_add');

    Route::get('departments/{id}/edit', [DepartmentController::class, 'edit'])
    ->name('departments.edit')
    ->middleware('permission:department_edit');

    Route::put('departments/{id}', [DepartmentController::class, 'update'])
    ->name('departments.update')
    ->middleware('permission:department_edit');

    Route::delete('departments/{id}', [DepartmentController::class, 'destroy'])
    ->name('departments.destroy')
    ->middleware('permission:department_delete');

    /*
    |---------------- EMPLOYEE ----------------
    */
    Route::get('employees', [EmployeeController::class, 'index'])
    ->name('employees.index')
    ->middleware('permission:employee_view_all,employee_view_own');

    Route::get('employees/create', [EmployeeController::class, 'create'])
    ->name('employees.create')
    ->middleware('permission:employee_add');

    Route::post('employees', [EmployeeController::class, 'store'])
    ->name('employees.store')
    ->middleware('permission:employee_add');

    Route::get('employees/{id}', [EmployeeController::class, 'show'])
    ->name('employees.show')
    ->middleware('permission:employee_view_all,employee_view_own');

    Route::get('employees/{id}/edit', [EmployeeController::class, 'edit'])
    ->name('employees.edit')
    ->middleware('permission:employee_edit');

    Route::put('employees/{id}', [EmployeeController::class, 'update'])
    ->name('employees.update')
    ->middleware('permission:employee_edit');

    Route::delete('employees/{id}', [EmployeeController::class, 'destroy'])
    ->name('employees.destroy')
    ->middleware('permission:employee_delete');

    Route::get('get-departments/{id}', [EmployeeController::class, 'getDepartments'])
    ->name('employees.departments');

    Route::post('employees/update-status', [EmployeeController::class, 'updateStatus'])
    ->name('employees.updateStatus')
    ->middleware('permission:employee_edit');
    
        /*
    |--------------------------------------------------------------------------
    | SUBTASK
    |--------------------------------------------------------------------------
    */
    
    Route::get('subtasks', [SubtaskController::class, 'index'])
        ->name('subtasks.index');
    
    Route::post('subtasks', [SubtaskController::class, 'store'])
        ->name('subtasks.store');
    
    Route::get('subtasks/{id}/edit', [SubtaskController::class, 'edit'])
        ->name('subtasks.edit');
    
    Route::put('subtasks/{id}', [SubtaskController::class, 'update'])
        ->name('subtasks.update');
    
    Route::delete('subtasks/{id}', [SubtaskController::class, 'destroy'])
        ->name('subtasks.destroy');

    /*
    |---------------- TASK ----------------
    */
    
    Route::get('/tasks/filter', [TaskController::class, 'filter'])
    ->name('tasks.filter');

     Route::get('tasks', [TaskController::class, 'index'])
    ->name('tasks.index')
    ->middleware('permission:task_view_all,task_view_own');

    Route::get('tasks/create', [TaskController::class, 'create'])
    ->name('tasks.create')
    ->middleware('permission:task_add');

    Route::post('tasks', [TaskController::class, 'store'])
    ->name('tasks.store')
    ->middleware('permission:task_add');

    Route::get('tasks/{id}', [TaskController::class, 'show'])
    ->name('tasks.show')
    ->middleware('permission:task_view_all,task_view_own');

    // Route::get('tasks/{id}/edit', [TaskController::class, 'edit'])
    // ->name('tasks.edit')
    // ->middleware('permission:task_edit');

    // Route::put('tasks/{id}', [TaskController::class, 'update'])
    // ->name('tasks.update')
    // ->middleware('permission:task_edit');
    Route::get('tasks/{id}/edit', [TaskController::class, 'edit'])
    ->name('tasks.edit')
    ->middleware('permission:task_edit,task_view_own');

Route::put('tasks/{id}', [TaskController::class, 'update'])
    ->name('tasks.update')
    ->middleware('permission:task_edit,task_view_own');

    Route::delete('tasks/{id}', [TaskController::class, 'destroy'])
    ->name('tasks.destroy')
    ->middleware('permission:task_delete');

    Route::post('tasks/{id}/status', [TaskController::class, 'changeStatus'])
    ->name('tasks.changeStatus')
    ->middleware('permission:task_change_status');
    
    Route::post('tasks/{id}/subtask', [TaskController::class, 'changeSubtask'])
    ->name('tasks.changeSubtask')
    ->middleware('permission:task_edit');
    
    Route::post('tasks/{id}/remark', [TaskController::class, 'storeRemark'])
    ->name('tasks.remark')
    ->middleware('permission:task_view_all,task_view_own');

    /*
    |---------------- TICKET ----------------
    */
    
    Route::get('/tickets/filter', [TicketController::class, 'filter'])
    ->name('tickets.filter');
    
    Route::post('/tickets/update-status', [TicketController::class, 'updateStatus'])
    ->name('tickets.updateStatus');
    
    Route::get('/tickets/status-options', [TicketController::class, 'statusOptions'])
    ->name('tickets.status.options');
    
    Route::get('tickets', [TicketController::class, 'index'])
    ->name('tickets.index')
    ->middleware('permission:ticket_view_all,ticket_view_own');

    Route::get('tickets/create', [TicketController::class,'create'])
    ->name('tickets.create')
    ->middleware('permission:ticket_add');

    Route::post('tickets', [TicketController::class,'store'])
    ->name('tickets.store')
    ->middleware('permission:ticket_add');

    Route::get('tickets/{id}', [TicketController::class,'show'])
    ->name('tickets.show')
    ->middleware('permission:ticket_view_all,ticket_view_own');

    Route::get('tickets/{id}/edit', [TicketController::class,'edit'])
    ->name('tickets.edit')
    ->middleware('permission:ticket_edit');

    Route::put('tickets/{id}', [TicketController::class,'update'])
    ->name('tickets.update')
    ->middleware('permission:ticket_edit');

    Route::delete('tickets/{id}', [TicketController::class,'destroy'])
    ->name('tickets.destroy')
    ->middleware('permission:ticket_delete');

    Route::post('/ticket/{id}/comment', [TicketController::class, 'addComment']);
    Route::get('/ticket/{id}/comments', [TicketController::class, 'getComments']);

    Route::post('tickets/assign', [TicketController::class,'assign'])
    ->name('tickets.assign')
    ->middleware('permission:ticket_change_status');

    Route::post('tickets/{id}/comment', [TicketController::class,'addComment'])
    ->name('tickets.comment')
    ->middleware('permission:ticket_view_all');

    /*
    |---------------- ROLE ----------------
    */
   Route::get('roles', [RoleController::class, 'index'])
   ->name('roles.index')
   ->middleware('permission:role_view_all,role_view_own');

    Route::post('roles', [RoleController::class, 'store'])
    ->name('roles.store')
    ->middleware('permission:role_add');

    Route::get('roles/{id}/edit', [RoleController::class, 'edit'])
    ->name('roles.edit')
    ->middleware('permission:role_edit');

    Route::put('roles/{id}', [RoleController::class, 'update'])
    ->name('roles.update')
    ->middleware('permission:role_edit');

    Route::delete('roles/{id}', [RoleController::class, 'destroy'])
    ->name('roles.destroy')
    ->middleware('permission:role_delete');

    /*
    |---------------- GROUP ----------------
    */
    Route::get('groups', [GroupController::class, 'index'])
    ->name('groups.index')
    ->middleware('permission:group_view_all,group_view_own');
    
    Route::get('groups/create', [GroupController::class, 'create'])
    ->name('groups.create')
    ->middleware('permission:group_add');

    Route::get('groups/{id}', [GroupController::class, 'show'])
    ->name('groups.show')
    ->middleware('permission:group_view_all,group_view_own');

    Route::post('groups', [GroupController::class, 'store'])
    ->name('groups.store')
    ->middleware('permission:group_add');

    Route::get('groups/{id}/edit', [GroupController::class, 'edit'])
    ->name('groups.edit')
    ->middleware('permission:group_edit');

    Route::put('groups/{id}', [GroupController::class, 'update'])
    ->name('groups.update')
    ->middleware('permission:group_edit');

    Route::delete('groups/{id}', [GroupController::class, 'destroy'])
    ->name('groups.destroy')
    ->middleware('permission:group_delete');
    
    /*
    |------------------------------------------
    | AJAX DEPENDENT DROPDOWN ROUTES
    |------------------------------------------
    */
    
    Route::get('groups/get-departments/{locationId}', [GroupController::class,'getDepartments'])
    ->name('groups.departments');
    
    Route::get('groups/get-employees/{locationId}/{departmentId?}', [GroupController::class,'getEmployeesByDepartment'])
    ->name('groups.employees');

    /*
    |---------------- PERMISSIONS ----------------
    */
    Route::get('permissions', [PermissionController::class, 'index'])
    ->name('permissions.index')
    ->middleware('permission:permission_view_all,permission_view_own');

    Route::post('permissions', [PermissionController::class, 'store'])
    ->name('permissions.store')
    ->middleware('permission:permission_add');

    Route::get('permissions/{id}/edit', [PermissionController::class, 'edit'])
    ->name('permissions.edit')
    ->middleware('permission:permission_edit');

    Route::put('permissions/{id}', [PermissionController::class, 'update'])
    ->name('permissions.update')
    ->middleware('permission:permission_edit');

    Route::delete('permissions/{id}', [PermissionController::class, 'destroy'])
    ->name('permissions.destroy')
    ->middleware('permission:permission_delete');

    /*
    |---------------- ROLE PERMISSIONS ----------------
    */
    Route::get('roles_permissions', [RolePermissionController::class, 'index'])
    ->name('roles_permissions.index')
    ->middleware('permission:role_permission_view_all,role_permission_view_own');

    Route::get('roles_permissions/assign', [RolePermissionController::class, 'create'])
    ->name('roles_permissions.assign')
    ->middleware('permission:role_permission_add');

    Route::get('roles_permissions/{id}', [RolePermissionController::class, 'show'])
    ->name('roles_permissions.show')
    ->middleware('permission:role_permission_view_all,role_permission_view_own');

    Route::post('roles_permissions', [RolePermissionController::class, 'store'])
    ->name('roles_permissions.store')
    ->middleware('permission:role_permission_add');

    Route::get('roles_permissions/{id}/edit', [RolePermissionController::class, 'edit'])
    ->name('roles_permissions.edit')
    ->middleware('permission:role_permission_edit');

    Route::put('roles_permissions/{id}', [RolePermissionController::class, 'update'])
    ->name('roles_permissions.update')
    ->middleware('permission:role_permission_edit');

    Route::delete('roles_permissions/{id}', [RolePermissionController::class, 'destroy'])
    ->name('roles_permissions.destroy')
    ->middleware('permission:role_permission_delete');

});

Route::get('/notifications/latest', function () {

    $notification = auth()->user()
        ->unreadNotifications()
        ->latest()
        ->first();

    if (!$notification) {
        return response()->json([
            'status' => false
        ]);
    }

    $data = $notification->data;

    return response()->json([
        'status' => true,
        'id' => $notification->id,
        'message' => $data['message'] ?? 'New notification',
        'task_id' => $data['task_id'] ?? null,
        'task_title' => $data['task_title'] ?? null,
    ]);

})->middleware('auth');

Route::get('/notifications', function () {

    $user = auth()->user();

    // Saari unread notifications
    $unreadNotifications = $user->unreadNotifications()
        ->latest()
        ->get();

    // Sirf latest 5 read/seen notifications
    $readNotifications = $user->readNotifications()
        ->latest()
        ->take(5)
        ->get();

    return response()->json([
        'unread_count' => $unreadNotifications->count(),

        'unread' => $unreadNotifications->map(function ($notification) {
            return [
                'id' => $notification->id,
                'message' => $notification->data['message'] ?? 'New notification',
                'task_id' => $notification->data['task_id'] ?? null,
                'task_title' => $notification->data['task_title'] ?? null,
                'created_at' => $notification->created_at->format('d M Y, h:i A'),
            ];
        }),

        'read' => $readNotifications->map(function ($notification) {
            return [
                'id' => $notification->id,
                'message' => $notification->data['message'] ?? 'Notification',
                'task_id' => $notification->data['task_id'] ?? null,
                'task_title' => $notification->data['task_title'] ?? null,
                'created_at' => $notification->created_at->format('d M Y, h:i A'),
            ];
        }),
    ]);

})->middleware('auth');



Route::post('/notifications/{id}/read', function ($id) {

    $notification = auth()->user()
        ->notifications()
        ->where('id', $id)
        ->firstOrFail();

    $notification->markAsRead();

    return response()->json([
        'status' => true
    ]);

})->middleware('auth');