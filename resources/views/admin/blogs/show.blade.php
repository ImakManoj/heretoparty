@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h4>Show Your Blogs</h4></div>
                    <div class="card-body">

                        <div class="container">
                            {!! $blogs['description'] !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
