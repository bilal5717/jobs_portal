@extends('admin.common.index')



@section('content')

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Project Management
                </div>
                <div class="card-body">
                	@if(is_allowed('add_project'))
                    <a href="{{url('app-admin/project/create')}}" class="btn btn-primary btn-sm my-2">Create new Project</a>  
                	@endif
                
                <table class="table table-bordered  mx-auto">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Project Name</th>
                        <th scope="col">Details</th>
                        <th scope="col">Company</th>
                        <th scope="col" width="29%">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($projects as $project)
                        <tr>
                            <td>{{$project->id}}</td>
                            <td>{{$project->name}}</td>
                            <td>{{$project->description}}</td>
                            <td>{{@getCompanyData($project->company_id, "company_name")}}</td>
                            <td class="d-flex">
                                <div class="btn-group">
								    @if(is_allowed('edit_project'))
								    <a href="{{url('app-admin/project/'.$project->id .'/edit')}}" type="button" class="btn btn-outline-secondary"> Edit </a>
	                                @endif
	                                @if(is_allowed('delete_project'))
	                                <a  onclick="jQuery('#project_{{$project->id}}').submit()" href="javascript:;" type="submit" class="btn btn-outline-secondary" data-toggle="tooltip" title="Delete"> Delete</a>
								    <form id="project_{{$project->id}}" onsubmit="return confirm('Are you sure to delete this project?');" action="{{url('app-admin/project/' . $project->id)}}" method="post">
	                                    @csrf
	                                    @method('delete')
	                                </form>
	                                @endif
	                                
	                                @if(isset($last_timetable->id) && is_allowed('timetables'))
	                                <a href="{{route('admin.open_timetable', $last_timetable->id)}}?project_id={{$project->id}}" type="button" class="btn btn-outline-secondary"> <i class="fa fa-calendar"></i> Schedule </a>
									@endif
									
									@if(!is_allowed('delete_project') && !is_allowed('timetables') && !is_allowed('edit_project'))
	                                No Permission
									@endif
								</div>
                            </td>
                        </tr>
                    @empty
                        <td class="text-center" colspan="6">No Project Found</td> 
                    @endforelse

                    </tbody>
                  </table>
                  {{ $projects->links() }}
            </div>
        </div>
        </div>
@endsection
