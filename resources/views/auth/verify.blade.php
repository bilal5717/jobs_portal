<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Jobs Portal | Verify Email</title>
		<meta name="description" content="">
		<meta name="keywords" content="">
		<link href='{{asset('public/favicon.ico')}}' rel='shortcut icon' type='image/x-icon' />
		<link rel="stylesheet" href="{{asset('public/css/parsley.css')}}">
		<link rel="stylesheet" href="{{asset('public/css/bootstrap.min.css')}}">
		<link rel="stylesheet" href="{{asset('public/css/font-awesome.min.css')}}">
		<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="{{asset('public/frontend/assets/styles/custom.css')}}">
		@toastr_css

	</head>
	<body>

		<div class="flex-row account-wrap">
			<div class="flex-col half left">
				<div class="inner">
					<h2>WELCOME TO</h2>
					<h3>OUR JOBS PORTAL</h3>
					<p>This is the exaample text about the services.</p>
				</div>
			</div>
			<div class="flex-col half right">
				<div class="inner">
					<div class="account-box">
						<a href="{{config('app.wp_url', '/')}}">
							<!--<img src="{{asset('public/frontend/assets/images/logo.png')}}" class="login-logo" />-->
						</a>
						<h2 class="caption">JOBS PORTAL <br /><small>Verify Your Email</small></h2>
						<div class="clear40"></div>
						
						@if (session('resent'))
	                        <div class="alert alert-success" role="alert">
	                            {{ __('A fresh verification link has been sent to your email address.') }}
	                        </div>
	                    @endif
							@php
							  //dd(Auth::user());
							@endphp
	                    {{ __('Hi ') }}  <b>{{Auth::user()->name}}</b><br />
	                    {{ __('Before proceeding, please check your email for a verification link or ') }}
	                    
	                    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>.
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
	                    
	                    {{ __('If you did not receive the email, please resend to your registered email at '.Auth::user()->email) }} <br /> <br />
	                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
	                        @csrf
	                        <div style="text-align: center;">
	                        	<button type="submit" class="btn btn-primary align-baseline">{{ __('Resend Verification Link') }}</button>
	                        </div>
	                    </form>

					</div>
					<div class="text-center copyrights">© 2020.</div>
				</div>
			</div>
		</div>


		<script src="{{asset('public/js/jquery.min.js')}}"></script>
		<script src="{{asset('public/js/bootstrap.bundle.min.js')}}" defer></script>
		<script src="{{asset('public/js/parsley.min.js')}}"></script>
		@toastr_js
		@toastr_render
		<script>
			$('#form').parsley();
			
		</script> 
	</body>
</html>