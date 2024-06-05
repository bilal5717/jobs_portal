@extends('admin.common.index')



@section('content')
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    File Management
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="post" action="{{route('admin.file.update')}}" enctype="multipart/form-data" id="form">
                        @csrf
                        <div class="form-group">
                            <label for="name">File:</label>
                            <input type="file" class="form-control" name="file" id="name" required data-parsley-error-message="This field is required">
                            @if(!empty($file->orignal_name))
                            	<small><b>Filename:</b> {{$file->orignal_name}}</small>
							@else
								<small><b>Filename:</b> {{$file->file}}</small>
							@endif
                            
                            <input type="hidden" name="file_id" value="{{$file->id}}">
                            <input type="hidden" name="folder_id" value="{{$folder_id}}">
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-sm float-right">Update</button>
                        
                        <a href="{{url('app-admin/subfolder/'.$folder_id.'/view')}}" class="mx-auto btn btn-primary btn-sm pull-left">back</a>
                    </form>
                </div>
                
            </div>
        </div>
  
@endsection