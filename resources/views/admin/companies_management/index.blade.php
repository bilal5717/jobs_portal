@extends('admin.common.index')



@section('content')

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Company Management
                </div>
                <div class="card-body">
                	@if(is_allowed('create_company'))
                    <a href="{{url('app-admin/company/create')}}" class="btn btn-primary btn-sm my-2">Create new Company</a>  
                	@endif
                
                <table class="table table-bordered  mx-auto">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Company Name</th>
                        <th scope="col">Details</th>
                        @if(is_allowed('project'))
                        <th scope="col" style="text-align: center;">Projects</th>
                        @endif
                        <th scope="col" width="25%">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($companies as $company)
                        <tr>
                            <td>{{$company->id}}</td>
                            <td>{{$company->company_name}}</td>
                            <td>{{$company->description}}</td>
                            @if(is_allowed('project'))
                            <td align="center"><a href="{{route('admin.project.index')}}?company_id={{$company->id}}"><i class="fa fa-th-list"></i></a></td>
                            @endif
                            <td class="d-flex">
                                <div class="btn-group">
                                	@if(is_allowed('edit_company'))
								    <a href="{{url('app-admin/company/'.$company->id .'/edit')}}" type="button" class="btn btn-outline-secondary"> Edit </a>
								    @endif
								    @if(is_allowed('delete_company'))
								    <form  onsubmit="return confirm('Are you sure to delete this company?');" action="{{url('app-admin/company/'.$company->id)}}" method="post">
	                                    @csrf
	                                    @method('delete')
	                                    <a href="javascript:;" type="submit" class="btn btn-outline-secondary" data-toggle="tooltip" title="Delete"> Delete</a>
	                                </form>
	                                @endif
	                                @if(isset($last_timetable->id) && is_allowed('timetables'))
	                                <a href="{{route('admin.open_timetable', $last_timetable->id)}}?company_id={{$company->id}}" type="button" class="btn btn-outline-secondary"> Schedule </a>
									@endif
									
									@if(!is_allowed('delete_company') && !is_allowed('timetables') && !is_allowed('edit_company'))
	                                No Permission
									@endif
								</div>
                            </td>
                        </tr>
                    @empty
                        <td class="text-center" colspan="3">No Company Found</td>
                    @endforelse

                    </tbody>
                  </table>
                  {{ $companies->links() }}
            </div>
        </div>
        </div>
@endsection
