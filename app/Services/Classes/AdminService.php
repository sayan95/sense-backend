<?php

namespace App\Services\Classes;

use App\Repositories\Contracts\AdminContract;
use App\Services\Interfaces\IAdminService;

class AdminService implements IAdminService{
    private $admin;

    public function __construct(AdminContract $admin){
        $this->admin = $admin;
    }   

    // updates admin's last login date and time
    public function updateLastLogin($user_id)
    {
        return $this->admin->updateLastLogin($user_id);
    }
}