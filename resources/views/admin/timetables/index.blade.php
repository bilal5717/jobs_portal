@extends('admin.common.index')



@section('content')
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Timetable Management
                </div>
                <div class="card-body">
                	@if(is_allowed('create_timetable'))
                    <a href="{{url('app-admin/timetable/create')}}" class="btn btn-primary btn-sm">Create Timetable</a>  
                	@endif
                </div>
                
                <table class="table  mx-auto"><!--table-bordered-->
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Timetable Title</th>
                        <th scope="col">Dates</th>
                        <th scope="col">Status</th>
                        <th scope="col" width="10%">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($timetables as $timetable)
                      	@php
					    	if($timetable->status == 'active'){
								$badgeClass = "badge badge-success";
							}else{
								$badgeClass = "badge badge-warning";
							}
					    @endphp
                        <tr>
                            <td>{{$timetable->id}}</td>
                            <td>{{$timetable->title}}</td>
                            <td>{{$timetable->start_date}} - {{$timetable->end_date}}</td>
                            <td><span class="{{$badgeClass}}">{{$timetable->status}}</span></td>
                            <td class="d-flex">
                                <div class="btn-group">
								    @if(is_allowed('open_timetable'))
								    <a href="{{route('admin.open_timetable', $timetable->id)}}" type="button" class="btn btn-outline-secondary"> Open </a>
								    @endif
								    
								    @if(is_allowed('delete_timetable'))
								    <a href="javascript:;"  onclick="jQuery('#timetable-delete-form-{{$timetable->id}}').submit()" type="button" class="btn btn-outline-secondary"> Delete </a>
								    <form id="timetable-delete-form-{{$timetable->id}}"  action="{{route('admin.timetable.destroy', $timetable->id)}}" method="post">
	                                    @method('DELETE')
	                                    @csrf
	                                </form>
	                                @endif
	                                
	                                @if(is_allowed('activate_timetable') || is_allowed('deactivate_timetable'))
								    <button type="button" class="btn btn-outline-secondary dropdown-toggle" onclick="jQuery('#dropDownTimetable_{{$timetable->id}}').toggle()" id="dropdownMenuReference1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								        <span class="sr-only">Toggle Dropdown</span>
								    </button>
								    <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1" id="dropDownTimetable_{{$timetable->id}}">
										@if(is_allowed('activate_timetable'))
										<a class="dropdown-item" onclick="changeTimetableAction({{$timetable->id}}, 'active')" href="javascript:;">Activate</a>
										@endif
										@if(is_allowed('deactivate_timetable'))
										<a class="dropdown-item" onclick="changeTimetableAction({{$timetable->id}}, 'inactive')" href="javascript:;">Deactivate</a>
										@endif
										<form id="timetable-status-form-{{$timetable->id}}"  action="{{route('admin.timetable_status_change')}}" method="post">
		                                    @csrf
		                                    <input type="hidden" name="timetable_id" value="{{$timetable->id}}" />
		                                    <input type="hidden" name="status" id="timetable-status-{{$timetable->id}}" value="" required="" />
		                                </form>
								    </div>
								    @endif
								    @if(!is_allowed('open_timetable') 
								    && !is_allowed('delete_timetable') 
								    && !is_allowed('activate_timetable') 
								    && !is_allowed('deactivate_timetable'))
	                                No Permission
									@endif
								</div>
                            </td>
                        </tr>
                    @empty
                        <p class="text-center">No Timetable</p>
                    @endforelse

                    </tbody>
                  </table>
                  {{ $timetables->links() }}
            </div>
        </div>
  
@endsection
@section('script')
<script>
	/*Timetable Script*/
	function changeTimetableAction(id, action){
		if(confirm('Are you sure to '+action+' this timetable?')){
			console.log(id, action);
			$('#timetable-status-'+id).val(action);
			$('#timetable-status-form-'+id).submit();
		}
	}
</script>
@endsection