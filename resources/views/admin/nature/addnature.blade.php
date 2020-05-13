@extends('layouts.admin')
@section('content')
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<div class="container-fluid">
    <div class="col-md-12">
            <br />
        @if($message = Session::get('message'))
            <div class="alert alert-warning alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
            </div>
            @endif
     <a href="{{ url('/admin/voicelist') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
     <br />
     <br />
     <div class="card">
        <div class="card-header">Create New Nature</div>
        <div class="card-body">
                <form method="POST" action="{{ url('/admin/natureSave') }}" accept-charset="UTF-8" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                         <label>Enter Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" required="" value="{{@$records->name}}">

                    </div>
                    <input type="hidden" name="voiceid" value="{{@$records->id}}">
                     <div class="form-group">
                        <label> Choose images </label>
                            <input type="file" name="images" id="images"  class="form-control">
                        </div>
                        
                         <div class="form-group">
                             <label> Choose nature sound </label>

                            <input type="file" name="voice" id="voice"  class="form-control">
                        </div>
                         <div class="form-group">
                            <input type="submit" name="submit" class="btn btn-primary sm-btn" value="Submit">
                        </div>
                </form>
        </div>
    </div>
</div>

</div>



@endsection
