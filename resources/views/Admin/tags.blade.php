@extends('Admin.Userslayouts.apps')
@section('title','Tags')
@section('content')
 

 <div class="dashboard-content-wrap">
                <div class="dashboard-content-inner">

                <div class="white-box-shadow">
                      <div class="d-title">
                           <h3>Tags</h3>
                      </div>
			@if ($message = Session::get('success'))
			<div class="alert alert-warning alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>	
			<strong>{{ $message }}</strong>
			</div>
			@endif
		<span class="btn green-btn" style="float: right" data-toggle="modal" data-target="#myModal">Add Tags</span>
			
        <div class="row">
        <div class="col-sm-4">
          <div class="form-group">
            <label>Tag</label>
            <select name="Category" id="Category"  onchange="SearchCategory()" class="form-control">
              <option value="">Select Tag</option>
              @foreach($records  as $val)
                <option value="{{$val->id}}">{{$val->tag_name}}</option>
              @endforeach
            </select>
          </div>
        </div>
        
      </div>	

 
			<table  class="table mt-3 card" id="example">
						<tr>
							<th >Tags</th>

							<th style="text-align: right;">Action</th>
						</tr>	
				<tbody id="replacetable">
					@foreach($records as $ft)
					<tr id="removecagegory_{{$ft->id}}">
						
						<td>{{$ft->tag_name}}</td>
				
						<td style="text-align: right;"><span class="btn yellow-btn table-btn" onclick="EditCategory({{$ft->id}})" data-toggle="modal" data-target="#myModal">Update</span>
                            @if($ft->status==1)
                            <span class="btn green-btn table-bt" onclick="DeleteCategory({{$ft->id}},0)">Active</span>
                            @else
                             <span class="btn red-btn table-btn" onclick="DeleteCategory({{$ft->id}},1)">Inactive</span></td>
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
          <h4 class="modal-title">Add Tag</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        	<form action="{{route('addtags')}}" method="post" enctype="multipart/form-data">
          <div class="modal-body">
        		@csrf
        
         	<div class="form-group">
         		<label for="category">Enter Tag</label>
         		<input type="text" class="form-control" name="category" id="category" placeholder="Enter Tag name">
         	</div>
          <!-- <div class="form-group">
            <label for="category">Chose Image</label>
            <input type="file" class="form-control" name="images" id="images" placeholder="Enter Category name">
          </div> -->
         	<input type="hidden" name="category_id" id="category_id">
         	
         </div>
        <div class="modal-footer">

            <input type="submit" name="submit" value="Submit" class="btn red-btn table-btn">
         
          <button type="button" class="btn yellow-btn table-btn" data-dismiss="modal">Close</button>
        </div>
         </form>
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
    			$('#category').val(obj.cagetory_name);
    			$('#category_id').val(obj.cagetory_id);
    			//$('#myModal').modal('show');
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
    width: 100%;
    white-space: nowrap;
}
   </style>

@endsection