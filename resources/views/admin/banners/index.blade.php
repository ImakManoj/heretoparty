<?php 
use App\Http\Controllers\Controller;
?>
@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <h4 class="title">Banners</h4>
                <a href="{{ url('/admin/banner/create') }}" class="btn btn-success btn-sm" title="Add New Song">
                    <i class="fa fa-plus" aria-hidden="true"></i> Add New
                </a>
                <div class="card">
                    <div class="card-content">

                        <div class="fresh-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Playlist Image</th>
                                        <th>Playlist Name</th>
                                        <th>Created Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $counter = 1; ?>
                                @foreach($results as $item)
                                    <tr>
                                        <td>{{ @$counter }}</td>
                                        <td>
                                            <?php
                                                $picture = Controller::getFilePath(@$item['getPlaylistInfo']->image, 'playlists');
                                                    if($picture) { ?>
                                                        <img src="{{ $picture }}" class="img-circle">
                                                        <?php
                                                    }else{ ?>
                                                        <img src="{{asset('public/uploads/images.jpg')}}" class="img-circle">
                                                    <?php
                                                    }
                                                ?>
                                            </td>
                                        <td>{{ strlen(@$item['getPlaylistInfo']->name) > 20 ? substr(@$item['getPlaylistInfo']->name, 0, 20)."..." : @$item['getPlaylistInfo']->name  }}</td>
                                        <td>{{ date('d F Y', strtotime(@$item->created_at)) }}</td>
                                        <td>
                                            <form method="POST" action="{{ url('/admin/banner' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
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

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
