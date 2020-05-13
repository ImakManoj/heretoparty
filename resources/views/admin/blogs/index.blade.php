@extends('layouts.admin')

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" >
                    <a href="{{ url('/admin/blogs/create') }}" class="btn btn-success btn-sm" title="Add New Blog" style="float: right;">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                    </a>
                </div>
            <div class="col-md-12">
                  @if(Session::has('message'))
                  <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                  @endif
                <h4 class="title">Blogs</h4>
                
                <div class="card">
                    <div class="card-content">
                        <div class="toolbar">
                            <!--Here you can write extra buttons/actions for the toolbar-->
                        </div>
                        <div class="fresh-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width: 50% !important;">Title</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($blogs as $item)

                                <tr>
                                    <td>{{ @$item['title'] }}</td>

                                    <td>
                                        <a href="{{ url('/admin/blogs/' . $item['id']) }}" title="Blog Show"><button class="btn btn-success btn-sm"><i class="ti-eye" aria-hidden="true"></i> </button>

                                        <a href="{{ url('/admin/blogs/' . $item['id'] . '/edit') }}" title="Edit post"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </button></a>

                                    <!-- <a href="{{ url('/admin/verbs/' . $item['id'] . '/edit') }}" title="Edit post"><button class="btn btn-danger btn-sm"><i class="ti-trash" aria-hidden="true"></i> Delete</button></a> -->

                                    <form method="POST" action="{{ url('/admin/blogs' . '/' . $item['id']) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete blogs" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> </button>
                                    </form>
                                    </td>
                                </tr>

                                @endforeach

                               </tbody>
                            </table>
                        </div>

                    </div>
                </div><!--  end card  -->
            </div> <!-- end col-md-12 -->
        </div> <!-- end row -->
    </div>
</div>
@endsection