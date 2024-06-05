@extends('admin.common.index')



@section('content')
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Folder Management
                </div>
                <div class="card-body">
                    
                    @if($parent)
                    <a href="{{url('app-admin/subfolder/'.$parentID.'/create')}}" class="btn btn-primary btn-sm mx-2">Create Sub Folder</a>
                    @else 
                    <a href="{{url('app-admin/folder/create')}}" class="btn btn-primary btn-sm mx-2">Create new Folder</a>
                    <!--<a href="{{url('app-admin/folder/root/file')}}" class="btn btn-sm btn-primary mx-2">Root Files</a>-->
                    @endif
                    <!--<a href="#" class="btn btn-primary btn-sm"  data-toggle="modal" data-target="#assignFolder">Assign Folder to Employee</a>-->  
                </div>
                
                <table class="table table-bordered  mx-auto">
                    <thead>
                      <tr>
                        <!--<th scope="col">#</th>-->
                        <th scope="col">Name</th>
                        
                        @if(!$parentID)
                        	<th scope="col">Company</th>
                        @endif
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($folders as $folder)
                        <tr>
                            <!--<td>{{$loop->iteration}}</td>-->
                            <td><a href="{{url('app-admin/subfolder/'.$folder->id.'/view')}}"><i class="fa fa-folder"></i> {{$folder->name}}</a></td>
                            @if(!$parentID)
	                            @if(isset($folder->companies[0]))
	                            	<td>{{$folder->companies[0]->company_name}}</td>
	                            @else
	                            	<td> n/a </td>
		                      	@endif
		                    @endif
                            <td class="d-flex justify-content-center">
                                <a href="{{url('app-admin/subfolder/'.$folder->id.'/view')}}" class="btn btn-sm btn-primary mx-2"  data-toggle="tooltip" title="View sub folders"><i class="fa fa-folder"></i></a>
                                <a href="{{url('app-admin/folder/'.$folder->id.'/file')}}" class="btn btn-sm btn-primary mx-2"  data-toggle="tooltip" title="View/upload files here"><i class="fa fa-file"></i></a>
                                <a href="{{url('app-admin/folder/'.$folder->id .'/edit')}}" class="btn btn-sm btn-primary mx-2"  data-toggle="tooltip" title="Edit this folder"><i class="fa fa-edit"></i></a>
                                <form  onsubmit="return confirm('Are you sure to delete this folder?');" action="{{url('app-admin/folder/'.$folder->id)}}" method="post" class="mx-2">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm btn-danger"  data-toggle="tooltip" title="Delete this folder and all its content."><i class="fa fa-trash"></i></a>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <td class="text-center" colspan="3">No Folder Found</td>
                    @endforelse

                    </tbody>
                  </table>
            </div>
        </div>
    
{{-- Assign Folder to Employee  --}}

<div class="modal fade" id="assignFolder" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Assign Folder To Employee</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form  action="{{route('admin.folder.assign')}}" method="post" id="form">
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
                  <label for="folders">Folders</label>
                  <select name="folder_id" id="folders" class="form-control" required>
                    <option value="">Select Folder</option>
                    @foreach($folders as $folder)
                      <option value="{{$folder->id}}">{{$folder->name}}</option>
                    @endforeach
                </select> 
                </div>
                
                <input type="submit" class="btn btn-primary" value="Assign">
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
          if(commpany_id != '0'){
             $.ajax({
            url:'{{ url('/app-admin/fetch/employees/')}}' +'/'+ commpany_id,
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