@extends('layouts.master')

@section('title','Edit Group')

@section('content')
@section('css')
<link rel="stylesheet" href="{{ asset('css/group.css') }}?v={{ time() }}">
<style>
/* Force Select2 to 100% width and align properly */
.select2-container {
    width: 100% !important;
}
.select2-container .select2-selection--single {
    height: 42px !important;
    border-radius: 10px !important;
    border: 1px solid #dbe3ec !important;
    display: flex;
    align-items: center;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: normal !important;
    padding-left: 12px;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 40px !important;
}
</style>
@endsection

@php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
@endphp

@if($isAdmin || hasPermission('group_edit'))

<x-breadcrumb title="Group Management" page="Edit Group" />
<hr>

<div class="row">
<div class="col-md-10 m-auto">

<div class="white_shd full p-4 shadow-sm">

<h4 class="mb-3">
<i class="fa fa-edit text-primary"></i> Edit Group
</h4>

<form method="POST" action="{{ route('groups.update',$group->id) }}">
@csrf
@method('PUT')

<!-- GROUP NAME -->
<div class="mb-3">
<label>Group Name</label>

<input type="text"
name="group_name"
value="{{ old('group_name',$group->group_name) }}"
class="form-control @error('group_name') is-invalid @enderror">

@error('group_name')
<small class="text-danger">{{ $message }}</small>
@enderror
</div>

<!-- LOCATION -->
<div class="mb-3">
<label>Select Location</label>

<select name="location_id"
id="location_id"
class="form-control custom-select2 @error('location_id') is-invalid @enderror">

<option value="">Select Location</option>

@foreach($locations as $location)
<option value="{{ $location->id }}"
{{ $group->location_id == $location->id ? 'selected' : '' }}>
{{ $location->name }}
</option>
@endforeach

</select>

@error('location_id')
<small class="text-danger">{{ $message }}</small>
@enderror
</div>

<!-- DEPARTMENT -->
<div class="mb-3" id="department_div">
<label>Select Department (Optional)</label>

<select name="department_id"
id="department_id"
class="form-control custom-select2 @error('department_id') is-invalid @enderror">

<option value="">Select Department (Optional)</option>

@foreach($departments as $department)
<option value="{{ $department->id }}"
{{ $group->department_id == $department->id ? 'selected' : '' }}>
{{ $department->dept_name }}
</option>
@endforeach

</select>

@error('department_id')
<small class="text-danger">{{ $message }}</small>
@enderror
</div>

<!-- EMPLOYEE -->
<div class="mb-3" id="employee_div">
<label>Select Employees</label>

<select name="employees[]"
id="employees"
multiple
class="form-control select2 @error('employees') is-invalid @enderror">

@foreach($employees as $emp)
<option value="{{ $emp->id }}"
{{ in_array($emp->id,$group->employees->pluck('id')->toArray()) ? 'selected' : '' }}>
{{ $emp->user->name }}
</option>
@endforeach

</select>

@error('employees')
<small class="text-danger">{{ $message }}</small>
@enderror
</div>

<div class="text-end">

<a href="{{ route('groups.index') }}"
class="btn btn-light border btn-sm">
Cancel
</a>

<button class="btn btn-primary btn-sm">
Update Group
</button>

</div>

</form>

</div>
</div>
</div>

@else

<div class="alert alert-danger">
    You do not have permission to edit group.
</div>

@endif

@endsection


@section('script')

<script>
$(document).ready(function(){

// Initialize custom select2 for single dropdowns to avoid master.blade.php global placeholder
$('.custom-select2').select2({
    width: '100%'
});

// Fetch employees function
function fetchEmployees(locationId, departmentId) {
    $('#employees').html('<option>Loading...</option>');
    if (locationId != '') {
        $('#employee_div').show();
        let dep = departmentId ? departmentId : 'all';
        $.ajax({
            url: "/groups/get-employees/" + locationId + "/" + dep,
            type: "GET",
            success: function(response) {
                let html = '';
                if (response.length > 0) {
                    // We need to keep the currently selected employees selected if we fetch anew, 
                    // but usually in edit they just use select2 normally. 
                    // Since it's AJAX fetching, we overwrite options.
                    $.each(response, function(key, row) {
                        html += '<option value="' + row.id + '">' + row.user.name + '</option>';
                    });
                } else {
                    html = '<option value="">No Employee Found</option>';
                }
                $('#employees').html(html).trigger('change');
            }
        });
    } else {
        $('#employee_div').hide();
        $('#employees').trigger('change');
    }
}

// LOCATION CHANGE
$('#location_id').change(function(){

let locationId = $(this).val();

$('#department_id').html('<option>Loading...</option>').trigger('change');
$('#employees').html('').trigger('change');
$('#employee_div').hide();

if(locationId != '')
{
    $('#employee_div').show();
    $.ajax({
    url: "/groups/get-departments/" + locationId,
    type: "GET",

    success:function(response)
    {
    let html = '<option value="">Select Department (Optional)</option>';

    $.each(response,function(key,row){
    html += '<option value="'+row.id+'">'+row.dept_name+'</option>';
    });

    $('#department_id').html(html).trigger('change');
    }
    });
    
    // Fetch Employees for Location
    fetchEmployees(locationId, '');
}
});


// DEPARTMENT CHANGE
$('#department_id').change(function(){

let departmentId = $(this).val();
let locationId   = $('#location_id').val();

fetchEmployees(locationId, departmentId);

});

});
</script>

@endsection