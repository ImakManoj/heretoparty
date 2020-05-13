@extends('VendorPanel.Userslayouts.apps')
@section('title','Change Password')
@section('content')


  <div class="dashboard-content-wrap"> 
                <div class="dashboard-content-inner"> 

                <div class="white-box-shadow">
                    <div class="row-wrap">
                        <div class="d-title ">
                            <h3>Change Password</h3>
                       </div>
    @if (Session::has('message'))
    <div id="registers" class="alert alert-success">{{ Session::get('message') }}</div>
    @endif

     @if (Session::has('error'))
    <div id="registers" class="alert alert-danger">{{ Session::get('error') }}</div>
    @endif

      <div class="row" >
        <div class="col-md-12">
          <div class="card card-with-nav">
          
            <div class="card-body">
             <form action="{{route('VendorChangePassword')}}" method="post" >
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
                <div class="text-right mt-3 mb-3">
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
          


@endsection