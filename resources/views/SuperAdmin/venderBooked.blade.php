@extends('SuperAdmin.layouts.app')
@section('title', 'Vendor Recently Booked')
@include('SuperAdmin.default.header')
@include('SuperAdmin.default.sidebar')
@section('content')
<div class="main-panel">
  <div class="content">
  		<div class="page-inner">
      <h4 class="page-title">Vendor Recently Booked</h4>
      <div class="card">
            <div class="card-body">
      <div class="row">
            <div class="col-md-10">
            <textarea class="form-control" name="title" id="title" placeholder="Enter Heading">{{$heading->vendorbook_name}}</textarea>
            </div>
            <div class="col-md-2">
                  <span class="btn btn-danger sm-btn" style="color: white" onclick="saveHeadingTitle()">Save</span>
            </div>
            </div>
      </div>
      </div>
      	 <div class="card">
      	 		<div class="card-body">
      	 		<form action="{{route('saveVendorBooked')}}" method="POST" enctype="multipart/form-data">
      	 			@csrf
      	 			<div class="row">
      	 				<div class="col-md-3">
      	 					<div class="form-group">
      	 						<div class="card-title">Name</div>
      	 						<input type="text" name="iwantname" id="iwantname" class="form-control" placeholder="Enter Name">
      	 					</div>
      	 				</div>
                                    <input type="hidden" name="vendorid" id="vendorid">
      	 				<div class="col-md-3">
      	 					<div class="form-group">
      	 						<div class="card-title">Country</div>
                                                <select name="country" id="country" class="form-control">
                                                      <option value="">Select Country</option>
                                                      @foreach($country as $ft)
                                                            <option value="{{$ft->id}}">{{$ft->country_name}}</option>
                                                      @endforeach
                                                </select>
      	 					</div>
      	 				</div>
      	 				<div class="col-md-2">
      	 					<div class="form-group">
      	 						<div class="card-title">Image</div>
      	 						<input type="file" name="images" id="images" class="form-control">
      	 					</div>
      	 				</div>
                                    <div class="col-md-2">
                                          <div class="form-group">
                                                <div class="card-title">Rank</div>
                                                <input type="number" name="Rank" class="form-control" id="rank" placeholder="Rank" min="0" max="5">
                                          </div>
                                    </div>
      	 				<div class="col-md-2">
      	 					<div class="form-group">
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
      		<div class="card-title">I Want To Plan </div>
      		<table class="table">
      			<thead>
      				<tr>
      					<th>Sl. No</th>
      					<th>Name</th>
      					<th>Country</th>
      					<th>Image</th>
      					<th>Action</th>
      				</tr>
      			</thead>
      			<tbody>
      				@foreach($response as $ft)
      				<tr>
      					<td>{{$ft->id}}</td>
      					<td>{{$ft->vendorbook_name}}</td>
      					<td>{{$ft->country_name}}</td>
      					<td style="width: 10%"><img src="{{asset('images/'.$ft->vendorbook_images)}}" style="width: 100%"></td>
      					<td><span class="btn btn-danger sm-btn" onclick="Editvendors({{$ft->vid}})" style="color: white">Edit</td>
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
      function saveHeadingTitle(){
      const parmt={
            title:$('#title').val(),
            _token:"{{csrf_token()}}"
      }
      $.post('{{route("saveHeadingTitle")}}',parmt).then(function(response){
            alert('Save Heading Title');
      })
      }
</script>

<script type="text/javascript">
      function Editvendors(id){
            const parmt={
                  id:id,
                  _token:"{{csrf_token()}}",
            }
            $.post('{{route("editvendors")}}',parmt).then(function(response){
                  console.log(response);
                  var obj=JSON.parse(response);
                  $('#iwantname').val(obj.vendorbook_name);
                  $('#country').val(obj.vendorbook_country);
                  $('#rank').val(obj.vendorbook_rating);
                  $('#vendorid').val(obj.id);
            })
      }
</script>
@include('SuperAdmin.default.footer')
@endsection