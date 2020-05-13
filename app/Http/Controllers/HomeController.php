<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Reset password by confirming email
     *
     * @return response
     */  
    public function resetPassword(Request $request) {

        $user = $request->input('user');
        $usertoken = $request->input('usertoken');

        if(!empty($user) && !empty($usertoken))
        {
            $check_token =  User::where(['id'=>$request->input('user'), 'pass_token'=>$request->input('usertoken')])->first();
            if ($check_token) {

                return view('emails.reset_password', compact('user', 'usertoken'));

            }else{
                return view('emails.expire_link');
            }
        }else{
            return view('emails.alert');
        }
    }


    /**
     * Save Reset password by confirming email
     *
     * @return response
     */ 
    public function saveResetPassword(Request $request)
    {
        $this->validation($request->all(), [
            "user" => "required",
            "usertoken" => "required",
        ]);


        $user = $request->input('user');
        $usertoken = $request->input('usertoken');
        $newPassword = password_hash($request->input('password'), PASSWORD_DEFAULT);

        $check_token =  User::where(['id'=>$user, 'pass_token'=>$usertoken])->first();
        if ($check_token) {

            $update =  User::where(['id'=>$user, 'pass_token'=>$usertoken])->update(['pass_token'=>'', 'password'=>$newPassword]);

            if($update){
                return view('emails.thankyou', compact('user', 'usertoken'));
            }else{
                Session::flash('message', 'Somthing went wrong, Please try again!');
                Session::flash('alert-class', 'alert-danger'); 
                return view('emails.resetpass', compact('user', 'usertoken'));
            }
        }else{
            
            return view('emails.alert');
        }
    }
}
