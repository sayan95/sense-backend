<?php

namespace App\Http\Controllers\Web\Admin\Auth;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Interfaces\IAdminService;
use App\Http\Resources\Admin\AdminResource;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    private $adminService;

    public function __construct(IAdminService $adminService)
    {
        $this->adminService = $adminService;
        $this->middleware('auth:admin')->except('login');
        $this->middleware('csrf:admin')->except('login');
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
    public function attemptLogin(Request $request){
        // attempt to issuse a token based on the valid login credentials
        $credentials = $request->only('email','password');
        if($request->has('remember_me') && $request->remember_me === true)
            $token = $this->guard()->claims(['csrf-token' => Str::random(32)])->setTTL(20160)->attempt($credentials);
        else
            $token = $this->guard()->claims(['csrf-token' => Str::random(32)])->attempt($credentials);

        if( ! $token ){
            return false;
        }

        // set the user's token
        $this->guard()->setToken($token);

        return true;
    }

    // return login success response
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

        // update last _login time
        $this->adminService->updateLastLogin($this->guard()->user()->id);

        // return success message with token
        return response()->json([
            'alertType' => 'success',
            'message' => 'You are Logged in successfully',
            'token'=>$token,
            'token_type' => 'bearer',
            'expires_in' => $expiration,
            'user' => new AdminResource($this->guard()->user())
        ], 200)->withCookie($jwtCookie)->withCookie($csrfCookie);
    }

    // return login failed response
    protected function sendFailedLoginResponse()
    {   
        return response()->json([
            'alert-type' => 'credential-error',
            'error'=>'Invalid email or password'
        ], 422);
    }

    // returns authentication guard
    protected function guard(){
        return Auth::guard('admin');
    }

    // returns authenticated user
    public function me(){
        return new AdminResource($this->guard()->user());
    }

    // logout user
    public function logout(Request $request){
        $this->guard()->logout(true);
        $jwtCookie = cookie()->forget('jwt');
        $csrfCookie = cookie()->forget('csrf');
        return response()->json([
            'message'=> 'Successfully logged out'
        ], 200)->withCookie($jwtCookie)->withCookie($csrfCookie);
    }
}
