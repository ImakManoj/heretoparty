<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\profileModel;
use Illuminate\Http\Request;
use App\User;
use App\Vendor;
use App\Userinvoice as Invoice;
use App\Userquote;
use App\ReuseModel;
use App\cityModel as City;
use App\countryModel as Country;
use Auth;
use DB;
use App\Serviceimage as Simg;
use App\Budgeter;
use App\Event;
use App\Guestlist;
use App\Message;
use Hash;
use Session;
use Mail;

 
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request)
    {
         $totalQuote=DB::table('userquotes')->select('userquotes.*','users.*')->join('users','users.id','userquotes.user_id')->where('users.id',Auth::User()->id)->count('userquotes.user_id');
         $response=DB::table('users')->select('users.*','countries.*','cities.*')->join('countries','countries.id','users.country_id')->join('cities','cities.id','users.city_id')->where('users.id',Auth::User()->id)->where('users.status',1)->first();

        return view('UserDashboard.index',compact('totalQuote','response'));
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
     * @param  \App\profileModel  $profileModel
     * @return \Illuminate\Http\Response
     */
    public function show(profileModel $profileModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\profileModel  $profileModel
     * @return \Illuminate\Http\Response
     */
    public function edit(profileModel $profileModel)
    {
        //
    } 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\profileModel  $profileModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, profileModel $profileModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\profileModel  $profileModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(profileModel $profileModel)
    {
        //
    }



      public function query(Request $request){
        $response=DB::table('userquotes')->select('userquotes.*','userinvoices.*','vendors.*','users.*','vendors.id as vid')->join('userinvoices','userinvoices.id','userquotes.userinvoice_id')->join('vendors','vendors.id','userquotes.vendor_id')->join('users','users.id','vendors.user_id')->where('userquotes.user_id',Auth::user()->id)->get();
        return view('UserDashboard.query',compact('response'));
    }

    
    public function file(Request $request){
        return view('UserDashboard.files');
    }

    public function business(Request $request){
        return view('UserDashboard.bussiness');
    }


    public function saveQuotes(Request $request){
        $invoice = array(
                            'user_id'=>Auth::User()->id,
                            'total_vendor'=>count($request->eventselevted),
                            'vendor_id'=>implode(',',$request->eventselevted),
                            'order_date'=>date('Y-m-d',strtotime($request->orderDate))
                        );
                        $id=Invoice::create($invoice);
$images=array();
for ($k=0; $k < (sizeof($request->file('resumeFile'))); $k++) { 
    $images[]=ReuseModel::UploadImages1('Uploads',$request->resumeFile[$k],$k);
}

foreach($request->eventselevted as $row){
       $UserOrders=array(
          'user_id'=>Auth::User()->id,
          'vendor_id'=>$row,
          'userinvoice_id'=>$id->id, 
          'servces_id'=>implode(',', $request->eventTypes),
          'event_name'=>$request->events,
          'name'=>$request->orderByUser,
          'event_time'=>$request->getEventTime,
          'event_date'=>date('Y-m-d',strtotime($request->orderDate)),
          'event_type'=>implode(',', $request->eventTypes),
          'events'=>$request->extraevents,
          'gaddring'=>$request->numberofgadring,
          'contact'=>$request->mobile,
          'email'=>$request->email,
          'comment'=>$request->comments,
          'images'=>json_encode($images)
       );
       Userquote::create($UserOrders);
       }

       return redirect()->back();

}




public function usersgetImagesServices(Request $request){
     $id=$request->id;
     $records=Simg::where('srvice_id',$id)->get();
     foreach($records as $row){
        ?>

        <img src="<?php echo $row->images;?>">

        <?php
     }
}



public function userProfile(Request $request){
    $response=User::where('id',Auth::User()->id)->where('status',1)->first();
    $Country=Country::get();
    $city=City::get();
    return view('UserDashboard.userProfile',compact('response','Country','city'));   
}



public function updateUserProfile(Request $request){

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

public function myevents(Request $request){
    return view('UserDashboard.myevents');
}


public function mybudgeter(Request $request){
    $events=Event::where('user_id',Auth::User()->id)->get();
    return view('UserDashboard.mybudgeter',compact('events'));
}


public function mygestlist(Request $request){
    $response=Guestlist::where('user_id',Auth::User()->id)->get();
    return view('UserDashboard.mygestlist',compact('response'));
}


public function usernotification(Request $request){
    return view('UserDashboard.usernotification');
}


public function usersmessage(Request $request){
    $response=DB::table('userquotes')->select('users.*','userquotes.*','users.id as uid','users.images as img','vendors.*','vendors.id as vid')->join('vendors','vendors.id','userquotes.vendor_id')->join('users','users.id','vendors.user_id')->where('userquotes.user_id',Auth::User()->id)->groupBy('userquotes.vendor_id')->get();
    return view('UserDashboard.usersmessage',compact('response'));
}

public function saveBudgeter(Request $request){
    $array=array(
                    'name'=>$request->budgeterName,
                    'amount'=>$request->amount,
                    'user_id'=>Auth::User()->id,
                    'date'=>date('Y-m-d')
                );
        Event::create($array);
        return redirect()->back();
}

public function geteventprice(Request $request){
    $result=Event::where('user_id',Auth::User()->id)->where('id',$request->id)->first();
    return $result;
}


public function saveBudgeterList(Request $request){
    for($i=0;$i< (sizeof($request->itemName)) ;$i++){
        $array=array(
                        'event_id'=>$request->event,
                        'user_id'=>Auth::User()->id,
                        'itme_name'=>$request->itemName[$i],
                        'itme_amount'=>$request->itemAmount[$i],
                        'itme_date'=>date('Y-m-d')
                    );
            Budgeter::create($array);
    }
    return redirect()->back();
}

public static function getItems($id){
    return Budgeter::where('event_id',$id)->get();
}



public function UpdateEvents(Request $request){
            $array=array(
                            'amount'=>$request->amount,
                            'name'=>$request->changeevent
                        );
            $id=Event::where('id',$request->id)->update($array);
            $response=Event::where('id',$request->id)->first();
        return json_encode($response);

}


public function UpdateBudgeter(Request $request){
            $array=array(
                            'itme_amount'=>$request->amount,
                            'itme_name'=>$request->changeevent
                        );
            $id=Budgeter::where('id',$request->id)->update($array);
            $response=Budgeter::where('id',$request->id)->first();
        return json_encode($response);

}


public function deleteEvents(Request $request){
         
            $id=Event::where('id',$request->id)->delete();

}

public function Deleteitem(Request $request){
         
            $id=Budgeter::where('id',$request->id)->delete();

}

public function submitGuest(Request $request){
    $array=array(
                    'guest_name'=>$request->guest_name,
                    'email_name'=>$request->gust_email,
                    'date'=>date('Y-m-d'),
                    'status'=>$request->guest_status,
                    'user_id'=>Auth::User()->id
                );
    if($request->guest_id==''){
            Guestlist::create($array);
    }else{
        Guestlist::where('id',$request->guest_id)->update($array);
    }

    return redirect()->back();

}


public function updateGuestLIst(Request $request){
    return Guestlist::where('id',$request->id)->first();
}

public function deletegueslist(Request $request){
    $result=Guestlist::where('id',$request->id)->delete();
}


public function SendMessagetoVendors(Request $request)
{
     $fistid=Vendor::where('user_id',Auth::User()->id)->first();
        $array = array(
                    'message' =>$request->Message, 
                    'user_id' =>Auth::User()->id, 
                    'type' =>2, 
                    'vendor_id' =>$request->id, 
                    'date' =>date('Y-m-d'), 
                );
    Message::create($array);
}





public function getallVendorMessages(Request $request){

    $condition='';
    if($request->Greater!=''){
        $condition=$request->Greater;
    }
    $response=Message::where('vendor_id',$request->id)->where('user_id',Auth::User()->id)
        ->where(function($query) use($condition){
        if($condition!=''){
            $query->where('id','>',$condition);
        }
    })
    ->get();
            foreach($response as $ft){
               // dd($ft);
                $fistid=Vendor::where('id',$ft->vendor_id)->first();
               // dd($fistid);
                $vendorUserid=$fistid->user_id;
                $vids=$fistid->id;
                if($ft->type==1){
                    $Users=User::where('id',$vendorUserid)->first();
                    $ft->img=$Users->images;
                }else{
                    $Users=User::where('id',$ft->user_id)->first();
                    $ft->img=$Users->images;
                }
                $message_Id=Message::where('user_id',Auth::User()->id)->where('vendor_id',$vids)->max('id');
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


public function userChangePassword(Request $request){
  return view('UserDashboard.changePassword');
}




public function UsersChangePassword(Request $request){
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


/* End controller*/
}
