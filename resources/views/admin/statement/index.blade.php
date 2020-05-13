@extends('layouts.admin')

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                  @if(Session::has('message'))
                  <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                  @endif
                <h4 class="title">Statements</h4>
                
                <div class="card">
                    <div class="card-content">
                        <div class="toolbar">
                            <!--Here you can write extra buttons/actions for the toolbar-->
                        </div>
                        <div class="fresh-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Verbs</th>
                                    <th>Statements</th>
                                    <th>Created Date</th>
                                    <th>Match</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($statement as $item)

                                <tr>
                                    <td>{{ @$item['getUserName']->name }}</td>
                                    <td>{{ @$item['getVerb']->name }}</td>
                                    <td>{{ strlen(@$item['description']) > 20 ? substr(@$item['description'], 0, 20)."..." : @$item['description']  }}</td>
                                    <td>{{ @$item['created_at'] }}</td>
                                    <td>
                                        <a href="{{ url('admin/statements/show/'.$item['id'] ) }}" title="Edit post"><button class="btn btn-success btn-sm"><i class="ti-link" aria-hidden="true"></i> View</button></a>
                                        <!-- {{ url('/admin/verbs/' . $item['id'] . '/edit') }} -->
                                    </td>
                                    

                                    
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