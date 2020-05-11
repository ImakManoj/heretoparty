@extends('SuperAdmin.layouts.app')

    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <title>Zennflo</title>
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
      <h3 class="text-center">Forgot Password</h3>
      <form action="{{route('forgetPass')}}" method="post">
        @csrf
      <div class="login-form">
        <div class="form-group form-floating-label">
          <input id="email" name="email" type="email" class="form-control input-border-bottom" required autocomplete="new-password">
          <label for="username" class="placeholder">Eamil</label>
        </div>
      
        <div class="row form-sub m-0">
          <div class="custom-control custom-checkbox">
<!--             <input type="checkbox" class="custom-control-input" id="rememberme">
            <label class="custom-control-label" for="rememberme">Remember Me</label> -->
          </div>
          
    
        </div>
        <div class="form-action mb-3">
          <button type="submit" class="btn btn-primary btn-rounded btn-login">Submit</button>
        </div>
        <div class="form-action mb-3">
            <a href="{{asset('admin')}}" class="link float-right">Click here for Login</a>
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