<?php

namespace App\Http\Controllers\Web\User\Therapist\Auth;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Services\Interfaces\ITherapistService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Resources\Therapist\TherapistResource;
use App\Events\User\Therapist\SendOtpForTherapistEvent;

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
            $token = $this->guard()->setTTL(20160)->attempt($credentials);
        }else{
            $token = $this->guard()->attempt($credentials);
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

        // check user has verified email
        $has_verified_email = $this->guard()->user()->is_active;
        
        // email is not verified
        if(!$has_verified_email){
            // get the auth user
            $therapist = $this->therapistService->findTherapistById($this->guard()->id());
            
            $token = rand(100000, 999999);                                  // generate a 6 digit token
            
            if($request->cookie('OTP_COOKIE')){                             // Delete any xisting cookie
                cookie()->forget('OTP_COOKIE');
            }
            if($request->cookie('attempter')){
                cookie()->forget('attempter');
            }

            $otpCookie = cookie('OTP_COOKIE', Crypt::encrypt($token), 60);     // set the token in a cookie
            $attemptedUserCookie = cookie('attempter', Crypt::encrypt($therapist->email), 60);

            $therapist->sendEmailVerificationMail($token);                    // send the email for otp 
            
            // logout user
            $this->guard()->logout();
            $jwtCookie = cookie()->forget('jwt');

            // return response
            return response()->json([
                'alertType' => 'account-not-verified',
                'message' => 'Your account is not verified yet.Enter the OTP sent to tour email to verify your account.',
            ], 422)->withCookie($otpCookie)->withCookie($jwtCookie)->withCookie($attemptedUserCookie);
        }

        //get the token
        $token = (string)$this->guard()->getToken();

        // set to httponly cookie
        $jwtCookie = cookie('jwt', $token, 60);

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
        ], 200)->withCookie($jwtCookie);
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
