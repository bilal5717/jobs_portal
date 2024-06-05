@extends('admin.common.index')



@section('content')
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Admin Management
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="post" action="{{route('admin.update_admin',$user->id)}}" id="form">
                        @csrf
                        @METHOD("POST")
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name"  value="{{$user->name}}" required data-parsley-maxlength="10" data-parsley-minlength="4" data-parsley-trigger="change">
                          </div>
                        <div class="form-group">
                          <label for="email">Email address</label>
                          <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" value="{{$user->email}}" required>
                        </div>
                        <div class="form-group">
                            <label for="companyName">Admin Role</label>
                            <select class="form-control" name="admin_role_id">
                                <option value="">Select Role</option>
                            @foreach($adminRoles as $role)
                                <option value="{{$role->id}}" {{($role->id == $user->admin_role_id ? 'selected':'')}}>{{$role->name}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="companyName">Active Status</label>
                            <select class="form-control" name="status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                          <label for="password">Password</label>
                          <input type="password" class="form-control" name="password" id="password" placeholder="Password" data-parsley-maxlength="16" data-parsley-minlength="8" data-parsley-trigger="change">
                        </div>
                        
                        <button type="submit" class="btn btn-primary float-right">Update</button>
                    </form>
                </div>
                
            </div>
        </div>
 
@endsection
