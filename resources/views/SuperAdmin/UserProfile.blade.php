@extends('SuperAdmin.layouts.app')
@section('title', 'Profile')
@include('SuperAdmin.default.header')
@include('SuperAdmin.default.sidebar')
@section('content')
@php
use Illuminate\Support\Facades\Crypt;
@endphp
<div class="main-panel">
  <div class="content">
    @if (Session::has('message'))
    <div id="registers" class="alert alert-success">{{ Session::get('message') }}</div>
    @endif
    <div class="page-inner">
      <h4 class="page-title">Profile</h4>
      <div class="row">
        <div class="col-md-8">
          <div class="card card-with-nav">
            <div class="card-header">
              <div class="row row-nav-line">
                <ul class="nav nav-tabs nav-line nav-color-secondary" role="tablist">
                  <li class="nav-item"> <a class="nav-link active show"  href="{{route('profileeditByadmin',[Crypt::encryptString($Profile->id)])}}" >Professional</a> </li>
                  <li class="nav-item"> <a class="nav-link"  href="{{route('CompamyProfile',[Crypt::encryptString($Profile->id)])}}" >Company</a> </li>
                </ul>
              </div>
            </div>
            <div class="card-body">
             <form action="{{route('UserProfileResetByAdmin')}}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="row mt-3">
                <div class="col-md-6">
                  <div class="form-group form-group-default">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Name" value="{{@$Profile->first_name}} {{@$Profile->last_name}}">
                  </div>
                </div>
                <input type="hidden" name="userids" id="userids" value="{{@$Profile->id}}">
                <div class="col-md-6">
                  <div class="form-group form-group-default">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Name" value="{{@$Profile->email}}" readonly="">
                  </div>
                </div>
              </div>
              <div class="row mt-3">
                    <!-- <div class="col-md-4">
                      <div class="form-group form-group-default">
                        <label>Birth Date</label>
                        <input type="text" class="form-control" id="datepicker" name="datepicker" value="03/21/1998" placeholder="Birth Date">
                      </div>
                    </div> -->
                    <!-- <div class="col-md-4">
                      <div class="form-group form-group-default">
                        <label>Gender</label>
                        <select class="form-control" id="gender">
                          <option>Male</option>
                          <option>Female</option>
                        </select>
                      </div>
                    </div> -->
                    <div class="col-md-4">
                      <div class="form-group form-group-default">
                        <label>Phone</label>
                        <input type="text" class="form-control" name="phone" placeholder="Phone" value="{{@$Profile->contact}}">
                      </div>
                    </div>
                  </div>
                  <div class="row mt-3">
                    <div class="col-md-12">
                      <div class="form-group form-group-default">
                        <label>Address</label>
                        <input type="text" class="form-control" value="{{@$Profile->address}}"  id="address" name="address" placeholder="Address">
                        <input type="file" name="GetImages" id="GetImages" style="display: none;"  onchange="loadFile(event)">
                      </div>
                    </div>
                  </div>
                  
                  <div class="text-right mt-3 mb-3">
                    <button class="btn btn-success">Save</button>
                    <button class="btn btn-danger" onclick="location.reload();">Reset</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card card-profile card-secondary">
              <div class="card-header" style="background-image: url('assets/img/blogpost.jpg')">
                <div class="profile-picture">
                  <div class="avatar avatar-xl">
                    <img src="{{asset(@$Profile->profile_images)}}" alt="..." class="avatar-img rounded-circle" id="output">
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="user-profile text-center">
                  <div class="name">{{@$Profile->name}}</div>
                  
                  <div class="social-media">
                    <a class="btn btn-info btn-twitter btn-sm btn-link" href="#"> 
                      <span class="btn-label just-icon"><i class="flaticon-twitter"></i> </span>
                    </a>
                    <a class="btn btn-danger btn-sm btn-link" rel="publisher" href="#"> 
                      <span class="btn-label just-icon"><i class="flaticon-google-plus"></i> </span> 
                    </a>
                    <a class="btn btn-primary btn-sm btn-link" rel="publisher" href="#"> 
                      <span class="btn-label just-icon"><i class="flaticon-facebook"></i> </span> 
                    </a>
                    <a class="btn btn-danger btn-sm btn-link" rel="publisher" href="#"> 
                      <span class="btn-label just-icon"><i class="flaticon-dribbble"></i> </span> 
                    </a>
                  </div>
                  <div class="view-profile">
                    <a href="#" class="btn btn-secondary btn-block" onclick="GetImages()">Choose Image</a>
                  </div>
                </div>
              </div>
                <!-- <div class="card-footer">
                  <div class="row user-stats text-center">
                    <div class="col">
                      <div class="number">125</div>
                      <div class="title">Post</div>
                    </div>
                    <div class="col">
                      <div class="number">25K</div>
                      <div class="title">Followers</div>
                    </div>
                    <div class="col">
                      <div class="number">134</div>
                      <div class="title">Following</div>
                    </div>
                  </div>
                </div> -->
              </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>
    <script type="text/javascript">
      function GetImages(){
        $('#GetImages').click();
      }

    </script>

    <script type="text/javascript">
      
      var loadFile = function(event) {
        var output = document.getElementById('output');
        var data =  URL.createObjectURL(event.target.files[0])
        document.getElementById("output").src = data;
    //output.style.backgroundImage = "url('"+data+"')";
  };
</script>
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
@include('SuperAdmin.default.footer')
@endsection