<?php
 
use Illuminate\Support\Facades\Route;

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

/*Route::get('/', function () { 
    return view('welcome');
});*/ 
 

Route::get('/','Pages\pageController@index')->name('index');	
Route::get('about','Pages\pageController@about')->name('about');	
Route::get('careers','Pages\pageController@careers')->name('careers');	
Route::get('contact','Pages\pageController@contact')->name('contact');	
Route::get('userlogin','Pages\pageController@userLogin')->name('userlogin');	
Route::get('signup','Pages\pageController@signup')->name('signup');	
Route::get('forgot','Pages\pageController@forgot')->name('forgot');	
Route::get('termCondition','Pages\pageController@termCondition')->name('termCondition');	
Route::post('getCities','Pages\pageController@getCities')->name('getCities');	
Route::get('vendorDetails/{id?}','Pages\pageController@vendorDetails')->name('vendorDetails');	
Route::match(['GET','POST'],'searchEvents','Pages\pageController@searchEvents')->name('searchEvents');	


Auth::routes();

Route::post('signup','Auth\UserAuthController@store')->name('signup');	
Route::post('loginUsers','Auth\UserAuthController@loginUsers')->name('loginUsers');	
Route::get('/home', 'HomeController@index')->name('home');

/*Vender Router*/

Route::group(['middleware' => 'App\Http\Middleware\Client'], function()
{
Route::get('vendordashboard','Vender\VenderController@dashboard')->name('vendordashboard');
Route::get('vendorquery','Vender\VenderController@query')->name('vendorquery');
Route::get('business','Vender\VenderController@business')->name('business');
Route::get('vendorfile','Vender\VenderController@file')->name('vendorfile');
Route::post('createBusinessProfile','Vender\VenderController@createBusinessProfile')->name('createBusinessProfile');
Route::post('getSubCategory','Vender\VenderController@getSubCategory')->name('getSubCategory');
Route::get('vendorProfile','Vender\VenderController@vendorProfile')->name('vendorProfile');
Route::get('pages','Vender\VenderController@pages')->name('pages');
Route::post('getImagesServices','Vender\VenderController@getImagesServices')->name('getImagesServices');
Route::post('getCity','Vender\VenderController@getCity')->name('getCity');
Route::post('updateProfile','Vender\VenderController@updateProfile')->name('updateProfile');
Route::post('saveBrochure','Vender\VenderController@saveBrochure')->name('saveBrochure');
Route::post('getbouchers','Vender\VenderController@getbouchers')->name('getbouchers');
Route::get('notification','Vender\VenderController@notification')->name('notification');
Route::get('messages','Vender\VenderController@messages')->name('messages');

});
Route::get('CreateQuote/{id?}','Pages\pageController@CreateQuote')->name('CreateQuote');


/*End Vendor Router*/
/* Users */


Route::group(['middleware' => 'App\Http\Middleware\Users'], function()
{
Route::get('usersdashboard','Users\UsersController@dashboard')->name('usersdashboard'); 
Route::get('query','Users\UsersController@query')->name('query');
Route::get('file','Users\UsersController@file')->name('file');
Route::post('saveQuotes','Users\UsersController@saveQuotes')->name('saveQuotes');
Route::post('usersgetImagesServices','Users\UsersController@usersgetImagesServices')->name('usersgetImagesServices');

Route::get('userProfile','Users\UsersController@userProfile')->name('userProfile');

Route::get('myevents','Users\UsersController@myevents')->name('myevents');
Route::get('mybudgeter','Users\UsersController@mybudgeter')->name('mybudgeter');
Route::get('mygestlist','Users\UsersController@mygestlist')->name('mygestlist');
Route::get('usernotification','Users\UsersController@usernotification')->name('usernotification');
Route::get('usersmessage','Users\UsersController@usersmessage')->name('usersmessage');
Route::post('saveBudgeter','Users\UsersController@saveBudgeter')->name('saveBudgeter');
Route::post('geteventprice','Users\UsersController@geteventprice')->name('geteventprice');
Route::post('saveBudgeterList','Users\UsersController@saveBudgeterList')->name('saveBudgeterList');
Route::post('UpdateEvents','Users\UsersController@UpdateEvents')->name('UpdateEvents');
Route::post('UpdateBudgeter','Users\UsersController@UpdateBudgeter')->name('UpdateBudgeter');
Route::post('deleteEvents','Users\UsersController@deleteEvents')->name('deleteEvents');
Route::post('Deleteitem','Users\UsersController@Deleteitem')->name('Deleteitem');
Route::post('submitGuest','Users\UsersController@submitGuest')->name('submitGuest');
Route::post('updateGuestLIst','Users\UsersController@updateGuestLIst')->name('updateGuestLIst');
Route::post('deletegueslist','Users\UsersController@deletegueslist')->name('deletegueslist');



Route::post('updateUserProfile','Users\UsersController@updateUserProfile')->name('updateUserProfile');
});
/*Users*/

/*Super Admin Router*/
Route::get('admin','Admin\Admins@index')->name('admin');
Route::post('admin','Admin\Admins@login')->name('login');

Route::group(['middleware' => 'App\Http\Middleware\SuperAdmin'], function()
{
	Route::get('admndashboard','Admin\Admins@dashboard')->name('admndashboard');
	Route::get('banner','Admin\Admins@banner')->name('banner');
	Route::get('aboutBanner','Admin\Admins@banner')->name('aboutBanner');
	Route::get('iWantToPlan','Admin\Admins@iWantToPlan')->name('iWantToPlan');
	Route::get('vendorsRecentlyBooked','Admin\Admins@vendorsRecentlyBooked')->name('vendorsRecentlyBooked');
	Route::get('howItWorks','Admin\Admins@howItWorks')->name('howItWorks');
	Route::get('aboutUs','Admin\Admins@aboutUs')->name('aboutUs');
	Route::post('saveBanner','Admin\Admins@saveBanner')->name('saveBanner');
	Route::post('saveiwanttoplan','Admin\Admins@saveiwanttoplan')->name('saveiwanttoplan');
	Route::post('saveHeadingTitle','Admin\Admins@saveHeadingTitle')->name('saveHeadingTitle');
	Route::post('saveVendorBooked','Admin\Admins@saveVendorBooked')->name('saveVendorBooked');
	Route::post('saveHowitworkedHeadingTitle','Admin\Admins@saveHowitworkedHeadingTitle')->name('saveHowitworkedHeadingTitle');
	Route::post('savehowitworks','Admin\Admins@savehowitworks')->name('savehowitworks');
	Route::post('saveaboutus','Admin\Admins@saveaboutus')->name('saveaboutus');
	Route::get('degination','Admin\Admins@degination')->name('degination');
	Route::get('ourteam','Admin\Admins@ourteam')->name('ourteam');
	Route::post('savedegination','Admin\Admins@savedegination')->name('savedegination');
	Route::post('savedOurTeam','Admin\Admins@savedOurTeam')->name('savedOurTeam');
	Route::get('careers','Admin\Admins@careers')->name('careers');
	Route::post('savedCareers','Admin\Admins@savedCareers')->name('savedCareers');
	Route::post('editBanner','Admin\Admins@editBanner')->name('editBanner');
	Route::post('editdegination','Admin\Admins@editdegination')->name('editdegination');
	Route::post('editiwantmyplan','Admin\Admins@editiwantmyplan')->name('editiwantmyplan');
	Route::post('editvendors','Admin\Admins@editvendors')->name('editvendors');
	Route::post('edithowitworks','Admin\Admins@edithowitworks')->name('edithowitworks');
	Route::post('editaboutus','Admin\Admins@editaboutus')->name('editaboutus');
	Route::get('adminCategory','Admin\Admins@adminCategory')->name('adminCategory');
	Route::post('addcategories','Admin\Admins@addcategories')->name('addcategories');
	Route::post('GetCatById','Admin\Admins@GetCatById')->name('GetCatById');
	Route::get('DeleteCategory','Admin\Admins@DeleteCategory')->name('DeleteCategory');
	Route::get('SearchCategory','Admin\Admins@SearchCategory')->name('SearchCategory');
	Route::get('tags','Admin\Admins@tags')->name('tags');
	Route::post('addtags','Admin\Admins@addtags')->name('addtags');
	Route::get('adminService','Admin\Admins@adminService')->name('adminService');
	Route::post('addServicesByadmin','Admin\Admins@addServicesByadmin')->name('addServicesByadmin');
	
});
Route::post('adinReg','SuperAdminControler\SuperAdminController@adinReg')->name('adinReg');
Route::get('forgorpassword','SuperAdminControler\SuperAdminController@forgorpassword')->name('forgorpassword');


