 @forelse($tasks as $key => $task)
<tr style="font-size:13px;">

    <td>{{ $key+1 }}</td>

    <td><span style="font-weight:500;">{{ $task->title }}</span></td>

    <td>
        <span class="badge"
              style="background:#eef2ff; color:#4338ca; font-weight:500;">
            {{ ucfirst($task->task_type) }}
        </span>
    </td>
    
    <td>
        @if($isAdmin || hasPermission('task_edit'))
            <select class="form-select form-select-sm changeSubtask shadow-sm" data-id="{{ $task->id }}" style="min-width: 130px; background-color: #f8f9fa; color: #495057; font-weight: 500; border: 1px solid #ced4da; border-radius: 6px; cursor: pointer;">
                <option value="" style="color: #6c757d;">- Select Subtask -</option>
                @foreach($subtasks as $id => $name)
                    <option value="{{ $id }}" {{ $task->subtask_id == $id ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        @else
            <span class="badge" style="background:#ecfdf3; color:#027a48; font-weight:500;">
                {{ $subtasks[$task->subtask_id] ?? '-' }}
            </span>
        @endif
    </td>

    <td>{{ $task->location->name ?? '-' }}</td>

    <td>{{ $task->group->group_name ?? '-' }}</td>

    <td style="color:#6c757d;">{{ $task->from_date }}</td>

    <td style="color:#6c757d;">{{ $task->to_date }}</td>

    <!-- Assigned -->
    <td>
        @php
            $assignedNames = $task->taskUsers
                ->map(function ($assign) {
                    return $assign->employee->user->name ?? null;
                })
                ->filter()
                ->implode(', ');
            $count = $task->taskUsers->count();
        @endphp

        <span style="display:none;" class="export-data">
            {{ $assignedNames ?: '-' }}
        </span>

        <div class="d-flex align-items-center">

            @foreach($task->taskUsers->take(3) as $assign)
                <img src="{{ !empty($assign->employee->image) 
                ? asset('uploads/employees/'.$assign->employee->image) 
                : asset('uploads/employees/user.png') }}"
                 title="{{ $assign->employee->user->name }}"
                 style="width:32px;height:32px;border-radius:50%;object-fit:cover;border:2px solid #fff;margin-left:-8px;">
            @endforeach

            @if($count > 3)
                <div style="width:32px;height:32px;border-radius:50%;background:#0d6efd;color:#fff;font-size:11px;display:flex;align-items:center;justify-content:center;margin-left:-8px;border:2px solid #fff;">
                    +{{ $count - 3 }}
                </div>
            @endif
        </div>
    </td>

    <td>{{ $task->createdBy->name ?? '-' }}</td>

    <!-- ACTION -->
    <td>
        <div class="d-flex gap-1">
            @if($isAdmin || hasPermission('task_view_all') || hasPermission('task_view_own'))
            <a href="{{ route('tasks.show',$task->id) }}" class="btn btn-light btn-sm border">
                <i class="fa fa-eye text-info"></i>
            </a>
            @endif

            @if($isAdmin || hasPermission('task_edit'))
            <a href="{{ route('tasks.edit',$task->id) }}" class="btn btn-light btn-sm border">
                <i class="fa fa-edit text-warning"></i>
            </a>
            @endif

            @if(hasPermission('task_delete'))
            <form action="{{ route('tasks.destroy',$task->id) }}" method="POST" class="delete-form">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-light btn-sm border delete-btn">
                    <i class="fa fa-trash text-danger"></i>
                </button>
            </form>
            @endif
        </div>
    </td>

    <!-- STATUS -->
    <td style="min-width:160px;">
        @if($isAdmin || hasPermission('task_change_status'))

        <select class="form-select form-select-sm changeStatus"
                data-id="{{ $task->id }}">

            <option value="pending" {{ $task->status=='pending' ? 'selected' : '' }}>Pending</option>
            <option value="in_progress" {{ $task->status=='in_progress' ? 'selected' : '' }}>In Progress</option>
            <option value="completed" {{ $task->status=='completed' ? 'selected' : '' }}>Completed</option>

        </select>

        @else

            @if($task->status == 'pending')
                <span class="task-status-badge task-status-pending">Pending</span>

            @elseif($task->status == 'in_progress')
                <span class="task-status-badge task-status-progress">In Progress</span>

            @else
                <span class="task-status-badge task-status-completed">Completed</span>
            @endif

        @endif
    </td>

</tr>

@empty
<tr>
    <td colspan="12" class="text-center text-muted">
        No tasks found
    </td>
</tr>
@endforelse