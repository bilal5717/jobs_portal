@extends('admin.common.index')



@section('content')
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    User Management
                </div>
                <div class="card-body">
                    <a href="{{url('app-admin/user/create')}}" class="btn btn-primary btn-sm">Create new user</a>  
                </div>
                
                <table class="table table-bordered  mx-auto">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td class="d-flex">
                                {{-- <a href="{{url('app-admin/user/'.$user->id .'/folder')}}" class="btn btn-sm btn-primary">Folders</a> --}}
                                <a href="{{url('app-admin/user/'.$user->id .'/edit')}}" class="mx-2 btn btn-sm btn-primary"  data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                <form onsubmit="return confirm('Are you sure to delete this user?');"  action="{{url('app-admin/user/'.$user->id)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm btn-danger"  data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <p class="text-center">No users</p>
                    @endforelse

                    </tbody>
                  </table>
                  {{ $users->links() }}
            </div>
        </div>
  
@endsection
