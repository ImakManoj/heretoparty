<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
});


Route::get('auth/resetPass','HomeController@resetPassword');
Route::post('auth/saveResetPass','HomeController@saveResetPassword');

Route::group(array('prefix' => 'admin', 'namespace' => 'Admin'), function () {
	Route::get('/', function () {
	    return view('auth/login');
	});
});

Route::group(array('prefix' => 'admin', 'namespace' => 'Admin',  'middleware' => 'auth'), function () {

  Route::resource('/dashboard', 'DashboardController');
  Route::resource('/users', 'UsersController');
  Route::resource('/prices', 'PricesController');
  Route::resource('/verbs', 'VerbsController');
  Route::resource('/statements', 'StatementsController');
  Route::resource('/keyword', 'KeywordController');
  Route::resource('/balances', 'BalancesController');
  Route::resource('/blogs', 'BlogsController');

  Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

  Route::resource('/categories', 'CategoriesController');
  Route::get('/voicelist', 'CategoriesController@voicelist')->name('voicelist');
  Route::get('/voice/{id?}', 'CategoriesController@voice')->name('voice');
  Route::post('/voiceSave', 'CategoriesController@voiceSave')->name('voiceSave');
  Route::resource('/albums', 'AlbumsController');
  Route::resource('/artists', 'ArtistsController');
  Route::resource('/playlists', 'PlaylistsController');
  Route::resource('/tracks', 'TracksController');
  Route::resource('/banner', 'BannerController');
  Route::resource('/featured_playlist', 'FeaturedPlaylistController');
  Route::resource('/help_pages', 'PagesController');

  Route::get('nature', 'CategoriesController@nature')->name('nature');
  Route::get('/addNature', 'CategoriesController@addNature')->name('addNature');
  Route::post('/natureSave', 'CategoriesController@natureSave')->name('natureSave');

  Route::get('/songPlayCount/{id}', 'SongsController@songPlayCount');

});




Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

// Auth::routes();

// Route::get('/Voice', 'CategoriesController@voice')->name('voice');

Route::resource('admin/songs', 'Admin\\SongsController');
