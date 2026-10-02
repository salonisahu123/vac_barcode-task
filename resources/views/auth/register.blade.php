@extends('layouts.master')

@section('title','Users Table')

@section('content')

<div class="midde_cont">
   <div class="container-fluid">

      <div class="row column_title">
         <div class="col-md-12">
            <div class="page_title">
               <h2>Users Table</h2>
            </div>
         </div>
      </div>

      {{-- SUCCESS MESSAGE --}}
      @if(session('success'))
      <div class="alert alert-success">
         {{ session('success') }}
      </div>
      @endif

      <div class="row">

         <div class="col-md-12">
            <div class="white_shd full margin_bottom_30">

               <div class="full graph_head d-flex justify-content-between align-items-center">
                  <div class="heading1 margin_0">
                     <h2>Users</h2>
                  </div>
                  <div>
                     <a href="{{ route('add.users') }}" class="btn btn-primary">Create User</a>
                  </div>
               </div>

               <div class="table_section padding_infor_info">
                  <div class="table-responsive-sm">

                     <table class="table">
                        <thead>
                           <tr>
                              <th>S. No</th>
                              <th>Name Of User</th>
                              <th>Mobile No</th>
                              <th>Email</th>
                              <th>Permanent Address</th>
                              <th>Password</th>
                              <th>User Type</th>
                              <th>Action</th>
                           </tr>
                        </thead>

                        <tbody>
                           @foreach($users as $index => $user)
                           <tr>
                              <td>{{ $users->firstItem() + $index }}</td>
                              <td>{{ $user->name }}</td>
                              <td>{{ $user->mobile }}</td>
                              <td>{{ $user->email }}</td>
                              <td>{{ $user->address }}</td>
                              <td>{{ $user->show_password }}</td>
                              <td>{{ $user->user_type }}</td>

                              <td>
                                 <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                       class="btn cur-p btn-danger"
                                       onclick="return confirm('Are you sure you want to delete this user?')">
                                       Delete
                                    </button>
                                 </form>
                              </td>

                           </tr>
                           @endforeach
                        </tbody>
                     </table>

                     {{-- PAGINATION --}}
                     <div class="d-flex justify-content-between">
                        <div>
                           Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
                        </div>
                        <div>
                           {{ $users->links() }}
                        </div>
                     </div>

                  </div>
               </div>

            </div>
         </div>

      </div>

   </div>
</div>

@endsection