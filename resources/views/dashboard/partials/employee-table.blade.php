
            <div class="table-responsive">

                <table class="table datatable align-middle" data-table="employee">

                    <thead>
                        <tr style="font-size:13px; background:#f8f9fa;">
                            <th>#</th>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Location</th>
                            <th>Department</th>
                            <th width="150">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($employees as $key => $emp)
                        <tr style="font-size:13px;">

                            <td>{{ $key+1 }}</td>

                            <td>
                                @if($emp->image)
                                    <img src="{{ asset('uploads/employees/'.$emp->image) }}"
                                        style="width:40px; height:40px; border-radius:50%; object-fit:cover; border:1px solid #ddd;">
                                @else
                                    <img src="{{ asset('uploads/employees/user.png') }}"
                                        style="width:40px; height:40px; border-radius:50%; object-fit:cover; border:1px solid #ddd;">
                                @endif
                            </td>

                            <td>
                                <span style="font-weight:500;">
                                    {{ $emp->user->name }}
                                </span>
                            </td>

                            <td style="color:#6c757d;">
                                {{ $emp->user->email }}
                            </td>
                            
                            <td>
                                <span class="badge"
                                      style="background:#e7f1ff; color:#0d6efd; font-weight:500;">
                                    {{ $emp->role->name ?? 'N/A' }}
                                </span>
                            </td>

                            <td>
                                <span class="badge"
                                      style="background:#e7f1ff; color:#0d6efd; font-weight:500;">
                                    {{ $emp->location->name }}
                                </span>
                            </td>

                            <td>
                                <span class="badge"
                                      style="background:#eef2ff; color:#4338ca; font-weight:500;">
                                    {{ $emp->department->dept_name }}
                                </span>
                            </td>

                            <td>
                                <div class="d-flex gap-1">

                                    {{-- VIEW --}}
                                    @if($isAdmin || hasPermission('employee_view_all') || hasPermission('employee_view_own'))
                                    <a href="{{ route('employees.show',$emp->id) }}"
                                       class="btn btn-light btn-sm border"
                                       title="View">
                                       <i class="fa fa-eye text-info"></i>
                                    </a>
                                    @endif

                                    {{-- EDIT --}}
                                    @if($isAdmin || hasPermission('employee_edit'))
                                    <a href="{{ route('employees.edit',$emp->id) }}"
                                       class="btn btn-light btn-sm border"
                                       title="Edit">
                                       <i class="fa fa-edit text-warning"></i>
                                    </a>
                                    @endif

                                    {{-- DELETE --}}
                                    @if($isAdmin || hasPermission('employee_delete'))
                                    <form action="{{ route('employees.destroy',$emp->id) }}"
                                          method="POST"
                                          class="delete-form">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button"
                                                class="btn btn-light btn-sm border delete-btn"
                                                title="Delete">
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