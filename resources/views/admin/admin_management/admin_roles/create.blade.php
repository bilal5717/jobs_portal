@extends('admin.common.index')



@section('content')
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Create Admin User
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
                    <form id="form" method="post" action="{{route('admin.add_new_role')}}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name"  placeholder="Enter name" required data-parsley-maxlength="10" data-parsley-minlength="4" data-parsley-trigger="change">
                          </div>
                        <div class="form-group">
                          <label for="email">Description</label>
                          <textarea type="email" class="form-control" name="description" id="description"  placeholder="Enter role description" required></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary float-right">Submit</button>
                    </form>
                </div>
                
            </div>
        </div>
   
@endsection
