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
Route::post('register', 'UserController@register');
Route::post('login', 'UserController@authenticate');
Route::get('open', 'DataController@open');

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', 'UserController@getAuthenticatedUser');
    Route::post('updateExpertise', 'UserController@updateExpertise');
    Route::post('updateTraining', 'UserController@updateTraining');
    Route::post('updateLanguages', 'UserController@updateLanguages');
    Route::post('updateFees', 'UserController@updateFees');
    Route::post('updateProfile', 'UserController@updateProfile');
    Route::post('updateProfileImage', 'UserController@updateProfileImage');
    Route::post('sendVerificationCode', 'UserController@sendVerificationCode');
    Route::post('checkVerificationCode', 'UserController@checkVerificationCode');
    
    Route::get('closed', 'DataController@closed');
});

