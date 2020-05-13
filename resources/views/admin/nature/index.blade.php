@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <br />

     <a href="{{ url('/admin/addNature') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Add </button></a>
 <h4 class="title">Nature</h4>
 <table  class="table table-striped table-no-bordered table-hover" width="100%" style="width:100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Songs</th>
            <th>Image</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>


    </tbody>
</table>
</div>
@endsection
