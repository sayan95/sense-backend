<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



/**
 *  therapist routes group
 */
Route::group([ 
    'prefix' => 'therapist/auth-api',
    'namespace' => 'Web\User\Therapist',
    'middleware' => 'guest:therapist'
], function(){
    Route::post('/login', 'Auth\LoginController@login')->name('therapist.login');
    Route::post('/register', 'Auth\RegisterController@register')->name('therapist.register');
    Route::post('/auth/verify', 'Auth\EmailVerificationController@verify')->name('therapist.verify.email');
    Route::get('/resend/verify', 'Auth\ResendOtpController@resendLink')->name('therapist.verify.email.resend');
});  // guest routes

Route::group([
    'prefix' => 'therapist/auth-api',
    'namespace' => 'Web\User\Therapist',
    'middleware' => 'auth:therapist'
], function(){
    Route::get('/profile', 'Auth\MeController@me')->name('therapist.profile');
    Route::post('/create/profile/{email}', 'Auth\ProfileController@createProfile')->name('therapist.profile.create');
    Route::post('/logout', 'Auth\LogoutController@logout')->name('therapist.logout');
}); // auth routes


/**
 *  Application related configs and support service route group
 */
Route::group([
    'prefix' => 'app/service-api',
    'namespace' => 'Web\App'
], function(){
    Route::get('/service/therapist', 'TherapistServiceSupportController@getTherapistServiceData')->name('app.therapist.service');
    Route::get('/settings/info', 'AppSettingsController@index')->name('app.settings.info');
});


// route for testing endpoint connection 
Route::get('/test/connection/server', 'Web\Connection\AppConnectioncontroller@checkAppConnection');
Route::get('/test/connection/db', 'Web\Connection\DBConnectioncontroller@checkDBConnection');
