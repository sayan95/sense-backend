<?php

namespace App\Repositories\DAL;

use App\Model\Admin\Admin;
use App\Repositories\Contracts\AdminContract;
use Carbon\Carbon;

class AdminRepository extends BaseRepository implements AdminContract{
    //  returns the associate model class
    public function model(){
        return Admin::class;
    }

    // updates admin's last login date and time
    public function updateLastLogin($user_id)
    {   
        return $this->update($user_id, [
            'last_login' => Carbon::now()
        ]);
    }
}