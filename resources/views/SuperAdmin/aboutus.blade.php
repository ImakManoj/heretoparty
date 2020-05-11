@extends('SuperAdmin.layouts.app')
@section('title', 'About Us')
@include('SuperAdmin.default.header')
@include('SuperAdmin.default.sidebar')
@section('content')
<div class="main-panel">
  <div class="content">
  		<div class="page-inner">
      <h4 class="page-title">About Us</h4>
      	 <div class="card">
      	 		<div class="card-body">
      	 		<form action="{{route('saveaboutus')}}" method="POST" enctype="multipart/form-data">
      	 			@csrf
      	 			<div class="row">
                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="card-title">Page Type</div>
                                                <select name="pagetype" id="pagetype" class="form-control" required="">
                                                      <option value="">Select page</option>
                                                      <option value="1">Landing Page</option>
                                                      <option value="2">About page</option>
                                                </select>
                                          </div>
                                    </div>
                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="card-title">Title</div>
                                                <textarea type="text" name="title" id="title" class="form-control" placeholder="Enter title"></textarea>
                                          </div>
                                    </div>
      	 				<div class="col-md-12">
      	 					<div class="form-group">
      	 						<div class="card-title">Content</div>
                                                <textarea type="text" name="content" id="content" class="form-control" placeholder="Enter Content"></textarea>
      	 					</div>
      	 				</div>
      	 				<div class="col-md-2">
      	 					<div class="form-group">
      	 						<div class="card-title">Image</div>
      	 						<input type="file" name="images" id="images" class="form-control">
      	 					</div>
      	 				</div>
                                    <div class="col-md-8 row">
                                          <div class="col-md-4">
                                          <ul class="list-group">
                                                <li class="list-group-item"><input type="checkbox" id="" name="todolist[]" value="To-Do List">To-Do List</li>

                                                <li class="list-group-item"><input type="checkbox" id="" name="todolist[]" value="Budget Tracker">Budget Tracker</li>
                                                <li class="list-group-item"><input type="checkbox" id="" name="todolist[]" value="Guest List">Guest List</li>
                                                <li class="list-group-item"><input type="checkbox" id="" name="todolist[]" value="Messaging">Messaging</li>
                                          </ul>
                                          </div>
                                          <div class="col-md-8">
                                                <ul class="list-group">
                                                <li class="list-group-item"><input type="checkbox" id="" name="todolist[]" value="Keep track of your events">Keep track of your events</li>
                                                <li class="list-group-item"><input type="checkbox" id="" name="todolist[]" value="Find appropriate vendors">Find appropriate vendors </li>
                                                <li class="list-group-item"><input type="checkbox" id="" name="todolist[]" value="Appointment reminders">Appointment reminders</li>
                                               
                                          </ul>
                                          </div>
                                    </div>
      	 				<div class="col-md-1">
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
      					<th style="width: 10%">Sl. No</th>
      					<th>Title</th>
                                    <th>page</th>
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
      					<td>{{$ft->about_title}}</td>
                                    <td><?php if($ft->page_type==1)echo 'Landing Page'; else echo 'About Page'; ?></td>
      					<td style="width: 50%">{{$ft->about_statement}}</td>
      					<td style="width: 10%"><img src="{{asset('images/'.$ft->about_image)}}" style="width: 100%"></td>
      					<td><span class="btn btn-danger sm-btn" onclick="Editaboutus({{$ft->id}})" style="color: white">Edit</td>
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
      function Editaboutus(id){
            const parmt={
                  id:id,
                  _token:"{{csrf_token()}}",
            }
            $.post('{{route("editaboutus")}}',parmt).then(function(response){
                  console.log(response);
                  // var obj=JSON.parse(response);
                  // $('#iwantname').val(obj.howitwork_name);
                  // $('#content').val(obj.howitwork_statement);
                  // $('#howitworkid').val(obj.id);
            })
      }
</script>
@include('SuperAdmin.default.footer')
@endsection