@extends('layouts.admin')

@section('content')

<div class="content">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="col-md-12">
							<h4 class="title">Keywords</h4>
	                        <div class="card">
	                            <div class="card-content">
	                                <div class="toolbar">
	                                    <!--Here you can write extra buttons/actions for the toolbar-->
	                                </div>
                                    <div class="fresh-datatables">
										<table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
										<thead>
											<tr>
												<!-- <th>Id</th> -->
												<th>User Name</th>
												<th>Keyword Type</th>
												<th>Keyword Value</th>
												<th>Created Date</th>
											</tr>
										</thead>
										<tbody>
											@foreach($results as $item)
											<tr>
												<!-- <td>{{ @$item['id'] }}</td> -->
												<td>{{ @$item['getUserName']->name }}</td>
												<td>{{ @$item['key_type'] }}</td>
												<td>{{ @$item['value'] }}</td>
												<td>{{ @$item['created_at'] }}</td>
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