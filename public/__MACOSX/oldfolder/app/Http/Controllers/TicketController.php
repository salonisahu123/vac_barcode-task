<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketAssignment;
use App\Models\TicketComment;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Location;
use App\Models\Group;
use App\Models\Activity;
use App\Models\GroupEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
  /*
|---------------- INDEX
*/
public function index()
{
    $user = Auth::user();

    $isAdmin = $user->user_type == 'admin';

    $employeeId = Employee::where('user_id', $user->id)->value('id');

    if (hasPermission('ticket_view_all')) {

        $tickets = Ticket::with([
            'creator',
            'assignments.employee.user',
            'assignments.group',
            'department',
            'location'
        ])->latest()->get();

    } elseif (hasPermission('ticket_view_own')) {

        $tickets = Ticket::with([
            'creator',
            'assignments.employee.user',
            'assignments.group',
            'department',
            'location'
        ])
        ->whereHas('assignments', function($q) use ($employeeId) {
            $q->where('assigned_to', $employeeId);
        })
        ->latest()
        ->get();

    } else {
        return response()->view('errors.no-access');
    }

    $employees = Employee::with('user')->get();
    $groups = Group::all();
    $locations = Location::all();
    
    $statusOptions = [
    'in_progress',
    'hold',
    'close_request',
    'closed',
    'reopen'
];

$loginUserId = Auth::id();

foreach ($tickets as $ticket) {

    $employeeId = Employee::where('user_id', $loginUserId)->value('id');

    $isAssignedToMe = $ticket->assignments
        ->where('assigned_to', $employeeId)
        ->isNotEmpty();

    $isCreatedByMe = $ticket->user_id == $loginUserId;

    $ticket->can_edit_status = [
        'assigned_to_me' => $isAssignedToMe,
        'created_by_me' => $isCreatedByMe,
        'status' => $ticket->status
    ];
}

    return view('tickets.index', compact(
        'tickets',
        'employees',
        'groups',
        'locations',
        'statusOptions',
    ));
}

/////////////////// FILTER //////////////////////////////////////////    
public function filter(Request $request)
{
    $query = Ticket::with([
        'location',
        'assignments.employee.user',
        'assignments.group'
    ]);

    if ($request->location_id) {
        $query->where('location_id', $request->location_id);
    }

    if ($request->group_id) {
        $query->whereHas('assignments', function($q) use ($request){
            $q->where('group_id', $request->group_id);
        });
    }

    $tickets = $query->latest()->get();

    $isAdmin = auth()->user()->user_type == 'admin';

    return response()->json([
        'html' => view('tickets.partials.rows', compact(
            'tickets',
            'isAdmin',
        ))->render()
    ]);
} 

    /*
    |---------------- CREATE
    */
    public function create()
    {
        if (!hasPermission('ticket_add')) {
            return response()->view('errors.no-access');
        }

        $departments = Department::orderBy('dept_name')->get();
        $locations   = Location::orderBy('name')->get();

        return view('tickets.create', compact('departments','locations'));
    }

    /*
    |---------------- STORE
    */
    public function store(Request $request)
    {
        if (!hasPermission('ticket_add')) {
            return response()->view('errors.no-access');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'ticket_type' => 'required|in:individual,location',
            'department_id' => 'required|exists:departments,id',
            'subject' => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high',
            'description' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
            'location_id' => 'required_if:ticket_type,location|nullable|exists:locations,id',
            'assigned_to' => 'nullable|array',
            'assigned_to.*' => 'exists:employees,id',
        ]);

        $fileName = null;

        if ($request->hasFile('attachment')) {

            $fileName = time().'_'.$request->attachment->getClientOriginalName();

            $request->attachment->move(
                public_path('uploads/tickets'),
                $fileName
            );
        }

        $ticket = Ticket::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'ticket_type' => $request->ticket_type,
            'location_id' => $request->ticket_type == 'location'
                        ? $request->location_id
                        : null,
            'department_id' => $request->department_id,
            'subject' => $request->subject,
            'priority' => $request->priority,
            'description' => $request->description,
            'attachment' => $fileName,
            'status' => 'pending',
        ]);
        
        Activity::create([
        'user_id' => Auth::id(),
        'table_name' => 'tickets',
        'table_id' => $ticket->id,
        'operation' => 'create',
        'description' => 'Ticket created: '.$ticket->title
    ]);

        return redirect()->route('tickets.index')
            ->with('success','Ticket Created Successfully');
    }

    /*
    |---------------- SHOW
    */
    public function show($id)
{
    $user = Auth::user();

    $ticket = Ticket::with([
        'creator',
        'assignments.employee.user',
        'comments.user'
    ])->findOrFail($id);

    /*
    |-------------------------------
    | ACCESS CONTROL
    |-------------------------------
    */

    $isAdmin = hasPermission('ticket_view_all');

    $isOwner = hasPermission('ticket_view_own')
        && $ticket->user_id == $user->id;

    $isAssigned = $ticket->assignments->contains(function ($a) use ($user) {
        return $a->employee->user_id == $user->id;
    });

    if (!$isAdmin && !$isOwner && !$isAssigned) {
        return response()->view('errors.no-access');
    }

    /*
    |-------------------------------
    | ACTIVITY QUERY
    |-------------------------------
    */

    $query = Activity::query();

    // base ticket activity
    $query->where(function ($q) use ($ticket) {
        $q->where('table_name', 'tickets')
          ->where('table_id', $ticket->id);
    });

    // assignments activity
    $query->orWhere(function ($q) use ($ticket) {
        $q->where('table_name', 'ticket_assignments')
          ->whereIn('table_id', function ($sub) use ($ticket) {
              $sub->select('id')
                  ->from('ticket_assignments')
                  ->where('ticket_id', $ticket->id);
          });
    });

    // comments activity
    $query->orWhere(function ($q) use ($ticket) {
        $q->where('table_name', 'ticket_comments')
          ->whereIn('table_id', function ($sub) use ($ticket) {
              $sub->select('id')
                  ->from('ticket_comments')
                  ->where('ticket_id', $ticket->id);
          });
    });

    /*
    |-------------------------------
    | ROLE BASE FILTERING
    |-------------------------------
    */

    if (!$isAdmin) {

        $query->where(function ($q) use ($user) {

            // OWNER + ASSIGNED ONLY LIMITED ACTIONS
            $q->where('table_name', 'tickets')
              ->orWhere('table_name', 'ticket_comments')
              ->orWhere(function ($x) {
                  $x->where('table_name', 'ticket_assignments');
              });
        });
    }

    $activities = $query->orderBy('created_at', 'desc')->get();

    /*
    |-------------------------------
    | CLEAN ACTIVITY FORMAT
    |-------------------------------
    */

    foreach ($activities as $act) {

        // ASSIGNMENT → SHOW NAME
        if ($act->table_name == 'ticket_assignments') {

            $assign = \App\Models\TicketAssignment::with('employee.user')
                ->find($act->table_id);

            $name = $assign->employee->user->name ?? 'Unknown';

            $act->description = "Ticket assigned to $name";
        }

        // COMMENT
        elseif ($act->table_name == 'ticket_comments') {
            $act->description = "Comment added on ticket";
        }

        // TICKET
        elseif ($act->table_name == 'tickets') {
            // already fine
        }
    }

    return view('tickets.show', compact('ticket', 'activities'));
}
    /*
    |---------------- EDIT
    */
    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);

        if (hasPermission('ticket_edit')) {

        } elseif (
            hasPermission('ticket_view_own') &&
            $ticket->user_id == Auth::id()
        ) {

        } else {
            return response()->view('errors.no-access');
        }

        $locations = Location::all();
        $departments = Department::all();
        $employees = Employee::with('user')->get();

        return view('tickets.edit', compact(
            'ticket',
            'locations',
            'departments',
            'employees'
        ));
    }

    /*
    |---------------- UPDATE
    */
    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        if (hasPermission('ticket_edit')) {

        } elseif (
            hasPermission('ticket_view_own') &&
            $ticket->user_id == Auth::id()
        ) {

        } else {
            return response()->view('errors.no-access');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'ticket_type' => 'required|in:individual,location',
            'department_id' => 'required|exists:departments,id',
            'subject' => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high',
            'description' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
            'location_id' => 'required_if:ticket_type,location|nullable|exists:locations,id',
        ]);

        if ($request->hasFile('attachment')) {

            if (
                $ticket->attachment &&
                file_exists(public_path('uploads/tickets/'.$ticket->attachment))
            ) {
                unlink(public_path('uploads/tickets/'.$ticket->attachment));
            }

            $fileName = time().'_'.$request->attachment->getClientOriginalName();

            $request->attachment->move(
                public_path('uploads/tickets'),
                $fileName
            );

            $ticket->attachment = $fileName;
        }

        $ticket->update([
            'title' => $request->title,
            'ticket_type' => $request->ticket_type,
            'department_id' => $request->department_id,
            'subject' => $request->subject,
            'priority' => $request->priority,
            'description' => $request->description,
            'location_id' => $request->ticket_type == 'location'
                        ? $request->location_id
                        : null,
            'attachment' => $ticket->attachment,
        ]);

      Activity::create([
        'user_id' => Auth::id(),
        'table_name' => 'tickets',
        'table_id' => $ticket->id,
        'operation' => 'update',
        'description' => 'Ticket updated: '.$ticket->title
    ]);

        return redirect()->route('tickets.index')
            ->with('success','Ticket updated Successfully');
    }

    /*
    |---------------- DELETE
    */
    public function destroy($id)
    {
        if (!hasPermission('ticket_delete')) {
            return response()->view('errors.no-access');
        }

        $ticket = Ticket::findOrFail($id);

        if (
            $ticket->attachment &&
            file_exists(public_path('uploads/tickets/'.$ticket->attachment))
        ) {
            unlink(public_path('uploads/tickets/'.$ticket->attachment));
        }

        $ticket->delete();

      Activity::create([
            'user_id' => Auth::id(),
            'table_name' => 'tickets',
            'table_id' => $id,
            'operation' => 'delete',
            'description' => 'Ticket deleted: '.$ticket->title
        ]);

        return back()->with('success','Deleted');
    }

    /*
    |---------------- ASSIGN
    */
    // public function assign(Request $request)
    // {
    //     if (!hasPermission('ticket_assign')) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'No Access'
    //         ]);
    //     }

    //     $ticket = Ticket::findOrFail($request->ticket_id);

    //     $ticket->update([
    //         'status' => 'assigned'
    //     ]);

    //     TicketAssignment::where('ticket_id', $ticket->id)->delete();

    //     if (!empty($request->employee_id)) {

    //         foreach ($request->employee_id as $emp) {

    //             TicketAssignment::create([
    //                 'ticket_id'   => $ticket->id,
    //                 'assigned_by' => auth()->id(),
    //                 'assign_type' => $request->assign_type,
    //                 'assigned_to' => $emp,
    //                 'location_id' => $ticket->location_id,
    //                 'assigned_at' => now(),
    //             ]);
    //         }
    //     }

    //     if (!empty($request->group_id)) {

    //         $employees = GroupEmployee::where(
    //             'group_id',
    //             $request->group_id
    //         )->get();

    //         foreach ($employees as $row) {

    //             TicketAssignment::create([
    //                 'ticket_id'   => $ticket->id,
    //                 'assigned_by' => auth()->id(),
    //                 'assign_type' => 'group_team',
    //                 'assigned_to' => $row->employee_id,
    //                 'location_id' => $ticket->location_id,
    //                 'group_id'    => $request->group_id,
    //                 'assigned_at' => now(),
    //             ]);
    //         }
    //     }

        
    //   Activity::create([
    //         'user_id' => Auth::id(),
    //         'table_name' => 'ticket_assignments',
    //         'table_id' => $assignment->id,
    //         'operation' => 'assign',
    //         'description' => 'Ticket assigned to employee ID: '.$emp
    //     ]);

    //     return response()->json([
    //         'success' => true
    //     ]);
    // }
    
    
    public function assign(Request $request)
{
    if (!hasPermission('ticket_assign')) {
        return response()->json([
            'success' => false,
            'message' => 'No Access'
        ]);
    }

    $ticket = Ticket::findOrFail($request->ticket_id);

    $ticket->update([
        'status' => 'assigned'
    ]);

    TicketAssignment::where('ticket_id', $ticket->id)->delete();

    /*
    |---------------- INDIVIDUAL ASSIGN
    */
    if (!empty($request->employee_id)) {

        foreach ($request->employee_id as $emp) {

            $assignment = TicketAssignment::create([
                'ticket_id'   => $ticket->id,
                'assigned_by' => auth()->id(),
                'assign_type' => $request->assign_type,
                'assigned_to' => $emp,
                'location_id' => $ticket->location_id,
                'assigned_at' => now(),
            ]);

            Activity::create([
                'user_id' => Auth::id(),
                'table_name' => 'ticket_assignments',
                'table_id' => $assignment->id,
                'operation' => 'assign',
                'description' => 'Ticket assigned to employee ID: '.$emp
            ]);
        }
    }

    /*
    |---------------- GROUP ASSIGN
    */
    if (!empty($request->group_id)) {

        $employees = GroupEmployee::where(
            'group_id',
            $request->group_id
        )->get();

        foreach ($employees as $row) {

            $assignment = TicketAssignment::create([
                'ticket_id'   => $ticket->id,
                'assigned_by' => auth()->id(),
                'assign_type' => 'group_team',
                'assigned_to' => $row->employee_id,
                'location_id' => $ticket->location_id,
                'group_id'    => $request->group_id,
                'assigned_at' => now(),
            ]);

            Activity::create([
                'user_id' => Auth::id(),
                'table_name' => 'ticket_assignments',
                'table_id' => $assignment->id,
                'operation' => 'assign',
                'description' => 'Ticket assigned via group ID: '.$request->group_id
            ]);
        }
    }

    return response()->json([
        'success' => true
    ]);
}

    /*
    |---------------- COMMENT
    */
public function addComment(Request $request, $id)
{
    try {

        $ticket = Ticket::findOrFail($id);
        $user   = auth()->user();

        $fileName = null;

        // FILE CHECK
        if ($request->hasFile('attachment')) {

            $file = $request->file('attachment');

            $fileName = time().'_'.$file->getClientOriginalName();

            $file->move(public_path('uploads/comments'), $fileName);
        }

        $comment = TicketComment::create([
            'ticket_id'  => $id,
            'user_id'    => $user->id,
            'comment'    => $request->comment ?? '',
            'attachment' => $fileName
        ]);

        return response()->json([
            'success' => true,
            'message' => $comment->comment,
            'file'    => $fileName ? asset('uploads/comments/'.$fileName) : null,
            'time'    => $comment->created_at->format('g:i A')
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
}

    /*
    |---------------- GET COMMENTS
    */
    public function getComments($id)
    {
        if (!hasPermission('ticket_view_all') && !hasPermission('ticket_view_own')) {
            return response()->json([]);
        }

        $comments = TicketComment::with('user')
            ->where('ticket_id', $id)
            ->orderBy('id', 'asc')
            ->get();

        return response()->json($comments);
    }


////////////////////// UPDATE STATUS ////////////////////////////////
public function updateStatus(Request $request)
{
    $ticket = Ticket::findOrFail($request->ticket_id);

    $user = auth()->user();
    $employeeId = Employee::where('user_id', $user->id)->value('id');

    $isAssignee = $ticket->assignments
        ->where('assigned_to', $employeeId)
        ->isNotEmpty();

    $isCreator = $ticket->user_id == $user->id;

    $currentStatus = $ticket->status;
    $newStatus = $request->status;

    // ---------------- ASSIGNEE RULE ----------------
    if ($isAssignee) {

        $allowed = [];

        if ($currentStatus == 'assigned') {
            $allowed = ['in_progress', 'hold', 'close_request'];
        }
        elseif ($currentStatus == 'in_progress') {
            $allowed = ['hold', 'close_request'];
        }
        elseif ($currentStatus == 'hold') {
            $allowed = ['in_progress', 'close_request'];
        }

        if (!in_array($newStatus, $allowed)) {
            return response()->json([
                'success' => false,
                'message' => 'Not allowed'
            ], 403);
        }
    }

    // ---------------- CREATOR RULE ----------------
    if ($isCreator && $currentStatus == 'close_request') {

        if (!in_array($newStatus, ['closed', 'reopen'])) {
            return response()->json([
                'success' => false,
                'message' => 'Not allowed'
            ], 403);
        }

        // reopen = back to pending
       if ($newStatus == 'reopen') {

    $newStatus = 'pending';

    // REMOVE OLD ASSIGNMENTS
    TicketAssignment::where('ticket_id', $ticket->id)->delete();

    // OPTIONAL: activity log
    Activity::create([
        'user_id' => Auth::id(),
        'table_name' => 'ticket_assignments',
        'table_id' => $ticket->id,
        'operation' => 'unassign',
        'description' => 'Ticket reopened, previous assignments removed'
    ]);
}
    }

    // ---------------- UPDATE ----------------
    $ticket->status = $newStatus;
    $ticket->save();

    Activity::create([
        'user_id' => Auth::id(),
        'table_name' => 'tickets',
        'table_id' => $ticket->id,
        'operation' => 'status_update',
        'description' => 'Status changed to '.$newStatus
    ]);

    return response()->json([
    'success' => true,
    'message' => 'Status updated successfully'
]);
}

////////////////////// STATUS OPTION ////////////////////////////////
public function statusOptions(Request $request)
{
    $ticket = Ticket::with('assignments')->findOrFail($request->ticket_id);

    $user = auth()->user();

    $options = $this->getTicketStatusOptions($ticket, $user);

    return response()->json([
        'options' => $options
    ]);
}

public function getTicketStatusOptions($ticket, $user)
{
    $employeeId = Employee::where('user_id', $user->id)->value('id');

    $isAssignee = $ticket->assignments
        ->where('assigned_to', $employeeId)
        ->isNotEmpty();

    $isCreator = $ticket->user_id == $user->id;

    $status = $ticket->status;

    $options = [];

    // ---------------- ASSIGNEE FLOW ----------------
    if ($isAssignee) {

        if ($status == 'assigned') {
            $options = ['in_progress', 'hold', 'close_request'];
        }
        elseif ($status == 'in_progress') {
            $options = ['hold', 'close_request'];
        }
        elseif ($status == 'hold') {
            $options = ['in_progress', 'close_request'];
        }
        elseif ($status == 'close_request') {
            $options = [];
        }
    }

    // ---------------- CREATOR FLOW ----------------
    if ($isCreator && $status == 'close_request') {
        $options = ['closed', 'reopen'];
    }

    return $options;
}

}

