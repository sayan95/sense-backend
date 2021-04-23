<?php

namespace App\Http\Controllers\Web\User\Therapist\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Therapist\TherapistResource;
use App\Services\Interfaces\ITherapistService;

class MeController extends Controller
{
    private $therapistService;

    // attaching middlewares to the controller
    public function __construct(ITherapistService $therapistService)
    {
        $this->therapistService = $therapistService;
        $this->middleware('auth:therapist');
        $this->middleware('csrf:therapist');
    }

    // return the authenticated therapist profile
    public function me()
    {
        return response()->json([
            'alertType' => 'user-authenticated',
            'user' => new TherapistResource(
                $this->therapistService->findTherapistById($this->guard()->id())
            )
        ], 200);
    }

    // returns the authenticated therapist guard
    private function guard()
    {
        return auth()->guard('therapist');
    }
}
