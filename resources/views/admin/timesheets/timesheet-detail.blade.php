@extends('admin.common.index')
@section('styles')

@endsection
@section('content')
<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			Timesheet Management
		</div>
		<div class="card-body">
			<div class="col-lg-12 col-md-12 col-sm-12">
				@include('admin.users_management.user_details.user_profile')
					<br /><hr />
					<div class="timesheet-form-details">
						@php
						if($timesheet->status == 'pending'){
						$badgeClass = "badge badge-info";
						}elseif($timesheet->status == 'denied'){
						$badgeClass = "badge badge-danger";
						}elseif($timesheet->status == 'approved'){
						$badgeClass = "badge badge-success";
						}else{
						$badgeClass = "badge badge-warning";
						}
						@endphp
						<div><strong>Status:</strong> <span class="badge-pill {{$badgeClass}}" style="padding: 5px;">{{$timesheet->status}}</span></div>
						<div><strong>Title:</strong> {{$timesheet->title}} </div>
						<div><strong>Start Date:</strong> 
							<label title="{{date('D, M Y', strtotime($timesheet->start_date))}}">{{date('d/m/yy', strtotime($timesheet->start_date))}}</label>
							&nbsp; To &nbsp;  <label title="{{date('D, M Y', strtotime($timesheet->end_date))}}">{{date('d/m/yy', strtotime($timesheet->end_date))}}</label>
						</div>
					</div>
					<div class="input-container" style="overflow: auto;">
						<table class="table table-hover table-bordered" style="border: 2px #ebeaf0 solid;">
							<thead>
								<tr>
									<th scope="col" width="5%">DAYs</th>
									<th scope="col" width="25%">Location</th>
									<th scope="col" width="10%">DATE</th>
									<th scope="col" width="10%">IN TIME</th>
									<th scope="col" width="10%">OUT TIME</th>
									<th scope="col" width="5%">HOURS</th>
									<th scope="col">NOTES</th>
								</tr>
							</thead>
							<tbody>
								@php
								$daysCount = 1;
								$weekEnd = FALSE;
								$weekCount = 1;
								$allRowDurations = [];
								@endphp
								@foreach($timesheet_days as $timesheet_day)
								@php 
								if($daysCount == 8){
								$weekEnd = TRUE;
								$daysCount = 2;
								$weekCount++;
								}else{
								$weekEnd = FALSE;
								$daysCount++;
								}
								$rowDuration = '0:00';
								if(isset($timesheet_day['check_in_time']) && isset($timesheet_day['check_out_time'])){
										
								$start_date = new DateTime($timesheet_day['date'].' '.$timesheet_day['check_in_time']);
								$since_start = $start_date->diff(new DateTime($timesheet_day['date'].' '.$timesheet_day['check_out_time']));
								$rowDuration = $since_start->h.':'.$since_start->i;
								$allRowDurations[] = $rowDuration;
								}
								@endphp
								<!--@if($weekEnd)
								<div class="row">
									Week {{$weekCount}} starts
								</div>
								@endif-->
								<tr>
									<td>{{isset($timesheet_day['date'])? date('D', strtotime($timesheet_day['date'])):'Day'}}</td>
									<td>{{isset($timesheet_day['location'])?$timesheet_day['location']:''}}</td>
									<td>{{isset($timesheet_day['date'])?$timesheet_day['date']:''}}</td>
									<td>{{isset($timesheet_day['check_in_time'])?$timesheet_day['check_in_time']:''}}</td>
									<td>{{isset($timesheet_day['check_out_time'])?$timesheet_day['check_out_time']:''}}</td>
									<td>{{$rowDuration}}</td>
									<td>{{isset($timesheet_day['notes'])?$timesheet_day['notes']:''}}</td>
								</tr>
								@endforeach
								<tr>
									<td colspan="5"><strong>Total hours: </strong></td>
									<td><strong>{{sumArrayOfTimes($allRowDurations)}}</strong></td>
									<td></td>
								</tr>
								
							</tbody>
						</table>
					</div>
				
			</div>
			
			<br />
			
			<div class="col-lg-12 col-md-12 col-sm-12">
				<!--Timesheet Form End-->
				@if(is_allowed('deny_timesheet') || is_allowed('approve_timesheet') || is_allowed('pay_timesheet'))
				<form action="{{route('admin.save_timesheet_action')}}" method="post">
					@csrf()
					<div class="row">
						<div class="col-md-12">
							<h4>Timesheet Approval details</h4>
						</div>
						<input type="hidden" name="admin_id" value="{{Auth::guard('admin')->user()->id}}" required />
						<input type="hidden" name="timesheet_id" value="{{$timesheet->id}}" required />
						<input type="hidden" name="user_id" value="{{$timesheet->user_id}}" required />
						<div class="col-md-6">
							<div class="form-group">
								<label for="sheet-status">Timesheet Status</label>
								<select class="form-control" name="status" id="sheet-status" placeholder="Select action" required>
									<option value="" {{($timesheet->status != 'denied' && $timesheet->status != 'paid' && $timesheet->status != 'approved')? 'selected':''}}>Select Action</option>
									@if(is_allowed('approve_timesheet'))
									<option value="approved" {{($timesheet->status == 'approved')? 'selected':''}}>Approve</option>
									@endif
									@if(is_allowed('deny_timesheet'))
									<option value="denied" {{($timesheet->status == 'denied')? 'selected':''}}>Deny</option>
									@endif
									@if(is_allowed('pay_timesheet'))
									<option value="paid" {{($timesheet->status == 'paid')? 'selected':''}}>Pay</option>
									@endif
								</select>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="sheet-status">Messages for user</label>
								<textarea class="form-control" name="comments" id="messages" placeholder="Type comments for user." required></textarea>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<input type="submit" class="btn btn-warning" id="submit-action" value="Submit" />
							</div>
						</div>
					</div>
				</form>
				@endif
				<hr />
				
				<div class="row">
					<div class="col-md-12">
						<h4>Latest comments</h4>
					</div>
					<div class="col-md-12">
						@if(count($timesheet->timesheet_comments) > 0)
						@foreach($timesheet->timesheet_comments as $comment)
						<div><span class="badge badge-success"> </span> {{$comment->comment}} &nbsp; Posted By <strong>{{getadminName(Auth::guard('admin')->user()->id)}}</strong> <br/ >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; At <strong>{{date('D: d M Y h:i a', strtotime($comment->updated_at))}}</strong></div>
						@endforeach
						@else
						<div>(No comments yet)</div>
						@endif
					</div>
				</div>
			</div>
			<br />
			<hr />
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="row">
					<div class="col-md-12">
						<h4>Latest Timesheets</h4>
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
									@if(!is_allowed('pending_timesheets') && $timesheetRec->status == 'pending')
										@continue;
									@endif
									@if(!is_allowed('denied_timesheets') && $timesheetRec->status == 'denied')
										@continue;
									@endif
									@if(!is_allowed('approved_timesheets') && $timesheetRec->status == 'approved')
										@continue;
									@endif
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
											@if(is_allowed('open_timesheet'))
											<a href="{{route('admin.open_timesheet')}}/{{$timesheetRec->id}}" type="button" class="btn btn-outline-secondary"> Open </a>
											@endif
											@if($timesheetRec->status != 'approved')
											<!--
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
											-->
											@endif
										</div>
									</td>
								</tr>
								@endforeach
								<!--<tr>
								<th scope="row">2</th>
								<td>Jacob</td>
								<td>Thornton</td>
								<td>@fat</td>
								</tr>-->
							</tbody>
						</table>
					</div>
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