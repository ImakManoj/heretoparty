@extends('SuperAdmin.layouts.app')
@section('title', 'Banner')
@include('SuperAdmin.default.header')
@include('SuperAdmin.default.sidebar')
@section('content')

<div class="main-panel">
  <div class="content">
  		<div class="page-inner">
      <h4 class="page-title">Banner</h4>
      	 <div class="card">
      	 		<div class="card-body">
      	 		<form action="{{route('saveBanner')}}" method="POST" enctype="multipart/form-data">
      	 			@csrf
      	 			<div class="row">
                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="card-title">Select Banner Type</div>
                                                <select class="form-control" name="bannertype" id="bannertype">
                                                      <option>Select Banner Type</option>
                                                      <option value="1">Home Page</option>
                                                      <option value="2">About Us</option>
                                                      <option  value="3">Careers</option>
                                                </select>
                                          </div>
                                    </div>
                                    <input type="hidden" name="bannerid" id="bannerid">
      	 				<div class="col-md-6">
      	 					<div class="form-group">
      	 						<div class="card-title">Title</div>
      	 						<input type="text" name="bannerTitile" id="bannerTitile" class="form-control" placeholder="Enter Banner Title">
      	 					</div>
      	 				</div>
      	 				<div class="col-md-6">
      	 					<div class="form-group">
      	 						<div class="card-title">Sub Title</div>
      	 						<input type="text" name="bannersubTitile" id="bannersubTitile" class="form-control" placeholder="Enter Banner Sub Title">
      	 					</div>
      	 				</div>
      	 				<div class="col-md-6">
      	 					<div class="form-group">
      	 						<div class="card-title">Banner Image</div>
      	 						<input type="file" name="bannerImages" id="bannerImages" class="form-control">
      	 					</div>
      	 				</div>
      	 				<div class="col-md-12">
      	 					<div class="form-group" style="text-align: right;">
      	 						<div class="card-title">&nbsp;</div>
      	 						<input type="submit" name="submit" class="btn btn-danger sm-btn" value="Submit" style="color: white">
      	 					</div>
      	 				</div>
      	 			</div>
      	 			</form>
      	 		</div>	
      </div>


      <div class="card">
      	<div class="card-body">
      		<div class="card-title">Banner Table</div>
      		<table class="table">
      			<thead>
      				<tr>
      					<th>Sl. No</th>
      					<th>Title</th>
      					<th>Sub-Title</th>
      					<th>Images</th>
      					<th>Action</th>
      				</tr>
      			</thead>
      			<tbody>
      				@foreach($response as $ft)
      				<tr>
      					<td>{{$ft->id}}</td>
      					<td>{{$ft->banner_title}}</td>
      					<td>{{$ft->banner_subtitle}}</td>
      					<td style="width: 10%"><img src="{{asset('images/'.$ft->banner_images)}}" style="width: 100%"></td>
      					<td><span class="btn btn-danger sm-btn" onclick="EditBanner({{$ft->id}})" style="color: white">Edit</td>
      				</tr>
      				@endforeach
      			</tbody>
      		</table>
      	</div>
      </div>
  </div>
  </div>
</div>
<script type="text/javascript">
      function EditBanner(id){
            const parmt={
                  id:id,
                  _token:"{{csrf_token()}}",
            }
            $.post('{{route("editBanner")}}',parmt).then(function(response){
                  var obj=JSON.parse(response);
                  $('#bannertype').val(obj.baner_type);
                  $('#bannerTitile').val(obj.banner_title);
                  $('#bannersubTitile').val(obj.banner_subtitle);
                  $('#bannerid').val(obj.id);
            })
      }
</script>

@include('SuperAdmin.default.footer')
@endsection