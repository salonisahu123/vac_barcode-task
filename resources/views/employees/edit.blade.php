@extends('layouts.master')

@section('title','Edit Employee')

@section('css')
<link rel="stylesheet" href="{{ asset('css/employee.css') }}">
@endsection

@section('content')

@php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
@endphp

@if($isAdmin || hasPermission('employee_edit'))

<x-breadcrumb title="Employee" page="Edit Employee"/>

<hr>

<div class="row">
<div class="col-md-12">
<div class="main-card">

<!-- HEADER -->
<div class="form-header mb-2">
    <h4><i class="fa fa-user-edit me-1"></i> Edit Employee</h4>
    <small>Update employee details carefully</small>
</div>

<div class="section-line"></div>

<!-- FORM -->
<form method="POST"
      enctype="multipart/form-data"
      action="{{ route('employees.update',$employee->id) }}">

@csrf
@method('PUT')

<div class="row">

<!-- NAME -->
<div class="col-md-4 form-group mb-3">
<label class="form-label">Name</label>

<input type="text"
       name="name"
       value="{{ old('name',$employee->user->name) }}"
       class="form-control @error('name') is-invalid @enderror">

@error('name')
<small class="text-danger">{{ $message }}</small>
@enderror
</div>

<!-- EMAIL -->
<div class="col-md-4 form-group mb-3">
<label class="form-label">Email</label>

<input type="email"
       name="email"
       value="{{ old('email',$employee->user->email) }}"
       class="form-control @error('email') is-invalid @enderror">

@error('email')
<small class="text-danger">{{ $message }}</small>
@enderror
</div>

<!-- MOBILE -->
<div class="col-md-4 form-group mb-3">
<label class="form-label">Mobile</label>

<input type="text"
       name="mobile"
       value="{{ old('mobile',$employee->user->mobile) }}"
       class="form-control @error('mobile') is-invalid @enderror">

@error('mobile')
<small class="text-danger">{{ $message }}</small>
@enderror
</div>

<!-- PASSWORD -->
<div class="col-md-4 form-group mb-3">
<label class="form-label">Password</label>

<div class="position-relative">

<input type="password"
       name="password"
       id="password"
       placeholder="Leave blank to keep old password"
       class="form-control @error('password') is-invalid @enderror">

<span onclick="togglePassword()" class="eye-icon">
<i class="fa fa-eye" id="eyeIcon"></i>
</span>

</div>

@error('password')
<small class="text-danger">{{ $message }}</small>
@enderror
</div>

<!-- LOCATION -->
<div class="col-md-4 form-group mb-3">
<label class="form-label">Location</label>

<select name="location_id"
        id="location_id"
        class="form-control @error('location_id') is-invalid @enderror">

<option value="">Select Location</option>

@foreach($locations as $loc)
<option value="{{ $loc->id }}"
{{ old('location_id',$employee->location_id) == $loc->id ? 'selected' : '' }}>
{{ $loc->name }}
</option>
@endforeach

</select>

@error('location_id')
<small class="text-danger">{{ $message }}</small>
@enderror
</div>

<!-- DEPARTMENT -->
<div class="col-md-4 form-group mb-3">
<label class="form-label">Department</label>

<select name="department_id"
        id="department_id"
        class="form-control @error('department_id') is-invalid @enderror">

<option value="">Loading...</option>

</select>

@error('department_id')
<small class="text-danger">{{ $message }}</small>
@enderror
</div>

<!-- ROLE -->
<div class="col-md-4 form-group mb-3">
<label class="form-label">Role</label>

<select name="role_id"
        class="form-control @error('role_id') is-invalid @enderror">

<option value="">Select Role</option>

@foreach($roles as $role)
<option value="{{ $role->id }}"
{{ old('role_id',$employee->role_id) == $role->id ? 'selected' : '' }}>
{{ $role->name }}
</option>
@endforeach

</select>

@error('role_id')
<small class="text-danger">{{ $message }}</small>
@enderror
</div>

<!-- GENDER -->
<div class="col-md-4 form-group mb-3">
<label class="form-label">Gender</label>

<select name="gender"
class="form-control @error('gender') is-invalid @enderror">

<option value="">Select Gender</option>

<option value="male"
{{ old('gender',$employee->gender)=='male' ? 'selected' : '' }}>
Male
</option>

<option value="female"
{{ old('gender',$employee->gender)=='female' ? 'selected' : '' }}>
Female
</option>

<option value="other"
{{ old('gender',$employee->gender)=='other' ? 'selected' : '' }}>
Other
</option>

</select>

@error('gender')
<small class="text-danger">{{ $message }}</small>
@enderror
</div>

<!-- IS ACTIVE -->
<div class="col-md-4 form-group mb-3">
    <label class="form-label d-block" style="opacity: 0; pointer-events: none;">Status</label>
    <div class="form-check d-flex align-items-center h-100" style="min-height: 44px; margin-top: -10px;">
        <input class="form-check-input mt-0 me-2" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $employee->user->is_active) ? 'checked' : '' }} style="width: 20px; height: 20px; cursor: pointer;">
        <label class="form-check-label mb-0" for="is_active" style="cursor: pointer; padding-top: 2px; font-weight: 500; color: #475569;">
            Active Employee
        </label>
    </div>
</div>

<!-- CUSTOM DASHBOARD -->
<div class="col-md-4 form-group mb-3">

    <label class="form-label">Custom Dashboard</label>

    <select name="dashboard_ids[]" class="form-control choices" multiple>

        @foreach($customdashboards as $customdashboard)

            <option value="{{ $customdashboard->id }}"
                {{ in_array($customdashboard->id, $assignedDashboards ?? []) ? 'selected' : '' }}>

                {{ $customdashboard->dash_name }}

            </option>

        @endforeach

    </select>

    @error('dashboard_ids')
        <small class="text-danger">{{ $message }}</small>
    @enderror

</div>

<!-- JOINING DATE -->
<div class="col-md-4 form-group mb-3">
<label class="form-label">Joining Date</label>

<input type="date"
       name="joining_date"
       value="{{ old('joining_date',$employee->joining_date) }}"
       class="form-control @error('joining_date') is-invalid @enderror">

@error('joining_date')
<small class="text-danger">{{ $message }}</small>
@enderror
</div>

<!-- IMAGE -->
<div class="col-md-4 form-group mb-3">
<label class="form-label">Image</label>

<input type="file"
       name="image"
       class="form-control @error('image') is-invalid @enderror"
       onchange="previewImage(event)">

@error('image')
<small class="text-danger">{{ $message }}</small>
@enderror

<img id="previewImg"
     class="preview-img mt-2"
     src="{{ $employee->image ? asset('uploads/employees/'.$employee->image) : '' }}"
     style="{{ $employee->image ? 'display:block;width:80px;' : 'display:none;width:80px;' }}">
</div>

<!-- ADDRESS -->
<div class="col-md-12 form-group mb-3">
<label class="form-label">Address</label>

<textarea name="address"
          rows="3"
          class="form-control @error('address') is-invalid @enderror">{{ old('address',$employee->user->address) }}</textarea>

@error('address')
<small class="text-danger">{{ $message }}</small>
@enderror
</div>

</div>

<div class="section-line"></div>

<!-- BUTTON -->
<div class="button-group">

<a href="{{ route('employees.index') }}"
class="btn btn-light border btn-sm">
Cancel
</a>

<button class="btn btn-primary btn-sm">
<i class="fa fa-save me-1"></i> Update Employee
</button>

</div>

</form>

</div>
</div>
</div>

@else

<div class="alert alert-danger">
    You do not have permission to access this page.
</div>

@endif

@endsection


@section('script')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

/* PASSWORD SHOW HIDE */
function togglePassword()
{
    let pass = document.getElementById('password');
    let icon = document.getElementById('eyeIcon');

    if(pass.type === 'password')
    {
        pass.type = 'text';
        icon.classList.replace('fa-eye','fa-eye-slash');
    }
    else
    {
        pass.type = 'password';
        icon.classList.replace('fa-eye-slash','fa-eye');
    }
}

/* IMAGE PREVIEW */
function previewImage(event)
{
    let img = document.getElementById('previewImg');

    img.src = URL.createObjectURL(event.target.files[0]);
    img.style.display = 'block';
}

/* LOCATION WISE DEPARTMENT */
$(document).ready(function () {

    function loadDepartments(locationId, selectedDepartment = '')
    {
        $('#department_id').html('<option>Loading...</option>');

        $.ajax({
            url: "{{ route('employees.departments','') }}/" + locationId,
            type: "GET",

            success:function(response)
            {
                let html = '<option value="">Select Department</option>';

                $.each(response, function(key,row){

                    let selected =
                        selectedDepartment == row.id ? 'selected' : '';

                    html += '<option value="'+row.id+'" '+selected+'>'
                         + row.dept_name +
                         '</option>';
                });

                $('#department_id').html(html);
            },

            error:function(){
                $('#department_id').html(
                    '<option value="">No Department Found</option>'
                );
            }
        });
    }

    $('#location_id').change(function(){

        let locationId = $(this).val();

        if(locationId != '')
        {
            loadDepartments(locationId);
        }
        else
        {
            $('#department_id').html(
                '<option value="">Select Location First</option>'
            );
        }
    });

    let oldLocation =
        "{{ old('location_id',$employee->location_id) }}";

    let oldDepartment =
        "{{ old('department_id',$employee->department_id) }}";

    if(oldLocation != '')
    {
        loadDepartments(oldLocation, oldDepartment);
    }

});

</script>

@endsection