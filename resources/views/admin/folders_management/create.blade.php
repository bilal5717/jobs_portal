@extends('admin.common.index')



@section('content')
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Folder Management
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
                    <form method="post" action="{{route('admin.folder.store')}}" id="form">
                        @csrf
                        <div class="form-group">
                            <label for="name">Folder Name:</label>
                            <input type="text" class="form-control" name="name" id="name"  placeholder="Enter folder name" required data-parsley-maxlength="15" data-parsley-minlength="5" data-parsley-trigger="change">
                            <input type="hidden" name="parent_id" value="{{$parentID}}">
                        </div>
                        @if(!$parentID)
	                        <div class="form-group">
	                            <label for="companyName">Company Name</label>
	                            <select class="form-control" name="company_id">
	                                <option value="">Choose Company</option>
	                            @foreach($companies as $company)
	                                <option value="{{$company->id}}">{{$company->company_name}}</option>
	                            @endforeach
	                            </select>
	                        </div>							
						@else
							<input type="hidden" name="company_id" value="{{$selected_company}}">
						@endif
						
                        <button type="submit" class="btn btn-primary btn-sm float-right">Submit</button>
                        
                        @if($parentID)
	                		<a href="{{url('app-admin/subfolder/'.$parentID.'/view')}}" class="mx-auto btn btn-primary btn-sm pull-left">back</a>
	                    @else
	                    	<a href="{{url('app-admin/folder')}}" class="mx-auto btn btn-primary btn-sm pull-left">back</a>
	                    @endif 
                    </form>
                </div>
                
            </div>
        </div>
    
@endsection
