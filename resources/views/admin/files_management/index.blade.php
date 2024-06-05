@extends('admin.common.index')



@section('content')
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Folder Management
                </div>
                <div class="card-body">
                	<nav aria-label="breadcrumb">
	                    <ul class="breadcrumb">
				          @if($bredcrumbPath)
	                    	<li class="breadcrumb-item"><a class="kt-link" href="{{url('app-admin/folder')}}">All Folder</a></li>
				            @foreach($bredcrumbPath as $bread)
					            @if($loop->last)
					            	<i  class="breadcrumb-item active"></i> <li>{{$bread['name']}}</li>
					            @else
					            	<li class="breadcrumb-item"><a class="kt-link" href="{{url('app-admin/subfolder/'.$bread['id'].'/view')}}">{{$bread['name']}}</a></li>
					            @endif
				          	@endforeach
				        @else
				            <li class="breadcrumb-item"><a class="kt-link" href="javascript:;">All Folder</a></li>
				        @endif
				        </ul>
			        </nav>
                
                    <a href="{{url('app-admin/folder/'.$folder_id.'/file/upload')}}" class="mx-auto btn btn-primary btn-sm pull-right ml-5">Upload File</a> &nbsp;
                    <a href="{{url('app-admin/subfolder/'.$folder_id.'/view')}}" class="mx-auto btn btn-primary btn-sm pull-right" style="margin-right: 10px !important;">back</a> 
                    <!--<a href="#" class="mx-auto btn btn-primary btn-sm" data-toggle="modal" data-target="#assignFile">Assign File to Employee</a>-->  
                </div>
                
                <table class="table table-bordered  mx-auto">
                    <thead>
                      <tr>
                        <!--<th scope="col">#</th>-->
                        <th scope="col">Name</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($files as $file)
                        <tr>
                            <!--<td>{{$loop->iteration}}</td>-->
                            @if(!empty($file->orignal_name))
                            	<td>{{$file->orignal_name}}</td>
							@else
								<td>{{$file->file}}</td>
							
							@endif
                            <td class="d-flex">
                                <a href="{{url('app-admin/folder/'.$folder_id.'/file/'.$file->id .'/edit')}}" class="btn btn-sm btn-primary mx-2"  data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                <a onclick="return confirm('Are you sure to delete this file?');" href="{{url('app-admin/folder/'.$folder_id.'/file/'.$file->id .'/delete')}}" class="btn btn-sm btn-danger"  data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a> 
                             
                            </td>
                        </tr>
                    @empty
                        <td class="text-center" colspan="3">No File Found</td>
                    @endforelse

                    </tbody>
                  </table>
            </div>
        </div>


{{-- Assign Files to Employee  --}}

<div class="modal fade" id="assignFile" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Assign Files To Employee</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form  action="{{route('admin.file.assign')}}" method="post" id="form">
                @csrf
                <div class="form-group">
                  <label for="Companies">Companies:</label>
                  <select name="company_id" id="Companies" class="form-control" required>
                    <option value="">Select Company</option>
                      @foreach($companies as $company)
                        <option value="{{$company->id}}">{{$company->company_name}}</option>
                      @endforeach
                  </select>    
                </div>
                <div class="form-group" id="employee-group" >
                  <label for="employees">Employees:</label>
                  <select class="employee" id="employee" name="employees[]" multiple="multiple"></select>   
                </div>
                <div class="form-group">
                  <label for="folders">Files</label>
                  <select name="file_id" id="folders" class="form-control" required>
                    <option value="">Choose File</option>
                    @foreach($files as $file)
                      <option value="{{$file->id}}">{{$file->file}}</option>
                    @endforeach
                </select> 
                </div>
                
                <input type="submit" class="btn btn-primary float-right" value="Assign">
            </form>
        </div>
        {{-- <div class="modal-footer">--}}
            
            {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
          {{-- <button type="button" class="btn btn-primary">Understood</button> --}}
        {{-- </div>  --}}
      </div>
    </div>
</div>    
@endsection
@section('script')
<script>
  window.onload = function(){
      
      $(document).ready(function(){
        var multipleSelect =  $('#employee').select2({
          placeholder: "-- Select --"

        });
        
        var commpany_id = '';
        $("#Companies").change(function(){
          commpany_id = $(this).val();

          var option = '';
          if(commpany_id != 0){
             $.ajax({
              url:'{{ url('/app-admin/fetch/employees/')}}'+'/'+commpany_id,
              success:function(res){
                
                $.each(res.employees,function(key,val){
                    option += `<option value="${val.id}">${val.name}</option>`;
                })
                $("#employee option").remove();
                $("#employee").append(option);
              }
               })   
          }
         
        });
          
      })
  }
  
  
</script>
@endsection
