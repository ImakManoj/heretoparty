<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use PHPMailer\PHPMailer;
use App\User;
use App\Content;
use App\Song;
use App\Stats;
use App\Favourite;
use App\UserPlaylist;
use App\Banner;
use App\FeaturedPlaylist;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Response;
use Auth;
use Mail;
use URL;
use DB;
use File;
use Input;
use Storage;
use Illuminate\Contracts\Filesystem\Filesystem;

class CollectionsController extends Controller
{

	/**
     * Get Home all data
     *
     * @param  user_id
     * @return response
     */
    public function getHomeData(Request $request)
	{

		$this->validation($request->all(), [
	        "user_id" => "required",
	    ]);

		$userinfo =  User::where('id',$request->input('user_id'))->first();
		if (empty($userinfo)) {
			$this->error('User does not exist.', []);
		}

		//1=> artist, 2=> album, 3=> playlist, 4=> track
		$banner_data = $this->getBannerData($request->input('user_id'), 3, 5);

		$song_data = $this->getSongData($request->input('user_id'), 2, 10);

		$albums_data = $this->getContentsData($request->input('user_id'), 2, 5);

		$popular_playlist_data = $this->getPopularPlaylistBySong($request->input('user_id'), 3, 5);

		$featured_playlist_data = $this->getFeaturedPlaylistData($request->input('user_id'), 3, 5);

		$response = [];
		$response['banner_data'] = $banner_data;
		$response['song_data'] = $song_data;
		$response['album_data'] = $albums_data;
		$response['popular_playlist_data'] = $popular_playlist_data;
		$response['featured_playlist_data'] = $featured_playlist_data;

		if($response)
		{
			$this->success('record found.', $response);
		}else{
			$this->error('record not fount', []);
		}
	}

	/**
     * Get Home all data
     *
     * @param  user_id
     * @return response
     */
    public function getExploreData(Request $request)
	{
		$this->validation($request->all(), [
	        "user_id" => "required",
	    ]);

		$userinfo =  User::where('id',$request->input('user_id'))->first();
		if (empty($userinfo)) {
			$this->error('User does not exist.', []);
		}

		//1=> artist, 2=> album, 3=> playlist, 4=> track
		$featured_playlist_data = $this->getFeaturedPlaylistData($request->input('user_id'), 3, 5);

		$genre_moods = $this->getContentsData($request->input('user_id'), 4, 10);

		$albums_data = $this->getContentsData($request->input('user_id'), 3, 5);

		$artist_data = $this->getContentsData($request->input('user_id'), 1, 5);


		$response = [];
		$response['featured_playlist_data'] = $featured_playlist_data;
		$response['genre_moods'] = $genre_moods;
		$response['album_data'] = $albums_data;
		$response['artist_data'] = $artist_data;

		if($response)
		{
			$this->success('record found.', $response);
		}else{
			$this->error('record not fount', []);
		}
	}

	/**
     * Get Genres and mood
     *
     * @param  user_id
     * @return response
     */
    public function getGenresMood(Request $request)
	{
		$this->validation($request->all(), [
	        "user_id" => "required",
	    ]);

		$userinfo =  User::where('id',$request->input('user_id'))->first();
		if (empty($userinfo)) {
			$this->error('User does not exist.', []);
		}

		$per_page = 20;

	    if ($request->input('page') == "") {
	        $skip = 0;
	    } else {
	        $skip = $per_page * $request->input('page');
	    }

	    if ($request->input('page') == '') {
			$take = 20;
	    }else{
			$take = ( (int) @$request->input('page') + 2) * 10;
	    }

		//1=> artist, 2=> album, 3=> playlist, 4=> genre_mood

		$file_path = $this->getPath(4);
		$results = Content::where(['cat_id' => 4])->orderBy('id', 'DESC')->skip($skip)->take($take)->get();
		$response = [];
		foreach ($results as $key => $value) {
			$response[] = [
				'id' => $value->id,
				'category_id' => $value->cat_id,
				'name' => (string) $value->name,
				'subtitle' => (string) $value->subtitle,
				'description' => (string) $value->description,
				'file_image' => $this->getFilePath($value->image, $file_path),
				'is_favourite' => $this->isFavourite($request->input('user_id'), $value->id, 4),
				'created_at' => date('Y-m-d H:i:s', strtotime($value->created_at)),
			];
		}

		if($response)
		{
			$this->success('record found.', $response);
		}else{
			$this->error('record not fount', []);
		}
	}

	/**
     * Explore screen (New Tab)
     *
     * @param  user_id
     * @return response
     */
    public function getExploreNewInfo(Request $request)
	{
		$this->validation($request->all(), [
	        "user_id" => "required",
	    ]);

		$userinfo =  User::where('id',$request->input('user_id'))->first();
		if (empty($userinfo)) {
			$this->error('User does not exist.', []);
		}

		//1=> artist, 2=> album, 3=> playlist, 4=> track
		$song_data = $this->getSongData($request->input('user_id'), 2, 5);

		$albums_data = $this->getContentsData($request->input('user_id'), 2, 5);

		$response = [];
		$response['song_data'] = $song_data;
		$response['album_data'] = $albums_data;

		if($response)
		{
			$this->success('record found.', $response);
		}else{
			$this->error('record not fount', []);
		}
	}

	/**
     * Explore screen (Top Tab)
     *
     * @param  user_id
     * @return response
     */
    public function getExploreTopInfo(Request $request)
	{
		$this->validation($request->all(), [
	        "user_id" => "required",
	    ]);

		$userinfo =  User::where('id',$request->input('user_id'))->first();
		if (empty($userinfo)) {
			$this->error('User does not exist.', []);
		}

		//1=> artist, 2=> album, 3=> playlist, 4=> track
		$song_data = $this->getPopularSongByStats($request->input('user_id'), 2, 10);

		$albums_data = $this->getContentsData($request->input('user_id'), 2, 10);

		$response = [];
		$response['song_data'] = $song_data;
		$response['album_data'] = $albums_data;

		if($response)
		{
			$this->success('record found.', $response);
		}else{
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
	public function getContentsData($user_id = '', $category_id = 1, $take = 5, $page = 1) {

		$skip = 0;
	    $skip = $take * ($page - 1);

		$file_path = $this->getPath($category_id);
		$results = Content::where(['cat_id' => $category_id])->orderBy('id', 'DESC')->skip($skip)->take($take)->get();
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


	public function setContentsInfo(Request $request, $category_id = 1, $take = 5, $page = 1){
		$this->validation($request->all(), [
					"id"=> "required",
					"user_id" => "required",
					"cat_id" => "required",
					"name" => "required",
					"subtitle" => "required",
					"description" => "required",
			]);
			$userinfo =  User::where('id',$request->input('user_id'))->first();
			if (empty($userinfo)) {
				$this->error('User does not exist.', []);
			}
			$user_id=$request->user_id;
			$input['cat_id']=$request->cat_id;
			$input['name']=$request->name;
			$input['subtitle']=$request->subtitle;
			$input['description']=$request->description;
			if($request->file('image')){
					$img_name = $this->uploadS3Data(@$request->file('image'), 'albums');
					$input['image']=$img_name;
			}


			DB::table('contents')->where('id',$request->id)->update($input);

					$skip = 0;
				    $skip = $take * ($page - 1);

					$file_path = $this->getPath($request->cat_id);
					$results = Content::where(['cat_id' =>$request->cat_id])->where('id',$request->id)->orderBy('id', 'DESC')->skip($skip)->take($take)->get();
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
     * Get Home all data
     *
     * @param  user_id
     * @return response
     */
    public function getHomeDataNew(Request $request)
	{
		$this->validation($request->all(), [
	        "user_id" => "required",
	    ]);

		$userinfo =  User::where('id',$request->input('user_id'))->first();
		if (empty($userinfo)) {
			$this->error('User does not exist.', []);
		}

		//1=> artist, 2=> album, 3=> playlist, 4=> track
		$banner_data = $this->getBannerData($request->input('user_id'), 3, 5);

		$song_data = $this->getSongData($request->input('user_id'), 2, 10);

		$albums_data = $this->getContentsData($request->input('user_id'), 2, 5);

		$popular_playlist_data = $this->getPopularPlaylistBySong($request->input('user_id'), 3, 5);

		$featured_playlist_data = $this->getFeaturedPlaylistData($request->input('user_id'), 3, 5);

		$response = [];
		$response['banner_data'] = $banner_data;
		$response['song_data'] = $song_data;
		$response['album_data'] = $albums_data;
		$response['popular_playlist_data'] = $popular_playlist_data;
		$response['featured_playlist_data'] = $featured_playlist_data;

		if($response)
		{
			$this->success('record found.', $response);
		}else{
			$this->error('record not fount', []);
		}
	}



	/**
     * get popular playlist by song stats
     *
     * @param  user_id, category_id, take
     * @param  Reference of category: 1=> artist, 2=> album, 3=> playlist, 4=> songs
     * @return response
     */
	public function getPopularPlaylistBySong($user_id = '', $category_id = 3, $take = 5) {

		// $get_data = Stats::where(['user_id'=> $request->input('user_id'), 'song_id'=> $request->input('song_id')])->get();

		$set_temp = DB::select("CREATE TEMPORARY TABLE temp_table as (select sum(stats.play_count) as play_count, songs.id as song_id, contents.id as content_id, contents.cat_id, contents.name, contents.subtitle, contents.description, contents.created_at, contents.image from stats left join songs on stats.song_id=songs.id left join contents on  find_in_set(contents.id, songs.content_id) where contents.cat_id=3  group by  stats.song_id order by stats.play_count DESC);");

		$get_data = DB::select("select * from temp_table group by content_id order by play_count DESC");
		$response = [];
		if (count($get_data)) {
			foreach ($get_data as $key => $value) {
				$file_path = $this->getPath($value->cat_id);
				$response[] = [
					'id' => $value->content_id,
					'category_id' => $value->cat_id,
					'name' => (string) $value->name,
					'subtitle' => (string) $value->subtitle,
					'description' => (string) $value->description,
					'file_image' => $this->getFilePath($value->image, $file_path),
					'is_favourite' => $this->isFavourite($user_id, $value->content_id, $value->cat_id),
					'created_at' => date('Y-m-d H:i:s', strtotime($value->created_at)),
				];
			}
		}else{

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
		}

		return $response;
	}

	/**
     * get popular playlist by song stats
     *
     * @param  user_id, category_id, take
     * @param  Reference of category: 1=> artist, 2=> album, 3=> playlist, 4=> songs
     * @return response
     */
	public function getPopularSongByStats($user_id = '', $category_id = 3, $take = 5) {

		$get_data = Stats::selectRaw('sum(stats.play_count) as play_count, song_id')->with('getSongInfo')->groupBy('song_id')->orderBy('play_count', 'DESC')->take($take)->get();
		$response = [];
		if (count($get_data)) {
			foreach ($get_data as $key => $value) {
				$file_path = $this->getPath(4);
				$response[] = [
					'song_id' => $value->song_id,
					'name' => (string) $value['getSongInfo']->name,
					'subtitle' => (string) $value['getSongInfo']->subtitle,
					'description' => (string) $value['getSongInfo']->description,
					'song_image' => $this->getFilePath($value['getSongInfo']->image, 'songPic'),
					'song_url' => $this->getFilePath($value['getSongInfo']->song, 'songs'),
					'duration' => $value['getSongInfo']->duration,
					'is_favourite' => $this->isFavourite($user_id, $value->song_id, 4),
					'created_at' => date('Y-m-d H:i:s', strtotime($value['getSongInfo']->created_at)),
					'contents' => $this->getContentsDetails($user_id, $value['getSongInfo']->content_id),
				];
			}
		}else{

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
		}

		return $response;
	}

	/**
     * view popular song by stats
     *
     * @param  user_id, page
     * @param  Reference of category: 1=> artist, 2=> album, 3=> playlist, 4=> songs
     * @return response
     */
	public function viewAllPopularSongs(Request $request) {

		$this->validation($request->all(), [
	        "user_id" => "required",
	    ]);

		$userinfo =  User::where('id',$request->input('user_id'))->first();
		if (empty($userinfo)) {
			$this->error('User does not exist.', []);
		}

		$per_page = 10;
		$take = 10;

	    if ($request->input('page') == "") {
	        $skip = 0;
	    } else {
	        $skip = $per_page * ($request->input('page') - 1);
	    }

		$get_data = Stats::selectRaw('sum(stats.play_count) as play_count, song_id')->with('getSongInfo')->groupBy('song_id')->orderBy('play_count', 'DESC')->skip($skip)->take($take)->get();
		$response = [];
		if (count($get_data)) {
			foreach ($get_data as $key => $value) {
				$file_path = $this->getPath(4);
				$response[] = [
					'song_id' => $value->song_id,
					'name' => (string) $value['getSongInfo']->name,
					'subtitle' => (string) $value['getSongInfo']->subtitle,
					'description' => (string) $value['getSongInfo']->description,
					'song_image' => $this->getFilePath($value['getSongInfo']->image, 'songPic'),
					'song_url' => $this->getFilePath($value['getSongInfo']->song, 'songs'),
					'duration' => $value['getSongInfo']->duration,
					'is_favourite' => $this->isFavourite($request->input('user_id'), $value->song_id, 4),
					'created_at' => date('Y-m-d H:i:s', strtotime($value['getSongInfo']->created_at)),
					'contents' => $this->getContentsDetails($request->input('user_id'), $value['getSongInfo']->content_id),
				];
			}
		}

		// else{

		// 	$results = Song::where(['status' => 1])->orderBy('id', 'DESC')->take(5)->get();
		// 	$response = [];
		// 	foreach ($results as $key => $value) {
		// 		$response[] = [
		// 			'song_id' => $value->id,
		// 			'name' => $value->name,
		// 			'subtitle' => $value->subtitle,
		// 			'description' => $value->description,
		// 			'song_image' => $this->getFilePath($value->image, 'songPic'),
		// 			'song_url' => $this->getFilePath($value->song, 'songs'),
		// 			'duration' => $value->duration,
		// 			'is_favourite' => $this->isFavourite($request->input('user_id'), $value->id, 4),
		// 			'created_at' => date('Y-m-d H:i:s', strtotime($value->created_at)),
		// 			'contents' => $this->getContentsDetails($request->input('user_id'), $value->content_id),
		// 		];
		// 	}
		// }

		if ($response) {

			$this->success('record found.', $response);
		}else{

			$this->success('record not found.', []);
		}
	}

	/**
     * view popular song by stats
     *
     * @param  user_id, page
     * @param  Reference of category: 1=> artist, 2=> album, 3=> playlist, 4=> songs
     * @return response
     */
	public function viewAllPopularPlaylist(Request $request) {

		$this->validation($request->all(), [
	        "user_id" => "required",
	    ]);

		$userinfo =  User::where('id',$request->input('user_id'))->first();
		if (empty($userinfo)) {
			$this->error('User does not exist.', []);
		}

		$per_page = 10;
		$take = 10;

	    if ($request->input('page') == "") {
	        $skip = 0;
	    } else {
	        $skip = $per_page * ($request->input('page') - 1);
	    }

		$set_temp = DB::select("CREATE TEMPORARY TABLE temp_table as (select sum(stats.play_count) as play_count, songs.id as song_id, contents.id as content_id, contents.cat_id, contents.name, contents.subtitle, contents.description, contents.created_at, contents.image from stats left join songs on stats.song_id=songs.id left join contents on  find_in_set(contents.id, songs.content_id) where contents.cat_id=3  group by  stats.song_id order by stats.play_count DESC);");

		$get_data = DB::select("select * from temp_table group by content_id order by play_count DESC LIMIT ".@$take." OFFSET ".@$skip." ");
		$response = [];
		if (count($get_data)) {
			foreach ($get_data as $key => $value) {
				$file_path = $this->getPath($value->cat_id);
				$response[] = [
					'id' => $value->content_id,
					'category_id' => $value->cat_id,
					'name' => (string) $value->name,
					'subtitle' => (string) $value->subtitle,
					'description' => (string) $value->description,
					'file_image' => $this->getFilePath($value->image, $file_path),
					'is_favourite' => $this->isFavourite($request->input('user_id'), $value->content_id, $value->cat_id),
					'created_at' => date('Y-m-d H:i:s', strtotime($value->created_at)),
				];
			}
		}else{

			$file_path = $this->getPath(3);
			$results = Content::where(['cat_id' => 3])->orderBy('id', 'DESC')->skip($skip)->take($take)->get();
			$response = [];
			foreach ($results as $key => $value) {
				$response[] = [
					'id' => $value->id,
					'category_id' => $value->cat_id,
					'name' => (string) $value->name,
					'subtitle' => (string) $value->subtitle,
					'description' => (string) $value->description,
					'file_image' => $this->getFilePath($value->image, $file_path),
					'is_favourite' => $this->isFavourite($request->input('user_id'), $value->id, 3),
					'created_at' => date('Y-m-d H:i:s', strtotime($value->created_at)),
				];
			}
		}

		if ($response) {

			$this->success('record found.', $response);
		}else{

			$this->success('record not found.', []);
		}
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
		$results = Banner::where(['status'=> 1])->with('getPlaylistInfo')->orderBy('id', 'DESC')->take($take)->get();
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
		$results = FeaturedPlaylist::where(['status'=> 1])->with('getPlaylistInfo')->orderBy('id', 'DESC')->take($take)->get();
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

	public function getPath($id='') {
		if ($id == 1) {

			$file_path = 'artists';
		}elseif ($id == 2) {

			$file_path = 'albums';
		}elseif ($id == 3) {

			$file_path = 'playlists';
		}elseif ($id == 4) {

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
		$response = [];
		foreach ($results as $key => $value) {
			if ($value->cat_id == 1) {
				$response['artist'][] = [
					'id' => $value->id,
					'name' => (string) @$value->name,
					'subtitle' => (string) @$value->subtitle,
					'description' => (string) @$value->description,
					'file_image' => $this->getFilePath($value->image, 'artists'),
					'is_favourite' => $this->isFavourite($user_id, $value->id, 1),
					'created_at' => date('Y-m-d H:i:s', strtotime($value->created_at)),
				];
			}elseif ($value->cat_id == 2) {
				$response['album'][] = [
					'id' => $value->id,
					'name' => (string) @$value->name,
					'subtitle' => (string) @$value->subtitle,
					'description' => (string) @$value->description,
					'file_image' => $this->getFilePath($value->image, 'albums'),
					'is_favourite' => $this->isFavourite($user_id, $value->id, 2),
					'created_at' => date('Y-m-d H:i:s', strtotime($value->created_at)),
				];
			}elseif ($value->cat_id == 3) {
				$response['playlist'][] = [
					'id' => $value->id,
					'name' => (string) @$value->name,
					'subtitle' => (string) @$value->subtitle,
					'description' => (string) @$value->description,
					'file_image' => $this->getFilePath($value->image, 'playlists'),
					'is_favourite' => $this->isFavourite($user_id, $value->id, 3),
					'created_at' => date('Y-m-d H:i:s', strtotime($value->created_at)),
				];
			}elseif ($value->cat_id == 4) {
				$response['genre'][] = [
					'id' => $value->id,
					'name' => (string) @$value->name,
					'subtitle' => (string) @$value->subtitle,
					'description' => (string) @$value->description,
					'file_image' => $this->getFilePath($value->image, 'tracks'),
					'is_favourite' => 0, //it will not favourite
					'created_at' => date('Y-m-d H:i:s', strtotime($value->created_at)),
				];
			}

		}
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

	    $per_page = 10;
		$take = 10;

	    if ($request->input('page') == "") {
	        $skip = 0;
	    } else {
	        $skip = $per_page * ($request->input('page') - 1);
	    }

	    $take = 20;
		$results = Song::where(['status' => 1])->orderBy('id', 'DESC')->skip($skip)->take($take)->get();
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
		}else{
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

	    $take = 10;

	    if ($request->input('page') == "") {
	        $skip = 0;
	    } else {
	        $skip = $take * ($request->input('page') - 1);
	    }

		$results = Song::whereRaw('FIND_IN_SET("'.$request->input('content_id').'", content_id)')->orderBy('id', 'DESC')->skip($skip)->take($take)->get();
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
		}else{
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

		$take = 10;

	    if ($request->input('page') == "") {
	        $page = 0;
	    } else {
	        $page = $take * ($request->input('page') - 1);
	    }

		$response = [];
		$response = $this->getContentsData($request->input('user_id'), $request->input('type_id'), $take, $page);
		if ($response) {
			$this->success('record found.', $response);
		}else{
			$this->error('record not found.');
		}

	}
/**
*Get Category
*/

public function getCategoryes(Request $request){
  $this->validation($request->all(), [
        "user_id" => "required",
        "type_id" => "required",
    ]);
      $file_path = $this->getPath($request->type_id);
    	$url = Storage::disk('s3')->url($file_path);
      $response=DB::table('contents')->where('cat_id',$request->type_id)->where('status',1)->get();
    if($response->isEmpty()){
        $this->error('record not found.');
    }else{
      foreach ($response as $key => $value) {
        $value->image=$url.'/'.$value->image;
      }
      $this->success('record found.', $response);
    }
}

public function randomCategory(Request $request){
  $this->validation($request->all(), [
        "user_id" => "required",
        "type_id" => "required",
    ]);
    $file_path = $this->getPath($request->type_id);
    $url = Storage::disk('s3')->url($file_path);
    $response['random']=Content::where('cat_id',$request->type_id)->inRandomOrder()->first();
  if(!empty($response['random'])){
      foreach ($response as $key => $ft) {
            $ft->image=$url.'/'.$ft->image;
      }
  }
  $response['interested']=array();
  $file_path = $this->getPath($request->type_id);
  $interest=DB::table('callect_category')->where('callect_userid',$request->user_id)->get();
    foreach($interest as $ft){
      $category_id=json_decode($ft->callect_categoryid);
      if(!empty($category_id)){
        $response['interested']=DB::table('contents')->whereIn('id',$category_id)->where('status',1)->get();
        foreach($response['interested'] as $catid){
          $catid->image=$url.'/'.$catid->image;
          $catid->user_id=$ft->callect_userid;
        }
      }
    }




    $file_path = $this->getPath($request->type_id);
    $response['categories']=DB::table('contents')->where('cat_id',$request->type_id)->where('status',1)->get();
    if($response['categories']->isEmpty()){
        $this->error('record not found.');
    }else{
      foreach ($response['categories'] as $key => $value) {
              $value->image=$url.'/'.$value->image;
      }
    }

    $array[]=array(
      'id'=>1,
      'type'=>'My Recording',
      'date'=>date('d-m-Y'),
    );

    $array[]=array(
      'id'=>1,
      'type'=>'My Favourite',
      'date'=>date('d-m-Y'),
    );

    $response['mystuff']=$array;
    $response['nature']=DB::table('nature')->where('nature_status',1)->get();
    foreach($response['nature'] as $nature){
      $nature->songs=asset('public/voice').'/'.$nature->nature_sound;
      $nature->images=asset('public/images/flag').'/'.$nature->nature_image;
    }

    $this->success('record found.', $response);

}



	/**
     * Add fa
     *
     * @param  user_id
     * @return response
     * @return type 1=> artist, 2=> album, 3=> playlist, 4=> song
     */
	public function addFavourite(Request $request)
    {
		$this->validation($request->all(), [
		        "user_id" => "required",
		        "type" 	  => "required",
		        "fav_id"  => "required",
		    ]);

		$check_favourite =  Favourite::where(['user_id'=>$request->input('user_id'), 'type'=>$request->input('type'), 'fav_id'=>$request->input('fav_id')])->first();

		if(!empty($check_favourite)){
			if($check_favourite->status == 1){
				$status = 0;
			}else{
				$status = 1;
			}
			$store_data = Favourite::where(['user_id'=>$request->input('user_id'), 'type'=>$request->input('type'), 'fav_id'=>$request->input('fav_id')])->update(['status' => $status]);
		}else{
			$status = 1;
			$data = ['user_id'=>$request->input('user_id'), 'type'=>$request->input('type'), 'fav_id'=>$request->input('fav_id'), 'status' => 1];
			$store_data = Favourite::insert($data);
		}

		if (@$store_data) {

			$response = [];
			$response['is_favourite'] = $status;
			$this->success('success', $response);
		}else{
			$this->error('Something went wrong.');
		}


    }

     /**
     * check Favourite
     *
     * @param  type 1=> artist, 2=> album, 3=> playlist, 4=> song
     * @return response
     */
    public function isFavourite($user_id='', $fav_id = '', $type_id = '')
    {
    	$result =  Favourite::where(['user_id'=>$user_id, 'type'=>$type_id, 'fav_id'=>$fav_id])->first();
    	return (int) @$result['status'];
    }

     /**
     * Get User All Playlists
     *
     * @param  user_id
     * @return response
     */
    public function getPlaylists(Request $request)
	{
		$this->validation($request->all(), [
	        "user_id" => "required",
	    ]);

		$userinfo =  User::where('id',$request->input('user_id'))->first();

		if($userinfo){

			$playlists = UserPlaylist::where('user_id', $request->input('user_id'))->get();

			if(count($playlists)>0)
			{
				$this->success('All Playlist.', $playlists);
			}else{
				$this->error('Playlist does not exist.', []);
			}
		}else{
			$this->error('User does not exist.', []);
		}
	}




	/**
     * Create User Playlist
     *
     * @param  user_id
     * @return response
     */
    public function createPlaylist(Request $request)
	{
		$this->validation($request->all(), [
	        "user_id" => "required",
	        "name" => "required"
	    ]);

		$userinfo =  User::where('id',$request->input('user_id'))->first();

		if($userinfo){

			$data = [
	    		'user_id'=> $request->input('user_id'),
	    		'name'=> strtolower($request->input('name')),
	    		'description'=> strtolower($request->input('description')),
	    	];

			if ($save = UserPlaylist::create($data)) {

				$response['playlist_id'] = (string) $save->id;
				$this->success('Playlist created successfully.', $response);
		    }else{
		    	$this->error('Something went wrong.', null);
		    }
		}else{
			$this->error('User does not exist.', null);
		}
	}


	//get user profile using from user_id
    public function getUserProfile($user_id='') {
    	$userinfo =  User::where('id', $user_id)->first();
    	$picture = "";
    	if ($userinfo) {
    		if(strstr($userinfo->profile, 'https://')){
				$picture = $userinfo->profile;
			}elseif(!empty($userinfo->profile)){
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
    public function getTracksByArtist(Request $request)
	{
		$artist =  Content::where('id',$request->input('artist_id'))->first();

		if($artist)
		{
			$tracks = Song::where(['cat_id'=>'1', 'content_id'=>$request->input('artist_id'), 'status'=>'1'])->orderBy('id', 'DESC')->get();

			if(count($tracks)>0)
			{
				foreach ($tracks as $key => $value) {

					$artist_id=$album_id=$playlist_id=$artist=$album=$playlist="";

					$artist_id = Song::where(['group_id'=>$value->group_id, 'cat_id'=>'1'])->pluck('content_id')->first();

					$album_id = Song::where(['group_id'=>$value->group_id, 'cat_id'=>'2'])->pluck('content_id')->first();

					$playlist_id = Song::where(['group_id'=>$value->group_id, 'cat_id'=>'3'])->pluck('content_id')->first();

					if(!empty($artist_id))
					{
						$artist = Content::where('id',$artist_id)->pluck('name')->first();
					}

					if(!empty($album_id))
					{
						$album = Content::where('id',$album_id)->pluck('name')->first();
					}
					if(!empty($playlist_id))
					{
						$playlist = Content::where('id',$playlist_id)->pluck('name')->first();
					}

					if(!empty($value->content_id))
					{
						$track = Content::where('id',$value->content_id)->pluck('name')->first();
					}

					$data[] = [
						"id" 	  	  => (string) $value->id,
						"title" 	  => (string) $value->name,
						"subtitle"	  => (string) $value->subtitle,
						"description" => (string) $value->description,
						"image"	 	  => (string) !empty($value->image)?Controller::getFilePath($value->image, 'songPic'):"",
						"song"	 	  => (string) !empty($value->song)?Controller::getFilePath($value->song, 'songs'):"",
						"duration"	  => (string) $value->duration,
						"artist"	  => (string) $artist,
						"album"	  	  => (string) $album,
						"playlist"	  => (string) $playlist,
						"track"	  	  => (string) $track,
					];
				}
				$this->success('All tracks.', $data);
			}else{
				$this->success('All tracks.', []);
			}
		}else{
			$this->error('Artist does not exist.', null);
		}
	}


	/**
     * Get All Tracks of an Artist
     *
     * @param  user_id
     * @return response
     */
    public function getTracksByAlbum(Request $request)
	{
		$album =  Content::where('id',$request->input('album_id'))->first();

		if($album)
		{
			$tracks = Song::where(['cat_id'=>'2', 'content_id'=>$request->input('album_id'), 'status'=>'1'])->orderBy('id', 'DESC')->get();

			if(count($tracks)>0)
			{
				foreach ($tracks as $key => $value) {

					$artist_id=$album_id=$playlist_id=$artist=$album=$playlist="";

					$artist_id = Song::where(['group_id'=>$value->group_id, 'cat_id'=>'1'])->pluck('content_id')->first();

					$album_id = Song::where(['group_id'=>$value->group_id, 'cat_id'=>'2'])->pluck('content_id')->first();

					$playlist_id = Song::where(['group_id'=>$value->group_id, 'cat_id'=>'3'])->pluck('content_id')->first();

					if(!empty($artist_id))
					{
						$artist = Content::where('id',$artist_id)->pluck('name')->first();
					}

					if(!empty($album_id))
					{
						$album = Content::where('id',$album_id)->pluck('name')->first();
					}
					if(!empty($playlist_id))
					{
						$playlist = Content::where('id',$playlist_id)->pluck('name')->first();
					}

					if(!empty($value->content_id))
					{
						$track = Content::where('id',$value->content_id)->pluck('name')->first();
					}

					$data[] = [
						"id" 	  	  => (string) $value->id,
						"title" 	  => (string) $value->name,
						"subtitle"	  => (string) $value->subtitle,
						"description" => (string) $value->description,
						"image"	 	  => (string) !empty($value->image)?Controller::getFilePath($value->image, 'songPic'):"",
						"song"	 	  => (string) !empty($value->song)?Controller::getFilePath($value->song, 'songs'):"",
						"duration"	  => (string) $value->duration,
						"artist"	  => (string) $artist,
						"album"	  	  => (string) $album,
						"playlist"	  => (string) $playlist,
						"track"	  	  => (string) $track,
					];
				}
				$this->success('All tracks.', $data);
			}else{
				$this->success('All tracks.', []);
			}
		}else{
			$this->error('Album does not exist.', null);
		}
	}


	public function getVoice(Request $request){
			$voice=DB::table('voice')->where('status',1)->get();
			if(!$voice->isEmpty()){
				foreach($voice as $ft){
					$ft->image=asset('public').'/images/'.$ft->image;
					$ft->flag=asset('public').'/images/flag/'.$ft->flag;
					$ft->voices=asset('public').'/voice/'.$ft->voices;
				}
				$data=$voice;

				$this->success('record found.',$data);
			}else{
				$data=array();
				$this->error('record not found.',$data);
			}
	}


public function setVoice(Request $request){
		$this->validation($request->all(), [
	        "user_id" => "required",
	        "voice_id" => "required",
	        "user_time" => "required",
	        "status" => "required",
	    ]);

		$input['voice_id']=json_encode($request->voice_id);
		$input['user_id']=$request->user_id;
		$input['user_time']=$request->user_time;
		$input['on_off_status']=$request->status;



		$data=DB::table('user_voice')->insert($input);
		$id= DB::getPdo()->lastInsertId();
		$record=DB::table('user_voice')->where('user_voice_id',$id)->where('user_id',$request->user_id)->get();
		$this->success("record found",$record);
}

public function collectCategory(Request $request){

  $this->validation($request->all(), [
        "user_id" => "required",
        "category_id" => "required",
    ]);
  $input['callect_categoryid']=json_encode($request->category_id);
  $input['callect_userid']=$request->user_id;
  DB::table('callect_category')->insert($input);
  $this->success("Successfully insert category");
}


public function support(Request $request){
  $array=array(
      'support_userid'=>$request->user_id,
      'support_title'=>$request->suppert_subject,
      'support_message'=>$request->support_message
    );
        $records=DB::table('supports')->insert($array);
        $userinfo=user::where('id',$request->user_id)->first();
        // $data=['email' => $userinfo->email, 'username' => $userinfo->first_name, 'title'=>$request->suppert_subject,'message'=>$request->support_message];

      $send = Mail::send('emails.Support', ['email' => $userinfo->email, 'username' => $userinfo->first_name, 'title'=>$request->suppert_subject,'user_message'=>$request->support_message], function ($m) use ($userinfo) {
        $m->from('no-reply@imarkinfotech.com', 'meditation');
        $m->to($userinfo->email, $userinfo->first_name)->subject('meditation : Support');
      });


      $this->success("Successfully send you query");
}


// End controller

}
