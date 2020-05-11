@extends('VendorPanel.Userslayouts.apps')
@section('title','Dashboard')

@section('content')
            <div class="dashboard-content-wrap">

                <div class="dashboard-content-inner">

                    <div class="row-wrap row-mb-50">

                        <div class="d-title"> 
 
                            <h3>Dashboard</h3>

                        </div>

                        <div class="dashboard-feature-wrap">

                            <div class="row">

                                <div class="col-md-4">

                                    <div class="m-feature-box voiet">

                                        <figure><img src="{{asset('heretoparty/dashboard')}}/images/d-m-feature-1.png" alt="d-m-feature-1.png" /></figure>

                                        <h3>{{$totalQuote}}</h3>

                                        <p>Total Quotes</p>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="m-feature-box blue">

                                        <figure><img src="{{asset('heretoparty/dashboard')}}/images/d-m-feature-2.png" alt="d-m-feature-2.png" /></figure>

                                        <h3>{{$files}}</h3>

                                        <p>Total Files</p>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="m-feature-box yellow">

                                        <figure><img src="{{asset('heretoparty/dashboard')}}/images/d-m-feature-3.png" alt="d-m-feature-3.png" /></figure>

                                        <h3>20</h3>

                                        <p>Total Events</p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="row-wrap row-mb-50">

                        <div class="profile-box-wrap white-box-shadow">

                            <div class="d-title d-flex align-items-start justify-content-between">

                                <h3>Profile</h3>

                                <a href="{{route('vendorProfile')}}" class="btn btn-default  btn-capitalize ">Edit Profile</a>

                            </div>  

                            <div class="row">

                                <div class="col-xl-10">

                                    <ul class="list-50">

                                        <li>First Name: {{$response->first_name}}</li>

                                        <li>Last Name: {{$response->last_name}}</li>

                                        <li>Phone Number: {{$response->mobile}}</li>

                                        <li>Email Address: {{$response->email}}</li>

                                        <li>Country: {{$response->country_name}} </li>

                                        <li>City: {{$response->city_name}}</li>

                                    </ul>

                                </div>

                            </div>

                            

                        </div>

                    </div>

                </div>

                <!-- dashboard-content-inn  -->

            </div>

            <!-- dashboard-content-wrap  -->

    

  @endsection