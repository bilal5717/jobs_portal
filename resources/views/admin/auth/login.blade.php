
<!DOCTYPE html>

<html lang="en">

	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title>Admin Login</title>
		<meta name="description" content="Login page example">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link href='{{asset('public/favicon.ico')}}' rel='shortcut icon' type='image/x-icon' />
		<!--begin::Fonts -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">

		<!--end::Fonts -->
		<link rel="stylesheet" href="{{asset('public/css/parsley.css')}}">
		<!--begin::Page Custom Styles(used by this page) -->
		<link href="{{asset('public/css/login-3.css')}}" rel="stylesheet" type="text/css" />

		<!--end::Page Custom Styles -->

		<!--begin::Global Theme Styles(used by all pages) -->
		<link href="{{asset('public/css/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('public/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />

		<!--end::Global Theme Styles -->

		<!--begin::Layout Skins(used by all pages) -->
		 <link href="{{asset('public/css/base/light.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('public/css/menu/light.css')}}" rel="stylesheet" type="text/css" />
		{{--<link href="assets/css/skins/brand/dark.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/skins/aside/dark.css" rel="stylesheet" type="text/css" /> --}}

		<!--end::Layout Skins -->
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">

		<!-- begin:: Page -->
		<div class="kt-grid kt-grid--ver kt-grid--root">
			<div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v3 kt-login--signin" id="kt_login">
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" style="background-image: url({{asset('public/media/bg/bg-3.jpg')}});">
					<div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
						<div class="kt-login__container">
							<div class="kt-login__logo">
								<a href="{{url('/app-admin')}}">
									<img src="{{asset('public/frontend/assets/images/logo.png')}}" class="login-logo" width="150px" />
								</a>
							</div>
							
							<div class="kt-login__signin">
								<div class="kt-login__head">
                                    <h3 class="kt-login__title">Sign In To Admin</h3>
                                   
                                </div>
                                
								<form id="form" data-parsley-validate class="kt-form" method="POST" action="{{ route('admin.login') }}">
                                    @csrf
                                    
									<div class="input-group">
										<input class="form-control" type="text" placeholder="Email" name="email" class="form-control @error('email') is-invalid @enderror"  value="{{ old('email') }}" required autocomplete="email" autofocus required autocomplete="email" autofocus data-parsley-trigger="change" data-parsley-type="email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert" style="display: block;">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        
                                    </div>
									<div class="input-group">
										<input class="form-control" type="password" placeholder="Password" name="password" required>
									</div>
									<div class="row kt-login__extra">
										<div class="col">
											<label class="kt-checkbox">
												<input type="checkbox" name="remember"> Remember me
												<span></span>
											</label>
										</div>
										{{-- <div class="col kt-align-right">
											<a href="javascript:;" id="kt_login_forgot" class="kt-login__link">Forget Password ?</a>
										</div> --}}
									</div>
									<div class="kt-login__actions">
										<button  type="submit" class="btn btn-brand btn-elevate kt-login__btn-primary">Sign In</button>
									</div>
								</form>
							</div>
							<div class="kt-login__signup">
								<div class="kt-login__head">
									<h3 class="kt-login__title">Sign Up</h3>
									<div class="kt-login__desc">Enter your details to create your account:</div>
								</div>
								<form class="kt-form" action="">
									<div class="input-group">
										<input class="form-control" type="text" placeholder="Fullname" name="fullname">
									</div>
									<div class="input-group">
										<input class="form-control" type="text" placeholder="Email" name="email" autocomplete="off">
									</div>
									<div class="input-group">
										<input class="form-control" type="password" placeholder="Password" name="password">
									</div>
									<div class="input-group">
										<input class="form-control" type="password" placeholder="Confirm Password" name="rpassword">
									</div>
									<div class="row kt-login__extra">
										<div class="col kt-align-left">
											<label class="kt-checkbox">
												<input type="checkbox" name="agree">I Agree the <a href="#" class="kt-link kt-login__link kt-font-bold">terms and conditions</a>.
												<span></span>
											</label>
											<span class="form-text text-muted"></span>
										</div>
									</div>
									<div class="kt-login__actions">
										<button id="kt_login_signup_submit" class="btn btn-brand btn-elevate kt-login__btn-primary">Sign Up</button>&nbsp;&nbsp;
										<button id="kt_login_signup_cancel" class="btn btn-light btn-elevate kt-login__btn-secondary">Cancel</button>
									</div>
								</form>
							</div>
							<div class="kt-login__forgot">
								<div class="kt-login__head">
									<h3 class="kt-login__title">Forgotten Password ?</h3>
									<div class="kt-login__desc">Enter your email to reset your password:</div>
								</div>
								<form class="kt-form" action="">
									<div class="input-group">
										<input class="form-control" type="text" placeholder="Email" name="email" id="kt_email" autocomplete="off">
									</div>
									<div class="kt-login__actions">
										<button id="kt_login_forgot_submit" class="btn btn-brand btn-elevate kt-login__btn-primary">Request</button>&nbsp;&nbsp;
										<button id="kt_login_forgot_cancel" class="btn btn-light btn-elevate kt-login__btn-secondary">Cancel</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


		<!-- end::Global Config -->

		<!--begin::Global Theme Bundle(used by all pages) -->
		<script src="{{asset('public/js/plugins.bundle.js')}}" type="text/javascript"></script>
		<script src="{{asset('public/js/scripts.bundle.js')}}" type="text/javascript"></script>

		<!--end::Global Theme Bundle -->

		<!--begin::Page Scripts(used by this page) -->
		<script src="{{asset('public/js/login-general.js')}}" type="text/javascript"></script>
		<script src="{{asset('public/js/parsley.min.js')}}"></script>
		<script>
			$('#form').parsley();
		</script>	
		<!--end::Page Scripts -->
	</body>

	<!-- end::Body -->
</html>