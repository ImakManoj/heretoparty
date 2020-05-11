@extends('SuperAdmin.layouts.app')
@section('title', 'Careers')
@include('SuperAdmin.default.header')
@include('SuperAdmin.default.sidebar')
@section('content')
<div class="main-panel">
  <div class="content">
  		<div class="page-inner">
      <h4 class="page-title">Careers</h4>
      	 <div class="card">
      	 		<div class="card-body">
      	 		<form action="{{route('savedCareers')}}" method="POST"  enctype="multipart/form-data">
      	 			@csrf
      	 			<div class="row">
                                    <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="card-title">Heading</div>
                                                <input type="text" name="heading" id="heading" placeholder="Enter Heading" class="form-control">
                                          </div>
                                    </div>
                                     <div class="col-md-6">
                                          <div class="form-group">
                                                <div class="card-title">Heading2</div>
                                                <input type="text" name="heading2" id="heading2" placeholder="Enter Heading" class="form-control">
                                          </div>
                                    </div>
                                  <div class="col-md-12">
                                            <div class="form-group">
                                              <div class="card-title">Content</div>
                                                <textarea type="text" name="content" id="content" class="form-control" placeholder="Enter Content"></textarea>
                                            </div>
                                          </div>
                                           <div class="col-md-6">
                                          <div class="form-group">
                                            <div class="card-title">Image</div>
                                            <input type="file" name="images" id="images" class="form-control">
                                          </div>
                                        </div>
                                   
      	 				<div class="col-md-6">
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
      		<div class="card-title">Careers </div>
      		<table class="table">
      			<thead>
      				<tr>
      					<th style="width: 10%">Sl. No</th>
                <th>Heading</th>
      					<th>Heading1</th>
                <th>Content</th>
                <th>image</th>
      					<th>Action</th>
      				</tr>
      			</thead>
      			<tbody>
                    @if(!$response->isEmpty())
              @foreach($response as $ft)
              <tr>
                <td>{{$ft->id}}</td>
                <td>{{$ft->career_title}}</td>
                <td>{{$ft->career_title1}}</td>
                              
                <td style="width: 50%">{{$ft->career_statement}}</td>
                <td style="width: 10%"><img src="{{asset('images/'.$ft->career_images)}}" style="width: 100%"></td>
                <td></td>
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
@include('SuperAdmin.default.footer')
@endsection