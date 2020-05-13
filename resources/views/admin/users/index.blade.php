<?php 
use App\Http\Controllers\Controller;
?>

@extends('layouts.admin')

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
				<h4 class="title">Users</h4>
                <div class="card">
                    <div class="card-content">
                        <div class="toolbar">
                            <!--Here you can write extra buttons/actions for the toolbar-->
                        </div>
                        <div class="fresh-datatables">
							<table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
							<thead>
								<tr>
									<th>Id</th>
									<th>Image</th>
									<th>First Name</th>
									<th>Last Name</th>
									<th>Email</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $counter = 1; ?>
								@foreach($users as $item)
								<tr>
									<td>{{ @$counter }}</td>
									<td>
										<?php
											$picture = Controller::getFilePath($item->profile, 'users');
											if($picture) { ?>
												<img src="{{ $picture }}" class="img-circle">
												<?php
											}else{ ?>
												<img src="{{asset('public/uploads/images.jpg')}}" class="img-circle">
												<?php
											}
										?>
									</td>
									<td>{{ @$item['first_name'] }}</td>
									<td>{{ @$item['last_name'] }}</td>
									<td>{{ @$item['email'] }}</td>
									<!-- <td>
									  <button type="button" class="btn btn-success btn-sm"  onclick="updateIm('<?php echo $item['id'] ?>','<?php echo $item['name'] ?>','<?php echo $item['iam_balance'] ?>');" data-toggle="modal" data-target="#myModal">
									  	<p>{{ (float) @$item['iam_balance'] }} IAM</p> Edit</button>
									</td> -->
									<td>
										<a href="{{ url('/admin/users/' . $item['id']) }}" title="View"><button class="btn btn-success btn-sm"><i class="ti-eye" aria-hidden="true"></i></button>
										</a>
									</td>
								</tr>
								<?php $counter++; ?>
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