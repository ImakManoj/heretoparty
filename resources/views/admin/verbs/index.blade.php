@extends('layouts.admin')

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" >
                    <!-- <a href="{{ url('/admin/verbs/create') }}" class="btn btn-success btn-sm" title="Add New verb" style="float: right;">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                    </a> -->
                </div>
            <div class="col-md-12">
                  @if(Session::has('message'))
                  <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                  @endif
                <h4 class="title">Verbs</h4>
                
                <div class="card">
                    <div class="card-content">
                        <div class="toolbar">
                            <!--Here you can write extra buttons/actions for the toolbar-->
                        </div>
                        <div class="fresh-datatables">
                            <table class="table table-striped table-no-bordered table-hover">
                            <!-- <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%"> -->
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php $count = 1; ?>
                                @foreach($verbs as $item)
                                <tr>
                                    <td>{{ @$count }}</td>
                                    <td>{{ @$item['name'] }}</td>
                                    <!-- <td><a href="{{ url('/admin/verbs/' . $item['id'] . '/edit') }}" title="Edit post"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a> -->

                                    <!-- <a href="{{ url('/admin/verbs/' . $item['id'] . '/edit') }}" title="Edit post"><button class="btn btn-danger btn-sm"><i class="ti-trash" aria-hidden="true"></i> Delete</button></a> -->

                                    <!-- <form method="POST" action="{{ url('/admin/verbs' . '/' . $item['id']) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete verbs" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                    </form> -->
                                    <!-- </td> -->
                                </tr>
                                <?php $count++;?>
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