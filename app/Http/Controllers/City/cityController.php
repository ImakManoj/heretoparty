<?php

namespace App\Http\Controllers\City;

use App\Http\Controllers\Controller;
use App\cityModel;
use Illuminate\Http\Request;

class cityController extends Controller
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

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $data=array(
            'city_name'=>$request->city_name,
            'country_id'=>$request->country_id
        );
       $response=cityModel::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\cityModel  $cityModel
     * @return \Illuminate\Http\Response
     */
    public function show(cityModel $cityModel)
    {
        return $response=cityModel::get()->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\cityModel  $cityModel
     * @return \Illuminate\Http\Response
     */
    public function edit(cityModel $cityModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\cityModel  $cityModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cityModel $cityModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\cityModel  $cityModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(cityModel $cityModel)
    {
        //
    }
}
