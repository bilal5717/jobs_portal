@extends('admin.common.index')



@section('content')
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Admin Management
                    <div class="dropdown dropdown-inline pull-right" title="" data-placement="top" data-original-title="Quick actions">
	                    @if(is_allowed('create_admin'))
	                    <a href="{{route('admin.create_admin')}}" style="width: 12rem;" class="btn btn-icon btn btn-label btn-label-brand btn-bold" data-offset="0px,0px">
	                        <i class="flaticon2-add-1"></i> &nbsp; Create new user
	                    </a>
						@endif
						<a href="javascript:;" class="btn btn-icon btn btn-label btn-label-brand btn-bold" id="toogleSearchForm" data-offset="0px,0px" aria-haspopup="true" aria-expanded="false">
	                        <i class="flaticon2-magnifier-tool"></i>
	                    </a>
						<a href="{{route('admin.admin_users')}}" class="btn btn-icon btn btn-label btn-label-brand btn-bold" id="refreshButton" data-offset="0px,0px" aria-haspopup="true" aria-expanded="false">
	                        <i class="flaticon-refresh"></i>
	                    </a>
	                </div>
                </div>
			
                
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Active</th>
                        <th scope="col" align="right" width="30%" style="text-align: center;">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($admin_users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{(isset($user->adminRole->name))? $user->adminRole->name : 'N/A'}}</td>
                            <td><span class="badge">{{($user->status == 1) ? "Yes":"No"}}</span></td>
                            <td class="d-flex" align="right" style="text-align: right;">
                                <!--<a href="{{url('app-admin/user/'.$user->id .'/edit')}}" class="mx-2 btn btn-sm btn-primary"  data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                <form onsubmit="return confirm('Are you sure to delete this user?');"  action="{{url('app-admin/user/'.$user->id)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm btn-danger"  data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>
                                </form>-->
                                <div class="btn-group" style="width:100%;">
									@if(is_allowed('admin_delete'))
									<form action="{{route('admin.admin_delete', $user->id)}}" id="delete_form_{{$user->id}}" method="POST">
									    @method('DELETE')
									    @csrf
									</form>
									<a href="javascript:;" type="button" class="btn btn-outline-secondary"  onclick="deleteUser({{$user->id}})"> Delete </a>
									@endif
									
									@if(is_allowed('edit_admin'))
									<a href="{{route('admin.edit_admin', $user->id)}}" type="button" class="btn btn-outline-secondary"> Edit </a>
									@endif
									
									@if(!is_allowed('admin_delete') && !is_allowed('edit_admin'))
									No permissions
									@endif
								</div>
                            </td>
                        </tr>
                    @empty
                        <p class="text-center">No admin users</p>
                    @endforelse

                    </tbody>
                  </table>
                  {{ $admin_users->links() }}
                  

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
