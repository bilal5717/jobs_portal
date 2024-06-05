@extends('frontend.include.index')

@section('content')


	<div class="container-fluid" id="grad1">
		<div class="container main-secction">
			@include('frontend.include.user_profile')
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="row user-left-part" style="margin-bottom: 30px;">
						<div class="col-md-12 col-sm-12 col-xs-12 pull-right profile-right-section">
							
							<div class="row profile-right-section-row">
								<div class="col-md-12">
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12">
											<ul class="nav nav-tabs" role="tablist">
												<li class="nav-item">
													<a class="nav-link dashboardTab  {{Route::currentRouteName()== 'home' ? 'active':''}}" href="{{url('/')}}"><i class="fa fa-user-circle"></i> Dashboard</a>
												</li>
												<li class="nav-item">
													<a class="nav-link {{Route::currentRouteName()== 'quiz' ? 'active':''}}" href="{{url('/quiz')}}"><i class="fa fa-info-circle"></i> Induction</a>
												</li> 
												<li class="nav-item">
													<a class="nav-link {{Route::currentRouteName()== 'timesheet' ? 'active':''}}" href="{{url('/timesheet')}}"><i class="fa fa-info-circle"></i> Timesheets</a>
												</li> 
											</ul>
											<!-- Tab panes -->
											<div class="tab-content">
												<div role="tabpanel" class="tab-pane fade show active" id="{{Route::currentRouteName()}}">
													@yield('sub-content')
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