@extends('admin.common.index')



@section('content')
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    User Management
                    
                    <div class="dropdown dropdown-inline pull-right" title="" data-placement="top" data-original-title="Quick actions">
	                    @if(is_allowed('create_user'))
	                    <a href="{{url('app-admin/user/create')}}" style="width: 12rem;" class="btn btn-icon btn btn-label btn-label-brand btn-bold" data-offset="0px,0px">
	                        <i class="flaticon2-add-1"></i> &nbsp; Create new user
	                    </a>
						@endif
						
						<a href="javascript:;" class="btn btn-icon btn btn-label btn-label-brand btn-bold" id="toogleSearchForm" data-offset="0px,0px" aria-haspopup="true" aria-expanded="false">
	                        <i class="flaticon2-magnifier-tool"></i>
	                    </a>
						<a href="{{route('admin.user.index')}}" class="btn btn-icon btn btn-label btn-label-brand btn-bold" id="refreshButton" data-offset="0px,0px" aria-haspopup="true" aria-expanded="false">
	                        <i class="flaticon-refresh"></i>
	                    </a>
	                </div>
                </div>
                
                 <div id="filterForm" style="display: {{($searched)?'block':'none'}};">
					<form class="form" id="filterForm" action="{{route('admin.user_post')}}" method="post">
						@csrf
						<div class="card-body">
							<div class="form-group row">
								<div class="col-lg-6">
									<label>User Name:</label>
									<input type="text" name="name" class="form-control" value="{{Request::get('name')}}" placeholder="Search by name"/>
									<!--<span class="form-text text-muted">Please enter folder name</span>-->
								</div>
								<div class="col-lg-6">
									<label>User Email:</label>
									<input type="text" name="email" class="form-control" value="{{Request::get('email')}}" placeholder="Search by name"/>
									<!--<span class="form-text text-muted">Please enter folder name</span>-->
								</div>
								<div class="col-lg-6">
									<label>User Status:</label>
		                            <select class="form-control" name="user_status"  id="companyBox">
		                                <option value="">All</option>
		                                <option value="new" {{ (Request::get('user_status') == 'new' ? "selected":"")}}>New</option>
		                                <option value="pending" {{ (Request::get('user_status') == 'pending' ? "selected":"")}}>Pending</option>
		                                <option value="approved" {{ (Request::get('user_status') == 'approved' ? "selected":"")}}>Approved</option>
		                                <option value="rejected" {{ (Request::get('user_status') == 'rejected' ? "selected":"")}}>Rejected</option>
		                            </select>
									<!--<span class="form-text text-muted">Please select company to sort</span>-->
		                        </div>
		                        <br>
		                	</div>
							<div class="row">
								<div class="col-lg-6">
									<button type="submit" class="btn btn-primary mr-2">Filter</button>
									<a type="reset" href="{{url('app-admin/user')}}" class="btn btn-secondary">Cancel</a>
									<!--onclick="$('#filterForm').toggle();"-->
								</div>
							</div>
						</div>
					</form>						
					<hr />
				</div>
				
                
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Status</th>
                        <th scope="col" align="right" width="30%" style="text-align: center;">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($users as $user)
                      	@php
							if($user->user_status == 'pending'){
							$badgeClass = "badge-info";
							}elseif($user->user_status == 'rejected'){
							$badgeClass = "badge-danger";
							}elseif($user->user_status == 'approved'){
							$badgeClass = "badge-success";
							}else{
							$badgeClass = "badge-warning";
							}
							$thumbnail = getProfileImage($user->id);
						@endphp
                        <tr>
                            <td>{{$user->id}}</td>
                            <td><a href="{{$thumbnail}}" target="_blank"><img src="{{$thumbnail}}" width="30" /></a></td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td><span class="badge {{$badgeClass}}">{{$user->user_status}}</span></td>
                            <td class="d-flex" align="right" style="text-align: right;">
                                <!--<a href="{{url('app-admin/user/'.$user->id .'/edit')}}" class="mx-2 btn btn-sm btn-primary"  data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                <form onsubmit="return confirm('Are you sure to delete this user?');"  action="{{url('app-admin/user/'.$user->id)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm btn-danger"  data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>
                                </form>-->
                                <div class="btn-group" style="width:100%;">
									
									@if(is_allowed('delete_user'))
									<form action="{{route('admin.user.destroy', $user->id)}}" id="delete_form_{{$user->id}}" method="POST">
									    @method('DELETE')
									    @csrf
									</form>
									<a href="javascript:;" type="button" class="btn btn-outline-secondary"  onclick="deleteUser({{$user->id}})"> Delete </a>
									@endif
									
									@if(is_allowed('view_user'))
									<a href="{{route('admin.user.show', $user->id)}}" type="button" class="btn btn-outline-secondary"> View </a>
									@endif
									
									@if(isset($last_timetable->id) && is_allowed('timetables'))
									<a href="{{route('admin.open_timetable', $last_timetable->id)}}?user_id={{$user->id}}" type="button" class="btn btn-outline-secondary"> <i class="fa fa-calendar"></i> Schedule </a>
									@endif
									
									@if(is_allowed('approve_user') || is_allowed('reject_user'))
									<button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" onclick="jQuery('#dropDownUsers_{{$user->id}}').toggle()" id="dropdownMenuReference" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
										<span class="sr-only">Toggle Dropdown</span>
									</button>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuReference" id="dropDownUsers_{{$user->id}}">
										@if(is_allowed('approve_user'))
										<a class="dropdown-item" onclick="changeUserAction({{$user->id}}, 'approved')" href="javascript:;">Approve</a>
										@endif
										@if(is_allowed('reject_user'))
										<a class="dropdown-item" onclick="changeUserAction({{$user->id}}, 'rejected')" href="javascript:;">Reject</a>
										@endif
										<form id="user-status-form-{{$user->id}}"  action="{{route('admin.change_user_status')}}" method="post">
											@csrf
											<input type="hidden" name="user_id" value="{{$user->id}}" />
											<input type="hidden" name="user_status" id="user-status-{{$user->id}}" value="" required="" />
										</form>
									</div>
									@endif
									
									@if(!is_allowed('view_user') 
								    && !is_allowed('delete_user') 
								    && !is_allowed('timetables') 
								    && !is_allowed('approve_user') 
								    && !is_allowed('reject_user'))
	                                No Permission
									@endif
								</div>
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
@section('script')
<script>
	/*user status Script*/
	function changeUserAction(id, action){
		if(confirm('This user will be '+action+'?')){
			$('#user-status-'+id).val(action);
			$('#user-status-form-'+id).submit();
		}
	}
	/*user delete Script*/
	function deleteUser(id){
		if(confirm('Are you sure to delete this user.')){
			$('#delete_form_'+id).submit();
		}
	}
	window.onload = function(){
      $(document).ready(function(){
        $('#toogleSearchForm').click(function(){
        	$('#filterForm').toggle();
        });
      })
  	}
</script>
@endsection
@section('script')
