<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\pageModel;
use Illuminate\Http\Request;
use App\countryModel;
use App\cityModel;
use App\AuthModel;
use DB;
use Auth;
use Mail;
use Hash;
use App\User; 
use App\categoryModel as Categroy;
use App\cityModel as City;
use App\Vendor;
use App\Tag;
use App\Serviceimage;
use App\Service;
use App\subCategoryModel as SubCategory;
use Illuminate\Support\Facades\Crypt;
use Session;



class pageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category=Categroy::where('categories_status',1)->get();
        $city=City::orderBy('city_name','asc')->get();

        return view('website.index',compact('category','city'));
    }

    public function about()
    {
        return view('website.about');
    }

    public function careers()
    {
        return view('website.careers');
    }

    public function contact()
    {
        return view('website.contact');
    }

     public function userLogin()
    {
        return view('website.ForUsers.index');
    }

     public function signup()
    {
         $countries=countryModel::get();
         $cities=cityModel::with('RelationCountry')->get();
        return view('website.ForUsers.signup',compact('countries','cities'));
    }
    public function forgot()
    {
        return view('website.ForUsers.forgot');
    }
     public function termCondition()
    {
        return view('website.termCondition');
    }


    public function searchEvents(Request $request){
        if(isset($request->city) && $request->city==''){
            $city='';
        }else{
            $city=$request->city;
        }
        if(isset($request->events) && $request->events==''){
            $event='';
        }else{
            $event=$request->events;
        }
         $vendors=Vendor::select('vendors.*','users.*','services.*','categories.*','vendors.id as vendorId')->join('users','users.id','vendors.user_id')->join('services','services.vendor_id','vendors.id')
         ->join('cities','cities.id','users.city_id')
         ->join('vendorcategorylists','vendorcategorylists.vendor_id','vendors.id')
         ->join('categories','categories.id','vendorcategorylists.category_id')
         ->where(function($query) use($city){
            if($city!=''){
                $query->where('cities.id',$city);
            }
         })
         ->where(function($query) use($event){
              if($event!=''){
            $query->where('categories.id',$event);
            }
         })
         ->groupBy('vendors.id')
         ->get();
         $tag=Tag::where('status',1)->get();
         $category= Categroy::where('categories_status',1)->get();
          $city=City::orderBy('city_name','asc')->get();
        return view('website.search',compact('vendors','tag','category','city'));
    }

    public function vendorDetails(Request $request){
        $id= $request->segment(2);
           if(isset($request->city) && $request->city==''){
            $city='';
        }else{
            $city=$request->city;
        }
        if(isset($request->events) && $request->events==''){
            $event='';
        }else{
            $event=$request->events;
        }
         $vendors=Vendor::select('vendors.*','users.*','services.*','categories.*','vendors.vendor_video as video','vendors.id as vid')->join('users','users.id','vendors.user_id')->join('services','services.vendor_id','vendors.id')
         ->join('cities','cities.id','users.city_id')
         ->join('vendorcategorylists','vendorcategorylists.vendor_id','vendors.id')
         ->join('categories','categories.id','vendorcategorylists.category_id')
         ->where('vendors.id',$id)
         ->where(function($query) use($city){
            if($city!=''){
                $query->where('cities.id',$city);
            }
         })
         ->where(function($query) use($event){
              if($event!=''){
            $query->where('categories.id',$event);
            }
         })
         ->first();
         $tag='';
         $gettag=DB::table('vendortaglists')->where('vendor_id',$id)->first();
         if(!empty($gettag)){
            $id=explode(',', $gettag->tags_id);
            $tag=Tag::whereIn('id',$id)->get();
        }
        // $tag=Tag::select('vendortaglists.*','tags.*')->join('vendortaglists','vendortaglists.tag_id','tags.id')->where('vendor_id',$id)->get();


         $category= Categroy::where('categories_status',1)->get();
          $city=City::orderBy('city_name','asc')->get();
          $Gallery=Serviceimage::where('vendor_id',$id)->get();
        return view('website.vendorDetails',compact('vendors','tag','category','city','Gallery'));
    }

    

    public function CreateQuote(Request $request){
         $uri=$request->segment(2); 
         $id=explode(',',$uri);
         //$services='';
         //$subCat[]='';
         $response=Vendor::with('userWiths')->whereIn('id',$id)->get();
         $services=Service::whereIn('vendor_id',$id)->get();
         foreach($services as $ft){
            $subCat[]=$ft->service_name;
         }
         $duplicates = array_unique(array_diff_assoc($subCat, array_unique($subCat)));
         $services=SubCategory::whereIn('id',$duplicates)->get();
        return view('website.quotes',compact('response','services'));
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\pageModel  $pageModel
     * @return \Illuminate\Http\Response
     */
    public function show(pageModel $pageModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\pageModel  $pageModel
     * @return \Illuminate\Http\Response
     */
    public function edit(pageModel $pageModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\pageModel  $pageModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pageModel $pageModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\pageModel  $pageModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(pageModel $pageModel)
    {
        //
    }

public function getCities(Request $request){
     
     return  $resonse=cityModel::where('country_id',$request->id)->get()->toJson(); 
}


 public static function getTimes(){
            $default = '19:00';
            $interval = '+30 minutes';
            $output = '';

            $current = strtotime( '00:00' );
            $end = strtotime( '23:59' );
            $array=array();
            while( $current <= $end ) {
                $time = date( 'H:i', $current );
                $time1 = date( 'H:i:s', $current );
                $sel = ( $time == $default ) ? ' selected' : '';
                array_push($array, $time1);
                //$output .= "<option value=\"{$time1}\">" . date( 'h:i A', $current ) .'</option>';
                $current = strtotime( $interval, $current );
            }
            // $time1='Closed';
            array_push($array, $time1);

            return $array;
    
}

public function forgotPassword(Request $request){
    if($records=User::where('email',$request->forgotEmail)->count()<1){
    Session::flash('error', 'User not Exists!');
    return redirect()->back();
  }
  $records=User::where('email',$request->forgotEmail)->first();
  if($records->facebook_id!=''){
    Session::flash('error', 'You used a Social Login (Google or Facebook), you must change your password there!');
    return redirect()->back();
  }elseif($records->google_id!=''){
    Session::flash('error', 'You used a Social Login (Google or Facebook), you must change your password there!');
    return redirect()->back();
  }else{
    $user_token=md5(rand());
    $token['remember_token']=$user_token;
    DB::table('users')->where('email',$request->forgotEmail)->update($token);
    $UserName=DB::table('users')->where('email',$request->forgotEmail)->first();
    $toemail = $request->forgotEmail;
    $appname=\Config::get('app.name');
    $secidtoview = array('id' => $user_token,'Email'=>Crypt::encryptString($toemail),'name'=>$UserName->first_name,'appname'=>$appname,'token'=>$user_token);
    Mail::send('Email.forgot',$secidtoview,function($message) use ($toemail,$appname) {
      $message->to($toemail)->subject('Forgot Password')->from('hello@zennflo.com',$appname);
    });
    Session::flash('message', 'Please Check your email id !');
    return redirect()->back();
  }
}


public function reset(Request $request){
     $email = $request->segment(2);
 $token = $request->segment(3);
    return view('website.forgot',compact('email','token'));
}

public function resetYourPassword(Request $request){
  if($request->password!=$request->cpassword){
    Session::flash('password', 'Password and Confirm Password does not match!');
    return redirect('/');
  }else{
   $email = Crypt::decryptString($request->email);
   $token=$request->token;
   if(User::where('email',$email)->where('remember_token',$token)->count()<1){
    Session::flash('password', 'Link Expired !');
    //  echo 1;
    return redirect('/');
  }else{
    $input['remember_token']=$request->_token;
    $input['password']=Hash::make($request->password);
    DB::table('users')->where('email',$email)->where('remember_token',$token)->update($input);
    Session::flash('successpassword', 'Password changed Successfully !');
    return redirect('/');
  }
}

}
















    /* End Controller*/
}
