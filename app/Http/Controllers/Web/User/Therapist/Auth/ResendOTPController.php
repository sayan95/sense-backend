<?php

namespace App\Http\Controllers\Web\User\Therapist\Auth;

use Throwable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Services\Interfaces\ITherapistService;

class ResendOTPController extends Controller
{
    private $therapistService;

    /**
     *  Constructor
     */
    public function __construct(ITherapistService $therapistService)
    {
        $this->therapistService = $therapistService;
    }

    /**
     *  resend verification link
     */
    public function resendLink(Request $request)
    {
        // get the attempter cookie
        $attempter = $request->cookie('attempter');

        // return response for invalid attempter
        if(! $attempter){
            return response()->json([
                'alertType' => 'invalid-attempter',
                'message' => 'current session is over. Try to login again'
            ], 403);
        }

        // Get the user from the database
        $user = $this->therapistService->findTherapistBySpecificField('email', Crypt::decrypt($attempter), []);

        // return response if user not avaliable
        if (!$user) {
            return response()->json([
                'alertType' => 'therapist-not-found-error',
                'message' => "We can't find a user with that email address."
            ], 422);
        }

        // return response if account is already verified
        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'alertType' => 'already-verified-account',
                'meassgae' => 'Your account is already verified'
            ], 422);
        }

        // send verification email
        try {
            // generate a 6 digit token
            $token = rand(100000, 999999);    
            
            // delete if there is a previous cookie
            if($request->cookie('OTP_COOKIE')) { cookie()->forget('OTP_COOKIE'); }

            // set the token in a cookie
            $otpCookie = cookie('OTP_COOKIE', Crypt::encrypt($token), 60);  
            
            // send notification with new token
            $user->sendEmailVerificationMail($token);       
            
            // return response for successfull otp resend
            return response()->json([           
                'alertType' => 'otp-resend',
                'message' => 'A new OTP has been sent successfully'
            ], 200)->withCookie($otpCookie);

        } catch (Throwable $e) {
            // return response if the otp send failed
            return response()->json([
                'alertType' => 'internal-server-error',
                'message' => 'Something went wrong ! please try again'
            ], 422);
        }
    }


}
