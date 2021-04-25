<?php

namespace App\Http\Controllers\Web\User\Therapist\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __construct(){
        $this->middleware('auth:therapist');
        $this->middleware('csrf:therapist');
    }

    // logout therapist
    public function logout(Request $request){
        $this->guard()->logout(true);
        $jwtCookie = cookie()->forget('jwt');
        return response()->json([
            'alertType' => 'user-logout',
            'message'=> 'You are logged out successfully'
        ], 200)->withCookie($jwtCookie);
    }

    private function guard(){
        return auth()->guard('therapist');
    }
}
