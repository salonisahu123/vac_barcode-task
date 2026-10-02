<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskUser;
use App\Models\User;  
use App\Models\Subtask;
use App\Models\Group;
use App\Models\Location;
use App\Models\Employee;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use App\Notifications\TaskUpdatedNotification;

class TaskController extends Controller
{
    /* =======================================
       LIST
    ======================================= */
    public function index()
{
    $user = Auth::user();

    $isAdmin = $user->user_type == 'admin';

    $employeeId = Employee::where('user_id', $user->id)->value('id');

    if (hasPermission('task_view_all')) {

        $tasks = Task::with([
            'createdBy',
            'location',
            'group',
            'taskUsers.employee.user'
            ])
            ->whereIn('status', ['pending', 'in_progress'])
            ->latest()
            ->get();

    } elseif (hasPermission('task_view_own')) {

           $tasks = Task::with([
            'createdBy',
            'location',
            'group',
            'taskUsers.employee.user'
        ])
       ->where(function ($query) use ($employeeId, $user) {

        $query->where('user_id', $user->id)
    
            ->orWhereHas('taskUsers', function ($q) use ($employeeId) {
                $q->where('assigned_to', $employeeId);
            });
    })
        ->whereIn('status', ['pending', 'in_progress'])
        ->latest()
        ->get();

    } else {
        return response()->view('errors.no-access');
    }

    $locations = Location::all();
    $groups = Group::all();
    $employees = Employee::whereHas('user', function($q) {
        $q->where('is_active', 1);
    })->with('user')->get();
    $subtasks = Subtask::pluck('subtask', 'id');

    return view('tasks.index', compact(
        'tasks',
        'locations',
        'groups',
        'employees',
        'isAdmin',
        'subtasks',
        'employeeId'
    ));
}
    
public function filter(Request $request)
{
    $user = auth()->user();
    $employeeId = Employee::where('user_id', $user->id)->value('id');
    $subtasks = Subtask::pluck('subtask', 'id');

    $query = Task::with([
        'location',
        'group',
        'taskUsers.employee.user',
        'createdBy'
    ]);

   
    if (
    hasPermission('task_view_own') &&
    !hasPermission('task_view_all')
    ) {
        $query->where(function ($taskQuery) use ($employeeId, $user) {
    
            $taskQuery->where('user_id', $user->id)
    
                ->orWhereHas('taskUsers', function ($q) use ($employeeId) {
                    $q->where('assigned_to', $employeeId);
                });
        });
    }

    if ($request->location_id) {
        $query->where('location_id', $request->location_id);
    }

    if ($request->group_id) {
        $query->where('group_id', $request->group_id);
    }

    if ($request->filled('employee_id')) {
        $query->whereHas('taskUsers', function ($q) use ($request) {
            $q->where('assigned_to', $request->employee_id);
        })->whereNull('group_id');
    }
    
    if ($request->filled('status')) {

    $query->where('status', $request->status);

    } else {
    
        // Default listing: completed tasks hide rahenge
        $query->whereIn('status', ['pending', 'in_progress']);
    }

    $tasks = $query->latest()->get();
    $isAdmin = auth()->user()->user_type == 'admin';

    if($tasks->isEmpty()){
        return response()->json([
            'html' => '<tr><td colspan="11" class="text-center text-muted">No tasks found</td></tr>'
        ]);
    }

    return response()->json([
        'html' => view('tasks.partials.rows', compact('tasks','isAdmin','subtasks'))->render()
    ]);
}

    /* =======================================
       CREATE PAGE
    ======================================= */
    public function create()
    {
        if (!hasPermission('task_add')) {
            return response()->view('errors.no-access');
        }

        $employees = Employee::whereHas('user', function($q) {
            $q->where('is_active', 1);
        })->with('user')->get();
        $locations = Location::all();
        $groups    = Group::all();
        $subtask   = Subtask::all();
    
        return view('tasks.create', compact(
            'employees',
            'locations',
            'groups',
            'subtask'
        ));
    }


    /* =======================================
       STORE
    ======================================= */
    public function store(Request $request)
    {
       
        if (!hasPermission('task_add')) {
            return response()->view('errors.no-access');
        }

        $request->validate([
            'title'         => 'required|string|max:255',
            'task_type'     => 'required|in:individual,location',
            'subtask_id' => 'nullable|exists:subtasks,id',
            'status'        => 'required|in:pending,in_progress,completed',
            'from_date'     => 'required|date',
            'to_date'       => 'required|date|after_or_equal:from_date',
            'description'   => 'nullable|string',
            'file'          => 'nullable|file|max:2048',

            'mode' => 'required_if:task_type,location|nullable|in:location_wise,group_team',

            'assigned_to'   => 'required_if:task_type,individual|required_if:mode,location_wise|array',
            'assigned_to.*' => 'exists:employees,id',

            'location_id'   => 'required_if:mode,location_wise|nullable|exists:locations,id',
            'group_id'      => 'required_if:mode,group_team|nullable|exists:groups,id',

        ],[
            'title.required' => 'Title is required.',
            'task_type.required' => 'Please select task type.',
            'assigned_to.required_if' => 'Please select employee.',
            'mode.required_if' => 'Please select mode.',
            'location_id.required_if' => 'Please select location.',
            'group_id.required_if' => 'Please select group.',
            'status.required' => 'Please select status.',
            'from_date.required' => 'Please select from date.',
            'to_date.required' => 'Please select to date.',
            'to_date.after_or_equal' => 'To date must be after from date.',
        ]);

        /* FILE */
        $fileName = null;

        if ($request->hasFile('file')) {
            $fileName = time().'_'.$request->file('file')->getClientOriginalName();
            $request->file('file')->move(public_path('uploads/tasks'), $fileName);
        }

        /* TASK CREATE */
        $task = Task::create([
            'title'       => $request->title,
            'user_id'     => Auth::id(),
            'task_type'   => $request->task_type,
            'subtask_id'  => $request->subtask_id,
            'mode'        => $request->mode,
            'status'      => $request->status,
            'from_date'   => $request->from_date,
            'to_date'     => $request->to_date,
            'description' => $request->description,
            'file'        => $fileName,
            'location_id' => $request->location_id,
            'group_id'    => $request->group_id,
        ]);

        /* MULTIPLE USERS ATTACH */
        if ($request->task_type == 'individual' || $request->mode == 'location_wise') {

            if ($request->filled('assigned_to')) {

                foreach ($request->assigned_to as $assignedId) {

                    $task->taskUsers()->create([
                        'assigned_to' => $assignedId
                    ]);
                }
            }
        }

        /* GROUP TEAM */
        // if ($request->mode == 'group_team') {

        //     $groupEmployees = \DB::table('group_employees')
        //                     ->where('group_id', $request->group_id)
        //                     ->pluck('employee_id');

        //     foreach ($groupEmployees as $empId) {

        //         $task->taskUsers()->create([
        //             'assigned_to' => $empId
        //         ]);
        //     }
        // }
        
        if ($request->mode == 'group_team') {

        $groupEmployees = \DB::table('group_employees')
            ->join('employees', 'group_employees.employee_id', '=', 'employees.id')
            ->join('users', 'employees.user_id', '=', 'users.id')
            ->where('group_employees.group_id', $request->group_id)
            ->where('users.is_active', 1)
            ->whereDate('group_employees.joined_at', '<=', $request->to_date)
            ->where(function ($query) use ($request) {
                $query->whereNull('group_employees.removed_at')
                    ->orWhereDate('group_employees.removed_at', '>=', $request->to_date);
            })
            ->pluck('group_employees.employee_id')
            ->unique();
    
        foreach ($groupEmployees as $empId) {
    
            $task->taskUsers()->create([
                'assigned_to' => $empId,
            ]);
        }
    }

        /* ACTIVITY */
        Activity::create([
            'user_id'     => Auth::id(),
            'table_name'  => 'tasks',
            'table_id'    => $task->id,
            'operation'   => 'create',
            'description' => 'Task "'.$task->title.'" created',
        ]);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task created successfully');
    }

    /* =======================================
       SHOW
    ======================================= */
   public function show($id)
{
    $task = Task::with([
        'createdBy',
        'location',
        'group',
        'taskUsers.employee'
    ])->findOrFail($id);

    $user = Auth::user();
    $employeeId = \App\Models\Employee::where('user_id', $user->id)->value('id');
    
    $isAssigned = $task->taskUsers
        ->where('assigned_to', $employeeId)
        ->count() > 0;
    
    $isCreator = $task->user_id == $user->id;

    if (
        !hasPermission('task_view_all') &&
        !(
            hasPermission('task_view_own') &&
            ($isAssigned || $isCreator)
        )
    ) {
        return response()->view('errors.no-access');
    }
    
    

    $assignedEmployees = $task->taskUsers->map(function ($assign) {
        return [
            'id' => $assign->employee->id ?? null,
            'name' => $assign->employee->name ?? '-',
            'image' => $assign->employee->image
                ? asset('uploads/employees/' . $assign->employee->image)
                : asset('images/default-user.png'),
        ];
    });

    $activities = \App\Models\Activity::where('table_name', 'tasks')
        ->where('table_id', $task->id)
        ->orderBy('created_at', 'desc')
        ->get();
        
        
    $task->subtask_name = '-';
    
    if (!empty($task->subtask_id)) {
    
        $task->subtask_name = \App\Models\Subtask::where(
            'id',
            $task->subtask_id
        )->value('subtask') ?? '-';
    }
        
        
    return view('tasks.show', [
        'task' => $task,   
        'employees' => $assignedEmployees,
        'activities' => $activities,
        
    ]);
}

    /* =======================================
       EDIT PAGE
    ======================================= */

    public function edit($id)
        {
            $task = Task::with('taskUsers')->findOrFail($id);

            $user = Auth::user();

            $employeeId = Employee::where(
                'user_id',
                $user->id
            )->value('id');

            $isAssigned = $task->taskUsers
                ->where('assigned_to', $employeeId)
                ->count() > 0;

            $isCreator = $task->user_id == $user->id;

            if (
                hasPermission('task_edit')
                ||
                (
                    hasPermission('task_view_own')
                    &&
                    ($isAssigned || $isCreator)
                )
            ) {

            } else {
                return response()->view('errors.no-access');
            }

        $employees = Employee::whereHas('user', function($q) {
            $q->where('is_active', 1);
        })->with('user')->get();
        $locations = Location::all();
        $groups    = Group::all();
        $subtask = Subtask::all();

        return view('tasks.edit', compact(
            'task',
            'employees',
            'locations',
            'groups',
            'subtask'
        ));
    }

    /* =======================================
       UPDATE
    ======================================= */

public function update(Request $request, $id)
{
    $task = Task::with('taskUsers')->findOrFail($id);

    $user = Auth::user();

    $employeeId = Employee::where(
        'user_id',
        $user->id
    )->value('id');

    $isAssigned = $task->taskUsers
        ->where('assigned_to', $employeeId)
        ->count() > 0;

    $isCreator = $task->user_id == $user->id;

    if (
        hasPermission('task_edit')
        ||
        (
            hasPermission('task_view_own')
            &&
            ($isAssigned || $isCreator)
        )
    ) {

    } else {
        return response()->view('errors.no-access');
    }
        $request->validate([
            'title'         => 'required|string|max:255',
            'task_type'     => 'required|in:individual,location',
            'subtask_id'    => 'nullable|exists:subtasks,id',
            'status'        => 'required|in:pending,in_progress,completed',
            'from_date'     => 'required|date',
            'to_date'       => 'required|date|after_or_equal:from_date',
            'description'   => 'nullable|string',
            'file'          => 'nullable|file|max:2048',
            'mode'          => 'required_if:task_type,location|nullable|in:location_wise,group_team',
            'assigned_to'   => 'nullable|array',
            'assigned_to.*' => 'exists:employees,id',
            'location_id'   => 'required_if:mode,location_wise|nullable|exists:locations,id',
            'group_id'      => 'required_if:mode,group_team|nullable|exists:groups,id',
            
        ]);

        /* FILE */
        if ($request->hasFile('file')) {

            if ($task->file && file_exists(public_path('uploads/tasks/'.$task->file))) {
                unlink(public_path('uploads/tasks/'.$task->file));
            }

            $fileName = time().'_'.$request->file('file')->getClientOriginalName();

            $request->file('file')->move(public_path('uploads/tasks'), $fileName);

            $task->file = $fileName;
        }

        /* TASK UPDATE */
        $updateData = [
            'title'       => $request->title,
            'task_type'   => $request->task_type,
            'subtask_id'  => $request->subtask_id,
            'status'      => $request->status,
            'from_date'   => $request->from_date,
            'to_date'     => $request->to_date,
            'description' => $request->description,
            // 'user_id'     => auth()->id(),
        ];

        if ($request->task_type == 'individual') {
            $updateData['mode'] = null;
            $updateData['location_id'] = null;
            $updateData['group_id'] = null;
        }

        if ($request->task_type == 'location') {

        $updateData['mode'] = $request->mode;
    
        if ($request->mode == 'location_wise') {
    
            $updateData['location_id'] = $request->location_id;
            $updateData['group_id'] = null;
        }
    
        if ($request->mode == 'group_team') {
    
            $updateData['group_id'] = $request->group_id;
            $updateData['location_id'] = null;
        }
    }

        $task->update($updateData);
       

        /* EMPLOYEE ASSIGNMENT */
        $employeesToAssign = [];

        if ($request->task_type == 'individual') {
            $employeesToAssign = $request->assigned_to ?? [];
        }

        if ($request->task_type == 'location') {

            if ($request->mode == 'location_wise') {
                $employeesToAssign = $request->assigned_to ?? [];
            }

            if ($request->mode == 'group_team') {

            if (!empty($request->group_id)) {
        
                $employeesToAssign = \DB::table('group_employees')
                    ->join('employees', 'group_employees.employee_id', '=', 'employees.id')
                    ->join('users', 'employees.user_id', '=', 'users.id')
                    ->where('group_employees.group_id', $request->group_id)
                    ->where('users.is_active', 1)
                    ->whereDate('group_employees.joined_at', '<=', $request->to_date)
                    ->where(function ($query) use ($request) {
                        $query->whereNull('group_employees.removed_at')
                            ->orWhereDate('group_employees.removed_at', '>=', $request->to_date);
                    })
                    ->pluck('group_employees.employee_id')
                    ->unique()
                    ->toArray();
            }
        }
        }

        $employeesToAssign = array_values(array_unique(array_filter($employeesToAssign)));

        $task->taskUsers()->delete();

        if (!empty($employeesToAssign)) {

            $insert = [];

            foreach ($employeesToAssign as $empId) {

                $insert[] = [
                    'task_id'     => $task->id,
                    'assigned_to' => $empId,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ];
            }

            \DB::table('task_users')->insert($insert);
        }

        Activity::create([
            'user_id'     => Auth::id(),
            'table_name'  => 'tasks',
            'table_id'    => $task->id,
            'operation'   => 'update',
            'description' => 'Task "'.$task->title.'" updated',
        ]);

        /* =========================================
            NOTIFICATION
        ========================================= */

            $this->sendTaskNotification(
                $task,
                'Task "' . $task->title . '" has been updated.'
            );
       

        return redirect()->route('tasks.index')
            ->with('success', 'Task updated successfully');
    }

    /* =======================================
       DELETE
    ======================================= */

    
    public function destroy($id)
{
    if (!hasPermission('task_delete')) {
        return response()->view('errors.no-access');
    }

    $task = Task::findOrFail($id);

    \DB::beginTransaction();

    try {

        // Activity Log
        Activity::create([
            'user_id'     => Auth::id(),
            'table_name'  => 'tasks',
            'table_id'    => $task->id,
            'operation'   => 'delete',
            'description' => 'Task "'.$task->title.'" deleted',
        ]);

        
        if ($task->dashboard_task_id) {
            \DB::table('dashboard_tasks')
                ->where('id', $task->dashboard_task_id)
                ->delete();
        }

        
        $task->taskUsers()->delete();

       
        $task->delete();

        \DB::commit();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task deleted successfully');

    } catch (\Exception $e) {

        \DB::rollback();

        return back()->with('error', 'Something went wrong');
    }
}
    
    // TaskController.php

    /* =======================================
       CHANGE STATUS
    ======================================= */
    public function changeStatus(Request $request, $id)
    {
        if (!hasPermission('task_change_status')) {
            return response()->json([
                'status' => false,
                'message' => 'No permission'
            ]);
        }
    
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed'
        ]);
    
        $task = Task::findOrFail($id);
    
        $oldStatus = $task->status;
    
        $task->update([
            'status' => $request->status
        ]);
    
        Activity::create([
            'user_id'     => Auth::id(),
            'table_name'  => 'tasks',
            'table_id'    => $task->id,
            'operation'   => 'status_change',
            'description' => 'Task "'.$task->title.'" status changed from '.$oldStatus.' to '.$request->status,
        ]);
    
        return response()->json([
            'status' => true,
            'message' => 'Task status updated successfully'
        ]);
    }
    
    /* =======================================
       CHANGE SUBTASK
    ======================================= */
    public function changeSubtask(Request $request, $id)
    {
        if (!hasPermission('task_edit')) {
            return response()->json([
                'status' => false,
                'message' => 'No permission'
            ]);
        }
    
        $request->validate([
            'subtask_id' => 'nullable|exists:subtasks,id'
        ]);
    
        $task = Task::findOrFail($id);
        
        $oldSubtaskName = $task->subtask_id ? \App\Models\Subtask::find($task->subtask_id)->subtask : '-';
        $newSubtaskName = $request->subtask_id ? \App\Models\Subtask::find($request->subtask_id)->subtask : '-';
    
        $task->update([
            'subtask_id' => $request->subtask_id
        ]);
    
        Activity::create([
            'user_id'     => Auth::id(),
            'table_name'  => 'tasks',
            'table_id'    => $task->id,
            'operation'   => 'subtask_change',
            'description' => 'Task "'.$task->title.'" subtask changed from '.$oldSubtaskName.' to '.$newSubtaskName,
        ]);
    
        return response()->json([
            'status' => true,
            'message' => 'Sub Task updated successfully'
        ]);
    }
    
    public function storeRemark(Request $request, $id)
{
    $request->validate([
        'remark' => 'required|string|max:1000',
    ]);

    $task = Task::findOrFail($id);

    Activity::create([
        'user_id' => Auth::id(),
        'table_id' => $task->id,
        'table_name' => 'tasks',
        'operation' => 'remark',
        'description' => 'Remark added on task "' . $task->title . '": ' . $request->remark,
    ]);

     return response()->json([
        'status' => true,
        'message' => 'Remark added successfully'
    ]);
}


// notification
private function sendTaskNotification(Task $task, string $message)
{
    $currentUser = Auth::user();
    $usersToNotify = collect();

    // 1. Add Task Creator
    if ($task->user_id) {
        $creator = User::find($task->user_id);
        if ($creator && $creator->id !== $currentUser->id) {
            $usersToNotify->push($creator);
        }
    }

    // 2. Add Assigned Employees
    $task->load('taskUsers.employee');
    foreach ($task->taskUsers as $taskUser) {
        if ($taskUser->employee && $taskUser->employee->user_id) {
            $assignedUser = User::find($taskUser->employee->user_id);
            if ($assignedUser && $assignedUser->id !== $currentUser->id) {
                $usersToNotify->push($assignedUser);
            }
        }
    }

    // Ensure unique users to avoid duplicate notifications
    $usersToNotify = $usersToNotify->unique('id');

    // Send Notification
    foreach ($usersToNotify as $user) {
        $user->notify(new TaskUpdatedNotification($task, $message));
    }
}
}