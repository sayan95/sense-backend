<?php

namespace App\Repositories\Contracts;

interface AdminContract extends BaseContract{
    public function updateLastLogin($user_id);
}