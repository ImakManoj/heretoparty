@extends('layouts.admin')

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form name ="price_form" id="price_form" action="{{ url('admin/prices/update/') }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="card-header">
                                    <h4 class="card-title">
                                        Update IAM Price
                                    </h4>
                          <p></p>
                          @if(Session::has('message'))
                          <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                          @endif
                                    </div>
                        <div class="card-content">
                          <div class="form-group">
                              <label class="control-label">
                                                Price <star>*</star>
                                            </label>
                              <input class="form-control"
                                     name="price"
                                     type="number"
                                     required="true"
                                     autofocus="true" 
                                     autocomplete="off"
                                     value="{{ @$price->value }}" />
                          </div>
                        </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-info btn-fill pull-left">Update</button>
                                    <div class="clearfix"></div>
                                </div>
                    </form>
                </div>
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
                                    <td>{{ @$item['description'] }}</td>
                                    <td>{{ @$item['created_at'] }}</td>
                                    <td>
                                        <a href="{{ url('admin/statements/show' ) }}" title="Edit post"><button class="btn btn-success btn-sm"><i class="ti-link" aria-hidden="true"></i> View</button></a>
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
            </div>

        </div>
    </div>
</div>

@endsection