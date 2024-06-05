<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Jobs Portal | Login</title>
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
						<h2 class="caption">JOBS PORTAL <br />LOGIN</h2>
						<div class="clear40"></div>
						<form method="post" action="{{url('login')}}" id="form" autocomplete="off">
							<div class="input-wrap">
								@csrf
								<input type="email" required placeholder="Email Address" name="email" data-parsley-trigger="change" data-parsley-type="email" autocomplete="off"/>
								@error('email')
								<span class="invalid-feedback   d-block text-center" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
							<div class="input-wrap">
								<input type="password" required placeholder="Password" name="password" data-parsley-maxlength="16" data-parsley-minlength="8" data-parsley-trigger="change" autocomplete="off"/>
								@error('password')
								<span class="invalid-feedback   d-block text-center" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
							<div class="text-center">
								<button class="btn btn-login" type="submit">LOG IN</button>
							</div>
							<div class="text-center">
								<a href="{{url('/forgot')}}" class="link-forgot-password">I forgot my password</a>  or 
								<a href="{{url('/register')}}" class="link-forgot-password">Sign Up</a>
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