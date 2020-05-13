<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['namespace' => 'Api'], function () {

  //auth process
  Route::post('auth/register','AuthController@register'); 
  Route::post('auth/login','AuthController@login');  
  Route::post('auth/forgotPassword','AuthController@forgotPassword');  
  Route::post('auth/changePassword','AuthController@changePassword');  
  Route::post('auth/getProfile','AuthController@getProfile');  
  Route::post('auth/editProfile','AuthController@editProfile');  
  Route::post('auth/changeNotification','AuthController@changeNotification');  
  Route::post('auth/logout','AuthController@logout');  
  
  Route::post('auth/checkSubscription','AuthController@checkSubscription');  
   

  //Collections 
  Route::post('collections/getHomeData','CollectionsController@getHomeData');
  Route::get('collections/getTracks','CollectionsController@getTracks');
  Route::post('collections/getAllSongs','CollectionsController@getAllSongs');
  Route::post('collections/getSongsByGroup','CollectionsController@getSongsByGroup');
  Route::post('collections/getContentsInfo','CollectionsController@getContentsInfo');

  //Favourite
  Route::post('collections/addFavourite','CollectionsController@addFavourite');
  
  //Explore Data
  Route::post('collections/getExploreData','CollectionsController@getExploreData');
  Route::post('collections/getExploreNewInfo','CollectionsController@getExploreNewInfo');
  Route::post('collections/getExploreTopInfo','CollectionsController@getExploreTopInfo');
  Route::post('collections/getHomeDataNew','CollectionsController@getHomeDataNew');

  //My Collections 
  Route::post('mycollections/getPlaylist','MyCollectionsController@getPlaylist');
  Route::post('mycollections/getAlbums','MyCollectionsController@getAlbums');
  Route::post('mycollections/getArtists','MyCollectionsController@getArtists');
  Route::post('mycollections/getSongs','MyCollectionsController@getSongs');
  Route::post('mycollections/createPlaylist','MyCollectionsController@createPlaylist');
  Route::post('mycollections/addStats','MyCollectionsController@addStats');

  //search all data
  Route::post('mycollections/searchAllData','MyCollectionsController@searchAllData');
  Route::post('mycollections/searchViewAll','MyCollectionsController@searchViewAll');
  
  //payment modules
  Route::post('payment/generateToken','PaymentsController@token'); 
  Route::post('payment/payment','PaymentsController@payment'); 
  Route::post('payment/sendIam','PaymentsController@sendIam'); 
  Route::post('payment/sendImHistory','PaymentsController@sendImHistory'); 
  Route::post('payment/receiveImHistory','PaymentsController@receiveImHistory'); 
  Route::post('payment/requestIam','PaymentsController@requestIam');
  

   
  Route::get('auth/getTracks','AuthController@getTracks');
  Route::post("music/getPlaylist",'AuthController@getPlaylists');
  Route::post('auth/getTracksByArtist','AuthController@getTracksByArtist');
  Route::post('auth/getTracksByAlbum','AuthController@getTracksByAlbum');

  //Help pages
  Route::get('auth/aboutUs','AuthController@aboutUs');  
  Route::get('auth/privacyPolicy','AuthController@privacyPolicy');  
  Route::get('auth/termsCondtions','AuthController@termsCondtions');


  Route::post('auth/contactUs','AuthController@contactUs');  
  Route::post('auth/deleteKeyword','AuthController@deleteKeyword');  
  Route::get('auth/confirmMail','AuthController@confirmMail');
  Route::post('auth/resendVerificationmail','AuthController@resendVerificationmail'); 
  Route::post('auth/changeNotification','AuthController@changeNotification'); 

  //update qb id
  Route::post('auth/updateQbId','AuthController@updateQbId'); 
  Route::post('auth/getQbDetails','AuthController@getQbDetails'); 

  //Referral
  Route::post('auth/AddImByReferral','AuthController@AddImByReferral'); 

  

  //statement modules
  Route::get('statement/getVerbs','StatementController@getVerbs');  
  Route::post('statement/submitStatement','StatementController@submitStatement');  
  Route::post('statement/getStatements','StatementController@getStatements');  
  Route::post('statement/myStatements','StatementController@myStatements');  
  Route::post('statement/editStatement','StatementController@editStatement');  
  Route::post('statement/deleteStatement','StatementController@deleteStatement');  

  //payment modules
  Route::get('payment/generateToken','PaymentsController@token'); 
  Route::post('payment/byIam','PaymentsController@payment'); 
  Route::post('payment/sendIam','PaymentsController@sendIam'); 
  Route::post('payment/sendImHistory','PaymentsController@sendImHistory'); 
  Route::post('payment/receiveImHistory','PaymentsController@receiveImHistory'); 
  Route::post('payment/requestIam','PaymentsController@requestIam'); 

  Route::get('users/searchUsers','PaymentsController@searchUsers'); 
  Route::post('users/getNotifications','PaymentsController@getNotifications'); 
  

  Route::get('/posts', 'PostsController@index');
  Route::resource('/users', 'UsersController');



});

