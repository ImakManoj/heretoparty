@extends('SuperAdmin.layouts.app')
@section('title', 'Change Password')
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

     @if (Session::has('error'))
    <div id="registers" class="alert alert-danger">{{ Session::get('error') }}</div>
    @endif
    <div class="page-inner">
      <h4 class="page-title">Change Password</h4>
      <div class="row" style="width:  40%;margin-left: 23em;">
        <div class="col-md-12">
          <div class="card card-with-nav">
            <div class="card-header">
              <div class="row row-nav-line">


              </div>
            </div>
            <div class="card-body">
             <form action="{{route('AdminChangePassword')}}" method="post" >
              @csrf
              <div class="row mt-3">
                <div class="col-md-12">
                  <div class="form-group form-group-default">
                    <label>Old Password</label>
                    <input type="password" class="form-control" name="old_password" placeholder="Old Password" required="">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group form-group-default">
                    <label>New Password</label>
                    <input type="password" class="form-control" name="new_password" placeholder="New Password" required>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group form-group-default">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required>
                  </div>
                </div>


                <div class="text-right mt-3 mb-3" style="margin-left: 9em">
                  <button class="btn btn-success">Save</button>
                  <button class="btn btn-danger" onclick="location.reload();">Reset</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        
      </div>
    </div>
  </div>

</div>

@include('SuperAdmin.default.footer')
@endsection