<?php use App\Http\Controllers\Controller; ?>

<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ 'Title' }}</label>
    <input class="form-control" name="name" type="text" id="name" value="{{ $song->name or ''}}" required />
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('subtitle') ? 'has-error' : ''}}">
    <label for="subtitle" class="control-label">{{ 'Subtitle' }}</label>
    <input class="form-control" name="subtitle" type="text" id="subtitle" value="{{ $song->subtitle or ''}}" >
    {!! $errors->first('subtitle', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    <label for="description" class="control-label">{{ 'Description' }}</label>
    <textarea class="form-control" rows="4" cols="100" name="description" type="textarea" id="description" >{{ $song->description or ''}}</textarea>
    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
    <label for="image" class="control-label">{{ 'Display Image' }}</label>
    <?php
if(isset($song))
{
    $getFile = Controller::getFilePath($song->image, 'songPic');
    if($getFile)
    { ?>
            <img height="200" width="200" src="{{ $getFile }}">
        <?php
    }
} ?>
    <input class="form-control" name="image" type="file" id="image" value="{{ $song->image or ''}}" >
    {!! $errors->first('image', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
    <label for="song" class="control-label">{{ 'Song' }}</label>
    @if(isset($song))
        <input class="form-control" name="song" type="file" id="song" value="{{ $song->song or ''}}" {{ !empty($song->song)?'':'required' }} /> {{ $song->song }}
    @else
        <input class="form-control" name="song" type="file" id="song" value="" required />
    @endif
    {!! $errors->first('song', '<p class="help-block">:message</p>') !!}
</div>

<!-- <label class="control-label">Please Select</label>
<div class="form-group">
    <input type="checkbox" id="artist" name="cat[]" value="1" {{ isset($getArtist)?'checked':'' }} />Artist
    <input type="checkbox" id="album" name="cat[]" value="2" {{ isset($getAlbum)?'checked':'' }} />Album
    <input type="checkbox" id="playlist" name="cat[]" value="3" {{ isset($getPlaylist)?'checked':'' }} />Playlist
    <input type="checkbox" id="track" name="cat[]" value="4" {{ isset($getTrack)?'checked':'' }} />Track
</div> -->


<!-- style="{{ isset($getArtist)?'':'display: none' }}" -->
<div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
    <label for="song" class="control-label">Select Artist</label>

    <select class="form-control" id="artist_list" name="selectedArtist">
        <option value="">Select Artist</option>

        @foreach($artists as $key => $val)
            @if(isset($getArtist))
                <option value="{{ $val->id}}" 
                    {{ (in_array($val->id, explode(',', $song->content_id))) ? 'selected' : '' }} >{{$val->name}}
                </option>
            @else
                <option value="{{ $val->id}}">{{$val->name}}</option>
            @endif
        @endforeach
    </select>
</div>

<!-- style="{{ isset($getAlbum)?'':'display: none' }}" -->
<div class="form-group {{ $errors->has('Album') ? 'has-error' : ''}}">
    <label for="song" class="control-label">Select Album</label>
    <select class="form-control" id="album_list" name="selectedAlbum">
        <option value="">Select Category</option>
        @foreach($albums as $key=>$val)
            @if(isset($getAlbum))
                <option value="{{ $val->id}}" data-id="{{ $getAlbum->content_id }}" val-id="{{ $val->id }}" 
                    {{ (in_array($val->id, explode(',', $getAlbum->content_id))) ? 'selected' : '' }} >{{$val->name}}
                </option>
            @else
                <option value="{{ $val->id}}">{{$val->name}}</option>
            @endif
        @endforeach
    </select>
</div>

<!-- style="{{ isset($getPlaylist)?'':'display: none' }}" -->
<div class="form-group {{ $errors->has('Playlist') ? 'has-error' : ''}}">
    <label for="song" class="control-label">Select Playlist</label>
    <select class="form-control" id="playlist_list" name="selectedPlaylist" >
        <option value="">Select Playlist</option>
        @foreach($playlists as $key=>$val)
            @if(isset($getPlaylist))
                <option value="{{ $val->id}}" 
                    {{ (in_array($val->id, explode(',', $getPlaylist->content_id))) ? 'selected' : '' }} >{{$val->name}}
                </option>
            @else
                <option value="{{ $val->id}}">{{$val->name}}</option>
            @endif
        @endforeach
    </select>
</div>

<!-- style="{{ isset($getTrack)?'':'display: none' }}" -->
<div class="form-group {{ $errors->has('Track') ? 'has-error' : ''}}">
    <label for="song" class="control-label">Select Track</label>
    <select class="form-control ui dropdown" id="track_list" name="selectedTrack[]"  multiple>
        <option value="">Select Track</option>
        @foreach($tracks as $key=>$val)
            @if(isset($getTrack))
                <option value="{{ $val->id}}" 
                    {{ (in_array($val->id, explode(',', $getTrack->content_id))) ? 'selected' : '' }} >{{$val->name}}
                </option>
            @else
                <option value="{{ $val->id}}">{{$val->name}}</option>
            @endif
        @endforeach
    </select>
</div>

</br>
<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>

<style type="text/css">
    .card .icon{
        display: inline !important;
        transform: none !important;
    }
</style>

