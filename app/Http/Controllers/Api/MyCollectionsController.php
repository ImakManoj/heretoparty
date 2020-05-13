<?php

namespace App\Http\Controllers\Api;

use App\Banner;
use App\Content;
use App\Favourite;
use App\FeaturedPlaylist;
use App\Http\Controllers\Controller;
use App\Song;
use App\Stats;
use App\User;
use App\Playlist;
use App\UserPlaylist;
use Illuminate\Http\Request;
use Input;
use Response;
use DB;
class MyCollectionsController extends Controller {

	/**
	 * Get My Playlist
	 *
	 * @param  user_id
	 * @return response
	 */
	public function getPlaylist(Request $request) {

		$this->validation($request->all(), [
			"user_id" => "required",
		]);

		$userinfo = User::where('id', $request->input('user_id'))->first();

		if (empty($userinfo)) {
			$this->error('User does not exist.', []);
		}

		//1=> artist, 2=> album, 3=> playlist, 4=> track

		$my_playlist = $this->getUserPlaylists($request->input('user_id'), 10);

		$favourite_playlist = $this->getFavouriteContents($request->input('user_id'), 3, 10);

		$response = [];
		$response['my_playlist'] = $my_playlist;
		$response['favourite_playlist'] = $favourite_playlist;

		if ($response) {
			$this->success('record found.', $response);
		} else {
			$this->error('record not fount', []);
		}
	}

	/**
	 * Get my albums
	 * 1=> artist, 2=> album, 3=> playlist, 4=> track
	 * @param  user_id
	 * @return response
	 */
	public function getAlbums(Request $request) {

		$this->validation($request->all(), [
			"user_id" => "required",
		]);

		$userinfo = User::where('id', $request->input('user_id'))->first();

		if (empty($userinfo)) {
			$this->error('User does not exist.', []);
		}

		//1=> artist, 2=> album, 3=> playlist, 4=> track

		$favourite_albums = $this->getFavouriteContents($request->input('user_id'), 2, 10);

		$response = [];
		$response = $favourite_albums;

		if ($response) {
			$this->success('record found.', $response);
		} else {
			$this->error('record not fount', []);
		}
	}

	/**
	 * Get my artists
	 * 1=> artist, 2=> album, 3=> playlist, 4=> track
	 * @param  user_id
	 * @return response
	 */
	public function getArtists(Request $request) {

		$this->validation($request->all(), [
			"user_id" => "required",
		]);

		$userinfo = User::where('id', $request->input('user_id'))->first();

		if (empty($userinfo)) {
			$this->error('User does not exist.', []);
		}

		//1=> artist, 2=> album, 3=> playlist, 4=> track

		$favourite_artists = $this->getFavouriteContents($request->input('user_id'), 1, 10);

		$response = [];
		$response = $favourite_artists;

		if ($response) {
			$this->success('record found.', $response);
		} else {
			$this->error('record not fount', []);
		}
	}

	/**
	 * Get my songs
	 * 1=> artist, 2=> album, 3=> playlist, 4=> track
	 * @param  user_id
	 * @return response
	 */
	public function getSongs(Request $request) {

		$this->validation($request->all(), [
			"user_id" => "required",
		]);

		$userinfo = User::where('id', $request->input('user_id'))->first();

		if (empty($userinfo)) {
			$this->error('User does not exist.', []);
		}

		//1=> artist, 2=> album, 3=> playlist, 4=> track

		$take = 10;
		$results = Favourite::where(['user_id' => $request->input('user_id'), 'type'=>4, 'status'=>1])->with('getSongInfo')->orderBy('id', 'DESC')->take($take)->get();
		$response = [];
		if ($results) {
			foreach ($results as $key => $value) {
				$file_path = $this->getPath(4);
				$response[] = [
					'id' => $value->id,
					'content_id' => $value->fav_id,
					'status' => $value->status,
					'type' => $value->type,
					'name' => (string) @$value['getSongInfo']['name'],
					'subtitle' => (string) @$value['getSongInfo']['subtitle'],
					'description' => (string) @$value['getSongInfo']['description'],
					'is_favourite' => $this->isFavourite($request->input('user_id'), $value->fav_id, 4),
					'song_image' => $this->getFilePath(@$value['getSongInfo']->image, 'songPic'),
					'song_url' => $this->getFilePath(@$value['getSongInfo']->song, 'songs'),
					'created_at' => @date('Y-m-d H:i:s', strtotime(@$value['getSongInfo']->created_at)),
					'contents' => $this->getContentsDetails($request->input('user_id'), @$value['getSongInfo']->id),
				];
			}
		}

		if ($response) {
			$this->success('record found.', $response);
		} else {
			$this->error('record not fount', []);
		}
	}

	/**
	 * Get user playlist
	 *
	 * @param  user_id
	 * @return response
	 */
	public function getUserPlaylists($user_id = '', $take = 5) {

		$results = UserPlaylist::where(['user_id' => $user_id])->orderBy('id', 'DESC')->take($take)->get();
		$response = [];
		foreach ($results as $key => $value) {
			$response[] = [
				'id' => $value->id,
				'name' => $value->name,
				'description' => $value->description,
				'created_date' => date('Y-m-d', strtotime(@$value->created_at)),
			];
		}
		return $response;
	}

	/**
	 * check Favourite
	 *
	 * @param  type 1=> artist, 2=> album, 3=> playlist, 4=> song
	 * @return response
	 */
	public function getFavouriteContents($user_id = '', $type = '3', $take = 5) {

		$results = Favourite::where(['user_id' => $user_id, 'type'=>$type, 'status'=>1])->where('type', '<>', '4')->with('getContentsInfo')->orderBy('id', 'DESC')->take($take)->get();
		$response = [];
		if ($results) {
			foreach ($results as $key => $value) {
				if (!empty($value['getContentsInfo'])) {
					$file_path = $this->getPath($value['getContentsInfo']->cat_id);
					$response[] = [
						'id' => $value->id,
						'content_id' => $value->fav_id,
						'status' => $value->status,
						'type' => $value->type,
						'name' => $value['getContentsInfo']->name,
						'subtitle' => $value['getContentsInfo']->subtitle,
						'description' => $value['getContentsInfo']->description,
						'file_image' => $this->getFilePath($value['getContentsInfo']->image, $file_path),
					];
				}
			}
		}
		return $response;
	}

	/**
	 * Create User Playlist
	 *
	 * @param  user_id
	 * @return response
	 */
	public function createPlaylist(Request $request) {
		$this->validation($request->all(), [
			"user_id" => "required",
			"name" => "required",
		]);

		$userinfo = User::where('id', $request->input('user_id'))->first();

		if (empty($userinfo)) {
			$this->error('User does not exist.', []);
		}

		$data = [
			'user_id'		 => $request->input('user_id'),
			'name' 			 => strtolower($request->input('name')),
			'description' 	 => strtolower(@$request->input('description')),
		];

		if ($save = UserPlaylist::create($data)) {

			$response['playlist_id'] = (string) $save->id;
			$this->success('Playlist created successfully.', $response);
		} else {

			$this->error('Something went wrong.', null);
		}

	}

	/**
	 * Create User Playlist
	 *
	 * @param  user_id
	 * @return response
	 */
	public function getMyPlaylist(Request $request) {
		$this->validation($request->all(), [
			"user_id" => "required",
		]);

		$userinfo = User::where('id', $request->input('user_id'))->first();

		if (empty($userinfo)) {
			$this->error('User does not exist.', []);
		}

		$data = [];
		$response = [];
		$data = UserPlaylist::where(['user_id'=>$request->input('user_id')])->orderBy('id', 'DESC')->get();
		foreach ($data as $key => $value) {
			$response[] = [
				'id' => $value->id,
				'user_id' => $value->user_id,
				'name' => $value->name,
				'description' => $value->description,
			];
		}

		if ($response) {

			$this->success('success.', $response);
		} else {

			$this->error('record not found.', []);
		}

	}

	/**
	 * Create User Playlist
	 *
	 * @param  user_id
	 * @return response
	 */
	public function addSongPlaylist(Request $request) {
		$this->validation($request->all(), [
			"user_id" => "required",
			"playlist_id" => "required",
			"song_id" => "required",
		]);

		$userinfo = User::where('id', $request->input('user_id'))->first();

		if (empty($userinfo)) {
			$this->error('User does not exist.', '');
		}

		$check_playlsit = UserPlaylist::where('id', $request->input('playlist_id'))->first();

		if (empty($check_playlsit)) {
			$this->error('Playlist is not exist.', '');
		}

		$check_already = Playlist::where(['user_id' => $request->input('user_id'), 'playlist_id' => $request->input('playlist_id'),	'song_id' => $request->input('song_id'),])->first();

		if (empty($check_already)) {
			$data = [
				'user_id'		 => $request->input('user_id'),
				'playlist_id'		 => $request->input('playlist_id'),
				'song_id'		 => $request->input('song_id'),
			];

			if ($save = Playlist::create($data)) {

				$this->success('success.', '');
			} else {

				$this->error('Something went wrong.', null);
			}
		}else{
			$this->error('This song is already added.', null);
		}

		

	}

	/**
	 * Get All Tracks
	 *
	 * @param  user_id
	 * @return response
	 */
	public function getMyPlaylistSong(Request $request) {

		$this->validation($request->all(), [
			"user_id" => "required",
			"playlist_id" => "required",

		]);

		$userinfo = User::where('id', $request->input('user_id'))->first();

		if (empty($userinfo)) {
			$this->error('User does not exist.', '');
		}

		$take = 20;
		$results = Playlist::where(['user_id'=>$request->input('user_id'), 'playlist_id'=> $request->input('playlist_id')])->orderBy('id', 'DESC')->with('getPlaylistInfo', 'getSongInfo')->take($take)->get();
		//echo '<pre>'; print_r($results); die;
		$response = [];
		foreach ($results as $key => $value) {
			$response[] = [
				'song_id' => $value['getSongInfo']->id,
				'name' => (string) @$value['getSongInfo']->name,
				'playlist_id' => (int) @$value['getPlaylistInfo']->id,
				'playlist_name' => (string) @$value['getPlaylistInfo']->name,
				'playlist_description' => (string) @$value['getPlaylistInfo']->description,

				'subtitle' => (string) @$value['getSongInfo']->subtitle,
				'description' => (string) @$value['getSongInfo']->description,
				'song_image' => $this->getFilePath($value['getSongInfo']->image, 'songPic'),
				'song_url' => $this->getFilePath($value['getSongInfo']->song, 'songs'),
				'duration' => $value['getSongInfo']->duration,
				'is_favourite' => $this->isFavourite($request->input('user_id'), $value['getSongInfo']->id, 4),
				'created_at' => date('Y-m-d H:i:s', strtotime($value['getSongInfo']->created_at)),
				'contents' => $this->getContentsDetails($request->input('user_id'), $value['getSongInfo']->content_id),
			];
		}
		if ($response) {
			$this->success('record found.', $response);
		} else {
			$this->error('record not found.', []);
		}
	}


	/**
	 * Create User Playlist
	 *
	 * @param  user_id
	 * @return response
	 */
	public function addStats(Request $request) {
		$this->validation($request->all(), [
			"user_id" => "required",
			"song_id" => "required",
		]);

		$userinfo = User::where(['id'=> $request->input('user_id')])->first();

		if (empty($userinfo)) {
			$this->error('User does not exist.', '');
		}

		$song_info = Song::where(['id'=> $request->input('song_id')])->first();

		if (empty($userinfo)) {
			$this->error('Song id does not exist.', '');
		}

		$get_data = Stats::where(['user_id'=> $request->input('user_id'), 'song_id'=> $request->input('song_id')])->first();
		if (!empty($get_data)) {
			$play_counts = (int) @$get_data->play_count;
			$play_counts = $play_counts + 1;

			$get_data->play_count = (int) @$play_counts;

			//for song table
			$song_stats = (int) @$song_info->stats;
			$song_info->stats = @$song_stats + 1;

			@$song_info->save();


			if ($get_data->save()) {
				$this->success('success', '');
			}else{
				$this->error('Something went wrong.', '');
			}

		}else{
			$data = [
				'user_id' => $request->input('user_id'),
				'song_id' => $request->input('song_id'),
				'play_count' => 1,
			];

			$insert = Stats::create($data);

			//for song table
			$song_stats = (int) @$song_info->stats;
			$song_info->stats = 1;
			@$song_info->save();

			if ($insert) {
				$this->success('success', '');
			}else{
				$this->error('Something went wrong.', '');
			}
		}

	}

	/**
	 * Search all data
	 *
	 * @param  type 1=> artist, 2=> album, 3=> playlist, 4=> song
	 * @param  user_id
	 * @return response
	 */
	public function searchAllData(Request $request) {
		$this->validation($request->all(), [
			"user_id" => "required",
		]);

		$per_page = 5;

	    if ($request->input('page') == "") {
	        $skip = 0;
	    } else {
	        $skip = $per_page * $request->input('page');
	    }

	    if ($request->input('page') == '') {
			$take = 5;
	    }else{
			$take = @$request->input('take');
	    }

	    $final_response = [];
	    //search data for artist
		$artist_data = Content::where(['cat_id'=> 1, 'status'=> 1])->where('cat_id', '<>', 4);
		if (!empty($request->input('search_key'))) {
			$key = $request->input('search_key');
			$artist_data->where(function($query) use ($key) {
			    $query->where('name', 'LIKE', '%'.$key.'%')
			        ->orWhere('subtitle', 'LIKE', '%'.$key.'%')
			        ->orWhere('description', 'LIKE', '%'.$key.'%');
			});
		}

		$artist_data = $artist_data->take($take)->inRandomOrder()->get();
		$artist_response = [];

		foreach ($artist_data as $key => $value) {
			$artist_response[] = [
				'id' => $value->id,
				'name' => (string) @$value->name,
				'subtitle' => (string) @$value->subtitle,
				'description' => (string) @$value->description,
				'file_image' => $this->getFilePath($value->image, 'artists'),
				'is_favourite' => $this->isFavourite($request->input('user_id'), $value->id, 1),
				'created_at' => date('Y-m-d H:i:s', strtotime($value->created_at)),
			];
		}

		//search data for album
		$album_data = Content::where(['cat_id'=> 2, 'status'=> 1])->where('cat_id', '<>', 4);
		if (!empty($request->input('search_key'))) {
			$key = $request->input('search_key');
			$album_data->where(function($query) use ($key) {
			    $query->where('name', 'LIKE', '%'.$key.'%')
			        ->orWhere('subtitle', 'LIKE', '%'.$key.'%')
			        ->orWhere('description', 'LIKE', '%'.$key.'%');
			});
		}

		$album_data = $album_data->take($take)->inRandomOrder()->get();
		$album_response = [];
		foreach ($album_data as $key1 => $value1) {
			$album_response[] = [
				'id' => $value1->id,
				'category_id' => $value1->cat_id,
				'name' => (string) @$value1->name,
				'subtitle' => (string) @$value1->subtitle,
				'description' => (string) @$value1->description,
				'file_image' => $this->getFilePath($value1->image, 'album'),
				'is_favourite' => $this->isFavourite($request->input('user_id'), $value1->id, 2),
				'created_at' => date('Y-m-d H:i:s', strtotime($value1->created_at)),
			];
		}
		//search data for playlist
		$playlist_data = Content::where(['cat_id'=> 3, 'status'=> 1])->where('cat_id', '<>', 4);
		if (!empty($request->input('search_key'))) {
			$key = $request->input('search_key');
			$playlist_data->where(function($query) use ($key) {
			    $query->where('name', 'LIKE', '%'.$key.'%')
			        ->orWhere('subtitle', 'LIKE', '%'.$key.'%')
			        ->orWhere('description', 'LIKE', '%'.$key.'%');
			});
		}

		$playlist_data = $playlist_data->take($take)->inRandomOrder()->get();
		$playlist_response = [];
		foreach ($playlist_data as $key => $value) {
			$playlist_response[] = [
				'id' => $value->id,
				'name' => (string) @$value->name,
				'subtitle' => (string) @$value->subtitle,
				'description' => (string) @$value->description,
				'file_image' => $this->getFilePath($value->image, 'playlists'),
				'is_favourite' => $this->isFavourite($request->input('user_id'), $value->id, 3),
				'created_at' => date('Y-m-d H:i:s', strtotime($value->created_at)),
			];
		}

		//search data for song
		$song_data = Song::where('status', 1);
		if (!empty($request->input('search_key'))) {
			$key = $request->input('search_key');
			$song_data->where(function($query) use ($key) {
			    $query->where('name', 'LIKE', '%'.$key.'%')
			        ->orWhere('subtitle', 'LIKE', '%'.$key.'%')
			        ->orWhere('description', 'LIKE', '%'.$key.'%');
			});
		}
		$song_data = $song_data->take($take)->inRandomOrder()->get();
		$song_response = [];
		foreach ($song_data as $key => $value) {
			$song_response[] = [
				'song_id' => $value->id,
				'name' => (string) @$value->name,
				'subtitle' => (string) @$value->subtitle,
				'description' => (string) @$value->description,
				'song_image' => $this->getFilePath($value->image, 'songPic'),
				'song_url' => $this->getFilePath($value->song, 'songs'),
				'duration' => $value->duration,
				'is_favourite' => $this->isFavourite($request->input('user_id'), $value->id, 4),
				'created_at' => date('Y-m-d H:i:s', strtotime($value->created_at)),
				'contents' => $this->getContentsDetails($request->input('user_id'), $value->content_id),
			];
		}

		$final_response['artist_response'] 		= $artist_response;
		$final_response['album_response'] 		= $album_response;
		$final_response['playlist_response'] 	= $playlist_response;
		$final_response['song_response'] 		= $song_response;

		if ($final_response) {
			$this->success('record found.', $final_response);
		} else {
			$this->error('record not fount', []);
		}
	}

	/**
	 * Search all data
	 *
	 * @param  type 1=> artist, 2=> album, 3=> playlist, 4=> song
	 * @param  user_id
	 * @return response
	 */
	public function searchViewAll(Request $request) {
		$this->validation($request->all(), [
			"user_id" => "required",
			"search_type" => "required",
		]);

		$per_page = 10;

	    if ($request->input('page') == "") {
	        $skip = 0;
	    } else {
	        $skip = $per_page * $request->input('page');
	    }

	    if ($request->input('page') == '') {
			$take = 10;
	    }else{
			$take = ( (int) @$request->input('page') + 1) * 10;
	    }

	    $response = [];

	    if ($request->input('search_type') == 1 || $request->input('search_type') == 2 || $request->input('search_type') == 3){
	    	$response = [];
		    //search data for contents
			$data = Content::where(['cat_id'=> $request->input('search_type'), 'status'=> 1])->where('cat_id', '<>', 4);
			if (!empty($request->input('search_key'))) {
				$key = $request->input('search_key');
				$data->where(function($query) use ($key) {
				    $query->where('name', 'LIKE', '%'.$key.'%')
				        ->orWhere('subtitle', 'LIKE', '%'.$key.'%')
				        ->orWhere('description', 'LIKE', '%'.$key.'%');
				});
			}

			$data = $data->take($take)->skip($skip)->take($take)->inRandomOrder()->get();

			foreach ($data as $key => $value) {
				$file_path = $this->getPath($value->cat_id);
				$response[] = [
					'id' => $value->id,
					'cat_id' => $value->cat_id,
					'name' => (string) @$value->name,
					'subtitle' => (string) @$value->subtitle,
					'description' => (string) @$value->description,
					'file_image' => $this->getFilePath($value->image, $file_path),
					'is_favourite' => $this->isFavourite($request->input('user_id'), $value->id, $value->cat_id),
					'created_at' => date('Y-m-d H:i:s', strtotime($value->created_at)),
				];
			}
	    }

	    if ($request->input('search_type') == 4){
	    	$response = [];
		    //search data for song
			$data = Song::where('status', 1);
			if (!empty($request->input('search_key'))) {
				$key = $request->input('search_key');
				$data->where(function($query) use ($key) {
				    $query->where('name', 'LIKE', '%'.$key.'%')
				        ->orWhere('subtitle', 'LIKE', '%'.$key.'%')
				        ->orWhere('description', 'LIKE', '%'.$key.'%');
				});
			}
			$data = $data->take($take)->skip($skip)->take($take)->inRandomOrder()->get();
			$song_response = [];
			foreach ($data as $key => $value) {
				$response[] = [
					'song_id' => $value->id,
					'name' => (string) @$value->name,
					'subtitle' => (string) @$value->subtitle,
					'description' => (string) @$value->description,
					'song_image' => $this->getFilePath($value->image, 'songPic'),
					'song_url' => $this->getFilePath($value->song, 'songs'),
					'duration' => $value->duration,
					'is_favourite' => $this->isFavourite($request->input('user_id'), $value->id, 4),
					'created_at' => date('Y-m-d H:i:s', strtotime($value->created_at)),
					'contents' => $this->getContentsDetails($request->input('user_id'), $value->content_id),
				];
			}
	    }
	    	

		if ($response) {
			$this->success('record found.', $response);
		} else {
			$this->error('record not fount', []);
		}
	}

	/**
	 * get contents data acording to category
	 *
	 * @param  user_id, category_id, take
	 * @param  Reference of category: 1=> artist, 2=> album, 3=> playlist, 4=> songs
	 * @return response
	 */
	public function getContentsData($user_id = '', $category_id = 1, $take = 5) {

		$file_path = $this->getPath($category_id);
		$results = Content::where(['cat_id' => $category_id])->orderBy('id', 'DESC')->take($take)->get();
		$response = [];
		foreach ($results as $key => $value) {
			$response[] = [
				'id' => $value->id,
				'category_id' => $value->cat_id,
				'name' => (string) $value->name,
				'subtitle' => (string) $value->subtitle,
				'description' => (string) $value->description,
				'file_image' => $this->getFilePath($value->image, $file_path),
				'is_favourite' => $this->isFavourite($user_id, $value->id, $category_id),
				'created_at' => date('Y-m-d H:i:s', strtotime($value->created_at)),
			];
		}
		return $response;
	}

	/**
	 * get contents data acording to category
	 *
	 * @param  user_id, category_id, take
	 * @param  Reference of category: 1=> artist, 2=> album, 3=> playlist, 4=> songs
	 * @return response
	 */
	public function getBannerData($user_id = '', $category_id = 1, $take = 5) {

		$file_path = $this->getPath($category_id);
		$results = Banner::where(['status' => 1])->with('getPlaylistInfo')->orderBy('id', 'DESC')->take($take)->get();
		$response = [];
		foreach ($results as $key => $value) {
			$response[] = [
				'id' => $value->id,
				'content_id' => $value->content_id,
				'name' => $value['getPlaylistInfo']->name,
				'subtitle' => $value['getPlaylistInfo']->subtitle,
				'description' => $value['getPlaylistInfo']->description,
				'file_image' => $this->getFilePath($value['getPlaylistInfo']->image, $file_path),
				'is_favourite' => 0,
				'created_at' => date('Y-m-d H:i:s', strtotime($value['getPlaylistInfo']->created_at)),
			];
		}
		return $response;
	}

	/**
	 * get contents data acording to category
	 *
	 * @param  user_id, category_id, take
	 * @param  Reference of category: 1=> artist, 2=> album, 3=> playlist, 4=> songs
	 * @return response
	 */
	public function getFeaturedPlaylistData($user_id = '', $category_id = 1, $take = 5) {

		$file_path = $this->getPath($category_id);
		$results = FeaturedPlaylist::where(['status' => 1])->with('getPlaylistInfo')->orderBy('id', 'DESC')->take($take)->get();
		$response = [];
		foreach ($results as $key => $value) {
			$response[] = [
				'id' => $value->id,
				'content_id' => $value->content_id,
				'name' => $value['getPlaylistInfo']->name,
				'subtitle' => $value['getPlaylistInfo']->subtitle,
				'description' => $value['getPlaylistInfo']->description,
				'file_image' => $this->getFilePath($value['getPlaylistInfo']->image, $file_path),
				'is_favourite' => 0,
				'created_at' => date('Y-m-d H:i:s', strtotime($value['getPlaylistInfo']->created_at)),
			];
		}
		return $response;
	}

	public function getPath($id = '') {
		if ($id == 1) {

			$file_path = 'artists';
		} elseif ($id == 2) {

			$file_path = 'albums';
		} elseif ($id == 3) {

			$file_path = 'playlists';
		} elseif ($id == 4) {

			$file_path = 'tracks';
		}
		return $file_path;
	}

	/**
	 * get contents data acording to category
	 *
	 * @param  user_id, category_id, take
	 * @param  Reference of category: 1=> artist, 2=> album, 3=> playlist, 4=> track
	 * @return response
	 */
	public function getSongData($user_id = '', $category_id = 1, $take = 5) {

		$results = Song::where(['status' => 1])->orderBy('id', 'DESC')->take($take)->get();
		$response = [];
		foreach ($results as $key => $value) {
			$response[] = [
				'song_id' => $value->id,
				'name' => $value->name,
				'subtitle' => $value->subtitle,
				'description' => $value->description,
				'song_image' => $this->getFilePath($value->image, 'songPic'),
				'song_url' => $this->getFilePath($value->song, 'songs'),
				'duration' => $value->duration,
				'is_favourite' => $this->isFavourite($user_id, $value->id, 4),
				'created_at' => date('Y-m-d H:i:s', strtotime($value->created_at)),
				'contents' => $this->getContentsDetails($user_id, $value->content_id),
			];
		}
		return $response;
	}

	/**
	 * get contents data acording to category
	 *
	 * @param  user_id, category_id, take
	 * @param  Reference of category: 1=> artist, 2=> album, 3=> playlist, 4=> track
	 * @return response
	 */
	public function getSongById($user_id = '', $song_id = 1, $take = 5) {

		$results = Song::where(['id'=> $song_id, 'status' => 1])->orderBy('id', 'DESC')->first();
		$response = [];
			$response = [
				'song_id' => $results->id,
				'name' => $results->name,
				'subtitle' => $results->subtitle,
				'description' => $results->description,
				'song_image' => $this->getFilePath($results->image, 'songPic'),
				'song_url' => $this->getFilePath($results->song, 'songs'),
				'duration' => $results->duration,
				'is_favourite' => $this->isFavourite($user_id, $results->id, 4),
				'created_at' => date('Y-m-d H:i:s', strtotime($results->created_at)),
				'contents' => $this->getContentsDetails($user_id, $results->content_id),
			];
		return $response;
	}

	/**
	 * get contents details acording to contents it
	 *
	 * @param  user_id, category_id, take
	 * @param  Reference of category: 1=> artist, 2=> album, 3=> playlist, 4=> track
	 * @return response
	 */
	public function getContentsDetails($user_id = '', $contents_ids = 1, $take = 5) {
		if (!empty($contents_ids)) {
			$content_ids = explode(',', $contents_ids);
		}
		$results = Content::whereIn('id', $content_ids)->orderBy('id', 'DESC')->get();
		// dd($results);
		$response = [];
		$response_artist = [];
		$response_album = [];
		$response_playlist = [];
		$response_genre = [];
		foreach ($results as $key => $value) {
			if ($value->cat_id == 1) {
				$response_artist[] = [
					'id' => $value->id,
					'name' => $value->name,
					'subtitle' => $value->subtitle,
					'description' => $value->description,
					'file_image' => $this->getFilePath($value->image, 'artists'),
					'is_favourite' => $this->isFavourite($user_id, $value->id, 1),
					'created_at' => date('Y-m-d H:i:s', strtotime($value->created_at)),
				];
			} elseif ($value->cat_id == 2) {
				$response_album[] = [
					'id' => $value->id,
					'name' => $value->name,
					'subtitle' => $value->subtitle,
					'description' => $value->description,
					'file_image' => $this->getFilePath($value->image, 'albums'),
					'is_favourite' => $this->isFavourite($user_id, $value->id, 2),
					'created_at' => date('Y-m-d H:i:s', strtotime($value->created_at)),
				];
			} elseif ($value->cat_id == 3) {
				$response_playlist[] = [
					'id' => $value->id,
					'name' => $value->name,
					'subtitle' => $value->subtitle,
					'description' => $value->description,
					'file_image' => $this->getFilePath($value->image, 'playlists'),
					'is_favourite' => $this->isFavourite($user_id, $value->id, 3),
					'created_at' => date('Y-m-d H:i:s', strtotime($value->created_at)),
				];
			} elseif ($value->cat_id == 4) {
				$response_genre[] = [
					'id' => $value->id,
					'name' => $value->name,
					'subtitle' => $value->subtitle,
					'description' => $value->description,
					'file_image' => $this->getFilePath($value->image, 'tracks'),
					'is_favourite' => 0, //it will not favourite
					'created_at' => date('Y-m-d H:i:s', strtotime($value->created_at)),
				];
			}

		}

		$response['artist'] = $response_artist;
		$response['album'] = $response_album;
		$response['playlist'] = $response_playlist;
		$response['genre'] = $response_genre;

		return $response;
	}

	/**
	 * Get All Songs
	 *
	 * @param  user_id
	 * @return response
	 */
	public function getAllSongs(Request $request) {

		$this->validation($request->all(), [
			"user_id" => "required",
		]);

		$take = 20;
		$results = Song::where(['status' => 1])->orderBy('id', 'DESC')->take($take)->get();
		$response = [];
		foreach ($results as $key => $value) {
			$response[] = [
				'song_id' => $value->id,
				'name' => $value->name,
				'subtitle' => $value->subtitle,
				'description' => $value->description,
				'song_image' => $this->getFilePath($value->image, 'songPic'),
				'song_url' => $this->getFilePath($value->song, 'songs'),
				'duration' => $value->duration,
				'is_favourite' => $this->isFavourite($request->input('user_id'), $value->id, 4),
				'created_at' => date('Y-m-d H:i:s', strtotime($value->created_at)),
				'contents' => $this->getContentsDetails($request->input('user_id'), $value->content_id),
			];
		}
		if ($response) {
			$this->success('record found.', $response);
		} else {
			$this->error('record not found.', []);
		}
	}

	/**
	 * Get All Tracks
	 *
	 * @param  user_id
	 * @return response
	 */
	public function getSongsByGroup(Request $request) {

		$this->validation($request->all(), [
			"user_id" => "required",
			"content_id" => "required",
		]);

		$take = 20;
		$results = Song::whereRaw('FIND_IN_SET("' . $request->input('content_id') . '", content_id)')->orderBy('id', 'DESC')->take($take)->get();
		$response = [];
		foreach ($results as $key => $value) {
			$response[] = [
				'song_id' => $value->id,
				'name' => $value->name,
				'subtitle' => $value->subtitle,
				'description' => $value->description,
				'song_image' => $this->getFilePath($value->image, 'songPic'),
				'song_url' => $this->getFilePath($value->song, 'songs'),
				'duration' => $value->duration,
				'is_favourite' => $this->isFavourite($request->input('user_id'), $value->id, 4),
				'created_at' => date('Y-m-d H:i:s', strtotime($value->created_at)),
				'contents' => $this->getContentsDetails($request->input('user_id'), $value->content_id),
			];
		}
		if ($response) {
			$this->success('record found.', $response);
		} else {
			$this->error('record not found.', []);
		}
	}

	/**
	 * get contents info
	 *
	 * @param  user_id, category_id, take
	 * @param  Reference of category: 1=> artist, 2=> album, 3=> playlist, 4=> genre
	 * @return response
	 */
	public function getContentsInfo(Request $request) {
		$this->validation($request->all(), [
			"user_id" => "required",
			"type_id" => "required",
		]);
		$take = 5;
		$response = [];
		$response = $this->getContentsData($request->input('user_id'), $request->input('type_id'), $take);
		if ($response) {
			$this->success('record found.', $response);
		} else {
			$this->error('record not found.');
		}

	}

	/**
	 * Add fa
	 *
	 * @param  user_id
	 * @return response
	 * @return type 1=> artist, 2=> album, 3=> playlist, 4=> song
	 */
	public function addFavourite(Request $request) {
		$this->validation($request->all(), [
			"user_id" => "required",
			"type" => "required",
			"fav_id" => "required",
		]);

		$check_favourite = Favourite::where(['user_id' => $request->input('user_id'), 'type' => $request->input('type'), 'fav_id' => $request->input('fav_id')])->first();

		if (!empty($check_favourite)) {
			if ($check_favourite->status == 1) {
				$status = 0;
			} else {
				$status = 1;
			}
			$store_data = Favourite::where(['user_id' => $request->input('user_id'), 'type' => $request->input('type'), 'fav_id' => $request->input('fav_id')])->update(['status' => $status]);
		} else {
			$data = ['user_id' => $request->input('user_id'), 'type' => $request->input('type'), 'fav_id' => $request->input('fav_id'), 'status' => 1];
			$store_data = Favourite::insert($data);
		}

		if (@$store_data) {
			$response = [];
			$response['is_favourite'] = $store_data->is_favourite;
			$this->success('success', $response);
		} else {
			$this->error('Something went wrong.');
		}

	}

	/**
	 * check Favourite
	 *
	 * @param  type 1=> artist, 2=> album, 3=> playlist, 4=> song
	 * @return response
	 */
	public function isFavourite($user_id = '', $fav_id = '', $type_id = '') {
		$result = Favourite::where(['user_id' => $user_id, 'type' => $type_id, 'fav_id' => $fav_id])->first();
		return (int) @$result['status'];
	}

	/**
	 * Get User All Playlists
	 *
	 * @param  user_id
	 * @return response
	 */
	public function getPlaylists(Request $request) {
		$this->validation($request->all(), [
			"user_id" => "required",
		]);

		$userinfo = User::where('id', $request->input('user_id'))->first();

		if ($userinfo) {

			$playlists = UserPlaylist::where('user_id', $request->input('user_id'))->get();

			if (count($playlists) > 0) {
				$this->success('All Playlist.', $playlists);
			} else {
				$this->error('Playlist does not exist.', []);
			}
		} else {
			$this->error('User does not exist.', []);
		}
	}


	//get user profile using from user_id
	public function getUserProfile($user_id = '') {
		$userinfo = User::where('id', $user_id)->first();
		$picture = "";
		if ($userinfo) {
			if (strstr($userinfo->profile, 'https://')) {
				$picture = $userinfo->profile;
			} elseif (!empty($userinfo->profile)) {
				$picture = Controller::getFilePath($userinfo->profile, 'users');
				// $picture = URL::to('/uploads/users/').'/'.$userinfo->profile;
			}
		}
		return $picture;
	}

	/**
	 * Get All Tracks of an Artist
	 *
	 * @param  user_id
	 * @return response
	 */
	public function getTracksByArtist(Request $request) {
		$artist = Content::where('id', $request->input('artist_id'))->first();

		if ($artist) {
			$tracks = Song::where(['cat_id' => '1', 'content_id' => $request->input('artist_id'), 'status' => '1'])->orderBy('id', 'DESC')->get();

			if (count($tracks) > 0) {
				foreach ($tracks as $key => $value) {

					$artist_id = $album_id = $playlist_id = $artist = $album = $playlist = "";

					$artist_id = Song::where(['group_id' => $value->group_id, 'cat_id' => '1'])->pluck('content_id')->first();

					$album_id = Song::where(['group_id' => $value->group_id, 'cat_id' => '2'])->pluck('content_id')->first();

					$playlist_id = Song::where(['group_id' => $value->group_id, 'cat_id' => '3'])->pluck('content_id')->first();

					if (!empty($artist_id)) {
						$artist = Content::where('id', $artist_id)->pluck('name')->first();
					}

					if (!empty($album_id)) {
						$album = Content::where('id', $album_id)->pluck('name')->first();
					}
					if (!empty($playlist_id)) {
						$playlist = Content::where('id', $playlist_id)->pluck('name')->first();
					}

					if (!empty($value->content_id)) {
						$track = Content::where('id', $value->content_id)->pluck('name')->first();
					}

					$data[] = [
						"id" => (string) $value->id,
						"title" => (string) $value->name,
						"subtitle" => (string) $value->subtitle,
						"description" => (string) $value->description,
						"image" => (string) !empty($value->image) ? Controller::getFilePath($value->image, 'songPic') : "",
						"song" => (string) !empty($value->song) ? Controller::getFilePath($value->song, 'songs') : "",
						"duration" => (string) $value->duration,
						"artist" => (string) $artist,
						"album" => (string) $album,
						"playlist" => (string) $playlist,
						"track" => (string) $track,
					];
				}
				$this->success('All tracks.', $data);
			} else {
				$this->success('All tracks.', []);
			}
		} else {
			$this->error('Artist does not exist.', null);
		}
	}

	/**
	 * Get All Tracks of an Artist
	 *
	 * @param  user_id
	 * @return response
	 */
	public function getTracksByAlbum(Request $request) {
		$album = Content::where('id', $request->input('album_id'))->first();

		if ($album) {
			$tracks = Song::where(['cat_id' => '2', 'content_id' => $request->input('album_id'), 'status' => '1'])->orderBy('id', 'DESC')->get();

			if (count($tracks) > 0) {
				foreach ($tracks as $key => $value) {

					$artist_id = $album_id = $playlist_id = $artist = $album = $playlist = "";

					$artist_id = Song::where(['group_id' => $value->group_id, 'cat_id' => '1'])->pluck('content_id')->first();

					$album_id = Song::where(['group_id' => $value->group_id, 'cat_id' => '2'])->pluck('content_id')->first();

					$playlist_id = Song::where(['group_id' => $value->group_id, 'cat_id' => '3'])->pluck('content_id')->first();

					if (!empty($artist_id)) {
						$artist = Content::where('id', $artist_id)->pluck('name')->first();
					}

					if (!empty($album_id)) {
						$album = Content::where('id', $album_id)->pluck('name')->first();
					}
					if (!empty($playlist_id)) {
						$playlist = Content::where('id', $playlist_id)->pluck('name')->first();
					}

					if (!empty($value->content_id)) {
						$track = Content::where('id', $value->content_id)->pluck('name')->first();
					}

					$data[] = [
						"id" => (string) $value->id,
						"title" => (string) $value->name,
						"subtitle" => (string) $value->subtitle,
						"description" => (string) $value->description,
						"image" => (string) !empty($value->image) ? Controller::getFilePath($value->image, 'songPic') : "",
						"song" => (string) !empty($value->song) ? Controller::getFilePath($value->song, 'songs') : "",
						"duration" => (string) $value->duration,
						"artist" => (string) $artist,
						"album" => (string) $album,
						"playlist" => (string) $playlist,
						"track" => (string) $track,
					];
				}
				$this->success('All tracks.', $data);
			} else {
				$this->success('All tracks.', []);
			}
		} else {
			$this->error('Album does not exist.', null);
		}
	}

}
