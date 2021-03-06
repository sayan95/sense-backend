<?php

namespace App\Model\User\Therapist;

use Throwable;
use App\Model\BaseModel as Eloquent;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use App\Model\User\Therapist\TherapistProfile;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Notifications\User\Therapist\VerifyEmail;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class Therapist extends Eloquent implements JWTSubject, Authenticatable 
{
    use AuthenticatableTrait;
    use Notifiable;
    
    // fillable properties
    protected $fillable = ['id', 'username','email' , 'password', 'email_verified_at', 'is_active', 'profile_created', 'logged_in_at'];
 
    // date fields
    protected $dates = ['created_at', 'updated_at', 'email_verified_at', 'logged_in_at'];

    // moloquent relationships
    public function profile(){
        return $this->hasOne(TherapistProfile::class);
    }
    

    // jwt specific methods
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    // helpers
    // checks if the user has a verified email
    public function hasVerifiedEmail(){
        return $this->is_active;
    }

    // sends verification link
    public function sendEmailVerificationMail($token){
        $this->notify(new VerifyEmail($token));
    }
}
