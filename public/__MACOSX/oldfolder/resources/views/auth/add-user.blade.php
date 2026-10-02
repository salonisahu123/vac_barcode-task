@extends('layouts.master')

@section('title','Add User')

@section('content')

<div class="midde_cont">
    <div class="container-fluid">

        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title">
                    <h2>Add User</h2>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="white_shd full margin_bottom_30">

                    <div class="full graph_head">
                        <div class="heading1 margin_0">
                            <h2>New User</h2>
                        </div>
                    </div>

                    <div class="table_section padding_infor_info">
                        <div class="table-responsive-sm">

                            <form action="{{ route('users.store') }}" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label for="name">Name Of User</label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="mobile">Mobile No</label>
                                    <input type="text" class="form-control" name="mobile" id="mobile" value="{{ old('mobile') }}">
                                    @error('mobile')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}">
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="address">Permanent Address</label>
                                    <input type="text" class="form-control" name="address" id="address" value="{{ old('address') }}">
                                    @error('address')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="user_type">User Type</label>
                                    <select name="user_type" id="user_type" class="form-control">
                                        <option value="">-- Select User Type --</option>
                                        <option value="user">User</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                    @error('user_type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                           <div class="form-group">
                                <label for="role_id">Select Role</label>

                                <select name="role_id" id="role_id" class="form-control">
                                    <option value="">-- Select Role --</option>

                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('role_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" id="password">
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                                    @error('password_confirmation')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="field margin_0">
                                    <button class="main_bt" type="submit">Add User</button>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

@endsection