<?php 
use App\Http\Controllers\Controller;
?>
@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h4 class="title">Genres</h4>
                <!-- <form method="GET" action="{{ url('/admin/contents') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request('search') }}">
                        <span class="input-group-append">
                            <button class="btn btn-secondary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form> -->

                <a href="{{ url('/admin/tracks/create') }}" class="btn btn-success btn-sm" title="Add New Content">
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
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $counter = 1; ?>
                                @foreach($contents as $item)
                                    <tr>
                                         <td>{{ @$counter }}</td>
                                          <td>
                                            <?php
                                                $picture = Controller::getFilePath($item->image, 'tracks');
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
                                        <td>
                                            <a href="{{ url('/admin/tracks/' . $item->id) }}" title="View Content"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> </button></a>
                                            <a href="{{ url('/admin/tracks/' . $item->id . '/edit') }}" title="Edit Content"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </button></a>

                                            <form method="POST" action="{{ url('/admin/tracks' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Content" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php $counter++; ?>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $contents->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
