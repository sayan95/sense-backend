<?php

namespace App\Http\Controllers\Web\user\Therapist\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Services\Interfaces\ITherapistService;

class RegisterController extends Controller
{
    private $therapistServivce;

    // constructor
    public function __construct(ITherapistService $therapistServivce)
    {
        $this->therapistServivce = $therapistServivce;
    }

    //  register therapist to system
    public function register(Request $request){
        // validate request
        $this->validator($request->all())->validate();

        // create the user
        $newUser =  $this->therapistServivce->addTherapist([
            'email' => $request->email,
            'password' => bcrypt('Welcome@1'),
            'profile_created' => false,
            'is_active' => false
        ]);
        
        // sending email verification link
        $newUser->sendEmailVerificationMail();
        
        // return response
        return response()->json([
            'alertType' => 'success',
            'message' => 'An activation link has been sent to your email. Please check your email'
        ], 200);
    }   
    
    // request validator
    public function validator(array $data){
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:50','unique:therapists,email'],
        ]);   
    }
}
