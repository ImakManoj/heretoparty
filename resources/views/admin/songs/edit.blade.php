@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="container-fluid">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="title">Edit Song {{ $song->name }}</h4>
                    <div class="card-content">
                        <a href="{{ url('/admin/songs') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form id="add_form" method="POST" action="{{ url('/admin/songs/' . $song->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}

                            @include ('admin.songs.form', ['formMode' => 'edit'])

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
