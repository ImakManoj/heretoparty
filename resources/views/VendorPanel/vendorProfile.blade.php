@extends('VendorPanel.Userslayouts.apps')
@section('title','Profile')
@section('content')

            <div class="dashboard-content-wrap">
                <div class="dashboard-content-inner fc-50 ">
    
                    <div class="profile-box white-box-shadow">
                        <form action="{{route('updateProfile')}}" method="post"  enctype="multipart/form-data">
                        <div class="row-wrap row-mb-50">
                            <div class="d-title">
                                <h3>Profile</h3>
                            </div>

                        <div class="avatar-upload">
                            <div class="avatar-edit">
                                <input type='file' name="imageUpload" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                <label for="imageUpload"></label>
                            </div>
                            <div class="avatar-preview">
                            	@if(@$response->images=='')
                                <div id="imagePreview" style="background-image: url(http://i.pravatar.cc/500?img=7);"></div>
                                @else
                                <div id="imagePreview" style="background-image: url({{asset($response->images)}});"></div>
                                @endif
                            </div>
                        </div>
                        </div>
    					@csrf
                
                    <div class="row-wrap row row-mb-20">
                        <div class="col-md-6">
                            <div class="form-group">
                            <input type="text" name="first_name" class="form-control border icon-left user-icon" placeholder="First Name" value="{{@$response->first_name}}" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text"name="last_name"  class="form-control border icon-left user-icon" placeholder="Last Name" value="{{@$response->last_name}}" />
                            </div>
                        </div>


                        <div class="col-md-6"> 
                            <div class="form-group">
                                <input type="text" name="email" class="form-control border icon-left mail-icon" placeholder="Email" value="{{@$response->email}}" readonly="" />
                            </div>
                        </div>

                        <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="mobile" class="form-control border icon-left phone-icon" placeholder="Phone Number" value="{{@$response->mobile}}"/>
                                </div>
                        </div>

                        <div class="col-md-6"> 
                            <div class="form-group">
                                <select  class="form-control" name="country_name" placeholder="Country" onchange="getCity(this.value)" >
                                	<option value="">Select Country</option>
                                	@foreach($Country as $ft)
                               <option value="{{$ft->id}}" @if($ft->id==$response->country_id) {{'selected'}} @endif >{{$ft->country_name}}</option>
                                	@endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                                <div class="form-group"  id="getCity">
                                    <select class="form-control" name="city_name" placeholder="City" >
                                    	<option value="">Select City</option>
                                    	@foreach($city as $ft)
                                    		<option value="{{$ft->id}}" @if($ft->id==$response->city_id) {{'selected'}} @endif>{{$ft->city_name}}</option>
                                    	@endforeach
                                    </select>
                                </div>
                        </div>


                        </div>
                        <div class="row-wrap">
                            <div class="form-group button-outer">
                                <button class="btn btn-default btn-inherit btn-capitalize">Save</button>
                                <button class="btn btn-grey btn-inherit btn-capitalize">Cancel</button>
                            </div>
                        </div> 
                    </form>
                   </div>
                </div><!-- dashboard-content-inn  -->
            </div><!-- dashboard-content-wrap  -->
    
<script type="text/javascript">
	function getCity(id){
		const parmt={
			_token:"{{csrf_token()}}",
			id:id
		}
		$.post('{{route("getCity")}}',parmt).then(function(response){
			$('#getCity').html(response);
		})
	}

</script>
@endsection



