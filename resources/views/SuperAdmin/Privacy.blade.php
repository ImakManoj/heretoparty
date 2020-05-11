@extends('SuperAdmin.layouts.app')
@section('title', 'Privacy')
@include('SuperAdmin.default.header')
@include('SuperAdmin.default.sidebar')
@section('content')
<div class="main-panel">
	<div class="content">
		<div class="page-inner">
			@if (Session::has('message'))
  <div id="registers" class="alert alert-success">{{ Session::get('message') }}</div>
      @endif

     <div class="page-header">
      <h4 class="page-title">Privacy Policy</h4> 
    </div>	
    <div class="row">
     
      <div class="col-md-12">
     <section id="SelectItems">
      <form action="{{route('Updateprivicy')}}" method="post" enctype="multipart/form-data">
        <div class="row">
          @csrf
         <div class="col-md-12"> 
          <div class="form-group">
            <select name="dataselect" id="dataselect" class="form-control" onchange="GetPrivicyValue(this.value)" required="">
              <option value="">Select type</option>
              <option value="1">Personal Information Collection</option>
              <option value="2">Using Personal Information</option>
              <option value="3">Securing your data</option>
              <option value="4">Return Policy</option>
            </select>
          </div>
        </div>

         <div class="col-md-12"> 
          <label>Privacy Policy</label>
          <textarea  name="PrivacyPolicy" id="PrivacyPolicy" placeholder="Privacy Policy" class="form-control ckeditor" required=""></textarea>
        </div>
        <div class="col-md-12">
          <input type="submit" name="SaveOurService" id="SaveOurService" value="Save" class="btn btn-primary sm-btn pull-right">
        </div>
      </div>
    </form>
  </section>
 
  <div >
   
  </div>
</div>
</div>
</div>
</div>
</div>



<style type="text/css">
  .btn-primary{
    margin-top: 1.3em;
  }
</style>

<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script>
  CKEDITOR.replace( 'ckeditor' );
</script>

<script type="text/javascript">

  //CKEDITOR.instances['OurServicesText'].setData(response[0].content_statument);
</script>
<script type="text/javascript">
  function GetPrivicyValue(id){
    const parmt={
      id:id,
      _token:"{{csrf_token()}}"
    }
    $.post('{{route("PrivacyPolicy")}}',parmt).then(function(response){
      CKEDITOR.instances['PrivacyPolicy'].setData(response[0].content);
    })
  }
</script>
@include('SuperAdmin.default.footer')
@endsection