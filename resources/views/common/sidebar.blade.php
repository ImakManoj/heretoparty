<div class="sidebar" data-background-color="brown" data-active-color="danger">
<!--
	Tip 1: you can change the color of the sidebar's background using: data-background-color="white | brown"
	Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
-->
	<div class="logo">
		<a href="{{ url('admin/dashboard/') }}" class="simple-text logo-mini">
		  <div class="photo">
                <img src="{{ asset('public/img/admin/logo50x50.png') }}" style="width: 50px;"/>
            </div>
		</a>

		<a href="{{ url('admin/dashboard/') }}" class="simple-text logo-normal">
			<div class="photo">
                <img src="{{ asset('public/img/admin/logo100x100.png') }}" style="width: 50px;" alt="Meditation"/>
            </div>
		</a>
	</div>
	<div class="sidebar-wrapper">
		<div class="user">
            <div class="info">
				<div class="photo">
                    <img src="{{ asset('public/img/admin/logo50x50.png') }}" />
                </div>

                <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                    <span>
						Meditation Admin
                        <!-- <b class="caret"></b> -->
					</span>
                </a>
				<div class="clearfix"></div>

                <!-- <div class="collapse" id="collapseExample">
                    <ul class="nav">
                        <li>
							<a href="#profile">
								<span class="sidebar-mini">Mp</span>
								<span class="sidebar-normal">My Profile</span>
							</a>
						</li>
                        <li>
							<a href="#edit">
								<span class="sidebar-mini">Ep</span>
								<span class="sidebar-normal">Edit Profile</span>
							</a>
						</li>
                        <li>
							<a href="#settings">
								<span class="sidebar-mini">S</span>
								<span class="sidebar-normal">Settings</span>
							</a>
						</li>
                    </ul>
                </div> -->
            </div>
        </div>
        <ul class="nav">
            <li class="<?php if(strtok(Route::currentRouteName(), '.' ) == 'dashboard'){ echo 'active' ; }?>">
                <a href="{{ url('admin/dashboard/') }}" aria-expanded="true">
                    <i class="ti-panel"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            <li class="<?php if(strtok(Route::currentRouteName(), '.' ) == 'users'){ echo 'active' ; }?>">
                <a href="{{ url('admin/users/') }}" aria-expanded="true">
                    <i class="ti-user"></i>
                    <p>Users</p>
                </a>
            </li>
              <li class="<?php if(strtok(Route::currentRouteName(), '.' ) == 'Voice'){ echo 'active' ; }?>">
                <a href="{{ url('admin/voicelist/') }}" aria-expanded="true">
                    <i class="ti-music-alt"></i>
                    <p>Voice</p>
                </a>
            </li>

						<li class="<?php if(strtok(Route::currentRouteName(), '.' ) == 'nature'){ echo 'active' ; }?>">
							<a href="{{ url('admin/nature/') }}" aria-expanded="true">
									<i class="ti-music-alt"></i>
									<p>Nature</p>
							</a>
					</li>

            <li class="<?php if(strtok(Route::currentRouteName(), '.' ) == 'albums'){ echo 'active' ; }?>">
                <a href="{{ url('admin/albums/') }}" aria-expanded="true">
                    <i class="ti-gallery"></i>
                    <p>Category</p>
                </a>
            </li>
            <li class="<?php if(strtok(Route::currentRouteName(), '.' ) == 'artists'){ echo 'active' ; }?>">
                <a href="{{ url('admin/artists/') }}" aria-expanded="true">
                    <i class="ti-headphone-alt"></i>
                    <p>Artists</p>
                </a>
            </li>
            <li class="<?php if(strtok(Route::currentRouteName(), '.' ) == 'playlists'){ echo 'active' ; }?>">
                <a href="{{ url('admin/playlists/') }}" aria-expanded="true">
                    <i class="ti-control-shuffle"></i>
                    <p>Playlists</p>
                </a>
            </li>
            <li class="<?php if(strtok(Route::currentRouteName(), '.' ) == 'tracks'){ echo 'active' ; }?>">
                <a href="{{ url('admin/tracks/') }}" aria-expanded="true">
                    <i class="ti-themify-favicon"></i>
                    <p>Genres</p>
                </a>
            </li>
            <li class="<?php if(strtok(Route::currentRouteName(), '.' ) == 'songs'){ echo 'active' ; }?>">
                <a href="{{ url('admin/songs/') }}" aria-expanded="true">
                    <i class="ti-music-alt"></i>
                    <p>Songs</p>
                </a>
            </li>

            <li class="<?php if(strtok(Route::currentRouteName(), '.' ) == 'featured_playlist'){ echo 'active' ; }?>">
                <a href="{{ url('admin/featured_playlist/') }}" aria-expanded="true">
                    <i class="ti-rss"></i>
                    <p>Featured Playlist</p>
                </a>
            </li>

            <li class="<?php if(strtok(Route::currentRouteName(), '.' ) == 'banner'){ echo 'active' ; }?>">
                <a href="{{ url('admin/banner/') }}" aria-expanded="true">
                    <i class="ti-layers-alt"></i>
                    <p>Banner</p>
                </a>
            </li>

            <li class="<?php if(strtok(Route::currentRouteName(), '.' ) == 'help_pages'){ echo 'active' ; }?>">
                <a href="{{ url('admin/help_pages/') }}" aria-expanded="true">
                    <i class="ti-layers-alt"></i>
                    <p>Pages</p>
                </a>
            </li>


			<!-- <li class="<?php if(strtok(Route::currentRouteName(), '.' ) == 'verbs'){ echo 'active' ; }?>">
				<a href="{{ url('admin/verbs/') }}" aria-expanded="true">
                    <i class="ti-server"></i>
                    <p>
						Verb
                    </p>
                </a> -->
                <!-- <div class="collapse" id="pagesExamples">
					<ul class="nav">
						<li>
							<a href="">
								<span class="sidebar-mini">S</span>
								<span class="sidebar-normal">Show</span>
							</a>
						</li>
						<li>
							<a href="">
								<span class="sidebar-mini">C</span>
								<span class="sidebar-normal">Create</span>
							</a>
						</li>
                    </ul>
                </div> -->
            <!-- </li> -->

            <!-- <li class="<?php if(strtok(Route::currentRouteName(), '.' ) == 'statements'){ echo 'active' ; }?>">
                <a href="{{ url('admin/statements/') }}" aria-expanded="true">
                    <i class="ti-book"></i>
                    <p>Statements</p>
                </a>
            </li> -->

             <!-- <li class="<?php if(strtok(Route::currentRouteName(), '.' ) == 'payment'){ echo 'active' ; }?>">
                <a href="{{ url('admin/payment/') }}" aria-expanded="true">
                    <i class="ti-book"></i>
                    <p>Payment History</p>
                </a>
            </li>

            <li class="<?php if(strtok(Route::currentRouteName(), '.' ) == 'blogs'){ echo 'active' ; }?>">
                <a href="{{ url('admin/blogs/') }}" aria-expanded="true">
                    <i class="ti-comment"></i>
                    <p>Blogs</p>
                </a>
            </li> -->
        </ul>
	</div>
</div>
