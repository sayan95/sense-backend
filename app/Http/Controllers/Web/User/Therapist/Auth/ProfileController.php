<?php

namespace App\Http\Controllers\Web\User\Therapist\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Therapist\TherapistResource;
use App\Services\Interfaces\ITherapistService;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ProfileController extends Controller
{
    private $therapistService;

    // attaching middlewares to the controller
    public function __construct(ITherapistService $therapistService){
        $this->therapistService = $therapistService;
        $this->middleware('auth:therapist');
        $this->middleware('csrf:therapist');
    }

    // creates therapist profile
    public function createProfile(Request $request, $email){
        
        // check for the valid request
        $this->validator($request->all())->validate();

        // update username field
        $therapist = $this->therapistService->findTherapistBySpecificField('email', $email, []);
        $this->therapistService->updateTherapistDetails($therapist->id,[
            'username' => $request->username,
            'profile_created' => true
        ]);

        // add data to record
        try{
            $this->therapistService->addTherpistProfile($email, $request->all());
            return response()->json([
                'user' => new TherapistResource($this->therapistService->findTherapistBySpecificField('email', $email, ['profile'])),
                'alertType' => 'profile-created',
                'message' => 'Thank you for joining us. We will catch you soon :)'
            ], 201);
        }catch(Throwable $e){
            return response()->json([
                'alertType' => 'profile-created-fail',
                'message' => 'Profile creation process failed! Please try after some time'
            ], 201);
        }   
    }

    // validate requests
    private function validator($data){
        return Validator::make($data, [
            'username' => ['required', 'max:50', 'unique:therapists'],
            'firstname' => ['required', 'max:50'],
            'lastname' => ['required', 'max:50'],
            'phone' => ['required', 'regex:/^[0-9]+$/', 'max:10', 'min:10', 'unique:therapist_profiles'],
            'gender' => ['required'],
            'language_proficiency' => ['required'],
            'education' => ['required'],
            'therapist_profile' => ['required'],
            'experties' => ['required'],
            'spectrum_specialization' => ['required'],
            'age_group' => ['required']
        ]);
    }
}
