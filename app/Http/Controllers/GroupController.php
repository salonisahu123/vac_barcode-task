<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupEmployee;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Location;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    /**
     * LIST
     */
    public function index()
    {
        if (hasPermission('group_view_all')) {

            $groups = Group::with('location','department','employees.user')
                        ->latest()
                        ->get();

        } elseif (hasPermission('group_view_own')) {

            $groups = Group::with('location','department','employees.user')
                        ->where('user_id', Auth::id())
                        ->latest()
                        ->get();

        } else {
            return response()->view('errors.no-access');
        }

        return view('groups.index', compact('groups'));
    }

    /**
     * CREATE
     */
    public function create()
    {
        if (!hasPermission('group_add')) {
            return response()->view('errors.no-access');
        }

        $locations = Location::orderBy('name')->get();

        return view('groups.create', compact('locations'));
    }

    /**
     * STORE
     */
  public function store(Request $request)
{
    if (!hasPermission('group_add')) {
        return response()->view('errors.no-access');
    }

    $request->validate([
        'group_name'    => 'required|string|max:255|unique:groups,group_name',
        'location_id'   => 'required|exists:locations,id',
        'department_id' => 'nullable|exists:departments,id',
        'employees'     => 'sometimes|array',
        'employees.*'   => 'nullable|exists:employees,id',
    ]);
    
    if (!$request->has('employees') || empty(array_filter($request->employees))) {

    return back()
        ->withInput()
        ->with('error', 'Please select at least one employee.');
    }
    
    $group = Group::create([
        'user_id'       => Auth::id(),
        'group_name'    => $request->group_name,
        'location_id'   => $request->location_id,
        'department_id' => $request->department_id,
    ]);

    
      foreach ($request->employees as $empId) {
    
        GroupEmployee::create([
            'group_id'    => $group->id,
            'employee_id' => $empId,
            'joined_at'   => now()->toDateString(),
            'removed_at'  => null,
        ]);
    }

    Activity::create([
        'user_id'     => Auth::id(),
        'table_name'  => 'groups',
        'table_id'    => $group->id,
        'operation'   => 'create',
        'description' => 'Group "'.$group->group_name.'" created',
    ]);

    return redirect()->route('groups.index')
        ->with('success', 'Group created successfully');
}

    /**
     * AJAX DEPARTMENTS
     */
    public function getDepartments($locationId)
    {
        $departments = Department::where('location_id', $locationId)
                        ->orderBy('dept_name')
                        ->get();

        return response()->json($departments);
    }

    /**
     * AJAX EMPLOYEES
     */
    public function getEmployeesByDepartment($locationId, $departmentId = null)
    {
        $query = Employee::whereHas('user', function($q) {
                        $q->where('is_active', 1);
                    })->with('user')
                    ->where('location_id', $locationId);

        if ($departmentId && $departmentId !== 'all') {
            $query->where('department_id', $departmentId);
        }

        $employees = $query->get();

        return response()->json($employees);
    }

    /**
     * SHOW
     */
    public function show(string $id)
    {
        $group = Group::with('employees.user')->findOrFail($id);

        if (hasPermission('group_view_all')) {

        } elseif (
            hasPermission('group_view_own') &&
            $group->user_id == Auth::id()
        ) {

        } else {
            return response()->view('errors.no-access');
        }

        return view('groups.show', compact('group'));
    }

    /**
     * EDIT
     */
    public function edit($id)
    {
        $group = Group::with('employees')->findOrFail($id);

        if (hasPermission('group_edit')) {

        } elseif (
            hasPermission('group_view_own') &&
            $group->user_id == Auth::id()
        ) {

        } else {
            return response()->view('errors.no-access');
        }

        $locations = Location::orderBy('name')->get();

        $departments = Department::where('location_id', $group->location_id)
                        ->orderBy('dept_name')
                        ->get();

        $employeesQuery = Employee::whereHas('user', function($q) {
                        $q->where('is_active', 1);
                    })->with('user')
                    ->where('location_id', $group->location_id);
                    
        if ($group->department_id) {
            $employeesQuery->where('department_id', $group->department_id);
        }
        
        $employees = $employeesQuery->get();

        return view('groups.edit', compact(
            'group',
            'locations',
            'departments',
            'employees'
        ));
    }

    /**
     * UPDATE
     */
    public function update(Request $request, string $id)
    {
        $group = Group::findOrFail($id);

        if (hasPermission('group_edit')) {

        } elseif (
            hasPermission('group_view_own') &&
            $group->user_id == Auth::id()
        ) {

        } else {
            return response()->view('errors.no-access');
        }

        $request->validate([
            'group_name'    => 'required|string|max:255|unique:groups,group_name,' . $id,
            'location_id'   => 'required|exists:locations,id',
            'department_id' => 'nullable|exists:departments,id',
            'employees'     => 'sometimes|array',
            'employees.*'   => 'nullable|exists:employees,id',
        ]);
        
        if (
        !$request->has('employees') ||
        empty(array_filter($request->employees))
    ) {
    
        return back()
            ->withInput()
            ->with('error', 'Please select at least one employee.');
    }

        $group->update([
            'group_name'    => $request->group_name,
            'location_id'   => $request->location_id,
            'department_id' => $request->department_id,
        ]);

        // GroupEmployee::where('group_id', $group->id)->delete();

        // if ($request->employees) {

        //     foreach ($request->employees as $empId) {

        //         GroupEmployee::create([
        //             'group_id'    => $group->id,
        //             'employee_id' => $empId,
        //         ]);
        //     }
        // }
        
    //     $selectedEmployeeIds = collect($request->employees)
    // ->filter()
    // ->map(fn ($id) => (int) $id)
    // ->unique()
    // ->values();

$selectedEmployeeIds = collect($request->input('employees', []))
    ->filter()
    ->map(fn ($id) => (int) $id)
    ->unique()
    ->values();
    
$currentEmployeeIds = GroupEmployee::where('group_id', $group->id)
    ->whereNull('removed_at')
    ->pluck('employee_id')
    ->map(fn ($id) => (int) $id);

/*
|--------------------------------------------------------------------------
| Removed employees
|--------------------------------------------------------------------------
*/

$removedEmployeeIds = $currentEmployeeIds->diff($selectedEmployeeIds);

GroupEmployee::where('group_id', $group->id)
    ->whereNull('removed_at')
    ->whereIn('employee_id', $removedEmployeeIds)
    ->update([
        'removed_at' => now()->toDateString(),
        'updated_at' => now(),
    ]);

/*
|--------------------------------------------------------------------------
| Newly added employees
|--------------------------------------------------------------------------
*/

$addedEmployeeIds = $selectedEmployeeIds->diff($currentEmployeeIds);

foreach ($addedEmployeeIds as $employeeId) {
    GroupEmployee::create([
        'group_id'    => $group->id,
        'employee_id' => $employeeId,
        'joined_at'   => now()->toDateString(),
        'removed_at'  => null,
    ]);
}

/*
|--------------------------------------------------------------------------
| Sync existing group tasks
|--------------------------------------------------------------------------
*/

$today = now()->toDateString();

/*
|--------------------------------------------------------------------------
| Newly added employees: assign valid current/future tasks
|--------------------------------------------------------------------------
*/

$validGroupTaskIds = DB::table('tasks')
    ->where('mode', 'group_team')
    ->where('group_id', $group->id)
    ->whereDate('to_date', '>=', $today)
    ->pluck('id');

foreach ($addedEmployeeIds as $employeeId) {

    foreach ($validGroupTaskIds as $taskId) {

       $alreadyAssigned = DB::table('task_users')
    ->where('task_id', $taskId)
    ->where('assigned_to', $employeeId)
    ->exists();

    if (!$alreadyAssigned) {
        DB::table('task_users')->insert([
            'task_id'     => $taskId,
            'assigned_to' => $employeeId,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
    }
    }
}

/*
|--------------------------------------------------------------------------
| Removed employees: remove only future tasks
|--------------------------------------------------------------------------
*/

$futureGroupTaskIds = DB::table('tasks')
    ->where('mode', 'group_team')
    ->where('group_id', $group->id)
    ->whereDate('to_date', '>', $today)
    ->pluck('id');

if (
    $removedEmployeeIds->isNotEmpty() &&
    $futureGroupTaskIds->isNotEmpty()
) {
    DB::table('task_users')
        ->whereIn('task_id', $futureGroupTaskIds)
        ->whereIn('assigned_to', $removedEmployeeIds->values()->all())
        ->delete();
}

        Activity::create([
            'user_id'     => Auth::id(),
            'table_name'  => 'groups',
            'table_id'    => $group->id,
            'operation'   => 'update',
            'description' => 'Group "'.$group->group_name.'" updated',
        ]);

        return redirect()->route('groups.index')
            ->with('success', 'Group updated successfully');
    }

    /**
     * DELETE
     */
    public function destroy(string $id)
    {
        if (!hasPermission('group_delete')) {
            return response()->view('errors.no-access');
        }

        $group = Group::findOrFail($id);

        GroupEmployee::where('group_id', $group->id)->delete();

        $name = $group->group_name;

        $group->delete();

        Activity::create([
            'user_id'     => Auth::id(),
            'table_name'  => 'groups',
            'table_id'    => $id,
            'operation'   => 'delete',
            'description' => 'Group "'.$name.'" deleted',
        ]);

        return redirect()->route('groups.index')
            ->with('success', 'Group deleted successfully');
    }
}