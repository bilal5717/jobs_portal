@extends('admin.common.index')
@section('styles')
<link rel="stylesheet" href="{{asset('public/assets/css/time-sheet.css')}}" />
@endsection
@section('content')
<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			Timetable Management
		</div>
		<div class="card-body">
			<div class="col-lg-12 col-md-12 col-sm-12"">
				
				<div id="contact-form" class="form-container timesheet-from" data-form-container>
						
					<div class="row" id="timesheetInfoBox" >
						<div class="form-title">
							Timetable and schedules: &nbsp;
						</div>
						<!--<div class="timesheet-form-details">
							<div><small>Title:</small> Title Here </div>
							<div><small>Start Date:</small> Date Here </div>
						</div>-->
					</div>
					<div class="input-container"  style="overflow-x: auto;">
						<div class="timesheet-form-box" style="min-width: 1350px;">
							<form action="{{route('admin.save_timetable_admin')}}" method="post" id="add-titmetable-form">
								@csrf()
								
								<div class="row"  style="padding: 28px;">
									<div class="col-md-12">
		                            	<label for="name">Name of Timetable</label><br />
		                            	<input style="width: 30%;" type="text" class="form-control" name="timetable_title" id="timetable_title"  placeholder="Timetable name" required />
									</div>
									<div class="col-md-12">
		                            	<label for="name">Starting Date<small>(Select only with Monday)</small></label><br />
		                            	<input style="width: 30%;" type="date" class="form-control" name="start_date" id="satrt_date" value="<?php echo (isset($start_date)? $start_date : ''); ?>" placeholder="Timetable start date" required />
									</div>
	                          	</div>
								
								<div class="row timesheet-head" style="display: none;">
									<label class=" small-label">&nbsp;</label>
									<label class="day-label-head">DAYs</label>
									<label class="head-label medium-input"> Location</label>
									<label class="head-label large-input"> Employee</label>
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
								@foreach($timetable_days as $timesheet_day)
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
								$date = $timesheet_day['date'];
								@endphp
								@if($weekEnd)
								<div class="row">
									Week {{$weekCount}} starts
								</div>
								@endif
								<div class="row" id="row-date-{{$date}}" style="display: none;">
									<label class="add-icon-label row-add-new pulse " data-date="{{$date}}"> + </label>
									<label class="day-label">{{isset($timesheet_day['date'])? date('D', strtotime($timesheet_day['date'])):'Day'}}</label>
									<span class="req-input valid medium-input">
										<span class="input-status" data-toggle="tooltip" data-placement="top" title="Please enter the place of your job location."> </span>
										<select name="data[{{$timesheet_day['date']}}][project_id][]" class="" placeholder="Enter Location.." style="width: 110px;">
											<option value="">Select Site</option>
											@foreach($projects as $project)
												<option value="{{$project->id}}">{{$project->name}}</option>
											@endforeach
										</select>
									</span>
									<span class="req-input valid large-input">
										<!--<span class="input-status" data-toggle="tooltip" data-placement="top" title="Please enter the place of your job location."> </span>-->
										<div class="user-selection" style="display: block;width:100%;cursor: pointer;" date-string="{{strtotime($timesheet_day['date'])}}" data-date="{{$timesheet_day['date']}}">
											<input type="hidden" name="data[{{$timesheet_day['date']}}][user_id][]" value="" id="user_id_{{strtotime($timesheet_day['date'])}}"/>
											<div style="display: inline-block; width: 20%;float: left;">
												<img src="{{asset('public/assets/images/user-default-40x40.png')}}" id="user_image_{{strtotime($timesheet_day['date'])}}" width="40" height='40' />
											</div>
											<div style="display: inline-block; width: 70%;color: white;float: left;" id="user_info_{{strtotime($timesheet_day['date'])}}">
												Select Employee
											</div>
											<div style="display: inline-block; width: 8%;color: white;float: left;line-height: 40px;">
												&raquo;
											</div>
										</div>
									</span>
									<span class="req-input valid">
										<span class="input-status" data-toggle="tooltip" data-placement="top" title="Select date of job."> </span>
										<input name="data[{{$timesheet_day['date']}}][check_in_date][]" readonly="true" type="date" class="medium-input" placeholder="Post Title" value="{{isset($timesheet_day['date'])?$timesheet_day['date']:''}}">
									</span>
									<span class="req-input valid">
										<span class="input-status" data-toggle="tooltip" data-placement="top" title="Select punch IN time."> </span>
										<input name="data[{{$timesheet_day['date']}}][check_in_time][]" onchange="timediff({{strtotime($timesheet_day['date'])}})" id="in_{{strtotime($timesheet_day['date'])}}" type="text" class="INtimePic medium-input" placeholder="IN Time" value="{{isset($timesheet_day['check_in_time'])?$timesheet_day['check_in_time']:''}}">
									</span>
									<span class="req-input valid">
										<span class="input-status" data-toggle="tooltip" data-placement="top" title="Enter punch OUT time, or when did you leave."> </span>
										<input name="data[{{$timesheet_day['date']}}][check_out_time][]" onchange="timediff({{strtotime($timesheet_day['date'])}})" id="out_{{strtotime($timesheet_day['date'])}}" type="text" class="OUTtimePic medium-input" placeholder="OUT Time" value="{{isset($timesheet_day['check_out_time'])?$timesheet_day['check_out_time']:''}}">
									</span>
									<span class="req-input valid" style="background: #9c9f9c;">
										<span class="input-status" data-toggle="tooltip" data-placement="top" title="Total Hours, calculated from your IN and OUT time."> </span>
										<input name="data[{{$timesheet_day['date']}}][hours][]" style="border-color: #9c9f9c;" class="totalHour" id="hr_{{strtotime($timesheet_day['date'])}}" type="text" readonly="true" placeholder="0.00 HR" value="{{$totalDuration}}">
									</span>
									<span class="req-input valid large-input">
										<span class="input-status" data-toggle="tooltip" data-placement="top" title="Input your post title."> </span>
										<textarea name="data[{{$timesheet_day['date']}}][notes][]" class="" placeholder="Comments..">{{isset($timesheet_day['notes'])?$timesheet_day['notes']:''}}</textarea>
									</span>
								</div>

								@endforeach
									
								<div class="row submit-row p-5">
									<button type="submit" class="btn btn-block submit-form valid">Save Timesheet</button>&nbsp;
									<div class="hours-box" style="display: none;">Total hours: <label id="total_hours_all">0:00</label></div>
								</div>
							</form>
						</div>	
					</div>
				</div>
				
			</div>	                     
		</div>
	</div>
</div>

<!-- Button trigger modal-->
<!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Launch demo modal
</button>-->
<!-- Modal-->
<div class="modal fade" id="exampleModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Employees</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
            	<form id="searchUsers" action=''>
            		@csrf()
					<div class="form-group">
						<label>Search User</label>
						<div class="input-group input-group-sm">
							<div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span></div>
							<input type="text" name="name" class="form-control" value="" placeholder="Enter name" aria-describedby="basic-addon2"/>
						</div>
						<br />
						<div class="input-group input-group-sm">
							<div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></span></div>
							<input type="text" name="email" class="form-control" value="" placeholder="Enter name or email" aria-describedby="basic-addon2"/>
						</div>
						<br />
						
						<input type="hidden" id="selected_search_date" name="selected_search_date" value=""/>
						<!--<input type="hidden" name="user_status" value="approved"/>-->
						<button type="button" id="search-employees" class="btn btn-secondary btn-sm font-weight-bold">SEARCH</button>
					</div>
            	</form>

				
                <div class="row">
	                <div class="col-md-12 users-list">
		                @foreach($users as $user)
	                		<div class="row mb-1">
	                			<div class="col-md-2"><img src="{{getProfileImage($user->id)}}"  id="get_image_{{$user->id}}" width="50" /></div>
	                			<div class="col-md-8" id="get_info_{{$user->id}}">
	                				{{$user->name}}<br>
	                				{{$user->email}}
	                			</div>
	                			<div class="col-md-2"><a href="javascript:;" data-id="{{$user->id}}" class="select_user_button btn btn-primary btn-sm mt-2">SELECT</a></div>
	                		</div>
		                @endforeach
	                </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
        
<script>
	$(document).ready(function(){
		var getdateUser;
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
			
			function initTimepicker(){
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
			}

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
			initTimepicker();
			initInnerFunctionsNewRow();
			initForPopupUsersSearch();
			
			function initInnerFunctionsNewRow(){
				$('.delete-icon-label').click(function(){
					var getdate = $(this).attr('data-date');
					var currentRow = $('#row-date-'+getdate);
					currentRow.remove();
					sumOfHours();
				});
				$('.user-selection').click(function(){
					getdateUser = $(this).attr('date-string');//Do not change
					var dateSelected = $(this).attr('data-date');
					jQuery('#selected_search_date').val(dateSelected);
					jQuery('#exampleModal').modal('show');
				});
			}
			
			function initForPopupUsersSearch(){
				$('.select_user_button').click(function(){
					var userId = $(this).attr('data-id');
					var imgSrc = $('#get_image_'+userId).attr('src');
					var infoHTML = $('#get_info_'+userId).html();
					var selectedDate = jQuery('#selected_search_date').val();
					
					$.ajax({
				        url: "{{url('app-admin/duplicate_user_timetable')}}/"+userId+"/"+selectedDate,
				        type: "get",
				        success: function (response) {
				        	if(response == 'true'){
								alert("User already selected in the same date.")
							}else{
								if(getdateUser){
									$("#user_id_" + getdateUser).val(userId);
									$("#user_image_" + getdateUser).attr('src', imgSrc);
									$("#user_info_" + getdateUser).html(infoHTML);
								}
								jQuery('#exampleModal').modal('hide');
							}
				        },
				        error: function(jqXHR, textStatus, errorThrown) {
				           console.log(textStatus, errorThrown);
				        }
				    });	
					
					
				});
			}
			
			$('.row-add-new').click(function(){
				var getdate = $(this).attr('data-date');
				var currentRow = $('#row-date-'+getdate);
				var gerRowHtml = generateNewRowHtml(getdate);
				$(gerRowHtml).insertAfter(currentRow);
				setTimeout(function(){
					initTimepicker();
					initInnerFunctionsNewRow();
				}, 1000);
			});
			
			function generateNewRowHtml(date){
				var d = new Date(date);
				var datestring = d.toString();
				var dayName = d.toString().split(' ')[0];
				var dnewStamp = new Date().valueOf();
				var fullHtml = '<div class="row" id="row-date-'+dnewStamp+'">\
					<label class="delete-icon-label" data-date="'+dnewStamp+'"> - </label>\
					<label class="day-label-disabled">'+dayName+'</label>\
					<span class="req-input valid medium-input">\
						<span class="input-status" data-toggle="tooltip" data-placement="top" title="Please enter the place of your job location."> </span>\
						<select name="data['+date+'][location][]" class="" placeholder="Enter Location.." style="width: 110px;">\
							<option value="">Select Site</option>\
							<?php foreach($projects as $project){ ?>\
								<option value="<?php echo $project->id ?>"><?php echo $project->name ?></option>\
							<?php } ?>\
						</select>\
					</span>\
					<span class="req-input valid large-input">\
						<div class="user-selection" style="display: block;width:100%;cursor: pointer;" date-string="'+dnewStamp+'" data-date="'+date+'">\
							<input type="hidden" name="data['+date+'][user_id][]" value="" id="user_id_'+dnewStamp+'"/>\
							<div style="display: inline-block; width: 20%;float: left;">\
								<img src="{{asset('public/assets/images/user-default-40x40.png')}}" id="user_image_'+dnewStamp+'" width="40" height="40" />\
							</div>\
							<div style="display: inline-block; width: 70%;color: white;float: left;" id="user_info_'+dnewStamp+'">\
								Select Employee\
							</div>\
							<div style="display: inline-block; width: 8%;color: white;float: left;line-height: 40px;">\
								&raquo;\
							</div>\
						</div>\
					</span>\
					<span class="req-input valid">\
						<span class="input-status" data-toggle="tooltip" data-placement="top" title="Select date of job."> </span>\
						<input name="data['+date+'][check_in_date][]" readonly="true" type="date" class="medium-input" placeholder="Post Title" value="'+date+'">\
					</span>\
					<span class="req-input valid">\
						<span class="input-status" data-toggle="tooltip" data-placement="top" title="Select punch IN time."> </span>\
						<input name="data['+date+'][check_in_time][]" onchange="timediff('+dnewStamp+')" id="in_'+dnewStamp+'" type="text" class="INtimePic medium-input" placeholder="IN Time" value="">\
					</span>\
					<span class="req-input valid">\
						<span class="input-status" data-toggle="tooltip" data-placement="top" title="Enter punch OUT time, or when did you leave."> </span>\
						<input name="data['+date+'][check_out_time][]" onchange="timediff('+dnewStamp+')" id="out_'+dnewStamp+'" type="text" class="OUTtimePic medium-input" placeholder="OUT Time" value="">\
					</span>\
					<span class="req-input valid" style="background: #9c9f9c;">\
						<span class="input-status" data-toggle="tooltip" data-placement="top" title="Total Hours, calculated from your IN and OUT time."> </span>\
						<input name="data['+date+'][hours][]" style="border-color: #9c9f9c;" class="totalHour" id="hr_'+dnewStamp+'" type="text" readonly="true" placeholder="0:00" value="0:00">\
					</span>\
					<span class="req-input valid large-input">\
						<span class="input-status" data-toggle="tooltip" data-placement="top" title="Input your post title."> </span>\
						<textarea name="data['+date+'][notes][]" class="" placeholder="Comments.."></textarea>\
					</span>\
				</div>';
				return fullHtml;
			}
		
		/**
		* Search employees
		*/
		
		$('#search-employees').click(function(){
	 		var searchValue = $('#searchUsers').serialize();
	 		if(searchValue){
			 	$.ajax({
			        url: "{{route('admin.ajax_user_search')}}",
			        type: "post",
			        data: searchValue,
			        success: function (response) {
			        	var listHtml = "";
			        	if(response.length > 0){
			        		$.each(response, function(key, value){
			        			listHtml += '<div class="row mb-1">';
			        			listHtml += '<div class="col-md-2"><img src="'+ value.profile_image +'" width="50" id="get_image_'+ value.id +'" /></div>\
		                			<div class="col-md-8" id="get_info_'+ value.id +'">\
		                				'+value.name+' <br />\
		                				'+value.email+'\
		                			</div>\
		                			<div class="col-md-2"><a href="javascript:;"  data-id="'+ value.id +'" class="select_user_button btn btn-primary btn-sm mt-2">SELECT</a></div>';
								listHtml += '</div>';
			        		});
		                	$('.users-list').html(listHtml);
		                	initForPopupUsersSearch();
						}else{
							listHtml =  '<div class="row">\
		                			<div class="col-md-12">No user found</div>\
		                		</div>';
		                	$('.users-list').html(listHtml);
						}
			        },
			        error: function(jqXHR, textStatus, errorThrown) {
			           console.log(textStatus, errorThrown);
			        }
			    });				
			}
		});
		
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
	Number.prototype.padDigit = function (){
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