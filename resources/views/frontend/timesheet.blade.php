@extends('frontend.include.layout1')
@section('styles')

@endsection
@section('sub-content')
<style>
	/*Scroll bar css*/
	.scroller::-webkit-scrollbar {
	    width: 5px;
	    background-color: #F5F5F5;
	}
	.scroller::-webkit-scrollbar-thumb {
	    background-color: #999;
	}
	.scroller::-webkit-scrollbar-track {
	    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	    background-color: #F5F5F5;
	}
</style>

@if($user->user_status == 'approved')

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12">
		<div id="contact-form" class="form-container timesheet-from" data-form-container>
			<!--Timesheet Form Start-->
			@if($timesheet_opened)
			<div class="row" id="editTimesheetBox" style="display: none;">
				<div>
					<form method="post" action="{{route('edit_timesheet')}}">
						@csrf()
						<!--min="2020-09-15"-->
						<input type="hidden" name="id" value="{{$timesheet->id}}" />
						<input type="text" class="large-input" value="{{$timesheet->title}}" id="title" name="title" placeholder="Give timesheet a title." required/> &nbsp;
						<input type="date" class="medium-input" value="{{$timesheet->start_date}}" id="start_date" min="{{$last_timesheet_date}}" name="start_date" placeholder="Start date.." required/> &nbsp;
						<input type="date" class="medium-input" value="{{$timesheet->end_date}}"  id="end_date" min="0000-00-00" name="end_date" placeholder="End date.." required/> &nbsp;
						<button type="submit" class="btn btn-primary">Save Timesheet</button> &nbsp;
					</form>
				</div>
			</div>
			<div class="row" id="timesheetInfoBox">
				<div class="form-title">
					Current Timesheet: &nbsp; @if($timesheet->status != 'denied') <a href="javascript:;" onclick="$('#editTimesheetBox').toggle('slow');" class="edit-timesheet"><i class="fa fa-pencil"></i></a> @endif
				</div>
				<div class="timesheet-form-details">
					<div><small>Status:</small> {{$timesheet->status}}</div>
					<div><small>Title:</small> {{$timesheet->title}} </div>
					<div><small>Start Date:</small> 
						<label title="{{date('D, M Y', strtotime($timesheet->start_date))}}">{{date('d/m/yy', strtotime($timesheet->start_date))}}</label>
						 - <label title="{{date('D, M Y', strtotime($timesheet->end_date))}}">{{date('d/m/yy', strtotime($timesheet->end_date))}}</label>
					</div>
				</div>
			</div>
			<div class="input-container scroller" style="overflow-x: auto;">
				<div class="timesheet-form-box">
					<form action="{{route('save_timesheet')}}" method="post">
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
							<span class="req-input valid">
								<span class="input-status" data-toggle="tooltip" data-placement="top" title="Please enter the place of your job location."> </span>
								<textarea name="data[{{$timesheet_day['date']}}][location]" class="large-input" placeholder="Enter Location..">{{isset($timesheet_day['location'])?$timesheet_day['location']:''}}</textarea>
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
							<span class="req-input valid">
								<span class="input-status" data-toggle="tooltip" data-placement="top" title="Input your post title."> </span>
								<textarea name="data[{{$timesheet_day['date']}}][notes]" class="large-input" placeholder="Comments..">{{isset($timesheet_day['notes'])?$timesheet_day['notes']:''}}</textarea>
							</span>
						</div>

						@endforeach
						<!--<div class="row" style="text-align: right;">
						</div>-->
						<div class="row submit-row">
							<button type="submit" class="btn btn-block submit-form valid">Save Timesheet</button>&nbsp;
							
							<button type="button" onclick="{{($submit_button == TRUE) ? 'if(confirm("Are you sure to submit the timesheet?")){$("#submitForm").submit();}': 'javascript:;'}}" class="btn btn-block submit-form valid {{($submit_button == TRUE) ? '':'disabled'}}">Submit</button>
							
							<div class="hours-box">Total hours: <label id="total_hours_all">0:00</label></div>
						</div>
					</form>
				</div>
				<form id="submitForm" action="{{route('submit_timesheet')}}" method="post">
					@csrf()
					<input type="hidden" name="timesheet_id" value="{{$timesheet->id}}" />
					<input type="hidden" name="user_id" value="{{$timesheet->user_id}}" />
				</form>
			</div>
			@endif
			<!--Timesheet Form End-->
			
			<!--New timesheet form-->
			@if(!$timesheet_opened)
			<div class="row">
				<div>
					<form method="post" action="{{url('timesheet/new')}}">
						@csrf()
						<!--min="2020-09-15"-->
						<input type="text" class="large-input" id="title" name="title" placeholder="Give timesheet a title." required/> &nbsp;
						<input type="date" class="medium-input" id="start_date" min="{{$last_timesheet_date}}" name="start_date" placeholder="Start date.." required/> &nbsp;
						<input type="date" class="medium-input"  id="end_date" min="0000-00-00" name="end_date" placeholder="End date.." required/> &nbsp;
						<button type="submit" class="btn btn-primary">New Timesheet</button> &nbsp;
					</form>
				</div>
			</div>
			@endif
			
			<!--Timesheets listing start-->
			<div class="row">
				<div class="col-md-12">&nbsp;</div>
				<div class="form-title">
					Recent Submissions: 
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

@else
<div class="row">
	
	<div class="col-lg-12 col-md-12 col-sm-12">
		<br />
		<div class="alert alert-warning" role="alert">
		  	<span><b>Note:</b> You can not access timesheets untill your account is approved.</span>
		</div>
		
	</div>
</div>
@endif

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