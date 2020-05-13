<?php 
use App\Http\Controllers\Controller;
?>

<input class="form-control" name="cat_id" type="hidden" id="cat_id" value="{{ 1 }}" >

<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ 'Name' }}</label>
    <input class="form-control" name="name" type="text" id="name" value="{{ $content->name or ''}}" required>
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    <label for="description" class="control-label">{{ 'About' }}</label>
    <textarea class="form-control" rows="5" name="description" type="textarea" id="description" >{{ $content->description or ''}}</textarea>
    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
    <label for="image" class="control-label">{{ 'Profile Image' }}</label>

    <?php
    if(!empty($content->image)) {
        $picture = Controller::getFilePath($content->image, 'artists');

        if($picture) {
            ?>
            <img src="{{ $picture }}" height="150px" width="150px">
            <?php
        }
    }
    ?>
    <input class="" name="image" type="file" id="image" value="{{ $content->image or ''}}" {{ isset($content->image)?'':'required' }} />
    {!! $errors->first('image', '<p class="help-block">:message</p>') !!}

</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
