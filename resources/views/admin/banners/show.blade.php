@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="container-fluid">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <h4 class="title">{{ $song->name }}</h4>
                        <a href="{{ url('/admin/songs') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/admin/songs/' . $song->id . '/edit') }}" title="Edit Song"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('admin/songs' . '/' . $song->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Song" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr><th> Title </th><td> {{ $song->name }} </td></tr>
                                    <tr><th> Subtitle </th><td> {{ $song->subtitle }} </td></tr>
                                    <tr><th> Duration </th><td> {{ ($song->duration/1000) }} minutes</td></tr>
                                    <tr><th> Status </th><td> {{ $song->status == '1'?"Active":"Inactive" }} </td></tr>
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
