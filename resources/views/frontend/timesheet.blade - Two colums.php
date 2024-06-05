@extends('frontend.include.index')

@section('styles')
 	<link rel="stylesheet" href="{{asset('public/frontend/assets/styles/user-home.css')}}" />
 	<link rel="stylesheet" href="{{asset('public/frontend/assets/styles/time-sheet.css')}}" />
 	
 	
@endsection


@section('content')


	<div class="container-fluid" id="grad1">
		<div class="container main-secction">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12 image-section">
					<img src="{{asset('public/frontend/assets/images/portal-user-banner.jpg')}}">
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="row user-left-part">
						<div class="col-md-3 col-sm-12 col-xs-12 user-profil-part pull-left">
							<div class="row">
								<div class="col-md-12 col-md-12-sm-12 col-xs-12 user-image text-center">
									<img src="{{asset('public/frontend/assets/images/default.jpg')}}" class="rounded-circle">
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12 user-detail-section1 text-center">
									<button id="btn-contact" (click)="clearModal()" data-toggle="modal" data-target="#contact" class="btn btn-success btn-block follow">Contactarme</button> 
									<button class="btn btn-warning btn-block">Timesheets</button>                               
								</div>
								<div class="row user-detail-row">
									<div class="col-md-12 col-sm-12 user-detail-section2 pull-left">
										<div class="border"></div>
										<p>FOLLOWER</p>
										<span>320</span>
									</div>                           
								</div>
	                       
							</div>
						</div>
						
						<div class="col-md-9 col-sm-12 col-xs-12 pull-right profile-right-section">
							<div class="row profile-right-section-row">
								<div class="col-md-12">
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12">
											<ul class="nav nav-tabs" role="tablist">
												<li class="nav-item">
													<a class="nav-link dashboardTab" href="{{url('/')}}"><i class="fa fa-user-circle"></i> Dashboard</a>
												</li>
												<li class="nav-item">
													<a class="nav-link active" href="#timesheet" role="tab" data-toggle="tab"><i class="fa fa-info-circle"></i> Timesheets</a>
												</li>                                                
											</ul>
											<!-- Tab panes -->
											<div class="tab-content">
												<div role="tabpanel" class="tab-pane fade show active" id="timesheet">
													<div class="row">
														<div class="col-lg-12 col-md-12 col-sm-12" style="overflow-x: auto;">
												    		
												    		
																<div id="contact-form" class="form-container timesheet-from" data-form-container>
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
																	<div class="row">
																		<div class="form-title">
																			<span> Time Sheets </span>
																		</div>
																	</div>
																	<div class="input-container">
																		<form>
												    						@csrf()
																			<div class="row timesheet-head">
																				<label class="day-label">DAYs</label>
																				<label class="head-label"> Project</label>
																				<label class="head-label medium-label"> IN TIME</label>
																				<label class="head-label medium-label"> OUT TIME</label>
																				<label class="head-label"> BREAK</label>
																				<label class="head-label large-input"> NOTES</label>
																			</div>
																			<div class="row">
																				<label class="day-label">MON</label>
																				<span class="req-input valid">
																					<span class="input-status" data-toggle="tooltip" data-placement="top" title="Input your post title."> </span>
																					<select>
																						<option value="1">Select..</option>
																						<option value="1">Project 1</option>
																						<option value="1">Project 2</option>
																						<option value="1">Project 3</option>
																					</select>
																				</span>
																				<span class="req-input valid">
																					<span class="input-status" data-toggle="tooltip" data-placement="top" title="Input your post title."> </span>
																					<input type="time" class="medium-input" data-min-length="8" placeholder="Post Title" value="testing post">
																				</span>
																				<span class="req-input valid">
																					<span class="input-status" data-toggle="tooltip" data-placement="top" title="Input your post title."> </span>
																					<input type="time" class="medium-input" data-min-length="8" placeholder="Post Title" value="testing post">
																				</span>
																				<span class="req-input valid">
																					<span class="input-status" data-toggle="tooltip" data-placement="top" title="Input your post title."> </span>
																					<input type="text" data-min-length="8" placeholder="Post Title" value="testing post">
																				</span>
																				<span class="req-input valid">
																					<span class="input-status" data-toggle="tooltip" data-placement="top" title="Input your post title."> </span>
																					<textarea class="" placeholder="Comments.."></textarea>
																				</span>
																			</div>
																			<div class="row">
																				<label class="day-label">TUE</label>
																				<span class="req-input valid">
																					<span class="input-status" data-toggle="tooltip" data-placement="top" title="Input your post title."> </span>
																					<select>
																						<option value="1">Select..</option>
																						<option value="1">Project 1</option>
																						<option value="1">Project 2</option>
																						<option value="1">Project 3</option>
																					</select>
																				</span>
																				<span class="req-input valid">
																					<span class="input-status" data-toggle="tooltip" data-placement="top" title="Input your post title."> </span>
																					<input type="time" class="medium-input" data-min-length="8" placeholder="Post Title" value="testing post">
																				</span>
																				<span class="req-input valid">
																					<span class="input-status" data-toggle="tooltip" data-placement="top" title="Input your post title."> </span>
																					<input type="time" class="medium-input" data-min-length="8" placeholder="Post Title" value="testing post">
																				</span>
																				<span class="req-input valid">
																					<span class="input-status" data-toggle="tooltip" data-placement="top" title="Input your post title."> </span>
																					<input type="text" data-min-length="8" placeholder="Post Title" value="testing post">
																				</span>
																				<span class="req-input valid">
																					<span class="input-status" data-toggle="tooltip" data-placement="top" title="Input your post title."> </span>
																					<textarea class="" placeholder="Comments.."></textarea>
																				</span>
																			</div>
																			<div class="row submit-row">
																				<button type="button" class="btn btn-block submit-form valid">Submit</button>
																			</div>
																		</form>
																	</div>
																</div>
															
														</div>
													</div>
												</div>
											</div>
										</div>
										
									</div>
								</div>
							</div>
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
		});
	</script>
@endsection