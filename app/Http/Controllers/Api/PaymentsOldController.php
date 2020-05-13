<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use PHPMailer\PHPMailer;
use App\User;
use App\keyword;
use App\ContactUs;
use App\Blogs;
use App\Prices;
use App\Transaction;
use App\Notification;
use App\Hit;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Response;
use Auth;
use Mail;
use URL;
use DB;
use File;
use Storage;
use Input;

use Braintree_Customer;
use Braintree_ClientToken;
use Braintree_Transaction;

class PaymentsController extends Controller
{

	// Generate token 
	public function token(Request $request) {

    	$this->validation($request->all(), [
			        "user_id" => "required",
			    ]);

    	$userinfo =  User::where('_id', $request->input('user_id'))->first();
    	
    	if ($userinfo) {
    		if (!empty($userinfo->bt_customer_id)) {
    			$bt_customer_id = $userinfo->bt_customer_id;
    		}else{
    			// braintree create customer
    			$bt_customer_id = ''; 
				$bt_result = Braintree_Customer::create(array(
				    'firstName' => @$userinfo->name,
				    'email' 	=> @$userinfo->email,
				    'phone' 	=> @$userinfo->phone,
				));
				if ($bt_result->success == 1) {
					$update_bt_id = User::where('_id','=', $request->input('user_id'))->update(['bt_customer_id'=>@$bt_result->customer->id]);
					$bt_customer_id = @$bt_result->customer->id;
				}
    			
    		}
    		try {
    			$token = Braintree_ClientToken::generate(["customerId" => @$bt_customer_id]);
	    		if ($token) {
	    			$response['token'] = $token;
	    			$this->success('Token generate successfully.', $response);
	    		}
    		} catch (Exception $e) {
    			$error = $e->getMessage();
    			$this->error($error, null);
    		}
    		
    	}
        $this->error('Something went Wrong, Please try again.', null);
    }


    /**
     * Payment
     *
     * @return response
     */
     public function payment(Request $request) {

    	$this->validation($request->all(), [
			        "user_id" => "required",
			        "nonce" => "required",
			        "iam_quantity" => "required",
			    ]);

    	$userinfo =  User::where('_id', $request->input('user_id'))->first();
    	$iam_price =  Prices::where('_id', '5b55b42fb214de1bd0abbe52')->first();
    	// $nonceFromTheClient = Braintree_PaymentMethodNonce::find($find);
    	if ($userinfo) {
    		try {
    			$amount = $iam_price->value * $request->input('iam_quantity');
    			$result = Braintree_Transaction::sale(array(
				    'amount' => $amount,
				    'paymentMethodNonce' => $request->input('nonce'),
				    'customer' => array(
                        // 'id' => $userinfo->bt_customer_id
				        'id' => null
				    ),
				    'options' => array(
				        'storeInVaultOnSuccess' => true,
				    )
				));
	    		if ($result->success == 1) {
                    $data = ['user_id'=>$request->input('user_id'), 'opponent_id'=>'0', 'payment_type' => '1', 'quantity'=>$request->input('iam_quantity'), 'price'=>$iam_price->value, 'total_amount'=>$amount, 'transaction_id'=>$result->transaction->id, 'created_at'=>date('Y-m-d H:i:s')];
                    $store_data = Transaction::insert($data);
                    if ($store_data) {
                    	$update_iam = $userinfo->iam_balance + $request->input('iam_quantity');
                		$user_iam_update = User::where('_id','=', $request->input('user_id'))->update(['iam_balance'=>@$update_iam]);
                    }
	    			$response['transaction'] = $result->transaction->id;
	    			$response['iam_balance'] = (string) @$update_iam;
	    			$this->success('Payment successfully.', $response);
	    		}else{
	    			$this->error($result->message, null);
	    		}
    		} catch (Exception $e) {
    			$error = $e->getMessage();
    			$this->error($error, null);
    		}
    		
    	}else{
        	$this->error('User id does not exists.', null);
    	}
    }

    /**
     * Payment
     *
     * @return response
     */
     public function sendIam(Request $request) {

    	$this->validation($request->all(), [
			        "user_id" => "required",
			        "opponent_id" => "required",
			        "iam_quantity" => "required",
			    ]);

    	$userinfo =  User::where('_id', $request->input('user_id'))->first();
    	$opponentinfo =  User::where('_id', $request->input('opponent_id'))->first();
    	if ($userinfo && $opponentinfo) {
    		
    		$iam_price =  Prices::where('_id', '5b55b42fb214de1bd0abbe52')->first();
    		

			$amount = $iam_price->value * $request->input('iam_quantity');
			
			if ($userinfo->iam_balance <  $request->input('iam_quantity')) {
				$this->error("Balance too low. To increase your balance, either donate to the Foundation or earn IAM by doing things for others.", null);
			}else{
				$data = ['user_id'=>$request->input('user_id'), 'opponent_id'=>$request->input('opponent_id'), 'payment_type' => '2', 'quantity'=>$request->input('iam_quantity'), 'price'=>$iam_price->value, 'total_amount'=>$amount, 'transaction_id'=>'', 'created_at'=>date('Y-m-d H:i:s')];
                $store_data = Transaction::insert($data);
                if ($store_data) {
                	$update_user_iam = $userinfo->iam_balance - $request->input('iam_quantity');
                	$user_iam_update = User::where('_id','=', $request->input('user_id'))->update(['iam_balance'=>@$update_user_iam]);
                	if ($user_iam_update) {
                		$updated_opponent_iam = $opponentinfo->iam_balance + $request->input('iam_quantity');
                		$opponent_iam_update = User::where('_id','=', $request->input('opponent_id'))->update(['iam_balance'=>@$updated_opponent_iam]);
                		if ($opponent_iam_update) {
                			$opponent_iam_balance =  User::where('_id', $request->input('opponent_id'))->first();
                			$opponent_iam_balance = $opponent_iam_balance->iam_balance;
                		}else{
                			$opponent_iam_balance = $updated_opponent_iam;
                		}
                		//send notification
                		$sender_name = $userinfo->name;
                		$send_notification = $this->sendNotification($opponentinfo, ['title'=>'Receive Iam', 'body'=> $sender_name.' send '.$request->input('iam_quantity').' iam', 'value'=>$opponent_iam_balance, 'type'=>1], $request->input('user_id'));
    					$this->success('Send iam successfully.' , ['iam_balance'=> (string) @$update_user_iam]);
                	}else{
                		$this->error('Something went wrong.', null);
                	}

                }else{
                	$this->error('Something went wrong.', null);
                }
			}

    	}else{
        	$this->error('User id does not exists.', null);
    	}
    }

    /**
     * Get public keyword list
     *
     * @return response
     */
	public function sendImHistory(Request $request) {

		$this->validation($request->all(), [
			        "user_id" => "required",
			    ]); 
  
    	$userinfo =  User::where('_id', $request->input('user_id'))->first();
    	if ($userinfo) {
    		$data = [];
    		$data = Transaction::where(['user_id'=>$request->input('user_id'),  'payment_type'=> '2'])->orderBy('created_at', 'DESC')->with('getOpponentUser')->get();
		    $response = [];
		    $response['send_history'] = [];
		    foreach ($data as $key => $value) {
		    	$response['send_history'][] = [
		    		'id'  => $value['id'],
		    		'user_id'  => (string) $value['getOpponentUser']->id,
		    		'name'  => $value['getOpponentUser']->name,
		    		'quantity'  =>  (string) $value['quantity'],
		    		'profile'  => $this->getUserProfile($value['getOpponentUser']->id),
		    		'date'  => date($value['created_at']),
		    	];
		    }
		    $response['request_coming_history'] = $this->getRequestComingHistory($request->input('user_id'));
		    $this->success('record found', $response);
    	}else{
    		$this->error('User id does not exists.', null);
    	}
		
	}

	/**
     * Get Receive Im History
     *
     * @return response
     */
	public function receiveImHistory(Request $request) {

		$this->validation($request->all(), [
			        "user_id" => "required",
			    ]); 
  
    	$userinfo =  User::where('_id', $request->input('user_id'))->first();
    	if ($userinfo) {
    		$data = [];
    		$data = Transaction::where(['opponent_id'=>$request->input('user_id')])->orderBy('created_at', 'DESC')->with('getUser')->get();
		    $response = [];
		    $response['receive_history'] = [];
		    foreach ($data as $key => $value) {
		    	if ($value['payment_type'] == 2) {
		    		$response['receive_history'][] = [
		    			'id' => $value['id'],
		    			'user_id' => (string) $value['getUser']->id,
		    			'name' => $value['getUser']->name,
		    			'quantity' =>  (string) $value['quantity'],
		    			'profile' => $this->getUserProfile($value['getUser']->id),
		    			'date' => date($value['created_at']),
		    		];
		    	}
		    }
		    $response['request_history'] = $this->getRequestHistory($request->input('user_id'));
		    $this->success('record found', $response);
    	}else{
    		$this->error('User id does not exists.', null);
    	}
		
	}

	public function getRequestHistory($user_id = '') {
		$data = [];
		$data = Transaction::where(['user_id'=>$user_id, 'payment_type'=>"3"])->orderBy('created_at', 'DESC')->with('getOpponentUser')->get();
	    $response = [];
	    foreach ($data as $key => $value) {
    		$response[] = [
    			'id' => $value['id'],
    			'user_id' => (string) $value['opponent_id'],
    			'name' => $value['getOpponentUser']->name,
    			'quantity' =>  (string) $value['quantity'],
    			'profile' => $this->getUserProfile($value['opponent_id']),
    			'date' => date($value['created_at']),
    		];
	    }
	    return $response;
	}

	public function getRequestComingHistory($user_id = '') {
		$data = [];
		$data = Transaction::where(['opponent_id'=>$user_id, 'payment_type'=>"3"])->orderBy('created_at', 'DESC')->with('getUser')->get();
	    $response = [];
	    foreach ($data as $key => $value) {
    		$response[] = [
    			'id' => $value['id'],
    			'user_id' => (string) $value['user_id'],
    			'name' => $value['getUser']->name,
    			'quantity' =>  (string) $value['quantity'],
    			'profile' => $this->getUserProfile($value['user_id']),
    			'date' => date($value['created_at']),
    		];
	    }
	    return $response;
	}

	/**
     * Get payment history
     *
     * @return response
     */
	public function paymentHistory(Request $request) {

		$this->validation($request->all(), [
			        "user_id" => "required",
			    ]); 
  
    	$userinfo =  User::where('_id', $request->input('user_id'))->first();
    	if ($userinfo) {
    		$data = [];
    		$data = Transaction::where(['user_id'=>$request->input('user_id'),  'payment_type'=> '1'])->orderBy('created_at', 'DESC')->with('getUser')->get();
		    $response = [];
		    foreach ($data as $key => $value) {
		    	$response[$key]['id'] = $value['id'];
		    	$response[$key]['user_id'] = (string) $value['getUser']->id;
		    	$response[$key]['name'] = $value['getUser']->name;
		    	$response[$key]['transaction_id'] =  (string) $value['transaction_id'];
		    	$response[$key]['quantity'] =  (string) $value['quantity'];
		    	$response[$key]['price'] =  (string) $value['price'];
		    	$response[$key]['total_amount'] =  (string) $value['total_amount'];
		    	$response[$key]['profile'] = $this->getUserProfile($value['getUser']->id);
		    	$response[$key]['date'] = date($value['created_at']);
		    }
		    if ($response) {
		    	$this->success('record found', $response);
		    }else{
		    	$this->error('No payment history.', []);
		    }
    	}else{
    		$this->error('User id does not exists.', []);
    	}
		
	}


	/**
     * Get search user
     *
     * @return response
     */
    public function searchUsers(Request $request) {
    	$this->validation($request->all(), [
	        "search_keyword" => "required",
	    ]);

		$users = User::where('username', 'like', '%' . $request->input('search_keyword') . '%')->orWhere('name', 'like', '%' . $request->input('search_keyword') . '%')->get();
		
		if (count($users)) {
			$response = [];
			foreach ($users as $key => $value) {
				$response[] = [
					"user_id"   =>  $value->id,
					"username"  =>  (string) $value->username,
					"user_name" =>  (string) $value->name,
					"profile" 	=> $this->getUserProfile($value->id),
				];
			}
			if (count($response)) {
				$this->success('record found.', $response);
			}else{
				$this->error('record not found.', []);
			}
			
		}else{
			$this->error('record not found.', []);
		}
	
    }

    //get user profile using from user_id
    public function getUserProfile($user_id='') {

    	$userinfo =  User::where('_id', $user_id)->first();
    	$picture = "";
    	if ($userinfo) {
    		if(strstr($userinfo->profile, 'https://')){
				$picture = $userinfo->profile;
			}elseif(!empty($userinfo->profile)){
				$picture = URL::to('/uploads/users/').'/'.$userinfo->profile;
			}
    	}
    	return $picture;
    	
    }

    /**
     * Request
     *
     * @return response
     */
     public function requestIam(Request $request) {

    	$this->validation($request->all(), [
			        "user_id" => "required",
			        "opponent_id" => "required",
			        "iam_quantity" => "required",
			    ]);

    	$userinfo =  User::where('_id', $request->input('user_id'))->first();
    	$opponentinfo =  User::where('_id', $request->input('opponent_id'))->first();
    	if ($userinfo && $opponentinfo) {
    		

    		$iam_price =  Prices::where('_id', '5b55b42fb214de1bd0abbe52')->first();
    		$sender_name = $userinfo->name;
    		
    		//store history
    		$data = ['user_id'=>$request->input('user_id'), 'opponent_id'=>$request->input('opponent_id'), 'payment_type' => '3', 'quantity'=>$request->input('iam_quantity'), 'price'=>$iam_price->value, 'total_amount'=> $iam_price->value * $request->input('iam_quantity'), 'transaction_id'=>'', 'created_at'=>date('Y-m-d H:i:s')];
            $store_data = Transaction::insert($data);
    		
    		//send notification
    		$send_notification = $this->sendNotification($opponentinfo, ['title'=>'Request Iam', 'body'=> $sender_name.' request for '.$request->input('iam_quantity').' iam', 'type'=>2], $request->input('user_id'));

    		// if (!empty($send_notification)) {
    		if (1==1) {
    			$this->success('success', '');
    		}else{
    			$this->error('notification not send', '');
    		}
    	}else{
        	$this->error('User id does not exists.', '');
    	}
    }

    /**
     * Get Notification
     *
     * @return response
     */
	public function getNotifications(Request $request) {

		$this->validation($request->all(), [
			        "user_id" => "required",
			    ]); 
  
    	$userinfo =  User::where('_id', $request->input('user_id'))->first();
    	if ($userinfo) {
    		$data = [];
    		$data = Notification::where(['receiver_id'=>$request->input('user_id')])->orderBy('created_at', 'DESC')->with('getSenderInfo')->get();
		    $response = [];
		    foreach ($data as $key => $value) {
		    	$response[$key]['id'] = $value['id'];
		    	$response[$key]['sender_name'] = (string) $value['getSenderInfo']->name;
		    	$response[$key]['title'] =  (string) $value['title'];
		    	$response[$key]['message'] =  (string) $value['message'];
		    	$response[$key]['sender_profile'] = $this->getUserProfile($value['sender_id']);
		    	$response[$key]['date'] = date($value['created_at']);
		    }
		    if ($response) {
		    	$this->success('record found', $response);
		    }else{
    			$this->error('No notifications found.', null);
		    }
    	}else{
    		$this->error('User id does not exists.', null);
    	}
		
	}

	/**
     * Register with socail(login and signup)
     *
     * @return response
     */
	public function register(Request $request)
	{
	    if ($request->input('socail_type') == ('gmail' || 'facebook') ) {
		
			$this->socailLogin($request);
		} else{

	    	$this->validation($request->all(), [
		        "name" => "required",
		        "username" => "required|unique:users,username",
		        "email" => "required|email|unique:users,email",
		        "password" => "required",
		        "confirm_password" => "required|same:password",
		    ]);
	    	
	    	$profile_name = '';

		    if(!empty($request->file('file'))){
				$file = $request->file('file');
				$extension = $file->getClientOriginalExtension();
				$filename = $file->getFilename().'.'.$extension;
				if($file->move(public_path('/uploads/users'),$filename)){
					$profile_name = $filename;
				}
			}

	    	$data = [
	    		'name'=> $request->input('name'),
	    		'username'=> $request->input('username'),
	    		'email'=> $request->input('email'),
	    		'profile'=> $profile_name,
	    		'password'=> password_hash($request->input('password'), PASSWORD_DEFAULT),
	    	];

		    if ($save = User::create($data)) {
		    	$get_data = User::where(['_id'=>$save->id])->first();

		    	$response['user_id'] = $get_data->id;
		    	$response['name'] = $get_data->name;
		    	$response['username'] = $get_data->username;
		    	$response['email'] = $get_data->email;
		    	$response['profile'] = $get_data->profile!==null? URL::to('/uploads/users/').'/'.$get_data->profile:"";
		    	$response['device_type'] = (string) $get_data->device_type;
		    	$response['device_token'] = (string) $get_data->device_token;

		    	$this->success('register successfully.', $response);
		    }else{
		    	$this->error('something went wrong.');
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
	        "socail_id" => "required",
	        "name" => "required",
	        "email" => "required|email",
	    ]);

		$get_data = User::where(['socail_id'=>$request->input('socail_id')])->first();
		$this->device_type = '';
		$this->device_token = '';
		if (!empty($get_data)) {
			$get_data->device_type  = $request->input('device_type');
			$get_data->device_token  = $request->input('device_token');

			$update = $get_data->save();

			$response['user_id'] = $get_data->id;
	    	$response['name'] = $get_data->name;
	    	$response['username'] = $get_data->username;
	    	$response['email'] = $get_data->email;
	    	$response['socail_id'] = $get_data->socail_id;
	    	$response['socail_type'] = $get_data->socail_type;
	    	$response['profile'] = $get_data->profile!==null? $get_data->profile:"";
	    	$response['device_type'] = (string) $get_data->device_type;
	    	$response['device_token'] = (string) $get_data->device_token;

		    $this->success('login successfully.', $response);
		}else{

			// if(!empty($request->file('file'))){

			// 	$file = $request->file('file');
			// 	$extension = $file->getClientOriginalExtension();
			// 	$filename = $file->getFilename().'.'.$extension;
			// 	if($file->move(public_path('/uploads/users'),$filename)){
			// 		$profile_name = $filename;
			// 	}
			// }

			$data = [
				'name'=> $request->input('name'),
				'email'=> $request->input('email'),
				'username'=> $request->input('username'),
				'socail_id'=> $request->input('socail_id'),
				'socail_type'=> $request->input('socail_type'),
				'profile'=> $request->input('file'),
				'device_type'=> $request->input('device_type'),
				'device_token'=> $request->input('device_token'),
			];

			if ($save = User::create($data)) {
		    	$get_data = User::where(['_id'=>$save->id])->first();

		    	$response['user_id'] = $get_data->id;
		    	$response['name'] = $get_data->name;
		    	$response['username'] = $get_data->username;
		    	$response['email'] = $get_data->email;
		    	$response['socail_id'] = $get_data->socail_id;
		    	$response['socail_type'] = $get_data->socail_type;
		    	$response['profile'] = $get_data->profile!==null? $get_data->profile:"";
		    	$response['device_type'] = (string) $get_data->device_type;
		    	$response['device_token'] = (string) $get_data->device_token;

		    	$this->success('register successfully.', $response);
		    }else{
		    	$this->error('something went wrong.');
		    }
		}

	}


    /**
     * Simple login without socail
     *
     * @return response
     */    
    
	public function login(Request $request)
    {
		$this->validation($request->all(), [
	        "email" => "required|email",
	        "password" => "required",
	    ]);

		$userdata = array(
			'email'     => $request->input('email'),
			'password'  =>	$request->input('password'),
		);

		// attempt to do the login
		if (Auth::attempt($userdata)) {

			$public =  Keyword::where('user_id', Auth::id())->where('key_type','public')->pluck('value')->toArray();
			$private =  Keyword::where('user_id', Auth::id())->where('key_type','private')->pluck('value')->toArray();
			
			$userinfo =  User::where('_id', Auth::id())->with('getKeywords')->first(); 
			 
			if ($userinfo) {
				$userinfo->device_type = $request->input('device_type');
				$userinfo->device_token = $request->input('device_token');
				
				//update device_type and device_token
				$userinfo->save();

				$data = [
					"user_id" 	 		=> $userinfo->id,
					"name"	 		=> $userinfo->name,
					"username"	 	=> $userinfo->username,
					"email"	 		=> $userinfo->email,
					"device_type"	=> (string) $userinfo->device_type,
					"device_token"	=> (string) $userinfo->device_token,
					"device_token"	=> (string) $userinfo->device_token,
					"profile" 		=> $userinfo->profile!==null? URL::to('/uploads/users/').'/'.$userinfo->profile:"",
					"public_keyword"	=> (string) implode(', ', $public),
					"private_keyword"	=> (string) implode(', ', $private),
				];

				$this->success('Login successfully.', $data);
			}else{
				$this->error('Invalid user! Please try again.', null);
			}
		} else {        
			$this->error('Email or password does not match!! Please try again.', null);
		}

    }

    // public function getKeywords($user_id='') {
    // 	$result = [];
    // 	$response = [];
    // 	$result =  Keyword::where('user_id', $user_id)->toArray();
    // 	dd($result);
    // }

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
	
		$userinfo =  User::where('email',$request->input('email'))->first(); 

		// attempt to do the login
		if ($userinfo) {

			
			$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

			// $password = substr(str_shuffle(str_repeat($pool, 8)), 0, 8);
			$password = '123456';
			
			$userinfo->password  = bcrypt($password);
			if($userinfo->save()){
					
			$to = $userinfo->email;
			$subject = 'Iam : Reset passowrd';
			$sender = 'no-reply@imarkinfotech.com';

			$message = $this->forgetTemp($userinfo->name, $password);

			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= "X-Mailer: PHP \r\n";
			$headers .= 'From: '.$sender.' < '.$sender.'>' . "\r\n";

			$mail = mail($to, $subject, $message, $headers ); 
			$this->success('Your new password has been sent to your email.', '');
		}else{

			$this->error('Unable to reset your password!! Please try again.');
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
			
		$user =  User::where('_id',$request->input('user_id'))->first(); 
		
		$userdata = array(
			'email'     => $user->email,
			'password'  =>	$request->input('old_password'),
		);

		// attempt to do the login
		if (Auth::attempt($userdata)) { 

			$user->password = bcrypt($request->input('new_password'));
			if($user->save()){
				$this->success('Congratulation!! Your password has been changed.', '');
			}else{
				$this->error('Enable to update password! Please try again.');
			}
		}else{
			$this->error('Wrong old password! Please try again.');
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

		$userinfo =  User::where('_id',$request->input('user_id'))->first(); 

		if($userinfo){
			
			if(strstr($userinfo->profile, 'https://')){
				$picture = $userinfo->profile;
			}elseif(!empty($userinfo->profile)){
				$picture = URL::to('/uploads/users/').'/'.$userinfo->profile;
			}else{
				$picture = "";
			}
			
			$udata = array(
				"user_id"		=>$userinfo->id,
				"username"		=>$userinfo->username,
				"email"			=>$userinfo->email,
				"name"			=>$userinfo->name,
				"email"			=>$userinfo->email,
				"profile"		=>$picture,
				"device_type"	=>(string) $userinfo->device_type,
				"device_token"	=>(string) $userinfo->device_token,
				"public_keyword"=> $this->getPublicKeywords($userinfo->id),
			);
			
			$this->success('success', $udata);
		}else{
			$this->error('User does not exist.');
		}

    }

    /**
     * Get public keyword list
     *
     * @return response
     */
	public function getPublicKeywords($user_id = '') {
		$data = [];
	    $data = Keyword::select('id', 'key_type', 'value')->where(['user_id'=>$user_id,  'key_type'=> 'public'])->get();
	    $response = [];
	    foreach ($data as $key => $value) {
	    	$response[$key]['id'] = $value['id'];
	    	$response[$key]['key_type'] = $value['key_type'];
	    	$response[$key]['value'] = $value['value'];
	    }
	    
	    return $response;

	}


    /**
     * Edit Profile
     *
     * @return response
     */
    public function editProfile(Request $request) {
		$this->validation($request->all(), [
	        "user_id" => "required",
	        "name" 	  => "required",
	        "phone" => "required",
	    ]);
		
		$user =  User::where('_id',$request->input('user_id'))->first(); 
		
		$user->name 	= !empty($request->input('name'))? $request->input('name'): $user['name'];
		$user->phone  	= !empty($request->input('phone'))? $request->input('phone'): $user['phone'];
			
		if(!empty($request->file('file'))){
			$file = $request->file('file');
			$extension = $file->getClientOriginalExtension();
			$filename = $file->getFilename().'.'.$extension;
			if($file->move(public_path('/uploads/users/'),$filename)){
				$user->profile = $filename;
			}
		}
			
		if($user->save()){
			$userinfo =  User::where('_id',$request->input('user_id'))->first(); 
			
			if(strstr($userinfo->profile, 'https://')){
				$picture = $userinfo->profile;
			}elseif(!empty($userinfo->profile)){
				$picture = URL::to('/uploads/users/').'/'.$userinfo->profile;
			}else{
				$picture = "";
			}
			
			$udata = array(
				"user_id"	=>$userinfo->id,
				"username"	=>$userinfo->username,
				"name"		=>$userinfo->name,
				"email"		=>$userinfo->email,
				"phone"		=>$userinfo->phone,
				"profile"	=>$picture,
			);

			$this->success('Update successfully.', $udata);
		}else{
			$this->error('Enable to update profile! Please try again.');
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
		return view('help_pages.privacy_policy');
	}

	// Terms Condtions
	public function termsCondtions()
	{
		return view('help_pages.terms_condition');
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
		
		$checkUser = User::where('_id', $request->input('user_id'))->first();
		
		if($checkUser){ 

			$data = [
				'user_id' =>$request->input('user_id'),
				'title' =>$request->input('title'),
				'message' =>$request->input('message'),
			];

			$insert = ContactUs::insert($data);
			dd($insert);
			if($insert){

				$this->success('Thanks for contact with us', '');
			}else{
				$this->error('Unable to contact please try again');
			}
		}else{
			$this->error('Unable to contact please try again.');
		}
			
    }

    /**
     * Get blog list
     *
     * @return response
     */
	public function getBlogs(Request $request)
	{
		$data = [];
	    $data = Blogs::select('id', 'title', 'description')->orderBy('created_at', 'DESC')->get();
	    $response = [];
	    foreach ($data as $key => $value) {
	    	$response[$key]['id'] = $value['id'];
	    	$response[$key]['title'] = $value['title'];
	    	$response[$key]['description'] = $value['description'];
	    }
	    if ($response) {
	    	$this->success('record found.', $response);
	    }else{
	    	$this->error('record not found.', '');
	    }

	}












    // OLD
	
	
	public function signup(Request $request)
    {
		if($request->input('socialId') <> null && !empty($request->input('socialId') && $request->input('socialId') <> '')){
			
			$socialId = $request->input('socialId');
			$socialType = $request->input('socialType');
			$name = $request->input('username');
			$email = $request->input('email');
			$profilePic = $request->input('profile_Pic');
			
			$deviceToken = $request->input('deviceToken'); 
			$deviceType = $request->input('deviceType'); 
			
			$this->validation($request->all(), [
				        "socialId" => "required",
				        "socialType" => "required",
				        "email" => "required",
				    ]);

			$userData = User::where('email',$email)->where('socail_type',$socialType)->where('socail_id',$socialId)->first();
			
			if(count($userData) == 0){
				
			$users = new User(array(
					'socail_type' =>  $socialType,
					'socail_id' =>  $socialId,
					'deviceType' =>  $deviceType,
					'deviceToken' =>  $deviceToken,
					'username' => $name,
					'first_name' => $request->input('first_name'),
					'last_name' => $request->input('last_name'),
					'email' =>  $email,
					'profile_pic' =>  $profilePic,
					'role' =>  $request->input('role'),
					'last_login' =>  date('Y-m-d'),
				)); 
						
				if($users->save()){
					$insertedId = $users->id;
					
					$userinfo = User::where('id','=',$insertedId)->first();

					if ($request->input('role') == 1)
					{
						// braintree create customer 
						$bt_result = Braintree_Customer::create(array(
						    'firstName' => "$userinfo->first_name",
						    'lastName' => "$userinfo->last_name",
						    'email' => "$userinfo->email",
						    'phone' => "$userinfo->phone",
						));
						if ($bt_result->success == 1) {
							$updare_bt_id = User::where('id','=',$insertedId)->update(['bt_customer_id'=>@$bt_result->customer->id]);
						}
					}					

					$udata =[
						"userId"=>"$userinfo->id",
						"username"=>"$userinfo->username",
						"firstName"=>"$userinfo->first_name",
						"last_name"=>"$userinfo->last_name",
						"email"=>"$userinfo->email",
						"phone"=>"$userinfo->phone",
						"profilePic"=>$userinfo->profile_pic!==null? $userinfo->profile_pic:"",
						"menberFrom"=>date('d-M-Y',strtotime($userinfo->created_at)),
						"role"=>$userinfo->role == 2?"instructor":"student",
					];
					$this->success('success', $udata);
				}else{
					$this->error('Unable to login!! Please try again.');
				}
			}else{
				
				$userData->deviceType = $deviceType;
				$userData->deviceToken = $deviceToken;
				
				$userData->last_login = date('Y-m-d');

				if (empty($userData->bt_customer_id) && $userData->role == 1) {
					// braintree create customer 
					$bt_result = Braintree_Customer::create(array(
					    'firstName' => $userData->first_name,
					    'lastName' => $userData->last_name,
					    'email' => $userData->email,
					    'phone' => $userData->phone,
					));
					if ($bt_result->success == 1) {
						$updare_bt_id = User::where('id','=', $userData->id)->update(['bt_customer_id'=>@$bt_result->customer->id]);
					}
				}

				$save = $userData->save();
				

				if(strstr($userData->profile_pic, 'https://')){
					$picture = $userData->profile_pic;
				}elseif(!empty($userData->profile_pic)){
					$picture = URL::to('/public/users/').'/'.$userData->profile_pic;
				}else{
					$picture = "";
				}
				
				$udata =[
					"userId"=>"$userData->id",
					"username"=>"$userData->username",
					"firstName"=>"$userData->first_name",
					"last_name"=>"$userData->last_name",
					"email"=>"$userData->email",
					"phone"=>"$userData->phone",
					"profilePic"=>$picture,
					"menberFrom"=>date('d-M-Y',strtotime($userData->created_at)),
					"role"=>$userData->role == 2?"instructor":"student",
				];
				
				$this->success('success', $udata);
			}
			
		}else{
	
			$role = $request->input('role'); 
			$username = $request->input('username'); 
			$first_name = $request->input('first_name'); 
			$last_name = $request->input('last_name'); 
			$phone = $request->input('phone'); 
			$email = $request->input('email'); 
			$password = $request->input('password'); 
			$confirmPassword = $request->input('confirmPassword'); 
			
			$deviceToken = $request->input('deviceToken'); 
			$deviceType = $request->input('deviceType'); 
			
			$this->validation($request->all(), [
				        "email" => "required",
				        "password" => "required",
				        "confirmPassword" => "required",
				    ]);
				
			$userCheck =  User::where('email',$email)->count(); 
				
			if($userCheck){
				$this->error('Email you have enter already exist!! Please enter another email.');
			}else{
					
				$users = new User(array(
					'username' 		=>  $username,
					'first_name' 	=>  $first_name,
					'last_name'		=>  $last_name,
					'phone' 		=>  $phone,
					'email' 		=>  $email,
					'password' 		=> bcrypt($password),
					'deviceType' 	=>  $deviceType,
					'deviceToken' 	=>  $deviceToken,
					'role'			=>  $role,
				)); 
				
				if($users->save()){
					$insertedId = $users->id;
					$userinfo =  User::where('id',$insertedId)->first(); 
					
					if (empty($userinfo->bt_customer_id) && $role == 1) {
						// braintree create customer 
						$bt_result = Braintree_Customer::create(array(
						    'firstName' => $userinfo->first_name,
						    'lastName' => $userinfo->last_name,
						    'email' => $userinfo->email,
						    'phone' => $userinfo->phone,
						));
						if ($bt_result->success == 1) {
							$updare_bt_id = User::where('id','=', $insertedId)->update(['bt_customer_id'=>@$bt_result->customer->id]);
						}
					}
					
					$udata = array(
						"userId"	=>"$userinfo->id",
						"username"	=>"$userinfo->username",
						"firstName"	=>"$userinfo->first_name",
						"last_name"	=>"$userinfo->last_name",
						"email"		=>"$userinfo->email",
						"phone"		=>"$userinfo->phone",
						"profilePic"=>$userinfo->profile_pic!==null? URL::to('/public/users/').'/'.$userinfo->profile_pic:"",
						"menberFrom"=>date('d-M-Y',strtotime($userinfo->created_at)),
						"role"		=>$userinfo->role == 2?"instructor":"student",
					);
					
					$this->success('success', $udata);
				}else{
					//$result = array("response"=>"0","status"=>"fail","message"=>"Unable to register!! Please try again.");
					$this->error('Unable to register!! Please try again.');
				}
			}
	    }
	}


    

	
	
	
	

	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function forgetPassword(Request $request)
    {
		$email = $request->input('email');
		$this->validation($request->all(), [
			        "email" => "required",
			    ]);
	
		$userinfo =  User::where('email',$email)->where('role','<>',0)->first(); 

			// attempt to do the login
			if ($userinfo) {
				
				$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

				$password = substr(str_shuffle(str_repeat($pool, 16)), 0, 16);
				
				$userinfo->password  = bcrypt($password);
				if($userinfo->save()){
						
				$to = $userinfo->email;
				$subject = 'The University Collage: Reset passowrd';
				$sender = 'no-reply@imarkinfotech.com';

				$message = $this->forgetTemp($userinfo->name, $password);

				$headers = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= "X-Mailer: PHP \r\n";
				$headers .= 'From: '.$sender.' < '.$sender.'>' . "\r\n";

				$mail = mail( $to, $subject, $message, $headers ); 
					
				$this->success('Your new password has been sent to your email.');
			}else{

				$this->error('Unable to reset your password!! Please try again.');
			}
				
		} else {        

			$this->error('Email does not exist!! Please enter valid email.');
		}
			
    }
	
	function forgetTemp($username, $password){
		
		$message = '<table cellspacing="0" border="0" align="center" cellpadding="0" width="600" style="border:1px solid #ccc; margin-top:10px;">
			<tr>
				<td>
					<table cellspacing="0" border="0" align="center" cellpadding="20" width="100%">
				
						<tr align="center" >
							<td style="font-family:arial; padding-bottom:40px;"><strong>
							<img src="'.URL::to('/public/email/').'/'.'Logonew.jpg" alt="IBREEZE"></img>
							</strong></td>
						</tr>
					</table>
					<table cellspacing="0" border="0" align="center" cellpadding="10" width="100%" style="border:0px solid #efefef; margin-top:0px; padding:40px;">
						<tr>
						<td><h2>Hello: '.$username.'</h2></td>
						</tr>
						<tr>
						<td><p><h4>You have send request get your password.<h4></p></td>
						</tr>
						<tr>
						<td><p><h4>Your password has been updated with auto generated system.<h4></p></td>
						</tr>
						<tr>
						<td><p><h4>You New passowrd is: '.$password.'.<h4></p></td>
						</tr>
						<tr>
							<td>
								<table cellspacing="0" border="0" cellpadding="0" width="100%">	
									<tr>
										<td><h3>Best Regard</h3>
											<h3>Iam Team</h3>
										</td>
									</tr>
								</table>
							</td>
							<td width="30"></td> 
						</tr>
					</table>
					<table cellspacing="0" border="0" align="center" cellpadding="0" width="100%" style="border:0px solid #efefef; margin-top:20px; padding:0px;">
						<tr>
							<td align="center" style="font-family:PT Sans,sans-serif; font-size:13px; padding:15px 0; border-top:1px solid #efefef;"> 
							<b>Iam Team</b></strong></td> 
						</tr>
					</table>
				</td>   
			</tr>
		</table>';
		
		return $message;
		
	}

    public function lastLogin(Request $request)
    {
		if(empty($request->input('userId'))){
			//$result = array("response"=>"0","status"=>"fail","message"=>"Oops!! Un-know user found.");
			$result = array("success"=>"0","result"=>null,"error"=>"Oops!! Un-know user found.");
		}else{
			
			$user =  User::where('id',$request->input('userId'))->first(); 
			$user->last_login    = date('Y-m-d');
			if($user->save()){
				
				//$result = array("response"=>"1","status"=>"success","message"=>"Your last login date saved successfully.");
				$result = array("success"=>"1","result"=>"Your last login date saved successfully.","error"=>"No error found.");
			}else{
				//$result = array('response'=>"0",'status'=>'fail','message'=>'Enable to update profile! Please try after som time.');
				$result = array("success"=>"0","result"=>null,"error"=>"Enable to update profile! Please try after som time.");
			}
		}
    	return Response::json($result);
    }
}
