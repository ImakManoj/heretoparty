<?php use App\Http\Controllers\Controller; ?>

<div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
    <label for="song" class="control-label">Select Playlist</label>

    <select class="form-control" id="playlist" name="playlist" required="">
        <option value="">Select Playlist</option>

        @foreach($playlists as $key => $val)
                <option value="{{ $val->id}}">{{$val->name}}</option>
        @endforeach
    </select>
</div>


</br>
<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>