
@php
$user = Auth::user();
$isAdmin = $user->user_type == 'admin';
@endphp

@section('css')
<link rel="stylesheet" href="{{ asset('css/location.css') }}">
@endsection

<div class="table-responsive">

<table class="table table-bordered">

<thead>
<tr>
    <th>#</th>
    <th>Location Name</th>
    <th>Created By</th>
    <th>Action</th>
</tr>
</thead>

<tbody>

@foreach($locations as $key => $location)
<tr>

<td>{{ $key + 1 }}</td>

<td>
    <span class="pro-badge">
        {{ $location->name }}
    </span>
</td>

<td>
    {{ $location->user->name ?? 'Admin' }}
</td>

<td>
<div class="action-group d-flex align-items-center gap-1">

@if($isAdmin || hasPermission('location_edit'))
<a href="{{ route('locations.edit', $location->id) }}"
   class="btn btn-light btn-sm border">
    <i class="fa-solid fa-pen text-warning"></i>
</a>
@endif

@if($isAdmin || hasPermission('location_delete'))
<form action="{{ route('locations.destroy', $location->id) }}"
      method="POST"
      class="delete-form m-0">

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