@extends('UserDashboard.Userslayouts.apps')
@section('title','Dashboard')
@section('content') 

            <div class="dashboard-content-wrap">

                <div class="dashboard-content-inner">
                    <div class="row-wrap row-mb-50">
                        <div class="d-title"> 
                            <h3>Dashboard</h3>
                        </div> 
                        <div class="counter-wrap">
                            <h3>Your party countdown!</h3>
                            <div id="timer" class="timer-wraper">
                                <div id="hours" class="count">
                                    <span class="count-number">00</span>  
                                    <span class="count-text">Months</span>
                                </div>
                                <div id="mins" class="count">
                                    <span class="count-number">00</span>
                                    <span class="count-text">Weeks</span>
                                </div>
                                <div id="seconds" class="count">
                                    <span class="count-number">00</span>
                                    <span class="count-text">Days</span>
                                </div>
                              </div>
                        </div>
                    </div>

                    <div class="row-wrap row-mb-50">

                        <div class="profile-box-wrap white-box-shadow">

                            <div class="d-title d-flex align-items-start justify-content-between">

                                <h3>Profile</h3>

                                <a href="{{route('userProfile')}}" class="btn btn-default  btn-capitalize ">Edit Profile</a>

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

  