@extends('SuperAdmin.layouts.app')
@section('title', 'Single Page')
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
		
			<div class="page-header">
						<h4 class="page-title">Single Page</h4> 
			</div>
       <form action="{{route('SinglePages')}}" method="post">
        @csrf
        <div class="col-md-3">
          <select class="form-control" required="" name="categoryies" onchange="this.form.submit()">
            <option>Select Category</option>
            @foreach($category as $row)
              <option value="{{$row->cagetory_id}}" @if($row->cagetory_id==$id){{'selected'}} @endif> {{$row->cagetory_name}}</option>
            @endforeach
          </select>
        </div>
        </form>
        <div class="col-md-7"></div>
        <div class="col-md-2">
         <!--  <span class="btn btn-danger btn-sm pull-right" onclick="showeditpanel()">Edit</span> -->
        </div>
      

      <form action="{{route('SinglePagesCantent')}}" method="post" enctype="multipart/form-data">
          @csrf

       <!-- <div class="row">
        <div class="col-md-3">
          <select class="form-control" required="" name="categoryies">
            <option>Select Category</option>
            @foreach($category as $row)
              <option value="{{$row->cagetory_id}}"> {{$row->cagetory_name}}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-7"></div>
        <div class="col-md-2">
        
        </div>
       </div> -->

       
		  <section id="editSection" >
        @foreach($singlepages as $ft)
        <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <input type="text" name="names[]" id="Haircut" class="form-control" placeholder="Title" required="" value="{{$ft->name}}">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <input type="file" name="images[]" id="images" class="form-control" placeholder="Haircut" >
          </div>
          <input type="hidden" name="pageid[]" value="{{$ft->id}}">
        </div>


        <div class="col-md-12">
          <div class="form-group">
            <textarea type="text" name="Contant[]" id="Contant" class="form-control ckeditor" placeholder="Contant" required="">{{$ft->content}}</textarea>
          </div>
        </div> 
      </div>


      @endforeach


      <!-- <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <input type="text" name="names[]" id="Keratin" class="form-control" placeholder="Keratin Treatment" required="">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <input type="file" name="images[]" id="Keratinimages" class="form-control" placeholder="Haircut" required="">
          </div>
        </div>


        <div class="col-md-12">
          <div class="form-group">
            <textarea type="text" name="Contant[]" id="ContantKeratin" class="form-control ckeditor" placeholder="Contant" required=""></textarea>
          </div>
        </div> 
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <input type="text" name="names[]" id="BlowOut" class="form-control" placeholder="Blow Out" required="">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <input type="file" name="images[]" id="BlowOutimages" class="form-control" placeholder="Haircut" required="">
          </div>
        </div>


        <div class="col-md-12">
          <div class="form-group">
            <textarea type="text" name="Contant[]" id="ContantBlow" class="form-control ckeditor" placeholder="Blow Out Contant" required=""></textarea>
          </div>
        </div> 
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <input type="text" name="names[]" id="Styling" class="form-control" placeholder="Styling" required="">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <input type="file" name="images[]" id="Stylingimages" class="form-control" placeholder="Haircut" required="">
          </div>
        </div>


        <div class="col-md-12">
          <div class="form-group">
            <textarea type="text" name="Contant[]" id="ContantStyling" class="form-control ckeditor" placeholder="Styling Contant" required=""></textarea>
          </div>
        </div> 
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <input type="text" name="names[]" id="Highlightst" class="form-control" placeholder="Highlightst" required="">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <input type="file" name="images[]" id="Highlightstimages" class="form-control" placeholder="Haircut" required="">
          </div>
        </div>


        <div class="col-md-12">
          <div class="form-group">
            <textarea type="text" name="Contant[]" id="ContantHighlightst" class="form-control ckeditor" placeholder="Highlightst Contant" required=""></textarea>
          </div>
        </div> 
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <input type="text" name="names[]" id="ManyMore" class="form-control" placeholder="Many More" required="">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <input type="file" name="images[]" id="ManyMoreimages" class="form-control" placeholder="Haircut" required="">
          </div>
        </div>


        <div class="col-md-12">
          <div class="form-group">
            <textarea type="text" name="Contant[]" id="ContantManyMore" class="form-control ckeditor" placeholder="Many MoreContant" required=""></textarea>
          </div>
        </div> 
      </div> -->

      <div class="col-md-12">
        <div class="form-group">
          <input type="submit" name="submit" value="Save" class="btn btn-success btn-sm pull-right">
        </div>
      </div>
      </section>

      </form>
		</div>
	</div>
</div>
<script type="text/javascript">
  function showeditpanel(){
    if($('#categoryies').val()==''){
      alert('Please select Category');
    }else{
      const pramt={
          _token:"{{csrf_token()}}",
          id:$('#categoryies').val(),
      }



    }
    $('#default').hide();
    $('#editSection').show();
  }

</script>

<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script>
  CKEDITOR.replace( 'ckeditor' );
</script>
@include('SuperAdmin.default.footer')
@endsection