@extends('SuperAdmin.layouts.app')
@section('title', 'HOW IT WORKS')
@include('SuperAdmin.default.header')
@include('SuperAdmin.default.sidebar')
@section('content')
<div class="main-panel">
	<div class="content">
		<div class="page-inner">
			@if ($message = Session::get('success'))
			<div class="alert alert-warning alert-block">
       <button type="button" class="close" data-dismiss="alert">×</button>	
       <strong>{{ $message }}</strong>
     </div>
     @endif

     <div class="page-header">
      <h4 class="page-title">How IT WORKS</h4> 
    </div>	
    <div class="row">
      <div class="col-md-3">
        <ul class="list-group">
          <li class="list-group-item" onclick="filter('Banner')" id="banner">Banner</li>
          <li class="list-group-item" onclick="filter('WeDoEverything')">We Do Everything</li>
          <li class="list-group-item" onclick="filter('SelectService')">Select Service</li>
          <li class="list-group-item" onclick="filter('ChooseProfessional')">Choose Professional</li>
          <li class="list-group-item" onclick="filter('BookService')">Book Service</li>

        </ul>
      </div>
      <div class="col-md-9">
     <section id="SelectItems">
      <form action="{{route('SubmitSelectServiceAbout')}}" method="post" enctype="multipart/form-data">
        <div class="row">
          @csrf
          <div class="col-md-12">
           <label>Service Name</label>
           <input type="text" name="serviceName" id="serviceName" placeholder="Service Name" class="form-control">
           <input type="hidden" name="serviceid" id="serviceid">
         </div>
         <div class="col-md-12"> 
          <label>Our Services</label>
          <textarea  name="OurServicesText" id="OurServicesText" placeholder="Our Services" class="form-control ckeditor"></textarea>
          <input type="hidden" name="OurServicePage" value="Our Services">
        </div>
        <div class="col-md-12">
          <label>Select Image</label>
          <input type="file" name="Services" id="Services" placeholder="Our Services" class="form-control">
        </div>
        <div class="col-md-12">
          <input type="submit" name="SaveOurService" id="SaveOurService" value="Save" class="btn btn-primary sm-btn pull-right">
        </div>
      </div>
    </form>
  </section>

  <div >
    <table class="table mt-3">
      <thead>
        <tr>
          <th>S.No.</th>
          <th style="width: 20%">Page Name</th>
          <th style="width: 50%">Content</th>
          <th>Images</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="displaydetails">

      </tbody>
    </table>
  </div>
</div>
</div>
</div>
</div>
</div>
<input type="hidden" name="storetyep" id="storetyep">
<style type="text/css">
  section{
    display:none;
  }
  #displaydetails{
    display:none;
  }
</style>

<script type="text/javascript">
  function filter(id){
   $('section').css('display','none');
   if(id!=''){
    if(id=='whatourclient'){
      $('#whatourclient').css('display','block');
    }
    $('#storetyep').val(id);
    GetDetails(id)
  }
}
</script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<style type="text/css">
  .btn-primary{
    margin-top: 1.3em;
  }
</style>
<script type="text/javascript">
  function GetDetails(id){
    const parmt={
      _token:'{{csrf_token()}}',
      id:id
    }
    $.post("{{route('Editabout')}}",parmt).then(function(response){
      $('#displaydetails').html(response);   
      $('#displaydetails').show(); 
    })
  }
</script>
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script>
  CKEDITOR.replace( 'ckeditor' );
</script>
<script type="text/javascript">
  function EditDetails(id){
    const parmt={
      values:id,
      _token:"{{csrf_token()}}",
    }
    $.post('{{route("EditFrontHome")}}',parmt).then(function(response){
      $('#serviceName').val(response[0].content_title);
           CKEDITOR.instances['OurServicesText'].setData(response[0].content_statument);
           $('#serviceid').val(response[0].content_id);
      $('#SelectItems').show();

    })

  }
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#banner').click();
  })
</script>
@include('SuperAdmin.default.footer')
@endsection