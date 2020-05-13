<?php 
use App\Http\Controllers\Controller;
?>

@extends('layouts.admin')

@section('content')
<?php use App\Http\Controllers\Admin\UsersController; ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">View All Data</h4>
            			<div class="sctn1">
            				<h4></h4>
						    <figure>
						    	<?php
								$picture = Controller::getFilePath($users_details->profile, 'users');
									if($picture) { ?>
										<img src="{{ $picture }}" width="40px">
										<?php
									}else{ ?>
										<img src="{{asset('public/uploads/images.jpg')}}" width="40px">
									<?php
									}
								?>
							</figure>
							<h4>{{ @$users_details->first_name }} {{ @$users_details->last_name }}</h4>
						</div>
						<div class="sctn2">
						    <p> <label>First Name  :</label>
						    	<span>
						    		@if(!empty($users_details->first_name))
						    			{{ @$users_details->first_name }}
						    		@else
						    			{{ 'N/A' }}
						    		@endif
						    	</span>
						    </p>
						    <p> <label>Last Name  :</label>
						    	<span>
						    		@if(!empty($users_details->last_name))
						    			{{ @$users_details->last_name }}
						    		@else
						    			{{ 'N/A' }}
						    		@endif
						    	</span>
						    </p>
						    <p> <label>Email :</label><span>{{ @$users_details->email }}</span></p>
						</div>
						<div class="sctn2">
						    <p> <label>DOB :</label>
						    	<span>
						    		@if(!empty($users_details->dob))
						    			{{ @$users_details->dob }}
						    		@else
						    			{{ 'N/A' }}
						    		@endif
						    	</span>
						    </p>
						    <p> <label>Gender :</label>
						    	<span>
						    		@if(!empty($users_details->gender))
						    			{{ @$users_details->gender == "1" ? "Male" : (@$users_details->gender =="2" ? "Female" : " ") }}
						    		@else
						    			{{ 'N/A' }}
						    		@endif
						    	</span>
						   	</p>
						    <p> <label>Register Date :</label><span>{{ date(@$users_details->created_at) }}</span></p>
						</div>
                    </div>
                    <div class="card-content">
                        <div class="nav-tabs-navigation">
	                        <div class="nav-tabs-wrapper">
		                        <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
		                            <li class="active"><a href="#fav_albums" data-toggle="tab">Fav Albums</a></li>
		                            <li><a href="#fav_artists" data-toggle="tab">Fav Artists</a></li>
		                            <li><a href="#fav_playlist" data-toggle="tab">Fav Playlist</a></li>
		                            <li><a href="#fav_song" data-toggle="tab">Fav Song</a></li>
		                        </ul>
	                        </div>
	                    </div>
	                    <div id="my-tab-content" class="tab-content text-center">
	                        <div class="tab-pane active" id="fav_albums">
	                            <div class="fresh-datatables">
		                            <table id="datatables" class="table table-striped table-no-bordered table-hover" >
		                            <thead>
		                                <tr>
		                                    <th>Id</th>
		                                    <th>Image</th>
		                                    <th>Title</th>
		                                    <th>Subtitle</th>
		                                    <th>Description</th>
		                                    <th>Fav Date</th>
		                                    <th>Action</th>
		                                </tr>
		                            </thead>
		                            <tbody>
		                                <?php $counter = 1; ?>
		                                @foreach($fav_albums as $item)
			                            <tr>
		                                	<td><?php echo $counter; ?></td>
											<td>
												<?php
													$picture = Controller::getFilePath(@$item['getContentsInfo']->image, 'albums');
													if($picture) { ?>
														<img src="{{ $picture }}" class="img-circle">
														<?php
													}else{ ?>
														<img src="{{asset('public/uploads/images.jpg')}}" class="img-circle">
														<?php
													}
												?>
											</td>
			                                    
<td>{{ strlen(@$item['getContentsInfo']->name) > 20 ? substr(@$item['getContentsInfo']->name, 0, 20)."..." : @$item['getContentsInfo']->name  }}</td>

<td>{{ strlen(@$item['getContentsInfo']->subtitle) > 20 ? substr(@$item['getContentsInfo']->subtitle, 0, 20)."..." : @$item['getContentsInfo']->subtitle  }}</td>

<td>{{ strlen(@$item['getContentsInfo']->description) > 20 ? substr(@$item['getContentsInfo']->description, 0, 20)."..." : @$item['getContentsInfo']->description  }}</td>

											<td>{{ $item['created_at']->format('Y-m-d H:i') }}</td>

<td><a href = "#" onclick="showDetails('<?php echo @$item['getContentsInfo']->name; ?>','<?php echo @$item['getContentsInfo']->subtitle ?>' ,'<?php echo @$item['getContentsInfo']->description ?>');" data-toggle="modal" data-target="#myModal">View</a></td>
			                                </tr>
			                                <?php $counter++; ?>
					                    @endforeach
		                               </tbody>
		                            </table>
		                        </div>
	                        </div>

	                        <div class="tab-pane" id="fav_artists">
	                            <div class="fresh-datatables">
		                            <table id="datatables1" class="table table-striped table-no-bordered table-hover">
		                            <thead>
		                                <tr>
		                                    <th>Id</th>
		                                    <th>Image</th>
		                                    <th>Name</th>
		                                    <th>About</th>
		                                    <th>Fav Date</th>
		                                    <th>Action</th>
		                                </tr>
		                            </thead>
		                            <tbody>
		                                <?php $counter = 1; ?>
		                                @foreach($fav_artists as $item)
			                            <tr>
		                                	<td>{{ @$counter }}</td>
											<td>
												<?php
													$picture = Controller::getFilePath(@$item['getContentsInfo']->image, 'artists');
													if($picture) { ?>
														<img src="{{ $picture }}" class="img-circle">
														<?php
													}else{ ?>
														<img src="{{asset('public/uploads/images.jpg')}}" class="img-circle">
														<?php
													}
												?>
											</td>
			                                    
<td>{{ strlen(@$item['getContentsInfo']->name) > 20 ? substr(@$item['getContentsInfo']->name, 0, 20)."..." : @$item['getContentsInfo']->name  }}</td>

<td>{{ strlen(@$item['getContentsInfo']->description) > 20 ? substr(@$item['getContentsInfo']->description, 0, 20)."..." : @$item['getContentsInfo']->description  }}</td>

											<td>{{ $item['created_at']->format('Y-m-d H:i') }}</td>

<td><a href = "#" onclick='return showArtistDetails("<?php echo @$item['getContentsInfo']->name; ?>", "<?php echo addslashes(@$item['getContentsInfo']->description);  ?>" );' data-toggle="modal" data-target="#myModal1">View </a></td>
			                                </tr>
			                                <?php $counter++; ?>
					                    @endforeach
		                               </tbody>
		                            </table>
		                        </div>
	                        </div>
	                        <div class="tab-pane" id="fav_playlist">
	                            <div class="fresh-datatables">
		                            <table id="datatables2" class="table table-striped table-no-bordered table-hover" >
		                            <thead>
		                                <tr>
		                                    <th>Id</th>
		                                    <th>Image</th>
		                                    <th>Title</th>
		                                    <th>Subtitle</th>
		                                    <th>Description</th>
		                                    <th>Fav Date</th>
		                                    <th>Action</th>
		                                </tr>
		                            </thead>
		                            <tbody>
		                                <?php $counter = 1; ?>
		                                @foreach($fav_playlists as $item)
			                            <tr>
		                                	<td>{{ @$counter }}</td>
											<td>
												<?php
													$picture = Controller::getFilePath(@$item['getContentsInfo']->image, 'playlists');
													if($picture) { ?>
														<img src="{{ $picture }}" class="img-circle">
														<?php
													}else{ ?>
														<img src="{{asset('public/uploads/images.jpg')}}" class="img-circle">
														<?php
													}
												?>
											</td>
			                                    
<td>{{ strlen(@$item['getContentsInfo']->name) > 20 ? substr(@$item['getContentsInfo']->name, 0, 20)."..." : @$item['getContentsInfo']->name  }}</td>

<td>{{ strlen(@$item['getContentsInfo']->subtitle) > 20 ? substr(@$item['getContentsInfo']->subtitle, 0, 20)."..." : @$item['getContentsInfo']->subtitle  }}</td>

<td>{{ strlen(@$item['getContentsInfo']->description) > 20 ? substr(@$item['getContentsInfo']->description, 0, 20)."..." : @$item['getContentsInfo']->description  }}</td>

											<td>{{ $item['created_at']->format('Y-m-d H:i') }}</td>

<td><a href = "#" onclick="showDetails('<?php echo @$item['getContentsInfo']->name; ?>','<?php echo @$item['getContentsInfo']->subtitle ?>' ,'<?php echo @$item['getContentsInfo']->description ?>');" data-toggle="modal" data-target="#myModal">View</a></td>
			                                </tr>
			                               <?php $counter++; ?>
					                    @endforeach
		                               </tbody>
		                            </table>
		                        </div>
	                        </div>
	                        <div class="tab-pane" id="fav_song">
	                            <div class="fresh-datatables">
		                            <table id="datatables3" class="table table-striped table-no-bordered table-hover" >
		                            <thead>
		                                <tr>
		                                    <th>Id</th>
		                                    <th>Image</th>
		                                    <th>Title</th>
		                                    <th>Subtitle</th>
		                                    <th>Description</th>
		                                    <th>Fav Date</th>
		                                    <th>Action</th>
		                                </tr>
		                            </thead>
		                            <tbody>
		                                <?php $counter = 1; ?>
		                                @foreach($fav_songs as $item)
			                            <tr>
		                                	<td>{{ @$counter }}</td>
											<td>
												<?php
													$picture = Controller::getFilePath(@$item['getSongInfo']->image, 'songPic');
													if($picture) { ?>
														<img src="{{ $picture }}" class="img-circle">
														<?php
													}else{ ?>
														<img src="{{asset('public/uploads/images.jpg')}}" class="img-circle">
														<?php
													}
												?>
											</td>
			                                    
<td>{{ strlen(@$item['getSongInfo']->name) > 20 ? substr(@$item['getSongInfo']->name, 0, 20)."..." : @$item['getSongInfo']->name  }}</td>

<td>{{ strlen(@$item['getSongInfo']->subtitle) > 20 ? substr(@$item['getSongInfo']->subtitle, 0, 20)."..." : @$item['getSongInfo']->subtitle  }}</td>

<td>{{ strlen(@$item['getSongInfo']->description) > 20 ? substr(@$item['getSongInfo']->description, 0, 20)."..." : @$item['getSongInfo']->description  }}</td>

											<td>{{ $item['created_at']->format('Y-m-d H:i') }}</td>

<td><a href = "#" onclick="showDetails('<?php echo @$item['getSongInfo']->name; ?>','<?php echo @$item['getSongInfo']->subtitle ?>' ,'<?php echo @$item['getSongInfo']->description ?>');" data-toggle="modal" data-target="#myModal">View</a></td>
			                                </tr>
			                                <?php $counter++; ?>
					                    @endforeach
		                               </tbody>
		                            </table>
		                        </div>
	                        </div>
	                        
	                    </div>
                    </div> 
                </div>
            </div>
        </div> <!-- end row -->
    </div>
</div>
  
<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><center>Show Details</center></h4>
        </div>
        <div class="modal-body">
          	<div class="popup_section">
                <p> <label>Name  :</label>
                    <span id="name"></span>
                </p>
                <p> <label>Subtitle  :</label>
                    <span id="subtitle"></span>
                </p>
                <p> <label>Description  :</label>
                    <span id="description"></span>
                </p>
            </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
<!-- Modal -->
<script>
	function showDetails(name, subtitle, description) {
		$('#name').html(name);
		$('#subtitle').html(subtitle);
		$('#description').html(description);
	}
</script>

<!-- Modal -->
  <div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><center>Show Details</center></h4>
        </div>
        <div class="modal-body">
          	<div class="popup_section">
                <p> <label>Name  :</label>
                    <span id="name1"></span>
                </p>
                <p> <label>About  :</label>
                    <span id="about"></span>
                </p>
               
            </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
<!-- Modal -->
<script>
	function showArtistDetails(name, about) {
		$('#name1').html(name);
		$('#about').html(about);
	}

</script>



@endsection