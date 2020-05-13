@extends('layouts.admin')

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
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
                                     value="{{ $price->value }}" disabled="true" />
                          </div>
                        </div>
          						<div class="card-footer">
          							<!-- <button type="submit" class="btn btn-info btn-fill pull-left">Update</button> -->
          							<div class="clearfix"></div>
          						</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection