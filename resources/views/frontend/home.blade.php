@extends('frontend.include.layout1')

@section('sub-content')

	<div class="row">
		<div class="col-lg-8 col-md-12 col-sm-12">
			<div class="content-links-box">
				<h2 class="my-heading">account progress! {{$step}}</h2>
				<ul class="dashboard-items">
					<li class="{{($step >= 1)? 'done':'not-done'}}"><i class="check-icon fa fa-check-circle"></i> <a href="{{url('/account/1')}}">account created</a></li>
					<li class="{{($step >= 2)? 'done':'not-done'}}"><i class="check-icon fa fa-check-circle"></i> <a href="{{url('/account/2')}}">you have applied for a job</a></li>
					<li class="{{($step >= 3)? 'done':'not-done'}}"><i class="check-icon fa fa-check-circle"></i> <a href="{{url('/account/3')}}">profile information updated</a></li>
					<li class="{{($step >= 4)? 'done':'not-done'}}"><i class="check-icon fa fa-check-circle"></i> <a href="{{url('/account/4')}}">account approved</a></li>
					<li class="{{($step >= 5)? 'done':'not-done'}}"><i class="check-icon fa fa-check-circle"></i> <a href="{{url('/quiz')}}">improve your profile</a></li>
				</ul>
			</div>
		</div>
		<div class="col-lg-4 col-md-12 col-sm-12 img-main-rightPart">
			<div class="row">
				<div class="col-md-12">
					<div class="row image-right-part">
						<div class="circle-box">
							<div class="c100 p{{$percentage}} percentageBox big">
								<span>{{$percentage}}%</span>
								<div class="slice">
									<div class="bar"></div>
									<div class="fill"></div>
								</div>
							</div>            				
						</div>
					</div>
				</div>
				<!--<div class="col-md-12 image-right-detail-section2"></div>-->
			</div>
		</div>
	</div>

@endsection
@section('script')
	<script>
		$(document).ready(function(){
			/*Homepage script*/
			var hoverdPercentage = function(){
				setTimeout(function(){
					$('.percentageBox').addClass('hovered');
					setTimeout(function(){
						$('.percentageBox').removeClass('hovered');
					},2000);
				},1000);				
			}
			hoverdPercentage();
			$('.dashboardTab').click(function(){
				hoverdPercentage();
			});
		});
	</script>
@endsection