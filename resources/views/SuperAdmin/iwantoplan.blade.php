@extends('SuperAdmin.layouts.app')
@section('title', 'I Want To Plan ')
@include('SuperAdmin.default.header')
@include('SuperAdmin.default.sidebar')
@section('content')
<div class="main-panel">
  <div class="content">
  		<div class="page-inner">
      <h4 class="page-title">I Want To Plan </h4>
      	 <div class="card">
      	 		<div class="card-body">
      	 		<form action="{{route('saveiwanttoplan')}}" method="POST" enctype="multipart/form-data">
      	 			@csrf
      	 			<div class="row">
      	 				<div class="col-md-4">
      	 					<div class="form-group">
      	 						<div class="card-title">Name</div>
      	 						<input type="text" name="iwantname" id="iwantname" class="form-control" placeholder="Enter Name">
      	 					</div>
      	 				</div>
      	 				<div class="col-md-4">
      	 					<div class="form-group">
      	 						<div class="card-title">Statement</div>
      	 						<input type="text" name="statement" id="statement" class="form-control" placeholder="Enter Statement">
      	 					</div>
      	 				</div>
                                    <input type="hidden" name="iwantmyplanid" id="iwantmyplanid">
      	 				<div class="col-md-2">
      	 					<div class="form-group">
      	 						<div class="card-title">Icon</div>
      	 						<input type="file" name="icon" id="icon" class="form-control">
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
      					<th>Statement</th>
      					<th>Icon</th>
      					<th>Action</th>
      				</tr>
      			</thead>
      			<tbody>
      				@foreach($response as $ft)
      				<tr>
      					<td>{{$ft->id}}</td>
      					<td>{{$ft->iwanttoplan_title}}</td>
      					<td>{{$ft->iwanttoplan_message}}</td>
      					<td style="width: 10%"><img src="{{asset('images/'.$ft->iwanttoplan_icon)}}" style="width: 100%"></td>
      					<td><span class="btn btn-danger sm-btn" onclick="Editiwantmyplan({{$ft->id}})" style="color: white">Edit</td>
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
      function Editiwantmyplan(id){
            const parmt={
                  id:id,
                  _token:"{{csrf_token()}}",
            }
            $.post('{{route("editiwantmyplan")}}',parmt).then(function(response){
                  var obj=JSON.parse(response);
                  $('#iwantname').val(obj.iwanttoplan_title);
                  $('#statement').val(obj.iwanttoplan_message);
                  $('#iwantmyplanid').val(obj.id);
            })
      }
</script>
@include('SuperAdmin.default.footer')
@endsection