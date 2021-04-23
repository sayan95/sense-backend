<?php

namespace App\Http\Controllers\Web\User\Therapist\Auth;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Therapist\TherapistResource;
use App\Services\Interfaces\ITherapistService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    private $therapistService;

    public function __construct(ITherapistService $therapistService){
        $this->therapistService = $therapistService;
        $this->middleware('guest:therapist')->only('login');
    }

    // validate login credentials
    protected function validateLogin(Request $request)
    {
        
        $request->validate([
            'email' => 'required|string|email|max:50',
            'password' => 'required|string',
        ]);
    }
    
    // attempts for login
    protected function attemptLogin(Request $request){
        // login credentials
        $credentials = $request->only('email', 'password');
        if($request->has('remember_me') && $request->remember_me === true){
            $token = $this->guard()->claims(['csrf_token' => Str::random(32)])->setTTL(20160)->attempt($credentials);
        }else{
            $token = $this->guard()->claims(['csrf_token' => Str::random(32)])->attempt($credentials);
        } 
        if(!$token){
            return false;
        }

        // set the user's token
        $this->guard()->setToken($token);

        return true;
    }

    // send login success response
    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        //get the token
        $token = (string)$this->guard()->getToken();

        // set to httponly cookie
        $jwtCookie = cookie('jwt', $token, 60);
        $csrfCookie = cookie('csrf', $this->guard()->payload()->get('csrf-token'), 60);

        //extract the token's expiary date
        $expiration = $this->guard()->getPayload()->get('exp');

        // return success message with token
        return response()->json([
            'alertType' => 'login-success',
            'message' => 'You are Logged in successfully',
            'token'=>$token,
            'token_type' => 'bearer',
            'expires_in' => $expiration,
            'user' => new TherapistResource($this->guard()->user())
        ], 200)->withCookie($jwtCookie)->withCookie($csrfCookie);
    }

    // sends login failed reponse
    protected function sendFailedLoginResponse(Request $request)
    {
        return response()->json([
            'alertType' => 'credential-error',
            'errors' => [
                'email' => 'Invalid email or password'
            ]
        ], 422);
    }

    // returns authentication guard for therapist
    private function guard(){
        return auth()->guard('therapist');
    } 

}
