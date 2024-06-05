
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>H2O Environmental</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link rel="stylesheet" href="{{asset('public/css/parsley.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('public/frontend/assets/styles/custom.css')}}">
  </head>
  <body>

    <div class="flex-row account-wrap">
      <div class="flex-col half left">
        <div class="inner">
          <h2>WELCOME TO</h2>
          <h3>H2O Environmental Services</h3>
          <p>H2O Environmental Services Ltd have been trading since 2003 and we have grown continuously year on year.</p>
          <p>We pride ourselves on our professional approach which is backed up by our training commitment to our staff.</p>
        </div>
      </div>
      <div class="flex-col half right">
        <div class="inner">
          <div class="account-box">
          <a href="{{config('app.wp_url', '/')}}">
            	<img src="{{asset('public/frontend/assets/images/logo.png')}}" class="login-logo" />
          </a>
            <h2 class="caption">Reset<br>
            Password</h2>
            <div class="description">Email address is your account ID</div>
            <div class="clear40"></div>
            <form method="POST" action="{{ route('password.update') }}" id="form">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">
              <div class="input-wrap">
                <input type="email" name="email" placeholder="ACCOUNT ID / EMAIL" value="{{ $email ?? old('email') }}" required data-parsley-trigger="change" data-parsley-type="email"/>
                @error('email')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="input-wrap">
                <input type="password" placeholder="NEW PASSWORD" required name="password" data-parsley-maxlength="16" data-parsley-minlength="8" data-parsley-trigger="change" />
                @error('password')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
              </div>
              <div class="input-wrap">
                <input type="password" placeholder="CONFIRM PASSWORD" name="password_confirmation" required class="no-border" data-parsley-maxlength="16" data-parsley-minlength="8" data-parsley-trigger="change" />
              </div>
              <div class="text-center">
              <button class="btn btn-login" type="submit">RESET PASSWORD</button>
            </form>
            <a href="{{url('/login')}}" class="link-account">LOGIN</a>
            </div>
            <div class="text-center copyrights">© H2O Environmental Services Ltd., All rights reserved.<br>
            Web Design by <a href="https://eaglewebs.co.uk" target="_blank">Eagle Web Solutions</a>.</div>
          </div>
        </div>
      </div>
    </div>

    <script src="{{asset('public/plugins/jquery3.5.1/jquery.min.js')}}"></script>
	<script src="{{asset('public/js/bootstrap.bundle.min.js')}}" defer></script>
    <script src="{{asset('public/frontend/assets/scripts/custom.js')}}" defer></script>
    <script src="{{asset('public/js/parsley.min.js')}}"></script>
    <script>
        $('#form').parsley();
        
    </script> 
  </body>
</html>