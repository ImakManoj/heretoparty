<?php 
use App\Http\Controllers\Controller;
?>

<input class="form-control" name="id" type="hidden" id="id" value="{{ @$data->id }}" >

<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ 'Page Name' }}</label>
    <input class="form-control" name="page" type="hidden" id="page" value="{{ @$data->page }}" >
    <input class="form-control" name="page" type="text" id="page" value="{{ (@$data->page == 1) ? 'Terms' : 'Privacy'}}" disabled="">
    {!! $errors->first('page', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    <label for="title" class="control-label">{{ 'Title' }}</label>
    <input class="form-control" name="title" type="text" id="title" value="{{ @$data->title}}" required />
    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    <label for="description" class="control-label">{{ 'Description' }}</label>
    <textarea name="description" class="summernote" required></textarea>
    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
