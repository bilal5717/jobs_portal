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
                    <form method="post" action="{{url('app-admin/folder/'.$folder->id)}}" id="form">
                        @csrf
                        @METHOD("PUT")
                        <div class="form-group">
                            <label for="name">Folder Name:</label>
                            <input type="text" class="form-control" name="name" id="name"  value="{{$folder->name}}" required data-parsley-maxlength="15" data-parsley-minlength="5" data-parsley-trigger="change">
                            <input type="hidden" name="folder_id" value="{{$folder->id}}">
                            <!--<input type="hidden" name="user_id" value="{{$folder->user_id}}">-->
                        </div>
                        <!--<div class="form-group">
                            <label for="companyName">Company Name</label>
                            <select class="form-control" name="company_id" required>
                                <option value="">Choose Company</option>
                            	@foreach($companies as $company)
                                <option value="{{$company->id}}" {{$selected_company == $company->id ? "selected": NULL}}>{{$company->company_name}}</option>
                            	@endforeach
                            </select>
                        </div>-->
                        @if($folder->parent_id == '0')
	                        <div class="form-group">
	                            <label for="companyName">Company Name</label>
	                            <select class="form-control" name="company_id">
	                                <option value="">Choose Company</option>
	                            @foreach($companies as $company)
	                                <option value="{{$company->id}}" {{$selected_company == $company->id ? "selected": NULL}}>{{$company->company_name}}</option>
	                            @endforeach
	                            </select>
	                        </div>							
						@else
							<input type="hidden" name="company_id" value="{{$selected_company}}">
						@endif
                        <button type="submit" class="btn btn-primary btn-sm float-right">Update</button>
                        
                        <a href="{{url('app-admin/subfolder/'.$folder->id.'/view')}}" class="mx-auto btn btn-primary btn-sm pull-left" style="margin-right: 10px !important;">back</a> 

                    </form>
                </div>
                
            </div>
        </div>
    
@endsection
