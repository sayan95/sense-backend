<?php

namespace App\Model\Admin;

use App\Model\Admin\Role;
use App\Model\BaseModel as Eloquent;

class Permission extends Eloquent
{

    // fillables
    protected $fillable = ['permission_name'];

    // dates 
    protected $dates = ['created_at', 'updated_at'];

    /**
     * Moloqeunt relationships
     */
    public function roles(){
        return $this->belongsToMany(Role::class);
    }
}
