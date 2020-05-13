@extends('layouts.admin')

@section('content')

<div class="content">
	<div class="container-fluid">
	    <div class="row">
	        <div class="col-md-12">
				<h4 class="title">Verbs</h4>
	            <div class="card">
	                <div class="card-content">
	                    <div class="toolbar">
	                        <!--Here you can write extra buttons/actions for the toolbar-->
	                    </div>
	                    <div class="fresh-datatables">
							<table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
							<thead>
								<tr>
									<th>Name</th>
								</tr>
							</thead>
							<tbody>
								@foreach($verbs as $item)

								<tr>
									<td>{{ @$item['name'] }}</td>
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