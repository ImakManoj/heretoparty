<?php

namespace App\Http\Controllers\Admin;

use App\Users;
use App\Content;
use App\Song;
use App\Transaction;
use DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $users_count = 0;
       $artists_count = 0;
       $albums_count = 0;
       $playlists_count = 0;
       $tracks_count = 0;

       $users_count = Users::where('id', '<>', 1)->count();
       $artists_count = Content::where('cat_id',1)->count();
       $albums_count = Content::where('cat_id',2)->count();
       $playlists_count = Content::where('cat_id',3)->count();
       $tracks_count = Song::where('status', 1)->count();

       return view('admin.dashboard.index', compact('users_count', 'artists_count', 'albums_count', 'playlists_count', 'tracks_count'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
