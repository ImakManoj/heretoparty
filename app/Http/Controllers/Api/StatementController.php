<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\StringcompareController;
use Illuminate\Support\Facades\Validator;
use PHPMailer\PHPMailer;
use App\User;
use App\keyword;
use App\ContactUs;
use App\Verbs;
use App\VerbMatchs;
use App\Statements;
use App\VirtualMatches;
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

class StatementController extends Controller
{
 
	/**
     * Get verbs list
     *
     * @return response
     */
	public function getVerbs(Request $request) {
		$data = [];
	    $data = Verbs::select('id', 'name')->get();
	    $response = [];
	    foreach ($data as $key => $value) {
	    	$response[$key]['id'] = $value['id'];
	    	$response[$key]['name'] = $value['name'];
	    	$response[$key]['keywords'] = $this->getKeywords($value['id']);
	    }
	    if ($response) {
	    	$this->success('record found.', $response);
	    }else{
	    	$this->error('record not found.', '');
	    }

	}


	//Get keywords
	public function getKeywords($id = '') {
		$data = [
			[
			'id' => '1',
			'name' => 'where'
			],
			[
			'id' => '2',
			'name' => 'when'
			],
			[
			'id' => '3',
			'name' => 'price'
			],
			[
			'id' => '4',
			'name' => 'details'
			]
		];
		return $data;
	}

	/**
     * Get statement
     *
     * @return response
     */
	public function getStatements(Request $request) {

		//perameter->sort_by recent=1, relevant=2

		$this->validation($request->all(), [
	        "user_id" => "required",
	    ]);

	    $take = 20;
	    $startRow = 0;
	    $distance = 100;

		$data = [];
	    $response = [];
	    $result = [];
	    $stm_ids_data = [];
	    $data = Statements::where('user_id', $request->input('user_id'))->orderBy('created_at', 'DESC')->get();
	    if ($data) {
	    	// $get_verb_ids = VerbMatchs::whereIn('verb_id', $data)->groupBy('match_id')->pluck('match_id')->toArray();
	    	
	    	

	    	// $get_verbs_data = Statements::where('user_id', '<>', $request->input('user_id'))->whereIn('verb_id', $get_verb_ids)->orderBy('created_at', 'DESC')->pluck('where_data')->toArray();
	    	$statIdList = array();

	    	foreach ($data as $key => $value) {
	    		$match_verb_id 	= VerbMatchs::where('verb_id', $value['verb_id'])->first();

	    		$match_verb_id 	= $match_verb_id->match_id;
	    		$where_data 	= $value['where_data'];
	    		$when_data		= $value['when_data'];
	    		$lat 			= $value['lat'];
	    		$lng 			= $value['lng'];

	    		// $desc_data[] = [
	    		// 	'user_stm_id' => $value['id'],
	    		// 	'match_stm_id' => $value['id'],
	    		// ]; 

	    		$query = Statements::where('user_id', '<>', $request->input('user_id'))->where('verb_id', $match_verb_id);


	    		if ($where_data == "2") {
	    			$query->whereRow("(1.609344 * 3956 * acos( cos( radians('".$lat."') ) * cos( radians(lat) ) * cos( radians(lng) - radians('".$lng."') ) + sin( radians('".$lat."') ) * sin( radians(lat) ) ) ) <= $distance");
	    		}else{
	    			//1
	    		}

	    		if ($when_data == "1") {
		    		$query->where('when_data', '1'); 

		    	}else{
		    		$start_date = date("Y-m-d H:00:00", strtotime($when_data));
		    		
		    		$end_date = date("Y-m-d H:00:00", strtotime($when_data));
		    		
		    		$end_date = date("Y-m-d H:00:00", strtotime('+1 hours', strtotime($end_date) ));

		    		$query->whereBetween('when_data', [$start_date, $end_date])->orderBy('when_data', 'DESC'); 
		    	}

		    	$stm_ids_data = $query->orderBy('created_at', 'DESC')->pluck('_id')->toArray();

		    	if($stm_ids_data){

		    		$matchTempArr[$value['id']] =  $stm_ids_data; 
		    	}

				$statIdList = array_unique(array_merge($statIdList, $stm_ids_data));
				
	    	}
	    	$result = Statements::whereIn('_id', $statIdList)->orderBy('created_at', 'DESC')->with('getUserName', 'getVerb')->get();

	    	
	    	foreach ($result as $key => $value) {
	    		// dd($result);
	    		// $count = 0;

	    		// if (count($matchTempArr)) {
	    		// 	if (count($matchTempArr[$count]) <= $result) {
	    		// 		# code...
	    		// 	}
	    		// }
	    		// if (count($matchTempArr) > $count && count(array_keys($matchTempArr)) > 0 ) {
	    		// 	$myId = array_keys($matchTempArr)[$count];
	    		// 	dd($myId);
	    		// 	$key_id = array_search($value['id'], $matchTempArr[$myId] );
	    		// }

	    		// if (!empty($matchTempArr[$key]['matchId'])) {
			    // 	$res = array_search($value['id'], $matchTempArr[$key]['matchId']); 
			    // 	echo "<pre>";
		    	//  	print_r($res);
		    	//  	echo "<pre>";
		    	//  	print_r($matchTempArr[$res]['myId']);
		    	//  	echo "<pre>";
	    		// }
	    		
	    		//get similar percent
	    		// $string_compare_ini = new StringcompareController($statement_data->description, $value['description']);
				// $similar_percent1 = $string_compare_ini->getSimilarityPercentage();

		    	$response[$key]['id'] = $value['id'];
		    	$response[$key]['user_id'] = $value['user_id'];
		    	$response[$key]['verb_id'] = $value['verb_id'];
		    	$response[$key]['verb_name'] = (string) $value['getVerb']['name'];
		    	$response[$key]['user_name'] = (string) $value['getUserName']['name'];
		    	$response[$key]['username'] = (string) $value['getUserName']['username'];
		    	$response[$key]['qb_id'] = (string) $value['getUserName']['qb_id'];
		    	$response[$key]['user_profile'] = (string) $this->getUserProfile($value['user_id']);
		    	$response[$key]['description'] = (string) $value['description'];
		    	$response[$key]['where'] = (string) $value['where_data'];
		    	$response[$key]['when'] = (string) $value['when_data'];
		    	$response[$key]['price'] = (string) $value['price'];
		    	$response[$key]['details'] = (string) $value['details'];
		    	$response[$key]['lat'] = (string) $value['lat'];
		    	$response[$key]['lng'] = (string) $value['lng'];
		    	$response[$key]['created_at'] = date('Y-m-d H:i:s', strtotime($value['created_at']));
		    	$response[$key]['public_keyword'] = $this->getUserKeywords($value['user_id'], 'public');

		    }
		    if ($response) {
		    	$this->success('record found.', $response);
		    }else{
		    	$this->error('record not found.', []);
		    }
	    }else{
	    	$this->error('record not found.', []);
	    }
	        

	}

	

	public function getUserKeywords($user_id='', $keyword_type = '') {
		$data = [];
	    $data = Keyword::select('id', 'key_type', 'value')->where(['user_id'=>$user_id,  'key_type'=> $keyword_type])->get();
	    $response = [];
	    foreach ($data as $key => $value) {
	    	$response[$key]['id'] = $value['id'];
	    	$response[$key]['key_type'] = $value['key_type'];
	    	$response[$key]['value'] = $value['value'];
	    }
	    
	    return $response;
	}

	/**
     * view matchs statement
     *
     * @return response
     */
	public function ViewStatementsMatch(Request $request) {

		$this->validation($request->all(), [
	        "user_id" => "required",
	        "statement_id" => "required",
	    ]);

	    $take = 20;
	    $startRow = 0;
	    $distance = 10;

		$data = [];
	    $response = [];
	    $result = [];
	    $final_response = [];

	    $statement_data = Statements::where(['_id'=>$request->input('statement_id'), 'user_id'=> $request->input('user_id')])->with('getUserName')->first();
	    if ($statement_data) {
	    	$virtual_data = VirtualMatches::where(['statement_id'=>$request->input('statement_id')])->orderBy('total_avg', 'DESC')->with('getStatementInfo')->get();
		    if (count($virtual_data) >= 20) {
		    	foreach ($virtual_data as $key => $value) {
			    	$response[$key]['id'] = $value['id'];
			    	$response[$key]['user_id'] = $value['getStatementInfo']['user_id'];
			    	$response[$key]['verb_id'] = $value['getStatementInfo']['verb_id'];
			    	$response[$key]['verb_name'] = (string) $this->getVerbInfo($value['getStatementInfo']['verb_id'])->name;
			    	$response[$key]['user_name'] = (string) $this->getUserInfo($value['getStatementInfo']['user_id'])->name;
			    	$response[$key]['username'] = (string) $this->getUserInfo($value['getStatementInfo']['user_id'])->username;
			    	$response[$key]['qb_id'] = (string) $this->getUserInfo($value['getStatementInfo']['user_id'])->qb_id;
			    	$response[$key]['user_profile'] = $this->getUserProfile($value['getStatementInfo']['user_id']);
			    	$response[$key]['description'] = (string) $value['getStatementInfo']['description'];
			    	$response[$key]['where'] = (string) $value['getStatementInfo']['where_data'];
			    	$response[$key]['when'] = (string) $value['getStatementInfo']['when_data'];
			    	$response[$key]['price'] = (string) $value['getStatementInfo']['price'];
			    	$response[$key]['details'] = (string) $value['getStatementInfo']['details'];
			    	$response[$key]['lat'] = (string) $value['getStatementInfo']['lat'];
			    	$response[$key]['lng'] = (string) $value['getStatementInfo']['lng'];
			    	$response[$key]['similar_percent'] = $value['total_avg'];
			    	$response[$key]['created_at'] = date('Y-m-d H:i:s', strtotime($value['getStatementInfo']['created_at']));
			    	$response[$key]['public_keyword'] = $this->getUserKeywords($value['getStatementInfo']['user_id'], 'public');
		    	}

		    }else{
		    	$match_data = VerbMatchs::where('verb_id', $statement_data->verb_id)->first();
		    	$query = Statements::where('user_id', '<>', $request->input('user_id'));

		    	if($match_data){

		    		$query->where('verb_id', $match_data->match_id);
		    	}

		    	if (@$statement_data->where_data == '2') {
		    		// $query->where('where', 2); 
		    		$query->where("(1.609344 * 3956 * acos( cos( radians('$statement_data->lat') ) * cos( radians(lat) ) * cos( radians(lng) - radians('$statement_data->lng') ) + sin( radians('$statement_data->lat') ) * sin( radians(lat) ) ) ) <= $distance"); 
		    	}elseif (@$statement_data->where_data == '1') {
		    		$query->where('where_data', "1"); 
		    	}

		    	if (@$statement_data->when_data == '1') {
		    		$query->where('when_data', '1'); 

		    	}else{
		    		$start_date = date("Y-m-d H:00:00", strtotime($statement_data->when_data));
		    		
		    		$end_date = date("Y-m-d H:00:00", strtotime($statement_data->when_data));
		    		
		    		$end_date = date("Y-m-d H:00:00", strtotime('+1 hours', strtotime($end_date) ));

		    		$query->whereBetween('when_data', [$start_date, $end_date])->orderBy('when_data', 'DESC'); 
		    	} 

		    	$result = $query->orderBy('created_at', 'DESC')->with('getUserName', 'getVerb')->get();

		    }
	    	

	    	foreach ($result as $key => $value) {
	    		$string_compare_ini = new StringcompareController($statement_data->description, $value['description']);
				$similar_percent1 = $string_compare_ini->getSimilarityPercentage();

				// $string_compare_ini2 = new StringcompareController($statement_data->details, $value['details']);
				// $similar_percent2 = $string_compare_ini2->getSimilarityPercentage();
	    		
		    	$response[$key]['id'] = $value['id'];
		    	$response[$key]['user_id'] = $value['user_id'];
		    	$response[$key]['verb_id'] = $value['verb_id'];
		    	$response[$key]['verb_name'] = (string) $value['getVerb']['name'];
		    	$response[$key]['user_name'] = (string) $value['getUserName']['name'];
		    	$response[$key]['username'] = (string) $value['getUserName']['username'];
		    	$response[$key]['qb_id'] = (string) $value['getUserName']['qb_id'];
		    	$response[$key]['user_profile'] = (string) $this->getUserProfile($value['user_id']);
		    	$response[$key]['description'] = (string) $value['description'];
		    	$response[$key]['where'] = (string) $value['where_data'];
		    	$response[$key]['when'] = (string) $value['when_data'];
		    	$response[$key]['price'] = (string) $value['price'];
		    	$response[$key]['details'] = (string) $value['details'];
		    	$response[$key]['lat'] = (string) $value['lat'];
		    	$response[$key]['lng'] = (string) $value['lng'];
		    	$response[$key]['similar_percent'] = $similar_percent1;
		    	$response[$key]['created_at'] = date('Y-m-d H:i:s', strtotime($value['created_at']));
		    	$response[$key]['public_keyword'] = $this->getUserKeywords($value['user_id'], 'public');

		    }


    		array_multisort(array_column($response, 'similar_percent'), SORT_DESC, $response);

		    if ($statement_data) {
		    	$final_response['id'] = $statement_data->id;
		    	$final_response['verb_id'] = $statement_data->verb_id;
		    	$final_response['user_id'] = $statement_data->user_id;
		    	$final_response['user_name'] = (string) $statement_data['getUserName']->name;
		    	$final_response['username'] = (string) $statement_data['getUserName']->username;
		    	$final_response['profile'] = (string) $this->getUserProfile($statement_data->user_id);
		    	$final_response['description'] = (string) $statement_data->description;
		    	$final_response['created_at'] = date('Y-m-d H:i:s', strtotime($statement_data->created_at));
		    	$final_response['matchs'] = $response;

		    	$this->success('record found.', $final_response);
		    }else{
		    	$this->error('record not found.', '');
		    }
	    }else{
	    	$this->error('record not found.', '');
	    }
	        

	}


	public function getUserInfo($id='') {
		$result = User::where(['_id'=> $id])->first();
		return @$result;
	}

	public function getVerbInfo($id='') {
		$result = Verbs::where(['_id'=> $id])->first();
		return @$result;
	}


	/**
     * Create Virtual Matches
     *
     * @return response
     */
	public function createVirtualMatches(Request $request) {

		$this->validation($request->all(), [
	        "user_id" => "required",
	        "statement_id" => "required",
	    ]);

	    $take = 20;
	    $startRow = 0;
	    $distance = 10;

		$data = [];
	    $response = [];
	    $result = [];
	    $final_response = [];
	    $statement_data = Statements::where(['_id'=>$request->input('statement_id'), 'user_id'=> $request->input('user_id')])->first();
	    if ($statement_data) {
	    	$match_data = VerbMatchs::where('verb_id', $statement_data->verb_id)->first();
	    	$query = Statements::where('user_id', '<>', $request->input('user_id'));
	    	
	    	if($match_data){

	    		$query->where('verb_id', $match_data->match_id);
	    	}

	    	if (@$statement_data->where_data == 2) {
	    		// $query->where('where', 2); 
	    		$query->whereRow("(1.609344 * 3956 * acos( cos( radians('$statement_data->lat') ) * cos( radians(lat) ) * cos( radians(lng) - radians('$statement_data->lng') ) + sin( radians('$statement_data->lat') ) * sin( radians(lat) ) ) ) <= $distance"); 
	    	}else{
	    		// $query->whereRow('where', 1); 
	    	}

	    	if (@$statement_data->when_data == 1) {
	    		$query->where('when_data', '1'); 

	    	}else{
	    		$start_date = date("Y-m-d H:00:00", strtotime($statement_data->when_data));
	    		
	    		$end_date = date("Y-m-d H:00:00", strtotime($statement_data->when_data));
	    		
	    		$end_date = date("Y-m-d H:00:00", strtotime('+1 hours', strtotime($end_date) ));

	    		$query->whereBetween('when_data', [$start_date, $end_date])->orderBy('when_data', 'DESC'); 
	    	} 

	    	$result = $query->orderBy('created_at', 'DESC')->get();

	    	foreach ($result as $key => $value) {

	    		$main_stm = $statement_data->description;
	    		$match_stm = $value['description'];

				$string_compare_ini = new StringcompareController($statement_data->description, $value['description']);
				$similar_percent1 = $string_compare_ini->getSimilarityPercentage();
				// $defferent_percent1 = $string_compare_ini->getDifferencePercentage();

				$string_compare_ini2 = new StringcompareController($statement_data->details, $value['details']);
				$similar_percent2 = $string_compare_ini2->getSimilarityPercentage();
				// $defferent_percent2 = $string_compare_ini2->getDifferencePercentage();

				$total_avg = ($similar_percent1 + $similar_percent2)/2;
				
	    		
		    	$data['match_id'] = $value['id'];
		    	$data['statement_id'] = $request->input('statement_id');
		    	$data['description_avg'] = $similar_percent1;
		    	$data['details_avg'] = $similar_percent2;
		    	$data['total_avg'] = (string) $total_avg;

		    	$save = VirtualMatches::create($data);

		    }

		    if ($result) {

		    	$this->success('successfully', null);
		    }else{

		    	$this->error('insert error.', null);
		    }
	    }else{
	    	$this->error('something went wrong.', null);
	    }
	        

	}

	/**
     * Get statement
     *
     * @return response
     */
	public function myStatements(Request $request) {

		$this->validation($request->all(), [
	        "user_id" => "required",
	    ]);

		$data = [];
	    $response = [];
	    $data = Statements::where(['user_id'=>$request->input('user_id')])->orderBy('created_at', 'DESC')->with('getUserName', 'getVerb')->get();
	  
	    foreach ($data as $key => $value) {
	    	$response[$key]['id'] = $value['id'];
	    	$response[$key]['user_id'] = $value['user_id'];
	    	$response[$key]['verb_id'] = $value['verb_id'];
	    	$response[$key]['verb_name'] = (string) $value['getVerb']['name'];
	    	$response[$key]['user_name'] = (string) $value['getUserName']['name'];
	    	$response[$key]['username'] = (string) $value['getUserName']['username'];
	    	$response[$key]['user_profile'] = (string) $this->getUserProfile($request->input('user_id'));
	    	$response[$key]['description'] = (string) $value['description'];
	    	$response[$key]['where'] = (string) $value['where_data'];
	    	$response[$key]['when'] = (string) $value['when_data'];
	    	$response[$key]['price'] = (string) $value['price'];
	    	$response[$key]['details'] = (string) $value['details'];
	    	$response[$key]['lat'] = (string) $value['lat'];
	    	$response[$key]['lng'] = (string) $value['lng'];
	    	$response[$key]['created_at'] = date('Y-m-d H:i:s', strtotime($value['created_at']));

	    }
	    if ($response) {
	    	$this->success('record found.', $response);
	    }else{
	    	$this->error('record not found.', []);
	    }

	}

	//get User profile
	public function getUserProfile($user_id='') {
		$data = User::where(['_id'=>$user_id])->first();
		if (!empty($data->profile)) {
			if(strstr($data->profile, 'https://')){
			$picture = $data->profile;
			}elseif(!empty($data->profile)){
				$picture = URL::to('/uploads/users/').'/'.$data->profile;
			}else{
				$picture = "";
			}
		}else{
			$picture = "";
		}
		
		return $picture;
	}

	/**
     * Add Statement
     *
     * @return Response
     */
    public function submitStatement(Request $request) {

		$this->validation($request->all(), [
	        "user_id" => "required",
	        "verb_id" => "required",
	        "description" => "required",
	        // "where" => "required",
	        // "when" => "required",
	        // "price" => "required",
	        // "details" => "required",
	        // "lat" => "required",
	        // "lng" => "required", 
	    ]);

		$checkUser =  User::where('_id',$request->input('user_id'))->first(); 
		if (empty($checkUser)) {
			$this->error('User does not exist.');
		}

		$checkVerbsId =  Verbs::where('_id',$request->input('verb_id'))->first(); 
		if (empty($checkVerbsId)) {
			$this->error('Verbs id does not exist.');
		}

		$data = [
			'user_id'=> $request->input('user_id'),
			'verb_id'=> $request->input('verb_id'),
			'description'=> $request->input('description'),
			'where_data'=> $request->input('where'),
			'when_data'=> $request->input('when'),
			'price'=> $request->input('price'),
			'details'=> $request->input('details'),
			'lat'=> $request->input('lat'),
			'lng'=> $request->input('lng'),
			'created_at'=> date("Y-m-d H:i:s"),
		];

		if ($save = Statements::create($data)) {
			
			$get_data = [];
			$response = [];
			$get_data =  Statements::where('_id',$save->id)->first();
			$response['id'] = $get_data->id;
			$response['user_id'] = $get_data->user_id;
			$response['verb_id'] = $get_data->verb_id;
			$response['description'] = $get_data->description;
			$response['where'] = $get_data->where_data;
			$response['when'] = $get_data->when_data;
			$response['price'] = $get_data->price;
			$response['details'] = $get_data->details;
			$response['lat'] = $get_data->lat;
			$response['lng'] = $get_data->lng;
			$response['created_at'] = date('Y-m-d H:i:s', strtotime($get_data->created_at));	
			$this->success('insert success.', $response);
		}else{
			$this->error('something went wrong.');
		}

    }

    /**
     * Method for edit statement
     *
     * @return response
     */
    public function editStatement(Request $request) {
    	$this->validation($request->all(), [
	        "user_id" => "required",
	        "statement_id" => "required",
	        "verb_id" => "required",
	        "description" => "required",
	        // "where" => "required",
	        // "when" => "required",
	        // "price" => "required",
	        // "details" => "required",
	        // "lat" => "required",
	        // "lng" => "required",
	    ]);

    	$checkData = Statements::where(['user_id'=>$request->input('user_id'), '_id'=>$request->input('statement_id')])->first();
    	if (empty($checkData)) {
    		$this->error('Statement does not exists.', '');
    	}

    	$data =  Statements::where(['user_id'=>$request->input('user_id'), '_id'=>$request->input('statement_id')])->first(); 
		
		$data->verb_id 	= !empty($request->input('verb_id'))? $request->input('verb_id'): $data['verb_id'];
		$data->description  	= !empty($request->input('description'))? $request->input('description'): $data['description'];
		$data->where_data  	= !empty($request->input('where'))? $request->input('where'): $data['where_data'];
		$data->when_data  	= !empty($request->input('when'))? $request->input('when'): $data['when_data'];
		$data->price  	= !empty($request->input('price'))? $request->input('price'): $data['price'];
		$data->details  = !empty($request->input('details'))? $request->input('details'): $data['details'];
		$data->lat  	= !empty($request->input('lat'))? $request->input('lat'): $data['lat'];
		$data->lng  	= !empty($request->input('lng'))? $request->input('lng'): $data['lng'];
			
		if($data->save()){
			$getData =  Statements::where(['user_id'=>$request->input('user_id'), '_id'=>$request->input('statement_id')])->first();
			
			$udata = array(
				"id"		=> $getData->id,
				"user_id"		=> $getData->user_id,
				"verb_id"		=> $getData->verb_id,
				"description"	=> $getData->description,
				"where"			=> $getData->where_data,
				"when"			=> $getData->when_data,
				"price"			=> $getData->price,
				"details"		=> $getData->details,
				"lat"			=> $getData->lat,
				"lng"			=> $getData->lng,
			);

			$this->success('Update successfully.', $udata);
		}else{
			$this->error('Enable to update! Please try again.');
		}
    }

    /**
     * Method for delete statement
     *
     * @return response
     */
    public function deleteStatement(Request $request) {
    	$this->validation($request->all(), [
	        "user_id" => "required",
	        "statement_id" => "required",
	    ]);

    	$checkData = Statements::where(['user_id'=>$request->input('user_id'), '_id'=>$request->input('statement_id')])->first();
    	if (empty($checkData)) {
    		$this->error('Statement does not exists.', '');
    	}

    	$delete = Statements::where(['_id'=>$request->input('statement_id'), 'user_id'=>$request->input('user_id')])->delete();
    	if ($delete) {

    		$this->success('delete success.');
    	}else{

    		$this->error('something went wrong.', '');
    	}
    }


	
}
