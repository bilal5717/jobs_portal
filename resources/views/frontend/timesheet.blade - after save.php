@extends('frontend.include.layout1')

@section('sub-content')

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12" style="overflow-x: auto;">
		<div id="contact-form" class="form-container timesheet-from" data-form-container>
			@if(!$timesheet_opened)
			<div class="row">
				<div>
					<form method="post" action="{{url('timesheet/new')}}">
						@csrf()
						<!--min="2020-09-15"-->
						<input type="text" class="large-input" id="title" name="title" placeholder="Give timesheet a title." required/> &nbsp;
						<input type="date" class="medium-input" id="start_date" name="start_date" placeholder="Start date.." required/> &nbsp;
						<input type="date" class="medium-input"  id="end_date" min="0000-00-00" name="end_date" placeholder="End date.." required/> &nbsp;
						<button type="submit" class="btn btn-primary">New Timesheet</button> &nbsp;
					</form>
				</div>
			</div>
			@endif
			
			<div class="row">
				<div class="form-title">
					Current Timesheet: 
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
			<div class="input-container">
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
						<span class="req-input valid">
							<span class="input-status" data-toggle="tooltip" data-placement="top" title="Input your post title."> </span>
							<textarea name="data[{{$timesheet_day['date']}}][notes]" class="" placeholder="Comments..">{{isset($timesheet_day['notes'])?$timesheet_day['notes']:''}}</textarea>
						</span>
					</div>

					@endforeach
					<!--<div class="row" style="text-align: right;">
					</div>-->
					<div class="row submit-row">
						<button type="submit" class="btn btn-block submit-form valid">Save Timesheet</button>&nbsp;
						
						<button type="submit" class="btn btn-block submit-form valid disabled">Submit</button>
						
						<div class="hours-box">Total hours: <label id="total_hours_all">0:00</label></div>
					</div>
					<!--<div class="row">
						<label class="day-label">MON</label>
						<span class="req-input valid">
							<span class="input-status" data-toggle="tooltip" data-placement="top" title="Please enter the place of your job location."> </span>
							<textarea class="" placeholder="Enter Location.."></textarea>
						</span>
						<span class="req-input valid">
							<span class="input-status" data-toggle="tooltip" data-placement="top" title="Select date of job."> </span>
							<input type="date" class="medium-input" placeholder="Post Title" value="">
						</span>
						<span class="req-input valid">
							<span class="input-status" data-toggle="tooltip" data-placement="top" title="Select punch IN time."> </span>
							<input type="time" class="medium-input" placeholder="IN Time" value="">
						</span>
						<span class="req-input valid">
							<span class="input-status" data-toggle="tooltip" data-placement="top" title="Enter punch OUT time, or when did you leave."> </span>
							<input type="time" class="medium-input" placeholder="OUT Time" value="">
						</span>
						<span class="req-input valid">
							<span class="input-status" data-toggle="tooltip" data-placement="top" title="Total Hours, calculated from your IN and OUT time."> </span>
							<input type="text" readonly="true" placeholder="0.00 HR" value="">
						</span>
						<span class="req-input valid">
							<span class="input-status" data-toggle="tooltip" data-placement="top" title="Input your post title."> </span>
							<textarea class="" placeholder="Comments.."></textarea>
						</span>
					</div>-->
					
					
				</form>
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
	Number.prototype.padDigit = function () {
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