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
    return view('UserDashboard.usersmessage');
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











/* End controller*/
}
