@extends('SuperAdmin.layouts.app')
@section('title', 'Services')
@include('SuperAdmin.default.header')
@include('SuperAdmin.default.sidebar')
@section('content')
<div class="main-panel">
	<div class="content">
		<div class="page-inner">
			@if ($message = Session::get('success'))
			<div class="alert alert-warning alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>	
			<strong><?php  echo  $message ; ?></strong>
			</div>
			@endif
		
			<div class="page-header">
						<h4 class="page-title">Services</h4> 
			</div>	
       <div class="row">
        <div class="col-sm-4">
          <div class="form-group">
            <label>Category</label>
            <select name="Category" id="Category"  onchange="SearchCategory()" class="form-control">
              <option value="">Select Category</option>
              @foreach($category as $val)
                <option value="<?php  echo $val->cagetory_id; ?>"><?php  echo $val->cagetory_name; ?></option>
              @endforeach
            </select>
          </div>
        </div>

         <div class="col-sm-8">
          <div class="form-group btns_rt" style="float: right;">
           
          </div>
        </div>
        
      </div>
			<table  class="table mt-3" id="example">
        <thead>
						<tr>
							<th scope="col">Category</th>
              <th scope="col">Services</th>
              <th scope="col">Time</th>
              <th scope="col">Price</th>
              <th scope="col">Created By</th>
              <th scope="col" style="width: 20%">Service Description</th>
							<th scope="col">Action</th>
						</tr>	
          </thead>
				<tbody id="replacetable">
					@foreach($Services as $ft)
					<tr id="replacetable_<?php  echo $ft->service_id; ?>">
						
						<td><?php  echo $ft->cagetory_name; ?></td>
            <td><?php  echo $ft->service_name; ?></td>
            <td><?php  echo $ft->service_hour; ?> <?php  echo $ft->service_minuts; ?></td>
            <td>$<?php  echo $ft->service_prince; ?></td>
            <td><?php  echo $ft->name; ?></td>
            <td><?php  echo $ft->service_description; ?></td>
						<td>
              @if($ft->service_status==1)
              <span class="btn btn-success btn-sm" onclick="ChangeStatus(<?php  echo $ft->service_id; ?>,0)">Active</span>
              @else
            <span class="btn btn-danger btn-sm" onclick="ChangeStatus(<?php  echo $ft->service_id; ?>,1)">Inactive</span>
            @endif
          </td>
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
        	<form action="<?php  echo route('addSubcategories'); ?>" method="post">
        		@csrf
         <div class="form-control">
            <div class="form-group">
                <label for="category">Enter Category</label>
               <select class="form-control" name="category" id="category" >
                   <option value="">Select Category</option>
                   @foreach($category as $ft)
                    <option value="<?php  echo $ft->cagetory_id; ?>"><?php  echo $ft->cagetory_name; ?></option>
                   @endforeach
               </select>
            </div>
         	<div class="form-group">
         		<label for="">Enter Sub-Category</label>
         		<input type="text" class="form-control" name="Sub_Category" id="Sub_Category" placeholder="Enter Sub-Category name">
         	</div>
                <div class="form-group">
                <label for="category">Enter Price</label>
                <input type="text" class="form-control" name="price" id="price" placeholder="Enter Price">
            </div>
         	<input type="hidden" name="subcategory_Id" id="subcategory_Id">
         	<div class="form-group">
         		<input type="submit" name="submit" value="Submuit" class="btn btn-primary btn-sm">
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
    			_token:"<?php  echo csrf_token(); ?>"
    		}
    		$.post("<?php  echo route('GetSubCatById'); ?>",parmt).then(function(response){
    			console.log(response);
    			var obj=JSON.parse(response);
    			$('#category').val(obj.subcategory_CategoryId);
                $('#Sub_Category').val(obj.subcategory_Name);
                $('#price').val(obj.subcategory_Price);
    			$('#subcategory_Id').val(obj.subcategory_Id);
    			$('#myModal').modal('show');
    		});
    	}
    </script>
<script type="text/javascript">
  function SearchCategory(){
    const parmt={
      Category:$('#Category').val(),
      Service:$('#Service').val(),
      _token:"<?php  echo csrf_token(); ?>"
    }
    $.post('<?php  echo route("SearchServices"); ?>',parmt).then(function(response){

      $('#replacetable').html(response);
    })
  }
</script>
<script type="text/javascript">
  function ChangeStatus(id,status){
    const parmt={
      id:id,
      status:status,
      _token:"<?php  echo csrf_token(); ?>",
    }
    $.post('<?php  echo route("ChangeStatus"); ?>',parmt).then(function(response){
      $('#replacetable_'+id).html(response);
    })
  }
</script>
 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    var table = $('#example').DataTable();
 
        function explode(){
        $("#example_filter").detach().appendTo('.btns_rt');
    }

    
    $(document).ready(function() {
        setTimeout(explode, 500);
    table
        .columns(3)
        .search( this.value )
        .draw();
} );

        $('div.dataTables_filter input').attr('placeholder', 'Search...','class'); 
        $("#example").wrap("<div class='responsive-table'></div>");
        $('div.dataTables_filter input').addClass('form-control');
        
</script>
@include('SuperAdmin.default.footer')
@endsection