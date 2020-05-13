@extends('layouts.admin')

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                  @if(Session::has('message'))
                  <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                  @endif
                <h4 class="title">Payment History</h4>
                
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
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total Amount</th>
                                    <th>Transaction Id</th>
                                    <th>Created Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payment as $item)

                                <tr>
                                    <td>{{ @$item['getUser']->name }}</td>
                                    <td>{{ (int) @$item['quantity'] }} IAM</td>
                                    <td>${{ @$item['price'] }}</td>
                                    <td>${{ @$item['total_amount'] }}</td>
                                    <td>{{ @$item['transaction_id'] }}</td>
                                    <td>{{ @$item['created_at'] }}</td>

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