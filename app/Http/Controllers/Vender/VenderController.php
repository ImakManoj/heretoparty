<?php

namespace App\Http\Controllers\Vender;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Vendor;
use App\User;
use App\categoryModel as Category;
use App\Tag;
use App\Service;
use App\Serviceimage as Simg;
use App\Vendorcategorylist as VenderCategory;
use App\ReuseModel;
use Auth;
use App\Vendortaglist;
use DB;
use App\Userinvoice as Invoice;
use App\Userquote;
use App\subCategoryModel as SubCategory;
use App\countryModel as Country;
use App\cityModel as City;
use App\Boucher;
use App\Message;
use Mail;
use Session;
use Hash;


class VenderController extends Controller
{
    public function dashboard(Request $request){
        $totalQuote=DB::table('userquotes')->select('userquotes.*','vendors.*')->join('vendors','vendors.id','userquotes.vendor_id')->where('vendors.user_id',Auth::User()->id)->count('userquotes.vendor_id');
         $response=DB::table('users')->select('users.*','countries.*','cities.*')->join('countries','countries.id','users.country_id')->join('cities','cities.id','users.city_id')->where('users.id',Auth::User()->id)->where('users.status',1)->first();
         $files=Boucher::where('user_id',Auth::User()->id)->count();

    	return view('VendorPanel.index',compact('totalQuote','response','files'));
    }

    public function business(Request $request){;

    	$Category=Category::get();
    	$tag=Tag::get();
        
        $vendor=DB::table('vendors')->select('vendors.*','vendorcategorylists.*','categories.*','vendors.id as vid')->join('vendorcategorylists','vendorcategorylists.vendor_id','vendors.id')->join('categories','categories.id','vendorcategorylists.category_id')->where('vendors.user_id',Auth::User()->id)->first();


        $id=$vendor->vid;
        $SubCategory=DB::table('vendorcategorylists')->select('vendorcategorylists.*','categories.*','subcategories.*','subcategories.id as subid')->join('categories','categories.id','vendorcategorylists.category_id')->join('subcategories','subcategories.category_id','categories.id')->where('vendorcategorylists.vendor_id',$id)->get();

       // $vendor=Vendor::with('getCategoryList','vendorCategory')->where('user_id',Auth::user()->id)->where('status',1)->first();
        //dd($vendor);

        $serviveNames=Service::where('user_id',Auth::User()->id)->get();
        $taglist=Vendortaglist::where('vendor_id',$id)->first();
      
    	return view('VendorPanel.business',compact('Category','tag','vendor','serviveNames','SubCategory','taglist'));
    }

    public function createBusinessProfile(Request $request){
    	// Vendor Createed  
         


    	$url = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=".urlencode($request->address)."/js&sensor=false&key=AIzaSyDvfEqpmOi0qt1j9Oq1LHIDNNkMRclKrWg");
		$response = json_decode($url);
		if ($response->status == 'OK') {
			$latitude = $response->results[0]->geometry->location->lat;
			$longitude = $response->results[0]->geometry->location->lng;
			$input['latitude']=$latitude;
			$input['longitude']= $longitude;
		}


      	$input['vendor_name']=$request->bussiness_name;
        if(!empty($request->logo)){
    	$input['vendor_logo']=ReuseModel::UploadImages('logo',$request->logo);
        }
        if(!empty($request->cover)){
    	$input['vendor_coverphoto']=ReuseModel::UploadImages('CoverImage',$request->cover);
        }
    	$input['vendor_address']=$request->address;
    	$input['vendor_contact']=$request->mobile;
    	$input['facebook_url']=$request->facebook;
    	$input['vendor_twitter']=$request->witter;
    	$input['vendor_instragram']=$request->instragram;
    	$input['vendor_website']=$request->websitelinks;
    	$input['vendor_video']=$request->videolink;
    	$input['user_id']=Auth::User()->id;

        if(Vendor::where('user_id',Auth::User()->id)->count('id')<1){
    	   $vendor=Vendor::create($input);
        }else{
          Vendor::where('user_id',Auth::User()->id)->update($input);  
          $vendor=Vendor::where('user_id',Auth::User()->id)->first();
        }

    	if(!empty($request->categories))
  			{
  				$categoryGenerate=array(
  						'vendor_id'=>$vendor->id,
  						'category_id'=>$request->categories
  				);
  					VenderCategory::create($categoryGenerate);
  			}

            if(!empty($request->taglist)){
    		  $taglist=array(
    				'vendor_id'=>$vendor->id,
    				'tags_id'=>implode(',', $request->taglist)
    			);
    		$tag=Vendortaglist::create($taglist);
        }   


        $count=0;
    	for($j=0;$j< (sizeof($request->serviceName));$j++){
            $count++;
    			$service=array(
    					'vendor_id'=>$vendor->id,
    					'category_id'=>1,
    					'service_name'=>$request->serviceName[$j],
    					'duration'=>$request->duration[$j],
    					'hours'=>$request->hours[$j],
    					'price'=>$request->price[$j],
    					'description'=>$request->discription[$j],
    					'user_id'=>Auth::User()->id
    			);

                if($request->serviceNamepdate[$j]==''){
                    $servicesGenerate=Service::create($service);
                    $serviceid=$servicesGenerate->id;
                }else{
                    Service::where('id',$request->serviceNamepdate[$j])->update($service);
                    $serviceid=$request->serviceNamepdate[$j];
                }

            if(!empty($request->file('proimage'.$count))){
    			for ($k=0; $k < (sizeof($request->file('proimage'.$count))); $k++) { 
    					$images=array(
    						'vendor_id'=>$vendor->id, 
    						'srvice_id'=>$serviceid,
    						'images'=>ReuseModel::UploadImages1('Upload',$request->file('proimage'.$count)[$k],$k)
    					);
    					Simg::create($images);
    			}
            }
    	}
         return redirect()->back();
    }


    public function query(Request $request){

            Auth::User()->id;

        $response=DB::table('userquotes')->select('userquotes.*','userinvoices.*','vendors.*','users.*','vendors.id as vid','users.id as uid')->join('userinvoices','userinvoices.id','userquotes.userinvoice_id')->join('vendors','vendors.id','userquotes.vendor_id')->join('users','users.id','userquotes.user_id')->where('vendors.user_id',Auth::user()->id)->get();
       
       // $response=Userquote::with('getInvoice','GetUsers','getvendors')->where('vendor_id',Auth::user()->id)->get();
        return view('VendorPanel.query',compact('response'));
    }

    
    public function file(Request $request){
        $service=DB::table('services')->select('services.*','subcategories.*','services.id as serviceId')->join('subcategories','subcategories.id','services.service_name')->where('services.user_id',Auth::User()->id)->get();
        $boucher=DB::table('bouchers')->select('bouchers.*','services.*','subcategories.*','bouchers.name as bname','bouchers.id as bid')->join('services','services.id','bouchers.service_id')->join('subcategories','subcategories.id','services.service_name')->where('bouchers.user_id',Auth::User()->id)->get();
        return view('VendorPanel.files',compact('service','boucher'));
    }

    public function getbouchers(Request $request){

         $boucher=DB::table('bouchers')->select('bouchers.*','services.*','subcategories.*','bouchers.name as bname','bouchers.id as bid')->join('services','services.id','bouchers.service_id')->join('subcategories','subcategories.id','services.service_name')->where('bouchers.id',$request->id)->first();
         return json_encode($boucher);

    }

    public static function getServices($id,$venderId){
         $id=explode(',',$id);
            return DB::table('services')->select('subcategories.*','services.*')->join('subcategories','subcategories.id','services.service_name')->whereIn('service_name',$id)->where('vendor_id',$venderId)->get();

    }

    public function getSubCategory(Request $request){
        $Services= SubCategory::where('category_id',$request->id)->get();

        ?>
        <select  class="form-control" id="serviceName" name="serviceName[]">
        <option value="">Select Service</option>
        <?php foreach($Services as $ft){ ?>
            <option value="<?php echo $ft->id; ?>"><?php echo $ft->name; ?></option>
        <?php } ?>
        </select>

        <?php
    }

    public function pages(Request $request){
        $id=$request->cat;
         $Services= SubCategory::where('category_id',$id)->get();
    return view('VendorPanel.appendpage',compact('Services'));
    }


public function getImagesServices(Request $request){
     $id=$request->id;
     $records=Simg::where('srvice_id',$id)->get();
     foreach($records as $row){
        ?>

        <img src="<?php echo $row->images;?>">

        <?php
     }
}



public function vendorProfile(Request $request){
    $response=User::where('id',Auth::User()->id)->where('status',1)->first();
    $Country=Country::get();
    $city=City::get();
    return view('VendorPanel.vendorProfile',compact('response','Country','city'));   
}



public function getCity(Request $request){
    $City=City::where('country_id',$request->id)->get();
    ?>
<select class="form-control"  name="city_name" placeholder="City" >
    <option value="">Select City</option>
    <?php foreach($City as $ft){ ?>
    <option value="<?php echo $ft->id; ?>"><?php echo $ft->city_name; ?></option>
   <?php } ?>
   </select>
<?php
}


public function updateProfile(Request $request){

    $array=array(
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'mobile'=>$request->mobile,
            'country_id'=>$request->country_name,
            'city_id'=>$request->city_name,
            'images'=>ReuseModel::UploadImages('profiles',$request->imageUpload)
        );
   
    User::where('id',Auth::User()->id)->update($array);

    return redirect()->back();

}


public static function UserProfile(){
     return User::where('id',Auth::User()->id)->first();
}

    public static function ServiceImages($id){
       return Simg::where('srvice_id',$id)->get();
    }



public function saveBrochure(Request $request){
    $venderId=Vendor::where('user_id',Auth::User()->id)->first();
    $array=array(
                    'name'=>$request->name,
                    'service_id'=>$request->services,
                    'images'=>ReuseModel::UploadImages('Upload',$request->file('files')),
                    'user_id'=>Auth::User()->id,
                    'vendor_id'=>$venderId->id
                );
    if($request->boucherIds==''){
        Boucher::create($array);
    }else{
        Boucher::where('id',$request->boucherIds)->update($array);
    }

    
    return redirect()->back();
}



public function notification(Request $request){
    return view('VendorPanel.notification');
}



public function messages(Request $request){
    $fistid=Vendor::where('user_id',Auth::User()->id)->first();
    $response=DB::table('users')->select('users.*','userquotes.*','users.id as uid','users.images as img')->join('userquotes','userquotes.user_id','users.id')->where('userquotes.vendor_id',$fistid->id)->groupBy('userquotes.user_id')->get();
   // dd($response);
    return view('VendorPanel.messages',compact('response'));
}

public function SendMessagetoUser(Request $request){
     $fistid=Vendor::where('user_id',Auth::User()->id)->first();
        $array = array(
                    'message' =>$request->Message, 
                    'user_id' =>$request->id, 
                    'type' =>1, 
                    'vendor_id' =>$fistid->id, 
                    'date' =>date('Y-m-d'), 
                );
    Message::create($array);
}


public function getallMessages(Request $request){
    $fistid=Vendor::where('user_id',Auth::User()->id)->first();
    $id=$fistid->id;
    $vendorUserid=$fistid->user_id;
    $condition='';
    if($request->Greater!=''){
        $condition=$request->Greater;
    }
    $response=Message::where('vendor_id',$id)->where('user_id',$request->id)
        ->where(function($query) use($condition){
        if($condition!=''){
            $query->where('id','>',$condition);
        }
    })
    ->get();
            foreach($response as $ft){
                if($ft->type==1){
                    $Users=User::where('id',$vendorUserid)->first();
                    $ft->img=$Users->images;
                }else{
                    $Users=User::where('id',$ft->user_id)->first();
                    $ft->img=$Users->images;
                }
                $message_Id=Message::where('user_id',$request->id)->where('vendor_id',$id)->max('id');
                $ft->Maxid=$message_Id;
                $timeago=$this->get_timeago(strtotime($ft->created_at));
                $ft->times=$timeago;
            }
        return json_encode($response);
}


public static function get_timeago( $ptime )
{
    $estimate_time = time() - $ptime;

    if( $estimate_time < 1 )
    {
        return 'less than 1 second ago';
    }

    $condition = array(
        12 * 30 * 24 * 60 * 60  =>  'year',
        30 * 24 * 60 * 60       =>  'month',
        24 * 60 * 60            =>  'day',
        60 * 60                 =>  'hour',
        60                      =>  'minute',
        1                       =>  'second'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $estimate_time / $secs;

        if( $d >= 1 )
        {
            $r = round( $d );
            return 'about ' . $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' ago';
        }
    }
}



public function submitMyQutotes(Request $request){
    $Users=User::where('id',$request->id)->first();
    $user_token=md5(rand());

    // $toemail =$Users->email;
    $toemail ='mobirex836@jupiterm.com';
    $appname=\Config::get('app.name');
    $secidtoview = array('id' => $user_token,'name'=>$Users->first_name.' '.$Users->last_name ,'appname'=>$appname,'token'=>$user_token);
    Mail::send('Email.submitQuotes',$secidtoview,function($message) use ($toemail,$appname) {
      $message->to($toemail)->subject('Submit My Quotes')->from('manojk.sharma@imarkinfotech.com',$appname);
    });
    Session::flash('message', 'Sumbit My Quotes !');
    //return redirect()->back();
}

public function resubmitMyQutotes(Request $request){
    $Users=User::where('id',$request->id)->first();
    $user_token=md5(rand());

    // $toemail =$Users->email;
    $toemail ='mobirex836@jupiterm.com';
    $appname=\Config::get('app.name');
    $secidtoview = array('id' => $user_token,'name'=>$Users->first_name.' '.$Users->last_name ,'appname'=>$appname,'token'=>$user_token);
    Mail::send('Email.submitQuotes',$secidtoview,function($message) use ($toemail,$appname) {
      $message->to($toemail)->subject('Submit My Quotes')->from('manojk.sharma@imarkinfotech.com',$appname);
    });
    Session::flash('message', 'Resumbit My Quotes !');
}


public function withdrawMyQutotes(Request $request){
    $Users=User::where('id',$request->id)->first();
    $user_token=md5(rand());

    // $toemail =$Users->email;
    $toemail ='mobirex836@jupiterm.com';
    $appname=\Config::get('app.name');
    $secidtoview = array('id' => $user_token,'name'=>$Users->first_name.' '.$Users->last_name ,'appname'=>$appname,'token'=>$user_token);
    Mail::send('Email.submitQuotes',$secidtoview,function($message) use ($toemail,$appname) {
      $message->to($toemail)->subject('Submit My Quotes')->from('manojk.sharma@imarkinfotech.com',$appname);
    });
    Session::flash('message', 'Widthdrow My Quotes !');
}

public function changePassword(Request $request){
    return view('VendorPanel.changePassword');
}



public function VendorChangePassword(Request $request){
    $data = $request->all();
    $user = User::find(auth()->user()->id);
    if($user->facebook_id!=''){
     Session::flash('error', 'You used a Social Login (Google or Facebook), you must change your password there!');
     return redirect()->back();
 }elseif($user->google_id!=''){
     Session::flash('error', 'You used a Social Login (Google or Facebook), you must change your password there!');
     return redirect()->back();
 }else{
    if(!Hash::check($data['old_password'], $user->password)){
        return back()
        ->with('error','The specified password does not match the database password');
    }elseif($request->new_password!=$request->confirm_password){
        return back()
        ->with('error','Your Password and confram password not match');
    }else{
       User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
       Session::flash('message', 'Successfully updated your password!');
       return redirect()->back();
   }
}
}


/* End Controller*/
}
