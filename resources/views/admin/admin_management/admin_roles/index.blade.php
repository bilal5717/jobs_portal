@extends('admin.common.index')



@section('content')
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Admin Roles
                    
                    <div class="dropdown dropdown-inline pull-right" title="" data-placement="top" data-original-title="Quick actions">
	                    @if(is_allowed('create_role'))
	                    <a href="{{route('admin.create_role')}}" style="width: 12rem;" class="btn btn-icon btn btn-label btn-label-brand btn-bold" data-offset="0px,0px">
	                        <i class="flaticon2-add-1"></i> &nbsp; Create new role
	                    </a>
						@endif
						
						<!--<a href="javascript:;" class="btn btn-icon btn btn-label btn-label-brand btn-bold" id="toogleSearchForm" data-offset="0px,0px" aria-haspopup="true" aria-expanded="false">
	                        <i class="flaticon2-magnifier-tool"></i>
	                    </a>-->
						<a href="{{route('admin.admin_roles')}}" class="btn btn-icon btn btn-label btn-label-brand btn-bold" id="refreshButton" data-offset="0px,0px" aria-haspopup="true" aria-expanded="false">
	                        <i class="flaticon-refresh"></i>
	                    </a>
	                </div>
                </div>
			
                
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Role Name</th>
                        <th scope="col">Description</th>
                        <th scope="col" align="right" width="30%" style="text-align: center;">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($admin_roles as $role)
                        <tr>
                            <td>{{$role->id}}</td>
                            <td>{{$role->name}}</td>
                            <td>{{$role->description}}</td>
                            <td class="d-flex" align="right" style="text-align: right;">
                                <!--<a href="{{url('app-admin/user/'.$role->id .'/edit')}}" class="mx-2 btn btn-sm btn-primary"  data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                <form onsubmit="return confirm('Are you sure to delete this user?');"  action="{{url('app-admin/user/'.$role->id)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm btn-danger"  data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>
                                </form>-->
                                <div class="btn-group" style="width:100%;">
									@if(is_allowed('role_delete'))
									<form action="{{route('admin.role_delete', $role->id)}}" id="delete_form_{{$role->id}}" method="POST">
									    @method('DELETE')
									    @csrf
									</form>
									<a href="javascript:;" type="button" class="btn btn-outline-secondary"  onclick="deleteUser({{$role->id}})"> Delete </a>
									@endif
									
									@if(is_allowed('edit_role'))
									<a href="{{route('admin.edit_role', $role->id)}}" type="button" class="btn btn-outline-secondary"> Edit </a>
									@endif
									
									@if(!is_allowed('edit_role') && !is_allowed('role_delete'))
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
                  {{ $admin_roles->links() }}
                  

            </div>
        </div>
  
@endsection
@section('script')
<script>
	/*user delete Script*/
	function deleteUser(id){
		if(confirm('Are you sure to delete this role.')){
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
