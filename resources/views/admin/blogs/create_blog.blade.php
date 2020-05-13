@extends('layouts.admin')

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                        <form method="POST" action="{{ url('/admin/blogs') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data" id="verbs_form">
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        <div class="card-header">
                                    <h4 class="card-title">
                                        Create New Blogs
                                    </h4>
                          <p></p>
                          @if(Session::has('message'))
                          <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                          @endif
                                    </div>
                        <div class="card-content">
                          <div class="form-group">
                              <label class="control-label">
                                                Title <star>*</star>
                                            </label>
                              <input class="form-control"
                                     name="title"
                                     type="text"
                                     required="true"
                                     autofocus="true" 
                                     autocomplete="off" />
                          </div>
  
                          <div class="form-group">
                              <label class="control-label">
                                                Create Blog Template <star>*</star>
                                            </label>
                              <textarea name="summernoteInput" class="summernote" required></textarea>
                          </div>
                           
                        </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-info btn-fill pull-left">Save</button>
                                    <div class="clearfix"></div>
                                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.note-editable {
  height: 400px;
}
</style>

@endsection
