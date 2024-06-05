@extends('admin.common.index')



@section('content')
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    User Management
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
                    <form method="post" action="{{url('app-admin/user/'.$user->id)}}" id="form">
                        @csrf
                        @METHOD("PUT")
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name"  value="{{$user->name}}" required data-parsley-maxlength="10" data-parsley-minlength="4" data-parsley-trigger="change">
                          </div>
                        <div class="form-group">
                          <label for="email">Email address</label>
                          <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" value="{{$user->email}}" required>
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
