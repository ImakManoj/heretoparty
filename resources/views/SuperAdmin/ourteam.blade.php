@extends('SuperAdmin.layouts.app')
@section('title', 'Our Team')
@include('SuperAdmin.default.header')
@include('SuperAdmin.default.sidebar')
@section('content')
<div class="main-panel">
  <div class="content">
  		<div class="page-inner">
      <h4 class="page-title">Our Team</h4>
      	 <div class="card">
      	 		<div class="card-body">
      	 		<form action="{{route('savedOurTeam')}}" method="POST"  enctype="multipart/form-data">
      	 			@csrf
      	 			<div class="row">
                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="card-title">Name</div>
                                                <input type="text" name="name" id="name" placeholder="Enter name" class="form-control">
                                          </div>
                                    </div>
                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="card-title">Degination</div>
                                                <select name="degination" id="degination" class="form-control"> 
                                                  <option value="">Select Degination</option>
                                                  @foreach($response as $ft)
                                                    <option value="{{$ft->id}}">{{$ft->deginatin_name}}</option>
                                                  @endforeach
                                                </select>
                                          
                                          </div>
                                           </div>
                                           <div class="col-md-6">
                                          <div class="form-group">
                                            <div class="card-title">Image</div>
                                            <input type="file" name="images" id="images" class="form-control">
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
                <th>Name</th>
      					<th>Degination</th>
                <th>image</th>
      					<th>Action</th>
      				</tr>
      			</thead>
      			<tbody>
                     @foreach($outTeam as $ft)
                              <tr>
                                  <td>{{$ft->id}}</td>
                                   <td>{{$ft->team_name}}</td> 
                                   <td>{{$ft->RelationDetination->deginatin_name}}</td>
                                   <td style="width: 10%"><img src="{{asset('images/'.$ft->images)}}" style="width: 100%"></td>
                                   <td></td>
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
@include('SuperAdmin.default.footer')
@endsection