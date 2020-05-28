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
Route::group(['prefix' => 'visacounsellor','middleware' => ['assign.guard:visacounsellors']],function ()
{
	Route::post('register', 'VisaCounsellorController@register');
    Route::post('login', 'VisaCounsellorController@authenticate');
});
Route::group(['prefix' => 'student','middleware' => ['assign.guard:students']],function ()
{
	Route::post('register', 'StudentController@register');
    Route::post('login', 'StudentController@authenticate');
});

Route::group(['prefix' => 'visacounsellor','middleware' => ['assign.guard:visacounsellors','jwt.verify']], function() {
    Route::get('user', 'VisaCounsellorController@getAuthenticatedUser');
    Route::post('updateExpertise', 'VisaCounsellorController@updateExpertise');
    Route::post('updateTraining', 'VisaCounsellorController@updateTraining');
    Route::post('updateLanguages', 'VisaCounsellorController@updateLanguages');
    Route::post('updateFees', 'VisaCounsellorController@updateFees');
    Route::post('updateProfile', 'VisaCounsellorController@updateProfile');
    Route::post('updateProfileImage', 'VisaCounsellorController@updateProfileImage');
    Route::post('sendVerificationCode', 'VisaCounsellorController@sendVerificationCode');
    Route::post('checkVerificationCode', 'VisaCounsellorController@checkVerificationCode');
    
    Route::get('closed', 'DataController@closed');
});
Route::group(['prefix' => 'student','middleware' => ['assign.guard:students','jwt.verify']], function() {
    Route::get('students', 'StudentController@getAuthenticatedStudents');
    Route::post('updateVisaType', 'StudentController@updateVisaType');
    Route::post('updateTravelHistory', 'StudentController@updateTravelHistory');
    Route::post('updateFunding', 'StudentController@updateFunding');
    Route::post('updateProposedStudy', 'StudentController@updateProposedStudy');
    Route::post('updateLocation', 'StudentController@updateLocation');
    Route::post('updateProfileImage', 'StudentController@updateProfileImage');
    // Route::post('updateExpertise', 'VisaCounsellorController@updateExpertise');
    // Route::post('updateTraining', 'VisaCounsellorController@updateTraining');
    // Route::post('updateLanguages', 'VisaCounsellorController@updateLanguages');
    // Route::post('updateFees', 'VisaCounsellorController@updateFees');
    // Route::post('updateProfile', 'VisaCounsellorController@updateProfile');
    // Route::post('updateProfileImage', 'VisaCounsellorController@updateProfileImage');
    // Route::post('sendVerificationCode', 'VisaCounsellorController@sendVerificationCode');
    // Route::post('checkVerificationCode', 'VisaCounsellorController@checkVerificationCode');
    
});

