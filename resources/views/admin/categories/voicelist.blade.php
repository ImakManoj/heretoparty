@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <br />

     <a href="{{ url('/admin/voice') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Add </button></a>
 <h4 class="title">Voice</h4>
 <table  class="table table-striped table-no-bordered table-hover" width="100%" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>images</th>
            <th>flag</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @if(!$records->isEmpty())
            @foreach($records as $ft)
                <tr>
                    <td>{{$ft->id}}</td>
                    <td>{{$ft->name}}</td>
                    <td><img src="{{asset('public/images/'.$ft->image)}}" class="img-circle"></td>
                    <td><img src="{{asset('public/images/flag').'/'.$ft->flag}}" class="img-circle"></td>
                    <td><a href="{{route('voice',['key'=>$ft->id])}}"><span class="btn btn-info sm-btn">Edit</span></a>
                        <span class="btn btn-danger sm-btn">Delete</span>
                    </td>
                </tr>
            @endforeach
        @endif

    </tbody>
</table>
</div>
@endsection
