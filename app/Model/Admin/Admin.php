<?php

namespace App\Model\Admin;

use App\Model\Admin\Role;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use App\Model\BaseModel as Eloquent;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable;

class Admin extends Eloquent implements JWTSubject, Authenticatable
{
    use AuthenticatableTrait;
    use Notifiable;

    
    // fillables
    protected $fillable = ['username', 'email', 'role_id', 'last_login'];

    // dates 
    protected $dates = ['created_at', 'updated_at', 'last_login'];

    /**
     *   Moloquent relations
     */
    public function role(){
        return $this->belongsTo(Role::class);
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
}
