<?php

namespace App\Model\Admin;

use App\Model\Admin\Admin;
use App\Model\BaseModel as Eloquent;

class Role extends Eloquent
{

    // fillables
    protected $fillable = ['role_name'];

    // dates 
    protected $dates = ['created_at', 'updated_at'];

    /**
     * Moloqeunt relationships
     */
    public function users(){
        return $this->hasMany(Admin::class);
    }
    public function permissions(){
        return $this->belongsToMany(Permission::class);
    }
}
