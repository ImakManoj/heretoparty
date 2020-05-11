@extends('SuperAdmin.layouts.app')
@section('title', 'Contact Us')
@include('SuperAdmin.default.header')
@include('SuperAdmin.default.sidebar')
@section('content')
<div class="main-panel">
  <div class="content">
    <div class="page-inner">
      @if ($message = Session::get('message'))
      <div class="alert alert-warning alert-block">
       <button type="button" class="close" data-dismiss="alert">×</button>  
       <strong>{{ $message }}</strong>
     </div>
     @endif
     @if ($error = Session::get('error'))
     <div class="alert alert-danger alert-block">
       <button type="button" class="close" data-dismiss="alert">×</button>  
       <strong>{{ $error }}</strong>
     </div>
     @endif

     <div class="page-header">
      <h4 class="page-title">Contact Us</h4> 
    </div>  
    <div class="row">


      <div class="col-md-12">
        <section id="SelectItems">
          <form action="{{route('ContactUs')}}" method="post">
            <div class="row">
              @csrf
              
              <div class="col-md-12"> 
                <textarea  name="OurServicesText" id="OurServicesText" placeholder="Our Services" class="form-control ckeditor" placeholder="Enter Content">

                  {!!$records->diffination!!}
                </textarea>
                <input type="hidden" name="OurServicePage" value="Our Services">
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <input type="text" name="address" class="form-control address" id="address" placeholder="Enter Address" value="{{$records->address}}">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input type="text" name="mobileno" class="form-control" id="mobileno" placeholder="Enter Mobile number" value="{{$records->mobile}}">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email" value="{{$records->email}}">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label>Get In Touch Enquiry Email</label>
                  <input type="email" name="GetInTouchemail" class="form-control" id="GetInTouchemail" placeholder="Enter Email" value="{{$records->email}}">
                </div>
              </div>
              <div class="col-md-12">
                <input type="submit" name="SaveOurService" id="SaveOurService" value="Save" class="btn btn-primary sm-btn pull-right">
              </div>
            </div>
          </form>
        </section>      
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


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>





<script>
  function initMap() {
    var input = document.getElementById('address');

    var autocomplete = new google.maps.places.Autocomplete(input);

    autocomplete.addListener('place_changed', function() {
      var place = autocomplete.getPlace();
      document.getElementById('location-snap').innerHTML = place.formatted_address;
      document.getElementById('lat-span').innerHTML = place.geometry.location.lat();
      document.getElementById('lon-span').innerHTML = place.geometry.location.lng();
    });
  }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDvfEqpmOi0qt1j9Oq1LHIDNNkMRclKrWg&libraries=places&callback=initMap" async defer></script>
<style type="text/css">
  li{
    cursor: pointer;
  }
</style>
@include('SuperAdmin.default.footer')
@endsection