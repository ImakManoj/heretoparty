<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
	<div class="card-header">
        <h4 class="card-title">
            Update Blog
        </h4>
      <p></p>
    <div class="card-content">
      <div class="form-group">
        <label class="control-label">
	        Title <star>*</star>
	    </label>
        <input class="form-control" name="title" type="text" id="title" value="{{ $blogs->title or ''}}" autofocus="true" autocomplete="off">
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
      </div>

      <div class="form-group">
        <label class="control-label">
            Description <star>*</star>
        </label>
        <!-- <input class="form-control" name="description" type="text" id="description" value="{{ $blogs->description or ''}}" autofocus="true" autocomplete="off"> -->
        <textarea name="summernoteInput" class="summernote" required></textarea>
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
      </div>
    </div>
</div>

<div class="card-footer">
    <div class="col-md-4">
        <input class="btn btn-info btn-fill pull-left" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
    <div class="clearfix"></div>
</div>



