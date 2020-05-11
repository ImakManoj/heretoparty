@extends('SuperAdmin.layouts.app')
@section('title', 'Message')
@include('SuperAdmin.default.header')
@include('SuperAdmin.default.sidebar')
@section('content')
<div class="main-panel">
	<div class="content">
		<div class="page-inner">


			<div class="page-header">
				<h4 class="page-title">Message </h4> 
			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label>Search By Name</label>
						<input type="text" name="search" id="search" class="form-control" placeholder="Search By Name" onkeyup="SearchMessageByName()">
					</div>
				</div>
			</div>	
			<div class="page-inner row">

				<div class="col-md-3" id="Scrolls">
					<h3>User List</h3>
					<ul class="list-group" id="replaceli">
						@foreach($records as $ft)
						<li class="list-group-item list" onclick="GetMesssage({{$ft->id}})">
							<div class="avatar">
								<img src="{{asset($ft->profile_images)}}" alt="..." class="avatar-img rounded-circle">
							</div>

							{{$ft->first_name}} {{$ft->last_name}}</li>
						@endforeach
					</ul>	
				</div>	
				<div class="col-md-9">
					<div class="Message" id="Message">
					</div>
					<div class="row">
						<div class="col-md-11">
							<div class="form-group">
								<input type="text" name="sendmessage" id="sendmessage" placeholder="Send Message" class="form-control">
							</div>
						</div>
						<div class="col-md-1">
							<input type="submit" class="btn btn-danger btn-sm" value="Send" onclick="Sendmessagetousers()" >
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
<input type="hidden" name="shiftusersValue" id="shiftusersValue">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
	$(".list").on("click",function(){
		$(".list-group  li").removeClass("active");
		$(this).addClass("active");
	});
</script>
<style type="text/css">
	#trainers{
		background: antiquewhite;
		font-weight: bold;
		font-size: 17px;
		font-family: -webkit-body;
	}
</style>
<script type="text/javascript">
	function GetMesssage(id){
		var Message="";
		const parmt={
			_token:"{{csrf_token()}}",
			id:id
		}
		$('#shiftusersValue').val(id);
		$.post('{{route("ProfinanalMessage")}}',parmt).then(function(response){
			var obj=JSON.parse(response);
			for(var i=0;i<obj.length;i++){
				console.log(obj[i].message_Type);
				if(obj[i].sendby=='Admin'){
					Message+='<div class="trainer"><div class="trainersStryle"><h6>'+obj[i].ClientName+'</h6><p>'+obj[i].messages+'</p></div></div>';
				}else{
					Message+='<div class="users"><div class="UserStryle"><div class="avatar"><img src="'+obj[i].profile_images+'" alt="..." class="avatar-img rounded-circle"></div><h6>'+obj[i].Professioal+'</h6><p>'+obj[i].messages+'</p></span></div></div>';
				}
			}
			$('#Message').html(Message);
		})
	}
</script>
<style type="text/css">
	.trainer {
		border: 1px solid royalblue;
		margin: 0.5em;
		padding: 1em;
		padding-bottom: 0;
		display: inline-block;
		width: 100%;
		background-color: cornsilk;
		border-radius: 21px;
	}
	.trainersStryle>h6 {
		font-weight: bold;
		font-size: 13px;
		display: inline-block;
		float: left;
	}
	.trainersStryle>p {
		display: inline-block;
		padding-left: 2em;
		/* float: right; */
		margin-top: -4px;
		font-size: 13px;
		font-family: air;
	}
	.users {
		border: 1px solid royalblue;
		margin: 0.5em;
		padding: 1em;
		padding-bottom: 0;
		display: inline-block;
		width: 100%;
		border-radius: 2px so;
		background: aliceblue;
		border-radius: 21px;
	}
	.UserStryle>h6 {
		font-weight: bold;
		font-size: 13px;
		display: inline-block;
		float: right;
	}
	.UserStryle>p {
		display: inline-block;
		padding-right: 2em;
		float: right;
		margin-top: -4px;
		font-size: 13px;
		font-family: air;
		display: inline-block;
		float: right;
	}
	#Message{
		height: 500px;
		/* overflow-y: auto; */
		overflow-y: scroll;
		overflow-x: hidden;
	}
</style>
<script type="text/javascript">
	function SearchMessageByName(){
		const parmt={
			name:$('#search').val(),
			_token:"{{csrf_token()}}"
		}
		$.post("{{route('SearchMessageByName')}}",parmt).then(function(response){
			$('#replaceli').html(response);
		})
	}
</script>
<style type="text/css">
	#Scrolls{
		height: 500px;
		overflow-y:auto; 
	}
</style>
<style type="text/css">
	.btn-danger{
		margin: 15px;
		margin-left: -3em;
	}
</style>
<script type="text/javascript">
	function  Sendmessagetousers(){
		if($('#shiftusersValue').val()==''){
			alert('Please Select users');
			return false;
		}
		const parmt={
			userid:$('#shiftusersValue').val(),
			message:$('#sendmessage').val(),
			_token:"{{csrf_token()}}"
		}
		$.post('{{route("sendmessage")}}',parmt).then(function(response){
			console.log(response);
		})
	}

</script>
@include('SuperAdmin.default.footer')
@endsection