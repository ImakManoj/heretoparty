@extends('SuperAdmin.layouts.app')
@section('title', 'Clients')
@include('SuperAdmin.default.header')
@include('SuperAdmin.default.sidebar')
@section('content')
@php
use Illuminate\Support\Facades\Crypt;
@endphp
<link rel="stylesheet" type="text/css" href="{{asset('')}}/datepicker.css">
<div class="main-panel">
	<div class="content">
		<div class="page-inner">
		
		
			<div class="page-header">
						<h4 class="page-title">Clients </h4> 
			</div>	
			   <div class="row">
        <div class="col-sm-4">
          <div class="form-group">
            <label>Clients Name</label>
            <input type="text" name="name" placeholder="Search By Name" id="Clients"  class="form-control" onkeyup="UserSearch()">
          </div>
           </div>
           <div class="col-sm-4">
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="Search By Email" id="email" class="form-control" onkeyup="UserSearch()">
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            <label>Date</label>
            <input type="text" name="date" placeholder="Search By Date" id="date" class="form-control datepicker" onchange="UserSearch()" autocomplete="off" >
          </div>
        
          </div>
      </div>
			<table  class="table mt-3">
						<tr>
							
							<th scope="col">Name</th>
							<th scope="col">Email</th>
							<th scope="col">Date</th>
							 <th scope="col">Action</th>
						</tr>	
				<tbody id="replacetable">
					@foreach($users as $ft)
					<tr>
						
						<td>
              <div class="avatar">
                <img src="{{asset($ft->profile_images)}}" alt="..." class="avatar-img rounded-circle">
              </div>

              {{$ft->first_name}} {{$ft->last_name}}</td>
						<td>{{$ft->email}}</td>
						<td>{{date('d-m-Y',strtotime($ft->created_at))}}</td>
						<td> 	
                            @if($ft->status==1)
                            <span class="btn btn-success btn-sm" onclick="DeleteCategory({{$ft->id}},0)">Active</span>
                            @else
                             <span class="btn btn-danger btn-sm" onclick="DeleteCategory({{$ft->id}},1)">Suspend</span>
                             @endif
                             <a href="{{route('profileeditByadminClient',[Crypt::encryptString($ft->id)])}}"><span class="btn btn-danger btn-sm">Edit</span>
                              <span class="btn btn-danger btn-sm " onclick="Deleteusers(<?php echo $ft->id; ?>)">delete</span>

                             </td>
					</tr>

					@endforeach
				
				</tbody>
			</table>
				{{ @$users->links() }}
		</div>
	</div>
</div>
 <script type="text/javascript">
        function DeleteCategory(id,status){
            const parmt={
                id:id,
                _token:"{{csrf_token()}}",
                status:status
            }
            $.post("{{route('UserDeleteCategory')}}",parmt).then(function(response){
                location.reload();
            });
        }
    </script>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
  <script type="text/javascript">
  var dateToday = new Date();
  var dates = $('.datepicker').datepicker({

    
  });
</script>
    <script type="text/javascript">
  function UserSearch(){
    const parmt={
        name:$('#Clients').val(),
        email:$('#email').val(),
        date:$('#date').val(),
        _token:"{{csrf_token()}}"
    }

    $.post('{{route("UserSearch")}}',parmt).then(function(response){
      $('#replacetable').html(response);
    })
  }
</script>
<script type="text/javascript">
  function Deleteusers(id){
    const parmt={
      _token:'{{csrf_token()}}',
      id:id
    }
    $.post('{{route("Deleteusers")}}',parmt).then(function(msg){
      $('#remove_'+id).hide();
    })
  }
</script>
@include('SuperAdmin.default.footer')
@endsection