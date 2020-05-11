<?php

namespace App\Http\Controllers\Auth;

use App\AuthModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Session;
use Auth;

class UserAuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $userdata=AuthModel::create([
        'first_name' => $request->first_name,
        'last_name'=>$request->last_name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'country_id'=>$request->countries,
        'city_id'=>$request->cities,
        'role'=>$request->LookingFor
        ]);
         Session::flash('message', 'Your are Register Successfully!');
          return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AuthModel  $authModel
     * @return \Illuminate\Http\Response
     */
    public function show(AuthModel $authModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AuthModel  $authModel
     * @return \Illuminate\Http\Response
     */
    public function edit(AuthModel $authModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AuthModel  $authModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AuthModel $authModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AuthModel  $authModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(AuthModel $authModel)
    {
        //
    }

    public function loginUsers(Request $request){
         if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user();
            if(Auth::User()->role=="Admin"){
                  return redirect()->route('admndashboard');
            }elseif(Auth::User()->role=="Vendor"){
                  return redirect()->route('vendordashboard');
            }elseif(Auth::User()->role=="Users"){
                  return redirect()->route('usersdashboard');
            }


          
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }


    /*End Users Controller*/
}
