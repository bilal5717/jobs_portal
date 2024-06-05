@extends('admin.common.index')


@section('content')
        <div class="col-md-12">
        	
        	
        
            <div class="card">
            	
            
                <div class="card-header">
                    Folder Management
                    
                    <!--
                    @if($parent)
		                <a href="{{url('app-admin/subfolder/'.$parentID.'/create')}}" class="btn btn-icon btn btn-label btn-label-brand btn-bold pull-right">
	                        <i class="flaticon2-add-1"></i>
	                    </a>
                    @else 
                    <a href="{{url('app-admin/folder/create')}}" class="btn btn-icon btn btn-label btn-label-brand btn-bold pull-right">
                    	<i class="flaticon2-add-1"></i>
                    </a>
                    @endif
                	-->
                
	                <div class="dropdown dropdown-inline pull-right" title="" data-placement="top" data-original-title="Quick actions">
	                    <a href="#" class="btn btn-icon btn btn-label btn-label-brand btn-bold" data-toggle="dropdown" data-offset="0px,0px" aria-haspopup="true" aria-expanded="false">
	                        <i class="flaticon2-add-1"></i>
	                    </a>
	                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-199px, 34px, 0px);" x-placement="bottom-end">
	                        <ul class="kt-nav kt-nav--active-bg" role="tablist">
	                            @if($parent)
	                            	<li class="kt-nav__item">
		                                <a class="kt-nav__link" role="tab"  href="{{url('app-admin/subfolder/'.$parentID.'/create')}}">
		                                    <i class="kt-nav__link-icon flaticon2-folder"></i>
		                                    <span class="kt-nav__link-text">Create new folder</span>
		                                </a>
		                            </li>
			                    @else 
				                    <li class="kt-nav__item">
		                                <a class="kt-nav__link" role="tab"  href="{{url('app-admin/folder/create')}}">
		                                    <i class="kt-nav__link-icon flaticon2-folder"></i>
		                                    <span class="kt-nav__link-text">Create new folder</span>
		                                </a>
		                            </li>
			                    <!--<a href="{{url('app-admin/folder/root/file')}}" class="btn btn-sm btn-primary mx-2">Root Files</a>-->
			                    @endif
			                    @if($parent)
		                            <li class="kt-nav__item">
		                                <a class="kt-nav__link" role="tab" target="_blank" href="{{url('app-admin/folder/'.$parentID.'/file/upload')}}">
		                                    <i class="kt-nav__link-icon flaticon2-file"></i>
		                                    <span class="kt-nav__link-text">Upload files</span>
		                                </a>
		                            </li>
	                            @endif
	                        </ul>
	                    </div>
						
						<a href="#" class="btn btn-icon btn btn-label btn-label-brand btn-bold" id="toogleSearchForm" data-offset="0px,0px" aria-haspopup="true" aria-expanded="false">
	                        <i class="flaticon2-magnifier-tool"></i>
	                    </a>
						<a href="javascript:;" class="btn btn-icon btn btn-label btn-label-brand btn-bold" onclick="location.reload();" id="refreshButton" data-offset="0px,0px" aria-haspopup="true" aria-expanded="false">
	                        <i class="flaticon-refresh"></i>
	                    </a>
	                </div>
                
                
                </div>
                <div class="card-body">
                	<nav aria-label="breadcrumb">
	                    <ul class="breadcrumb">
				          @if($bredcrumbPath)
	                    	<li class="breadcrumb-item"><a class="kt-link" href="{{url('app-admin/folder')}}">All Folders</a></li>
				            @foreach($bredcrumbPath as $bread)
					            @if($loop->last)
					            	<i  class="breadcrumb-item active"></i> <li>{{$bread['name']}}</li>
					            @else
					            	<li class="breadcrumb-item"><a class="kt-link" href="{{url('app-admin/subfolder/'.$bread['id'].'/view')}}">{{$bread['name']}}</a></li>
					            @endif
				          	@endforeach
				        @else
				            <li class="breadcrumb-item"><a class="kt-link" href="javascript:;">All Folders</a></li>
				        @endif
				        </ul>
			        </nav>

                </div>
				<div id="filterForm" style="display: {{($searched)?'block':'none'}};">
					@php
						if(!$parentID){
							$actionUrl = route('admin.folders');
						}else{
							$actionUrl = url('app-admin/subfolder/'.$parentID.'/view');
						}
					@endphp
					<form class="form" action="{{$actionUrl}}" method="post">
						@csrf
						<div class="card-body">
							<div class="form-group row">
								<div class="col-lg-6">
									<label>Folder Name:</label>
									<input type="text" name="name" class="form-control" value="{{Request::get('name')}}" placeholder="Enter folder name"/>
									<!--<span class="form-text text-muted">Please enter folder name</span>-->
								</div>
								@if(!$parentID)
								<div class="col-lg-6">
									<label>Select Company:</label>
		                            <select class="form-control" name="company_id"  id="companyBox">
		                                <option value="">Choose Company</option>
		                            	@foreach($companies as $company)
		                                <option value="{{$company->id}}" {{ (Request::get('company_id') == $company->id ? "selected":"") }}>{{$company->company_name}}</option>
		                            	@endforeach
		                            </select>
									<!--<span class="form-text text-muted">Please select company to sort</span>-->
		                        </div>
		                        @endif
		                        <br>
		                	</div>
		                	@if(!$parentID)
		                	<div class="form-group row">
		                        <div class="col-lg-12">
									<div class="form-group">
										<div class="checkbox-list">
											<label class="checkbox" for="IncludeFolders">
												<input type="checkbox" name="sub_folders"  id="IncludeFolders" />
												<span></span>
												Include results from all folders and subfolders
											</label>
										</div>
									</div>
								</div>
							</div>
							@endif
							<div class="row">
								<div class="col-lg-6">
									<button type="submit" class="btn btn-primary mr-2">Filter</button>
									<a type="reset" href="{{$actionUrl}}" class="btn btn-secondary">Cancel</a>
									<!--onclick="$('#filterForm').toggle();"-->
								</div>
							</div>
						</div>
					</form>						
				</div>
                
					                
                
                <table class="table  mx-auto">
                    <thead>
                      <tr>
                        <!--<th scope="col">#</th>-->
                        <th scope="col">Name</th>
                        
                        @if(!$parentID)
                        	<th scope="col" width="30%">Company</th>
                        @endif
                        <th scope="col" width="10%">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($folders as $folder)
                        <tr>
                           	<!--<td>{{$loop->iteration}}</td>-->
                            <td><a href="{{url('app-admin/subfolder/'.$folder->id.'/view')}}"><i class="fa fa-folder kt-font-warning"></i> {{$folder->name}}  <sup>({{$folder->files_count}})</sup></a></td>
                            @if(!$parentID)
	                            @if(isset($folder->companies[0]))
	                            	<td>{{$folder->companies[0]->company_name}}</td> 
	                            @else	
	                            	<td> n/a </td>
		                      	@endif
		                    @endif
                            <td class="d-flex justify-content-center">
                                <!--<a href="{{url('app-admin/subfolder/'.$folder->id.'/view')}}" class=""  data-toggle="tooltip" title="View sub folders"><i class="fa fa-folder kt-label-font-color-1"></i></a> &nbsp;&nbsp;
                                <a href="{{url('app-admin/folder/'.$folder->id.'/file')}}" class=""  data-toggle="tooltip" title="View/upload files here"><i class="fa fa-file kt-label-font-color-1"></i></a> &nbsp;&nbsp;-->
                                <a href="{{url('app-admin/folder/'.$folder->id .'/edit')}}" class=""  data-toggle="tooltip" title="Edit this folder"><i class="fa fa-edit kt-label-font-color-1"></i></a> &nbsp;&nbsp;
                                <a href="javascript:;" onclick="if(confirm('Are you sure to delete this folder?')){document.getElementById('delete-folder-form-{{$folder->id}}').submit();}" class=""  data-toggle="tooltip" title="Delete this folder and all its content."><i class="fa fa-trash kt-label-font-color-1"></i></a> &nbsp;&nbsp;
                                <form style="display: none;" onsubmit="return confirm('Are you sure to delete this folder?');" id="delete-folder-form-{{$folder->id}}" action="{{url('app-admin/folder/'.$folder->id)}}" method="post" class="mx-2">
                                    @csrf
                                    @method('delete')
                                </form>
                            </td>
                        </tr>
                    @empty
                    
                    @endforelse
                    @if($parentID)
                    	@forelse ($files as $file)
                    		@php 
                    			$ext = preg_replace('/^.*\.([^.]+)$/D', '$1', $file->file);
                    			if($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'gif'){
									$iconFile = asset("public/assets/media/files/image.svg");
								}else if($ext == 'doc' || $ext == 'docx'){
									$iconFile = asset("public/assets/media/files/doc.svg");
								}else if($ext == 'pdf'){
									$iconFile = asset("public/assets/media/files/pdf.svg");
								}else if($ext == 'xls' || $ext == 'xlsx'){
									$iconFile = asset("public/assets/media/files/excel.svg");
								}else if($ext == 'csv'){
									$iconFile = asset("public/assets/media/files/csv.svg");
								}else{
									$iconFile = asset("public/assets/media/files/file.svg");
								}
                    		@endphp
	                        <tr>
	                        	<!--<td>{{$loop->iteration}}</td>-->
	                            @if(!empty($file->orignal_name))
	                            	<td><img src="{{$iconFile}}" alt="h2o" width="20" /> {{$file->orignal_name}}</td>
								@else
									<td><img src="{{$iconFile}}" alt="h2o" width="20" /> {{$file->file}}</td>
								
								@endif
	                            <td class="d-flex justify-content-center">
	                                <!--<a href="{{url('app-admin/folder/'.$parentID.'/file/'.$file->id .'/edit')}}" target="_blank" class=""  data-toggle="tooltip" title="Update this file"><i class="fa fa-edit kt-label-font-color-1"></i></a> &nbsp;&nbsp;-->
	                                <a onclick="return confirm('Are you sure to delete this file?');" href="{{url('app-admin/folder/'.$parentID.'/file/'.$file->id .'/delete')}}" class=""  data-toggle="tooltip" title="Delete"><i class="fa fa-trash kt-label-font-color-1"></i></a> 
	                             
	                            </td>
	                        </tr>
	                    @empty
	                        
	                    @endforelse                    
                    @endif
                    
                    @if(count($files) == 0 && count($folders) == 0)
                    	<tr><td class="text-center" colspan="3">This folder is empty.</td></tr>
                    @endif

                    
                    

                    </tbody>
                  </table>
            </div>
        </div>

@endsection
@section('script')
<script>
  window.onload = function(){
      
      $(document).ready(function(){
        
        $('#toogleSearchForm').click(function(){
        	$('#filterForm').toggle();
        });
        $('#IncludeFolders').click(function(){
        	if($(this).prop('checked')){
        		$( "#companyBox" ).prop( "disabled", true );
        		$( "#companyBox" ).val("");
        		
        	}else{
				$('#companyBox').prop('disabled', false);
			}
        });
      })
  }
  
  
</script>
@endsection