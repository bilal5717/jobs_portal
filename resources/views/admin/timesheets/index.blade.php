@extends('admin.common.index')



@section('content')
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Timesheet Management
                </div>
                <!--<div class="card-body">
                    <a href="{{url('app-admin/user/create')}}" class="btn btn-primary btn-sm">Create new user</a>  
                </div>-->
                
                <table class="table  mx-auto"><!--table-bordered-->
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Image</th>
                        <th scope="col">Employee Name</th>
                        <th scope="col">Timesheet Title</th>
                        <th scope="col">Dates</th>
                        <th scope="col">Status</th>
                        <th scope="col" width="10%">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($timesheets as $timesheet)
                      	@php
					    	if($timesheet->status == 'pending'){
								$badgeClass = "badge badge-info";
							}elseif($timesheet->status == 'denied'){
								$badgeClass = "badge badge-danger";
							}elseif($timesheet->status == 'approved'){
								$badgeClass = "badge badge-success";
							}else{
								$badgeClass = "badge badge-warning";
							}
							$thumbnail = getProfileImage($timesheet->user_id);
					    @endphp
                        <tr>
                            <td>{{$timesheet->id}}</td>
                            <td><a href="{{$thumbnail}}" target="_blank"><img src="{{$thumbnail}}" width="30" height="30" /></a></td>
                            @if(isset($timesheet->user->name))
                            	<td><a href="{{route('admin.user.show', $timesheet->user_id)}}">{{$timesheet->user->name}}</a></td>
                            @else
                            	<td><a href="javascript:;">(#Deleted)</a></td>
                            @endif
                            <td>{{$timesheet->title}}</td>
                            <td>{{$timesheet->start_date}} - {{$timesheet->end_date}}</td>
                            <td><span class="{{$badgeClass}}">{{$timesheet->status}}</span></td>
                            <td class="d-flex">
                                <div class="btn-group">
                                	@if(is_allowed('open_timesheet'))
								    <a href="{{route('admin.open_timesheet')}}/{{$timesheet->id}}" type="button" class="btn btn-outline-secondary"> Open </a>
								    @endif
								    
								    @if(is_allowed('deny_timesheet') || is_allowed('approve_timesheet') || is_allowed('pay_timesheet'))
								    <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" onclick="jQuery('#dropdownMenuReference-{{$timesheet->id}}').toggle();" title="Approve/Deny">
								        <span class="sr-only">Toggle Dropdown</span>
								    </button>
								    <div class="dropdown-menu" id="dropdownMenuReference-{{$timesheet->id}}">
								    	@if(is_allowed('approve_timesheet'))
										<a class="dropdown-item" onclick="changeTimesheetAction({{$timesheet->id}}, 'approved')" href="javascript:;">Approve</a>
										@endif
										@if(is_allowed('deny_timesheet'))
										<a class="dropdown-item" onclick="changeTimesheetAction({{$timesheet->id}}, 'denied')" href="javascript:;">Deny</a>
										@endif
										@if(is_allowed('pay_timesheet'))
										<a class="dropdown-item" onclick="changeTimesheetAction({{$timesheet->id}}, 'paid')" href="javascript:;">Mark As Paid</a>
										@endif
										<form id="timesheet-status-form-{{$timesheet->id}}"  action="{{route('admin.timesheet_status_change')}}" method="post">
		                                    @csrf
		                                    <input type="hidden" name="timesheet_id" value="{{$timesheet->id}}" />
		                                    <input type="hidden" name="status" id="timesheet-status-{{$timesheet->id}}" value="" required="" />
		                                </form>
								    </div>
								    @endif
								    
								    @if(is_allowed('delete_timesheet'))
								    <a href="javascript:;"  onclick="jQuery('#timesheet-delete-form-{{$timesheet->id}}').submit()" type="button" class="btn btn-outline-secondary"> Delete </a>
								    <form id="timesheet-delete-form-{{$timesheet->id}}" onsubmit="return confirm('Are you sure to delete this timesheet?');"  action="{{route('admin.timesheet.destroy', $timesheet->id)}}" method="post">
	                                    @method('DELETE')
	                                    @csrf
	                                </form>
	                                @endif
								</div>
                            </td>
                        </tr>
                    @empty
                        <p class="text-center">No users</p>
                    @endforelse

                    </tbody>
                  </table>
                  {{ $timesheets->links() }}
            </div>
        </div>
  
@endsection
@section('script')
<script>
	/*Timesheet Script*/
	function changeTimesheetAction(id, action){
		if(confirm('Are you sure to '+action+' this timesheet?')){
			console.log(id, action);
			$('#timesheet-status-'+id).val(action);
			$('#timesheet-status-form-'+id).submit();
		}
	}
</script>
@endsection