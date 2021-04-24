<?php

namespace App\Http\Controllers\Web\User\Therapist\Auth;

use Throwable;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Model\User\Therapist\Therapist;
use App\Services\Interfaces\ITherapistService;
use App\Events\User\Therapist\TherapistRegisterdEvent;

class EmailVerificationController extends Controller
{
    private $therapistService;
    public function __construct(ITherapistService $therapistService)
    {
        $this->therapistService = $therapistService;
        $this->middleware('throttle:6,1')->only('verify');
    }

    // verifying account activation request
    public function verify(Request $request, $email)
    {
        // get the entered otp
        $otp_from_client = $request->otp;
        $otp_from_cookie = $request->cookie('OTP_COOKIE');

        // send invalid response if otp is not matched
        if($otp_from_client !== $otp_from_cookie){
            return response()->json([
                'alertType' => 'otp-mismatch',
                'message' => 'Invalid OTP entered'
            ], 422);
        }

        // find the therapist
        $user = $this->therapistService->findTherapistBySpecificField('email', $email);

        // if the user id is invalid
        if ($user == null) {
            return response()->json([
                'alertType' => 'verification-link-error',
                'message' => "Invalid verification link"
            ], 422);
        }

        // check if the user has already verified account
        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'alertType' => 'already-verified-account',
                'message' => 'Your account is already verified'
            ], 422);
        }
        
        try{
            // Fire event of registering therapist to sense
            event(new TherapistRegisterdEvent($user));
            
            // login user
            $token = $this->guard()->claims(['csrf-token' => Str::random(32)])->login($user);
            $this->guard()->setToken($token);

            // set to httponly cookie
            $jwtCookie = cookie('jwt', $token, 60);
            $csrfCookie = cookie('csrf', $this->guard()->payload()->get('csrf-token'), 60);

            // remove otp cookie
            $otpCookie = cookie()->forget('OTP_COOKIE');

            //extract the token's expiary date
            $expiration = $this->guard()->getPayload()->get('exp');

            // send the verification success message 
            return response()->json([
                'alertType' => 'success',
                'message' => 'Your account is verified successfully',
                'user' => $user->email
            ], 200)->withCookie($jwtCookie)->withCookie($csrfCookie)->withCookie($otpCookie);
        }
        catch(Throwable $exception){
            return response()->json([
                'alertType' => 'internal-server-error',
                'message' => 'Something went wrong ! Please try again later'
            ], 500);
        }
    }

    // resend verification link
    public function resendLink(Request $request)
    {
        // if user not found
        $user = $this->therapistService->findTherapistBySpecificField('email', $request->email);
        
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
            $otpCookie = cookie('OTP_COOKIE', $token, 60);  // set the token in a cookie
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
