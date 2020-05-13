@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col-xs-5">
                                <div class="icon-big icon-warning text-center">
                                    <i class="ti-user"></i>
                                </div>
                            </div>
                            <div class="col-xs-7">
                                <div class="numbers">
                                    <p>Users</p>
                                </br>
                                    {{ $users_count }}
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="card-footer">
						<hr />
						<div class="stats">
							<a href="{{ url('/admin/users') }}"><i class="ti-link"></i> More</a>
						</div>
					</div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col-xs-5">
                                <div class="icon-big icon-danger text-center">
                                    <i class="ti-align-justify"></i>
                                </div>
                            </div>
                            <div class="col-xs-7">
                                <div class="numbers">
                                    <p>Category</p>
                                </br>
                                    {{ $albums_count }}
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="card-footer">
						<hr />
						<div class="stats">
							<a href="{{ url('/admin/albums') }}"><i class="ti-link"></i> More</a>
						</div>
					</div>
                </div>
            </div>
            
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col-xs-5">
                                <div class="icon-big icon-danger text-center">
                                    <i class="ti-user"></i>
                                </div>
                            </div>
                            <div class="col-xs-7">
                                <div class="numbers">
                                    <p>Artists</p>
                                </br>
                                    {{ $artists_count }}
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="card-footer">
						<hr />
						<div class="stats">
							<a href="{{ url('/admin/artists') }}"><i class="ti-link"></i> More</a>
						</div>
					</div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col-xs-5">
                                <div class="icon-big icon-info text-center">
                                    <i class="ti-control-play"></i>
                                </div>
                            </div>
                            <div class="col-xs-7">
                                <div class="numbers">
                                    <p>Playlists</p>
                                </br>
                                    {{ $playlists_count }}
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="card-footer">
						<hr />
						<div class="stats">
							<a href="{{ url('/admin/playlists') }}"><i class="ti-link"></i> More</a>
						</div>
					</div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col-xs-5">
                                <div class="icon-big icon-info text-center">
                                    <i class="ti-music-alt"></i>
                                </div>
                            </div>
                            <div class="col-xs-7">
                                <div class="numbers">
                                    <p>Songs</p>
                                </br>
                                    {{ $tracks_count }}
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="card-footer">
						<hr />
						<div class="stats">
							<a href="{{ url('/admin/songs') }}"><i class="ti-link"></i> More</a>
						</div>
					</div>
                </div>
            </div>
        </div>
        
		<!-- <div class="row">
			<div class="col-lg-4 col-sm-6">
				<div class="card">
					<div class="card-content">
						<div class="row">
							<div class="col-xs-7">
								<div class="numbers pull-left">
									$34,657
								</div>
							</div>
							<div class="col-xs-5">
								<div class="pull-right">
									<span class="label label-success">
											+18%
									</span>
								</div>
							</div>
						</div>
						<h6 class="big-title">total earnings <span class="text-muted">in last</span> ten <span class="text-muted">quarters</span></h6>
                        <div id="chartTotalEarnings"></div>
					</div>
					<div class="card-footer">
						<hr>
						<div class="footer-title">Financial Statistics</div>
						<div class="pull-right">
							<button class="btn btn-info btn-fill btn-icon btn-sm">
								<i class="ti-plus"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-sm-6">
				<div class="card">
					<div class="card-content">
						<div class="row">
							<div class="col-xs-7">
								<div class="numbers pull-left">
									169
								</div>
							</div>
							<div class="col-xs-5">
								<div class="pull-right">
									<span class="label label-danger">
											-14%
									</span>
								</div>
							</div>
						</div>
						<h6 class="big-title">total subscriptions <span class="text-muted">in last</span> 7 days</h6>
                        <div id="chartTotalSubscriptions"></div>
					</div>
					<div class="card-footer">
						<hr>
						<div class="footer-title">View all members</div>
						<div class="pull-right">
							<button class="btn btn-default btn-fill btn-icon btn-sm">
								<i class="ti-angle-right"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-sm-6">
				<div class="card">
					<div class="card-content">
						<div class="row">
							<div class="col-xs-7">
								<div class="numbers pull-left">
									8,960
								</div>
							</div>
							<div class="col-xs-5">
								<div class="pull-right">
									<span class="label label-warning">
											~51%
									</span>
								</div>
							</div>
						</div>
						<h6 class="big-title">total downloads <span class="text-muted">in last</span> 6 years</h6>
                        <div id="chartTotalDownloads" ></div>
					</div>
					<div class="card-footer">
						<hr>
						<div class="footer-title">View more details</div>
						<div class="pull-right">
							<button class="btn btn-success btn-fill btn-icon btn-sm">
								<i class="ti-info"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-3 col-sm-6">
				<div class="card card-circle-chart" data-background-color="blue">
					<div class="card-header text-center">
                        <h5 class="card-title">Dashboard</h5>
                        <p class="description">Monthly sales target</p>
                    </div>
					<div class="card-content">
						<div id="chartDashboard" class="chart-circle" data-percent="70">70%</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-sm-6">
				<div class="card card-circle-chart" data-background-color="green">
					<div class="card-header text-center">
                        <h5 class="card-title">Orders</h5>
                        <p class="description">Completed</p>
                    </div>
					<div class="card-content">
						<div id="chartOrders" class="chart-circle" data-percent="34">34%</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-sm-6">
				<div class="card card-circle-chart" data-background-color="orange">
					<div class="card-header text-center">
                        <h5 class="card-title">New Visitors</h5>
                        <p class="description">Out of total number</p>
                    </div>
					<div class="card-content">
						<div id="chartNewVisitors" class="chart-circle" data-percent="62">62%</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-sm-6">
				<div class="card card-circle-chart" data-background-color="brown">
					<div class="card-header text-center">
                        <h5 class="card-title">Subscriptions</h5>
                        <p class="description">Monthly newsletter</p>
                    </div>
					<div class="card-content">
						<div id="chartSubscriptions" class="chart-circle" data-percent="10">10%</div>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
@endsection