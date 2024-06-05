
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Jobs Portal | Register</title>
		<meta name="description" content="">
		<meta name="keywords" content="">
		<link href='{{asset('public/favicon.ico')}}' rel='shortcut icon' type='image/x-icon' />
		<link rel="stylesheet" href="{{asset('public/css/parsley.css')}}">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="{{asset('public/frontend/assets/styles/custom.css')}}">
		<link rel="stylesheet" href="{{asset('public/frontend/assets/styles/custom.css')}}">
		<link rel="stylesheet" href="{{asset('public/frontend/assets/styles/custom_style.css')}}">
    
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
						<h2 class="caption">Create a<br> new account</h2>
						<div class="clear40"></div>
						<form method="post" action="{{route('user.register')}}" id="form" autocomplete="off">
							@csrf
							<div class="input-wrap">
								<input type="text" placeholder="Name" name="name" required data-parsley-trigger="change" data-parsley-maxlength="15" value="{{old('name')}}" data-parsley-minlength="5" data-parsley-trigger="change" />
								@error('name')
								<span class="invalid-feedback   d-block text-center" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
							<div class="input-wrap">
								<input type="email" placeholder="Email Address" name="email" value="{{old('email')}}" required data-parsley-trigger="change" data-parsley-type="email"/>
								@error('email')
								<span class="invalid-feedback   d-block text-center" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
							<div class="input-wrap">
								<input type="password" required placeholder="Password" class="" name="password" data-parsley-maxlength="16" data-parsley-minlength="8" data-parsley-trigger="change" />
								@error('password')
								<span class="invalid-feedback   d-block text-center" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
							<div class="text-center">
								<button class="btn btn-login" type="submit">Register</button>
							</div>
						</form>
						<div class="text-center">
							<a href="{{url('/login')}}" class="link-account">ALREADY HAVE AN ACCOUNT?</a>
						</div>
					</div>
					<div class="text-center"><div class="text-center copyrights"> ©2020 copyright. </div></<div>
				</div>
			</div>
		</div>
		</div>

		<script src="{{asset('public/plugins/jquery3.5.1/jquery.min.js')}}"></script>
		<script src="{{asset('public/js/bootstrap.bundle.min.js')}}" defer></script>
		<script src="{{asset('public/js/parsley.min.js')}}"></script>
		<script>
			$('#form').parsley();
			
		</script> 
	</body>
</html>