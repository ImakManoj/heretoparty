@extends('website.layouts.app')
@section('title','Careers')
@section('content')

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>



<!-- <div class="inner-banner" style="background-image: url('{{URL::asset('template')}}/images/inner-banner.jpg');">
  <div class="container">
    <div class="banner-inner">
      <h1>Forgot Password</h1>
    </div>
  </div>
</div> -->
@if (Session::has('message'))

  <div id="registers" class="alert alert-success">{{ Session::get('message') }}</div>
  <script type="text/javascript">
  	$(document).ready(function(){
  		setInterval(() => {
  			window.location.href="{{asset('')}}";
  		}, 2000);
  	})
  </script>

@endif

@if (Session::has('error'))

  <div id="registers" class="alert alert-danger">{{ Session::get('error') }}</div>
  <script type="text/javascript">
    $(document).ready(function(){
      setInterval(() => {
        window.location.href="{{asset('')}}";
      }, 2000);
    })
  </script>
@endif
<section class="section forgot-wrap">
<div class="container">
<form class="form" action="{{route('resetYourPassword')}}" method="post" onsubmit="return validation()">
  <div id="errorshow"></div>
	@csrf
  <div class="form-group">
    <label for="exampleInputEmail1">New Password</label>
    <input type="password" class="form-control" name="password" id="password" aria-describedby="emailHelp" minlength="8">
    
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Confirm Password</label>
    <input type="password" class="form-control" id="cpassword" name="cpassword" minlength="8">
  </div>
  <input type="hidden" name="email" id="email" value="{{$email}}">
  <input type="hidden" name="token" id="token" value="{{$token}}">
  <div class="button-wrap">
  <button type="submit" class="btn btn-black">Submit</button>
</div>
</form>
</div>
</section>
<script type="text/javascript">
  function validation(){
    if($('#password').val()!=$('#cpassword').val()){
       $('#errorshow').html('<span style="color:red">Password and Confirm Password does not match</span>');
        setTimeout(function(){ $('#errorshow').html(''); }, 2000);
      return false;
    }else{
      $('#errorshow').html(''); 
      return true;
    }
  }
</script>
<style type="text/css">
.forgot-wrap .form{
      max-width: 600px;
    margin: 0 auto;
    /* display: inline-block; */
    width: 100%;
    border: 1px solid #dbdcdc;
    padding: 50px;
}
.btn-primary {
    color: #fff;
    background-color: #0069d9;
    border-color: #0062cc;
}
.button-wrap{
  text-align: center;
}
</style>


@endsection