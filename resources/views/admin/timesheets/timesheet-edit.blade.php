@extends('admin.common.index')
@section('styles')
<link rel="stylesheet" href="{{asset('public/frontend/assets/styles/time-sheet.css')}}" />
@endsection
@section('content')
<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			Timesheet Management
		</div>
		<div class="card-body">
			<div class="col-lg-12 col-md-12 col-sm-12"">
				
				@include('admin.common.user_profile')
				
				<div id="contact-form" class="form-container timesheet-from" data-form-container>
						
					<div class="row" id="timesheetInfoBox" >
						<div class="form-title">
							Timesheet: &nbsp;
						</div>
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
							<div><small>Status:</small> <span class="badge-pill {{$badgeClass}}" style="padding: 5px;">{{$timesheet->status}}</span></div>
							<div><small>Title:</small> {{$timesheet->title}} </div>
							<div><small>Start Date:</small> 
								<label title="{{date('D, M Y', strtotime($timesheet->start_date))}}">{{date('d/m/yy', strtotime($timesheet->start_date))}}</label>
								- <label title="{{date('D, M Y', strtotime($timesheet->end_date))}}">{{date('d/m/yy', strtotime($timesheet->end_date))}}</label>
							</div>
						</div>
					</div>
					<div class="input-container"  style="overflow-x: auto;">
						<div class="timesheet-form-box">
							<form action="{{route('admin.save_timesheet_admin')}}" method="post">
								@csrf()
								<input type="hidden" name="timesheet_id" value="{{$timesheet->id}}" />
								<input type="hidden" name="user_id" value="{{$timesheet->user_id}}" />
								<div class="row timesheet-head">
									<label class="day-label-head">DAYs</label>
									<label class="head-label large-input"> Location</label>
									<label class="head-label medium-label"> DATE</label>
									<label class="head-label medium-label"> IN TIME</label>
									<label class="head-label medium-label"> OUT TIME</label>
									<label class="head-label"> HOURS</label>
									<label class="head-label large-input"> NOTES</label>
								</div>
								@php
								$daysCount = 1;
								$weekEnd = FALSE;
								$weekCount = 1;
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
								$totalDuration = '0:00';
								if(isset($timesheet_day['check_in_time']) && isset($timesheet_day['check_out_time'])){
										
								$start_date = new DateTime($timesheet_day['date'].' '.$timesheet_day['check_in_time']);
								$since_start = $start_date->diff(new DateTime($timesheet_day['date'].' '.$timesheet_day['check_out_time']));
								$totalDuration = $since_start->h.':'.$since_start->i;
								}
								@endphp
								@if($weekEnd)
								<div class="row">
									Week {{$weekCount}} starts
								</div>
								@endif
								<div class="row">
									<label class="day-label">{{isset($timesheet_day['date'])? date('D', strtotime($timesheet_day['date'])):'Day'}}</label>
									<span class="req-input valid large-input">
										<span class="input-status" data-toggle="tooltip" data-placement="top" title="Please enter the place of your job location."> </span>
										<textarea name="data[{{$timesheet_day['date']}}][location]" class="" placeholder="Enter Location..">{{isset($timesheet_day['location'])?$timesheet_day['location']:''}}</textarea>
									</span>
									<span class="req-input valid">
										<span class="input-status" data-toggle="tooltip" data-placement="top" title="Select date of job."> </span>
										<input name="data[{{$timesheet_day['date']}}][check_in_date]" readonly="true" type="date" class="medium-input" placeholder="Post Title" value="{{isset($timesheet_day['date'])?$timesheet_day['date']:''}}">
									</span>
									<span class="req-input valid">
										<span class="input-status" data-toggle="tooltip" data-placement="top" title="Select punch IN time."> </span>
										<input name="data[{{$timesheet_day['date']}}][check_in_time]" onchange="timediff({{strtotime($timesheet_day['date'])}})" id="in_{{strtotime($timesheet_day['date'])}}" type="text" class="INtimePic medium-input" placeholder="IN Time" value="{{isset($timesheet_day['check_in_time'])?$timesheet_day['check_in_time']:''}}">
									</span>
									<span class="req-input valid">
										<span class="input-status" data-toggle="tooltip" data-placement="top" title="Enter punch OUT time, or when did you leave."> </span>
										<input name="data[{{$timesheet_day['date']}}][check_out_time]" onchange="timediff({{strtotime($timesheet_day['date'])}})" id="out_{{strtotime($timesheet_day['date'])}}" type="text" class="OUTtimePic medium-input" placeholder="OUT Time" value="{{isset($timesheet_day['check_out_time'])?$timesheet_day['check_out_time']:''}}">
									</span>
									<span class="req-input valid" style="background: #9c9f9c;">
										<span class="input-status" data-toggle="tooltip" data-placement="top" title="Total Hours, calculated from your IN and OUT time."> </span>
										<input name="data[{{$timesheet_day['date']}}][hours]" style="border-color: #9c9f9c;" class="totalHour" id="hr_{{strtotime($timesheet_day['date'])}}" type="text" readonly="true" placeholder="0.00 HR" value="{{$totalDuration}}">
									</span>
									<span class="req-input valid large-input">
										<span class="input-status" data-toggle="tooltip" data-placement="top" title="Input your post title."> </span>
										<textarea name="data[{{$timesheet_day['date']}}][notes]" class="" placeholder="Comments..">{{isset($timesheet_day['notes'])?$timesheet_day['notes']:''}}</textarea>
									</span>
								</div>

								@endforeach
									
								<div class="row submit-row">
									<button type="submit" class="btn btn-block submit-form valid" style="display: none;">Save Timesheet</button>&nbsp;
									<div class="hours-box">Total hours: <label id="total_hours_all">0:00</label></div>
								</div>
							</form>
						</div>	
					</div>
				</div>

				<br />
				<hr />
				<!--Timesheet Form End-->
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
									<option value="" {{($timesheet->status != 'denied' && $timesheet->status != 'approved')? 'selected':''}}>Select Action</option>
									<option value="approved" {{($timesheet->status == 'approved')? 'selected':''}}>Approve</option>
									<option value="denied" {{($timesheet->status == 'denied')? 'selected':''}}>Deny</option>
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
				
				<br />
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
				
				<br />
				<hr />
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
	$(document).ready(function(){
			/*Timesheet Script*/
			function add7days(str){ 
				var date = new Date(str);
				var newdate = new Date(date);
				newdate.setDate(newdate.getDate() + 6);
				newdate = newdate.toISOString();
				var isoDate = newdate.split('T');
				return isoDate[0];
			}
			$('#end_date').click(function(){
					var date = $('#start_date').val();
					console.log(add7days(date));
					$(this).attr("min", add7days(date));
				});
			$( ".INtimePic" ).timepicker({
					showNowButton: true,
					showDeselectButton: true,
					showCloseButton: true,
					defaultTime:'now',
					onSelect: tpStartSelect,
					maxTime: {
						hour: 16, minute: 30
					}
				});
			$( ".OUTtimePic" ).timepicker({
					showNowButton: true,
					showDeselectButton: true,
					showCloseButton: true,
					defaultTime:'now',
					onSelect: tpEndSelect,
					minTime: {
						hour: 9, minute: 15
					}
				});
			// when start time change, update minimum for end timepicker
			function tpStartSelect( time, endTimePickerInst ) {
				$('#timepicker_end').timepicker('option', {
						minTime: {
							hour: endTimePickerInst.hours,
							minute: endTimePickerInst.minutes
						}
					});
			}
			// when end time change, update maximum for start timepicker
			function tpEndSelect( time, startTimePickerInst ) {
				$('#timepicker_start').timepicker('option', {
						maxTime: {
							hour: startTimePickerInst.hours,
							minute: startTimePickerInst.minutes
						}
					});
			}
		});
		
	function timeobject(t){
		a = t.replace('AM','').replace('PM','').split(':');
		h = parseInt(a[0]);
		m = parseInt(a[1]);
		ampm = (t.indexOf('AM') !== -1 ) ? 'AM' : 'PM';
		return {hour:h,minute:m,ampm:ampm};
	}

	function timediff(dateString){
		var s = document.getElementById('in_'+dateString).value;
		var e = document.getElementById('out_'+dateString).value;
		if(s != '' && e != ''){
			var h = document.getElementById('hr_'+dateString);
			s = timeobject(s);
			e = timeobject(e);
			e.hour = (e.ampm === 'PM' &&  s.ampm !== 'PM' && e.hour < 12) ? e.hour + 12 : e.hour;
			hourDiff = Math.abs(e.hour-s.hour);
			minuteDiff = e.minute - s.minute;

			if(minuteDiff < 0){
				minuteDiff = Math.abs(60 + minuteDiff);
				hourDiff = hourDiff - 1;
			}
			h.value = hourDiff+':'+ Math.abs(minuteDiff);
			sumOfHours();	
		}
	}
	/**
	* Calculate total hours
	*/
	Number.prototype.padDigit = function () 		{
		return (this < 10) ? '0' + this : this;
	}
	function sumOfHours() {
		var t1 = "00:00";
		var mins = 0;
		var hrs = 0;
		$('.totalHour').each(function () {
				t1 = t1.split(':');
				var t2 = $(this).val().split(':');
				mins = Number(t1[1]) + Number(t2[1]);
				minhrs = Math.floor(parseInt(mins / 60));
				hrs = Number(t1[0]) + Number(t2[0]) + minhrs;
				mins = mins % 60;
				t1 = hrs.padDigit() + ':' + mins.padDigit();
			});
		$('#total_hours_all').text(t1);
	}
	sumOfHours();
    
</script>
@endsection