

@php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
@endphp

@section('css')
<link rel="stylesheet" href="{{ asset('css/department.css') }}">
@endsection


<div class="table-responsive">

<table class="table">

<thead>
<tr>
    <th>#</th>
    <th>Department</th>
    <th>Location</th>
    <th>Created By</th>
    <th>Action</th>
</tr>
</thead>

<tbody>

@foreach($departments as $key => $dept)
<tr>

<td>{{ $key + 1 }}</td>

<td>
    <span class="pro-badge">
        {{ $dept->dept_name }}
    </span>
</td>

<td>
    <span class="pro-badge">
        {{ $dept->location->name ?? '-' }}
    </span>
</td>

<td>
    {{ $dept->user->name ?? 'Admin' }}
</td>

<td>
<div class="action-group d-flex gap-1">

@if($isAdmin || hasPermission('department_edit'))
<a href="{{ route('departments.edit', $dept->id) }}"
   class="btn btn-light btn-sm border">
    <i class="fa fa-edit text-warning"></i>
</a>
@endif

@if($isAdmin || hasPermission('department_delete'))
<form action="{{ route('departments.destroy', $dept->id) }}"
      method="POST">

@csrf
@method('DELETE')

<button type="button"
        class="btn btn-light btn-sm border delete-btn">
    <i class="fa fa-trash text-danger"></i>
</button>

</form>
@endif

</div>
</td>

</tr>
@endforeach

</tbody>

</table>

</div>