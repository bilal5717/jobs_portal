@extends('admin.common.index-noaside')

<link href="{{asset('public/assets/plugins/custom/uppy/uppy.bundle.css?v=2.0.0')}}" rel="stylesheet" type="text/css">

@section('content')
        <div class="col-md-12">
            <div class="card center-block">
                <div class="card-header">
                    Upload files
                </div>
                <div class="card-body" style="text-align: center;">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                   <!-- <form method="post" action="{{route('admin.file.store')}}" enctype="multipart/form-data" id="form">
                        @csrf
                        <div class="form-group">
                            <label for="name">File:</label>
                            <input type="file" class="form-control" name="file" id="name"  required data-parsley-error-message="This field is required">
                            <input type="hidden" name="folder_id" value="{{$folder_id}}">
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-sm float-right">Submit</button>
                    </form>-->
					<nav aria-label="breadcrumb">
	                    <ul class="breadcrumb">
				          @if($bredcrumbPath)
	                    	<li class="breadcrumb-item">All Folders</li>
				            @foreach($bredcrumbPath as $bread)
					            @if($loop->last)
					            	<i  class="breadcrumb-item"></i> <li>{{$bread['name']}}</li>
					            @else
					            	<li class="breadcrumb-item">{{$bread['name']}}</li>
					            @endif
				          	@endforeach
				        @else
				            <li class="breadcrumb-item">All Folders</li>
				        @endif
				        </ul>
			        </nav>
                        <div class="col-lg-12">
							<div class="checkbox-list">
									<label class="checkbox" for="IncludeFolders">
										<input type="checkbox" name="closeWindowCheck"  id="closeWindowCheck" checked="checked"/>
										&nbsp; Close window on file(s) upload complete.
									</label>
								</div>
						</div>
					<div class="col-lg-4" style="margin: 0 auto;">
						<form method="post" action="{{route('admin.file.store')}}" enctype="multipart/form-data" id="uploadfilesform">
	                        @csrf
	                        <input type="hidden" name="folder_id" id="folder_id" value="{{$folder_id}}">
	                    </form>
						<div class="uppy" id="kt_uppy_2">
						</div>
					</div>
            	</div>
        </div>
    
@endsection
@section('script')
	<!--<script src="{{asset('public/assets/plugins/global/plugins.bundle.js?v=2.0.0')}}"></script>-->
	<script src="{{asset('public/assets/plugins/custom/uppy/uppy.bundle.js?v=2.0.0')}}"></script>
	<script src="{{asset('public/assets/js/pages/features/file-upload/uppy.js?v=2.0.0')}}"></script>

@endsection