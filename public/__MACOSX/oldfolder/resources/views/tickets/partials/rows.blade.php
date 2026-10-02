@forelse($tickets as $key => $ticket)

<tr style="font-size:13px;">

    <td>{{ $key+1 }}</td>

    <td><b>{{ $ticket->title }}</b></td>

    <td>
        <span class="badge">
            {{ ucfirst($ticket->ticket_type) }}
        </span>
    </td>

    <!--<td>-->
    <!--    <span class="badge">-->
    <!--        {{ ucfirst($ticket->priority) }}-->
    <!--    </span>-->
    <!--</td>-->

<td>

<span class="status-badge status-{{ str_replace('_','-',$ticket->status) }}">
    {{ ucfirst(str_replace('_',' ',$ticket->status)) }}
</span>

@php
    $canEditStatus = $ticket->can_edit_status ?? [];
@endphp

@if(
    in_array($ticket->status, ['assigned', 'in_progress', 'hold', 'close_request'])
    && ($canEditStatus['assigned_to_me'] ?? false)
    && $ticket->status != 'close_request'
)
    <button class="btn btn-sm btn-outline-primary changeStatusBtn"
        data-id="{{ $ticket->id }}"
        data-status="{{ $ticket->status }}"
        data-assigned="{{ $canEditStatus['assigned_to_me'] ?? 0 }}"
        data-created="{{ $canEditStatus['created_by_me'] ?? 0 }}">
        Change
    </button>
@endif

</td>


    <!--<td>{{ $ticket->department->dept_name ?? '-' }}</td>-->
    <td>
        {{ $ticket->location->name ?? '-' }}
    </td>
    
    <td>
    @php
        $groupName = $ticket->assignments
            ->pluck('group.group_name')
            ->filter()
            ->unique()
            ->implode(', ');
    @endphp

    {{ $groupName ?: '-' }}
   </td>

    {{-- ASSIGNED USERS --}}
    @if($isAdmin)
    <td>
        <div class="d-flex align-items-center">
    
            @php $count = $ticket->assignments->count(); @endphp
    
            @forelse($ticket->assignments->take(3) as $assign)
                @if($assign->employee && $assign->employee->user)
    
                    <img src="{{ !empty($assign->employee->image) && file_exists(public_path('uploads/employees/'.$assign->employee->image)) 
                                ? asset('uploads/employees/'.$assign->employee->image) 
                                : asset('uploads/employees/user.png') }}"
                         
                         title="{{ $assign->employee->user->name }}"
                         style="width:32px;height:32px;border-radius:50%;object-fit:cover;margin-left:-6px;border:2px solid #fff;">
    
                @endif
            @empty
                <span class="text-muted">Not Assigned</span>
            @endforelse
    
            @if($count > 3)
            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                 style="width:32px;height:32px;font-size:11px;margin-left:-6px;">
                +{{ $count - 3 }}
            </div>
            @endif
    
        </div>
    </td>
    @endif

    <!--<td>{{ $ticket->creator->name ?? '-' }}</td>-->

    {{-- ACTION --}}
    <td>
    <div class="d-flex gap-1 align-items-center">

        {{-- ASSIGN BUTTON --}}
        @if(($isAdmin || hasPermission('ticket_assign')) && $ticket->status == 'pending')

        <button class="action-btn assignBtn"
            data-id="{{ $ticket->id }}"
            data-type="{{ $ticket->ticket_type }}"
            data-location="{{ $ticket->location->name ?? '' }}"
            data-locationid="{{ $ticket->location_id }}"
            title="Assign">

            <i class="fa fa-user-plus text-dark"></i>
        </button>

        @endif


        {{-- STATUS ACTION BUTTONS --}}
        @if($ticket->status == 'close_request' && $ticket->user_id == auth()->id())

            {{-- CLOSE --}}
            <button class="action-btn btn-close-ticket"
                data-id="{{ $ticket->id }}"
                title="Close Ticket">
                <i class="fa fa-check text-success"></i>
            </button>

            {{-- REOPEN --}}
            <button class="action-btn btn-reopen-ticket"
                data-id="{{ $ticket->id }}"
                title="Reopen Ticket">
                <i class="fa fa-undo text-warning"></i>
            </button>

        @endif


        {{-- VIEW --}}
        <a href="{{ route('tickets.show',$ticket->id) }}"
           class="action-btn">
            <i class="fa fa-eye text-info"></i>
        </a>
        
        {{-- EDIT --}}
        @if(
            ($isAdmin || hasPermission('ticket_edit')) 
            && in_array($ticket->status, ['pending', 'close_request'])
        )
        <a href="{{ route('tickets.edit',$ticket->id) }}"
           class="action-btn">
            <i class="fa fa-edit text-warning"></i>
        </a>
        @endif

        {{-- DELETE --}}
        @if($isAdmin || hasPermission('ticket_delete'))
        <form action="{{ route('tickets.destroy',$ticket->id) }}"
              method="POST">
            @csrf
            @method('DELETE')

            <button type="button" class="action-btn delete-btn">
                <i class="fa fa-trash text-danger"></i>
            </button>
        </form>
        @endif

    </div>
</td>

</tr>

@empty
<tr>
    <td colspan="7" class="text-center text-muted">
        No Tickets Found
    </td>
</tr>
@endforelse