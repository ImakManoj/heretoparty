<?php

namespace App\Http\Controllers\Admin;

use App\Users;
use App\Transaction;
use App\Favourite;
use App\Http\Controllers\Api\StringcompareController;
use Illuminate\Http\Request;
use URL;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $usres = [];
       $users = Users::where('id', '<>', 1)->orderBy('id', 'DESC')->get();
       

       return view('admin.users.index', compact('users'));
       
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
     * @return type 1=> artist, 2=> album, 3=> playlist, 4=> song
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = '')
    {
       $users_details = Users::where(['id'=>$id])->first();

       $fav_albums =  Favourite::where(['type'=>2, 'user_id'=>$id, 'status'=>1])->with('getContentsInfo')->get();

       $fav_artists =  Favourite::where(['type'=>1, 'user_id'=>$id, 'status'=>1])->with('getContentsInfo')->get();

       $fav_playlists =  Favourite::where(['type'=>3, 'user_id'=>$id, 'status'=>1])->with('getContentsInfo')->get();

       $fav_songs =  Favourite::where(['type'=>4, 'user_id'=>$id, 'status'=>1])->with('getSongInfo')->get();

       return view('admin.users.view', compact('users_details', 'fav_albums', 'fav_artists', 'fav_playlists', 'fav_songs'));
    }

    //get user profile using from user_id
    public static function getUserProfile($user_id='') {

        $userinfo =  Users::where('id', $user_id)->first();
        $picture = URL::to('/uploads/').'/'.'images.jpg';
        if ($userinfo) {
            if(strstr($userinfo->profile, 'https://')){
                $picture = $userinfo->profile;
            }elseif(!empty($userinfo->profile)){
                $picture = URL::to('/uploads/users/').'/'.$userinfo->profile;
            }
        }
        return (string) @$picture;
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
