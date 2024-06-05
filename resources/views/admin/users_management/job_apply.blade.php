@extends('admin.common.index')



@section('content')
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    New Job Applies
                </div>
                
                <table class="table table-bordered  mx-auto">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Job Type</th>
                        <th scope="col">License Name</th>
                        <th scope="col">License Number</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            @php
                            	$jobType = "";
                            	if($user->userJobDetail->job_type == 'cleaning'){
									$jobType = "Cleaning";
								}else if($user->userJobDetail->job_type == 'traffic_controller'){
									$jobType = "Traffic Controller";
								}else{
									$jobType = "Security";
								}
                            @endphp
                            <td>{{$jobType}}</td>
                            <td>{{$user->userJobDetail->license_name}}</td>
                            <td>{{$user->userJobDetail->license_number}}</td>
                            <td class="d-flex">
                            	<a href="{{route('admin.user.show', $user->id)}}" type="button" class="btn btn-sm btn-info"> View Details </a>&nbsp;
                                @if(is_allowed('approve_user'))
                                <form onsubmit="return confirm('Are you sure to accept this employee?');"  action="{{url('app-admin/user/jobaction')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{$user->id}}">
                                    <input type="hidden" name="job_action" value="accept">
                                    <button type="submit" class="btn btn-sm btn-success"  data-toggle="tooltip" title="Delete"><i class="fa fa-check-circle"></i> Accept</button>
                                </form> 
                                @endif
                                &nbsp;
                                @if(is_allowed('reject_user'))
                                <form onsubmit="return confirm('Are you sure to reject this employee?');"  action="{{url('app-admin/user/jobaction')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{$user->id}}"
                                    <input type="hidden" name="job_action" value="reject">
                                    <button type="submit" class="btn btn-sm btn-danger"  data-toggle="tooltip" title="Delete"><i class="fa fa-times-circle"></i> Reject</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <p class="text-center">No users requests</p>
                    @endforelse

                    </tbody>
                  </table>
                  {{ $users->links() }}
            </div>
        </div>
  
@endsection
