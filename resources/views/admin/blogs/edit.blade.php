@extends('layouts.admin')

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                        <form method="POST" action="{{ url('/admin/blogs/' . $blogs['id']) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}

                            @include ('admin.blogs.form', ['submitButtonText' => 'Update'])

                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.note-editable {
  height: 400px;
}
</style>

@endsection
