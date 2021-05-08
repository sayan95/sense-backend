<?php

namespace App\Http\Controllers\Web\User\Therapist\Auth;

use Throwable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\ITherapistService;
use App\Events\User\Therapist\TherapistRegisterdEvent;
use App\Http\Resources\Therapist\TherapistResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class EmailVerificationController extends Controller
{
    private $therapistService;
    public function __construct(ITherapistService $therapistService)
    {
        $this->therapistService = $therapistService;
    }

    // verifying account activation request
    public function verify(Request $request)
    {
        
        $otp_from_client = $request->otp;                      // get the entered otp
        $otp_from_cookie = $request->Cookie('OTP_COOKIE')      // get the otp from cookie
                            ?(string)Crypt::decrypt($request->cookie('OTP_COOKIE')) 
                            : '';

        //  get the attempted user
        if($request->cookie('attempter')){
            cookie()->forget('attempter');
        }
        $user_from_cookie = $request->cookie('attempter');
        
        // return response for invalid attemter
        if(!$user_from_cookie){
            return response()->json([
                'alertType' => 'invalid-attempter',
                'message' => 'current session is over. Try to login again'
            ], 403);
        }

        
        if($otp_from_client !== $otp_from_cookie ){         // send invalid response if otp is not matched
            
            if($otp_from_cookie === ''){                   // if cookie removed or invalidated
                return response()->json([
                    'alertType' => 'otp-timeout',
                    'message' => 'Your current session is over. Click the resend link for a new OTP'
                ], 422);
            }
            return response()->json([                       // if otp mismatched
                'alertType' => 'otp-mismatch',
                'message' => 'Invalid OTP entered'
            ], 422);
        }
        
        // find the therapist
        $user = $this->therapistService->findTherapistBySpecificField('email', Crypt::decrypt($user_from_cookie));

        // if the user id is invalid
        if ($user == null) {
            return response()->json([
                'alertType' => 'verification-link-error',
                'message' => "Invalid verification link"
            ], 422);
        }

        // check if the user has already verified account
        if ($user->hasVerifiedEmail() !== 'pending') {
            return response()->json([
                'alertType' => 'already-verified-account',
                'message' => 'Your account is already verified'
            ], 422);
        }
        
        try{
            // Fire event of registering therapist to sense
            event(new TherapistRegisterdEvent($user));
            
            // login user
            $token = $this->guard()->login($user);
            $this->guard()->setToken($token);
            $this->therapistService->updateTherapistDetails($this->guard()->id(),[
            'logged_in_at' => Carbon::now()
            ]);

            // set to httponly cookie
            $jwtCookie = cookie('jwt', $token, 60);
            

            // remove otp cookie
            $otpCookie = cookie()->forget('OTP_COOKIE');

            // remove attempter cookie
            $attempterCookie = cookie()->forget('attempter');

            //extract the token's expiary date
            $expiration = $this->guard()->getPayload()->get('exp');

            // send the verification success message 
            return response()->json([
                'alertType' => 'verification-success',
                'message' => 'Your account is verified successfully',
                'user' => new TherapistResource($user)
            ], 200)->withCookie($jwtCookie)
                    ->withCookie($otpCookie)
                    ->withCookie($attempterCookie);
        }
        catch(Throwable $exception){
            return $exception;
            return response()->json([
                'alertType' => 'internal-server-error',
                'message' => 'Something went wrong ! Please try again later'
            ], 500);
        }
    
    }

    // resend verification link
    public function resendLink(Request $request)
    {
        // get the attempter cookie
        $attempter = $request->cookie('attempter');

        // return response for invalid attemter
        if(! $attempter){
            return response()->json([
                'alertType' => 'invalid-attempter',
                'message' => 'current session is over. Try to login again'
            ], 403);
        }

        // if user not found
        $user = $this->therapistService->findTherapistBySpecificField('email', Crypt::decrypt($attempter));
        
        if (!$user) {
            return response()->json([
                'alertType' => 'therapist-not-found-error',
                'message' => "We can't find a user with that email address."
            ], 422);
        }

        // if account is already verified
        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'alertType' => 'already-verified-account',
                'meassgae' => 'Your account is already verified'
            ], 422);
        }

        // send verification email
        try {
            
            $token = rand(100000, 999999);    // generate a 6 digit token
            
            if($request->cookie('OTP_COOKIE')){
               cookie()->forget('OTP_COOKIE');
            }

            $otpCookie = cookie('OTP_COOKIE', Crypt::encrypt($token), 60);  // set the token in a cookie
            
            
            $user->sendEmailVerificationMail($token);       // send notification with new token
            
            return response()->json([           
                'alertType' => 'otp-resend',
                'message' => 'A new OTP has been sent successfully'
            ], 200)->withCookie($otpCookie);

        } catch (Throwable $th) {
            return response()->json([
                'alertType' => 'internal-server-error',
                'message' => 'Something went wrong ! please try again'
            ], 422);
        }

        // send success email
        return response()->json([
            'alertType' => 'success',
            'message' => 'Verification mail has been resent'
        ], 200);
    }

    // returns therapist auth guard
    private function guard()
    {
        return auth()->guard('therapist');
    }
}
