@extends('SuperAdmin.layouts.app')
@section('title', 'Category')
@include('SuperAdmin.default.header')
@include('SuperAdmin.default.sidebar')
@section('content')
<div class="main-panel">
	<div class="content">
		<div class="page-inner">
			@if ($message = Session::get('success'))
			<div class="alert alert-warning alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>	
			<strong>{{ $message }}</strong>
			</div>
			@endif
		<span class="btn btn-primary btn-sm" style="float: right" data-toggle="modal" data-target="#myModal">Add Categroy</span>
			<div class="page-header">
						<h4 class="page-title">Category</h4> 
			</div>
        <div class="row">
        <div class="col-sm-4">
          <div class="form-group">
            <label>Category</label>
            <select name="Category" id="Category"  onchange="SearchCategory()" class="form-control">
              <option value="">Select Category</option>
              @foreach($records  as $val)
                <option value="{{$val->cagetory_id}}">{{$val->cagetory_name}}</option>
              @endforeach
            </select>
          </div>
        </div>
        
      </div>	
			<table  class="table mt-3 card" id="example">
						<tr>
							<th scope="col">Category</th>
							<th scope="col">Date</th>
							<th scope="col">Action</th>
						</tr>	
				<tbody id="replacetable">
					@foreach($records as $ft)
					<tr id="removecagegory_{{$ft->id}}">
						
						<td>{{$ft->category_name}}</td>
						<td>{{date('d-m-Y',strtotime($ft->created_at))}}</td>
						<td><span class="btn btn-info btn-sm" onclick="EditCategory({{$ft->id}})" data-toggle="modal" data-target="#myModal">Update</span>
                            @if($ft->status==1)
                            <span class="btn btn-success btn-sm" onclick="DeleteCategory({{$ft->id}},0)">Active</span>
                            @else
                             <span class="btn btn-danger btn-sm" onclick="DeleteCategory({{$ft->id}},1)">Inactive</span></td>
                            @endif
					</tr>

					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>




<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add Category</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
        	<form action="{{route('addcategories')}}" method="post" enctype="multipart/form-data">
        		@csrf
         <div class="form-control">
         	<div class="form-group">
         		<label for="category">Enter Category</label>
         		<input type="text" class="form-control" name="category" id="category" placeholder="Enter Category name">
         	</div>
          <!-- <div class="form-group">
            <label for="category">Chose Image</label>
            <input type="file" class="form-control" name="images" id="images" placeholder="Enter Category name">
          </div> -->
         	<input type="hidden" name="category_id" id="category_id">
         	<div class="form-group" style="text-align: right;"> 
         		<input type="submit" name="submit" value="Submit" class="btn btn-primary btn-sm">
         	</div>
         </div>
         </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>

    <script type="text/javascript">
    	function EditCategory(id){
    		const parmt={
    			id:id,
    			_token:"{{csrf_token()}}"
    		}
    		$.post("{{route('GetCatById')}}",parmt).then(function(response){
    			console.log(response);
    			var obj=JSON.parse(response);
    			$('#category').val(obj.category_name);
    			$('#category_id').val(obj.id);
    		});
    	}
    </script>
    <script type="text/javascript">
        function DeleteCategory(id,status){
            const parmt={
                id:id,
                _token:"{{csrf_token()}}",
                status:status
            }
            $.post("{{route('DeleteCategory')}}",parmt).then(function(response){
                location.reload();
            });
        }
    </script>
    <script type="text/javascript">
      function SearchCategory(){
        const parmt={
          Category:$('#Category').val(),
          _token:"{{csrf_token()}}",
        }
        
        $.post('{{route("SearchCategory")}}',parmt).then(function(response){
          $('#replacetable').html(response);
        })
      }
    </script>


   <style type="text/css">
     .btn{
      color:white !important;
     }
       td, th {
    width: 47%;
    white-space: nowrap;
    text-align: left;
}
   </style>
@include('SuperAdmin.default.footer')
@endsection