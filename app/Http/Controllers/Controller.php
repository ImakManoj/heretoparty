<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Response;
use App\Notification;
use App\User;
use App\Subscription;
use Illuminate\Support\Facades\Validator;

// use Storage;
use Illuminate\Contracts\Filesystem\Filesystem;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Storage;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

     //for notification
    /**
	* Suppoted devices to send push Notifications
	* IOS
	* ANDROID
	*/
	const DEVICES = ['ios', 'android'];
	/**
	* Pass phrase of IOS
	* @var null
	*/
	private $passPhrase = null;
	/**
	* Headers for android
	* @var array
	*/
	private $headers = array();
	/**
	* Device Token
	* @var null
	*/
	private $deviceToken = null;

    private function setResponse(array $response) {
		header('Content-Type: application/json');
		echo json_encode($response);
		exit;
	}

		// echo response()->json($response);
		// echo Response::json($response);
	/**
	 * if operation successfully performed
	 * @param  int $msg  Message t obe displayed
	 * @param  array  $data data to return with success message
	 * @return callback
	 */
	public function success($msg = "Success", $data = array()) {
		return $this->setResponse(array('code' => "200", 'success' => true, 'messages' => $msg, 'data' => $data ) );
	}
	/**
	 * If operation was'nt performed successfully
	 * @param  string $error Error Message
	 * @return callback
	 */
	public function error($messages = "Error", $data = null, $code = 400) {
		return $this->setResponse(array('code' => $code, 'success' => false, 'messages' => $messages, 'data'=> $data));
	}

	public function validation($request='', $rules = [], $messages = [])
    {
    	$validator = Validator::make($request, $rules, $messages);

	    if ($validator->fails()) {
	        $this->error(@$validator->errors()->all()[0]);
	    }
    }

	 /**
	 * Return Json response
	 * @param  array  $response Response array
	 * @return json
	 */
	public function notification($payload = array(), $registration_ids = []) {
		//legacy_key from fcm server
		$legacy_key = 'AIzaSyCwfn1y5k-FQ2LS3676V-Ye2wf2XPh14v8'; //kizz cloud
        $fcm_url = 'https://fcm.googleapis.com/fcm/send';
        $token=$this->deviceToken;
        $notification = [
            'title' => @$payload['title'],
            'body' => @$payload['body'],
            'sound' => true,
        ];
        $extra_notificationData = ["message" => $notification];

        $fcm_notification = [
            'registration_ids' => $registration_ids, //multple token array
            // 'to'        => @$token, //single token
            'notification' => $notification,
            'data' => ['value'=> (string) @$payload['value'], 'type'=> (string) @$payload['type'] ],
            // 'data' => $extra_notificationData
        ];
        $headers = [
            'Authorization: key='.$legacy_key.' ',
            'Content-Type: application/json'
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcm_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcm_notification));
        $result = curl_exec($ch);
        curl_close($ch);

        return true;
    }

    /**
    * Send Push Notification
    * @param  object $user    User Object
    * @param  array $payLoad Payload
    * @return mixed
    */
	public function sendNotification($user = array(), $payload = [] ) {
		$token = trim(@$user->device_token);
		$device_type = trim(@$user->device_type);
		$users = Subscription::where(['is_expire'=>1])->with('getUserInfo')->get()->pluck('getUserInfo.device_token')->toArray();
		$array = [];
		$array = array_values(array_filter($users, function($value) { return $value !== null & $value !== ''; }));
		if (!empty($array)) {

		   return @$this->notification($payload, $array);
	    }
	}

	public function sendNotificationOld($user = array(), $payload = [] ) {
		$token = trim(@$user->device_token);
		$device_type = trim(@$user->device_type);
		$users = Subscription::where(['is_expire'=>1])->with('getUserInfo')->get()->pluck('getUserInfo.device_token');

		if (in_array($device_type, self::DEVICES) && $token != "" && @$user->is_notification == 1) {
		  $this->deviceToken = $token;
		  if ($device_type === "android") {
		     $result = $this->notification($payload);
		     if ($result) {
		     	$insert = Notification::create(['sender_id'=>$sender_id, 'receiver_id'=>$user->id, 'title'=>$payload['title'], 'message'=>$payload['body'], 'status'=>1]);
		     	return true;
		     }
		  } elseif ($device_type === "ios") {
		     $result = $this->notification($payload);
		     if ($result) {
		     	$insert = Notification::create(['sender_id'=>$sender_id, 'receiver_id'=>$user->id, 'title'=>$payload['title'], 'message'=>$payload['body']]);
		     	return true;
		     }
		  }
		}
	}


	/**
    * Upload File on S3 bucket
    */
	public function uploadS3Data($data = '', $filePath = '') {
    	$file_name = time() . '.' . $data->getClientOriginalExtension();
    	$s3 = Storage::disk('s3');
		$filePath = $filePath . '/' . $file_name;
		$upload = $s3->put($filePath, file_get_contents($data), 'public');
		// $upload = Storage::disk('s3')->put($filePath, file_get_contents($data), 'public');
		// $upload = $s3->putObjectFile($data, "kizzcloud", $file_name, 'public');


		if ($upload) {
			return $file_name;
		}else{
			return false;
		}
    }


    /**
    * Get file from s3 bucket
    */
    public function getS3File($file_name = '15365677901.jpg', $file_path = 'users_data') {

    	$url = env('AWS_URL').$file_path.'/'.$file_name;

    	$ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_NOBODY, true);
	    curl_exec($ch);
	    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	    if($code == 200 && $file_name != ''){
	       return $url;
	    }else{
	      return '';
	    }
    }


    // this is all api
    public function getAwsFile($file_name = '', $file_path) {
    	$url = env('AWS_URL').$file_path.'/'.$file_name;
    	if (!empty($file_name)) {
    		return (string) $url;
    	} else{
    		return '';
    	}
    }

    public static function getFilePath($filename = '', $path = '')
    {
    	$url = "";
    	if(strstr($filename, 'https://')){

    		return @$filename;
    	}


    	$fileExist = Storage::disk('s3')->has($path.'/'.$filename);
    	if(!empty($filename) && !empty($path)) {

			$fileExist = Storage::disk('s3')->has($path.'/'.$filename);
	    	if($fileExist) {

		    	$url = Storage::disk('s3')->url($path.'/'.$filename);
		    	return $url;
	    	} else {

	    		return $url;
	    	}
    	} else	{

    		return $url;
    	}
    }

    //get minutes
    public static function getMinutes($value='') {
    	$result = 0;
    	if (!empty($value)) {
    		$value = $value/1000;
    		$result = floor(@$value / 60).' Min '.floor(@$value % 60).' Sec';
    	}

    	return $result;
    }

}
