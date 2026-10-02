<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Task;
use App\Models\Subtask;
use App\Models\Location;
use App\Models\Department;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $loginUser = Auth::user();

        $filterType = $request->filter_type ?? 'location';

        $locationId = '';
        $departmentId = '';

        if ($filterType == 'location') {
            $locationId = $request->location_id ?? '';
        }

        if ($filterType == 'department') {
            $departmentId = $request->department_id ?? '';
        }

        $globalTaskCount = DB::table('tasks')->count();
        $globalTicketCount = DB::table('tickets')->count();

        /* ================= INPUT FILTER ================= */
        $locationId = $request->location_id ?? '';
        $departmentId = $request->department_id ?? '';

        $locations = Location::orderBy('name')->get();
        $departments = Department::orderBy('dept_name')->get();

        /* ================= EMPLOYEES ================= */
        $employeeQuery = User::where('users.user_type', 'employee')
            ->join('employees', 'employees.user_id', '=', 'users.id');

        /* LOCATION FILTER */
        if ($locationId && $locationId != 'all') {
            $employeeQuery->where('employees.location_id', $locationId);
        }

        /* DEPARTMENT FILTER */
        if ($departmentId && $departmentId != 'all') {
            $employeeQuery->where('employees.department_id', $departmentId);
        }

        if (hasPermission('dashboard_view_own') && !hasPermission('dashboard_view_all')) {
            $employeeQuery->where('users.id', $loginUser->id);
        }

        $employeeIds = $employeeQuery->pluck('users.id')->toArray();

        $employeeTableIds = DB::table('employees')
            ->whereIn('user_id', $employeeIds)
            ->pluck('id')
            ->toArray();

        $userCount = count($employeeIds);

        $scanBarCodeCount = DB::table('scan_brcodes')->count();

        /* ================= TASK COUNT ================= */
        $taskQuery = DB::table('task_users')
            ->join('tasks', 'tasks.id', '=', 'task_users.task_id')
            ->join('employees', 'employees.id', '=', 'task_users.assigned_to');

        if (!empty($employeeTableIds)) {
            $taskQuery->whereIn('task_users.assigned_to', $employeeTableIds);
        } else {
            $taskQuery->whereRaw('1=0');
        }

        if ($locationId && $locationId != 'all') {
            $taskQuery->where('employees.location_id', $locationId);
        }

        if ($departmentId && $departmentId != 'all') {
            $taskQuery->where('employees.department_id', $departmentId);
        }

        $taskCount = $taskQuery->distinct('task_users.task_id')->count('task_users.task_id');

        /* ================= TASK COUNT END ================= */

        /* ================= DASHBOARD TASK COUNT ================= */

        $basicTaskPendingQuery = DB::table('tasks')
            ->join('task_users', 'tasks.id', '=', 'task_users.task_id')
            ->join('employees', 'employees.id', '=', 'task_users.assigned_to')
            ->where('tasks.status', 'pending');

        if ($locationId && $locationId != 'all') {
            $basicTaskPendingQuery->where('employees.location_id', $locationId);
        }

        if ($departmentId && $departmentId != 'all') {
            $basicTaskPendingQuery->where('employees.department_id', $departmentId);
        }

        $basicTaskPending = $basicTaskPendingQuery
            ->distinct('tasks.id')
            ->count('tasks.id');

        /* ================= DASHBOARD TASK END ================= */

        /* ================= TICKET COUNT ======================= */

        $ticketQuery = DB::table('tickets')
            ->join('ticket_assignments', 'tickets.id', '=', 'ticket_assignments.ticket_id')
            ->join('employees', 'employees.id', '=', 'ticket_assignments.assigned_to');

        if ($locationId && $locationId != 'all') {
            $ticketQuery->where('employees.location_id', $locationId);
        }

        if ($departmentId && $departmentId != 'all') {
            $ticketQuery->where('employees.department_id', $departmentId);
        }

        /* EMPLOYEE LOGIN = ONLY ASSIGNED TICKETS */
        if ($loginUser->user_type == 'employee') {

            if (!empty($employeeTableIds)) {
                $ticketQuery->whereIn('ticket_assignments.assigned_to', $employeeTableIds);
            } else {
                $ticketQuery->whereRaw('1=0');
            }
        }

        /* PERMISSION BASED OLD LOGIC */ elseif (hasPermission('dashboard_view_own') && !hasPermission('dashboard_view_all')) {
            $ticketQuery->where('tickets.user_id', $loginUser->id);
        }

        $ticketCount = $ticketQuery->distinct('tickets.id')->count('tickets.id');

        /* ================= TICKET COUNT END================= */

        $users = User::where('users.user_type', 'employee')
            ->leftJoin('employees', 'employees.user_id', '=', 'users.id')
            ->select(
                'users.id',
                'users.name',
                'employees.location_id',
                'employees.department_id'
            )
            ->orderBy('users.name')
            ->get();

        $taskFilter = $request->task_filter ?? 'month';
        $taskUserId = $request->task_user_id ?? null;

        $taskBase = DB::table('tasks')
            ->join('task_users', 'tasks.id', '=', 'task_users.task_id')
            ->join('employees', 'employees.id', '=', 'task_users.assigned_to');

        if ($locationId && $locationId != 'all') {
            $taskBase->where('employees.location_id', $locationId);
        }

        if ($departmentId && $departmentId != 'all') {
            $taskBase->where('employees.department_id', $departmentId);
        }

        /* USER FILTER LAGE TO task_users JOIN */
        if (!empty($taskUserId)) {

            $employee = DB::table('employees')
                ->where('user_id', $taskUserId)
                ->first();

            if ($employee) {

                $taskBase->join('task_users as tu2', 'tasks.id', '=', 'tu2.task_id')
                    ->where('tu2.assigned_to', $employee->id);
            } else {
                $taskBase->whereRaw('1=0');
            }
        }

        /* DATE FILTER */
        if ($taskFilter == 'day') {
            $taskBase->whereDate('tasks.created_at', now()->toDateString());
        }

        if ($taskFilter == 'month') {
            $taskBase->whereMonth('tasks.created_at', now()->month)
                ->whereYear('tasks.created_at', now()->year);
        }

        if ($taskFilter == 'year') {
            $taskBase->whereYear('tasks.created_at', now()->year);
        }

        $taskStatus = (clone $taskBase)
            ->selectRaw("
        COUNT(DISTINCT CASE WHEN tasks.status='pending' THEN tasks.id END) as pending,
        COUNT(DISTINCT CASE WHEN tasks.status='in_progress' THEN tasks.id END) as in_progress,
        COUNT(DISTINCT CASE WHEN tasks.status='completed' THEN tasks.id END) as completed
    ")
            ->first();

      
        /* ================= TICKET FILTER ================= */
        $ticketFilter = $request->ticket_filter ?? 'month';
        $ticketUserId = $request->ticket_user_id ?? null;

        /* ================= TICKET BASE QUERY ================= */
        $ticketBase = DB::table('tickets')
            ->leftJoin('ticket_assignments', 'tickets.id', '=', 'ticket_assignments.ticket_id')
            ->leftJoin('employees', 'employees.id', '=', 'ticket_assignments.assigned_to');

        if ($locationId && $locationId != 'all') {
            $ticketBase->where('employees.location_id', $locationId);
        }

        if ($departmentId && $departmentId != 'all') {
            $ticketBase->where('employees.department_id', $departmentId);
        }
        /* LOCATION FILTER */
        if ($locationId && $locationId != 'all') {
            $ticketBase->where('employees.location_id', $locationId);
        }

        /* DEPARTMENT FILTER */
        if ($departmentId && $departmentId != 'all') {
            $ticketBase->where('employees.department_id', $departmentId);
        }


        /* ================= DATE FILTER ================= */
        if ($ticketFilter == 'day') {
            $ticketBase->whereDate('tickets.created_at', now()->toDateString());
        }

        if ($ticketFilter == 'month') {
            $ticketBase->whereMonth('tickets.created_at', now()->month)
                ->whereYear('tickets.created_at', now()->year);
        }

        if ($ticketFilter == 'year') {
            $ticketBase->whereYear('tickets.created_at', now()->year);
        }

        /* ================= USER FILTER ================= */
        if (!empty($ticketUserId)) {

            $employee = DB::table('employees')
                ->where('user_id', $ticketUserId)
                ->first();

            if ($employee) {

                $ticketBase->where('ticket_assignments.assigned_to', $employee->id);
            } else {
                $ticketBase->whereRaw('1=0');
            }
        }

        /* ================= TICKET STATUS (SAFE) ================= */
     $ticketStatus = (clone $ticketBase)
    ->selectRaw("
        COUNT(DISTINCT CASE WHEN tickets.status='pending' THEN tickets.id END) as pending,
        COUNT(DISTINCT CASE WHEN tickets.status='in_progress' THEN tickets.id END) as in_progress,
        COUNT(DISTINCT CASE WHEN tickets.status='hold' THEN tickets.id END) as hold,
        COUNT(DISTINCT CASE WHEN tickets.status='close_request' THEN tickets.id END) as close_request,
        COUNT(DISTINCT CASE WHEN tickets.status='closed' THEN tickets.id END) as closed,
        COUNT(DISTINCT CASE WHEN tickets.status='reopen' THEN tickets.id END) as reopen,
        COUNT(DISTINCT CASE WHEN tickets.status='assigned' THEN tickets.id END) as assigned
    ")
    ->first();


        /* ================= DASHBOARD TASK SECTION ================= */

        $dashboardTaskQuery = DB::table('tasks')
            ->join('task_users', 'tasks.id', '=', 'task_users.task_id')
            ->join('employees', 'employees.id', '=', 'task_users.assigned_to')
            ->where('tasks.task_type', 'dashboard');

        /* LOCATION FILTER */
        if ($locationId && $locationId != 'all') {
            $dashboardTaskQuery->where('employees.location_id', $locationId);
        }

        /* DEPARTMENT FILTER */
        if ($departmentId && $departmentId != 'all') {
            $dashboardTaskQuery->where('employees.department_id', $departmentId);
        }

        /*  PERMISSION LOGIC */
        if (hasPermission('task_view_own') && !hasPermission('task_view_all')) {

            if (!empty($employeeTableIds)) {
                $dashboardTaskQuery->whereIn('task_users.assigned_to', $employeeTableIds);
            } else {
                $dashboardTaskQuery->whereRaw('1=0');
            }
        }
        
        //////////////////////////////////////////////////////
        /* ================= EXTRA CARD COUNTS ================= */

        $pendingTicketCount = DB::table('tickets')
            ->where('status', 'pending')
            ->count();
        
        $locationCount = DB::table('locations')->count();
        
        $departmentCount = DB::table('departments')->count();
        
        $roleCount = DB::table('roles')->count();
        
        $groupCount = DB::table('groups')->count();
        
        $pendingTaskCount = DB::table('tasks')
        ->where('status', 'pending')
        ->count();

        /* ================= FINAL RETURN ================= */
        return view('dashboard', compact(
            'userCount',
            'scanBarCodeCount',
            'taskCount',
            'ticketCount',
            'locations',
            'departments',
            'users',
            'locationId',
            'departmentId',
            'filterType',
            'taskStatus',
            'ticketStatus',
            'taskFilter',
            'taskUserId',
            'ticketFilter',
            'ticketUserId',
            'globalTaskCount',
            'globalTicketCount',
            'basicTaskPending',
            'pendingTaskCount',
            'pendingTicketCount',
            'locationCount',
            'departmentCount',
            'roleCount',
            'groupCount',
        ));
    }
    
     public function pendingTasks(Request $request)
{
    $filterType = $request->filter_type ?? 'location';

    $locationId = $request->location_id ?? '';
    $departmentId = $request->department_id ?? '';

    $locations = Location::all();
    $departments = Department::all();
    $subtasks = Subtask::all();

    // 🔥 STEP 1: Get employee IDs based on filter
    $employeeQuery = DB::table('employees');

    if ($filterType == 'location' && $locationId && $locationId != 'all') {
        $employeeQuery->where('location_id', $locationId);
    }

    if ($filterType == 'department' && $departmentId && $departmentId != 'all') {
        $employeeQuery->where('department_id', $departmentId);
    }

    $employeeIds = $employeeQuery->pluck('id')->toArray();

    // 🔥 STEP 2: Get task ids assigned to those employees
    $taskIds = DB::table('task_users')
        ->whereIn('assigned_to', $employeeIds)
        ->pluck('task_id')
        ->toArray();

    // 🔥 STEP 3: Get tasks with subtask grouping
    $tasks = Task::whereIn('id', $taskIds)
    ->whereIn('status', ['pending', 'in_progress'])
    ->get()
    ->groupBy('subtask_id');

    // 🔥 STEP 4: status counts (optional for badge)
    $statusCounts = Task::whereIn('id', $taskIds)
        ->select('status', DB::raw('count(*) as total'))
        ->groupBy('status')
        ->pluck('total', 'status');

    return view('dashboard.pendingtask', compact(
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
