@extends('SuperAdmin.layouts.app')
@section('title', 'How it works')
@include('SuperAdmin.default.header')
@include('SuperAdmin.default.sidebar')
@section('content')
<div class="main-panel">
  <div class="content">
  		<div class="page-inner">
      <h4 class="page-title">How it works</h4>
      <div class="card">
            <div class="card-body">
      <div class="row">
            <div class="col-md-10">
            <textarea class="form-control" name="title" id="title" placeholder="Enter Heading">{{@$heading->howitwork_statement}}</textarea>
            </div>
            <div class="col-md-2">
                  <span class="btn btn-danger sm-btn" style="color: white" onclick="saveHeadingTitle()">Save</span>
            </div>
            </div>
      </div>
      </div>
      	 <div class="card">
      	 		<div class="card-body">
      	 		<form action="{{route('savehowitworks')}}" method="POST" enctype="multipart/form-data">
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
      	 						<div class="card-title">Content</div>
                                                <input type="text" name="content" id="content" class="form-control" placeholder="Enter Content">
      	 					</div>
                                          <input type="hidden" name="howitworkid" id="howitworkid">
      	 				</div>
      	 				<div class="col-md-2">
      	 					<div class="form-group">
      	 						<div class="card-title">Icon</div>
      	 						<input type="file" name="images" id="images" class="form-control">
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
      					<th>Content</th>
      					<th>Image</th>
      					<th>Action</th>
      				</tr>
      			</thead>
      			<tbody>
                              @if(!$response->isEmpty())
      				@foreach($response as $ft)
      				<tr>
      					<td>{{$ft->id}}</td>
      					<td>{{$ft->howitwork_name}}</td>
      					<td>{{$ft->howitwork_statement}}</td>
      					<td style="width: 10%"><img src="{{asset('images/'.$ft->howitwork_icon)}}" style="width: 100%"></td>
      					<td><span class="btn btn-danger sm-btn" onclick="Edithowitworks({{$ft->id}})" style="color: white">Edit</td>
      				</tr>
      				@endforeach
                              @endif
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
      $.post('{{route("saveHowitworkedHeadingTitle")}}',parmt).then(function(response){
            alert('Save Heading Title');
      })
      }
</script>
<script type="text/javascript">
      function Edithowitworks(id){
            const parmt={
                  id:id,
                  _token:"{{csrf_token()}}",
            }
            $.post('{{route("edithowitworks")}}',parmt).then(function(response){
                  console.log(response);
                  var obj=JSON.parse(response);
                  $('#iwantname').val(obj.howitwork_name);
                  $('#content').val(obj.howitwork_statement);
                  $('#howitworkid').val(obj.id);
            })
      }
</script>
@include('SuperAdmin.default.footer')
@endsection