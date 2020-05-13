<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use PHPMailer\PHPMailer;
use App\ContactUs;
use App\User;
use App\Content;
use App\Song;
use App\Page;
use App\UserPlaylist;
use App\Subscription;
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

use Stripe\Error\Card;
use Cartalyst\Stripe\Stripe;


use Braintree_Customer;

class AuthController extends Controller
{

	/**
     * Register with socail(login and signup)
     *
     * @return response
     */
	public function register(Request $request)
	{
		if ($request->input('social_type') == ('twitter' || 'facebook' || 'gmail') ) {

			$this->socailLogin($request);
		} else{

			$this->validation($request->all(), [
				"email" => "required|email|unique:users,email",
				"password" => "required",
			]);

			$token = sha1(str_random(8));


			$data = [
				'first_name'=> strtolower($request->input('first_name')),
				'last_name'=> strtolower($request->input('last_name')),
				'email'=> strtolower($request->input('email')),
				'password'=> password_hash($request->input('password'), PASSWORD_DEFAULT),
				'dob'=> $request->input('dob'),
				'gender'=> $request->input('gender'),
				'device_type'=> $request->input('device_type'),
				'device_token'=> $request->input('device_token'),
				'is_notification'=> '1',
			];

			if ($save = User::create($data)) {

				$get_data = User::where(['id'=>$save->id])->first();
		    	//$response['stripe_customer_id'] = @$this->stripeCheckAndUpdate(@$get_data->email);

				$response['user_id'] = (string) $get_data->id;
				$response['social_id'] = (string) $get_data->social_id;
				$response['social_type'] = (string) $get_data->social_type;
				$response['first_name'] = (string) $get_data->first_name;
				$response['last_name'] = (string) $get_data->last_name;
				$response['email'] = $get_data->email;
				$response['gender'] = (string) $get_data->gender;
				$response['dob'] = (string) $get_data->dob;
				$response['profile'] = (string) $this->getUserProfile($get_data->id);
				$response['device_type'] = (string) $get_data->device_type;
				$response['device_token'] = (string) $get_data->device_token;
				$response['is_notification'] = (string) $get_data->is_notification;

				$this->success('Register Successfully.', $response);
			}else{
				$this->error('Something went wrong.');
			}
		}
	}

	/**
     * Method for register api
     *
     * @return response
     */
	public function socailLogin(Request $request)
	{


		$profile_name = '';
		$this->validation($request->all(), [
			"social_id" => "required",
			'social_type' => "required",
			"email" => "required|email",
		]);



		$get_data = User::where(['email'=>$request->input('email')])->first();


		$this->device_type = '';
		$this->device_token = '';
		if (!empty($get_data)) {
			$response['stripe_customer_id'] = @$this->stripeCheckAndUpdate(@$get_data->email);
			$get_data->device_type  = $request->input('device_type');
			$get_data->device_token  = $request->input('device_token');

			if($request->input('social_type')=='facebook'){
			$get_data->social_id = $request->input('social_id');
			$get_data->social_type  = $request->input('social_type');
			}else{
			$get_data->google_id = $request->input('social_id');
			$get_data->social_type  = $request->input('social_type');
			}

			$update = $get_data->save();



			$response['user_id'] = (string) $get_data->id;
			$response['first_name'] = (string) $get_data->first_name;
			$response['last_name'] = (string) $get_data->last_name;
			$response['email'] = $get_data->email;
			$response['gender'] = (string) $get_data->gender;
			$response['dob'] = (string) $get_data->dob;
			$response['profile'] = (string) $this->getUserProfile($get_data->id);
			if($request->input('social_type')=='facebook'){
			$response['social_id'] = (string) $get_data->social_id;
			}else{
			$response['google_id'] = (string) $get_data->social_id;
			}
			$response['social_type'] = (string) $get_data->social_type;
			$response['device_type'] = (string) $get_data->device_type;
			$response['device_token'] = (string) $get_data->device_token;
			$response['is_notification'] = (string) $get_data->is_notification;
			$response['UserType'] = '1';

			$this->success('login Successfully.', $response);
		}else{
			if($request->input('social_type')=='facebook'){
			$data['social_id'] =  $request->input('social_id');
			}else{
			$data['google_id'] =  $request->input('social_id');
			}

			$setpassword=sha1(str_random(2));
			$data['password'] = password_hash($setpassword, PASSWORD_DEFAULT);

			// $referral_code = $this->generateRandom(6);
			$data = [
				'first_name'=> $request->input('first_name'),
				'last_name'=> $request->input('last_name'),
				'email'=> $request->input('email'),
				'gender'=> $request->input('gender'),
				'dob'=> $request->input('dob'),
				'profile'=> $request->input('profile'),
				// 'social_id'=> $request->input('social_id'),
				'social_type'=> $request->input('social_type'),
				'device_type'=> $request->input('device_type'),
				'device_token'=> $request->input('device_token'),
				'is_notification'=> '1'
			];
			if(User::where('email',$request->email)->count()>0){
				$this->error('User already exists.');
			}elseif ($save = User::create($data)) {
				$get_data = User::where(['id'=>$save->id])->first();
				$send = Mail::send('emails.UserPassword', ['email' => $get_data->email, 'username' => $get_data->first_name,'User_password'=>$setpassword], function ($m) use ($get_data) {
				  $m->from('no-reply@imarkinfotech.com', 'meditation');
				  $m->to($get_data->email, $get_data->first_name)->subject('meditation :Default Password');
				});


				$response['stripe_customer_id'] = @$this->stripeCheckAndUpdate(@$get_data->email);

				$response['user_id'] = (string) $get_data->id;
				$response['first_name'] = (string) $get_data->first_name;
				$response['last_name'] = (string) $get_data->last_name;
				$response['email'] = $get_data->email;
				$response['gender'] = (string) $get_data->gender;
				$response['dob'] = (string) $get_data->dob;
				$response['profile'] = (string) $this->getUserProfile($get_data->id);

				if($request->input('social_type')=='facebook'){
				$response['social_id'] = (string) $get_data->social_id;
				}else{
				$response['google_id'] = (string) $get_data->social_id;
				}
				//$response['social_id'] = (string) $get_data->social_id;
				$response['social_type'] = (string) $get_data->social_type;
				$response['device_type'] = (string) $get_data->device_type;
				$response['device_token'] = (string) $get_data->device_token;
				$response['is_notification'] = (string) $get_data->is_notification;
				$response['UserType'] = '0';
				$this->success('Register Successfully.', $response);
			}else{
				$this->error('Something went wrong.');
			}
		}
	}

	public function stripeCheckAndUpdate($email = '') {
		$stripe = Stripe::make(env('STRIPE_SECRET'));
		$get_data = User::where(['email'=>$email])->first();
		if (!empty($get_data->stripe_customer_id)) {
			return (string) @$get_data->stripe_customer_id;
		}else{
			$customer = $stripe->customers()->create([
				'email' => @$email,
			]);

			if ($customer['id']) {
				$get_data->stripe_customer_id = $customer['id'];

				if ($get_data->save()) {
					return (string) @$customer['id'];
				}
			}
		}

	}

	public function generateRandom($length = 6) {
		$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

		return substr(str_shuffle(str_repeat($pool, 6)), 0, $length);
	}

	public function confirmMail(Request $request) {
		$this->validation($request->all(), [
			"user" => "required",
			"usertoken" => "required",
		]);

		$check_token =  User::where(['id'=>$request->input('user'), 'token'=>$request->input('usertoken')])->first();
		if ($check_token) {
			$update =  User::where(['id'=>$request->input('user'), 'token'=>$request->input('usertoken')])->update(['token'=>'', 'status'=>0]);
			echo "<center><p>Congratulations, your email has been verified.</p></center>";
		}else{
			echo "<center><p>This link is not valid.</p></center>";
		}
	}


    /**
     * Simple login without social
     *
     * @return response
     */

    public function login(Request $request)
    {
    	/*print_r($request->all());
    	die();*/
    	$this->validation($request->all(), [
    		"email" => "required|email",
    		"password" => "required",
    	]);

    	$userdata = array(
    		'email'     => strtolower($request->input('email')),
    		'password'  =>	$request->input('password'),
    	);
    	if(User::where('email',$request->email)->count()<1){
    		$this->error('Email is not registered.', null);
    	}
    	elseif (Auth::attempt($userdata)) {

    		$userinfo =  User::where('id', Auth::id())->first();
    		if ($userinfo) {
				//$userinfo->stripe_customer_id = @$this->stripeCheckAndUpdate(@$userinfo->email);
				//update device_type and device_token
    			$userinfo->device_type = $request->input('device_type');
    			$userinfo->device_token = $request->input('device_token');
    			$userinfo->save();

    			$data = [
					//"stripe_customer_id"=> $userinfo->stripe_customer_id,
    				"user_id" 	 	=> (string) $userinfo->id,
    				"first_name"	=> (string) $userinfo->first_name,
    				"last_name"		=> (string) $userinfo->last_name,
    				"email"	 		=> $userinfo->email,
    				"gender"	 	=> (string) $userinfo->gender,
    				"dob"	 		=> (string) $userinfo->dob,
    				"profile" 		=> (string) $this->getUserProfile($userinfo->id),
    				"device_type"	=> (string) $userinfo->device_type,
    				"device_token"	=> (string) $userinfo->device_token,
    				"is_notification"=> (string) $userinfo->is_notification,
    			];

    			$this->success('Login Successfully.', $data);
    		}else{
    			$this->error('Invalid user! Please try again.', null);
    		}
    	} else {
    		$this->error('Email or password does not match!! Please try again.', null);
    	}

    }


    /**
     * Forgot password
     *
     * @param  email
     * @return response
     */
    public function forgotPassword(Request $request)
    {
    	$this->validation($request->all(), [
    		"email" => "required",
    	]);

    	$userinfo =  User::where('email',strtolower($request->input('email')))->first();

		// attempt to do the login
    	if ($userinfo) {

    		$pool = 'abcdefghijklmnopqrstuvwxyz0123456789';

    		$verify_token = sha1(substr(str_shuffle(str_repeat($pool, 8)), 0, 8));

    		$userinfo->pass_token = (string) $verify_token;
    		if($userinfo->save()){

    			$pass_url = url('/auth/resetPass?user='.$userinfo->id.'&usertoken='.$verify_token);

    			$send = Mail::send('emails.forgot_password', ['email' => $userinfo->email, 'username' => $userinfo->first_name, 'pass_url'=>$pass_url], function ($m) use ($userinfo) {
    				$m->from('no-reply@imarkinfotech.com', 'meditation');

    				$m->to($userinfo->email, $userinfo->first_name)->subject('meditation : Reset Password');
    			});

    			$this->success('Verification email has been sent. Please check your inbox.', '');
    		} else {
    			$this->error('Please try again.');
    		}

    	} else {

    		$this->error('Email does not exist!! Please enter valid email.');
    	}

    }

    /**
     * Resend verification mail
     *
     * @param  email
     * @return response
     */
    public function resendVerificationmail(Request $request) {
    	$this->validation($request->all(), [
    		"email" => "required",
    	]);

    	$get_data =  User::where('email',$request->input('email'))->first();

    	if ($get_data) {
    		if (!empty($get_data->social_type)) {
    			$this->error('Email does not exist! Please enter valid email.');
    		}

    		$token = sha1(str_random(8));

    		$confirm_link = url('/api/auth/confirmMail?user='.$get_data->id.'&usertoken='.$token);


    		$send = Mail::send('emails.confirm', ['user' => $get_data, 'link'=>$confirm_link], function ($m) use ($get_data) {

    			$m->from(env('MAIL_USERNAME'), 'I Am Application');

    			$m->to($get_data->email, $get_data->name)->subject('Iam : Confirm Mail');
    		});

    		$get_data->token  = $token;
    		$get_data->status  = 1;

    		if($get_data->save()){

    			$this->success('New confirmation link has been sent to your email.', '');
    		}else{

    			$this->error('Something went wrong!! Please try again.');
    		}

    	} else {

    		$this->error('Email does not exist!! Please enter valid email.');
    	}

    }


    /**
     * change password
     *
     * @param  user_id
     * @return response
     */
    public function changePassword(Request $request)
    {
    	$this->validation($request->all(), [
    		"user_id" => "required",
    		"old_password" => "required",
    		"new_password" => "required",
    	]);

    	$user =  User::where('id',$request->input('user_id'))->first();

    	if($user)
    	{
    		$userdata = array(
    			'email'     => $user->email,
    			'password'  =>	$request->input('old_password'),
    		);

			// attempt to do the login
    		if (Auth::attempt($userdata)) {

    			$user->password = password_hash($request->input('new_password'), PASSWORD_DEFAULT);
    			if($user->save()){
    				$this->success('Congratulations!! Your password has been changed.', '');
    			}else{
    				$this->error('Enable to update password! Please try again.');
    			}
    		}else{
    			$this->error('Wrong old password! Please try again.');
    		}
    	}else{
    		$this->error('User Id does not exist!.');
    	}
    }


	/**
     * Get profile
     *
     * @return Response
     */
	public function getProfile(Request $request) {

		$this->validation($request->all(), [
			"user_id" => "required",
		]);

		$userinfo =  User::where('id',$request->input('user_id'))->first();

		if($userinfo){

			$data = array(
				"user_id"		=> (string) $userinfo->id,
				"first_name"	=> (string) $userinfo->first_name,
				"last_name"		=> (string) $userinfo->last_name,
				"email"			=> (string) $userinfo->email,
				"password"			=> (string) $userinfo->password,
				"gender"		=> (string) $userinfo->gender,
				"dob"			=> (string) $userinfo->dob,
				"profile"		=> (string) $this->getUserProfile($userinfo->id),
				"is_notification"=>(string) $userinfo->is_notification,
			);

			$this->success('success', $data);
		}else{
			$this->error('User does not exist.');
		}
	}



    /**
     * Edit Profile
     *
     * @return response
     */
    public function editProfile(Request $request) {
    	$this->validation($request->all(), [
    		"user_id" => "required",
    		"first_name" => "required",
    		"last_name"=> "required",
    	]);

    	$message=0;
    	$user =  User::where('id',$request->input('user_id'))->first();

    	if($user)
    	{

    		$userdata = array(
    			'email'     => $user->email,
    			'password'  =>	$request->input('old_password'),
    		);
    		if($request->input('new_password')!=''){
    			if (Auth::attempt($userdata)) {

    				$user->password = password_hash($request->input('new_password'), PASSWORD_DEFAULT);
    				if($user->save()){
    					$userinfo =  User::where('id',$request->input('user_id'))->first();

    					$udata = array(
    						"user_id"	  => (string) $userinfo->id,
    						"first_name"  => (string) $userinfo->first_name,
    						"last_name"	  => (string) $userinfo->last_name,
    						"email"		  => $userinfo->email,
    						"password"		  => $userinfo->password,
    						"gender"	  => (string) $userinfo->gender,
    						"dob"		  => (string) $userinfo->dob,
    						"profile"	  => (string) $this->getUserProfile($userinfo->id),
    						"social_type" => (string) $userinfo->_type
    					);
					//
    				}else{
    					$this->error('Enable to update password! Please try again.');
    				}
    			}else{
    				$this->error('Wrong old password! Please try again.');
    			}
    		}

    		$user->first_name = !empty($request->input('first_name'))? $request->input('first_name'): $user['first_name'];
    		$user->last_name = !empty($request->input('last_name'))? $request->input('last_name'): $user['last_name'];
    		$user->gender = !empty($request->input('gender'))? $request->input('gender'): $user['gender'];
    		$user->dob = !empty($request->input('dob'))? $request->input('dob'): $user['dob'];

    		if(!empty($request->file('file'))){

    			$file = $request->file('file');
    			$image = $this->uploadS3Data(@$file, 'users');

    			if($image){
    				$user->profile = $image;
    			}
    		}

    		if($user->save()){
    			$userinfo =  User::where('id',$request->input('user_id'))->first();

    			$udata = array(
    				"user_id"	  => (string) $userinfo->id,
    				"first_name"  => (string) $userinfo->first_name,
    				"last_name"	  => (string) $userinfo->last_name,
    				"email"		  => $userinfo->email,
    				"password"		  => $userinfo->password,
    				"gender"	  => (string) $userinfo->gender,
    				"dob"		  => (string) $userinfo->dob,
    				"profile"	  => (string) $this->getUserProfile($userinfo->id),
    				"social_type" => (string) $userinfo->social_type
    			);

                if($request->input('new_password')!=''){
                    $this->success('Congratulations!! Your password has been changed.', $udata);
                }else{
    				$this->success('Update successfully.', $udata);
                }

    		}else{
    			$this->error('Unable to update profile! Please try again.');
    		}
    	}else{
    		$this->error('User does not exist.');
    	}
    }

    /**
     * Logout
     *
     * @param  user_id
     * @return response
     */
    public function changeNotification(Request $request)
    {
    	$this->validation($request->all(), [
    		"user_id" => "required",
    	]);

    	$check_status =  User::where(['id'=>$request->input('user_id')])->first();

    	if(!empty($check_status)){
    		if($check_status->is_notification == 1){
    			$status = 0;
    		}else{
    			$status = 1;
    		}
    		$store_data = User::where(['id'=>$request->input('user_id')])->update(['is_notification' => $status]);
    		if (@$store_data) {
    			$get_notification =  User::where(['id'=>$request->input('user_id')])->first();
    			$response['is_notification'] =  (int) @$get_notification->is_notification;
    			$this->success('update success', $response);
    		}else{
    			$this->error('Something went wrong.', '');
    		}
    	}else{
    		$this->error('user does not exists.', '');
    	}

    }


    /**
     * Logout
     *
     * @param  user_id
     * @return response
     */
    public function logout(Request $request)
    {
    	$this->validation($request->all(), [
    		"user_id" => "required",
    	]);

    	$user =  User::where('id',$request->input('user_id'))->first();

    	if ($user) {

    		$user->device_type = '';
    		$user->device_token = '';
    		if($user->save()){
    			$this->success('Logout successfully.', '');
    		}else{
    			$this->error('Something went wrong.');
    		}
    	}else{
    		$this->error('User does not exists.');
    	}

    }

	/**
     * Get All Tracks
     *
     * @param  user_id
     * @return response
     */
	public function checkSubscription(Request $request)
	{
		$this->validation($request->all(), [
			"user_id" => "required",
		]);

		$result = Subscription::where(['user_id' => $request->input('user_id')])->first();

		if ($result) {

			$expire_date = @$result->expire_date;
			$current_date = date('Y-m-d');

    		// $date_after_period_month = date('Y-m-d', strtotime("$expire_date"));

			if ($expire_date <= strtotime($current_date)) {
				$update = Subscription::where(['id'=> $result->id])->update(['is_expire'=>1]);

				$response['is_subscription'] = 1;
				$response['trail_status'] = @$result->trail_status;
				$response['expire_date'] = @$result->expire_date;
				$this->success('Your subscriptions expired', $response);
			}else{
				$response['is_subscription'] = 0;
				$response['trail_status'] = @$result->trail_status;
				$response['expire_date'] = @$result->expire_date;
				$this->success('You have subscriptions', $response);
			}

		} else{
			$response['is_subscription'] = 2;
			$this->success("You don't have subscriptions.", $response);
		}

	}


	/**
     * Get All Tracks
     *
     * @param  user_id
     * @return response
     */
	public function getTracks(Request $request)
	{
		$user =  User::where('id',$request->input('user_id'))->first();
		$tracks = Song::where(['cat_id'=>'4', 'status'=>'1'])->orderBy('id', 'DESC')->get();

		if(count($tracks)>0)
		{
			foreach ($tracks as $key => $value) {

				$artist_id=$album_id=$playlist_id=$artist=$album=$playlist=$playlist="";

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



    // About Us
	public function aboutUs()
	{
		return view('help_pages.about_us');
	}

	// Privacy Policy
	public function privacyPolicy()
	{
		// return view('help_pages.privacy_policy');
		$data = [];
		$data = Page::select('id', 'title', 'description')->where(['page'=>2])->first();
		$response = [];

		$response['id'] = $data->id;
		$response['title'] = $data->title;
		$response['description'] = $data->description;

		if ($response) {
			$this->success('record found.', $response);
		}else{
			$this->error('record not found.', '');
		}
	}

	// Terms Condtions
	public function termsCondtions()
	{
		$data = [];
		$data = Page::select('id', 'title', 'description')->where(['page'=>1])->first();
		$response = [];

		$response['id'] = $data->id;
		$response['title'] = $data->title;
		$response['description'] = $data->description;

		if ($response) {
			$this->success('record found.', $response);
		}else{
			$this->error('record not found.', '');
		}
	}


	public function testNotification($value='')
	{
		$payload = [];
		$payload = [
			'title' =>'Add new song',
			'body'  => 'New song added',
			'value' => '',
			'type'  => 2
		];

		$send = $this->sendNotification($user = [], $payload);
		if ($send) {
			$this->success('Notification Send', '');
		}else {
			$this->error('Notification failed.', '');
		}
	}


	/**
     * Contact Us
     *
     * @return response
     */
	public function contactUs(Request $request) {
		$this->validation($request->all(), [
			"user_id" => "required",
			"title" => "required",
			"message" => "required",
		]);



		$checkUser = User::where('id', $request->input('user_id'))->first();

		if($checkUser){

			$data = [
				'user_id' =>$request->input('user_id'),
				'title' =>$request->input('title'),
				'message' =>$request->input('message'),
			];
			//DB::enableQueryLog();
			$insert = ContactUs::insert($data);
			//dd(DB::getQueryLog());
			//print_r($insert);
			//die();
			if($insert){
				$data['name'] = @$checkUser->name;
				$data['email'] = @$checkUser->email;
				$name = @$checkUser->name;
				//$send = Mail::send('emails.contact_us', ['data'=>$data], function ($m) use ($data) {

	            	//$m->from(env('MAIL_USERNAME'), 'I Am Application');

	            	//$m->to('support@infobeing.com', 'Iam ')->subject('Iam : Contact Us');
	            	//support@infobeing.com
	            	// $m->to($get_data->email, $get_data->name)->subject('Iam : Confirm Mail');
				//});

				$this->success('Your message has been sent. Thank you!!', '');
			}else{
				$this->error('Unable to contact please try again');
			}
		}else{
			$this->error('Unable to contact please try again.');
		}

	}



}
