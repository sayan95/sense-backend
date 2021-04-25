<?php

use App\Model\User\Therapist\Therapist;
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

/* 
 *Admin routes
*/
Route::group([
    'namespace' => 'Web\Admin',
    'prefix' => 'admin',
    'middleware' => 'guest:admin'
], function(){
    Route::post('/login', 'Auth\LoginController@login')->name('admin.login');
}); // guest routes group


Route::group([
    'namespace' => 'Web\Admin',
    'prefix' => 'admin',
], function(){
    Route::get('/me', 'Auth\LoginController@me')->name('admin.me');
    Route::post('/logout', 'Auth\LoginController@logout')->name('admin.logout');
});  // auth routes group





/**
 *  therapist routes group
 */
Route::group([ 
    'prefix' => 'therapist',
    'namespace' => 'Web\User\Therapist',
    'middleware' => 'guest:therapist'
], function(){
    Route::post('/login', 'Auth\LoginController@login')->name('therapist.login');
    Route::post('/register', 'Auth\RegisterController@register')->name('therapist.register');
    Route::post('/auth/verify', 'Auth\EmailVerificationController@verify')->name('therapist.verify.email');
    Route::get('/resend/verify', 'Auth\EmailVerificationController@resendLink')->name('therapist.verify.email.resend');
});  // guest routes

Route::group([
    'prefix' => 'therapist',
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
    'prefix' => 'app',
    'namespace' => 'Web\App'
], function(){
    Route::get('/service/therapist', 'TherapistServiceSupportController@getTherapistServiceData')->name('app.therapist.service');
});



// route for testing endpoint connection 
Route::get('/test/connection/server', function(){
    return response()->json([
        'alertType' => 'connection-success',
        'message' => 'connection to API endpoints is established successfully'
    ], 200);
});
