<?php 
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CustomDashboard;
use App\Models\Employee;
use App\Models\Task;
use App\Models\Ticket;
use App\Models\Location;
use App\Models\Department;
use App\Models\Role;
use App\Models\Group;
use App\Models\Subtask;


class DashboardRenderController extends Controller
{
    
// public function show($id, Request $request)
// {
//     $user = Auth::user();

//     /* ---------------- EMPLOYEE ---------------- */
//     $employee = Employee::where('user_id', $user->id)->first();

//     /* ---------------- DASHBOARD ---------------- */
//     $dashboard = CustomDashboard::findOrFail($id);
//     $config = json_decode($dashboard->view_json, true) ?? [];

//     /* ---------------- PERMISSIONS ---------------- */
//     $permissions = DB::table('role_permissions')
//     ->join('permissions', 'permissions.id', '=', 'role_permissions.permission_id')
//     ->where('role_permissions.role_id', $user->role_id)
//     ->pluck('permissions.slug')
//     ->toArray();

//     $isAdmin = ($user->user_type == 'admin');
//     $roleSlug = DB::table('roles')
//     ->where('id', $user->role_id)
//     ->value('slug');
//     $employeeId = $employee?->id;

//     /* ==================================================
//       DASHBOARD ACCESS CONTROL
//     ================================================== */
//     $allowedDashboardIds = DB::table('employee_dashboards')
//         ->where('employee_id', $employeeId)
//         ->pluck('dashboard_id')
//         ->toArray();

//     if ($isAdmin) {
//         $allowedDashboardIds = CustomDashboard::pluck('id')->toArray();
//     }

//     if (!in_array($dashboard->id, $allowedDashboardIds)) {
//         abort(403, 'You are not allowed to view this dashboard');
//     }

//     /* ==================================================
//       TASKS
//     ================================================== */
//     $canTaskAll = in_array('task_view_all', $permissions);
//     $canTaskOwn = in_array('task_view_own', $permissions);

//     $taskQuery = Task::query();

//     if (!$isAdmin && $canTaskOwn && !$canTaskAll) {
    
//         $taskQuery->whereIn('tasks.id', function ($q) use ($employeeId) {
    
//             $q->select('task_id')
//                 ->from('task_users')
//                 ->where('assigned_to', $employeeId);
//         });
//     }

//     $taskCount = $taskQuery->count();
//     $globalTaskCount = Task::count();

//     $basicTaskPending = (clone $taskQuery)
//         ->where('status', 'pending')
//         ->count();

//     /* ==================================================
//       TICKETS
//     ================================================== */
//     $canTicketAll = in_array('ticket_view_all', $permissions);
//     $canTicketOwn = in_array('ticket_view_own', $permissions);

//     $ticketQuery = Ticket::query();

//     if (!$isAdmin && $canTicketOwn && !$canTicketAll) {
    
//         $ticketQuery->whereIn('tickets.id', function ($q) use ($employeeId) {
    
//             $q->select('ticket_id')
//                 ->from('ticket_assignments')
//                 ->where('assigned_to', $employeeId);
//         });
//     }

//     $ticketCount = $ticketQuery->count();
//     $globalTicketCount = Ticket::count();

//     $assignedTicketCount = Ticket::whereHas('assignments', function ($q) use ($user) {
//         $q->where('user_id', $user->id);
//     })->count();
    
//     /* ==================================================
//     UNASSIGNED PENDING TICKETS
//     ================================================== */
    
//     $pendingUnassignedTickets = Ticket::where('status', 'pending')
//         ->whereNotIn('id', function ($q) {
//             $q->select('ticket_id')
//                 ->from('ticket_assignments');
//         })
//         ->count();

//     /* ==================================================
//       MASTER COUNTS (PERMISSION BASED)
//     ================================================== */

//     $userCount = Employee::when(
//         !$isAdmin && in_array('employee_view_own', $permissions) && !in_array('employee_view_all', $permissions),
//         fn($q) => $q->where('user_id', $user->id),
//         fn($q) => $q
//     )->count();

//     $locationCount = Location::when(
//         !$isAdmin && in_array('location_view_own', $permissions) && !in_array('location_view_all', $permissions),
//         fn($q) => $q->where('user_id', $user->id),
//         fn($q) => $q
//     )->count();

//     $departmentCount = Department::when(
//         !$isAdmin && in_array('department_view_own', $permissions) && !in_array('department_view_all', $permissions),
//         fn($q) => $q->where('user_id', $user->id),
//         fn($q) => $q
//     )->count();

//     $roleCount = Role::when(
//         !$isAdmin && in_array('role_view_own', $permissions) && !in_array('role_view_all', $permissions),
//         fn($q) => $q->where('user_id', $user->id),
//         fn($q) => $q
//     )->count();

//     $groupCount = Group::when(
//         !$isAdmin && in_array('group_view_own', $permissions) && !in_array('group_view_all', $permissions),
//         fn($q) => $q->where('user_id', $user->id),
//         fn($q) => $q
//     )->count();

//     /* ==================================================
//       SUBTASK (NO PERMISSION ISSUE FIXED)
//     ================================================== */
//     $subtaskCount = Subtask::count();

//     /* ==================================================
//       CUSTOM DASHBOARD COUNT
//     ================================================== */
//     $customDashboardCount = CustomDashboard::count();
    
//     $users = User::where('users.user_type', 'employee')
//             ->leftJoin('employees', 'employees.user_id', '=', 'users.id')
//             ->select(
//                 'users.id',
//                 'users.name',
//                 'employees.location_id',
//                 'employees.department_id'
//             )
//             ->orderBy('users.name')
//             ->get();
    
//     /* ==================================================
//       GRAPH
//     ================================================== */
//         $taskFilter = $request->task_filter ?? 'month';
// $taskUserId = $request->task_user_id ?? null;

// $loggedEmployeeId = $employee?->id;

// $taskBase = DB::table('tasks')
//     ->leftJoin('task_users', 'tasks.id', '=', 'task_users.task_id');

// /* ================= ADMIN ================= */
// if ($isAdmin) {
//     // no filter → all tasks
// }

// /* ================= EMPLOYEE ================= */
// else {

//     if (hasPermission('task_view_all')) {
//         // no filter → all tasks
//     }

//     elseif (hasPermission('task_view_own')) {

//         $taskBase->where('task_users.assigned_to', $employeeId);
//     }

//     else {

//         $taskBase->whereRaw('1 = 0');
//     }
// }

// /* ================= PERMISSION ================= */

// if (!$isAdmin && $canTaskOwn && !$canTaskAll) {

//     $taskBase->where('task_users.assigned_to', $loggedEmployeeId);
// }

// /* ================= ADMIN USER FILTER ================= */

// if ($isAdmin && !empty($taskUserId)) {

//     $selectedEmployeeId = DB::table('employees')
//         ->where('user_id', $taskUserId)
//         ->value('id');

//     if ($selectedEmployeeId) {

//         $taskBase->where('task_users.assigned_to', $selectedEmployeeId);

//     } else {

//         $taskBase->whereRaw('1=0');
//     }
// }

// /* ================= DATE FILTER ================= */

// if ($taskFilter == 'day') {

//     $taskBase->whereDate('tasks.created_at', now()->toDateString());
// }

// if ($taskFilter == 'month') {

//     $taskBase->whereMonth('tasks.created_at', now()->month)
//         ->whereYear('tasks.created_at', now()->year);
// }

// if ($taskFilter == 'year') {

//     $taskBase->whereYear('tasks.created_at', now()->year);
// }

// /* ================= STATUS ================= */

// $taskStatus = (clone $taskBase)
//     ->selectRaw("
//         COUNT(DISTINCT CASE WHEN tasks.status='pending' THEN tasks.id END) as pending,
//         COUNT(DISTINCT CASE WHEN tasks.status='in_progress' THEN tasks.id END) as in_progress,
//         COUNT(DISTINCT CASE WHEN tasks.status='completed' THEN tasks.id END) as completed
//     ")
//     ->first();
      
        
// /* ================= TICKET FILTER ================= */

// $ticketFilter = $request->ticket_filter ?? 'month';
// $ticketUserId = $request->ticket_user_id ?? null;

// /* ================= LOGGED EMPLOYEE ================= */

// $loggedEmployeeId = $employee?->id;

// /* ================= TICKET BASE QUERY ================= */

// $ticketBase = DB::table('tickets')
//     ->leftJoin('ticket_assignments', 'tickets.id', '=', 'ticket_assignments.ticket_id');

// /* ================= ADMIN ================= */
// if ($isAdmin) {
//     // all tickets
// }

// /* ================= EMPLOYEE ================= */
// else {

//     if (hasPermission('ticket_view_all')) {
//         // all tickets
//     }

//     elseif (hasPermission('ticket_view_own')) {

//         $ticketBase->where('ticket_assignments.assigned_to', $employeeId);
//     }

//     else {

//         $ticketBase->whereRaw('1 = 0');
//     }
// }

// /* =====================================================
//   PERMISSION FILTER
// ===================================================== */

// if (!$isAdmin && $canTicketOwn && !$canTicketAll) {

//     $ticketBase->where(
//         'ticket_assignments.assigned_to',
//         $loggedEmployeeId
//     );
// }

// /* =====================================================
//   ADMIN USER FILTER
// ===================================================== */

// if ($isAdmin && !empty($ticketUserId)) {

//     $selectedEmployeeId = DB::table('employees')
//         ->where('user_id', $ticketUserId)
//         ->value('id');

//     if ($selectedEmployeeId) {

//         $ticketBase->where(
//             'ticket_assignments.assigned_to',
//             $selectedEmployeeId
//         );

//     } else {

//         $ticketBase->whereRaw('1=0');
//     }
// }

// /* ================= DATE FILTER ================= */

// if ($ticketFilter == 'day') {

//     $ticketBase->whereDate(
//         'tickets.created_at',
//         now()->toDateString()
//     );
// }

// if ($ticketFilter == 'month') {

//     $ticketBase->whereMonth(
//         'tickets.created_at',
//         now()->month
//     )->whereYear(
//         'tickets.created_at',
//         now()->year
//     );
// }

// if ($ticketFilter == 'year') {

//     $ticketBase->whereYear(
//         'tickets.created_at',
//         now()->year
//     );
// }

// /* ================= TICKET STATUS ================= */

// $ticketStatus = (clone $ticketBase)
//     ->selectRaw("
//         COUNT(DISTINCT CASE WHEN tickets.status='pending' THEN tickets.id END) as pending,

//         COUNT(DISTINCT CASE WHEN tickets.status='in_progress' THEN tickets.id END) as in_progress,

//         COUNT(DISTINCT CASE WHEN tickets.status='hold' THEN tickets.id END) as hold,

//         COUNT(DISTINCT CASE WHEN tickets.status='close_request' THEN tickets.id END) as close_request,

//         COUNT(DISTINCT CASE WHEN tickets.status='closed' THEN tickets.id END) as closed,

//         COUNT(DISTINCT CASE WHEN tickets.status='reopen' THEN tickets.id END) as reopen,

//         COUNT(DISTINCT CASE WHEN tickets.status='assigned' THEN tickets.id END) as assigned
//     ")
//     ->first();
    
    
    
//     ///////////////////////// TABLES START ///////////////////////////

//     /* ==================================================
//     | LOCATION TABLE
//     ================================================== */
    
//     $canViewLocationTable =
//         hasPermission('location_view_all') ||
//         hasPermission('location_view_own');
    
//     $locations = collect();
    
//     if (
//         data_get($config, 'modules.Location Module.table') == true
//         && $canViewLocationTable
//     ) {
    
//         if (hasPermission('location_view_all')) {
    
//             $locations = Location::with('user')
//                 ->latest()
//                 ->get();
    
//         } elseif (hasPermission('location_view_own')) {
    
//             $locations = Location::with('user')
//                 ->where('user_id', Auth::id())
//                 ->latest()
//                 ->get();
//         }
//     }
    
//   /* ==================================================
//     | DEPARTMENT TABLE
//     ================================================== */
    
//     $canViewDepartmentTable =
//         hasPermission('department_view_all') ||
//         hasPermission('department_view_own');
    
//     $departments = collect();
    
//     if (
//         data_get($config, 'modules.Department Module.table') == true
//         && $canViewDepartmentTable
//     ) {
    
//         if (hasPermission('department_view_all')) {
    
//             $departments = Department::with('location', 'user')
//                 ->latest()
//                 ->get();
    
//         } elseif (hasPermission('department_view_own')) {
    
//             $departments = Department::with('location', 'user')
//                 ->where('user_id', Auth::id())
//                 ->latest()
//                 ->get();
//         }
//     }
    
//   /* ==================================================
//     | GROUP TABLE
//     ================================================== */
    
//     $canViewGroupTable =
//         hasPermission('group_view_all') ||
//         hasPermission('group_view_own');
    
//     $groups = collect();
    
//     if (
//         data_get($config, 'modules.Group Module.table') == true
//         && $canViewGroupTable
//     ) {
    
//         if (hasPermission('group_view_all')) {
    
//             $groups = Group::with(
//                     'location',
//                     'department',
//                     'employees.user'
//                 )
//                 ->latest()
//                 ->get();
    
//         } elseif (hasPermission('group_view_own')) {
    
//             $groups = Group::with(
//                     'location',
//                     'department',
//                     'employees.user'
//                 )
//                 ->where('user_id', Auth::id())
//                 ->latest()
//                 ->get();
//         }
//     }
    
//      /* ==================================================
//     | EMPLOYEE TABLE
//     ================================================== */
    
//     $canViewEmployeeTable =
//         hasPermission('employee_view_all') ||
//         hasPermission('employee_view_own');
    
//     $employees = collect();
    
//     if (
//         data_get($config, 'modules.Employee Module.table') == true
//         && $canViewEmployeeTable
//     ) {
    
//         if (hasPermission('employee_view_all')) {
    
//             $employees = Employee::with([
//                     'user',
//                     'location',
//                     'department',
//                     'role'
//                 ])
//                 ->latest()
//                 ->get();
    
//         } elseif (hasPermission('employee_view_own')) {
    
//             $employees = Employee::with([
//                     'user',
//                     'location',
//                     'department',
//                     'role'
//                 ])
//                 ->where('user_id', Auth::id())
//                 ->latest()
//                 ->get();
//         }
//     }
    
//   /* ==================================================
//     | TICKET TABLE
//     ================================================== */
    
//     $canViewTicketTable =
//         hasPermission('ticket_view_all') ||
//         hasPermission('ticket_view_own');
    
//     $tickets = collect();
    
//     if (
//         data_get($config, 'ticket_module.table') == true
//         && $canViewTicketTable
//     ) {
    
//         $employeeId = Employee::where('user_id', $user->id)
//             ->value('id');
    
//         if (hasPermission('ticket_view_all')) {
    
//             $tickets = Ticket::with([
//                     'creator',
//                     'assignments.employee.user',
//                     'assignments.group',
//                     'department',
//                     'location'
//                 ])
//                 ->latest()
//                 ->get();
    
//         } elseif (hasPermission('ticket_view_own')) {
    
//             $tickets = Ticket::with([
//                     'creator',
//                     'assignments.employee.user',
//                     'assignments.group',
//                     'department',
//                     'location'
//                 ])
//                 ->whereHas('assignments', function($q) use ($employeeId) {
    
//                     $q->where('assigned_to', $employeeId);
    
//                 })
//                 ->latest()
//                 ->get();
//         }
//     }
    
//   /* ==================================================
// | TASK TABLE
// ================================================== */

// $canViewTaskTable =
//     hasPermission('task_view_all') ||
//     hasPermission('task_view_own');

// $tasks = collect();

// $showTaskTable = false;
// $enabledSubtaskIds = [];

// /*
// |--------------------------------------------------------------------------
// | GET SUBTASK CONFIG
// |--------------------------------------------------------------------------
// */

// $taskSubtasks = data_get($config, 'task_module.subtasks', []);

// /*
// |--------------------------------------------------------------------------
// | CHECK TRUE SUBTASKS
// |--------------------------------------------------------------------------
// */

// if (!empty($taskSubtasks)) {

//     foreach ($taskSubtasks as $subtaskName => $isEnabled) {

//         if ($isEnabled == true) {

//             $showTaskTable = true;

//             $subtask = Subtask::where(
//                 'subtask',
//                 $subtaskName
//             )->first();

//             if ($subtask) {

//                 $enabledSubtaskIds[] = $subtask->id;
//             }
//         }
//     }
// }

// /*
// |--------------------------------------------------------------------------
// | FETCH TASKS
// |--------------------------------------------------------------------------
// */

// if ($showTaskTable && $canViewTaskTable) {

//     $employeeId = Employee::where(
//         'user_id',
//         $user->id
//     )->value('id');

//     $taskQuery = Task::with([
//         'createdBy',
//         'location',
//         'group',
//         'taskUsers.employee.user'
//     ]);

//     /*
//     |--------------------------------------------------------------------------
//     | ONLY ENABLED SUBTASK TASKS
//     |--------------------------------------------------------------------------
//     */

//     $taskQuery->whereIn(
//         'subtask_id',
//         $enabledSubtaskIds
//     );

//     /*
//     |--------------------------------------------------------------------------
//     | PERMISSION FILTER
//     |--------------------------------------------------------------------------
//     */

//     if (hasPermission('task_view_own')
//         && !hasPermission('task_view_all')) {

//         $taskQuery->whereHas(
//             'taskUsers',
//             function($q) use ($employeeId) {

//                 $q->where(
//                     'assigned_to',
//                     $employeeId
//                 );
//             }
//         );
//     }

//     $tasks = $taskQuery
//         ->latest()
//         ->get();
// }
        
    
// ///////////////////////// TABLES END ///////////////////////////
   


//     return view('dashboard.render', compact(
//         'dashboard',
//         'config',
//         'taskCount',
//         'globalTaskCount',
//         'basicTaskPending',
//         'ticketCount',
//         'globalTicketCount',
//         'assignedTicketCount',
//         'pendingUnassignedTickets',
//         'userCount',
//         'users',
//         'locationCount',
//         'departmentCount',
//         'roleCount',
//         'groupCount',
//         'subtaskCount',
//         'customDashboardCount',
//         'employee',
//         'taskStatus',
//         'ticketStatus',
//         'roleSlug',
//         'locations',
//         'isAdmin',
//         'canViewLocationTable',
//         'departments',
//         'canViewDepartmentTable',
//         'groups',
//         'canViewGroupTable',
//         'employees',
//         'canViewEmployeeTable',
//         'tickets',
//         'canViewTicketTable',
//         'tasks',
//         'showTaskTable',
//         'canViewTaskTable'
//     ));
// }

public function show($id, Request $request)
{
    $filterType = $request->filter_type ?? 'location';

    $locationId = $request->location_id ?? '';
    $departmentId = $request->department_id ?? '';

    // $dashboard = CustomDashboard::findOrFail($id);
    // $user = Auth::user();

    // $employee = \App\Models\Employee::where('user_id', $user->id)->first();
    // $loggedEmployeeId = $employee?->id;
    
    // $canTaskAll = hasPermission('task_view_all');
    // $canTaskOwn = hasPermission('task_view_own');

    // $locations = Location::all();
    // $departments = Department::all();

    // /*
    // |--------------------------------------------------------------------------
    // | GET ENABLED SUBTASKS FROM DASHBOARD JSON
    // |--------------------------------------------------------------------------
    // */
    // $config = json_decode($dashboard->view_json, true) ?? [];

    // $taskSubtasks = $config['task_module']['subtasks'] ?? [];

    // $enabledSubtaskNames = [];

    // foreach ($taskSubtasks as $subtaskName => $isEnabled) {

    //     if ($isEnabled === true) {
    //         $enabledSubtaskNames[] = trim($subtaskName);
    //     }
    // }
    
    $user = Auth::user();

$employee = Employee::where('user_id', $user->id)->first();
$loggedEmployeeId = $employee?->id;

$canTaskAll = hasPermission('task_view_all');
$canTaskOwn = hasPermission('task_view_own');

$locations = Location::all();
$departments = Department::all();

/*
|--------------------------------------------------------------------------
| GET DASHBOARDS ASSIGNED TO LOGGED-IN EMPLOYEE
|--------------------------------------------------------------------------
*/

if ($user->user_type === 'admin') {

    // Admin ke liye URL wala selected dashboard
    $dashboard = CustomDashboard::findOrFail($id);

    $assignedDashboards = collect([$dashboard]);

} else {

    if (!$employee) {
        abort(403, 'Employee profile not found.');
    }

    $assignedDashboardIds = DB::table('employee_dashboards')
        ->where('employee_id', $employee->id)
        ->pluck('dashboard_id')
        ->toArray();

    if (empty($assignedDashboardIds)) {
        abort(403, 'No custom dashboard assigned.');
    }

    // URL mein diya dashboard bhi employee ko assigned hona chahiye
    if (!in_array((int) $id, array_map('intval', $assignedDashboardIds), true)) {
        abort(403, 'You are not allowed to view this dashboard.');
    }

    // Employee ko assigned saare dashboards fetch karo
    $assignedDashboards = CustomDashboard::whereIn(
        'id',
        $assignedDashboardIds
    )->get();

    // Blade heading ke liye requested dashboard available rakhenge
    $dashboard = $assignedDashboards->firstWhere('id', (int) $id)
        ?? $assignedDashboards->first();
}

/*
|--------------------------------------------------------------------------
| MERGE ENABLED SUBTASKS FROM ALL ASSIGNED DASHBOARDS
|--------------------------------------------------------------------------
*/

$enabledSubtaskNames = [];

foreach ($assignedDashboards as $assignedDashboard) {

    $config = json_decode(
        $assignedDashboard->view_json,
        true
    ) ?? [];

    $taskSubtasks = data_get(
        $config,
        'task_module.subtasks',
        []
    );

    foreach ($taskSubtasks as $subtaskName => $isEnabled) {

        if (
            $isEnabled === true ||
            $isEnabled === 1 ||
            $isEnabled === '1'
        ) {
            $enabledSubtaskNames[] = trim($subtaskName);
        }
    }
}

// Same subtask multiple dashboards mein enabled ho to duplicate card na aaye
$enabledSubtaskNames = array_values(
    array_unique($enabledSubtaskNames)
);

    $subtasks = Subtask::whereIn('subtask', $enabledSubtaskNames)->get();

    $enabledSubtaskIds = $subtasks->pluck('id')->toArray();

    /*
    |--------------------------------------------------------------------------
    | GET EMPLOYEE IDS BASED ON FILTER
    |--------------------------------------------------------------------------
    */
    $employeeQuery = DB::table('employees');

    if (
        $filterType == 'location' &&
        $locationId &&
        $locationId != 'all'
    ) {
        $employeeQuery->where('location_id', $locationId);
    }

    if (
        $filterType == 'department' &&
        $departmentId &&
        $departmentId != 'all'
    ) {
        $employeeQuery->where('department_id', $departmentId);
    }

    $employeeIds = $employeeQuery->pluck('id')->toArray();

    /*
    |--------------------------------------------------------------------------
    | GET TASK IDS ASSIGNED TO THOSE EMPLOYEES
    |--------------------------------------------------------------------------
    */
    // $taskUserQuery = DB::table('task_users');

    // if ($canTaskOwn && !$canTaskAll) {
    //     $taskUserQuery->where('assigned_to', $loggedEmployeeId);
    // } else {
    //     $taskUserQuery->whereIn('assigned_to', $employeeIds);
    // }
    
    // $taskIds = $taskUserQuery
    //     ->pluck('task_id')
    //     ->toArray();
    
    
    /*
    |--------------------------------------------------------------------------
    | GET VISIBLE TASK IDS (NO PERMISSION RESTRICTION FOR CUSTOM DASHBOARD)
    |--------------------------------------------------------------------------
    | As requested, if a subtask is enabled in the custom dashboard,
    | it should show all tasks in that module without restricting by view_own.
    */
    
    $taskIds = DB::table('task_users')
        ->whereIn('assigned_to', $employeeIds)
        ->pluck('task_id')
        ->unique()
        ->values()
        ->toArray();

    /*
    |--------------------------------------------------------------------------
    | SHOW ONLY ENABLED SUBTASK TASKS
    |--------------------------------------------------------------------------
    */
    $tasks = Task::whereIn('id', $taskIds)
        ->whereIn('subtask_id', $enabledSubtaskIds)
        ->whereIn('status', ['pending', 'in_progress'])
        ->orderBy('created_at', 'desc')
        ->get()
        ->groupBy('subtask_id');

    /*
    |--------------------------------------------------------------------------
    | STATUS COUNTS
    |--------------------------------------------------------------------------
    */
    $statusCounts = Task::whereIn('id', $taskIds)
        ->whereIn('subtask_id', $enabledSubtaskIds)
        ->select('status', DB::raw('count(*) as total'))
        ->groupBy('status')
        ->pluck('total', 'status');

    return view('dashboard.render', compact(
        'dashboard',
        'subtasks',
        'tasks',
        'locations',
        'departments',
        'statusCounts',
        'locationId',
        'departmentId',
        'filterType'
    ));
}


}