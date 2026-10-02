@extends('layouts.master')

@section('title','Tickets')

@section('css')
<link rel="stylesheet" href="{{ asset('css/ticket.css') }}">

<style>

/* PAGE */
body{
    background:#f5f7fb;
}

/* MAIN CARD */
.white_shd{
    background:#ffffff;
    border-radius:14px;
    box-shadow:0 8px 24px rgba(0,0,0,0.06);
    border:1px solid #eef1f6;
}

/* FILTER CARD */
.card{
    border-radius:14px !important;
    background:#ffffff;
    box-shadow:0 4px 18px rgba(0,0,0,0.04);
}

/* LABEL */
label{
    font-size:13px;
    font-weight:600;
    color:#495057;
}

/* INPUT */
.form-control,
.form-control-sm,
.select2-selection{
    border:1px solid #dfe3ea !important;
    border-radius:10px !important;
    min-height:40px;
    font-size:13px;
    box-shadow:none !important;
}

.form-control:focus{
    border-color:#4c8bf5 !important;
    box-shadow:0 0 0 0.15rem rgba(76,139,245,.15) !important;
}

/* BUTTON */
.btn{
    border-radius:10px !important;
    font-size:13px;
    font-weight:600;
    padding:8px 14px;
}

.btn-primary{
    background:linear-gradient(135deg,#0d6efd,#0b57d0);
    border:none;
}

.btn-primary:hover{
    opacity:.95;
}

.action-btn{
    width: 34px;
    height: 34px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    background: #fff;
    color: #374151;
    transition: all 0.2s ease-in-out;
    font-size: 14px;
    margin-right: 4px;
}

/* hover */
.action-btn:hover{
    transform: translateY(-1px);
    background: #f9fafb;
    box-shadow: 0 3px 8px rgba(0,0,0,0.08);
}

/* assign special hover color */
.assignBtn:hover{
    color: #16a34a;
    border-color: #16a34a;
}

/* edit */
.btn-edit:hover{
    color: #f59e0b;
    border-color: #f59e0b;
}

/* delete */
.btn-delete:hover{
    color: #ef4444;
    border-color: #ef4444;
}

/* TABLE WRAPPER */
.table-responsive{
    width:100%;
    overflow-x:auto;
    border-radius:14px;
    border:1px solid #edf0f5;
}

/* TABLE */
.table{
    width:100% !important;
    margin:0 !important;
    border-collapse:separate !important;
    border-spacing:0;
    background:#fff;
}

/* HEADER */
.table thead th{
    background:#f8faff !important;
    color:#344054;
    font-size:13px;
    font-weight:700;
    white-space:nowrap;
    padding:14px 12px !important;
    border-bottom:1px solid #e9edf3 !important;
    vertical-align:middle;
}

/* BODY */
.table tbody td{
    padding:14px 12px !important;
    font-size:13px;
    color:#444;
    white-space:nowrap;
    border-bottom:1px solid #f1f3f7;
    vertical-align:middle !important;
}

.table tbody tr:hover{
    background:#fafcff;
    transition:0.2s;
}

/* BADGES */
.badge{
    background:#eef4ff;
    color:#000;
    font-size:11px;
    padding:6px 10px;
    border-radius:30px;
}

/* STATUS BADGES */
.status-badge{
    padding:6px 12px;
    border-radius:30px;
    font-size:11px;
    font-weight:700;
    display:inline-block;
    letter-spacing:.2px;
}

.status-assigned{ background:#dbeafe; color:#1d4ed8; }
.status-in-progress{ background:#fef3c7; color:#92400e; }
.status-hold{ background:#e5e7eb; color:#374151; }
.status-close-request{ background:#fee2e2; color:#b91c1c; }
.status-closed{ background:#dcfce7; color:#15803d; }
.status-reopen{ background:#ffedd5; color:#c2410c; }

/* CHANGE BUTTON */
.changeStatusBtn{
    font-size:11px;
    padding:5px 10px;
    border-radius:8px;
    margin-left:6px;
}

/* ACTION BUTTONS */
.table .btn-light{
    width:34px;
    height:34px;
    padding:0;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:10px !important;
    background:#fff;
    border:1px solid #e5e7eb;
}

.table .btn-light:hover{
    background:#f8fafc;
}

/* ASSIGN BTN */
.assign-btn{
    background:#198754;
    color:#fff;
    border:none;
}

.assign-btn:hover{
    background:#157347;
    color:#fff;
}

/* IMAGE STACK */
.table img{
    width:34px !important;
    height:34px !important;
    border-radius:50%;
    object-fit:cover;
    border:2px solid #fff;
    box-shadow:0 2px 6px rgba(0,0,0,0.12);
}

/* MODAL */
.modal-content{
    border:none;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 20px 40px rgba(0,0,0,.15);
}

.modal-header{
    background:#f8faff;
    border-bottom:1px solid #eef1f5;
}

.modal-title{
    font-size:18px;
    font-weight:700;
}


select option:disabled {
    color: #aaa;
}

/* MOBILE */
@media(max-width:768px){

    .btn{
        font-size:12px;
        padding:7px 10px;
    }

    .table thead th,
    .table tbody td{
        font-size:12px;
        padding:10px 8px !important;
    }

    .white_shd{
        padding:12px !important;
    }
}
</style>
@endsection
@section('content')

@php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
@endphp

@if($isAdmin || hasPermission('ticket_view_all') || hasPermission('ticket_view_own'))

<x-breadcrumb title="Ticket Management" page="Ticket List" />

<div class="mt-2"></div>

<div class="row">
<div class="col-md-12">

<div class="white_shd full margin_bottom_30 p-3 shadow-sm">

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-3">

    <div></div>

    @if($isAdmin || hasPermission('ticket_add'))
    <a href="{{ route('tickets.create') }}"
       class="btn btn-primary btn-sm"
       style="border-radius:6px;">
        <i class="fa fa-plus me-1"></i> Create Ticket
    </a>
    @endif

</div>
<!--{ ================== FILTER START=============================}-->
<div class="card p-3 mb-3 shadow-sm border-0">

    <div class="row g-3 align-items-end">

        <div class="col-md-3">
            <label class="small mb-1">Location</label>
            <select id="filter_location" class="form-control form-control-sm">
                <option value="">All Location</option>
                @foreach($locations as $loc)
                    <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label class="small mb-1">Group</label>
            <select id="filter_group" class="form-control form-control-sm">
                <option value="">All Group</option>
                @foreach($groups as $grp)
                    <option value="{{ $grp->id }}">{{ $grp->group_name }}</option>
                @endforeach
            </select>
        </div>

        

    </div>

</div>
<!--{ ================== FILTER END=============================}-->

<!-- TABLE -->
<div class="table-responsive w-100">

<table class="table datatable align-middle w-100" id="ticketTable" data-table="ticket">

<thead>
<tr style="font-size:13px; background:#f8f9fa;">
    <th>#</th>
    <th>Title</th>
    <th>Type</th>
    <!--<th>Priority</th>-->
    <th>Status</th>
    <!--<th>Department</th>-->
    <th>Location</th>
    <th>Group</th>
    @if($isAdmin)
    <th>Assigned To</th>
    @endif
    <!--<th>Created By</th>-->
    <th width="200">Action</th>
</tr>
</thead>

<tbody id="ticketTableBody">

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
            title="Assign" style="cursor: pointer;">

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

            <button type="button" class="action-btn delete-btn" style="cursor: pointer;">
                <i class="fa fa-trash text-danger"></i>
            </button>
        </form>
        @endif

    </div>
</td>

</tr>

@empty

@endforelse

</tbody>
</table>

</div>
</div>
</div>
</div>

<!--{{-- ================= MODAL ================= --}}-->
<div class="modal fade" id="assignModal">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title">Assign Ticket</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button>

</div>

<div class="modal-body">

<input type="hidden" id="ticket_id">
<input type="hidden" id="ticket_type">

{{-- TICKET TYPE FIELD (modal me add karo) --}}
<div class="mb-3">
    <label class="mb-1">Ticket Type</label>
    <select id="ticket_type_show" class="form-control" disabled>
        <option value="">Select</option>
        <option value="individual">Individual</option>
        <option value="location">Location</option>
    </select>
</div>

{{-- LOCATION SHOW FIELD (Ticket Type ke neeche modal me add karo) --}}
<div class="mb-3 d-none" id="ticket_location_show_box">
    <label class="mb-1">Selected Location</label>
    <input type="text" id="ticket_location_show" class="form-control" readonly>
</div>

<input type="hidden" id="ticket_type">

{{-- MODE (ONLY LOCATION TYPE) --}}
<div id="mode_box" class="d-none mb-3">
    <label class="mb-1">Assign Mode</label>
    <select id="assign_mode" class="form-control">
        <option value="">Select</option>
        <option value="location_wise">Location Wise</option>
        <option value="group_team">Group / Team</option>
    </select>
</div>

{{-- INDIVIDUAL --}}
<div id="employee_box" class="d-none mb-3">
    <label class="mb-1">Employees</label>
    <select id="employee_id" class="form-control select2" multiple>
        @foreach($employees as $emp)
            <option value="{{ $emp->id }}">
                {{ $emp->user->name }}
            </option>
        @endforeach
    </select>
</div>

{{-- LOCATION --}}
<div id="location_box" class="d-none mb-3">
    <label class="mb-1">Location</label>
    <select id="location_id" class="form-control select2">
        <option value="">Select</option>
        @foreach($locations as $loc)
            <option value="{{ $loc->id }}">
                {{ $loc->name }}
            </option>
        @endforeach
    </select>
</div>

{{-- LOCATION EMPLOYEES --}}
<div id="location_emp_box" class="d-none mb-3">
    <label class="mb-1">Employees</label>
    <select id="location_employees" class="form-control select2" multiple></select>
</div>

{{-- GROUP / TEAM --}}
<div id="group_box" class="d-none mb-3">
    <label class="mb-1">Group / Team</label>
    <select id="group_id" class="form-control select2">
        <option value="">Select</option>
    </select>
</div>

</div>

<div class="modal-footer">
<button type="button" class="btn btn-primary" id="saveAssign">Assign</button>
</div>

</div>
</div>
</div>

<!--{-- ================= MODAL 2================= --}}-->
<div class="modal fade" id="statusModal">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
    <h5 class="modal-title">Update Ticket Status</h5>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<div class="modal-body">

    <input type="hidden" id="status_ticket_id">

    <label class="mb-2">Select Status</label>

    <select class="form-control status_select" id="status_select">
</select>

</div>

<div class="modal-footer">
    <button class="btn btn-primary" id="updateStatus">Update</button>
</div>

</div>
</div>
</div>

@else

<div class="alert alert-danger">
    You do not have permission to view ticket list.
</div>

@endif


@endsection

{{-- ================= SCRIPT ================= --}}

@section('script')
<script>
    
$(document).ready(function(){

let employees = @json($employees);
let groups    = @json($groups);

/* OPEN MODAL */
// $('.assignBtn').click(function(){
$(document).on('click', '.assignBtn', function () {

    /* ===== RESET ALL FIELDS FIRST ===== */
    $('#employee_id').val(null).trigger('change');
    $('#location_employees').html('').val(null).trigger('change');
    $('#group_id').html('<option value="">Select</option>').val('').trigger('change');
    $('#assign_mode').val('');
    $('#ticket_location_show').val('');

    let id         = $(this).data('id');
    let type       = $(this).data('type');
    let locationId = $(this).data('locationid');
    let location   = $(this).data('location');

    $('#ticket_id').val(id);
    $('#ticket_type').val(type);
    $('#ticket_type_show').val(type);
    $('#ticket_location_show').val(location);

    $('#mode_box,#employee_box,#location_emp_box,#group_box,#ticket_location_show_box')
    .addClass('d-none');

    if(type == 'individual'){
        $('#employee_box').removeClass('d-none');
    }

    if(type == 'location'){
        $('#mode_box').removeClass('d-none');
        $('#ticket_location_show_box').removeClass('d-none');
    }

    $('#assignModal').data('locationid', locationId);

    $('#assignModal').modal('show');
});


/* MODE CHANGE */
$('#assign_mode').change(function(){

    let mode       = $(this).val();
    let locationId = $('#assignModal').data('locationid');

    $('#location_emp_box,#group_box').addClass('d-none');

    /* LOCATION WISE */
    if(mode == 'location_wise'){

        let html = '';

        employees.forEach(function(emp){

            if(emp.location_id == locationId){
                html += `<option value="${emp.id}">
                            ${emp.user.name}
                         </option>`;
            }

        });

        $('#location_employees').html(html);
        $('#location_emp_box').removeClass('d-none');
    }

    /* GROUP TEAM */
    if(mode == 'group_team'){

        let html = '<option value="">Select</option>';

        groups.forEach(function(group){

            if(group.location_id == locationId){
                html += `<option value="${group.id}">
                            ${group.group_name}
                         </option>`;
            }

        });

        $('#group_id').html(html);
        $('#group_box').removeClass('d-none');
    }

});

});

$(document).on('click', '#saveAssign', function () {

    let ticket_id   = $('#ticket_id').val();
    let ticket_type = $('#ticket_type').val();

    let assign_type = '';
    let employee_id = [];
    let group_id    = '';

    if(ticket_type == 'individual'){

        assign_type = 'individual';
        employee_id = $('#employee_id').val() || [];

        if(employee_id.length == 0){
            alert('Please select at least one employee');
            return;
        }

    } else {

        assign_type = $('#assign_mode').val();

        if(assign_type == 'location_wise'){
            employee_id = $('#location_employees').val() || [];

            if(employee_id.length == 0){
                alert('Please select employee');
                return;
            }
        }

        if(assign_type == 'group_team'){
            group_id = $('#group_id').val();

            if(!group_id){
                alert('Please select group');
                return;
            }
        }
    }

    $.ajax({
        url: "{{ route('tickets.assign') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            ticket_id: ticket_id,
            assign_type: assign_type,
            employee_id: employee_id,
            group_id: group_id
        },
        success: function(res){
            alert('Assigned Successfully');
            $('#assignModal').modal('hide');
            location.reload();
        },
        error: function(){
            alert('Something went wrong');
        }
    });

});
//  { =========================== FILTER JS START===========================}
function loadTickets(){

    $.ajax({
        url: "{{ route('tickets.filter') }}",
        type: "GET",
        data: {
            location_id: $('#filter_location').val(),
            group_id: $('#filter_group').val()
        },

        beforeSend: function(){
            $('#ticketTableBody').html(`
                <tr>
                    <td colspan="9" class="text-center text-muted">
                        Loading...
                    </td>
                </tr>
            `);
        },

        success: function(res){
            $('#ticketTableBody').html(res.html);
        }
    });

}

$('#filter_location, #filter_group').on('change', function(){
    loadTickets();
});

// { =========================== FILTER JS END===========================}

// { ========================= STATUS ============================== }
function updateStatus(ticketId, status){

    $.ajax({
        url: "{{ route('tickets.updateStatus') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            ticket_id: ticketId,
            status: status
        },
        success: function(res){
            if(res.success){
                alert(res.message);
                location.reload();
            }
        },
        error: function(){
            alert('Something went wrong');
        }
    });
}

$(document).on('click', '.changeStatusBtn', function(){

    let ticketId = $(this).data('id');

    $.ajax({
        url: "{{ route('tickets.status.options') }}", // new route
        type: "GET",
        data: {
            ticket_id: ticketId
        },
        success: function(res){

            let options = '';

            if(res.options.length === 0){
                options = '<option disabled>No actions available</option>';
            } else {

                options += '<option value="">Select status</option>';

                res.options.forEach(function(st){
                    options += `<option value="${st}">${st.replace('_',' ')}</option>`;
                });
            }

            $('#status_select').html(options);
            $('#status_ticket_id').val(ticketId);
            $('#statusModal').modal('show');
        }
    });
});

// CLOSE CONFIRM
$(document).on('click', '.btn-close-ticket', function(){

    let id = $(this).data('id');

    if(!confirm('Are you sure you want to close this ticket?')) return;

    updateStatus(id, 'closed');
});


// REOPEN CONFIRM
$(document).on('click', '.btn-reopen-ticket', function(){

    let id = $(this).data('id');

    if(!confirm('Reopen this ticket?')) return;

    updateStatus(id, 'reopen');
});


// COMMON FUNCTION
$(document).on('click', '#updateStatus', function(){

    let ticketId = $('#status_ticket_id').val();
    let status   = $('#status_select').val();

    if(!status){
        alert('Please select status');
        return;
    }

    $.ajax({
        url: "{{ route('tickets.updateStatus') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            ticket_id: ticketId,
            status: status
        },

        beforeSend: function(){
            $('#updateStatus').text('Updating...');
        },

       success: function(res){

    $('#statusModal').modal('hide');

    if(res.success){
        alert(res.message);   
    }

    location.reload();
},

        error: function(xhr){
            console.log(xhr.responseText);
            alert('Not allowed or something went wrong');
        },

        complete: function(){
            $('#updateStatus').text('Update');
        }
    });

});

let allOptions = [
    {value:'in_progress', label:'In Progress'},
    {value:'hold', label:'Hold'},
    {value:'close_request', label:'Close Request'}
];

let current = status;

let options = '<option value="">Select status</option>';

allOptions.forEach(function(opt){

    let disabled = '';

    // logic based on current status
    if(current == 'in_progress' && opt.value == 'in_progress'){
        disabled = 'disabled';
    }

    if(current == 'assigned'){
        if(opt.value == 'assigned') disabled = 'disabled';
    }

    options += `<option value="${opt.value}" ${disabled}>${opt.label}</option>`;
});

$('#status_select').html(options);
</script>


@endsection


