<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::POST('createQuestion','question\userQuestionController@create');
Route::POST('questiondestroy','question\userQuestionController@Questiondestroy');
Route::POST('questionShow','question\userQuestionController@show');
Route::POST('createTable','Table\tableControrller@createTable');
Route::POST('getRecords','Table\tableControrller@getRecords');
Route::POST('insertRecords','Table\tableControrller@insertRecords');
Route::POST('getRecordsMulipleTables','Table\tableControrller@getRecordsMulipleTables');
Route::POST('getTables','Table\tableControrller@getTables');
Route::POST('runQuery','Table\tableControrller@runQuery');
