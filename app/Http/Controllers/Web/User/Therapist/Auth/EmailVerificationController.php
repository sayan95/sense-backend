<?php

namespace App\Http\Controllers\Web\User\Therapist\Auth;

use Throwable;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Model\User\Therapist\Therapist;
use App\Services\Interfaces\ITherapistService;
use App\Http\Resources\Therapist\TherapistResource;
use App\Events\User\Therapist\TherapistRegisterdEvent;
use App\Events\User\Therapist\TherapistDeRegisterEvent;

class EmailVerificationController extends Controller
{
    private $therapistService;
    
    /**
     *  constructor
     */
    public function __construct(ITherapistService $therapistService)
    {
        $this->therapistService = $therapistService;
    }

    /**
     * verifying account activation request
     */
    public function verify(Request $request)
    {
        // get the entered otp
        $otp_from_client = $request->otp;
        // get the otp from cookie                     
        $otp_from_cookie = $request->Cookie('OTP_COOKIE')      
                            ?(string)Crypt::decrypt($request->cookie('OTP_COOKIE')) 
                            : '';

        //  get the attempted user
        if($request->cookie('attempter')){
            cookie()->forget('attempter');
        }
        $user_from_cookie = $request->cookie('attempter');
        
         
        // return response for invalid attemter
        if(!$user_from_cookie) {
            return response()->json([
                'alertType' => 'invalid-attempter', 
                'message' => 'current session is over. Try to login again' 
            ], 403);
        }
         
         // send invalid response if otp is not matched
        if($otp_from_client !== $otp_from_cookie ){        
            // if cookie removed or invalidated
            if($otp_from_cookie === ''){                   
                return response()->json([
                    'alertType' => 'otp-timeout',
                    'message' => 'Your current session is over. Click the resend link for a new OTP'
                ], 422);
            }
            // if otp mismatched
            return response()->json([                       
                'alertType' => 'otp-mismatch',
                'message' => 'Invalid OTP entered'
            ], 422);
        }
        
        // find the therapist
        $user = $this->therapistService->findTherapistBySpecificField('email', Crypt::decrypt($user_from_cookie), []);


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
            event(new TherapistRegisterdEvent($user)); //*********************** */
            
            // login user
            $token = $this->attemptUserLogin($user);

            // send verification success response
            return $this->getVerificationSuccessResponse($user, $token);
        }catch(Throwable $exception){
            // log the exception
            Log::channel('applicationLog')
                ->critical('Therapist email verification process failed. #Origin: email-verification-controller. # AffectedModel: Therapist # ErrorMessage:'. $exception->getMessage());
            
            // remove the added therapist account
            $this->therapistService->deleteTherapistAccountById($user->id);

            // return invalid response
            return response()->json([
                'alertType' => 'email-verification-failed',
                'message' => 'Something went wrong ! 
                                Email verification failed. 
                                Please try to re register yourself after some times or contact the support team'
            ], 500);
        }
    
    }


    /**
     *  attempt user login
     */
    private function attemptUserLogin($user){
        $token = $this->guard()->login($user);                                       // creates an new auth token
        $this->guard()->setToken($token);                                           // assign the token to the user
        $this->therapistService->updateTherapistDetails($this->guard()->id(),[      // update login timestamp
        'logged_in_at' => Carbon::now()
        ]);

        return $token;
    }

    /**
     *  Send verfication success response
     */
    private function getVerificationSuccessResponse($user, $token){
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
            'user' => new TherapistResource($user),
            'sessionTimeOut' => $expiration
        ], 200)->withCookie($jwtCookie)
                ->withCookie($otpCookie)
                ->withCookie($attempterCookie);
    } 

    /**
     *  Send verification failure response 
     */
    private function getVerificationFailureResponse(){
        return response()->json([
            'alertType' => 'internal-server-error',
            'message' => 'Something went wrong ! Please try again later'
        ], 500);
    }

    /**
     * returns therapist auth guard
     */
    private function guard() { return auth()->guard('therapist'); }
}
