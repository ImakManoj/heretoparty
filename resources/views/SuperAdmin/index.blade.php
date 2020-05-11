@extends('SuperAdmin.layouts.app')

    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <title>HERE TO PARTY </title>
    <link rel="icon" href="assets/img/icon.ico" type="image/x-icon"/>

    <!-- Fonts and icons -->
    <script src="{{URL::asset('AdminTemp')}}/assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Open+Sans:300,400,600,700"]},
            custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands"], urls: ['assets/css/fonts.css']},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="{{URL::asset('AdminTemp')}}/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{URL::asset('AdminTemp')}}/assets/css/azzara.min.css">
<body class="login">
@if ($message = Session::get('success'))
<div class="alert alert-warning alert-block">
<button type="button" class="close" data-dismiss="alert">×</button> 
<strong>{{ $message }}</strong>
</div>
@endif
  <div class="wrapper wrapper-login">
    <div class="container container-login animated fadeIn">
      <h3 class="text-center">Sign In To Admin</h3>
      <form action="{{route('admin')}}" method="post">
        @csrf
      <div class="login-form">
        <div class="form-group form-floating-label">
          <input id="username" name="username" type="email" class="form-control input-border-bottom" required autocomplete="new-password">
          <label for="username" class="placeholder">Email</label>
        </div>
        <div class="form-group form-floating-label">
          <input id="password" name="password" type="password" class="form-control input-border-bottom" required>
          <label for="password" class="placeholder">Password</label>
          <div class="show-password">
            <i class="flaticon-interface"></i>
          </div>
        </div>
        <div class="row form-sub m-0">
          <div class="custom-control custom-checkbox">
<!--             <input type="checkbox" class="custom-control-input" id="rememberme">
            <label class="custom-control-label" for="rememberme">Remember Me</label> -->
          </div>
          
          <a href="{{route('forgorpassword')}}" class="link float-right">Forget Password ?</a>
        </div>
        <div class="form-action mb-3">
          <button type="submit" class="btn btn-primary btn-rounded btn-login">Sign In</button>
        </div>
     
      </div>
      </form>
    </div>

    <div class="container container-signup animated fadeIn">
      <h3 class="text-center">Sign Up</h3>
      <form action="{{route('adinReg')}}" method="post">
        @csrf
      <div class="login-form">
        <div class="form-group form-floating-label">
          <input  id="fullname" name="fullname" type="text" class="form-control input-border-bottom" required>
          <label for="fullname" class="placeholder">Fullname</label>
        </div>
        <div class="form-group form-floating-label">
          <input  id="email" name="email" type="email" class="form-control input-border-bottom" required>
          <label for="email" class="placeholder">Email</label>
        </div>
        <div class="form-group form-floating-label">
          <input  id="passwordsignin" name="passwordsignin" type="password" class="form-control input-border-bottom" required>
          <label for="passwordsignin" class="placeholder">Password</label>
          <div class="show-password">
            <i class="flaticon-interface"></i>
          </div>
        </div>
        <div class="form-group form-floating-label">
          <input  id="confirmpassword" name="confirmpassword" type="password" class="form-control input-border-bottom" required>
          <label for="confirmpassword" class="placeholder">Confirm Password</label>
          <div class="show-password">
            <i class="flaticon-interface"></i>
          </div>
        </div>
        <div class="row form-sub m-0">
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="agree" id="agree">
            <label class="custom-control-label" for="agree">I Agree the terms and conditions.</label>
          </div>
        </div>
        <div class="form-action">
          <a href="#" id="show-signin" class="btn btn-danger btn-rounded btn-login mr-3">Cancel</a>
          <button type="submit" class="btn btn-primary btn-rounded btn-login">Sign Up</button>
        </div>
      </div>
      </form>
    </div>
  </div>

</body>
    <script src="{{URL::asset('AdminTemp')}}/assets/js/core/jquery.3.2.1.min.js"></script>
    <script src="{{URL::asset('AdminTemp')}}/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="{{URL::asset('AdminTemp')}}/assets/js/core/popper.min.js"></script>
    <script src="{{URL::asset('AdminTemp')}}/assets/js/core/bootstrap.min.js"></script>
    <script src="{{URL::asset('AdminTemp')}}/assets/js/ready.js"></script>