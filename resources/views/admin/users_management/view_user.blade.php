@extends('admin.common.index')

@section('content')
<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			User Details
		</div>
		<div class="card-body">
			<div class="col-lg-12 col-md-12 col-sm-12">
				@include('admin.users_management.user_details.user_profile')
			</div><br /><br />
			
			<div class="col-lg-12 col-md-12 col-sm-12">
				<ul class="nav nav-tabs nav-tabs-line">
				    <li class="nav-item" style="margin-right: 30px;">
				        <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">
				        	<span class="nav-icon"><i class="flaticon2-user"></i></span>
            				<span class="nav-text">Personal Information</span>
				        </a>
				    </li>
				    <li class="nav-item" style="margin-right: 30px;">
				        <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">
					        <span class="nav-icon"><i class="fa fa-user-graduate"></i></span>
	            			<span class="nav-text">Job Details</span>
				        </a>
				    </li>
				    <li class="nav-item" style="margin-right: 30px;">
				        <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_3">
					        <span class="nav-icon"><i class="fa fa-copy"></i></span>
	            			<span class="nav-text">Documents</span>
				        </a>
				    </li>
				    <li class="nav-item" style="margin-right: 30px;">
				        <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_4">
					        <span class="nav-icon"><i class="fa fa-calendar"></i></span>
	            			<span class="nav-text">Timesheets</span>
				        </a>
				    </li>
				    <!--<li class="nav-item dropdown">
				        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
				            Dropdown
				        </a>
				        <div class="dropdown-menu">
				            <a class="dropdown-item" data-toggle="tab" href="#kt_tab_pane_3">Action</a>
				            <a class="dropdown-item" data-toggle="tab" href="#kt_tab_pane_3">Another action</a>
				            <a class="dropdown-item" data-toggle="tab" href="#kt_tab_pane_3">Something else here</a>
				            <div class="dropdown-divider"></div>
				            <a class="dropdown-item" data-toggle="tab" href="#kt_tab_pane_3">Separated link</a>
				        </div>
				     </li>-->
				</ul>
				<div class="tab-content mt-5" id="myTabContent">
				    <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_1">
				    	<div class="col-lg-12 col-md-12 col-sm-12">
							@include('admin.users_management.user_details.personal_details')
						</div>
				    </div>
				    <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel" aria-labelledby="kt_tab_pane_2">
				    	<div class="col-lg-12 col-md-12 col-sm-12">
							@include('admin.users_management.user_details.job_details')
						</div>
				    </div>
				    <div class="tab-pane fade" id="kt_tab_pane_3" role="tabpanel" aria-labelledby="kt_tab_pane_3">
				    	<div class="col-lg-12 col-md-12 col-sm-12">
							@include('admin.users_management.user_details.documents')
						</div>
				    </div>
				    
				    <div class="tab-pane fade" id="kt_tab_pane_4" role="tabpanel" aria-labelledby="kt_tab_pane_4">
	    				@if($timesheets->all())
							<div class="col-lg-12 col-md-12 col-sm-12">
								<div class="row">
									<div class="col-md-12">
										<h4>All Timesheets</h4>
									</div>
									<div class="col-md-12">
										<table class="table table-hover">
											<thead>
												<tr>
													<th scope="col">ID#</th>
													<th scope="col">Title</th>
													<th scope="col">Dates (FROM-TO)</th>
													<th scope="col">Submit Date</th>
													<th scope="col">Status</th>
													<th scope="col" width="10%"> </th>
												</tr>
											</thead>
											<tbody>
												@foreach($timesheets as $timesheetRec)
												@php
												if($timesheetRec->status == 'pending'){
												$badgeClass = "badge-info";
												}elseif($timesheetRec->status == 'denied'){
												$badgeClass = "badge-danger";
												}elseif($timesheetRec->status == 'approved'){
												$badgeClass = "badge-success";
												}else{
												$badgeClass = "badge-warning";
												}
												@endphp
												<tr>
													<th scope="row">00{{$timesheetRec->id}}</th>
													<td>{{$timesheetRec->title}}</td>
													<td>{{date('d M Y', strtotime($timesheetRec->start_date))}} - {{date('d M Y', strtotime($timesheetRec->end_date))}}</td>
													<td>{{date('D: d M Y', strtotime($timesheetRec->submit_date))}}</td>
													<td><label class="badge {{$badgeClass}}">{{$timesheetRec->status}}</label></td>
													<td>
														<div class="btn-group">
															<a href="{{route('admin.open_timesheet')}}/{{$timesheetRec->id}}" type="button" class="btn btn-outline-secondary"> Open </a>
															<button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
																<span class="sr-only">Toggle Dropdown</span>
															</button>
															<div class="dropdown-menu" aria-labelledby="dropdownMenuReference">
																<a class="dropdown-item" onclick="changeTimesheetAction({{$timesheetRec->id}}, 'approved')" href="javascript:;">Approve</a>
																<a class="dropdown-item" onclick="changeTimesheetAction({{$timesheetRec->id}}, 'denied')" href="javascript:;">Deny</a>
																<form id="timesheet-status-form-{{$timesheetRec->id}}"  action="{{route('admin.timesheet_status_change')}}" method="post">
																	@csrf
																	<input type="hidden" name="timesheet_id" value="{{$timesheetRec->id}}" />
																	<input type="hidden" name="status" id="timesheet-status-{{$timesheetRec->id}}" value="" required="" />
																</form>
															</div>
														</div>
													</td>
												</tr>
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
								
							</div>
							@else
								<div class="col-lg-12 col-md-12 col-sm-12 text-center">
									Timesheets not available yet.
								</div>
							@endif
				    	
				    </div>
				    <!--<div class="tab-pane fade" id="kt_tab_pane_4" role="tabpanel" aria-labelledby="kt_tab_pane_4">Tab content 5</div>-->
				</div>
			</div>
		
			
			
			
			
			
			

		</div>  
	</div>
</div>
@endsection
@section('script')
<script>
	/*Timesheet Script*/
	function changeTimesheetAction(id, action){
		if(confirm('Are you sure to '+action+' this timesheet?')){
			console.log(id, action);
			$('#timesheet-status-'+id).val(action);
			$('#timesheet-status-form-'+id).submit();
		}
	}
</script>
@endsection