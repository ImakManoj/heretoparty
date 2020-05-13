<?php 
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\SongsController;
?>
@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <h4 class="title">Songs</h4>
                <a href="{{ url('/admin/songs/create') }}" class="btn btn-success btn-sm" title="Add New Song">
                    <i class="fa fa-plus" aria-hidden="true"></i> Add New
                </a>
                <div class="card">
                    <div class="card-content">

                        <div class="fresh-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Subtitle</th>
                                        <th>Description</th>
                                        <th>Plays</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $counter = 1; ?>
                                @foreach($songs as $item)
                                    <tr>
                                        <td>{{ @$counter }}</td>
                                        <td>
                                            <?php
                                                $picture = Controller::getFilePath($item->image, 'songPic');
                                                    if($picture) { ?>
                                                        <img src="{{ $picture }}" class="img-circle">
                                                        <?php
                                                    }else{ ?>
                                                        <img src="{{asset('public/uploads/images.jpg')}}" class="img-circle">
                                                    <?php
                                                    }
                                                ?>
                                            </td>
<td>{{ strlen(@$item->name) > 20 ? substr(@$item->name, 0, 20)."..." : @$item->name  }}</td>
<td>{{ strlen(@$item->subtitle) > 20 ? substr(@$item->subtitle, 0, 20)."..." : @$item->subtitle  }}</td>
<td>{{ strlen(@$item->description) > 20 ? substr(@$item->description, 0, 20)."..." : @$item->description  }}</td>
<td>{{ SongsController::songPlayCount($item->id)  }}</td>
                                        <td>
                                            <a href="{{ url('/admin/songs/' . $item->id) }}" title="View Song"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> </button></a>
                                            <a href="{{ url('/admin/songs/' . $item->id . '/edit') }}" title="Edit Song"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </button></a>

                                            <form method="POST" action="{{ url('/admin/songs' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Song" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php $counter++; ?>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $songs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
