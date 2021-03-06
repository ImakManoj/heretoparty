@extends('SuperAdmin.layouts.app')
@section('title', 'Degination')
@include('SuperAdmin.default.header')
@include('SuperAdmin.default.sidebar')
@section('content')
<div class="main-panel">
  <div class="content">
  		<div class="page-inner">
      <h4 class="page-title">About Us</h4>
      	 <div class="card">
      	 		<div class="card-body">
      	 		<form action="{{route('savedegination')}}" method="POST">
      	 			@csrf
      	 			<div class="row">
                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="card-title">Degination</div>
                                                <input type="text" name="degination" id="degination" placeholder="Enter Degination" class="form-control">
                                          </div>
                                    </div>
                                    <input type="hidden" name="deginationid" id="deginationid">
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
      					<th>Degination</th>
      					<th>Action</th>
      				</tr>
      			</thead>
      			<tbody>
                           @foreach($response as $ft)
                              <tr>
                                   <td>{{$ft->id}}</td> 
                                   <td>{{$ft->deginatin_name}}</td>
                                   <td><span class="btn btn-danger sm-btn" onclick="Editdegination({{$ft->id}})" style="color: white">Edit</td>
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
      $.post('{{route("saveHowitworkedHeadingTitle")}}',parmt).then(function(response){
            alert('Save Heading Title');
      })
      }
</script>

<script type="text/javascript">
      function Editdegination(id){
            const parmt={
                  id:id,
                  _token:"{{csrf_token()}}",
            }
            $.post('{{route("editdegination")}}',parmt).then(function(response){
                  var obj=JSON.parse(response);
                  $('#degination').val(obj.deginatin_name);
                  $('#deginationid').val(obj.id);
            })
      }
</script>
@include('SuperAdmin.default.footer')
@endsection