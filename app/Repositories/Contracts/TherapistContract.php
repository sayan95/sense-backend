<?php

namespace App\Repositories\Contracts;

use App\Repositories\Contracts\BaseContract;

interface TherapistContract extends BaseContract{
    public function createProfile($email, array $data);
}