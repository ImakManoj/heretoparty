<?php 
use App\Http\Controllers\Controller;
?>
@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h4 class="title">Pages</h4>

                <!-- <a href="{{ url('/admin/tracks/create') }}" class="btn btn-success btn-sm" title="Add New Content">
                    <i class="fa fa-plus" aria-hidden="true"></i> Add New
                </a> -->

                <div class="card">
                    <div class="card-content">
                        <div class="fresh-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Page</th>
                                        <th>Title</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $counter = 1; ?>
                                @foreach($results as $item)
                                    <tr>
                                        <td>{{ @$item->id }}</td>
                                        <td>{{ (@$item->page == 1) ? 'Terms' : 'Privacy' }}</td>
                                        <td>{{ strlen(@$item->title) > 20 ? substr(@$item->title, 0, 20)."..." : @$item->title  }}</td>
                                        <td><a href="{{ url('/admin/help_pages/' . $item->id . '/edit') }}" title="Edit Content"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </button></a></td>
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
