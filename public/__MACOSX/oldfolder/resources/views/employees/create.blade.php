@extends('layouts.master')

@section('title','Add Employee')

@section('css')
<!-- ADD -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<link rel="stylesheet" href="{{ asset('css/employee.css') }}">
@endsection

@section('content')

@php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
@endphp

@if($isAdmin || hasPermission('employee_add'))

<x-breadcrumb title="Employee" page="Add Employee"/>

<hr>

<div class="row">
<div class="col-md-12">
<div class="main-card">

<!-- HEADER -->
<div class="form-header mb-2">
    <h4><i class="fa fa-user-plus me-1"></i> Add New Employee</h4>
    <small>Fill all required details carefully</small>
</div>

<div class="section-line"></div>

<!-- FORM -->
<form method="POST" enctype="multipart/form-data" action="{{ route('employees.store') }}">
@csrf

<div class="row">

<!-- NAME -->
<div class="col-md-4 form-group mb-3">
<label class="form-label">Name</label>
<input type="text"
       name="name"
       value="{{ old('name') }}"
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
       value="{{ old('email') }}"
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
       value="{{ old('mobile') }}"
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
{{ old('location_id') == $loc->id ? 'selected' : '' }}>
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

<option value="">Select Location First</option>

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
{{ old('role_id') == $role->id ? 'selected' : '' }}>
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
<option value="male" {{ old('gender')=='male' ? 'selected' : '' }}>Male</option>
<option value="female" {{ old('gender')=='female' ? 'selected' : '' }}>Female</option>
<option value="other" {{ old('gender')=='other' ? 'selected' : '' }}>Other</option>

</select>

@error('gender')
<small class="text-danger">{{ $message }}</small>
@enderror
</div>


  <!-- CUSTOM DASHBOARD -->
<div class="field-box">

    <label class="form-label">Custom Dashboard</label>

    <select name="dashboard_ids[]"
            class="form-control choices"
            multiple>

        @foreach($customdashboards as $customdashboard)

            <option value="{{ $customdashboard->id }}"
                {{ collect(old('dashboard_ids'))->contains($customdashboard->id) ? 'selected' : '' }}>

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
       value="{{ old('joining_date') }}"
       class="form-control @error('joining_date') is-invalid @enderror">

@error('joining_date')
<small class="text-danger">{{ $message }}</small>
@enderror
</div>

<!-- ADDRESS -->
<div class="col-md-12 form-group mb-3">
<label class="form-label">Address</label>

<textarea name="address"
          rows="3"
          class="form-control @error('address') is-invalid @enderror">{{ old('address') }}</textarea>

@error('address')
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

<img id="previewImg" class="preview-img mt-2" style="display:none; width:80px;">

@error('image')
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
<i class="fa fa-save me-1"></i> Save Employee
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

<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
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

/* LOCATION WISE DEPARTMENT LOAD */
$(document).ready(function () {

    function loadDepartments(locationId, selectedDepartment = '')
    {
        $('#department_id').html('<option>Loading...</option>');

        $.ajax({
            url: "{{ route('employees.departments','') }}/" + locationId,
            type: "GET",
            success: function (response)
            {
                let html = '<option value="">Select Department</option>';

                $.each(response, function (key, row) {

                    let selected = selectedDepartment == row.id ? 'selected' : '';

                    html += '<option value="' + row.id + '" '+selected+'>' + row.dept_name + '</option>';
                });

                $('#department_id').html(html);
            },
            error:function(){
                $('#department_id').html('<option value="">No Department Found</option>');
            }
        });
    }

    $('#location_id').change(function () {

        let locationId = $(this).val();

        if(locationId != '')
        {
            loadDepartments(locationId);
        }
        else
        {
            $('#department_id').html('<option value="">Select Location First</option>');
        }
    });

    let oldLocation   = "{{ old('location_id') }}";
    let oldDepartment = "{{ old('department_id') }}";

    if(oldLocation != '')
    {
        loadDepartments(oldLocation, oldDepartment);
    }

});

////////////////////////////// CHOICE /////////////////////////////

    new Choices('#dashboard_ids', {
        removeItemButton: true,
        placeholderValue: 'Select Dashboard',
        searchPlaceholderValue: 'Search Dashboard',
    });


</script>

@endsection