@extends('SuperAdmin.layouts.app')
@section('title', 'Service Tex')
@include('SuperAdmin.default.header')
@include('SuperAdmin.default.sidebar')
@section('content')

<div class="main-panel">
	<div class="content">
		<div class="page-inner">
				<div class="page-header">
						<h4 class="page-title">Service Tax</h4> 
				</div>
				<form action="{{route('saveServicetex')}}" method="post">
				<div class="row">
					@csrf
				<div class="col-md-4">
					<div class="form-group"> 
						<input type="text" name="servicetex" id="servicetex" class="form-control" placeholder="Enter Service Tex" value="{{@$records->tex}}">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group" >
						<input type="submit" name="serviceTex" value="Save" class="btn btn-success btn-sm"> 
					</div>
				</div>
			</div> 
			</form>
		</div>
	</div>
</div>

@include('SuperAdmin.default.footer')
@endsection